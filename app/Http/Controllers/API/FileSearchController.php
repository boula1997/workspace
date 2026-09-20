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

    /**
     * Count term occurrences in a (potentially very large) local file.
     *
     * Previously this loaded the entire file into a string via File::get(),
     * ran mb_convert_encoding() on the whole blob, split it into a full
     * in-memory $lines array via preg_split(), then walked that array once
     * to build a table map and AGAIN per search term (up to 20x) to collect
     * matches. On a multi-hundred-MB SQL dump that is several full copies of
     * the file alive in memory simultaneously, which exhausts PHP's
     * memory_limit (or blows past max_execution_time) and crashes as an
     * uncatchable fatal error — Laravel can't turn that into a JSON error
     * response, so the client just sees a bare 500 with no body.
     *
     * Fix: stream the file line-by-line with fgets() in a SINGLE pass,
     * decoding and matching one line at a time, and evaluate every term's
     * pattern against that one line before moving on. Nothing holds the
     * full file content or a full array of all lines in memory at once —
     * memory use now stays roughly constant regardless of file size.
     */
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

        // Give this endpoint extra headroom for large SQL dumps without
        // raising the limit for the whole app. Streaming below should make
        // this unnecessary in most cases, but it's a cheap safety net for
        // very large matched_lines/table_counts accumulators.
        @ini_set('memory_limit', '512M');
        @set_time_limit(120);

        $handle = @fopen($path, 'r');
        if ($handle === false) {
            return response()->json(['error' => 'Unable to open file for reading'], 500);
        }

        // Compile each term's pattern once, up front, and give each one its
        // own small accumulator. All terms are checked against every line in
        // the same single pass over the file.
        $terms = [];
        foreach ($validated['terms'] as $term) {
            $search        = $term['text'];
            $mode          = $term['mode'];
            $caseSensitive = (bool) ($term['case_sensitive'] ?? false);
            $flags         = $caseSensitive ? '' : 'i';
            $escaped       = preg_quote($search, '/');
            $pattern       = $mode === 'exact'
                ? '/\b' . $escaped . '\b/' . $flags
                : '/' . $escaped . '/' . $flags;

            $terms[] = [
                'text'           => $search,
                'mode'           => $mode,
                'case_sensitive' => $caseSensitive,
                'pattern'        => $pattern,
                'count'          => 0,
                'matched_lines'  => [],
                'seen'           => [],
                'table_counts'   => [],
            ];
        }

        $dbType       = null;
        $currentTable = null;
        $lineIndex    = 0;
        $inCopy       = false; // true while inside a pg_dump "COPY ... FROM stdin;" data block

        while (($rawLine = fgets($handle)) !== false) {
            $lineText = rtrim($rawLine, "\r\n");
            // Decode per-line instead of on the whole file at once.
            $lineText = mb_convert_encoding($lineText, 'UTF-8', 'UTF-8');

            if ($dbType === null && $lineIndex < 40) {
                if (stripos($lineText, 'MySQL dump') !== false || stripos($lineText, 'phpMyAdmin SQL Dump') !== false) {
                    $dbType = 'mysql';
                } elseif (stripos($lineText, 'PostgreSQL database dump') !== false || stripos($lineText, 'pg_dump') !== false) {
                    $dbType = 'postgres';
                }
            }

            // Inside a pg_dump COPY block every line up to the "\." terminator is
            // raw row data, not SQL. Never look for table names in it: a row whose
            // text says "... revoked from driver: Ahmed" would otherwise be read as
            // "FROM driver" and switch the current table to "driver" for every row
            // that follows, so keyword hits get attributed to the wrong table.
            if ($inCopy) {
                if ($lineText === '\\.') {
                    $inCopy = false;
                }
            } else {
                $detected = $this->detectTableName($lineText);
                if ($detected !== null) {
                    $currentTable = $detected;
                }

                if (preg_match('/^COPY\s+\S+.*\bFROM\s+stdin\b/i', $lineText)) {
                    $inCopy = true;
                }
            }

            foreach ($terms as &$term) {
                if (!preg_match_all($term['pattern'], $lineText, $m, PREG_OFFSET_CAPTURE)) {
                    continue;
                }

                $term['count'] += count($m[0]);

                $truncated = mb_strimwidth($this->truncateToTableName($lineText), 0, 120, '…');

                foreach ($m[0] as $match) {
                    $offset      = $match[1];
                    $matchLength = strlen($match[0]);
                    $matchedText = $this->expandToFullToken($lineText, $offset, $matchLength);

                    $tableBucket = $currentTable ?? '(outside table section)';
                    $term['table_counts'][$tableBucket] = ($term['table_counts'][$tableBucket] ?? 0) + 1;

                    // Uniqueness key: prefer the actual detected table name (works
                    // for COPY data rows with no per-line clause); fall back to the
                    // same-line clause text when no table has been detected yet.
                    $tableKey = $currentTable ?? $truncated;
                    $tableKey = $term['case_sensitive'] ? $tableKey : mb_strtolower($tableKey);
                    $tokenKey = $term['case_sensitive'] ? $matchedText : mb_strtolower($matchedText);
                    $key      = $tableKey . '|' . $tokenKey;

                    if (isset($term['seen'][$key])) {
                        continue;
                    }
                    $term['seen'][$key] = true;

                    $tableLabel = $currentTable ?? ($truncated !== '' ? $truncated : '(unknown)');

                    $term['matched_lines'][] = [
                        'line'         => $lineIndex + 1,
                        'content'      => $tableLabel . '->' . $matchedText,
                        'table'        => $currentTable,
                        'matched_word' => $matchedText,
                    ];
                }
            }
            unset($term);

            $lineIndex++;
        }

        fclose($handle);

        $results    = [];
        $totalCount = 0;

        foreach ($terms as $term) {
            arsort($term['table_counts']);
            $tablesOut = [];
            foreach ($term['table_counts'] as $table => $tableCount) {
                $tablesOut[] = ['table' => $table, 'count' => $tableCount];
            }

            $results[] = [
                'text'           => $term['text'],
                'mode'           => $term['mode'],
                'case_sensitive' => $term['case_sensitive'],
                'count'          => $term['count'],
                'matched_lines'  => $term['matched_lines'],
                'tables'         => $tablesOut,
                'table_count'    => count($tablesOut),
            ];
            $totalCount += $term['count'];
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
        // Handles users, public.users, `users`, "users" and "public"."users".
        $schemaAndTable = '(?:[`"]?[A-Za-z0-9_]+[`"]?\.)?[`"]?([A-Za-z0-9_]+)[`"]?';

        $patterns = [
            // --- MySQL / phpMyAdmin dump section markers ---
            '/^--\s*Table structure for table\s+`?"?([A-Za-z0-9_]+)`?"?/i',
            '/^--\s*Dumping data for table\s+`?"?([A-Za-z0-9_]+)`?"?/i',

            // --- PostgreSQL / pg_dump section markers ---
            '/^--\s*Data for Name:\s*([A-Za-z0-9_]+);\s*Type:\s*TABLE DATA/i',
            '/^--\s*Name:\s*([A-Za-z0-9_]+);\s*Type:\s*TABLE/i',
            '/^COPY\s+' . $schemaAndTable . '\s*(?:\(|FROM\b)/i',

            // --- Statement-level table references (either dialect) ---
            '/^(?:CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS|CREATE\s+TABLE)\s+' . $schemaAndTable . '/i',
            '/^DROP\s+TABLE(?:\s+IF\s+EXISTS)?\s+' . $schemaAndTable . '/i',
            '/^(?:INSERT\s+INTO|REPLACE\s+INTO)\s+' . $schemaAndTable . '/i',
            '/^ALTER\s+TABLE(?:\s+ONLY)?\s+' . $schemaAndTable . '/i',
            '/^(?:TRUNCATE\s+TABLE|TRUNCATE)\s+' . $schemaAndTable . '/i',
            '/^DELETE\s+FROM\s+' . $schemaAndTable . '/i',
            '/^UPDATE\s+' . $schemaAndTable . '/i',

            '/^LOCK\s+TABLES\s+' . $schemaAndTable . '/i',

            // --- Fallback: real SELECT statements only. It used to match ANY
            // "from x" on any line, which also fired on plain text inside
            // multi-line INSERT values (e.g. 'sent from home') and switched the
            // current table to "home". ---
            '/^SELECT\b.*?\bFROM\s+' . $schemaAndTable . '/i',
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