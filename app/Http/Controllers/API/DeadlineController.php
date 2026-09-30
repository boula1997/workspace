<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Deal;
use App\Models\Task;
use App\Services\DeadlineService;
use Exception;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    protected $deadlineService;

    public function __construct(DeadlineService $deadlineService)
    {
        $this->deadlineService = $deadlineService;
    }

    /**
     * GET /deadlines
     * Returns all pending deadlines ordered by date (Boula-only).
     */
    public function index()
    {
        try {
            $deadlines = $this->deadlineService->getPendingDeadlines();

            $data = [
                'deadlines' => $deadlines,
                'isExpired' => isExpired()[0],
            ];

            if (boula()) {
                return successResponse($data);
            }

            return successResponse([]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * POST /storeDeadline
     * Creates a new deadline (Boula-only).
     */
    public function store(Request $request)
    {
        try {
            if (boula()) {
                $this->deadlineService->createDeadline([
                    'title' => $request->title,
                    'date'  => $request->date,
                ]);
            }

            $deadlines = $this->deadlineService->getAllOrdered();

            return successResponse([
                'deadlines' => $deadlines,
                'action'    => $request->action,
            ]);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /updateDeadline
     * Toggles or updates a deadline; also syncs linked Task or Deal.
     */
    public function update(Request $request)
    {
        try {
            $deadline = $this->deadlineService->getDeadlineById($request->id);

            if ($request->action === 'delete') {
                if ($deadline->isForever) {
                    return successResponse([], 'Deadline is forever!', 201);
                }

                $this->deadlineService->updateDeadline($deadline->id, ['status' => !$deadline->status]);

                // Sync linked Task
                if ($deadline->deadlineable_type === Task::class && $deadline->deadlineable_id) {
                    $task = Task::find($deadline->deadlineable_id);
                    if ($task) {
                        $task->update(['status' => $deadline->status]);
                    }
                }

                // Sync linked Deal when status becomes 1
                if (
                    $deadline->deadlineable_type === Deal::class &&
                    $deadline->deadlineable_id &&
                    $deadline->status == 1
                ) {
                    $deal = Deal::find($deadline->deadlineable_id);
                    if ($deal) {
                        $deal->update(['isPaid' => 1]);
                    }
                }
            } elseif (isset($request->date)) {
                $this->deadlineService->updateDeadline($deadline->id, [
                    'date'  => $request->date,
                    'title' => $request->title ?? $deadline->title,
                ]);
            }

            $deadlines = $this->deadlineService->getAllOrdered();

            return successResponse([
                'boardProjects' => $deadlines,
                'action'        => $request->action,
            ]);
        } catch (Exception $e) {
            \Illuminate\Support\Facades\DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()),
                'created_at'      => now(),
            ]);
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /updatedSelectedDeadlines
     * Bulk-updates the date of multiple deadlines at once.
     */
    public function bulkUpdateDate(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:deadlines,id',
            'date'  => 'required|date',
        ]);

        $date = \Carbon\Carbon::parse($request->date)->toDateString();

        $this->deadlineService->bulkUpdateDates($request->ids, $date);

        return successResponse([]);
    }

    /**
     * POST /updateProjectDeadline
     * Updates the deadline field on a Project.
     */
    public function updateProjectDeadline(Request $request)
    {
        try {
            \Illuminate\Support\Facades\DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode($request->all()),
                'created_at'      => now(),
            ]);

            $this->deadlineService->updateProjectDeadline($request->id, $request->date);

            return successResponse([
                'boardProjects' => ProjectResource::collection(
                    $this->deadlineService->getPendingProjectsSortedByDeadline()
                ),
            ]);
        } catch (Exception $e) {
            \Illuminate\Support\Facades\DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()),
                'created_at'      => now(),
            ]);
            return failedResponse($e->getMessage());
        }
    }
}
