<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Base;
use App\Models\Category;
use App\Models\Note;
use App\Models\Projecthour;
use App\Models\ReadyClientResbonseMessage;
use App\Models\Repeat;
use App\Models\Survey;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MiscController extends Controller
{
    /**
     * POST /track
     * Logs incoming request data to the tracks table (debug endpoint).
     */
    public function track(Request $request)
    {
        try {
            DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode(request()->all()),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

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
            $bases = Base::get();

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
        $surveies = Survey::query()
            ->where('isActive', 1)
            ->get()
            ->shuffle()
            ->take(5)
            ->values();

        return successResponse($surveies);
    }

    /**
     * GET /get/repeat/survey/minuits
     * Returns the repeat survey interval setting.
     */
    public function getRepeatSurveyMinuits()
    {
        return successResponse([
            'repeat_survey_minuits' => setting()->repeat_survey_minuits,
        ]);
    }

    /**
     * GET /lastRepeatTime
     * Returns the date of the most recent repeat record.
     */
    public function lastRepeatTime(Request $request)
    {
        $lastRepeat = Repeat::latest()->first();

        return successResponse([
            'lastRepeat' => $lastRepeat
                ? Carbon::parse($lastRepeat->date)->timezone('Africa/Cairo')->toDateString()
                : null,
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

        Repeat::create([
            'date'       => Carbon::parse($request->date)->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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

        $projectHour = Projecthour::create([
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

        $notes = Note::inRandomOrder()->take(300)->get();

        return successResponse($notes);
    }

    /**
     * GET /marketing/get-ready-response-messages
     * Returns all ready client response messages.
     */
    public function getReadyResponseMessages()
    {
        return successResponse(ReadyClientResbonseMessage::latest()->get());
    }

    /**
     * GET /elements/category/{id}
     * Returns paginated, searchable elements for a given dynamic category.
     */
    public function elements($id, Request $request)
    {
        try {
            $category = Category::withoutGlobalScopes()->findOrFail($id);

            if (!$category->model) {
                return response()->json(['error' => 'Model not defined'], 400);
            }

            if (!class_exists($category->model)) {
                return response()->json([
                    'error' => 'Model class not found',
                    'model' => $category->model,
                ], 400);
            }

            $model       = $category->model;
            $searchKeys  = $category->search_keys ?? [];
            $titleField  = 'id';
            $configClass = $category->config_class ?? \App\CategoryConfigs\BaseCategoryConfig::class;

            if (!class_exists($configClass)) {
                return response()->json(['error' => 'Invalid config class'], 400);
            }

            // Normalize search keys to array
            if (is_string($searchKeys)) {
                $searchKeys = array_map('trim', explode(',', $searchKeys));
            }

            // Eager-load relations referenced in search keys
            $relations = array_unique(array_filter(
                array_map(fn($key) => strstr($key, '.', true) ?: null, $searchKeys)
            ));

            $query = $model::with($relations)->latest()->withoutGlobalScopes();

            // Date filters
            if ($request->from) {
                $query->whereDate('created_at', '>=', $request->from);
            }
            if ($request->to) {
                $query->whereDate('created_at', '<=', $request->to);
            }

            // Dynamic search
            if ($request->search) {
                $values = array_filter(array_map('trim', explode(',', $request->search)));
                $configClass::applySearch($query, $values, $searchKeys);
            }

            $items = $query->paginate($request->per_page ?? 20);

            // Transform items and append 'extra' field
            $items->getCollection()->transform(function ($item) use ($configClass, $titleField, $searchKeys) {
                $transformed  = $configClass::transform($item, $titleField);
                $extraValues  = [];

                foreach ($searchKeys as $key) {
                    $value = data_get($item, trim($key));
                    if ($value !== null && $value !== '') {
                        $extraValues[] = $value;
                    }
                }

                $transformed['extra'] = implode(', ', $extraValues);

                return $transformed;
            });

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
