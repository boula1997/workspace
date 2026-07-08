<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileSearchController extends Controller
{
public function countOccurrences(Request $request)
{
    $validated = $request->validate([
        'path'           => 'required|string',
        'text'           => 'required|string',
        'mode'           => 'required|in:exact,partial',
        'case_sensitive' => 'boolean',
    ]);

    $path = $validated['path'];

    if (!File::exists($path)) {
        return response()->json(['error' => 'File not found: ' . $path], 404);
    }

    if (!File::isReadable($path)) {
        return response()->json(['error' => 'File is not readable'], 403);
    }

    $content       = File::get($path);
    $search        = $validated['text'];
    $caseSensitive = $request->boolean('case_sensitive', false);

    // Strip/replace invalid UTF-8 bytes so preg_match_all doesn't choke on binary/legacy-encoded dumps
    $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');

    $flags   = $caseSensitive ? '' : 'i'; // removed 'u' — not needed for byte-level search
    $escaped = preg_quote($search, '/');

    $pattern = $validated['mode'] === 'exact'
        ? '/\b' . $escaped . '\b/' . $flags
        : '/' . $escaped . '/' . $flags;

    $count = preg_match_all($pattern, $content);

    if ($count === false) {
        $pcreError = preg_last_error_msg(); // PHP 8+, gives the real reason
        return response()->json(['error' => 'Search failed: ' . $pcreError], 422);
    }

    return response()->json([
        'path'           => $path,
        'search'         => $search,
        'mode'           => $validated['mode'],
        'case_sensitive' => $caseSensitive,
        'count'          => $count,
    ]);
}
}