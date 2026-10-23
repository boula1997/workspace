<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Admin;
use App\Models\Project;
use App\Services\TaskService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        updateStopClosingStatus();
        $this->taskService = $taskService;
    }

    // ─────────────────────────────────────────────
    //  Basic CRUD
    // ─────────────────────────────────────────────

    /**
     * GET /tasks
     * Returns all tasks.
     */
    public function index()
    {
        try {
            $data['tasks'] = TaskResource::collection($this->taskService->getAllTasks());
            return successResponse($data);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /tasks/{id}
     * Returns a single task.
     */
    public function show($id)
    {
        try {
            $data['task'] = new TaskResource($this->taskService->getTaskById($id));
            return successResponse($data);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /apptask/create
     * Returns data needed to render the task creation form.
     */
    public function create(Request $request)
    {
        $employees = $this->taskService->getEmployeesWithTaskCounts();

        if (auth('api')->user()->email == 'parcel@gmail.com') {
            $employees = Admin::where('email', auth('api')->user()->email)->get();
        }

        $clients      = Admin::where('is_active', 1)->where('type', 'client')->orderBy('name')->get();
        $prospectives = Admin::where('is_active', 1)->where('type', 'prospective')->orderBy('name')->get();

        if (auth('api')->user()->email == 'parcel@gmail.com') {
            $projects = Project::withoutGlobalScope('excludePersonal')
                ->where('title', 'Parcel Express')
                ->orderBy('title')
                ->get();
        } else {
            $projects = Project::withoutGlobalScope('excludePersonal')
                ->where('appearance', 1)
                ->orderBy('title')
                ->get();
        }

        $tasks = $this->taskService->paginateTasks($request, ['ignore_user_scope' => false]);

        return successResponse([
            'projects'     => ProjectResource::collection($projects),
            'employees'    => $employees,
            'clients'      => $clients,
            'prospectives' => $prospectives,
            'tasks'        => TaskResource::collection($tasks),
            'tasks_meta'   => [
                'current_page' => $tasks->currentPage(),
                'last_page'    => $tasks->lastPage(),
                'per_page'     => $tasks->perPage(),
                'total'        => $tasks->total(),
            ],
            'last_time' => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
        ]);
    }

    /**
     * POST /apptask/store
     * Creates one or more tasks (supports '+'-separated titles and base64 images).
     */
    public function store(Request $request)
    {
        try {
            $overthinkingTasks = \App\Models\Task::where('is_overthinking', 1)->get();
            $allTasks          = \App\Models\Task::get();

            if (count($allTasks) == count($overthinkingTasks) && !isWithinWorkingHours()) {
                return failedResponse([]);
            }

            $validated = $request->validate([
                'tasks'                   => 'required|array|min:1',
                'tasks.*.title'           => 'required|string',
                'tasks.*.project_id'      => 'required|integer|exists:projects,id',
                'tasks.*.employees'       => 'required|array|min:1',
                'tasks.*.employees.*'     => 'integer',
                'tasks.*.piority'         => 'nullable',
                'tasks.*.deadline'        => 'nullable|date',
                'tasks.*.images'          => 'nullable|array|max:6',
                'tasks.*.images.*.base64' => 'required_with:tasks.*.images|string',
                'tasks.*.images.*.name'   => 'nullable|string',
                'tasks.*.images.*.type'   => 'nullable|string',
            ]);

            $destinationPath = public_path('uploads/tasks');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $createdTasks = [];

            foreach ($validated['tasks'] as $taskData) {
                foreach (explode('+', $taskData['title']) as $title) {
                    $title = trim($title);
                    if (empty($title)) continue;

                    // Skip duplicate titles in the same project
                    $exists = \App\Models\Task::where('title', $title)
                        ->where('project_id', $taskData['project_id'])
                        ->exists();

                    if ($exists) continue;

                    $newTask = $this->taskService->createTask([
                        'title'      => $title,
                        'admin_id'   => 1,
                        'project_id' => $taskData['project_id'],
                        'date'       => $taskData['deadline'] ?? null,
                        'piority'    => $taskData['piority'] ?? 0,
                        'employees'  => $taskData['employees'],
                    ]);

                    $this->attachBase64Images($newTask, $taskData['images'] ?? [], $destinationPath);

                    $newTask->load('files');
                    $createdTasks[] = $newTask;
                }
            }

            return successResponse($createdTasks);
        } catch (Exception $e) {
            DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()),
                'created_at'      => now(),
            ]);

            return response()->json([
                'status'  => 500,
                'message' => 'error',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    //  Task Listing
    // ─────────────────────────────────────────────

    /**
     * GET /apptask/tasks
     * Returns a filtered, paginated task list in a lightweight format.
     */
    public function tasks(Request $request)
    {
        $tasks = $this->taskService->paginateTasks($request, [], 20);

        $formatted = $tasks->getCollection()->map(fn($task) => [
            'id'         => $task->id,
            'title'      => $task->title,
            'project'    => $task->project?->title ?? 'AM*Wo8owc^7',
            'project_id' => $task->project_id,
            'employee'   => $this->resolveEmployeeNames($task->employees),
            'employees'  => $task->employees,
            'date'       => $task->date,
            'created_at' => $task->created_at?->format('Y-m-d'),
            'piority'    => $task->piority,
            'status'     => $task->status,
            'isDeleted'  => $task->is_active == 0,
            'is_fixed'    => $task->is_fixed,
        ]);

        return response()->json([
            'status' => 200,
            'data'   => [
                'tasks'      => $formatted,
                'tasks_meta' => [
                    'current_page' => $tasks->currentPage(),
                    'last_page'    => $tasks->lastPage(),
                    'total'        => $tasks->total(),
                    'per_page'     => $tasks->perPage(),
                ],
            ],
        ]);
    }

    /**
     * GET /offline/tasks
     */
    public function offlineTasks(Request $request)
    {
        $tasks = $this->taskService->getOfflineTasks($request);
        return successResponse(TaskResource::collection($tasks));
    }

    /**
     * GET /apptask/create/finished
     */
    public function createFinished(Request $request)
    {
        $tasks = \App\Models\Task::filter($request, ['ignore_user_scope' => false])
            ->where('status', 1)
            ->paginate(20); // Simplified for speed

        return successResponse([
            'tasks'      => TaskResource::collection($tasks),
            'tasks_meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page'    => $tasks->lastPage(),
                'per_page'     => $tasks->perPage(),
                'total'        => $tasks->total(),
            ],
        ]);
    }

    /**
     * GET /apptask/finished/tasks
     */
    public function finishedTasks(Request $request)
    {
        return $this->createFinished($request);
    }

    /**
     * GET apptask/by-credential/{db_credential_id}
     */
    public function tasksByCredential(Request $request, $db_credential_id)
    {
        try {
            $tasks = $this->taskService->getTasksByCredential($request, $db_credential_id, $request->per_page ?? 7);

            $formatted = $tasks->getCollection()->map(fn($task) => [
                'id'         => $task->id,
                'title'      => $task->title,
                'project'    => $task->project?->title ?? 'AM*Wo8owc^7',
                'project_id' => $task->project_id,
                'employee'   => $this->resolveEmployeeNames($task->employees),
                'employees'  => $task->employees,
                'date'       => $task->date,
                'created_at' => $task->created_at?->format('Y-m-d'),
                'piority'    => $task->piority,
                'status'     => $task->status,
                'is_fixed'    => $task->is_fixed,
                'images'     => $task->images,
            ]);

            $employees = $this->taskService->getEmployeesWithTaskCounts();

            return response()->json([
                'status' => 200,
                'data'   => [
                    'employees'  => $employees,
                    'tasks'      => $formatted,
                    'tasks_meta' => [
                        'current_page' => $tasks->currentPage(),
                        'last_page'    => $tasks->lastPage(),
                        'total'        => $tasks->total(),
                        'per_page'     => $tasks->perPage(),
                    ],
                ],
            ]);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    // ─────────────────────────────────────────────
    //  Task Status & Priority
    // ─────────────────────────────────────────────

    /**
     * GET /deleteTask/{id}
     */
    public function toggleStatus($id)
    {
        try {
            if (!isWithinWorkingHours()) {
                return failedResponse([]);
            }

            $task = \App\Models\Task::findOrFail($id);
            if ($task->is_fixed) {
                return failedResponse([]);
            }

            $this->taskService->toggleTaskStatus($id);

            return successResponse($task->fresh());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * POST /apptask/complete/{id}
     * Marks a task done. Unlike toggleStatus this never re-opens a finished task, so it is safe to call
     * from a notification button that may fire for a task that was already completed.
     */
    public function completeTask($id)
    {
        try {
            $task = \App\Models\Task::findOrFail($id);
            if ($task->is_fixed) {
                return failedResponse([]);
            }
            if (!$task->status) {
                $task->update(['status' => 1]);
            }
            return successResponse($task->fresh());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * GET /piority/toggle/{id}
     */
    public function togglePiority($id)
    {
        try {
            if (!isWithinWorkingHours()) {
                return failedResponse([]);
            }

            $result = $this->taskService->toggleTaskPriority($id);

            if (!$result['success']) {
                return response()->json([
                    'status'  => false,
                    'message' => $result['message'],
                ], 400);
            }

            return response()->json(['success' => __('general.changed_successfully' . $result['task']->piority)]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // ─────────────────────────────────────────────
    //  Bulk Operations
    // ─────────────────────────────────────────────

    /**
     * POST /apptask/bulk-delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'task_ids'   => 'required|array|min:1',
            'task_ids.*' => 'integer|exists:tasks,id',
        ]);

        $adminId = auth('api')->user()->id;
        $tasks   = $this->taskService->bulkDeleteTasks($request->task_ids, $adminId);

        $affected = $tasks->where('is_fixed', 0)->count();

        return response()->json([
            'status'  => 200,
            'message' => "$affected task(s) toggled successfully.",
            'data'    => [
                'affected' => $affected,
                'skipped'  => $tasks->where('is_fixed', 1)->count(),
                'tasks'    => $tasks->map(fn($t) => [
                    'id'      => $t->id,
                    'status'  => $t->status,
                    'is_fixed' => $t->is_fixed,
                ]),
            ],
        ]);
    }

    /**
     * POST /apptask/bulk-assign
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'task_ids'       => 'required|array|min:1',
            'task_ids.*'     => 'integer|exists:tasks,id',
            'employee_ids'   => 'required|array|min:1',
            'employee_ids.*' => 'integer|exists:admins,id',
        ]);

        $affected = $this->taskService->bulkAssignTasks($request->task_ids, $request->employee_ids, auth('api')->user()->id);

        return response()->json([
            'status'  => 200,
            'message' => "$affected task(s) assigned successfully.",
            'data'    => ['affected' => $affected],
        ]);
    }

    /**
     * POST /apptask/bulk-assign-project
     */
    public function bulkAssignProject(Request $request)
    {
        $this->taskService->bulkAssignProject($request->task_ids, $request->project_id);
        return response()->json(['status' => 200, 'message' => 'Project assigned']);
    }

    /**
     * POST /apptask/bulk-update-date
     */
    public function bulkUpdateDate(Request $request)
    {
        $request->validate([
            'task_ids'   => 'required|array|min:1',
            'task_ids.*' => 'integer|exists:tasks,id',
            'date'       => 'required|date_format:Y-m-d',
        ]);

        $updated = $this->taskService->bulkUpdateTaskDate($request->task_ids, $request->date, auth('api')->user()->id);

        return response()->json([
            'status'  => 200,
            'message' => "$updated task(s) date updated to {$request->date}.",
            'data'    => ['affected' => $updated, 'date' => $request->date],
        ]);
    }

    /**
     * POST /update/tasks/to/today
     */
    public function updateTasksToToday()
    {
        $updated = $this->taskService->updateTasksToToday();
        return successResponse($updated);
    }

    // ─────────────────────────────────────────────
    //  Task Updates
    // ─────────────────────────────────────────────

    /**
     * POST /apptask/update-task/{id}
     */
    public function updateTaskTitleAndComments(Request $request, $id)
    {
        $request->validate([
            'title'    => 'sometimes|string|max:255',
            'comments' => 'sometimes|nullable|string',
        ]);

        $payload = [];
        if ($request->has('title') && trim($request->title) !== '') {
            $payload['title'] = trim($request->title);
        }
        if ($request->has('comments')) {
            $payload['comments'] = $request->comments;
        }

        if (empty($payload)) {
            return response()->json([
                'status'  => 422,
                'message' => 'No updatable fields provided.',
            ], 422);
        }

        $task = $this->taskService->updateTaskTitleAndComments($id, $payload);
        return successResponse($task);
    }

    // ─────────────────────────────────────────────
    //  Async / Offline Sync
    // ─────────────────────────────────────────────

    /**
     * POST /async/create
     * Atomic batch endpoint for the app's offline queues: creates tasks, notes, phone/post gigs and
     * surveys; updates and deletes tasks; and reassigns employees - all in one transaction.
     * Everything is validated first, so a 422 means nothing was saved.
     */
    public function asyncCreate(Request $request)
    {
        $request->validate([
            'tasks'            => 'nullable|array',
            'notes'            => 'nullable|array',
            'phone_gigs'       => 'nullable|array',
            'post_gigs'        => 'nullable|array',
            'task_updates'     => 'nullable|array',
            'task_deletes'     => 'nullable|array',
            'task_assignments' => 'nullable|array',
            'surveys'          => 'nullable|array',
            'plans'            => 'nullable|array',
            'learnings'        => 'nullable|array',
        ]);

        $errors = [];
        $filled = fn ($value) => is_string($value) ? trim($value) !== '' : !empty($value);

        foreach ($request->tasks ?? [] as $index => $item) {
            if (!$filled($item['title'] ?? null)) {
                $errors[] = "tasks[$index]: title is required.";
            }
            if (empty($item['project_id'])) {
                $errors[] = "tasks[$index]: project is required.";
            }
        }

        foreach ($request->notes ?? [] as $index => $item) {
            if (!$filled($item['title'] ?? null)) {
                $errors[] = "notes[$index]: title is required.";
            }
        }

        $seenPhones = [];
        foreach ($request->phone_gigs ?? [] as $index => $item) {
            $phone = trim((string) ($item['phone'] ?? ''));

            if ($phone === '') {
                $errors[] = "phone_gigs[$index]: phone is required.";
            } elseif (\App\Models\phoneGig::where('phone', $phone)->exists() || isset($seenPhones[$phone])) {
                $errors[] = "phone_gigs[$index]: phone '$phone' already exists.";
            }
            $seenPhones[$phone] = true;

            if (!$filled($item['description'] ?? null)) {
                $errors[] = "phone_gigs[$index]: description is required.";
            }
            if (!in_array($item['type'] ?? null, ['job', 'freelance'], true)) {
                $errors[] = "phone_gigs[$index]: type must be job or freelance.";
            }
        }

        foreach ($request->post_gigs ?? [] as $index => $item) {
            if (!$filled($item['post_link'] ?? null)) {
                $errors[] = "post_gigs[$index]: post_link is required.";
            }
            if (!$filled($item['description'] ?? null)) {
                $errors[] = "post_gigs[$index]: description is required.";
            }
            if (!in_array($item['type'] ?? null, ['job', 'freelance'], true)) {
                $errors[] = "post_gigs[$index]: type must be job or freelance.";
            }
        }

        foreach ($request->surveys ?? [] as $index => $item) {
            if (!$filled($item['question'] ?? null)) {
                $errors[] = "surveys[$index]: question is required.";
            }
        }

        foreach ($request->plans ?? [] as $index => $item) {
            $name = trim((string) ($item['name'] ?? ''));
            if ($name === '') {
                $errors[] = "plans[$index]: name is required.";
            } elseif (mb_strlen($name) > 255) {
                $errors[] = "plans[$index]: name must not be longer than 255 characters.";
            }
        }

        foreach ($request->learnings ?? [] as $index => $item) {
            $title = trim((string) ($item['title'] ?? ''));
            if ($title === '') {
                $errors[] = "learnings[$index]: title is required.";
            } elseif (mb_strlen($title) > 255) {
                $errors[] = "learnings[$index]: title must not be longer than 255 characters.";
            }
            if (isset($item['status']) && !in_array($item['status'], \App\Models\Learning::STATUSES, true)) {
                $errors[] = "learnings[$index]: status must be one of " . implode(', ', \App\Models\Learning::STATUSES) . '.';
            }
        }

        foreach ($request->task_updates ?? [] as $index => $item) {
            if (empty($item['task_id'])) {
                $errors[] = "task_updates[$index]: task_id is required.";
                continue;
            }

            $hasFields = array_key_exists('title', $item)
                || array_key_exists('date', $item)
                || array_key_exists('project_id', $item)
                || array_key_exists('employees', $item)
                || array_key_exists('comments', $item);

            if (!$hasFields) {
                $errors[] = "task_updates[$index]: no updatable fields provided.";
            }

            if (array_key_exists('title', $item) && !$filled($item['title'])) {
                $errors[] = "task_updates[$index]: title cannot be empty when provided.";
            }
        }

        foreach ($request->task_deletes ?? [] as $index => $item) {
            if (empty($item['task_id'])) {
                $errors[] = "task_deletes[$index]: task_id is required.";
            }
        }

        foreach ($request->task_assignments ?? [] as $index => $item) {
            if (empty($item['task_id'])) {
                $errors[] = "task_assignments[$index]: task_id is required.";
                continue;
            }
            if (empty($item['employee_ids']) || !is_array($item['employee_ids'])) {
                $errors[] = "task_assignments[$index]: employee_ids must be a non-empty array.";
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validation failed. Nothing was saved.',
                'errors'  => $errors,
            ], 422);
        }

        // The route requires a signed-in admin: they are the author of everything created here
        $adminId = auth('admin-api')->id();

        DB::beginTransaction();

        try {
            $created = [
                'tasks'      => [],
                'notes'      => [],
                'phone_gigs' => [],
                'post_gigs'  => [],
                'surveys'    => [],
                'plans'      => [],
                'learnings'  => [],
            ];

            $destinationPath = public_path('uploads/tasks');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // SURVEYS
            foreach ($request->surveys ?? [] as $item) {
                $survey = \App\Models\Survey::create([
                    'question'  => trim($item['question']),
                    'is_active' => $item['is_active'] ?? $item['isActive'] ?? 1,
                    'link'      => $item['link'] ?? null,
                    'phone'     => $item['phone'] ?? null,
                    'whatsapp'  => $item['whatsapp'] ?? null,
                ]);

                $created['surveys'][] = [
                    'temp_id' => $item['id'] ?? null,
                    'real_id' => $survey->id,
                ];
            }

            // CREATE TASKS (a title with "+" makes several tasks)
            foreach ($request->tasks ?? [] as $item) {
                foreach (explode('+', $item['title']) as $title) {
                    $title = trim($title);
                    if (!$title) continue;

                    $task = $this->taskService->createTask([
                        'title'      => $title,
                        'admin_id'   => $adminId,
                        'project_id' => $item['project_id'] ?? null,
                        'employees'  => $item['employees'] ?? [],
                        'date'       => $item['date'] ?? null,
                        'piority'    => 0,
                    ]);

                    $this->attachBase64Images($task, $item['images'] ?? [], $destinationPath);

                    $created['tasks'][] = [
                        'temp_id' => $item['id'] ?? null,
                        'real_id' => $task->id,
                        'title'   => $task->title,
                    ];
                }
            }

            // UPDATE TASKS
            foreach ($request->task_updates ?? [] as $item) {
                $task = \App\Models\Task::find($item['task_id']);
                if (!$task) continue;

                $payload = [];
                if (array_key_exists('title', $item))      $payload['title']      = trim($item['title']);
                if (array_key_exists('date', $item))       $payload['date']       = $item['date'];
                if (array_key_exists('project_id', $item)) $payload['project_id'] = $item['project_id'];
                if (array_key_exists('employees', $item))  $payload['employees']  = $item['employees'];
                if (array_key_exists('comments', $item))   $payload['comments']   = $item['comments'];

                if (!empty($payload)) {
                    $task->update($payload);
                }
            }

            // TASK ASSIGNMENTS
            foreach ($request->task_assignments ?? [] as $item) {
                $task = \App\Models\Task::find($item['task_id']);
                if (!$task) continue;

                $task->update(['employees' => $item['employee_ids']]);
            }

            // DELETE TASKS (soft-delete via status=1)
            foreach ($request->task_deletes ?? [] as $item) {
                \App\Models\Task::where('id', $item['task_id'])->update(['status' => 1]);
            }

            // NOTES
            foreach ($request->notes ?? [] as $item) {
                $note = \App\Models\Note::create(['title' => trim($item['title'])]);

                $created['notes'][] = [
                    'temp_id' => $item['id'] ?? null,
                    'real_id' => $note->id,
                ];
            }

            // PHONE GIGS
            foreach ($request->phone_gigs ?? [] as $item) {
                $phoneGig = \App\Models\phoneGig::create([
                    'phone'       => trim($item['phone']),
                    'description' => $item['description'],
                    'type'        => $item['type'],
                    'author_id'   => $adminId,
                ]);

                $created['phone_gigs'][] = [
                    'temp_id' => $item['id'] ?? null,
                    'real_id' => $phoneGig->id,
                ];
            }

            // POST GIGS
            foreach ($request->post_gigs ?? [] as $item) {
                $postGig = \App\Models\postGig::create([
                    'post_link'   => trim($item['post_link']),
                    'description' => $item['description'],
                    'type'        => $item['type'],
                    'author_id'   => $adminId,
                ]);

                $created['post_gigs'][] = [
                    'temp_id' => $item['id'] ?? null,
                    'real_id' => $postGig->id,
                ];
            }

            // PLANS (same rule as PlanController: at most one current plan per admin; the last one queued wins)
            foreach ($request->plans ?? [] as $item) {
                $makeCurrent = filter_var($item['is_current'] ?? false, FILTER_VALIDATE_BOOLEAN);
                if ($makeCurrent) {
                    \App\Models\Plan::where('admin_id', $adminId)->update(['is_current' => false]);
                }

                $description = isset($item['description']) ? trim((string) $item['description']) : '';
                $plan = \App\Models\Plan::create([
                    'admin_id'    => $adminId,
                    'name'        => trim($item['name']),
                    'description' => $description !== '' ? $description : null,
                    'is_current'  => $makeCurrent,
                ]);

                $created['plans'][] = [
                    'temp_id' => $item['id'] ?? null,
                    'real_id' => $plan->id,
                ];
            }

            // LEARNINGS
            foreach ($request->learnings ?? [] as $item) {
                $notes = isset($item['notes']) ? trim((string) $item['notes']) : '';
                $learning = \App\Models\Learning::create([
                    'admin_id' => $adminId,
                    'title'    => trim($item['title']),
                    'notes'    => $notes !== '' ? $notes : null,
                    'status'   => $item['status'] ?? 'todo',
                ]);

                $created['learnings'][] = [
                    'temp_id' => $item['id'] ?? null,
                    'real_id' => $learning->id,
                ];
            }

            DB::commit();

            return successResponse(['created' => $created]);
        } catch (Exception $e) {
            DB::rollBack();
            return failedResponse($e->getMessage());
        }
    }

    // ─────────────────────────────────────────────
    //  Client Tasks
    // ─────────────────────────────────────────────

    /**
     * GET /client/tasks
     */
    public function clientTasks(Request $request)
    {
        $request->validate([
            'project_id' => 'nullable|integer|exists:projects,id',
            'status'     => 'nullable|string',
            'from'       => 'nullable|date',
            'to'         => 'nullable|date|after_or_equal:from',
            'page'       => 'nullable|integer|min:1',
            'per_page'   => 'nullable|integer|min:1|max:100',
        ]);

        $query = \App\Models\Task::query()
            ->with('files')
            ->where('project_id', $request->project_id)
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('from'), fn($q) => $q->where('created_at', '>=', \Carbon\Carbon::parse($request->from)->startOfDay()))
            ->when($request->filled('to'), fn($q) => $q->where('created_at', '<=', \Carbon\Carbon::parse($request->to)->endOfDay()));

        $tasks = $query->orderBy('created_at', 'desc')->paginate($request->input('per_page', 20));

        $tasks->getCollection()->transform(function ($task) {
            $task->images = $task->files->map(fn($f) => \Storage::disk('public')->url($f->url));
            return $task;
        });

        return response()->json([
            'status'  => 200,
            'message' => 'success',
            'data'    => [
                'tasks'      => $tasks->items(),
                'tasks_meta' => [
                    'current_page' => $tasks->currentPage(),
                    'last_page'    => $tasks->lastPage(),
                    'per_page'     => $tasks->perPage(),
                    'total'        => $tasks->total(),
                ],
            ],
        ]);
    }

    /**
     * POST /client/tasks/store
     */
    public function clientTaskStore(Request $request)
    {
        $validated = $request->validate([
            'project_id'              => 'required|integer|exists:projects,id',
            'tasks'                   => 'required|array|min:1',
            'tasks.*.title'           => 'required|string|max:255',
            'tasks.*.employees'       => 'nullable|array',
            'tasks.*.employees.*'     => 'integer',
            'tasks.*.deadline'        => 'nullable|date',
            'tasks.*.piority'         => 'nullable',
            'tasks.*.images'          => 'nullable|array|max:6',
            'tasks.*.images.*.base64' => 'required_with:tasks.*.images|string',
            'tasks.*.images.*.name'   => 'nullable|string',
            'tasks.*.images.*.type'   => 'nullable|string',
        ]);

        $ownsProject = Project::withoutGlobalScopes()->where('id', $validated['project_id'])->exists();
        if (!$ownsProject) {
            return response()->json([
                'status'  => 403,
                'message' => 'You do not have access to this project.',
            ], 403);
        }

        $destinationPath = public_path('uploads/tasks');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $created = collect($validated['tasks'])->map(function ($task) use ($validated, $destinationPath) {
            $newTask = $this->taskService->createTask([
                'title'      => $task['title'],
                'project_id' => $validated['project_id'],
                'status'     => 0,
                'date'       => $task['deadline'] ?? now()->toDateString(),
                'is_fixed'    => false,
                'piority'    => $task['piority'] ?? 0,
                'employees'  => $task['employees'] ?? [],
            ]);

            $this->attachBase64Images($newTask, $task['images'] ?? [], $destinationPath);

            $newTask->load('files');
            $newTask->images = $newTask->files->map(fn($file) => asset($file->url));

            return $newTask;
        });

        return response()->json([
            'status'  => 201,
            'message' => 'success',
            'data'    => $created,
        ], 201);
    }

    // ─────────────────────────────────────────────
    //  Private Helpers
    // ─────────────────────────────────────────────

    private function attachBase64Images(\App\Models\Task $task, array $images, string $destinationPath): void
    {
        foreach ($images as $imageData) {
            $base64 = $imageData['base64'] ?? null;
            if (!$base64) continue;

            $filename = $imageData['name'] ?? (uniqid() . '.jpg');

            if (strpos($base64, 'base64,') !== false) {
                $base64 = explode('base64,', $base64)[1];
            }

            $imageBinary = base64_decode($base64);
            if ($imageBinary === false) continue;

            $extension      = pathinfo($filename, PATHINFO_EXTENSION) ?: 'jpg';
            $uniqueFilename = time() . '_' . uniqid() . '.' . $extension;

            file_put_contents($destinationPath . '/' . $uniqueFilename, $imageBinary);

            $task->files()->create([
                'url' => 'uploads/tasks/' . $uniqueFilename,
            ]);
        }
    }

    private function resolveEmployeeNames($employees): string
    {
        if (empty($employees)) return '';

        if (is_string($employees)) {
            $employees = json_decode($employees, true);
        }

        if (empty($employees) || !is_array($employees)) return '';

        $ids = array_filter($employees, fn($id) => is_numeric($id));

        if (empty($ids)) return '';

        return Admin::whereIn('id', $ids)
            ->orderBy('name')
            ->pluck('name')
            ->implode(', ');
    }
}