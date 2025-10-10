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

use Carbon\Carbon;
use Illuminate\Support\Str;
class GeneralController extends Controller
{
  

public function storeUpdate(Request $request, $table, $itemId = null)
{
 
    // Get table columns from the database
    $columns = DB::select("
        SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = ?;
    ", [$table]);

    // Convert to array of column names
    $columnNames = collect($columns)->pluck('COLUMN_NAME')->toArray();

    // Columns to exclude (e.g., auto-increment ID, timestamps)
    $exclude = ['id', 'created_at', 'updated_at'];

    // Build insert/update data dynamically
    $data = [];

    foreach ($columnNames as $column) {
        if (in_array($column, $exclude)) {
            continue;
        }

        // Handle special columns like image or images
        if ($column === 'image') {
            if ($request->hasFile('image')) {
                $data[$column] = $request->file('image')->store('uploads', 'public');
            } elseif (!$itemId) {
                $data[$column] = null; // For insert, ensure image column is not skipped
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

    // Check if updating or inserting
    if ($itemId && $itemId!="undefined") {
        // Update
        DB::table($table)->where('id', $itemId)->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Record updated successfully.',
            'data' => $data
        ]);
    } else {
        // Insert
        $newId = DB::table($table)->insertGetId($data);

        return response()->json([
            'success' => true,
            'message' => 'Record inserted successfully.',
            'data' => $data,
            'id' => $newId
        ]);
    }
}






public function showEditCreate($table, $itemId = null)
{
    $db = env('DB_DATABASE');

    // Step 1: Base table columns
    $columns = DB::select("
        SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
    ", [$db, $table]);

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

                if (!Schema::hasTable($baseTable)) {
                    continue;
                }

                $mainColumns = Schema::getColumnListing($baseTable);

                // Try to find a label column in the main table
                $labelColumn = collect(['title', 'name', 'fullname'])->first(function ($field) use ($mainColumns) {
                    return in_array($field, $mainColumns);
                });

                if ($labelColumn) {
                    $relatedData = DB::table($baseTable)
                        ->select('id', DB::raw("$labelColumn as label"))
                        ->get();
                } 

                // Check in translations table if main table has no label column
                elseif (Schema::hasTable($translationTable)) {
                    $translationColumns = Schema::getColumnListing($translationTable);

                    $translationLabel = collect(['title', 'name', 'fullname'])->first(function ($field) use ($translationColumns) {
                        return in_array($field, $translationColumns);
                    });

                    if ($translationLabel) {
                        $relatedData = DB::table($baseTable)
                            ->leftJoin($translationTable, "{$translationTable}.{$singular}_id", '=', "{$baseTable}.id")
                            ->where("{$translationTable}.locale", 'en')
                            ->select("{$baseTable}.id", "{$translationTable}.{$translationLabel} as label")
                            ->get();
                    } else {
                        // Fallback: Use just ID as label
                        $relatedData = DB::table($baseTable)
                            ->selectRaw("id, CONCAT('ID: ', id) as label")
                            ->get();
                    }
                } 
                // If no label column in either, fallback to ID
                else {
                    $relatedData = DB::table($baseTable)
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
    $data = DB::table($table)->where('id', $itemId)->first();

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

    if (Schema::hasTable($translationTable)) {
        $transColumns = DB::select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
        ", [$db, $translationTable]);

        $foreignKey = Str::singular($table) . '_id';

        $transColumns = collect($transColumns)->pluck('COLUMN_NAME')
            ->reject(fn($col) => in_array($col, ['id', 'locale', $foreignKey, 'created_at', 'updated_at', 'deleted_at']))
            ->values()
            ->toArray();

        $translations = DB::table($translationTable)
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



public function deleteItem($table, $itemId)
{
    // Retrieve table columns and their data types
    $columns = DB::select("
        SELECT COLUMN_NAME, DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
    ", [env('DB_DATABASE'), $table]);

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
    $data = DB::select("
        delete FROM {$table} WHERE id = ?
    ", [$itemId]);



    return response()->json([
        'success' => trans('general.sent_successfully'),
        'columns' => $columns,
        'data' => $data,
    ]);
}


            public function index($table)
            {
                // 1. Get base columns
            $columns = DB::select("
                SELECT COLUMN_NAME, DATA_TYPE
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
            ", [env('DB_DATABASE'), $table]);

            $columns = collect($columns)->map(fn($col) => (array)$col)->toArray();

            // 2. Translation handling
            $translationTable = Str::singular($table) . '_translations';
            $locale = request('locale', 'en');

            $translationExists = Schema::hasTable($translationTable);

            $translatedSelects = [];

            if ($translationExists) {
                $translationColumns = DB::select("
                    SELECT COLUMN_NAME, DATA_TYPE
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
                ", [env('DB_DATABASE'), $translationTable]);

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
            $dataQuery = DB::table($table)->select($table . '.*');

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




public function tableNames()
{
    // Step 1: Get all table names in the schema
    $allTables = DB::table('INFORMATION_SCHEMA.COLUMNS')
        ->select('TABLE_NAME')
        ->where('TABLE_SCHEMA', env('DB_DATABASE'))
        ->distinct()
        ->orderBy('TABLE_NAME')
        ->pluck('TABLE_NAME'); // Returns collection of strings

    // Step 2: Get blocked table names from blocked_modules table
    $blockedTables = DB::table('blocked_modules')->pluck('table_name');

    // Step 3: Exclude blocked tables
    $filteredTables = $allTables
        ->diff($blockedTables) // Remove blocked tables
        ->reject(function ($table) {
            return str_contains($table, '_translation'); // Remove *_translation tables
        })
        ->values(); // Re-index the collection

    // Step 4: Map to desired structure: [{ TABLE_NAME: '...' }]
    $structuredTables = $filteredTables->map(function ($table) {
        return ['TABLE_NAME' => $table];
    });

    return response()->json([
        'success' => trans('general.sent_successfully'),
        'tables' => $structuredTables,
    ]);
}





}
