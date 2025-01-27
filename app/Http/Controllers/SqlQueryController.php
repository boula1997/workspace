<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDO;

class SqlQueryController extends Controller
{
    public function runQuery(Request $request)
    {
        try {
            // Retrieve database credentials and interval datetime
            $host = env('DB_HOST', 'localhost');
            $dbname = $request->query('dbname', env('DB_DATABASE', 'automation'));
            $username = $request->query('username', env('DB_USERNAME', 'root'));
            $password = $request->query('password', '');
    
            // Retrieve the interval datetime from the query parameter
            $interval = $request->query('interval'); // Should be a datetime string, e.g., '2025-01-06T16:39'
    
            // Validate and format the interval datetime
            if (!$interval || !strtotime($interval)) {
                throw new \Exception("Invalid interval datetime provided.");
            }
    
            $intervalDateTime = Carbon::parse($interval)->format('Y-m-d H:i:s'); // Convert to database-compatible format
    
            // Create PDO connection
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Fetch tables with 'created_at' or 'updated_at' columns
            $queryTables = "
                SELECT TABLE_NAME, COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = :dbname
                AND COLUMN_NAME IN ('created_at', 'updated_at')
            ";
            $stmt = $pdo->prepare($queryTables);
            $stmt->bindParam(':dbname', $dbname, PDO::PARAM_STR);
            $stmt->execute();
            $columnsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Group tables by column
            $tablesWithColumns = [];
            foreach ($columnsData as $columnInfo) {
                $tableName = $columnInfo['TABLE_NAME'];
                $columnName = $columnInfo['COLUMN_NAME'];
                $tablesWithColumns[$tableName][] = $columnName;
            }
    
            // Fetch rows for each table based on the available columns
            $latestRows = [];
            foreach ($tablesWithColumns as $tableName => $columns) {
                $conditions = [];
                $orderByColumns = [];
    
                // Check if both 'created_at' and 'updated_at' exist in the table
                if (in_array('created_at', $columns)) {
                    $conditions[] = "created_at >= :intervalDateTime";
                    $orderByColumns[] = "created_at";
                }
                if (in_array('updated_at', $columns)) {
                    $conditions[] = "updated_at >= :intervalDateTime";
                    $orderByColumns[] = "updated_at";
                }
    
                // If conditions are set, proceed with the query
                if (!empty($conditions)) {
                    $query = "
                        SELECT *
                        FROM `$tableName`
                        WHERE " . implode(' OR ', $conditions) . "
                    ";
    
                    // Add ORDER BY clause
                    if (!empty($orderByColumns)) {
                        $query .= " ORDER BY " . implode(', ', $orderByColumns) . " DESC";
                    }
    
                    // Prepare and execute the query
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':intervalDateTime', $intervalDateTime, PDO::PARAM_STR);
                    $stmt->execute();
                    $latestRows[$tableName] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
    
            // Return the results
            return view('query_result', compact('latestRows', 'intervalDateTime', 'dbname', 'username', 'password'));
    
        } catch (\PDOException $e) {
            // Handle database exceptions
            return view('query_result', ['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            // Handle general exceptions
            return view('query_result', ['error' => $e->getMessage()]);
        }
    }
    
}
