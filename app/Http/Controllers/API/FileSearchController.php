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
        $maxLines   = 10;
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
            // Collect matched lines (line number + trimmed text), limited to $maxLines
            $matchedLines = [];
            foreach ($lines as $lineIndex => $lineText) {
                if (preg_match($pattern, $lineText)) {
                    $matchedLines[] = [
                        'line'    => $lineIndex + 1,
                        'content' => trim($lineText),
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
                'matched_lines'  => $matchedLines,   // ← NEW
            ];
            $totalCount += $count;
        }
        return response()->json([
            'path'        => $path,
            'results'     => $results,
            'total_count' => $totalCount,
        ]);
    }
}
