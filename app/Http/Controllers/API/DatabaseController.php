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
use App\Scopes\ActiveScope;


use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Services\SchemaDiffService;
use App\Services\SchemaSearchMatcher;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{


        // ✅ Static function inside controller
    public static function setDynamicConnection($dbname,$credentialId=null)
    {
        if (App::environment('local')) {
            // Locally we don't have per-client credentials, so just reuse
            // the app's own default connection (whichever driver DB_CONNECTION
            // in .env points to) and swap only the database name.
            $driver = config('database.default');
            $base = config("database.connections.$driver");

            config([
                'database.connections.dynamic' => array_merge($base, [
                    'url' => null,
                    'database' => $dbname ?? 'webapp',
                ]),
            ]);
        } else {
            if(isset($credentialId)){
                $credential = DBCredential::find($credentialId);
                $dbDriver = $credential->db_driver ?? 'mysql';
                $dbHost = $credential->db_host ?? 'localhost';
                $dbName = $credential->db_name ?? 'u112116784_workspace';
                $dbUser = $credential->db_username ?? 'u112116784_workspace';
                $dbPass = $credential->db_password ?? 'AM*Wo8owc^7';
            }else{
                //Here if outer system like erp and you copied code there
                $dbDriver = 'mysql';
                $dbHost =  'localhost';
                $dbName =  'laravel';
                $dbUser =  'root';
                $dbPass =  '';
            }

            config([
                'database.connections.dynamic' => buildDynamicConnectionConfig($dbDriver, $dbHost, $dbName, $dbUser, $dbPass),
            ]);
        }

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
            $dbDriver = DB::connection('dynamic')->getDriverName();

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

        // The connection is already scoped to $request->database_name;
        // USE is MySQL-only syntax and invalid on Postgres.
        if ($dbDriver === 'mysql') {
            DB::connection('dynamic')->statement('use ' . $request->database_name);
        }

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

private static function parseSkippedTables($value): array
{
    return array_values(array_unique(array_filter(array_map('trim', explode(',', (string) $value)))));
}

public function getSkippedTables($id)
{
    return response()->json([
        'success' => true,
        'skipped_tables' => (string) DBCredential::where('id', $id)->value('skipped_tables'),
    ]);
}

public function updateSkippedTables(Request $request, $id)
{
    $validated = $request->validate([
        'skipped_tables' => 'nullable|string|max:5000',
    ]);

    $credential = DBCredential::findOrFail($id);
    $credential->skipped_tables = implode(',', self::parseSkippedTables($validated['skipped_tables'] ?? ''));
    $credential->save();

    return response()->json([
        'success' => true,
        'skipped_tables' => $credential->skipped_tables,
    ]);
}

/**
 * Table / column suggestions straight from the database (information_schema), so the app
 * doesn't have to depend on the full schema fetched by getDatabase().
 *
 * Query params:
 *   q     search word. "table.col" => table must equal "table", column contains "col";
 *         otherwise columns contain q and tables contain q (case-insensitive).
 *   table optional - restrict columns to this exact table.
 *   limit rows per list (default 50, max 1000).
 */
public function suggestSchema(Request $request, $dbname, $namedb)
{
    try {
        $search = mb_strtolower(trim((string) $request->query('q', '')));
        $tableFilter = trim((string) $request->query('table', ''));
        $limit = max(1, min(1000, (int) $request->query("limit", 50)));

        self::setDynamicConnection($namedb, $dbname);
        $conn = DB::connection('dynamic');
        $driver = $conn->getDriverName();
        $schemaName = $driver === 'pgsql'
            ? (config('database.connections.dynamic.schema') ?? 'public')
            : $namedb;

        // '!' is the LIKE escape character (portable across MySQL and PostgreSQL).
        $like = fn (string $v) => '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $v) . '%';

        // ── Tables: name contains the whole search word ──
        $tableSql = 'FROM information_schema.tables WHERE table_schema = ?';
        $tableBind = [$schemaName];
        if ($search !== '') {
            $tableSql .= " AND LOWER(table_name) LIKE ? ESCAPE '!'";
            $tableBind[] = $like($search);
        }
        $tableTotal = (int) ($conn->selectOne("SELECT COUNT(*) AS total {$tableSql}", $tableBind)->total ?? 0);
        $tables = array_map(
            fn ($r) => $r->tname,
            $conn->select("SELECT table_name AS tname {$tableSql} ORDER BY LOWER(table_name) LIMIT {$limit}", $tableBind)
        );

        // ── Columns ──
        $colSql = 'FROM information_schema.columns WHERE table_schema = ?';
        $colBind = [$schemaName];

        $columnPart = $search;
        if (str_contains($search, '.')) {
            $parts = explode('.', $search);
            $tablePart = $parts[0];
            $columnPart = end($parts);
            if ($tablePart !== '') {
                $colSql .= ' AND LOWER(table_name) = ?';
                $colBind[] = $tablePart;
            }
        }
        if ($columnPart !== '') {
            $colSql .= " AND LOWER(column_name) LIKE ? ESCAPE '!'";
            $colBind[] = $like($columnPart);
        }
        if ($tableFilter !== '') {
            $colSql .= ' AND table_name = ?';
            $colBind[] = $tableFilter;
        }

        $typeExpr = $driver === 'pgsql'
            ? "data_type || CASE
                    WHEN character_maximum_length IS NOT NULL THEN '(' || character_maximum_length || ')'
                    WHEN numeric_precision IS NOT NULL AND numeric_scale IS NOT NULL THEN '(' || numeric_precision || ',' || numeric_scale || ')'
                    ELSE ''
               END"
            : 'column_type';

        $columnTotal = (int) ($conn->selectOne("SELECT COUNT(*) AS total {$colSql}", $colBind)->total ?? 0);
        $columns = array_map(fn ($r) => [
            'table'    => $r->tname,
            'column'   => $r->cname,
            'type'     => $r->ctype,
            'nullable' => $r->cnull === 'YES' ? 'YES' : 'NO',
            'default'  => $r->cdef,
            'value'    => $r->tname . '.' . $r->cname,
        ], $conn->select(
            "SELECT table_name AS tname, column_name AS cname, is_nullable AS cnull, column_default AS cdef, {$typeExpr} AS ctype {$colSql}
             ORDER BY LOWER(column_name), table_name LIMIT {$limit}",
            $colBind
        ));

        return response()->json([
            'success' => true,
            'tables'  => ['rows' => $tables, 'total' => $tableTotal],
            'columns' => ['rows' => $columns, 'total' => $columnTotal],
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to load suggestions: ' . $e->getMessage(),
        ], 500);
    }
}

/**
 * POST /databases/changes/{dbname}/{namedb}
 *
 * Scans the database on THIS backend, diffs it against the stored baseline
 * (d_b_credentials.last_snapshot), stores any difference + the new baseline, and returns only
 * what the SQL tab needs to display - not the whole schema.
 *
 * Query params:
 *   skip_tables    same as getDatabase()
 *   skip_diff      1 => only scan (no diff / baseline storing), e.g. on credential change
 *   include_schema 1 => also return the full getDatabase() payload under "info" (for the
 *                  tables browser) so the app needs just one scan
 *   detected_at    client formatted time shown in the diff header (defaults to server time)
 */
public function checkChanges(Request $request, $dbname, $namedb)
{
    try {
        $scan = $this->getDatabase($dbname, $namedb);
        $info = $scan->getData(true);

        if ($scan->getStatusCode() !== 200 || !($info['success'] ?? false)) {
            return $scan;
        }

        [$organized, $tableMeta] = SchemaDiffService::organize($info['data'] ?? []);

        $diff = [
            'checked'          => false,
            'changes_count'    => 0,
            'stored'           => false,
            'baseline_created' => false,
            'reason'           => null,
        ];

        if (!$request->boolean('skip_diff')) {
            $diff['checked'] = true;
            $detectedAt = (string) $request->query('detected_at', now()->toDateTimeString());
            $credential = DBCredential::withoutGlobalScopes()->find($dbname);

            if (!$credential) {
                // e.g. a local backend that has no row for this production credential id
                $diff['reason'] = 'credential not found on this backend';
            } else {
                $raw = $credential->last_snapshot;
                $baseline = is_string($raw) ? json_decode($raw, true) : (is_array($raw) ? $raw : null);
                $hasBaseline = is_array($baseline) && count($baseline) > 0;

                $lines = $hasBaseline ? SchemaDiffService::diffLines($baseline, $organized) : [];

                if ($hasBaseline && !$lines) {
                    // nothing changed and a baseline already exists: nothing to store
                } elseif (!$hasBaseline && !$organized) {
                    $diff['reason'] = 'no schema to store as baseline';
                } else {
                    $text = SchemaDiffService::buildText(
                        $namedb,
                        $dbname,
                        $detectedAt,
                        $hasBaseline ? $lines : [SchemaDiffService::BASELINE_MESSAGE]
                    );

                    DB::transaction(function () use ($credential, $text, $organized) {
                        Difference::create([
                            'd_b_credential_id' => $credential->id,
                            'diff_db'           => $text,
                        ]);
                        $credential->last_snapshot = json_encode($organized, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                        $credential->save();
                    });

                    $diff['stored'] = true;
                    $diff['changes_count'] = $hasBaseline ? count($lines) : 0;
                    $diff['baseline_created'] = !$hasBaseline;
                }
            }
        }

        $payload = [
            'success'             => true,
            'table_meta'          => (object) $tableMeta,
            'latest_overall_date' => $info['latest_overall_date'] ?? null,
            'ls_command'          => $info['ls_command'] ?? null,
            'id_columns'          => $info['id_columns'] ?? [],
            'diff'                => $diff,
        ];

        if ($request->boolean('include_schema')) {
            $payload['info'] = $info;
        }

        return response()->json($payload);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to check database changes: ' . $e->getMessage(),
        ], 500);
    }
}

/**
 * GET /databases/tables/{dbname}/{namedb}?search=&mode=partial|exact|smart
 *
 * The SQL tab's tables list, filtered ON THE SERVER with the same rules the app used to apply
 * locally (see SchemaSearchMatcher). Row counts / timestamps are only computed for the tables
 * that match, so a search no longer scans the whole database. An empty search returns every
 * table (same as the full info scan).
 *
 * Returns the same row shape as getDatabase()["data"].
 */
public function tablesBrowser(Request $request, $dbname, $namedb)
{
    $search = (string) $request->query('search', '');
    $mode = (string) $request->query('mode', 'partial');
    if (!in_array($mode, SchemaSearchMatcher::MODES, true)) {
        $mode = 'partial';
    }

    if (trim($search) !== '') {
        // Columns come straight from the information_schema rows (Field/Type/Null/Default).
        request()->attributes->set('schema_table_filter', function (string $tableName, array $columns) use ($search, $mode) {
            $cols = array_map(fn ($c) => [
                'column'       => $c->Field,
                'type'         => $c->Type ?? null,
                'nullable'     => ($c->Null ?? null) === 'YES' ? 'YES' : 'NO',
                'defaultValue' => $c->Default ?? null,
            ], $columns);

            return SchemaSearchMatcher::tableMatches($tableName, $cols, $search, $mode);
        });
    }

    try {
        $scan = $this->getDatabase($dbname, $namedb);
        $info = $scan->getData(true);

        if ($scan->getStatusCode() !== 200 || !($info['success'] ?? false)) {
            return $scan;
        }

        return response()->json([
            'success'             => true,
            'data'                => $info['data'] ?? [],
            'latest_overall_date' => $info['latest_overall_date'] ?? null,
        ]);
    } finally {
        request()->attributes->remove('schema_table_filter');
    }
}

public function getDatabase($dbname, $namedb)
{
    try {
        // Call the static method
        self::setDynamicConnection($namedb, $dbname);

        // This runs against whichever driver the 'dynamic' connection was
        // configured with (see setDynamicConnection()) - MySQL for real
        // client credentials, or the app's own default driver locally.
        $driver = DB::connection('dynamic')->getDriverName();
        $schemaName = $driver === 'pgsql'
            ? (config('database.connections.dynamic.schema') ?? 'public')
            : $namedb;

        $tables = DB::connection('dynamic')->select(
            'SELECT table_name AS "TABLE_NAME", table_type AS "TABLE_TYPE" FROM information_schema.tables WHERE table_schema = ? ORDER BY table_name',
            [$schemaName]
        );
        $results = [];
        $latestOverallDate = null;

        // Array to store all ID columns and their tables
        $idColumns = [];

        // Fetch columns and foreign keys for the WHOLE schema in one query each,
        // instead of two information_schema queries per table.
        try {
            if ($driver === 'pgsql') {
                $allColumns = DB::connection('dynamic')->select("
                    SELECT
                        table_name AS \"TABLE_NAME\",
                        column_name AS \"Field\",
                        data_type || CASE
                            WHEN character_maximum_length IS NOT NULL THEN '(' || character_maximum_length || ')'
                            WHEN numeric_precision IS NOT NULL AND numeric_scale IS NOT NULL THEN '(' || numeric_precision || ',' || numeric_scale || ')'
                            ELSE ''
                        END AS \"Type\",
                        is_nullable AS \"Null\",
                        '' AS \"Key\",
                        column_default AS \"Default\",
                        '' AS \"Extra\"
                    FROM information_schema.columns
                    WHERE table_schema = ?
                    ORDER BY table_name, ordinal_position
                ", [$schemaName]);
            } else {
                $allColumns = DB::connection('dynamic')->select("
                    SELECT
                        table_name AS `TABLE_NAME`,
                        column_name AS `Field`,
                        column_type AS `Type`,
                        is_nullable AS `Null`,
                        column_key AS `Key`,
                        column_default AS `Default`,
                        extra AS `Extra`
                    FROM information_schema.columns
                    WHERE table_schema = ?
                    ORDER BY table_name, ordinal_position
                ", [$schemaName]);
            }
        } catch (\Exception $colException) {
            // Without the schema's columns nothing below is meaningful
            throw $colException;
        }

        if ($driver === 'pgsql') {
            // Postgres' key_column_usage doesn't carry the referenced
            // table/column (that's a MySQL-only extension), so join
            // through constraint_column_usage to get it.
            $allForeignKeys = DB::connection('dynamic')->select("
                SELECT
                    tc.table_name AS \"TABLE_NAME\",
                    kcu.column_name AS \"COLUMN_NAME\",
                    ccu.table_name AS \"REFERENCED_TABLE_NAME\",
                    ccu.column_name AS \"REFERENCED_COLUMN_NAME\"
                FROM information_schema.table_constraints tc
                JOIN information_schema.key_column_usage kcu
                    ON tc.constraint_name = kcu.constraint_name AND tc.table_schema = kcu.table_schema
                JOIN information_schema.constraint_column_usage ccu
                    ON tc.constraint_name = ccu.constraint_name AND tc.table_schema = ccu.table_schema
                WHERE tc.constraint_type = 'FOREIGN KEY'
                    AND tc.table_schema = ?
            ", [$schemaName]);
        } else {
            $allForeignKeys = DB::connection('dynamic')->select("
                SELECT
                    TABLE_NAME AS `TABLE_NAME`,
                    COLUMN_NAME,
                    REFERENCED_TABLE_NAME,
                    REFERENCED_COLUMN_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE
                    TABLE_SCHEMA = ?
                    AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$schemaName]);
        }

        $columnsByTable = [];
        foreach ($allColumns as $c) {
            $columnsByTable[$c->TABLE_NAME][] = $c;
        }
        $fksByTable = [];
        foreach ($allForeignKeys as $fk) {
            $fksByTable[$fk->TABLE_NAME][] = $fk;
        }

        // Comma-separated list of tables whose DATA checks (row count and latest
        // timestamps) are skipped. Their columns are still returned so the schema diff
        // keeps working. The app sends the list (kept on the production backend) as
        // ?skip_tables=; without it, fall back to this database's own
        // d_b_credentials.skipped_tables.
        if (request()->query->has('skip_tables')) {
            $skipSource = request()->query('skip_tables');
        } elseif (Schema::hasColumn('d_b_credentials', 'skipped_tables')) {
            $skipSource = DBCredential::where('id', $dbname)->value('skipped_tables');
        } else {
            $skipSource = '';
        }
        $skipTables = array_flip(self::parseSkippedTables($skipSource));

        $tableFilter = request()->attributes->get('schema_table_filter');

        foreach ($tables as $t) {
            $tableName = $t->TABLE_NAME;
            $tableType = $t->TABLE_TYPE ?? 'BASE TABLE';
            $skipData = isset($skipTables[$tableName]);

            $columns = $columnsByTable[$tableName] ?? [];
            // The bulk query returns the TABLE_NAME helper column; the per-table
            // query never did, and the response sets TABLE_NAME itself below.
            foreach ($columns as $col) {
                unset($col->TABLE_NAME);
            }

            // Optional filter (see tablesBrowser): tables that don't match are skipped entirely,
            // so no row-count / timestamp queries run for them.
            if ($tableFilter && !$tableFilter($tableName, $columns)) {
                continue;
            }

            $foreignKeys = $fksByTable[$tableName] ?? [];

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

            // Detect timestamp columns - must actually be a date/time typed
            // column, since some tables (e.g. Laravel's queue `jobs` table)
            // name an integer Unix-timestamp column `created_at`, which
            // can't be fed into whereBetween() alongside Carbon dates.
            $hasCreatedAt = false;
            $hasUpdatedAt = false;

            $isTemporalType = fn ($type) => stripos($type, 'time') !== false || stripos($type, 'date') !== false;

            foreach ($columns as $c) {
                if ($c->Field === 'created_at' && $isTemporalType($c->Type)) $hasCreatedAt = true;
                if ($c->Field === 'updated_at' && $isTemporalType($c->Type)) $hasUpdatedAt = true;
            }

            // Defaults
            $latestCreatedAt = null;
            $latestUpdatedAt = null;
            $latestCreatedAtCount = null;
            $latestUpdatedAtCount = null;

            // Row count (skip views) - computed together with the MAX timestamps
            // in a single table scan instead of separate queries.
            $rowCount = null;

            if ($tableType !== 'VIEW' && !$skipData) {
                $selects = ['COUNT(*) as row_count'];

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

                $rowCount = (int) ($dates->row_count ?? 0);
            }

            // Get latest timestamps only if columns exist and not a view
            if ($tableType !== 'VIEW' && !$skipData && ($hasCreatedAt || $hasUpdatedAt)) {
                $latestCreatedAt = $dates->latest_created_at ?? null;
                $latestUpdatedAt = $dates->latest_updated_at ?? null;

                foreach ([$latestCreatedAt, $latestUpdatedAt] as $dt) {
                    if ($dt) {
                        if (!$latestOverallDate || Carbon::parse($dt)->gt(Carbon::parse($latestOverallDate))) {
                            $latestOverallDate = $dt;
                        }
                    }
                }

                // Count rows sharing the same timestamps (+/-1 minute window).
                // Kept as a range query so an index on the column can be used.
                if ($hasCreatedAt && $latestCreatedAt) {
                    $latestCreatedAtCarbon = Carbon::parse($latestCreatedAt);

                    $latestCreatedAtCount = DB::connection('dynamic')
                        ->table($tableName)
                        ->whereBetween('created_at', [$latestCreatedAtCarbon->copy()->subMinute(), $latestCreatedAtCarbon->copy()->addMinute()])
                        ->count();
                }

                if ($hasUpdatedAt && $latestUpdatedAt) {
                    $latestUpdatedAtCarbon = Carbon::parse($latestUpdatedAt);

                    $latestUpdatedAtCount = DB::connection('dynamic')
                        ->table($tableName)
                        ->whereBetween('updated_at', [$latestUpdatedAtCarbon->copy()->subMinute(), $latestUpdatedAtCarbon->copy()->addMinute()])
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

        $fixed = Query::where('d_b_credential_id', $id)->select('id','title')
            ->where('isFixed', 1)
            ->get();

        $all = Query::where('d_b_credential_id', $id)
            ->select('id','title')
            ->latest('updated_at')
            ->take(20)
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
    $validated = $request->validate([
        'credential_id'  => 'required|exists:d_b_credentials,id',
        'diff_text'      => 'required|string',
        'last_snapshot'  => 'required',
    ]);

    try {
        $difference = DB::transaction(function () use ($validated) {
            $difference = Difference::create([
                'd_b_credential_id' => $validated['credential_id'],
                'diff_db'           => $validated['diff_text'],
            ]);

            if (!$difference || !$difference->exists) {
                throw new \RuntimeException('Failed to create difference record.');
            }

            $updated = DBCredential::where('id', $validated['credential_id'])
                ->update(['last_snapshot' => $validated['last_snapshot']]);

            if (!$updated) {
                throw new \RuntimeException('Failed to update last_snapshot.');
            }

            return $difference;
        });

        return response()->json([
            'success' => true,
            'message' => 'Difference saved successfully',
            'data'    => $difference,
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'error'   => $e->getMessage(),
        ], 500);
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
                $q->where('diff_db', 'like', "%{$search}%");
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


public function queryMatching(Request $request)
{
    $keyword = $request->query('keyword');
    $db_credential_id = $request->query('db_credential_id');

    $queries = Query::withoutGlobalScope(ActiveScope::class)
        ->where('d_b_credential_id', $db_credential_id)
        ->where('title', 'like', "%{$keyword}%")
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'queries' => $queries,
    ]);
}




}