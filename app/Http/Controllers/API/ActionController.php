<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MessageRequest;
use App\Models\Message;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ActionController extends Controller
{
    public function postFunction(Request $request)
    {
        try {
            $action = request()->query('action');
            if ($action == "contactus") {
                $request->validate([
                    'message' => 'required',
                ]);
                $data = Message::create($request->except('action'));
            }
            return successResponse($data);
        } catch (Exception $e) {
            DB::table('tracks')->insert([
                'dispatch_status' => 'showing data of ' . json_encode([$e->getMessage()]),
                'created_at' => now(),
            ]);
            return failedResponse($e->getMessage());
        }
    }

public function getFunction(Request $request)
{
    try {
        $action = request()->query('action');
        if ($action == "getNotifications") {
            $notifications = [];

            $moneyProjects = Project::where('status', 2)
                ->where('cost', '>', 0)
                ->get();

            $renewProjects = Project::whereDate('renewalDate', '>=', Carbon::now()->subMonth())
                ->get();

            if ($moneyProjects->isNotEmpty()) {
                // Collect all project details into one string
                $mergedMoneyText = $moneyProjects->map(function ($project) {
                    return $project->title . "  with " . rest($project);
                })->implode(', ');

                // Push only one notification
                $notifications[] = "Projects due: " . $mergedMoneyText;
            }
            if ($renewProjects->isNotEmpty()) {
                // Collect all project details into one string
                $mergedRenewText = $renewProjects->map(function ($project) {
                    return $project->title . " renewal in " . $project->renewalDate;
                })->implode(', ');


                // Push only one notification
                $notifications[] = "Projects renew: " . $mergedRenewText ;
            }


            $data["notifications"] = $notifications;
        }

        return successResponse($data);
    } catch (Exception $e) {
        DB::table('tracks')->insert([
            'dispatch_status' => 'showing data of ' . json_encode([$e->getMessage()]),
            'created_at' => now(),
        ]);
        return failedResponse($e->getMessage());
    }
}

}

