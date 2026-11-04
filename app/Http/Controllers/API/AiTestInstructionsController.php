<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Issue;

/**
 * The SQL tab's "AI test instructions" button copies the `ai_prompt` of the Info reference titled
 * "AI instructions to test a task done by claude", so the text is edited in one place (the issue)
 * and every device copies the same version.
 */
class AiTestInstructionsController extends Controller
{
    private const REFERENCE_TITLE = 'AI instructions to test a task done by claude';

    public function show()
    {
        $issue = Issue::where('title', self::REFERENCE_TITLE)->orderBy('id')->first();

        if (!$issue) {
            return response()->json([
                'message' => 'Info reference "' . self::REFERENCE_TITLE . '" was not found.',
            ], 404);
        }

        return response()->json([
            'content' => $issue->ai_prompt ?? '',
            'updated_at' => $issue->updated_at,
        ]);
    }
}
