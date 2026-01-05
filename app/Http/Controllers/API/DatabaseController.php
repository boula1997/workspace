<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\TaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\NavigationResource;
use App\Http\Resources\IssueResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Query;
use App\Models\Fee;
use App\Models\Note;
use App\Models\Admin;
use App\Models\Deadline;
use App\Models\Category;
use App\Models\Video;
use App\Models\Navigation;
use App\Models\Clienttrack;
use App\Models\Task;
use App\Models\DBCredential;
use Spatie\Permission\Models\Role;

use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;


class DatabaseController extends Controller
{




    public function execQuery(Request $request)
    {

        DB::beginTransaction(); // Start transaction

        try {


            if (App::environment('local')) {
                $dbHost =  'localhost';
                $dbName = $request->database_name;
                $dbUser = 'root';
                $dbPass = '';
            } else {

                $credential = DBCredential::where('id', $request->credential_id)->first();

                $dbHost = isset($credential->db_host) ? $credential->db_host : 'localhost';
                $dbName = isset($credential->db_name) ? $credential->db_name : 'laravel';
                $dbUser = isset($credential->db_username) ? $credential->db_username : 'root';
                $dbPass = isset($credential->db_password) ? $credential->db_password : '';
            }


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

            $queryCommands = explode('++', $request->title);
            $finalResult = [];


            foreach ($queryCommands as $queryCommand) {
                // Normalize query: remove extra whitespace and lowercase for case-insensitive matching
                $normalizedQuery = preg_replace('/\s+/', ' ', strtolower(trim($queryCommand, "; \t\n\r\0\x0B")));

                if (str_starts_with($normalizedQuery, 'update') && strpos($normalizedQuery, 'where') === false) {
                    return response()->json([
                        'success' => "Done Successfully",
                        'data' => "Add condition",
                    ]);
                }
            }

            foreach ($queryCommands as $queryCommand) {



                DB::connection('dynamic')->statement('use ' . $dbName);
                $data = DB::connection('dynamic')->select($queryCommand);

                $cleanedData = array_map(function ($row) {
                    $row = (array) $row; // Ensure it's an array, not stdClass

                    if (isset($row['codeLinks'])) {
                        $row['codeLinks'] = preg_replace('/\s+/', ' ', $row['codeLinks']);
                        $row['codeLinks'] = trim($row['codeLinks']);
                    }
                    if (isset($row['script'])) {
                        $row['script'] = preg_replace('/\s+/', ' ', $row['script']);
                        $row['script'] = trim($row['script']);
                    }
                    if (isset($row['dispatch_status'])) {
                        $row['dispatch_status'] = preg_replace('/\s+/', ' ', $row['dispatch_status']);
                        $row['dispatch_status'] = trim($row['dispatch_status']);
                    }

                    // 🔥 SORT COLUMNS A → Z
                    ksort($row);

                    return $row;
                }, $data);


                $finalResult[] = [
                    'query' => $queryCommand,
                    'result' => $cleanedData,
                ];
            }

            DB::commit(); // Commit transaction if everything is fine

            return response()->json([
                'success' => "Done Successfully",
                'data' => $finalResult,
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if something goes wrong


            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => $e->getMessage(),
            ]);
        }
    }


    public function saveQuery(Request $request)
    {

        DB::beginTransaction(); // Start transaction

        try {



            $query = Query::updateOrCreate(
                ['title' => $request->title],
                ['updated_at' => now()]
            );
            $queries = Query::latest("updated_at")->get();



            DB::commit(); // Commit transaction if everything is fine

            return response()->json([
                'success' => "Done Successfully",
                'queries' => $queries,

            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if something goes wrong


            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => $e->getMessage(),
            ]);
        }
    }


  public function getDatabase($dbname, $namedb)
    {

        try {

            if (App::environment('local')) {
                $dbHost = 'localhost';
                $dbName = $namedb;
                $dbUser = 'root';
                $dbPass = '';
            } else {

                $credential = DBCredential::where('id', $dbname)->first();

                $dbHost = $credential->db_host ?? 'localhost';
                $dbName = $credential->db_name ?? 'laravel';
                $dbUser = $credential->db_username ?? 'root';
                $dbPass = $credential->db_password ?? '';
            }

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

            $tables = DB::connection('dynamic')->select("SHOW TABLES");
            $results = [];
           $latestOverallDate = null;


            foreach ($tables as $t) {

                $tableName = array_values((array)$t)[0];

                // Detect VIEW or BASE TABLE
                $isView = DB::connection('dynamic')->selectOne("
                        SELECT TABLE_TYPE 
                        FROM information_schema.tables 
                        WHERE table_schema = ? AND table_name = ?
                    ", [$dbName, $tableName]);

                $tableType = $isView->TABLE_TYPE ?? 'BASE TABLE';

                // Row count (skip views)
                if ($tableType === 'VIEW') {
                    $rowCount = null;
                } else {
                    $rowCount = DB::connection('dynamic')->table($tableName)->count();
                }

                // Get columns
                $columns = DB::connection('dynamic')->select("SHOW COLUMNS FROM `$tableName`");

                // Detect timestamp columns
                $hasCreatedAt = false;
                $hasUpdatedAt = false;

                foreach ($columns as $c) {
                    if ($c->Field === 'created_at') $hasCreatedAt = true;
                    if ($c->Field === 'updated_at') $hasUpdatedAt = true;
                }

                // Defaults
                $latestCreatedAt = null;
                $latestUpdatedAt = null;
                $latestCreatedAtCount = null;
                $latestUpdatedAtCount = null;

                // Get latest timestamps only if columns exist and not a view
                if ($tableType !== 'VIEW' && ($hasCreatedAt || $hasUpdatedAt)) {

                    $selects = [];

                    if ($hasCreatedAt) {
                        $selects[] = 'MAX(created_at) as latest_created_at';
                    }
                    if ($hasUpdatedAt) {
                        $selects[] = 'MAX(updated_at) as latest_updated_at';
                    }

                    $dates = DB::connection('dynamic')
                        ->table($tableName)
                        ->selectRaw(implode(', ', $selects))
                        ->first();

                    $latestCreatedAt = $dates->latest_created_at ?? null;
                    $latestUpdatedAt = $dates->latest_updated_at ?? null;

                foreach ([$latestCreatedAt, $latestUpdatedAt] as $dt) {
                    if ($dt) {
                        if (!$latestOverallDate || Carbon::parse($dt)->gt(Carbon::parse($latestOverallDate))) {
                            $latestOverallDate = $dt;
                        }
                    }
                }

                    // Count rows sharing the same timestamps
                    if ($hasCreatedAt && $latestCreatedAt) {
                        $latestCreatedAtCarbon = Carbon::parse($latestCreatedAt);

                        // ±1 minute window
                        $start = $latestCreatedAtCarbon->copy()->subMinute();
                        $end   = $latestCreatedAtCarbon->copy()->addMinute();

                        $latestCreatedAtCount = DB::connection('dynamic')
                            ->table($tableName)
                            ->whereBetween('created_at', [$start, $end])
                            ->count();

                    }

                    if ($hasUpdatedAt && $latestUpdatedAt) {
                    $latestUpdatedAtCarbon = Carbon::parse($latestUpdatedAt);

                    // ±1 minute range
                    $start = $latestUpdatedAtCarbon->copy()->subMinute();
                    $end   = $latestUpdatedAtCarbon->copy()->addMinute();

                    $latestUpdatedAtCount = DB::connection('dynamic')
                        ->table($tableName)
                        ->whereBetween('updated_at', [$start, $end])
                        ->count();
                    }
                }



                // Keep your existing logic and just append new fields
                foreach ($columns as $col) {
                    $col->TABLE_NAME = $tableName;
                    $col->ROW_COUNT = $rowCount;

                    $col->LATEST_CREATED_AT = $latestCreatedAt;
                    $col->LATEST_CREATED_AT_COUNT = $latestCreatedAtCount;

                    $col->LATEST_UPDATED_AT = $latestUpdatedAt;
                    $col->LATEST_UPDATED_AT_COUNT = $latestUpdatedAtCount;
                }


                $results = array_merge($results, $columns);
            }

            // Keep your existing sort logic
            usort($results, function ($a, $b) {
                $nameA = $a->COLUMN_NAME ?? ($a->Field ?? '');
                $nameB = $b->COLUMN_NAME ?? ($b->Field ?? '');
                return strcmp($nameA, $nameB);
            });

            return response()->json([
                'success' => true,
                'data' => $results,
            'latest_overall_date' => $latestOverallDate, // NEW: Latest date in whole DB

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load database info: ' . $e->getMessage(),
            ], 500);
        }
    }




    public function getQueries()
    {
        try {

            $queries = Query::latest("updated_at")->get();
            $credentials = DBCredential::get();

            return response()->json([
                'success' => "Done Successfully",
                'queries' => $queries,
                'credentials' => $credentials,

            ]);
        } catch (\Exception $e) {


            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => $e->getMessage(),
            ]);
        }
    }
}
