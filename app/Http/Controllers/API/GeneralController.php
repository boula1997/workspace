<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MessageRequest;
use App\Models\Message;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Deadline;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\DBCredential;
use Illuminate\Support\Facades\File;

use App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Support\Str;

class GeneralController extends Controller
{


public function storeUpdate(Request $request, $dbname, $table, $itemId = null)
{
    // Step 0: Get DB credentials
    $credential = DBCredential::where('db_name', $dbname)->first();

    $dbHost = $credential->db_host ?? '192.185.41.219';
    $dbName = $credential->db_name ?? 'automation';
    $dbUser = $credential->db_username ?? 'root';
    $dbPass = $credential->db_password ?? '';

    // Step 1: Configure dynamic connection
    config([
        'database.connections.dynamic' => [
            'driver' => 'mysql',
            'host' => $dbHost,
            'database' => $dbName,
            'username' => $dbUser,
            'password' => $dbPass,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
    ]);

    DB::purge('dynamic');
    DB::reconnect('dynamic');
    DB::connection('dynamic')->statement('USE ' . $dbName);

    // Step 2: Get main table columns
    $columns = DB::connection('dynamic')->select("
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = ?;
    ", [$table]);

    $columnNames = collect($columns)->pluck('COLUMN_NAME')->toArray();
    $exclude = ['id'];
    $data = [];

    // Step 3: Collect column values (excluding image/images)
    foreach ($columnNames as $column) {
        if (in_array($column, $exclude)) continue;
        if (in_array($column, ['image', 'images'])) continue;

        if ($request->has($column)) {
            $value = $request->input($column);

            if ($column === 'password' && !empty($value)) {
                $data[$column] = \Illuminate\Support\Facades\Hash::make($value);
            } else {
                $data[$column] = $value;
            }
        }
    }

    // 🕒 Step 3.1: Add timestamps manually
    $now = now(); // Carbon instance

    if ($itemId && $itemId !== "undefined") {
        // 🟢 UPDATE — set updated_at only
        if (in_array('updated_at', $columnNames)) {
            $data['updated_at'] = $now;
        }

        DB::connection('dynamic')->table($table)
            ->where('id', $itemId)
            ->update($data);
    } else {
        // 🟡 CREATE — set both created_at and updated_at
        if (in_array('created_at', $columnNames)) {
            $data['created_at'] = $now;
        }
        if (in_array('updated_at', $columnNames)) {
            $data['updated_at'] = $now;
        }

        $itemId = DB::connection('dynamic')->table($table)->insertGetId($data);
    }

    // Step 4: Handle image & images via files table (unchanged)
    $fileableType = 'App\\Models\\' . Str::studly(Str::singular($table));

    if ($request->hasFile('image')) {
        $currentImage = DB::connection('dynamic')->table('files')
            ->where('fileable_type', $fileableType)
            ->where('fileable_id', $itemId)
            ->where('isMultiply', 0)
            ->first();

        if ($currentImage && file_exists($currentImage->url)) {
            File::delete($currentImage->url);
        }
        if ($currentImage) {
            DB::connection('dynamic')->table('files')
                ->where('id', $currentImage->id)
                ->delete();
        }

        $file = $request->file('image');
        $image = $file->store('images');
        $file->move('images', $image);

        DB::connection('dynamic')->table('files')->insert([
            'url' => $image,
            'fileable_type' => $fileableType,
            'fileable_id' => $itemId,
            'isMultiply' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    if ($request->hasFile('images')) {
        $currentImages = DB::connection('dynamic')->table('files')
            ->where('fileable_type', $fileableType)
            ->where('fileable_id', $itemId)
            ->where('isMultiply', 1)
            ->get();

        foreach ($currentImages as $currentImage) {
            if ($currentImage && file_exists($currentImage->url)) {
                File::delete($currentImage->url);
            }
            if ($currentImage) {
                DB::connection('dynamic')->table('files')
                    ->where('id', $currentImage->id)
                    ->delete();
            }
        }

        foreach ($request->file('images') as $file) {
            $data['image'] = $file->store('images');
            $file->move('images', $data['image']);

            DB::connection('dynamic')->table('files')->insert([
                'url' => $data['image'],
                'fileable_type' => $fileableType,
                'fileable_id' => $itemId,
                'isMultiply' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Step 5: Translations (unchanged)
    $translationTable = Str::singular($table) . '_translations';
    $foreignKey = Str::singular($table) . '_id';

    if (Schema::connection('dynamic')->hasTable($translationTable)) {
        $translationData = [];

        foreach (['en', 'ar'] as $locale) {
            if ($request->has($locale) && is_array($request->input($locale))) {
                $translationData[$locale] = $request->input($locale);
            }
        }

        foreach ($translationData as $locale => $fields) {
            $fields[$foreignKey] = $itemId;
            $fields['locale'] = $locale;
            $fields['updated_at'] = $now; // 🕒 timestamp for translations
            if (in_array('created_at', Schema::connection('dynamic')->getColumnListing($translationTable))) {
                $fields['created_at'] = $now;
            }

            $existing = DB::connection('dynamic')->table($translationTable)
                ->where($foreignKey, $itemId)
                ->where('locale', $locale)
                ->first();

            if ($existing) {
                DB::connection('dynamic')->table($translationTable)
                    ->where($foreignKey, $itemId)
                    ->where('locale', $locale)
                    ->update($fields);
            } else {
                DB::connection('dynamic')->table($translationTable)->insert($fields);
            }
        }
    }

    // Step 6: Return response
    $files = DB::connection('dynamic')->table('files')
        ->where('fileable_type', $fileableType)
        ->where('fileable_id', $itemId)
        ->where('isMultiply', 1)
        ->get();
    $file = DB::connection('dynamic')->table('files')
        ->where('fileable_type', $fileableType)
        ->where('fileable_id', $itemId)
        ->where('isMultiply', 0)
        ->first();

    $image = $file->url ?? null;
    $images = $files->pluck('url')->map(fn($url) => asset('storage/' . $url))->toArray();

    return response()->json([
        'success' => true,
        'message' => $itemId ? 'Record updated successfully.' : 'Record inserted successfully.',
        'data' => $data,
        'id' => $itemId,
        'image' => $image ? asset('storage/' . $image) : null,
        'images' => $images,
    ]);
}










    public function showEditCreate($dbname, $table, $itemId = null)
    {
        // Step 0: Get DB credentials
        $credential = DBCredential::where('db_name', $dbname)->first();

        $dbHost = $credential->db_host ?? '192.185.41.219';
        $dbName = $credential->db_name ?? 'automation';
        $dbUser = $credential->db_username ?? 'root';
        $dbPass = $credential->db_password ?? '';

        // Step 1: Configure dynamic connection
        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => $dbName,
                'username' => $dbUser,
                'password' => $dbPass,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');
        DB::connection('dynamic')->statement('USE ' . $dbName);

        // Step 2: Base table columns
        $columns = DB::connection('dynamic')->select("
            SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_COMMENT
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
        ", [$dbName, $table]);

        $columns = collect($columns)
            ->map(fn($col) => [
                'COLUMN_NAME' => $col->COLUMN_NAME,
                'DATA_TYPE' => $col->DATA_TYPE,
                'IS_NULLABLE' => $col->IS_NULLABLE === 'YES',
                'HIDDEN' => strtolower(trim($col->COLUMN_COMMENT)) === 'hide', // 👈 Add this line
            ])
            ->values()
            ->toArray();

        // Step 3: Add virtual image fields
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

        // Step 4: Prepare related dropdown options for foreign keys
        // Step 4: Prepare related dropdown options for foreign keys
        $relatedOptions = [];

        // Fetch all mappings that have attribute_id, table_name, and title_name
        $mappingRows = DB::connection('dynamic')->table('mapping')
            ->select('attribute_id', 'table_name', 'title_name', 'type')
            ->whereNotNull('attribute_id')
            ->whereNotNull('table_name')
            ->whereNotNull('title_name')
            // DO NOT filter by type — just accept it if present or null
            ->get()
            ->keyBy('attribute_id'); // So we can find mapping by the _id column name

        foreach ($columns as $col) {
            $colName = $col['COLUMN_NAME'];

            // Check if this column is a foreign key (ends with _id)
            if (Str::endsWith($colName, '_id')) {
                // Check if mapping exists for this column
                if ($mappingRows->has($colName)) {
                    $map = $mappingRows->get($colName);

                    $mappedTable = $map->table_name;
                    $labelField = $map->title_name;

                    // Skip if the mapped table doesn't exist
                    if (!Schema::connection('dynamic')->hasTable($mappedTable)) {
                        continue;
                    }

                    // Get the related dropdown data
                    $relatedData = DB::connection('dynamic')->table($mappedTable)
                        ->select('id', DB::raw("`$labelField` as label"))
                        ->get();

                    // Use the original column name as the key
                    $relatedOptions[$colName] = $relatedData;
                    continue; // Skip fallback logic if mapping was used
                }

                // Fallback logic (guessing table and label field)
                $baseTable = Str::plural(Str::beforeLast($colName, '_id'));
                $singular = Str::singular($baseTable);
                $translationTable = "{$singular}_translations";

                if (!Schema::connection('dynamic')->hasTable($baseTable)) {
                    continue;
                }

                $mainColumns = Schema::connection('dynamic')->getColumnListing($baseTable);

                $labelColumn = collect(['title', 'name'])
                    ->first(fn($field) => in_array($field, $mainColumns));

                if ($labelColumn) {
                    $relatedData = DB::connection('dynamic')->table($baseTable)
                        ->select('id', DB::raw("`$labelColumn` as label"))
                        ->get();
                } elseif (Schema::connection('dynamic')->hasTable($translationTable)) {
                    $translationColumns = Schema::connection('dynamic')->getColumnListing($translationTable);

                    $translationLabel = collect(['title', 'name'])->first(function ($field) use ($translationColumns) {
                        return in_array($field, $translationColumns);
                    });

                    if ($translationLabel) {
                        $relatedData = DB::connection('dynamic')->table($baseTable)
                            ->leftJoin($translationTable, "{$translationTable}.{$singular}_id", '=', "{$baseTable}.id")
                            ->where("{$translationTable}.locale", 'en')
                            ->select("{$baseTable}.id", "{$translationTable}.{$translationLabel} as label")
                            ->get();
                    } else {
                        $relatedData = DB::connection('dynamic')->table($baseTable)
                            ->selectRaw("id, CONCAT('ID: ', id) as label")
                            ->get();
                    }
                } else {
                    $relatedData = DB::connection('dynamic')->table($baseTable)
                        ->selectRaw("id, CONCAT('ID: ', id) as label")
                        ->get();
                }

                $relatedOptions[$colName] = $relatedData;
            }
        }


        // Step 5: Handle translation columns - always add these for create & edit
        $translationTable = Str::singular($table) . '_translations';

        if (Schema::connection('dynamic')->hasTable($translationTable)) {
            $transColumns = DB::connection('dynamic')->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
        ", [$dbName, $translationTable]);

            $allTranslationCols = collect($transColumns)->pluck('COLUMN_NAME')->toArray();

            // Dynamically find the foreign key in the translation table
            $possibleForeignKeys = collect($allTranslationCols)->filter(fn($col) => Str::endsWith($col, '_id') && $col !== 'id');
            $foreignKey = $possibleForeignKeys->first(fn($col) => Str::startsWith($col, Str::singular($table))) ?? $possibleForeignKeys->first();
            if (!$foreignKey) {
                $foreignKey = Str::singular($table) . '_id'; // fallback
            }

            // Get only actual translatable columns
            $transColumns = collect($allTranslationCols)
                ->reject(fn($col) => in_array($col, ['id', 'locale', $foreignKey, 'created_at', 'updated_at', 'deleted_at']))
                ->values()
                ->toArray();


            // Define supported locales
            $locales = ['en', 'ar'];

            // Add translation fields for each locale to columns
            foreach ($locales as $locale) {
                foreach ($transColumns as $col) {
                    $columns[] = [
                        "COLUMN_NAME" => "{$locale}[$col]",
                        "DATA_TYPE" => "text",
                        "IS_NULLABLE" => true,
                    ];
                }
            }
        }

        // Step 6: If no valid $itemId, return columns and related options only
        if (!$itemId || $itemId === "undefined" || !is_numeric($itemId)) {
            return response()->json([
                'success' => trans('general.sent_successfully'),
                'columns' => $columns,
                'related' => $relatedOptions,
                'data' => [],
            ]);
        }

        // Step 7: Fetch main record for edit
        $data = DB::connection('dynamic')->table($table)->where('id', $itemId)->first();

        if (!$data) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $data = (array) $data;

        $files = DB::connection('dynamic')->table('files')
            ->where('fileable_type', 'App\\Models\\' . Str::studly(Str::singular($table)))
            ->where('fileable_id', $itemId)
            ->where('isMultiply', 1)
            ->pluck('url')
            ->map(function ($url) {
                return asset($url);
            })
            ->toArray();
        $file = DB::connection('dynamic')->table('files')
            ->where('fileable_type', 'App\\Models\\' . Str::studly(Str::singular($table)))
            ->where('fileable_id', $itemId)
            ->where('isMultiply', 0)
            ->pluck('url')
            ->map(function ($url) {
                return asset($url);
            })
            ->first();

        $data['image'] = $file  ?? null;
        $data['images'] = $files;


        // Optional: placeholder images (adjust or remove if you want)
        $data["image"] = $data["image"] ?? settings()->logo;
        $data["images"] = $data["images"] ?? [
            settings()->logo,
            settings()->logo
        ];

        // Step 8: Fetch translations data for this record
        if (Schema::connection('dynamic')->hasTable($translationTable)) {
            $transCols = Schema::connection('dynamic')->getColumnListing($translationTable);

            $possibleForeignKeys = collect($transCols)->filter(fn($col) => Str::endsWith($col, '_id') && $col !== 'id');
            $foreignKey = $possibleForeignKeys->first(fn($col) => Str::startsWith($col, Str::singular($table))) ?? $possibleForeignKeys->first();
            if (!$foreignKey) {
                $foreignKey = Str::singular($table) . '_id';
            }

            $translations = DB::connection('dynamic')->table($translationTable)
                ->where($foreignKey, $itemId)
                ->get();


            foreach ($translations as $translation) {
                foreach ($transColumns as $col) {
                    $key = "{$translation->locale}[$col]";
                    $data[$key] = $translation->$col;
                }
            }
        }

        // Step 9: Return data, columns, and related dropdown options
        return response()->json([
            'success' => trans('general.sent_successfully'),
            'columns' => $columns,
            'related' => $relatedOptions,
            'data' => [$data],
        ]);
    }



    public function deleteItem($dbname, $table, $itemId)
    {

        // Step 0: Get DB credentials
        $credential = DBCredential::where('db_name', $dbname)->first();

        $dbHost = $credential->db_host ?? '192.185.41.219';
        $dbName = $credential->db_name ?? 'automation';
        $dbUser = $credential->db_username ?? 'root';
        $dbPass = $credential->db_password ?? '';

        // Step 1: Configure dynamic connection
        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => $dbName,
                'username' => $dbUser,
                'password' => $dbPass,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');
        DB::connection('dynamic')->statement('USE ' . $dbName);


        // Retrieve table columns and their data types
        $columns = DB::connection('dynamic')->select("
        SELECT COLUMN_NAME, DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
    ", [$dbname, $table]);

        // Convert columns to array (for easy manipulation)
        $columns = collect($columns)->map(function ($col) {
            return (array) $col;
        })->toArray();

        // ✅ Add an extra "image" column manually
        $columns[] = [
            "COLUMN_NAME" => "image",
            "DATA_TYPE" => "image",
        ];

        $columns[] = [
            "COLUMN_NAME" => "images",
            "DATA_TYPE" => "multimages",
        ];

        // Retrieve record data
        $data = DB::connection('dynamic')->select("
        delete FROM {$table} WHERE id = ?
    ", [$itemId]);



        return response()->json([
            'success' => trans('general.sent_successfully'),
            'columns' => $columns,
            'data' => $data,
        ]);
    }


    public function index($dbname, $table,$column=null,$equal=null)
    {
        // Step 0: Dynamic DB connection
        $credential = DBCredential::where('db_name', $dbname)->first();
        $dbHost = $credential->db_host ?? '192.185.41.219';
        $dbName = $credential->db_name ?? 'automation';
        $dbUser = $credential->db_username ?? 'root';
        $dbPass = $credential->db_password ?? '';

        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => $dbName,
                'username' => $dbUser,
                'password' => $dbPass,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');
        DB::connection('dynamic')->statement('USE ' . $dbName);

        // Step 1: Get base columns of main table
        $columns = DB::connection('dynamic')->select("
            SELECT COLUMN_NAME, DATA_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
        ", [$dbName, $table]);
        $columns = collect($columns)->map(fn($c) => (array)$c)->toArray();

        // Step 2: Setup translation for main table
        $translationTable = Str::singular($table) . '_translations';
        $locale = request('locale', 'en');
        $hasMainTranslation = Schema::connection('dynamic')->hasTable($translationTable);

        $translatedSelects = [];
        $dataQuery = DB::connection('dynamic')->table($table)->select("$table.*");

        if ($hasMainTranslation) {
            $translationCols = DB::connection('dynamic')->select("
                SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
            ", [$dbName, $translationTable]);
            $translationCols = collect($translationCols)->pluck('COLUMN_NAME')->toArray();

            $expectedForeignKey = Str::snake(Str::singular($table)) . '_id';
            $foreignKey = in_array($expectedForeignKey, $translationCols) 
                ? $expectedForeignKey 
                : collect($translationCols)
                    ->first(fn($col) => Str::endsWith($col, '_id') && $col !== 'id')
                ?? $expectedForeignKey;

            $dataQuery->leftJoin(
                $translationTable,
                "$translationTable.$foreignKey",
                '=',
                "$table.id"
            )->where("$translationTable.locale", $locale);

            foreach ($translationCols as $col) {
                if (!in_array($col, ['id', $foreignKey, 'locale', 'created_at', 'updated_at', 'deleted_at'])) {
                    $translatedSelects[] = "$translationTable.$col as $col";
                    $columns[] = ['COLUMN_NAME' => $col, 'DATA_TYPE' => 'text'];
                }
            }

            if (!empty($translatedSelects)) {
                $dataQuery->addSelect($translatedSelects);
            }
        }

        // Step 3: Add image column metadata
        $columns[] = ['COLUMN_NAME' => 'image', 'DATA_TYPE' => 'image'];

        // Step 4: Load mappings for FK override
        $mappingRows = DB::connection('dynamic')->table('mapping')
            ->select('attribute_id', 'table_name', 'title_name')
            ->whereNotNull('attribute_id')
            ->whereNotNull('table_name')
            ->whereNotNull('title_name')
            ->get()
            ->keyBy('attribute_id');

        // Step 5: Get all tables
        $tablesList = DB::connection('dynamic')->select("SHOW TABLES");
        $tablesList = collect($tablesList)->map(fn($t) => array_values((array)$t)[0])->toArray();

        // Step 6: Handle *_id foreign keys
        // Step 6: Handle *_id foreign keys
        foreach ($columns as $cmeta) {
            $colName = $cmeta['COLUMN_NAME'];
            if (!Str::endsWith($colName, '_id')) continue;

            $relatedKey = $colName;
            $relatedBase = $mappingRows->has($colName)
                ? $mappingRows->get($colName)->table_name
                : Str::plural(str_replace('_id', '', $relatedKey));
            $displayFieldOverride = $mappingRows->has($colName) ? $mappingRows->get($colName)->title_name : null;

            if (!in_array($relatedBase, $tablesList)) continue;

            $aliasTitle = $relatedKey;
            $dataQuery->leftJoin($relatedBase, "$relatedBase.id", '=', "$table.$relatedKey");

            // Get related base columns
            $relCols = DB::connection('dynamic')->select("
                SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
            ", [$dbName, $relatedBase]);
            $relCols = collect($relCols)->pluck('COLUMN_NAME')->toArray();

            // Try to find a display column
            $displayCandidates = ['title', 'name', 'full_name', 'label'];
            $baseDisplayCol = $displayFieldOverride ?: collect($displayCandidates)->first(fn($d) => in_array($d, $relCols));

            // Try to find an auto-detected translation table
            $relatedTrans = Str::singular($relatedBase) . '_translations';
            $hasRelTrans = in_array($relatedTrans, $tablesList);

            if ($hasRelTrans) {
                // Try to identify foreign key in that translation table
                $transCols = DB::connection('dynamic')->select("
                    SELECT COLUMN_NAME
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
                ", [$dbName, $relatedTrans]);
                $transCols = collect($transCols)->pluck('COLUMN_NAME')->toArray();

                $foreignKeyInRelTrans = collect($transCols)->first(fn($col) => Str::endsWith($col, '_id')) 
                    ?? Str::snake(Str::singular($relatedBase)) . '_id';

                // Detect translatable display column
                $transDisplayCol = collect($displayCandidates)->first(fn($d) => in_array($d, $transCols));
                $translationAlias = $relatedTrans . '_' . $relatedKey;

                // Join the translation table
                $dataQuery->leftJoin("$relatedTrans as $translationAlias", function ($join) use ($translationAlias, $relatedBase, $foreignKeyInRelTrans, $locale) {
                    $join->on("$translationAlias.$foreignKeyInRelTrans", '=', "$relatedBase.id")
                        ->where("$translationAlias.locale", $locale);
                });

                // Prefer translated name if available
                if ($baseDisplayCol && $transDisplayCol) {
                    $dataQuery->addSelect(DB::raw("COALESCE($relatedBase.$baseDisplayCol, $translationAlias.$transDisplayCol) as $aliasTitle"));
                } elseif ($transDisplayCol) {
                    $dataQuery->addSelect("$translationAlias.$transDisplayCol as $aliasTitle");
                }
            } elseif ($baseDisplayCol) {
                // Fallback: non-translated related table
                $dataQuery->addSelect("$relatedBase.$baseDisplayCol as $aliasTitle");
            }
        }


            // Step 7: Apply filters

            // ✅ Custom column/equal filter
            if (!is_null($column) && !is_null($equal) && $column !== 'null' && $equal !== 'null') {
                $dataQuery->where("$table.$column", $equal);
            }

            // ✅ Request-based filters (fallback)
            foreach (request()->query() as $key => $value) {
                if ($key === 'page') continue;

                if (is_array($value) && in_array($key, ['en', 'ar']) && $hasMainTranslation) {
                    foreach ($value as $fld => $val) {
                        $dataQuery->where("$translationTable.$fld", 'like', "%$val%");
                    }
                } else {
                    // 🔍 Detect the column’s data type
                    $colMeta = collect($columns)->firstWhere('COLUMN_NAME', $key);
                    $dataType = $colMeta['DATA_TYPE'] ?? null;

                    // 🧠 Check if it’s numeric foreign key
                    if (is_numeric($value) && Str::endsWith($key, '_id')) {
                        $dataQuery->where("$table.$key", $value);

                    // 📅 Handle date/datetime values
                    } elseif (in_array($dataType, ['date', 'datetime', 'timestamp']) && strtotime($value)) {
                        // Example: return all records from or after this date
                        $dataQuery->whereDate("$table.$key", '>=', date('Y-m-d', strtotime($value)));

                    // 🔢 Numeric (non-ID)
                    } elseif (is_numeric($value)) {
                        $dataQuery->where("$table.$key", '>=', $value);

                    // 🔤 Text / fallback
                    } else {
                        $dataQuery->where("$table.$key", 'like', "%$value%");
                    }
                }
            }



         $dataQuery->orderBy("$table.id", 'desc');

        // Step 8: Pagination
        $paginated = $dataQuery->paginate(10);

        // Step 9: Add image URLs
        $paginated->getCollection()->transform(function ($item) use ($table) {
            $row = (array)$item;
            $fileableType = 'App\\Models\\' . Str::studly(Str::singular($table));

            $img = DB::connection('dynamic')->table('files')
                ->where('fileable_type', $fileableType)
                ->where('fileable_id', $row['id'])
                ->where('isMultiply', 0)
                ->value('url');

            $row['image'] = $img ? asset($img) : settings()->logo;
            return (object)$row;
        });

        // Step 10: Response
        return response()->json([
            'success' => trans('general.sent_successfully'),
            'columns' => $columns,
            'data' => $paginated->items(),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }









public function tableNames($dbname)
{
    // Step 0: Get DB credentials
    $credential = DBCredential::where('db_name', $dbname)->firstOrFail();

    config([
        'database.connections.dynamic' => [
            'driver' => 'mysql',
            'host' => $credential->db_host ?? '192.185.41.219',
            'database' => $credential->db_name ?? 'automation',
            'username' => $credential->db_username ?? 'root',
            'password' => $credential->db_password ?? '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
    ]);

    DB::purge('dynamic');
    DB::reconnect('dynamic');
    DB::connection('dynamic')->statement('USE ' . $dbname);

    // Step 2: Get allowed tables directly from admin permissions
    $allowedTables = collect();
    if (auth('admin-api')->check()) {
        $admin = auth('admin-api')->user();
        if (!empty($admin->permissions)) {
            $decoded = json_decode($admin->permissions, true);
            if (is_array($decoded)) {
                $allowedTables = collect($decoded);
            }
        }
    }

    // Step 3: Format as array of objects with "TABLE_NAME" key
    $formattedTables = $allowedTables->map(function ($table) {
        return ['TABLE_NAME' => $table];
    })->values();

    return response()->json([
        'success' => trans('general.sent_successfully'),
        'tables' => $formattedTables,
    ]);
}





    public function allTableNames($dbname,$admin_id=null)
    {
        // Step 0: Get DB credentials
        $credential = DBCredential::where('db_name', $dbname)->first();

        $dbHost = $credential->db_host ?? '192.185.41.219';
        $dbName = $credential->db_name ?? 'automation';
        $dbUser = $credential->db_username ?? 'root';
        $dbPass = $credential->db_password ?? '';

        // Step 1: Configure dynamic connection
        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => $dbName,
                'username' => $dbUser,
                'password' => $dbPass,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');
        DB::connection('dynamic')->statement('USE ' . $dbName);

                    $blockedModules = [];


        // Step 2: Get all table names
        $allTables = DB::connection('dynamic')->table('INFORMATION_SCHEMA.COLUMNS')
            ->select('TABLE_NAME')
            ->where('TABLE_SCHEMA', $dbname)
            ->distinct()
            ->orderBy('TABLE_NAME')
            ->pluck('TABLE_NAME');



                  // Step 3: Get blocked tables filtered by dbname
        try {
            if (isset($admin_id)) {
                // Fetch the permissions JSON from the admin
                $permissions = DB::connection('dynamic')
                    ->table('admins')
                    ->where('id', $admin_id)
                    ->value('permissions');

                // Decode JSON safely
                $blockedTables = collect(json_decode($permissions, true) ?? []);

                $blockedModules = DB::connection('dynamic')
                    ->table('blocked_modules')
                    ->pluck('table_name');
            } else {
                // Default: get from blocked_modules table
                $blockedTables = DB::connection('dynamic')
                    ->table('blocked_modules')
                    ->pluck('table_name');

                    $blockedModules = [];
            }
        } catch (\Exception $e) {
            $blockedTables = collect();
        }


        // Step 4: Filter tables
        $filteredTables = $allTables
            ->reject(function ($table) {
                return str_ends_with($table, '_translations') && $table !== 'mapping_translations';
            })
            ->values();



        // Step 5: Return as array of objects
        $structuredTables = $filteredTables->map(function ($table) {
            return ['TABLE_NAME' => $table];
        });

        $admins=Admin::latest()->get();

        return response()->json([
            'success' => trans('general.sent_successfully'),
            'tables' => $structuredTables,
            'blockedTables' => $blockedTables,
            'blockedModules' => $blockedModules,
            'admins' => $admins,
        ]);
    }

    public function blockTables(Request $request, $dbname)
    {
        $credential = DBCredential::where('db_name', $dbname)->firstOrFail();

        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $credential->db_host,
                'database' => $credential->db_name,
                'username' => $credential->db_username,
                'password' => $credential->db_password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');

        $tables = $request->tables ?? [];
        $permissions = json_encode($tables);

        if ($request->has('admin_id')) {
            // Update admin permissions
            DB::connection('dynamic')->table('admins')
                ->where('id', $request->admin_id)
                ->update([
                    'permissions' => $permissions,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Admin permissions updated successfully ✅',
                'permissions' => $tables,
            ]);
        } else {
            // Replace blocked modules list
            DB::connection('dynamic')->table('blocked_modules')->truncate();

            foreach ($tables as $table) {
                DB::connection('dynamic')->table('blocked_modules')->insert([
                    'table_name' => $table,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tables blocked successfully ✅',
                'blocked' => $tables,
            ]);
        }
    }


public function getAdmins($dbname)
{
    try {
        $credential = DBCredential::where('db_name', $dbname)->firstOrFail();

        // Configure connection dynamically
        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $credential->db_host,
                'database' => $credential->db_name,
                'username' => $credential->db_username,
                'password' => $credential->db_password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');

        // Fetch all admins
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



}
