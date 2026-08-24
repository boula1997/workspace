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
     * Count word occurrences in local file and return matched lines (max 10 per term).
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

    $content = File::get($path);
    $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');

    // Split into individual lines once so we can report line numbers cheaply
    $lines      = preg_split('/\r\n|\r|\n/', $content);
    $results    = [];
    $totalCount = 0;
    $maxLines   = 1000;

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

        // Collect unique truncated matches, limited to $maxLines total
        $matchedLines = [];
        $seen         = [];
        foreach ($lines as $lineIndex => $lineText) {
            if (preg_match_all($pattern, $lineText, $m, PREG_OFFSET_CAPTURE)) {
                $truncated   = $this->truncateToTableName($lineText);
                $offset      = $m[0][0][1];
                $matchLength = strlen($m[0][0][0]);
                $matchedText = $this->expandToFullToken($lineText, $offset, $matchLength);
                $display     = $truncated . '  ' . $matchedText;

                $key = $caseSensitive ? $display : mb_strtolower($display);

                if (isset($seen[$key])) {
                    continue;
                }
                $seen[$key] = true;

                $matchedLines[] = [
                    'line'    => $lineIndex + 1,
                    'content' => $display,
                ];

                if (count($matchedLines) >= $maxLines) {
                    break;
                }
            }
        }

        $results[] = [
            'text'           => $search,
            'mode'           => $mode,
            'case_sensitive' => $caseSensitive,
            'count'          => $count,
            'matched_lines'  => $matchedLines,
        ];
        $totalCount += $count;
    }

    return response()->json([
        'path'        => $path,
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
