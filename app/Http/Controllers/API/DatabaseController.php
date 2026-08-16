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
use App\Models\Command;
use App\Models\Note;
use App\Models\Admin;
use App\Models\Deadline;
use App\Models\Category;
use App\Models\Search;
use App\Models\Video;
use App\Models\Navigation;
use App\Models\Clienttrack;
use App\Models\Task;
use App\Models\DBCredential;
use App\Models\Difference;
use Spatie\Permission\Models\Role;


use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{


        // ✅ Static function inside controller
    public static function setDynamicConnection($dbname,$credentialId=null)
    {
        if (App::environment('local')) {
            $dbHost = 'localhost';
            $dbName = $dbname ?? 'webapp';
            $dbUser = 'root';
            $dbPass = '';
        } else {
            if(isset($credentialId)){
                $credential = DBCredential::find($credentialId);
                $dbHost = $credential->db_host ?? 'localhost';
                $dbName = $credential->db_name ?? 'u112116784_workspace';
                $dbUser = $credential->db_username ?? 'u112116784_workspace';
                $dbPass = $credential->db_password ?? 'AM*Wo8owc^7';
            }else{
                //Here if outer system like erp and you copied code there
                $dbHost =  'localhost';
                $dbName =  'laravel';
                $dbUser =  'root';
                $dbPass =  '';
            }
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
    }

private function extractTableFromSelect(string $sql): ?string
{
    if (preg_match('/from\s+`?([a-zA-Z0-9_]+)`?/i', $sql, $matches)) {
        return $matches[1];
    }
    return null;
}


    public function execQuery(Request $request)
    {

        DB::beginTransaction(); // Start transaction

        try {
            
            // Call the static method
            self::setDynamicConnection($request->database_name,$request->credential_id);

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

        DB::connection('dynamic')->statement('use ' . $request->database_name);

        $normalizedQuery = preg_replace(
            '/\s+/',
            ' ',
            strtolower(trim($queryCommand, "; \t\n\r\0\x0B"))
        );

        // ---------- SELECT ----------
    $suggestions = [];
    if (str_starts_with($normalizedQuery, 'select')) {

    $data = DB::connection('dynamic')->select($queryCommand);

    $cleanedData = array_map(function ($row) {
        $row = (array) $row;
        ksort($row);
        return $row;
    }, $data);

    // 🔥 Extract table name
    $tableName = $this->extractTableFromSelect($queryCommand);

    // 🔥 Get columns ONLY if table exists
    if ($tableName && Schema::connection('dynamic')->hasTable($tableName)) {
        $columns = Schema::connection('dynamic')->getColumnListing($tableName);
        // ✅ sort alphabetically
        sort($columns);
        // clean + quote columns (optional)
        $suggestions = array_map(fn ($c) => $c, $columns);
    }

    // 🔹 Empty result fallback
    if (empty($cleanedData) && isset($columns)) {
        $cleanedData = [array_fill_keys($columns, null)];
    }

    $finalResult[] = [
        'query'  => $queryCommand,
        'count'  => count($data),
        'result' => $cleanedData,
    ];

    continue;
}

    // ---------- UPDATE ----------
    if (str_starts_with($normalizedQuery, 'select')) {

        $data = DB::connection('dynamic')->select($queryCommand);

        $cleanedData = array_map(function ($row) {
            $row = (array) $row;

            foreach (['ai_prompt', 'script', 'dispatch_status'] as $field) {
                if (isset($row[$field])) {
                    $row[$field] = trim(preg_replace('/\s+/', ' ', $row[$field]));
                }
            }

            ksort($row);
            return $row;
        }, $data);

        // 🔹 IF EMPTY RESULT → return one NULL row with all columns
        if (empty($cleanedData)) {

            $tableName = $this->extractTableFromSelect($queryCommand);

            if ($tableName && Schema::connection('dynamic')->hasTable($tableName)) {
                $columns = Schema::connection('dynamic')->getColumnListing($tableName);

                $nullRow = array_fill_keys($columns, null);
                $cleanedData = [$nullRow];
            }
        }

        $finalResult[] = [
            'query'  => $queryCommand,
            'count'  => count($data), // real DB count (0 if empty)
            'result' => $cleanedData,
        ];

        continue;
    }

    // ---------- DELETE ----------
    if (str_starts_with($normalizedQuery, 'delete')) {

        $affected = DB::connection('dynamic')->delete($queryCommand);

        $finalResult[] = [
            'query' => $queryCommand,
            'count' => $affected,
        ];

        continue;
    }

    // ---------- INSERT / CREATE ----------
    if (str_starts_with($normalizedQuery, 'insert')) {

        DB::connection('dynamic')->statement($queryCommand);

        // MySQL has no reliable affected rows for raw INSERT
        $finalResult[] = [
            'query' => $queryCommand,
            'count' => 1, // best possible signal for "executed"
        ];

        continue;
    }

    // ---------- SHOW ----------
    if (str_starts_with($normalizedQuery, 'show')) {

        $data = DB::connection('dynamic')->select($queryCommand);

        $cleanedData = array_map(function ($row) {
            $row = (array) $row;
            ksort($row);
            return $row;
        }, $data);

        $finalResult[] = [
            'query'  => $queryCommand,
            'count'  => count($data),
            'result' => $cleanedData,
        ];

        continue;
    }
    // ---------- DESC ----------
    if (str_starts_with($normalizedQuery, 'desc')) {

        $data = DB::connection('dynamic')->select($queryCommand);

        $cleanedData = array_map(function ($row) {
            $row = (array) $row;
            ksort($row);
            return $row;
        }, $data);

        $finalResult[] = [
            'query'  => $queryCommand,
            'count'  => count($data),
            'result' => $cleanedData,
        ];

        continue;
    }

    // ---------- FALLBACK ----------
    DB::connection('dynamic')->statement($queryCommand);

    $finalResult[] = [
        'query' => $queryCommand,
        'count' => 0,
    ];
    }

            DB::commit(); // Commit transaction if everything is fine

            return response()->json([
                'success' => "Done Successfully",
                 'data' => $finalResult,
                  'suggestions' => array_values($suggestions ?? []),

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
                [
                    'd_b_credential_id' => $request->credential_id,
                    'updated_at' => now()
                ]
            );
            $fixed = Query::where('isFixed', 1)->get();

            $all = Query::latest('updated_at')
                ->take(50)
                ->get();

            $queries = $all->merge($fixed);



            DB::commit(); // Commit transaction if everything0 is fine

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

public function saveSearch(Request $request)
{
    DB::beginTransaction();

    try {
        
        // Use updateOrCreate with the correct combination of unique fields
        Search::updateOrCreate(
            [
                'title' => $request->search_term,
                'd_b_credential_id' => $request->d_b_credential_id
            ],
            [
                'updated_at' => now() // Explicitly set updated_at
            ]
        );

        // Get searches for this credential, ordered by updated_at DESC (newest first)
        $searches = Search::where('d_b_credential_id', $request->d_b_credential_id)
            ->orderBy('updated_at', 'DESC')
            ->take(50)
            ->get();

        DB::commit();

        return response()->json([
            'success' => "Done Successfully",
            'searches' => $searches,
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ]);
    }
}


    public function deleteSearch($id)
{
    try {
        $search = Search::find($id);
        
        if (!$search) {
            return response()->json([
                'success' => false,
                'error' => 'Search not found'
            ], 404);
        }
        
        // Optional: Check if the search belongs to the current user
        // if ($search->user_id !== auth()->id()) {
        //     return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        // }
        
        $search->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Search deleted successfully'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}

public function getDatabase($dbname, $namedb)
{
    try {
        // Call the static method
        self::setDynamicConnection($namedb, $dbname);

        $tables = DB::connection('dynamic')->select("SHOW TABLES");
        $results = [];
        $latestOverallDate = null;
        
        // Array to store all ID columns and their tables
        $idColumns = [];

        foreach ($tables as $t) {
            $tableName = array_values((array)$t)[0];

            // Detect VIEW or BASE TABLE
            $isView = DB::connection('dynamic')->selectOne("
                    SELECT TABLE_TYPE 
                    FROM information_schema.tables 
                    WHERE table_schema = ? AND table_name = ?
                ", [$namedb, $tableName]);

            $tableType = $isView->TABLE_TYPE ?? 'BASE TABLE';

            // Row count (skip views)
            if ($tableType === 'VIEW') {
                $rowCount = null;
            } else {
                $rowCount = DB::connection('dynamic')->table($tableName)->count();
            }

            // Get columns - wrap in try-catch to handle invalid views
            try {
                $columns = DB::connection('dynamic')->select("SHOW COLUMNS FROM `$tableName`");
            } catch (\Exception $colException) {
                // Skip invalid views that reference non-existent tables/columns or lack permissions
                if ($tableType === 'VIEW') {
                    continue; // Skip this view entirely
                }
                // For base tables, re-throw the exception
                throw $colException;
            }

            // Get actual foreign key information for this table
            $foreignKeys = DB::connection('dynamic')->select("
                SELECT 
                    COLUMN_NAME,
                    REFERENCED_TABLE_NAME,
                    REFERENCED_COLUMN_NAME
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE 
                    TABLE_SCHEMA = ? 
                    AND TABLE_NAME = ? 
                    AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$namedb, $tableName]);

            // Create a lookup array for quick access
            $fkLookup = [];
            foreach ($foreignKeys as $fk) {
                $fkLookup[$fk->COLUMN_NAME] = $fk->REFERENCED_TABLE_NAME;
            }

            // Find all columns ending with '_id' in this table
            foreach ($columns as $col) {
                if (str_ends_with($col->Field, '_id')) {
                    // Check if this column has an actual foreign key constraint
                    $referencedTable = $fkLookup[$col->Field] ?? null;
                    
                    $idColumns[] = [
                        'column_name' => $col->Field,
                        'table_name' => $tableName,
                        'referenced_table' => $referencedTable, // Will be null if no FK constraint
                        'has_foreign_key_constraint' => $referencedTable !== null,
                        'data_type' => $col->Type,
                        'is_nullable' => $col->Null === 'YES',
                    ];
                }
            }

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
                
                // Add foreign key information if this column has a constraint
                if (isset($fkLookup[$col->Field])) {
                    $col->IS_FOREIGN_KEY = true;
                    $col->REFERENCED_TABLE = $fkLookup[$col->Field];
                } else {
                    $col->IS_FOREIGN_KEY = false;
                    $col->REFERENCED_TABLE = null;
                }
            }

            $results = array_merge($results, $columns);
        }

        // Keep your existing sort logic
        usort($results, function ($a, $b) {
            $nameA = $a->COLUMN_NAME ?? ($a->Field ?? 'AM*Wo8owc^7');
            $nameB = $b->COLUMN_NAME ?? ($b->Field ?? 'AM*Wo8owc^7');
            return strcmp($nameA, $nameB);
        });

        // Group ID columns by their referenced table (only those with actual FK constraints)
        $groupedIdColumns = [];
        foreach ($idColumns as $idCol) {
            // Only include columns that have actual foreign key constraints
            if ($idCol['has_foreign_key_constraint']) {
                $referencedTable = $idCol['referenced_table'];
                if (!isset($groupedIdColumns[$referencedTable])) {
                    $groupedIdColumns[$referencedTable] = [];
                }
                $groupedIdColumns[$referencedTable][] = $idCol;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $results,
            'latest_overall_date' => $latestOverallDate,
            "ls_command" => settings()->ls_command,
            // ID columns information with actual database reference info
            'id_columns' => $idColumns,
            'grouped_id_columns' => $groupedIdColumns, // Grouped by referenced table (only actual FKs)
            'id_columns_summary' => [
                'total_count' => count($idColumns),
                'with_foreign_key_constraints' => count(array_filter($idColumns, function($col) {
                    return $col['has_foreign_key_constraint'];
                })),
                'without_constraints' => count(array_filter($idColumns, function($col) {
                    return !$col['has_foreign_key_constraint'];
                })),
                'by_referenced_table' => array_map(function($group) {
                    return count($group);
                }, $groupedIdColumns)
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to load database info: ' . $e->getMessage(),
        ], 500);
    }
}




public function getQueries($id = null)
{
    try {

        $fixed = Query::where('d_b_credential_id', $id)
            ->where('isFixed', 1)
            ->get();

        $all = Query::where('d_b_credential_id', $id)
            ->latest('updated_at')
            ->take(50)
            ->get();

        $queries = $all->merge($fixed)->unique('id')->values();

        $credentials = DBCredential::with('project:id,d_b_credential_id')->get();

        return response()->json([
            'success' => true,
            'queries' => $queries,
            'credentials' => $credentials,
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ]);
    }
}
    public function getSearches($id = null)
    {
        try {

            $fixed = Search::where("d_b_credential_id", $id)
                ->where('isFixed', 1)
                ->get();

            $all = Search::where("d_b_credential_id", $id)
                ->latest('updated_at')
                ->take(50)
                ->get();

            $searches = $all->merge($fixed)->unique('id')->values();

            return response()->json([
                'success' => true,
                'searches' => $searches,
                'credentials' => DBCredential::all(),
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

        public function getCommands($id = null)
    {
        try {


            $commands = Command::where("d_b_credential_id", $id)->orWhere("isGeneral", 1)
                ->latest('updated_at')
                ->take(50)
                ->get();


            return response()->json([
                'success' => true,
                'commands' => $commands,
                'credentials' => DBCredential::all(),
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }


/**
 * Save a database difference record to the main database
 */
public function storeDifference(Request $request)
{
    DB::beginTransaction();

    try {
        $difference = Difference::create([
            'd_b_credential_id' => $request->credential_id,
            'diff_db' => $request->diff_text,
        ]);

        
        DBCredential::where('id', $request->credential_id)->update([
            'last_snapshot' => $request->last_snapshot,
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Difference saved successfully',
            'data' => $difference,
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ]);
    }
}

/**
 * Get all differences for a credential
 */
public function getDifferences(Request $request)
{
    try {
        $credential_id = $request->query('credential_id');
        $search = trim((string) $request->query('search', ''));
        $perPage = (int) $request->query('per_page', 10);
        if ($perPage <= 0) {
            $perPage = 10;
        }

        $query = Difference::query()->orderBy('created_at', 'desc');

        if ($credential_id) {
            $query->where('d_b_credential_id', $credential_id);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('diff_db', 'like', "%{$search}%")
                  ->orWhere('diff_text', 'like', "%{$search}%");
            });
        }

        // Laravel reads the "page" query param automatically
        $paginator = $query->paginate($perPage);

        $last_snapshot = $credential_id
            ? DBCredential::where('id', $credential_id)->value('last_snapshot')
            : null;

        return response()->json([
            'success' => true,
            'differences' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
            ],
            'last_snapshot' => $last_snapshot,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
}




}