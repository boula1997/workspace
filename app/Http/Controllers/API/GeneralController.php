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






public function showEditCreate($table, $itemId)
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

    // Step 3: Get main record
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

    // Step 4: Handle translations
    $translationTable = Str::singular($table) . '_translations';

    if (Schema::hasTable($translationTable)) {
        // Get translation fields (excluding system fields)
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
            
                    // Fetch translations
            $translations = DB::table($translationTable)
                ->where($foreignKey, $itemId)
                ->get();

        foreach ($translations as $translation) {
            foreach ($transColumns as $col) {
                $key = "{$translation->locale}[$col]";
                $data[$key] = $translation->$col;
            }

            // Optional: add these translation fields to the columns array
            foreach ($transColumns as $col) {
                $columns[] = [
                    "COLUMN_NAME" => "{$translation->locale}[$col]",
                    "DATA_TYPE" => "text", // or "translatable" if you want to treat it specially in frontend
                    "IS_NULLABLE" => true,
                ];
            }
        }
    }

    return response()->json([
        'success' => trans('general.sent_successfully'),
        'columns' => $columns,
        'data' => [$data], // Send as array to match frontend format
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
    // Retrieve table columns and their data types
    $columns = DB::select("
        SELECT COLUMN_NAME, DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
    ", [env('DB_DATABASE'), $table]);

    $columns = collect($columns)->map(fn($col) => (array)$col)->toArray();

    // Add an extra "image" column manually
    $columns[] = [
        "COLUMN_NAME" => "image",
        "DATA_TYPE" => "image",
    ];

    // Use Laravel's paginate method with 10 items per page
    $dataQuery = DB::table($table);

    // Get current page from request query string (?page=2)
    $perPage = 10;

    $data = $dataQuery->paginate($perPage);

    // Add the fake "image" field to each row
    $data->getCollection()->transform(function ($item) {
        $row = (array) $item;
        $row["image"] = settings()->logo;
        return (object)$row;
    });

    return response()->json([
        'success' => trans('general.sent_successfully'),
        'columns' => $columns,
        'data' => $data->items(),
        'pagination' => [
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
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
