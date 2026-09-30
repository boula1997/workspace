<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MiscService;
use Exception;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    protected $miscService;

    public function __construct(MiscService $miscService)
    {
        $this->miscService = $miscService;
    }

    /**
     * POST /track
     * Logs incoming request data to the tracks table (debug endpoint).
     */
    public function track(Request $request)
    {
        try {
            $this->miscService->logTrack(json_encode($request->all()));

            return response()->json([
                'message' => 'User successfully registered',
                'user'    => [],
            ], 201);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /bases
     * Returns all base entries.
     */
    public function bases()
    {
        try {
            $bases = $this->miscService->getAllBases();

            return successResponse([
                'bases'     => $bases,
                'isExpired' => isExpired()[0],
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * GET /settings
     * Returns the current application settings.
     */
    public function settings(Request $request)
    {
        return successResponse(setting());
    }

    /**
     * GET /surveies
     * Returns 5 random active surveys.
     */
    public function surveies()
    {
        $surveies = $this->miscService->getRandomSurveys(5);

        return successResponse($surveies);
    }

    /**
     * GET /get/repeat/survey/minuits
     * Returns the repeat survey interval setting.
     */
    public function getRepeatSurveyMinuits()
    {
        return successResponse([
            'repeat_survey_minuits' => $this->miscService->getRepeatSurveyMinutes(),
        ]);
    }

    /**
     * GET /lastRepeatTime
     * Returns the date of the most recent repeat record.
     */
    public function lastRepeatTime(Request $request)
    {
        return successResponse([
            'lastRepeat' => $this->miscService->getLastRepeatDate(),
        ]);
    }

    /**
     * POST /createLastRepeatTime
     * Creates a new repeat time record for the given date.
     */
    public function createLastRepeatTime(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $this->miscService->createRepeatTime($request->date);

        return successResponse([]);
    }

    /**
     * POST /add/project/hours
     * Records worked hours for a project by an employee.
     */
    public function addProjectHours(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'admin_id'   => 'required|exists:admins,id',
            'hours'      => 'required|numeric',
        ]);

        $projectHour = $this->miscService->createProjectHour([
            'project_id'  => $request->project_id,
            'hours_count' => $request->hours,
            'employee_id' => $request->admin_id,
        ]);

        return successResponse($projectHour);
    }

    /**
     * GET /offline/notes
     * Returns up to 300 random notes (Boula-only).
     */
    public function offlineNotes(Request $request)
    {
        if (!boula()) {
            return successResponse([]);
        }

        $notes = $this->miscService->getRandomNotes(300);

        return successResponse($notes);
    }

    /**
     * GET /marketing/get-ready-response-messages
     * Returns all ready client response messages.
     */
    public function getReadyResponseMessages()
    {
        return successResponse($this->miscService->getReadyResponseMessages());
    }

    /**
     * GET /elements/category/{id}
     * Returns paginated, searchable elements for a given dynamic category.
     */
    public function elements($id, Request $request)
    {
        try {
            $filters = $request->only(['from', 'to', 'search', 'per_page']);
            
            $items = $this->miscService->getPaginatedElements($id, $filters);

            return response()->json([
                'status'  => 200,
                'message' => 'success',
                'data'    => ['elements' => $items],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
