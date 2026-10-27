<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClaudeDocument;
use Illuminate\Http\Request;

// The signed-in admin's own CLAUDE.md text
class ClaudeDocumentController extends Controller
{
    public function show()
    {
        $document = ClaudeDocument::where('admin_id', (int) auth('admin-api')->id())->first();

        return response()->json([
            'content' => $document?->content ?? '',
            'updated_at' => $document?->updated_at,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate(['content' => 'nullable|string|max:1000000']);

        $document = ClaudeDocument::updateOrCreate(
            ['admin_id' => (int) auth('admin-api')->id()],
            ['content' => $data['content'] ?? '']
        );

        return response()->json(['content' => $document->content, 'updated_at' => $document->updated_at]);
    }
}
