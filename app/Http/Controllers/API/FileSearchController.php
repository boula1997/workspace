<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileSearchController extends Controller
{
    /**
     * Read full text content directly from a local file path (e.g., parcel.sql or routes.json)
     */
    public function readContent(Request $request)
    {
        $validated = $request->validate([
            'path' => 'required|string',
        ]);

        $path = $validated['path'];

        if (!File::exists($path)) {
            return response()->json(['error' => 'File not found: ' . $path], 404);
        }

        if (!File::isReadable($path)) {
            return response()->json(['error' => 'File is not readable'], 403);
        }

        $content = File::get($path);
        // Clean UTF-8 encoding
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');

        return response()->json([
            'path'    => $path,
            'content' => $content,
        ]);
    }

public function countOccurrences(Request $request)
{
    $validated = $request->validate([
        'path'                   => 'required|string',
        'terms'                  => 'required|array|min:1|max:20',
        'terms.*.text'           => 'required|string',
        'terms.*.mode'           => 'required|in:exact,partial',
        'terms.*.case_sensitive' => 'boolean',
    ]);

    $path = $validated['path'];

    if (!File::exists($path)) {
        return response()->json(['error' => 'File not found: ' . $path], 404);
    }

    if (!File::isReadable($path)) {
        return response()->json(['error' => 'File is not readable'], 403);
    }

    $content = File::get($path);
    $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');

    // Split into individual lines once so we can report line numbers cheaply
    $lines      = preg_split('/\r\n|\r|\n/', $content);
    $results    = [];
    $totalCount = 0;

    // --- Single forward pass over the file to figure out, for every line,
    //     which table it "belongs to". This is ONLY used to (a) fill the new
    //     "table" field / "tables" breakdown below, and (b) tighten the
    //     existing uniqueness check so it dedupes by the real table instead
    //     of by whatever clause text happens to be on that exact line (which
    //     falls apart for Postgres COPY blocks, where the table name is only
    //     printed once and every following data row has no clause at all). ---
    $lineTableMap = [];
    $currentTable = null;
    $dbType       = null;

    foreach ($lines as $idx => $lineText) {
        if ($dbType === null && $idx < 40) {
            if (stripos($lineText, 'MySQL dump') !== false || stripos($lineText, 'phpMyAdmin SQL Dump') !== false) {
                $dbType = 'mysql';
            } elseif (stripos($lineText, 'PostgreSQL database dump') !== false || stripos($lineText, 'pg_dump') !== false) {
                $dbType = 'postgres';
            }
        }

        $detected = $this->detectTableName($lineText);
        if ($detected !== null) {
            $currentTable = $detected;
        }

        $lineTableMap[$idx] = $currentTable;
    }

    foreach ($validated['terms'] as $term) {
        $search        = $term['text'];
        $mode          = $term['mode'];
        $caseSensitive = (bool) ($term['case_sensitive'] ?? false);
        $flags         = $caseSensitive ? '' : 'i';
        $escaped       = preg_quote($search, '/');
        $pattern       = $mode === 'exact'
            ? '/\b' . $escaped . '\b/' . $flags
            : '/' . $escaped . '/' . $flags;

        $count = preg_match_all($pattern, $content);
        if ($count === false) {
            return response()->json([
                'error' => "Search failed for \"{$search}\": " . preg_last_error_msg(),
            ], 422);
        }

        // Collect every entry unique by (table, matched token) — no cap
        $matchedLines = [];
        $seen         = [];

        // Tally of occurrences per table for THIS term (every match counts,
        // independent of the dedup applied to matchedLines below).
        $tableCounts = [];

        foreach ($lines as $lineIndex => $lineText) {
            if (!preg_match_all($pattern, $lineText, $m, PREG_OFFSET_CAPTURE)) {
                continue;
            }

            $truncated    = $this->truncateToTableName($lineText);
            $tableForLine = $lineTableMap[$lineIndex]; // null if outside any recognized table section

            foreach ($m[0] as $match) {
                $offset      = $match[1];
                $matchLength = strlen($match[0]);
                $matchedText = $this->expandToFullToken($lineText, $offset, $matchLength);

                $tableBucket = $tableForLine ?? '(outside table section)';
                $tableCounts[$tableBucket] = ($tableCounts[$tableBucket] ?? 0) + 1;

                // Uniqueness key: prefer the actual detected table name (works
                // for COPY data rows with no per-line clause); fall back to the
                // same-line clause text exactly like before when no table has
                // been detected at all (e.g. very top of the file).
                $tableKey = $tableForLine ?? $truncated;
                $tableKey = $caseSensitive ? $tableKey : mb_strtolower($tableKey);
                $tokenKey = $caseSensitive ? $matchedText : mb_strtolower($matchedText);
                $key      = $tableKey . '|' . $tokenKey;

                if (isset($seen[$key])) {
                    continue;
                }
                $seen[$key] = true;

                // Display label: bare table name when we know it (e.g. "cities"),
                // otherwise fall back to the same-line clause text so it still
                // shows something meaningful (e.g. "SELECT ... FROM x").
                $tableLabel = $tableForLine ?? ($truncated !== '' ? $truncated : '(unknown)');

                $matchedLines[] = [
                    'line'    => $lineIndex + 1,
                    'content' => $tableLabel . '->' . $matchedText,
                    'table'   => $tableForLine,
                    'matched_word' => $matchedText,
                ];
            }
        }

        // Sort tables by occurrence count, descending
        arsort($tableCounts);
        $tablesOut = [];
        foreach ($tableCounts as $table => $tableCount) {
            $tablesOut[] = ['table' => $table, 'count' => $tableCount];
        }

        $results[] = [
            'text'           => $search,
            'mode'           => $mode,
            'case_sensitive' => $caseSensitive,
            'count'          => $count,
            'matched_lines'  => $matchedLines,
            'tables'         => $tablesOut,
            'table_count'    => count($tablesOut),
        ];
        $totalCount += $count;
    }

    return response()->json([
        'path'        => $path,
        'db_type'     => $dbType ?? 'unknown',
        'results'     => $results,
        'total_count' => $totalCount,
    ]);
}

/**
 * Truncates a SQL line to end right after the table name, covering the
 * common statement types: INSERT INTO, REPLACE INTO, UPDATE, DELETE FROM,
 * SELECT ... FROM, ALTER TABLE, CREATE TABLE [IF NOT EXISTS], DROP TABLE
 * [IF EXISTS], TRUNCATE [TABLE]. Falls back to the full trimmed line if
 * none of these clauses is found.
 */
private function truncateToTableName(string $lineText): string
{
    $line = trim($lineText);

    // Keyword clause that precedes a table name, longest/most-specific first.
    $clause = '(?:'
        . 'INSERT\s+INTO'
        . '|REPLACE\s+INTO'
        . '|DELETE\s+FROM'
        . '|UPDATE'
        . '|ALTER\s+TABLE'
        . '|CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS'
        . '|CREATE\s+TABLE'
        . '|DROP\s+TABLE\s+IF\s+EXISTS'
        . '|DROP\s+TABLE'
        . '|TRUNCATE\s+TABLE'
        . '|TRUNCATE'
        . '|FROM'
        . ')';

    // Table name: optionally schema-qualified, optionally backticked/quoted.
    $tableName = '`?"?[\w]+`?"?(?:\.`?"?[\w]+`?"?)?';

    if (preg_match('/^(.*?\b' . $clause . '\s+' . $tableName . ')/i', $line, $m)) {
        return trim($m[1]);
    }

    return $line;
}

/**
 * Extracts just the bare table name from a line, if the line is one of the
 * SQL statement types that names a table (works for both mysqldump/phpMyAdmin
 * style exports and pg_dump style exports). Returns null if no table name is
 * found on this line.
 *
 * This is used two ways:
 *  1. As the "current section" tracker — CREATE TABLE / DROP TABLE /
 *     INSERT INTO / COPY ... FROM stdin / etc. mark the start of a table's
 *     section, so subsequent lines (e.g. raw COPY data rows, which don't
 *     repeat the table name) are still correctly attributed to that table.
 *  2. As a direct, same-line table name whenever a line itself contains one
 *     of these clauses (most precise case).
 */
private function detectTableName(string $lineText): ?string
{
    $line = trim($lineText);

    // Table name: optional schema prefix (Postgres), optional backticks/quotes.
    $schemaAndTable = '(?:[A-Za-z0-9_]+\.)?`?"?([A-Za-z0-9_]+)`?"?';

    $patterns = [
        // --- MySQL / phpMyAdmin dump section markers ---
        '/^--\s*Table structure for table\s+`?"?([A-Za-z0-9_]+)`?"?/i',
        '/^--\s*Dumping data for table\s+`?"?([A-Za-z0-9_]+)`?"?/i',

        // --- PostgreSQL / pg_dump section markers ---
        '/^--\s*Name:\s*([A-Za-z0-9_]+);\s*Type:\s*TABLE/i',
        '/^COPY\s+' . $schemaAndTable . '\s*\(/i',

        // --- Statement-level table references (either dialect) ---
        '/^(?:CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS|CREATE\s+TABLE)\s+' . $schemaAndTable . '/i',
        '/^DROP\s+TABLE(?:\s+IF\s+EXISTS)?\s+' . $schemaAndTable . '/i',
        '/^(?:INSERT\s+INTO|REPLACE\s+INTO)\s+' . $schemaAndTable . '/i',
        '/^ALTER\s+TABLE(?:\s+ONLY)?\s+' . $schemaAndTable . '/i',
        '/^(?:TRUNCATE\s+TABLE|TRUNCATE)\s+' . $schemaAndTable . '/i',
        '/^DELETE\s+FROM\s+' . $schemaAndTable . '/i',
        '/^UPDATE\s+' . $schemaAndTable . '/i',

        // --- Generic fallback: any "FROM x" (e.g. SELECT ... FROM) ---
        '/\bFROM\s+' . $schemaAndTable . '/i',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $line, $m)) {
            return $m[1];
        }
    }

    return null;
}

/**
 * Expands a match at [offset, offset+length) outward to the full
 * contiguous "token" it sits inside (letters, digits, underscore,
 * hyphen, dot) so e.g. matching "ibrahim" inside "ibrahim-merchant-dev"
 * returns the whole "ibrahim-merchant-dev" token.
 */
private function expandToFullToken(string $lineText, int $offset, int $length): string
{
    $tokenChars = '/[\w\-.]/';

    $start = $offset;
    while ($start > 0 && preg_match($tokenChars, $lineText[$start - 1])) {
        $start--;
    }

    $end = $offset + $length;
    $len = strlen($lineText);
    while ($end < $len && preg_match($tokenChars, $lineText[$end])) {
        $end++;
    }

    return substr($lineText, $start, $end - $start);
}
}