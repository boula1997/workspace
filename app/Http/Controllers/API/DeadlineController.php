<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Deadline;
use App\Models\Deal;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeadlineController extends Controller
{
    /**
     * GET /deadlines
     * Returns all pending deadlines ordered by date (Boula-only).
     */
    public function index()
    {
        try {
            $deadlines = Deadline::where('status', 0)->orderBy('date', 'asc')->get();

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
                Deadline::create([
                    'title' => $request->title,
                    'date'  => $request->date,
                ]);
            }

            $deadlines = Deadline::orderBy('date', 'asc')->get();

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
            $deadline = Deadline::find($request->id);

            if ($request->action === 'delete') {
                if ($deadline->isForever) {
                    return successResponse([], 'Deadline is forever!', 201);
                }

                $deadline->update(['status' => !$deadline->status]);

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
                $deadline->update([
                    'date'  => $request->date,
                    'title' => $request->title ?? $deadline->title,
                ]);
            }

            $deadlines = Deadline::orderBy('date', 'asc')->get();

            return successResponse([
                'boardProjects' => $deadlines,
                'action'        => $request->action,
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

        $date = Carbon::parse($request->date)->toDateString();

        Deadline::query()
            ->whereIn('id', $request->ids)
            ->where('status', 0) // only unfinished
            ->update([
                'date'       => $date,
                'updated_at' => now(),
            ]);

        return successResponse([]);
    }

    /**
     * POST /updateProjectDeadline
     * Updates the deadline field on a Project.
     */
    public function updateProjectDeadline(Request $request)
    {
        try {
            DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode($request->all()),
                'created_at'      => now(),
            ]);

            $project      = Project::find($request->id);
            $deadlineTime = Carbon::parse($request->date, 'UTC')->setTimezone('Africa/Cairo');
            $project->update(['deadline' => $deadlineTime]);

            return successResponse([
                'boardProjects' => ProjectResource::collection(
                    Project::orderBy('deadline', 'asc')
                        ->get()
                        ->filter(fn($project) => $project->status != 1)
                ),
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
