<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Timer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TimerController extends Controller
{
    // One year at most, same as the app
    private const MAX_SECONDS = 365 * 86400;

    /**
     * GET /timers
     * The signed-in admin's timers, oldest first (the order they were added).
     */
    public function index()
    {
        try {
            return successResponse(
                Timer::where('admin_id', auth('admin-api')->id())->orderBy('id')->get()
            );
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /timers
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'action'       => 'required|string|max:255',
                'duration_sec' => 'required|integer|min:1|max:' . self::MAX_SECONDS,
            ]);

            return successResponse(Timer::create($data + ['admin_id' => auth('admin-api')->id()]));
        } catch (ValidationException $e) {
            return failedResponse($e->validator->errors()->first());
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * PUT /timers/{id}
     * Changes the action and / or the duration of one of the signed-in admin's timers.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'action'       => 'sometimes|required|string|max:255',
                'duration_sec' => 'sometimes|required|integer|min:1|max:' . self::MAX_SECONDS,
            ]);

            $timer = Timer::where('admin_id', auth('admin-api')->id())->findOrFail($id);
            $timer->update($data);

            return successResponse($timer);
        } catch (ValidationException $e) {
            return failedResponse($e->validator->errors()->first());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return failedResponse('This timer no longer exists.');
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * DELETE /timers/{id}
     */
    public function destroy($id)
    {
        try {
            Timer::where('admin_id', auth('admin-api')->id())->findOrFail($id)->delete();
            return successResponse([]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return failedResponse('This timer no longer exists.');
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }
}
