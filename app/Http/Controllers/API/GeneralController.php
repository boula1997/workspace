<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\DBCredential;
use Illuminate\Support\Facades\File;

use App\Models\Admin;
use App\Services\AuditLogger;


use Carbon\Carbon;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Database\QueryException;

class GeneralController extends Controller
{
    /** Driver of the current 'dynamic' connection (mysql / pgsql). */
    private string $driver = 'mysql';

    /** Value to bind as table_schema for information_schema lookups. */
    private string $schema = '';

    /** Cached table list of the current 'dynamic' connection. */
    private ?array $tablesCache = null;

    /**
     * Points the 'dynamic' connection at $dbname.
     *
     * Credentials come from db_credentials. A database without stored
     * credentials can only be opened when it is the app's own database (using
     * the app's own connection config) - anything else is a 404, instead of
     * silently falling back to the main workspace database.
     */
    private function connectDynamic(string $dbname): void
    {
        $credential = DBCredential::where('db_name', $dbname)->first();

        if ($credential) {
            $driver = $credential->db_driver ?: 'mysql';
            $config = buildDynamicConnectionConfig(
                $driver,
                $credential->db_host ?: 'localhost',
                $credential->db_name,
                $credential->db_username ?? '',
                $credential->db_password ?? ''
            );
        } else {
            $default = config('database.connections.' . config('database.default'));
            abort_unless($default && ($default['database'] ?? null) === $dbname, 404, "Unknown database {$dbname}");
            $driver = $default['driver'];
            $config = $default;
        }

        config(['database.connections.dynamic' => $config]);
        DB::purge('dynamic');
        DB::reconnect('dynamic');

        $this->driver = $driver;
        $this->schema = dynamicSchemaName($driver, $config['database']);
        $this->tablesCache = null;
    }

    /** All table names of the current 'dynamic' connection. */
    private function tables(): array
    {
        return $this->tablesCache ??= collect(DB::connection('dynamic')->select(
            'SELECT DISTINCT table_name AS "TABLE_NAME" FROM information_schema.columns WHERE table_schema = ? ORDER BY table_name',
            [$this->schema]
        ))->pluck('TABLE_NAME')->all();
    }

    private function hasTable(string $table): bool
    {
        return in_array($table, $this->tables(), true);
    }

    /**
     * Column metadata of $table. Rejects anything that is not a real table of
     * the connected database, so table names from the URL never reach SQL
     * unchecked.
     */
    private function tableColumns(string $table): array
    {
        abort_unless(preg_match('/^[A-Za-z0-9_]+$/', $table), 400, 'Invalid table name');

        $columns = dynamicTableColumns($this->driver, $this->schema, $table);
        abort_if(empty($columns), 404, "Table {$table} not found");

        return $columns;
    }

    /** mapping rows (FK column => table/title override), empty when the DB has no mapping table. */
    private function mappingRows()
    {
        if (!$this->hasTable('mapping')) {
            return collect();
        }

        return DB::connection('dynamic')->table('mapping')
            ->select('attribute_id', 'table_name', 'title_name')
            ->whereNotNull('attribute_id')
            ->whereNotNull('table_name')
            ->whereNotNull('title_name')
            ->get()
            ->keyBy('attribute_id');
    }

    /** Quotes "a.b" style identifiers for raw SQL. */
    private function q(string ...$parts): string
    {
        return implode('.', array_map(fn($p) => quoteDynamicIdentifier($this->driver, $p), $parts));
    }

    /** Foreign key column of a *_translations table pointing back to $table. */
    private function translationForeignKey(string $table, array $translationCols): string
    {
        $expected = Str::snake(Str::singular($table)) . '_id';
        if (in_array($expected, $translationCols, true)) {
            return $expected;
        }

        $candidates = collect($translationCols)->filter(fn($col) => Str::endsWith($col, '_id') && $col !== 'id');

        return $candidates->first(fn($col) => Str::startsWith($col, Str::singular($table)))
            ?? $candidates->first()
            ?? $expected;
    }

    private function fileableType(string $table): string
    {
        return 'App\\Models\\' . Str::studly(Str::singular($table));
    }


    // Finance tables of the main database are written here by table name, which skips
    // model events, so their changes are logged explicitly (see AuditLogger).
    private function isAuditedTable(string $table): bool
    {
        return AuditLogger::isAuditedTable($table)
            && DB::connection('dynamic')->getDatabaseName() === DB::connection()->getDatabaseName();
    }

    private function dynamicRow(string $table, $id): ?array
    {
        $row = DB::connection('dynamic')->table($table)->where('id', $id)->first();
        return $row ? (array) $row : null;
    }

    public function storeUpdate(Request $request, $dbname, $table, $itemId = null)
    {
        if ($table === 'audit_logs') {
            return response()->json(['success' => false, 'message' => 'Audit logs are read-only.'], 403);
        }

        $this->connectDynamic($dbname);
        $columnNames = collect($this->tableColumns($table))->pluck('COLUMN_NAME')->all();
        $conn = DB::connection('dynamic');
        $audited = $this->isAuditedTable($table);

        $isCreating = !$itemId || $itemId === 'undefined' || $itemId === 'null';

        if (!$isCreating) {
            abort_unless($conn->table($table)->where('id', $itemId)->exists(), 404, 'Record not found');
        }

        $hasFiles = $this->hasTable('files');
        $fileableType = $this->fileableType($table);
        $image = null;
        $images = [];
        $data = [];

        try {
            // Step 1: Collect column values (id and the virtual image/images fields are never written directly)
            foreach ($columnNames as $column) {
                if (in_array($column, ['id', 'image', 'images'], true)) continue;
                if (!$request->has($column)) continue;

                $value = $request->input($column);

                if ($column === 'password') {
                    if (filled($value)) {
                        $data[$column] = Hash::make($value);
                    }
                    continue;
                }

                $data[$column] = $value;
            }

            $now = now();

            $conn->beginTransaction();

            $before = $audited && !$isCreating ? $this->dynamicRow($table, $itemId) : null;

            if (!$isCreating) {
                if (in_array('updated_at', $columnNames, true)) {
                    $data['updated_at'] = $now;
                }

                if (!empty($data)) {
                    $conn->table($table)->where('id', $itemId)->update($data);
                }
            } else {
                if (in_array('created_at', $columnNames, true)) {
                    $data['created_at'] = $now;
                }
                if (in_array('updated_at', $columnNames, true)) {
                    $data['updated_at'] = $now;
                }

                $itemId = $conn->table($table)->insertGetId($data);
            }

            // Logged inside the transaction: if the entry cannot be saved, the change is rolled back
            if ($audited) {
                AuditLogger::recordRow($table, $itemId, $before, $this->dynamicRow($table, $itemId));
            }

            // Step 2: Translations (only real columns of the translation table are written)
            $translationTable = Str::singular($table) . '_translations';

            if ($this->hasTable($translationTable)) {
                $translationCols = Schema::connection('dynamic')->getColumnListing($translationTable);
                $foreignKey = $this->translationForeignKey($table, $translationCols);

                foreach (['en', 'ar'] as $locale) {
                    if (!is_array($request->input($locale))) continue;

                    $fields = collect($request->input($locale))
                        ->only(array_diff($translationCols, ['id', 'locale', $foreignKey, 'created_at', 'updated_at', 'deleted_at']))
                        ->all();

                    $fields[$foreignKey] = $itemId;
                    $fields['locale'] = $locale;

                    if (in_array('isActive', $translationCols, true) && !isset($fields['isActive'])) {
                        $fields['isActive'] = 1;
                    }
                    if (in_array('updated_at', $translationCols, true)) {
                        $fields['updated_at'] = $now;
                    }

                    $existing = $conn->table($translationTable)
                        ->where($foreignKey, $itemId)
                        ->where('locale', $locale)
                        ->exists();

                    if ($existing) {
                        $conn->table($translationTable)
                            ->where($foreignKey, $itemId)
                            ->where('locale', $locale)
                            ->update($fields);
                    } else {
                        if (in_array('created_at', $translationCols, true)) {
                            $fields['created_at'] = $now;
                        }
                        $conn->table($translationTable)->insert($fields);
                    }
                }
            }

            $conn->commit();

            // Step 3: Handle image & images via files table
            if ($hasFiles && $request->hasFile('image')) {
                $currentImage = $conn->table('files')
                    ->where('fileable_type', $fileableType)
                    ->where('fileable_id', $itemId)
                    ->where('isMultiply', 0)
                    ->first();

                if ($currentImage) {
                    if (file_exists($currentImage->url)) {
                        File::delete($currentImage->url);
                    }
                    $conn->table('files')->where('id', $currentImage->id)->delete();
                }

                $file = $request->file('image');
                $path = $file->store('images');
                $file->move('images', $path);

                $conn->table('files')->insert([
                    'url' => $path,
                    'fileable_type' => $fileableType,
                    'fileable_id' => $itemId,
                    'isMultiply' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($hasFiles && $request->hasFile('images')) {
                $currentImages = $conn->table('files')
                    ->where('fileable_type', $fileableType)
                    ->where('fileable_id', $itemId)
                    ->where('isMultiply', 1)
                    ->get();

                foreach ($currentImages as $currentImage) {
                    if (file_exists($currentImage->url)) {
                        File::delete($currentImage->url);
                    }
                    $conn->table('files')->where('id', $currentImage->id)->delete();
                }

                foreach ($request->file('images') as $file) {
                    $path = $file->store('images');
                    $file->move('images', $path);

                    $conn->table('files')->insert([
                        'url' => $path,
                        'fileable_type' => $fileableType,
                        'fileable_id' => $itemId,
                        'isMultiply' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Step 4: Current files for the response
            if ($hasFiles) {
                $image = $conn->table('files')
                    ->where('fileable_type', $fileableType)
                    ->where('fileable_id', $itemId)
                    ->where('isMultiply', 0)
                    ->value('url');

                $images = $conn->table('files')
                    ->where('fileable_type', $fileableType)
                    ->where('fileable_id', $itemId)
                    ->where('isMultiply', 1)
                    ->pluck('url')
                    ->map(fn($url) => asset('storage/' . $url))
                    ->toArray();
            }
        } catch (QueryException $e) {
            if ($conn->transactionLevel() > 0) $conn->rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Database error',
                'error'   => $e->getMessage(),
            ], 500);
        } catch (Throwable $e) {
            if ($conn->transactionLevel() > 0) $conn->rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'error'   => $e->getMessage(),
            ], 500);
        }

        // 👇 Handle task creation/update for deals
        if ($table == "deals") {
            $project = Project::find($request->project_id);
            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found',
                ], 404);
            }

            $deal = Deal::find($itemId);
            if (!$deal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Deal not found',
                ], 404);
            }

            if ($isCreating) {
                Task::create([
                    'title'      => "Get {$request->cost} deal - " . now()->format('Y-m-d H:i:s'),
                    'project_id' => $project->id,
                    'date'       => Carbon::now()->addDay()->toDateString(),
                    'isActive'   => 1,
                    'status'     => 0,
                    'counter'    => 20,
                    'level'      => '0',
                    'employees'  => json_encode([1]),
                ]);
            } else {
                Task::where('project_id', $project->id)
                    ->where('title', 'LIKE', "Get%deal%")
                    ->update([
                        'title' => "Get {$request->cost} deal" . now()->format('Y-m-d H:i:s'),
                        'date'  => Carbon::now()->addDay()->toDateString(),
                    ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $isCreating ? 'Record inserted successfully.' : 'Record updated successfully.',
            'data' => $data,
            'id' => $itemId,
            'image' => $image ? asset('storage/' . $image) : null,
            'images' => $images,
        ]);
    }


    public function showEditCreate($dbname, $table, $itemId = null)
    {
        $this->connectDynamic($dbname);
        $conn = DB::connection('dynamic');

        // Step 1: Base table columns
        $columns = collect($this->tableColumns($table))
            ->map(fn($col) => [
                'COLUMN_NAME' => $col->COLUMN_NAME,
                'DATA_TYPE' => $col->DATA_TYPE,
                'IS_NULLABLE' => $col->IS_NULLABLE === 'YES',
                'HAS_DEFAULT' => $col->COLUMN_DEFAULT !== null,
                'HIDDEN' => strtolower(trim($col->COLUMN_COMMENT ?? '')) === 'hide',
            ])
            ->values()
            ->toArray();

        // Step 2: Virtual image fields (stored in the files table)
        $hasFiles = $this->hasTable('files');
        if ($hasFiles) {
            $columns[] = [
                "COLUMN_NAME" => "image",
                "DATA_TYPE" => "Image",
                "IS_NULLABLE" => true,
            ];
            $columns[] = [
                "COLUMN_NAME" => "images",
                "DATA_TYPE" => "Multimages",
                "IS_NULLABLE" => true,
            ];
        }

        // Step 3: Foreign keys declared in the database
        $fkLookup = [];
        foreach (dynamicForeignKeys($this->driver, $this->schema, $table) as $fk) {
            $fkLookup[$fk->COLUMN_NAME] = [
                'referenced_table' => $fk->REFERENCED_TABLE_NAME,
                'referenced_column' => $fk->REFERENCED_COLUMN_NAME,
            ];
        }

        // Step 4: Related dropdown options
        $relatedOptions = [];
        $mappingRows = $this->mappingRows();

        foreach ($columns as $col) {
            $colName = $col['COLUMN_NAME'];

            if (isset($fkLookup[$colName])) {
                $referencedTable = $fkLookup[$colName]['referenced_table'];
                $referencedColumn = $fkLookup[$colName]['referenced_column'];

                if ($mappingRows->has($colName)) {
                    $map = $mappingRows->get($colName);

                    if ($this->hasTable($map->table_name)) {
                        $relatedOptions[$colName] = $conn->table($map->table_name)
                            ->select($referencedColumn . ' as id', DB::raw($this->q($map->title_name) . " as label"))
                            ->get();
                        continue;
                    }
                }

                if ($this->hasTable($referencedTable)) {
                    $mainColumns = Schema::connection('dynamic')->getColumnListing($referencedTable);

                    $labelColumn = collect(['title', 'name', 'username', 'email', 'full_name'])
                        ->first(fn($field) => in_array($field, $mainColumns));

                    $relatedOptions[$colName] = $conn->table($referencedTable)
                        ->select(
                            $referencedColumn . ' as id',
                            DB::raw($labelColumn
                                ? $this->q($labelColumn) . " as label"
                                : "CONCAT('ID: ', " . $this->q($referencedColumn) . ") as label")
                        )
                        ->get();
                }

                continue;
            }

            // Columns ending with _id but without a foreign key constraint
            if (Str::endsWith($colName, '_id')) {
                if ($mappingRows->has($colName)) {
                    $map = $mappingRows->get($colName);

                    if (!$this->hasTable($map->table_name)) {
                        continue;
                    }

                    $relatedOptions[$colName] = $conn->table($map->table_name)
                        ->select('id', DB::raw($this->q($map->title_name) . " as label"))
                        ->get();
                    continue;
                }

                $baseTable = Str::plural(Str::beforeLast($colName, '_id'));
                $singular = Str::singular($baseTable);
                $translationTable = "{$singular}_translations";

                if (!$this->hasTable($baseTable)) {
                    continue;
                }

                $mainColumns = Schema::connection('dynamic')->getColumnListing($baseTable);
                $labelColumn = collect(['title', 'name'])->first(fn($field) => in_array($field, $mainColumns));

                if ($labelColumn) {
                    $relatedData = $conn->table($baseTable)
                        ->select('id', DB::raw($this->q($labelColumn) . " as label"))
                        ->get();
                } elseif ($this->hasTable($translationTable)) {
                    $translationColumns = Schema::connection('dynamic')->getColumnListing($translationTable);
                    $translationLabel = collect(['title', 'name'])->first(fn($field) => in_array($field, $translationColumns));

                    if ($translationLabel) {
                        $fk = $this->translationForeignKey($baseTable, $translationColumns);
                        $relatedData = $conn->table($baseTable)
                            ->leftJoin($translationTable, function ($join) use ($translationTable, $fk, $baseTable) {
                                $join->on("{$translationTable}.{$fk}", '=', "{$baseTable}.id")
                                    ->where("{$translationTable}.locale", '=', 'en');
                            })
                            ->select("{$baseTable}.id", "{$translationTable}.{$translationLabel} as label")
                            ->get();
                    } else {
                        $relatedData = $conn->table($baseTable)->selectRaw("id, CONCAT('ID: ', id) as label")->get();
                    }
                } else {
                    $relatedData = $conn->table($baseTable)->selectRaw("id, CONCAT('ID: ', id) as label")->get();
                }

                $relatedOptions[$colName] = $relatedData;
            }
        }

        // Step 5: Translation columns - always added for create & edit
        $translationTable = Str::singular($table) . '_translations';
        $transColumns = [];
        $foreignKey = null;

        if ($this->hasTable($translationTable)) {
            $allTranslationCols = Schema::connection('dynamic')->getColumnListing($translationTable);
            $foreignKey = $this->translationForeignKey($table, $allTranslationCols);

            $transColumns = collect($allTranslationCols)
                ->reject(fn($col) => in_array($col, ['id', 'locale', $foreignKey, 'created_at', 'updated_at', 'deleted_at']))
                ->values()
                ->toArray();

            foreach (['en', 'ar'] as $locale) {
                foreach ($transColumns as $col) {
                    $columns[] = [
                        "COLUMN_NAME" => "{$locale}[$col]",
                        "DATA_TYPE" => "text",
                        "IS_NULLABLE" => true,
                    ];
                }
            }
        }

        // Step 6: No record requested -> columns and options only (create form / filter form)
        if (!$itemId || $itemId === "undefined" || !is_numeric($itemId)) {
            return response()->json([
                'success' => trans('general.sent_successfully'),
                'columns' => $columns,
                'related' => $relatedOptions,
                'data' => [],
            ]);
        }

        // Step 7: Record for show / edit
        $data = $conn->table($table)->where('id', $itemId)->first();

        if (!$data) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $data = (array) $data;

        foreach (['password', 'remember_token', 'api_token', 'access_token'] as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = '';
            }
        }

        if ($hasFiles) {
            $files = $conn->table('files')
                ->where('fileable_type', $this->fileableType($table))
                ->where('fileable_id', $itemId)
                ->get(['url', 'isMultiply']);

            $data['image'] = optional($files->firstWhere('isMultiply', 0))->url;
            $data['image'] = $data['image'] ? asset($data['image']) : settings()?->logo;
            $data['images'] = $files->where('isMultiply', 1)->pluck('url')->map(fn($url) => asset($url))->values()->toArray();
        }

        // Step 8: Translations of this record
        if ($foreignKey) {
            $translations = $conn->table($translationTable)->where($foreignKey, $itemId)->get();

            foreach ($translations as $translation) {
                foreach ($transColumns as $col) {
                    $data["{$translation->locale}[$col]"] = $translation->$col;
                }
            }
        }

        return response()->json([
            'success' => trans('general.sent_successfully'),
            'columns' => $columns,
            'related' => $relatedOptions,
            'data' => [$data],
        ]);
    }


    public function deleteItem($dbname, $table, $itemId)
    {
        if ($table === 'audit_logs') {
            return response()->json(['success' => false, 'message' => 'Audit logs are read-only.'], 403);
        }

        $this->connectDynamic($dbname);
        $this->tableColumns($table);
        $conn = DB::connection('dynamic');
        $audited = $this->isAuditedTable($table);

        try {
            $deleted = $conn->transaction(function () use ($conn, $table, $itemId, $audited) {
                $before = $audited ? $this->dynamicRow($table, $itemId) : null;

                // Translation rows first, so a translation FK without ON DELETE CASCADE can't block the delete
                $translationTable = Str::singular($table) . '_translations';
                if ($this->hasTable($translationTable)) {
                    $fk = $this->translationForeignKey($table, Schema::connection('dynamic')->getColumnListing($translationTable));
                    $conn->table($translationTable)->where($fk, $itemId)->delete();
                }

                $deleted = $conn->table($table)->where('id', $itemId)->delete();

                if ($audited && $deleted) {
                    AuditLogger::recordRow($table, $itemId, $before, null);
                }

                return $deleted;
            });
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'This record cannot be deleted because other records depend on it.',
                'error'   => $e->getMessage(),
            ], 409);
        }

        return response()->json([
            'success' => trans('general.sent_successfully'),
            'deleted' => $deleted,
            'data' => [],
        ]);
    }


    public function index($dbname, $table, $column = null, $equal = null)
    {
        $this->connectDynamic($dbname);
        $conn = DB::connection('dynamic');

        // Step 1: Base columns of the main table
        $baseColumns = collect($this->tableColumns($table))->map(fn($c) => (array) $c)->all();
        $baseNames = array_column($baseColumns, 'COLUMN_NAME');
        $typeOf = array_map('strtolower', array_column($baseColumns, 'DATA_TYPE', 'COLUMN_NAME'));
        $columns = $baseColumns;

        $locale = preg_match('/^[a-z]{2}$/', (string) request('locale')) ? request('locale') : 'en';
        $dataQuery = $conn->table($table)->select("$table.*");

        // Step 2: Translation of the main table. The locale goes in the JOIN
        // condition so records without a translation still appear.
        $translationTable = Str::singular($table) . '_translations';
        $hasMainTranslation = $this->hasTable($translationTable);
        $translatableCols = [];

        if ($hasMainTranslation) {
            $translationCols = Schema::connection('dynamic')->getColumnListing($translationTable);
            $foreignKey = $this->translationForeignKey($table, $translationCols);

            $dataQuery->leftJoin($translationTable, function ($join) use ($translationTable, $foreignKey, $table, $locale) {
                $join->on("$translationTable.$foreignKey", '=', "$table.id")
                    ->where("$translationTable.locale", '=', $locale);
            });

            foreach ($translationCols as $col) {
                if (!in_array($col, ['id', $foreignKey, 'locale', 'created_at', 'updated_at', 'deleted_at'])) {
                    $dataQuery->addSelect("$translationTable.$col as $col");
                    $columns[] = ['COLUMN_NAME' => $col, 'DATA_TYPE' => 'text'];
                    $translatableCols[] = $col;
                }
            }
        }

        // Step 3: Image column metadata
        $hasFiles = $this->hasTable('files') && in_array('id', $baseNames, true);
        if ($hasFiles) {
            $columns[] = ['COLUMN_NAME' => 'image', 'DATA_TYPE' => 'image'];
        }

        // Step 4: Show a label instead of the id for *_id columns. Each relation
        // gets its own alias so two FKs to the same table don't collide.
        $mappingRows = $this->mappingRows();
        $displayCandidates = ['title', 'name', 'full_name', 'label'];

        foreach ($baseNames as $colName) {
            if (!Str::endsWith($colName, '_id')) continue;

            $map = $mappingRows->get($colName);
            $relatedBase = $map->table_name ?? Str::plural(Str::beforeLast($colName, '_id'));
            if (!$this->hasTable($relatedBase)) continue;

            $wanted = $map->title_name ?? null;
            $relCols = Schema::connection('dynamic')->getColumnListing($relatedBase);
            $baseDisplayCol = $wanted
                ? (in_array($wanted, $relCols, true) ? $wanted : null)
                : collect($displayCandidates)->first(fn($d) => in_array($d, $relCols, true));

            $relatedTrans = Str::singular($relatedBase) . '_translations';
            $transDisplayCol = null;
            $transCols = [];
            if ($this->hasTable($relatedTrans)) {
                $transCols = Schema::connection('dynamic')->getColumnListing($relatedTrans);
                $transDisplayCol = $wanted
                    ? (in_array($wanted, $transCols, true) ? $wanted : null)
                    : collect($displayCandidates)->first(fn($d) => in_array($d, $transCols, true));
            }

            if (!$baseDisplayCol && !$transDisplayCol) continue;

            $relAlias = "rel_{$colName}";
            $dataQuery->leftJoin("$relatedBase as $relAlias", "$relAlias.id", '=', "$table.$colName");

            if ($transDisplayCol) {
                $transAlias = "reltr_{$colName}";
                $fkInRelTrans = $this->translationForeignKey($relatedBase, $transCols);

                $dataQuery->leftJoin("$relatedTrans as $transAlias", function ($join) use ($transAlias, $relAlias, $fkInRelTrans, $locale) {
                    $join->on("$transAlias.$fkInRelTrans", '=', "$relAlias.id")
                        ->where("$transAlias.locale", '=', $locale);
                });
            }

            if ($baseDisplayCol && $transDisplayCol) {
                $dataQuery->addSelect(DB::raw(
                    "COALESCE({$this->q($relAlias, $baseDisplayCol)}, {$this->q("reltr_{$colName}", $transDisplayCol)}) as {$this->q($colName)}"
                ));
            } elseif ($transDisplayCol) {
                $dataQuery->addSelect("reltr_{$colName}.$transDisplayCol as $colName");
            } else {
                $dataQuery->addSelect("$relAlias.$baseDisplayCol as $colName");
            }
        }

        // Step 5: Filters

        // Column/equal filter from the URL (used for sub-tables, e.g. order products of an order)
        if (!is_null($column) && !is_null($equal) && $column !== 'null' && $equal !== 'null') {
            abort_unless(in_array($column, $baseNames, true), 400, "Unknown column {$column}");
            $dataQuery->where("$table.$column", $equal);
        }

        // Query-string filters. Only real columns are filtered - unknown
        // parameters are ignored instead of producing an SQL error.
        $reserved = ['page', 'per_page', 'sort', 'direction', 'locale'];
        $booleanTypes = ['tinyint', 'boolean', 'bool', 'bit'];
        $dateTypes = ['date', 'datetime', 'timestamp', 'timestamp without time zone', 'timestamp with time zone'];

        foreach (request()->query() as $key => $value) {
            if (in_array($key, $reserved, true) || $value === null || $value === '') continue;

            if (is_array($value)) {
                if (in_array($key, ['en', 'ar'], true) && $hasMainTranslation) {
                    foreach ($value as $fld => $val) {
                        if ($val === null || $val === '' || is_array($val) || !in_array($fld, $translatableCols, true)) continue;
                        $dataQuery->where("$translationTable.$fld", 'like', "%$val%");
                    }
                }
                continue;
            }

            if (!in_array($key, $baseNames, true)) {
                if (in_array($key, $translatableCols, true)) {
                    $dataQuery->where("$translationTable.$key", 'like', "%$value%");
                }
                continue;
            }

            $dataType = $typeOf[$key] ?? '';

            if (in_array($dataType, $booleanTypes, true)) {
                // Exact match - "No" (0) must not turn into ">= 0"
                $dataQuery->where("$table.$key", $value);
            } elseif (is_numeric($value) && ($key === 'id' || Str::endsWith($key, '_id'))) {
                $dataQuery->where("$table.$key", $value);
            } elseif (in_array($dataType, $dateTypes, true) && strtotime($value)) {
                // Records from this date on
                $dataQuery->whereDate("$table.$key", '>=', date('Y-m-d', strtotime($value)));
            } elseif (is_numeric($value)) {
                $dataQuery->where("$table.$key", '>=', $value);
            } else {
                $dataQuery->where("$table.$key", 'like', "%$value%");
            }
        }

        // Step 6: Sorting & pagination
        $sort = in_array(request('sort'), $baseNames, true) ? request('sort') : null;
        $direction = strtolower((string) request('direction')) === 'asc' ? 'asc' : 'desc';

        if ($sort) {
            $dataQuery->orderBy("$table.$sort", $direction);
        } elseif (in_array('id', $baseNames, true)) {
            $dataQuery->orderBy("$table.id", 'desc');
        }

        $perPage = max(1, min(100, (int) request('per_page', 10)));
        $paginated = $dataQuery->paginate($perPage);

        // Step 7: Image URLs - one query for the whole page instead of one per row
        $rows = collect($paginated->items());

        if ($hasFiles) {
            $urls = $conn->table('files')
                ->where('fileable_type', $this->fileableType($table))
                ->where('isMultiply', 0)
                ->whereIn('fileable_id', $rows->pluck('id')->filter()->all())
                ->pluck('url', 'fileable_id');
            $logo = settings()?->logo;

            $rows = $rows->map(function ($item) use ($urls, $logo) {
                $row = (array) $item;
                $row['image'] = isset($urls[$row['id']]) ? asset($urls[$row['id']]) : $logo;
                return (object) $row;
            });
        }

        return response()->json([
            'success' => trans('general.sent_successfully'),
            'columns' => $columns,
            'data' => $rows->values()->all(),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
            // Lets the dashboard know this backend supports ?sort=&direction=&per_page=
            'sort' => [
                'column' => $sort,
                'direction' => $direction,
                'sortable' => array_values(array_diff($baseNames, ['image', 'images'])),
            ],
        ]);
    }


    public function tableNames($dbname)
    {
        $this->connectDynamic($dbname);

        $blockedTables = $this->hasTable('blocked_modules')
            ? DB::connection('dynamic')->table('blocked_modules')->pluck('table_name')
            : collect();

        $structuredTables = collect($this->tables())
            ->diff($blockedTables)
            ->reject(fn($table) => str_ends_with($table, '_translations') && $table !== 'mapping_translations')
            ->values()
            ->map(fn($table) => ['TABLE_NAME' => $table]);

        return response()->json([
            'success' => trans('general.sent_successfully'),
            'tables' => $structuredTables,
        ]);
    }


    public function allTableNames($dbname, $admin_id = null)
    {
        $this->connectDynamic($dbname);
        $conn = DB::connection('dynamic');

        $blockedModules = [];

        try {
            if (isset($admin_id)) {
                $permissions = $conn->table('admins')->where('id', $admin_id)->value('reactPermissions');
                $blockedTables = collect(json_decode($permissions, true) ?? []);
                $blockedModules = $conn->table('blocked_modules')->pluck('table_name');
            } else {
                $blockedTables = $conn->table('blocked_modules')->pluck('table_name');
            }
        } catch (\Exception $e) {
            $blockedTables = collect();
        }

        $structuredTables = collect($this->tables())
            ->reject(fn($table) => str_ends_with($table, '_translations') && $table !== 'mapping_translations')
            ->values()
            ->map(fn($table) => ['TABLE_NAME' => $table]);

        return response()->json([
            'success' => trans('general.sent_successfully'),
            'tables' => $structuredTables,
            'blockedTables' => $blockedTables,
            'blockedModules' => $blockedModules,
            'admins' => Admin::latest()->get(),
        ]);
    }

    public function blockTables(Request $request, $dbname)
    {
        $this->connectDynamic($dbname);
        $conn = DB::connection('dynamic');

        $tables = $request->tables ?? [];

        if ($request->has('admin_id')) {
            $conn->table('admins')
                ->where('id', $request->admin_id)
                ->update([
                    'reactPermissions' => json_encode($tables),
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Admin permissions updated successfully ✅',
                'permissions' => $tables,
            ]);
        }

        // Replace the blocked modules list atomically (TRUNCATE can't be rolled back)
        $conn->transaction(function () use ($conn, $tables) {
            $conn->table('blocked_modules')->delete();
            foreach ($tables as $table) {
                $conn->table('blocked_modules')->insert(['table_name' => $table]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Tables blocked successfully ✅',
            'blocked' => $tables,
        ]);
    }


    public function getAdmins($dbname)
    {
        try {
            $this->connectDynamic($dbname);

            $admins = DB::connection('dynamic')->table('admins')
                ->select('id', 'name')
                ->orderBy('id')
                ->get();

            return response()->json([
                'success' => true,
                'admins' => $admins,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load admins: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function databases()
    {
        return response()->json([
            'success' => trans('general.sent_successfully'),
            'databases' => databases(),
        ]);
    }

    public function getInputAppearances($dbname)
    {
        try {
            $this->connectDynamic($dbname);

            // Databases without the table simply have no per-column visibility rules
            $inputAppearances = $this->hasTable('input_appearances')
                ? DB::connection('dynamic')->table('input_appearances')
                    ->select('id', 'isCreate', 'isEdit', 'isIndex', 'isShow', 'table_name', 'column_name')
                    ->orderBy('id')
                    ->get()
                : [];

            return response()->json([
                'success' => true,
                'input_appearances' => $inputAppearances,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load input appearances: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function updateInputAppearance(Request $request, $dbname, $id)
    {
        try {
            $this->connectDynamic($dbname);

            $inputAppearance = DB::connection('dynamic')->table('input_appearances')
                ->where('id', $id)
                ->update([
                    'label' => $request->label,
                    'type' => $request->type,
                    'is_visible' => $request->is_visible,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Input appearance updated successfully ✅',
                'input_appearance' => $inputAppearance,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update input appearance: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteInputAppearance($dbname, $id)
    {
        try {
            $this->connectDynamic($dbname);

            $inputAppearance = DB::connection('dynamic')->table('input_appearances')
                ->where('id', $id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Input appearance deleted successfully ✅',
                'input_appearance' => $inputAppearance,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete input appearance: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function menuTables($dbname)
    {
        try {
            $this->connectDynamic($dbname);

            $menu_tables = DB::connection('dynamic')->table('menu_tables')
                ->select('*')
                ->orderBy('id')
                ->get();

            return response()->json([
                'success' => true,
                'menu_tables' => $menu_tables,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load menu tables: ' . $e->getMessage(),
            ], 500);
        }
    }
}
