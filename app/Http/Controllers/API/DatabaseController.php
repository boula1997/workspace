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
use Illuminate\Support\Facades\DB;


class DatabaseController extends Controller
{




    public function execQuery(Request $request)
    {

        DB::beginTransaction(); // Start transaction

        try {
            $credential = DBCredential::where('id', $request->credential_id)->first();
            $dbHost = isset($credential->db_host) ? $credential->db_host : '192.185.41.219';
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

            $queryCommands = explode('++', $request->title);
            $finalResult = [];

            $query = Query::firstOrCreate(['title' => $request->title]);


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



                DB::connection('dynamic')->statement('use ' . $credential->db_name);
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






public function getDatabase($dbname)
{
    try {

        $credential = DBCredential::find($dbname);
        
        // Configure connection dynamically
        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => isset($credential->db_host) ? $credential->db_host : '192.185.41.219',
                'database' => $credential->db_name,
                'username' => $credential->db_username,
                'password' => $credential->db_password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');


        $tables = DB::connection('dynamic')->select("SHOW TABLES");
        $results = [];

        foreach ($tables as $t) {
            $tableName = array_values((array)$t)[0];
            $columns = DB::connection('dynamic')->select("SHOW COLUMNS FROM `$tableName`");
            foreach ($columns as $col) {
                $col->TABLE_NAME = $tableName;
            }
            $results = array_merge($results, $columns);
        }

        foreach ($columns as $col) {
        $results[] = (object)[
            'TABLE_NAME' => $tableName,
            'COLUMN_NAME' => $col->Field,
            'DATA_TYPE' => $col->Type,
            'IS_NULLABLE' => $col->Null,
            'COLUMN_DEFAULT' => $col->Default,
        ];
        }


        return response()->json([
            'success' => true,
            'data' => $results,
        ]);


    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to load database info: ' . $e->getMessage(),
        ], 500);
    }
}

}
