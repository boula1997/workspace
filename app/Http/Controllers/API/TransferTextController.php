<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;

/**
 * The SQL tab's Transfer modal reads and writes the `ai_prompt` of the Info reference titled
 * "Transfer and copy Content" (the same text the Info tab shows for that reference), so a text
 * saved on one device is available on every other one.
 */
class TransferTextController extends Controller
{
    private const REFERENCE_TITLE = 'Transfer and copy Content';

    public function show()
    {
        $issue = $this->findIssue();

        if (!$issue) {
            return $this->missingReference();
        }

        return response()->json([
            'content' => $issue->ai_prompt ?? '',
            'updated_at' => $issue->updated_at,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'content' => 'present|nullable|string',
        ]);

        $issue = $this->findIssue();

        if (!$issue) {
            return $this->missingReference();
        }

        $issue->update(['ai_prompt' => $data['content'] ?? '']);

        return response()->json([
            'content' => $issue->ai_prompt,
            'updated_at' => $issue->updated_at,
        ]);
    }

    private function findIssue(): ?Issue
    {
        return Issue::where('title', self::REFERENCE_TITLE)->orderBy('id')->first();
    }

    private function missingReference()
    {
        return response()->json([
            'message' => 'Info reference "' . self::REFERENCE_TITLE . '" was not found.',
        ], 404);
    }
}
