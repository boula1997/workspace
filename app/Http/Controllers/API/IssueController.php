<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{
    /**
     * GET /issue/hollyMass
     * Returns the Holly Mass issue entry (Boula-only).
     */
    public function hollyMass()
    {
        try {
            if (boula()) {
                $hollyMass = Issue::where('id', 66)->first();

                return response()->json([
                    'message' => 'User is Boula',
                    'data'    => $hollyMass,
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /issue/facebookAds
     * Returns the Facebook Ads issue entry (Boula-only).
     */
    public function facebookAds()
    {
        try {
            if (boula()) {
                $facebookAds = Issue::where('id', 118)->first();

                return response()->json([
                    'message' => 'User is Boula',
                    'data'    => $facebookAds,
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * POST /apptask/refproPost
     * Saves an AI prompt to a Project or Issue.
     */
    public function refproPost(Request $request)
    {
        try {
            if (!isWithinWorkingHours()) {
                return failedResponse([]);
            }

            if (isset($request->project_id)) {
                $result = Project::find($request->project_id);
                $result->update(['ai_prompt' => $request->title]);
            } elseif (isset($request->refrence_id)) {
                $result = Issue::find($request->refrence_id);
                $result->update(['ai_prompt' => $request->title]);
            }

            return successResponse([
                'result'  => $result->ai_prompt,
                'project' => $result,
            ]);
        } catch (Exception $e) {
            DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()),
                'created_at'      => now(),
            ]);
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /apptask/refproGet
     * Retrieves the stored AI prompt from a Project or Issue.
     */
    public function refproGet(Request $request)
    {
        try {
            if (!isWithinWorkingHours()) {
                return failedResponse([]);
            }

            if (isset($request->project_id)) {
                $result = Project::find($request->project_id);
            } elseif (isset($request->refrence_id)) {
                $result = Issue::find($request->refrence_id);
            }

            return successResponse([
                'result'  => $result->ai_prompt,
                'project' => $result,
            ]);
        } catch (Exception $e) {
            DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()),
                'created_at'      => now(),
            ]);
            return failedResponse($e->getMessage());
        }
    }
}
