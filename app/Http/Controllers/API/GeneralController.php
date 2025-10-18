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

            if (in_array($column, ['image', 'images'])) continue; // Skip files for now

            if ($request->has($column)) {
                $value = $request->input($column);

                // If the column is 'password', hash it before storing
                if ($column === 'password' && !empty($value)) {
                    $data[$column] = \Illuminate\Support\Facades\Hash::make($value);
                } else {
                    $data[$column] = $value;
                }
            }
        }

        // Step 4: Insert or update main record
        if ($itemId && $itemId !== "undefined") {
            DB::connection('dynamic')->table($table)->where('id', $itemId)->update($data);
        } else {
            $itemId = DB::connection('dynamic')->table($table)->insertGetId($data);
        }

        // Step 4.1: Handle image & images via files table
        $fileableType = 'App\\Models\\' . Str::studly(Str::singular($table));

        // Handle single image
        if ($request->hasFile('image')) {
            // Delete previous single image if exists
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


            $file = request()->file('image');
            $image = request()->image->store('images');
            $file->move('images',  $image);

            DB::connection('dynamic')->table('files')->insert([
                'url' => $image,
                'fileable_type' => $fileableType,
                'fileable_id' => $itemId,
                'isMultiply' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            // Delete previous multi-images
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

        // Step 5: Handle translations (if translation table exists)
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

        // Step 6: Return response with asset URLs
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
        SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
    ", [$dbName, $table]);

        $columns = collect($columns)->map(function ($col) {
            return [
                'COLUMN_NAME' => $col->COLUMN_NAME,
                'DATA_TYPE' => $col->DATA_TYPE,
                'IS_NULLABLE' => $col->IS_NULLABLE === 'YES',
            ];
        })->toArray();

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


    public function index($dbname, $table)
    {
        // Step 0: DB credentials + dynamic connection
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

        // 1. Get base columns of the main table
        $columns = DB::connection('dynamic')->select("
            SELECT COLUMN_NAME, DATA_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
        ", [$dbName, $table]);
        $columns = collect($columns)->map(fn($c) => (array)$c)->toArray();

        // 2. Setup translation for main table if exists
        $translationTable = Str::singular($table) . '_translations';
        $locale = request('locale', 'en');
        $hasMainTranslation = Schema::connection('dynamic')->hasTable($translationTable);

        $translatedSelects = [];
        // Build the base query (we’ll add joins later)
        $dataQuery = DB::connection('dynamic')->table($table)->select("$table.*");

        if ($hasMainTranslation) {
            // Get translation table columns
            $translationCols = DB::connection('dynamic')->select("
                SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
            ", [$dbName, $translationTable]);
            $translationCols = collect($translationCols)->pluck('COLUMN_NAME')->toArray();

            // Detect foreign key column in translation table
            $possibleForeignKeys = collect($translationCols)
                ->filter(fn($col) => Str::endsWith($col, '_id') && $col !== 'id');

            // Normalize translation table to expected FK name (e.g., PaymentMethod -> payment_method_id)
            $expectedForeignKey = Str::snake(Str::singular($table)) . '_id';

            // Use expectedForeignKey if it exists in translationCols
            if (in_array($expectedForeignKey, $translationCols)) {
                $foreignKey = $expectedForeignKey;
            } else {
                // fallback: first match based on prefix
                $foreignKey = $possibleForeignKeys
                    ->first(fn($col) => Str::startsWith($col, Str::snake(Str::singular($table))))
                    ?? $possibleForeignKeys->first();

                // Final fallback
                if (!$foreignKey) {
                    $foreignKey = $expectedForeignKey;
                }
            }


            // Join translation table on the detected foreign key
            $dataQuery->leftJoin(
                $translationTable,
                "$translationTable.$foreignKey",
                '=',
                "$table.id"
            )
                ->where("$translationTable.locale", $locale);

            // Add each translatable column to SELECT
            foreach ($translationCols as $col) {
                if (in_array($col, ['id', $foreignKey, 'locale', 'created_at', 'updated_at', 'deleted_at'])) {
                    continue;
                }
                $translatedSelects[] = "$translationTable.$col as $col";
                // Add metadata for front end
                $columns[] = [
                    'COLUMN_NAME' => $col,
                    'DATA_TYPE' => 'text',
                ];
            }

            if (!empty($translatedSelects)) {
                $dataQuery->addSelect($translatedSelects);
            }
        }

        // 3. Add “image” virtual column metadata
        $columns[] = [
            'COLUMN_NAME' => 'image',
            'DATA_TYPE' => 'image',
        ];

        // 4. Load mapping definitions for foreign keys override if exists
        $mappingRows = DB::connection('dynamic')->table('mapping')
            ->select('attribute_id', 'table_name', 'title_name')
            ->whereNotNull('attribute_id')
            ->whereNotNull('table_name')
            ->whereNotNull('title_name')
            ->get()
            ->keyBy('attribute_id');

        // 5. Get list of all tables in DB schema
        $tablesList = DB::connection('dynamic')->select("SHOW TABLES");
        $tablesList = collect($tablesList)
            ->map(fn($t) => array_values((array)$t)[0])
            ->toArray();

        // 6. Handle *_id foreign keys in the main table (join related tables + translations)
        foreach ($columns as $cmeta) {
            $colName = $cmeta['COLUMN_NAME'];
            if (!Str::endsWith($colName, '_id')) {
                continue;
            }

            $relatedKey = $colName;

            // 6.1 Check override from `mapping` table
            if ($mappingRows->has($colName)) {
                $map = $mappingRows->get($colName);
                $relatedBase = $map->table_name;
                $displayFieldOverride = $map->title_name;
            } else {
                $relatedBase = Str::plural(str_replace('_id', '', $relatedKey));
                $displayFieldOverride = null;
            }

            if (!in_array($relatedBase, $tablesList)) {
                continue;
            }

            $aliasTitle = $relatedKey;

            // 6.2 Join base related table
            $dataQuery->leftJoin($relatedBase, "$relatedBase.id", '=', "$table.$relatedKey");

            // 6.3 Get columns of base table
            $relCols = DB::connection('dynamic')->select("
                SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
            ", [$dbName, $relatedBase]);
            $relCols = collect($relCols)->pluck('COLUMN_NAME')->toArray();

            $displayCandidates = ['title', 'name', 'full_name', 'label'];
            $baseDisplayCol = $displayFieldOverride ?: collect($displayCandidates)->first(fn($d) => in_array($d, $relCols));
            $transDisplayCol = null;

            // 6.4 Attempt to load from `mapping_translations` table first
            $normalizedAttrId = Str::snake($relatedKey);
            $customTransMapping = DB::connection('dynamic')
                ->table('mapping_translations')
                ->where('attribute_id', $normalizedAttrId)
                ->first();

            $relatedTrans = null;
            $foreignKeyInRelTrans = null;

            // Step 1: Try to find mapping_translations using the target attribute
            $mappingTransRecord = DB::connection('dynamic')
                ->table('mapping_translations')
                ->where('attribute_id', Str::snake($relatedKey))
                ->first();

            if ($mappingTransRecord) {
                $relatedTrans = $mappingTransRecord->translation_table;
                $foreignKeyInRelTrans = $mappingTransRecord->foreign_key ?: Str::snake($relatedKey);
            } else {
                $relatedTrans = Str::singular($relatedBase) . '_translations';
            }

            // Step 2: Only continue if the translation table exists
            $hasRelTrans = in_array($relatedTrans, $tablesList);

            if ($hasRelTrans) {
                $transCols = DB::connection('dynamic')->select("
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
    ", [$dbName, $relatedTrans]);
                $transCols = collect($transCols)->pluck('COLUMN_NAME')->toArray();

                // Step 3: Confirm foreign key column in translation table
                if (!$foreignKeyInRelTrans || !in_array($foreignKeyInRelTrans, $transCols)) {
                    $possibleForeignKeys = collect($transCols)->filter(fn($col) => Str::endsWith($col, '_id'));
                    $foreignKeyInRelTrans = $possibleForeignKeys->first();
                }

                // Step 4: Determine which translated column to show
                $transDisplayCol = collect($displayCandidates)->first(fn($d) => in_array($d, $transCols));

                // Step 5: Join translation table
                $translationAlias = $relatedTrans . '_' . $relatedKey; // e.g. 'paymentMethod_translations_paymentMethod_id'

                $dataQuery->leftJoin("$relatedTrans as $translationAlias", function ($join) use ($translationAlias, $relatedBase, $foreignKeyInRelTrans, $locale) {
                    $join->on("$translationAlias.$foreignKeyInRelTrans", '=', "$relatedBase.id")
                        ->where("$translationAlias.locale", $locale);
                });


                if ($baseDisplayCol && $transDisplayCol) {
                    $dataQuery->addSelect(
                        DB::raw("COALESCE($relatedBase.$baseDisplayCol, $relatedTrans.$transDisplayCol) as $aliasTitle")
                    );
                } elseif ($transDisplayCol) {
                    $dataQuery->addSelect("$relatedTrans.$transDisplayCol as $aliasTitle");
                }
            } elseif ($baseDisplayCol) {
                $dataQuery->addSelect("$relatedBase.$baseDisplayCol as $aliasTitle");
            }


            // 6.5 Join related translation table if exists
            if ($hasRelTrans) {
                $transCols = DB::connection('dynamic')->select("
                    SELECT COLUMN_NAME
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
                ", [$dbName, $relatedTrans]);
                $transCols = collect($transCols)->pluck('COLUMN_NAME')->toArray();

                $transDisplayCol = collect($displayCandidates)->first(fn($d) => in_array($d, $transCols));

                if (!isset($foreignKeyInRelTrans)) {
                    $possibleForeignKeys = collect($transCols)->filter(fn($col) => Str::endsWith($col, '_id'));
                    $foreignKeyInRelTrans = $possibleForeignKeys->first();
                }

                // Join translations
                $translationAlias = $relatedTrans . '_' . $relatedKey; // e.g. 'paymentMethod_translations_paymentMethod_id'

                $dataQuery->leftJoin("$relatedTrans as $translationAlias", function ($join) use ($translationAlias, $relatedBase, $foreignKeyInRelTrans, $locale) {
                    $join->on("$translationAlias.$foreignKeyInRelTrans", '=', "$relatedBase.id")
                        ->where("$translationAlias.locale", $locale);
                });


                if ($baseDisplayCol) {
                    $dataQuery->addSelect(
                        DB::raw("COALESCE($relatedBase.$baseDisplayCol, $relatedTrans.$transDisplayCol) as $aliasTitle")
                    );
                } else {
                    $dataQuery->addSelect("$relatedTrans.$transDisplayCol as $aliasTitle");
                }
            } elseif ($baseDisplayCol) {
                $dataQuery->addSelect("$relatedBase.$baseDisplayCol as $aliasTitle");
            }
        }



        // 7. Apply filters from request query parameters
        foreach (request()->query() as $key => $value) {
            if ($key === 'page') {
                continue;
            }
            if (is_array($value) && in_array($key, ['en', 'ar']) && $hasMainTranslation) {
                foreach ($value as $fld => $val) {
                    $dataQuery->where("$translationTable.$fld", 'like', "%$val%");
                }
            } else {
                $dataQuery->where("$table.$key", 'like', "%$value%");
            }
        }

        // 8. Paginate results
        $paginated = $dataQuery->paginate(10);

        // 9. Add image URL to each record
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

        // 10. Return JSON response
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

        // Step 2: Get all table names
        $allTables = DB::connection('dynamic')->table('INFORMATION_SCHEMA.COLUMNS')
            ->select('TABLE_NAME')
            ->where('TABLE_SCHEMA', $dbname)
            ->distinct()
            ->orderBy('TABLE_NAME')
            ->pluck('TABLE_NAME');

        // Step 3: Get blocked tables filtered by dbname
        try {
            $blockedTables = DB::connection('dynamic')->table('blocked_modules')
                ->where('dbname', $dbname)
                ->pluck('table_name');
        } catch (\Exception $e) {
            $blockedTables = collect();
        }

        // Step 4: Filter tables
        $filteredTables = $allTables
            ->diff($blockedTables)
            ->reject(function ($table) {
                return str_ends_with($table, '_translations') && $table !== 'mapping_translations';
            })
            ->values();

        // Step 5: Return as array of objects
        $structuredTables = $filteredTables->map(function ($table) {
            return ['TABLE_NAME' => $table];
        });

        return response()->json([
            'success' => trans('general.sent_successfully'),
            'tables' => $structuredTables,
        ]);
    }




    public function databases()
    {
        return response()->json([
            'success' => trans('general.sent_successfully'),
            'databases' => databases(),
        ]);
    }
}
