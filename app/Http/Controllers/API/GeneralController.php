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

    // Get main table columns
    $columns = DB::connection('dynamic')->select("
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = ?;
    ", [$table]);

    $columnNames = collect($columns)->pluck('COLUMN_NAME')->toArray();

    $exclude = ['id', 'created_at', 'updated_at'];

    $data = [];

    foreach ($columnNames as $column) {
        if (in_array($column, $exclude)) continue;

        if ($column === 'image') {
            if ($request->hasFile('image')) {
                $data[$column] = $request->file('image')->store('uploads', 'public');
            } elseif (!$itemId) {
                $data[$column] = null;
            }
        } elseif ($column === 'images') {
            if ($request->hasFile('images')) {
                $data[$column] = json_encode(array_map(function ($file) {
                    return $file->store('uploads', 'public');
                }, $request->file('images')));
            } elseif (!$itemId) {
                $data[$column] = null;
            }
        } else {
            if ($request->has($column)) {
                $data[$column] = $request->input($column);
            } elseif (!$itemId) {
                $data[$column] = null;
            }
        }
    }

    // Insert or Update Main Record
    if ($itemId && $itemId !== "undefined") {
        DB::connection('dynamic')->table($table)->where('id', $itemId)->update($data);
    } else {
        $itemId = DB::connection('dynamic')->table($table)->insertGetId($data);
    }

    // 🧠 STEP: Handle translations like en[title], ar[description], etc.
    $translationData = [];

    foreach ($request->all() as $key => $value) {
        if (preg_match('/^([a-z]{2})\[(.+)\]$/', $key, $matches)) {
            $locale = $matches[1];
            $field = $matches[2];

            $translationData[$locale][$field] = $value;
        }
    }

    if (!empty($translationData)) {
        $translationTable = Str::singular($table) . '_translations';
        $foreignKey = Str::singular($table) . '_id';

        foreach ($translationData as $locale => $fields) {
            // Add required fields
            $fields[$foreignKey] = $itemId;
            $fields['locale'] = $locale;

            // Check if translation exists
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

    return response()->json([
        'success' => true,
        'message' => $itemId ? 'Record updated successfully.' : 'Record inserted successfully.',
        'data' => $data,
        'id' => $itemId
    ]);
}







public function showEditCreate($dbname,$table, $itemId = null)
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



  

    // Step 1: Base table columns
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

    // Step 2: Add virtual image fields
    $columns[] = [
        "COLUMN_NAME" => "image",
        "DATA_TYPE" => "image",
        "IS_NULLABLE" => true,
    ];
    $columns[] = [
        "COLUMN_NAME" => "images",
        "DATA_TYPE" => "multimages",
        "IS_NULLABLE" => true,
    ];


        $relatedOptions = [];

        foreach ($columns as $col) {
            $colName = $col['COLUMN_NAME'];

            if (Str::endsWith($colName, '_id')) {
                $baseTable = Str::plural(Str::beforeLast($colName, '_id'));
                $singular = Str::singular($baseTable);
                $translationTable = "{$singular}_translations";

                if (!Schema::connection('dynamic')->hasTable($baseTable)) {
                    continue;
                }

                $mainColumns = Schema::connection('dynamic')->getColumnListing($baseTable);

                // Try to find a label column in the main table
                $labelColumn = collect(['fullname', 'name', 'title', 'username','id'])
                    ->first(fn($field) => in_array($field, $mainColumns));

                // If a valid label column is found in the main table
                if ($labelColumn) {
                    $relatedData = DB::connection('dynamic')->table($baseTable)
                        ->select('id', DB::raw("`$labelColumn` as label"))
                        ->get();
                }

                // Check in translations table if main table has no label column
                elseif (Schema::connection('dynamic')->hasTable($translationTable)) {
                    $translationColumns = Schema::connection('dynamic')->getColumnListing($translationTable);

                    $translationLabel = collect(['title', 'name', 'fullname','id'])->first(function ($field) use ($translationColumns) {
                        return in_array($field, $translationColumns);
                    });

                    if ($translationLabel) {
                        $relatedData = DB::connection('dynamic')->table($baseTable)
                            ->leftJoin($translationTable, "{$translationTable}.{$singular}_id", '=', "{$baseTable}.id")
                            ->where("{$translationTable}.locale", 'en')
                            ->select("{$baseTable}.id", "{$translationTable}.{$translationLabel} as label")
                            ->get();
                    } else {
                        // Fallback: Use just ID as label
                        $relatedData = DB::connection('dynamic')->table($baseTable)
                            ->selectRaw("id, CONCAT('ID: ', id) as label")
                            ->get();
                    }
                } 
                // If no label column in either, fallback to ID
                else {
                    $relatedData = DB::connection('dynamic')->table($baseTable)
                        ->selectRaw("id, CONCAT('ID: ', id) as label")
                        ->get();
                }

                $relatedOptions[$colName] = $relatedData;
            }
        }

    // ✅ Step 3: Skip data fetch if $itemId is null, "undefined", or not numeric
    if (!$itemId || $itemId === "undefined" || !is_numeric($itemId)) {
        return response()->json([
            'success' => trans('general.sent_successfully'),
            'columns' => $columns,
            'related' => $relatedOptions, // ✅ send related options to the frontend

            'data' => [],
        ]);
    }

    // Step 4: Get main record
    $data = DB::connection('dynamic')->table($table)->where('id', $itemId)->first();

    if (!$data) {
        return response()->json(['error' => 'Not found'], 404);
    }

    $data = (array) $data;
    $data["image"] = "https://via.placeholder.com/150";
    $data["images"] = [
        "https://via.placeholder.com/150",
        "https://via.placeholder.com/140"
    ];

    // Step 5: Handle translations
    $translationTable = Str::singular($table) . '_translations';

    if (Schema::connection('dynamic')->hasTable($translationTable)) {
        $transColumns = DB::connection('dynamic')->select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
        ", [$dbName, $translationTable]);

        $foreignKey = Str::singular($table) . '_id';

        $transColumns = collect($transColumns)->pluck('COLUMN_NAME')
            ->reject(fn($col) => in_array($col, ['id', 'locale', $foreignKey, 'created_at', 'updated_at', 'deleted_at']))
            ->values()
            ->toArray();

        $translations = DB::connection('dynamic')->table($translationTable)
            ->where($foreignKey, $itemId)
            ->get();

        foreach ($translations as $translation) {
            foreach ($transColumns as $col) {
                $key = "{$translation->locale}[$col]";
                $data[$key] = $translation->$col;
            }

            foreach ($transColumns as $col) {
                $columns[] = [
                    "COLUMN_NAME" => "{$translation->locale}[$col]",
                    "DATA_TYPE" => "text",
                    "IS_NULLABLE" => true,
                ];
            }
        }
    }





    return response()->json([
        'success' => trans('general.sent_successfully'),
        'columns' => $columns,
        'related' => $relatedOptions, // ✅ send related options to the frontend
        'data' => [$data],
    ]);
}



public function deleteItem($dbname,$table, $itemId)
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


            public function index($dbname,$table)
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

                // 1. Get base columns
            $columns = DB::connection('dynamic')->select("
                SELECT COLUMN_NAME, DATA_TYPE
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
            ", [$dbname, $table]);

            $columns = collect($columns)->map(fn($col) => (array)$col)->toArray();

            // 2. Translation handling
            $translationTable = Str::singular($table) . '_translations';
            $locale = request('locale', 'en');

            $translationExists = Schema::connection('dynamic')->hasTable($translationTable);

            $translatedSelects = [];

            if ($translationExists) {
                $translationColumns = DB::connection('dynamic')->select("
                    SELECT COLUMN_NAME, DATA_TYPE
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
                ", [$dbname, $translationTable]);

                $excluded = ['id', Str::singular($table) . '_id', 'locale', 'created_at', 'updated_at', 'deleted_at'];

                $filtered = collect($translationColumns)
                    ->map(fn($col) => (array)$col)
                    ->filter(fn($col) => !in_array($col['COLUMN_NAME'], $excluded))
                    ->toArray();

                // Append simplified translation columns to columns array
                foreach ($filtered as $col) {
                    $columns[] = [
                        'COLUMN_NAME' => $col['COLUMN_NAME'], // ✅ no prefix
                        'DATA_TYPE' => $col['DATA_TYPE'],
                    ];

                    // Select as alias
                    $translatedSelects[] = "$translationTable.{$col['COLUMN_NAME']} as {$col['COLUMN_NAME']}";
                }
            }

            // 3. Add image column
            $columns[] = [
                "COLUMN_NAME" => "image",
                "DATA_TYPE" => "image",
            ];

            // 4. Build query
            $dataQuery = DB::connection('dynamic')->table($table)->select($table . '.*');

            if ($translationExists) {
                $dataQuery->leftJoin($translationTable, "$translationTable." . Str::singular($table) . "_id", '=', "$table.id")
                        ->where("$translationTable.locale", $locale);

                $dataQuery->addSelect($translatedSelects);
            }

            // 5. Filters
            foreach (request()->query() as $key => $value) {
                if (!in_array($key, ['page'])) {
                    $dataQuery->where($key, 'like', '%' . $value . '%');
                }
            }

            // 6. Pagination
            $paginated = $dataQuery->paginate(10);

            // 7. Add image to each row
            $paginated->getCollection()->transform(function ($item) {
                $row = (array) $item;
                $row['image'] = settings()->logo;
                return (object) $row;
            });

            // 8. Return response
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

                    // Step 3: Try to get blocked tables, or default to empty collection
                    try {
                        $blockedTables = DB::connection('dynamic')->table('blocked_modules')->pluck('table_name');
                    } catch (\Exception $e) {
                        // Table probably doesn't exist — ignore and assume no blocked tables
                        $blockedTables = collect();
                    }

                    // Step 4: Filter tables
                    $filteredTables = $allTables
                        ->diff($blockedTables)
                        ->reject(function ($table) {
                            return str_contains($table, '_translation');
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
