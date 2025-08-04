<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MessageRequest;
use App\Models\Message;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function postFunction(Request $request)
    {

        try {
            $action = request()->query('action');
            if($action=="contactus"){
                $request->validate([
                'message' => 'required',
                ]);
                $data = Message::create($request->except('action'));
            }
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function getFunction(Request $request)
    {

        try {
            $action = request()->query('action');
            if($action=="getTasks")
            $data = Task::get();
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
}
