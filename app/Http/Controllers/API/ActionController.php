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
class ActionController extends Controller
{
    public function postFunction(Request $request)
    {
        try {
            $action = request()->query('action');
            if ($action == "contactus") {
                $request->validate([
                    'message' => 'required',
                ]);
                $data = Message::create($request->except('action'));
            }
            if ($action == "searchHotels") {
              dd($request->all());
            }
            return successResponse($data);
        } catch (Exception $e) {
            DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode([$e->getMessage()]),
                'created_at' => now(),
            ]);
            return failedResponse($e->getMessage());
        }
    }

public function getFunction(Request $request)
{
    try {
        $action = request()->query('action');
        if ($action == "getNotifications") {
            $notifications = []; // one single string
            $boardProjects = Project::get();
            $deadlines = Deadline::where("status",0)->latest()->get();
            $moneyProjects = $boardProjects->filter(function ($project) {
                return $project->status == 2 && $project->cost > 0;
            });
            $deadlineProjects =Project::orderBy("deadline","asc")
                    ->get()
                    ->filter(fn($project) => $project->status == 1) ;

            $dealProjects =Project::where('deal',0)->get();

            $renewProjects = Project::whereNotNull('renewalDate')
                ->orderBy('renewalDate', 'asc')->whereDate('renewalDate', '<=', Carbon::now()->addWeek())
                ->get();

            $tasks = Task::where("status",0)->latest()->get();
            
            if ($tasks->isNotEmpty()) {
                foreach ($tasks as $task) {
                    $notifications[] = $task->title;
                }
            }

            if ($moneyProjects->isNotEmpty()) {
                foreach ($moneyProjects as $project) {
                    $notifications[] = $project->title . " with " . rest($project);
                }
            }


            if ($dealProjects->isNotEmpty() && boula()) {
                foreach ($dealProjects as $project) {
                    $notifications[] = $project->title . " deal not closed yet";
                }
            }

            if ($renewProjects->isNotEmpty() && boula()) {
                foreach ($renewProjects as $project) {
                    $renewalDate = Carbon::parse($project->renewalDate)->format('Y-m-d');
                    $notifications[] = $project->title . " renewal on " . $renewalDate;
                }
            }

            if ($deadlineProjects->isNotEmpty() && boula()) {
                foreach ($deadlineProjects as $project) {
                    $deadline = Carbon::parse($project->deadline)->format('Y-m-d');
                    $notifications[] = $project->title . " due on " . $deadline;
                }
            }
            if ($deadlines->isNotEmpty() && boula()) {
                foreach ($deadlines as $deadline) {
                    $notifications[] = $deadline->title . " due on " . $deadline->date;
                }
            }


            // Final output: ONE notification string
            if(boula()){
                $notifications[] = "Yousab Tech + LapMob Ecommerce + Fixed Salary Programming Job";
                $notifications[]="Your role is Marketting + Project Mangement";
            }

            // Shuffle notifications to randomize order
            shuffle($notifications);
            
            $data["notifications"] = $notifications;
            $data["period"] = settings()->period;
        }

        return successResponse($data);

    } catch (Exception $e) {
        DB::table('tracks')->insert([
            'dispatch_status' => 'showing data of ' . json_encode([$e->getMessage()]),
            'created_at' => now(),
        ]);
        return failedResponse($e->getMessage());
    }
}


public function show($table, $itemId)
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


public function table($table)
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
