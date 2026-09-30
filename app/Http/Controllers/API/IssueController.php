<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\IssueService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueController extends Controller
{
    protected $issueService;

    public function __construct(IssueService $issueService)
    {
        $this->issueService = $issueService;
    }

    /**
     * GET /issue/hollyMass
     * Returns a specific issue used for "Holly Mass" logic.
     */
    public function hollyMass()
    {
        try {
            $issue = $this->issueService->getHollyMassIssue();
            return successResponse($issue);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * GET /issue/facebookAds
     * Returns a specific issue used for Facebook Ads reference.
     */
    public function facebookAds()
    {
        try {
            $issue = $this->issueService->getFacebookAdsIssue();
            return successResponse($issue);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * POST /apptask/refproPost
     * Updates the `ai_prompt` column on either an Issue or a Project.
     */
    public function refproPost(Request $request)
    {
        try {
            $this->issueService->updateAiPrompt($request->type, $request->id, $request->ai_prompt);
            return successResponse([]);
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
     * Fetches the model (Issue or Project) based on type and ID, 
     * typically to retrieve the `ai_prompt`.
     */
    public function refproGet(Request $request)
    {
        try {
            $model = $this->issueService->getAiPrompt($request->type, $request->id);
            return successResponse($model);
        } catch (Exception $e) {
            DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()),
                'created_at'      => now(),
            ]);
            return failedResponse($e->getMessage());
        }
    }
}
