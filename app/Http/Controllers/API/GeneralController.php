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
use Carbon\Carbon;
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
    // Retrieve table columns and their data types
    $columns = DB::select("
        SELECT COLUMN_NAME, DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
    ", ["webapp", $table]);

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
        SELECT * FROM {$table} WHERE id = ?
    ", [$itemId]);

    // Convert data to array and add the fake "image" field
    $data = collect($data)->map(function ($item) {
        $row = (array) $item;
        $row["image"] = "https://via.placeholder.com/150"; // ✅ Example image link
        $row["images"] = ["https://via.placeholder.com/150","https://via.placeholder.com/140"]; // ✅ Example images links
        return $row;
    })->toArray();

    return response()->json([
        'success' => trans('general.sent_successfully'),
        'columns' => $columns,
        'data' => $data,
    ]);
}
public function deleteItem($table, $itemId)
{
    // Retrieve table columns and their data types
    $columns = DB::select("
        SELECT COLUMN_NAME, DATA_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;
    ", ["webapp", $table]);

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
    ", ["webapp", $table]);

    // Convert columns to array (for easy manipulation)
    $columns = collect($columns)->map(function ($col) {
        return (array) $col;
    })->toArray();

        // ✅ Add an extra "image" column manually
    $columns[] = [
        "COLUMN_NAME" => "image",
        "DATA_TYPE" => "image",
    ];



    // Retrieve record data
    $data = DB::select("SELECT * FROM {$table}");


        // Convert data to array and add the fake "image" field
    $data = collect($data)->map(function ($item) {
        $row = (array) $item;
        $row["image"] = settings()->logo; // ✅ Example image link
        return $row;
    })->toArray();


    return response()->json([
        'success' => trans('general.sent_successfully'),
        'columns' => $columns,
        'data' => $data,
    ]);
}


public function tableNames()
{
   

      $tables = DB::select("select distinct  TABLE_NAME from INFORMATION_SCHEMA. COLUMNS where table_schema = '" . "webapp" . "' order by TABLE_NAME;");

          return response()->json([
        'success' => trans('general.sent_successfully'),
        'tables' => $tables,
    ]);
    

}



}
