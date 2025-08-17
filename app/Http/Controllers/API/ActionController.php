<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MessageRequest;
use App\Models\Message;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Deadline;
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
            if ($action == "searchHotels") {
              dd($request->all());
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
            $notificationMessage = ""; // one single string

            $moneyProjects = Project::where('status', 2)
                ->where('cost', '>', 0)
                ->get();

            $renewProjects = Project::whereDate('renewalDate', '<=', Carbon::now()->addMonth())
                ->whereDate('renewalDate', '>=', Carbon::now())
                ->orderBy('renewalDate', 'asc')
                ->get();

            $commitProjects = Project::whereDate('deadline', '<=', Carbon::now()->addMonth())
                ->whereDate('deadline', '>=', Carbon::now())
                ->orderBy('deadline', 'asc')
                ->get();

            $deadlines = Deadline::whereDate('date', '<=', Carbon::now()->addWeek())
                ->whereDate('date', '>=', Carbon::now())
                ->orderBy('date', 'asc')
                ->get();

            $issues = Issue::where('isNotification', 1)
                ->orderBy('title', 'desc')
                ->get();

            if ($moneyProjects->isNotEmpty()) {
                $mergedMoneyText = $moneyProjects->map(function ($project) {
                    return "- " . $project->title . " with " . rest($project);
                })->implode("\n");

                $notificationMessage .= "💰 Projects due:\n" . $mergedMoneyText . "\n\n";
            }

            if ($renewProjects->isNotEmpty()) {
                $mergedRenewText = $renewProjects->map(function ($project) {
                    return "- " . $project->title . " renewal in " . $project->renewalDate;
                })->implode("\n");

                $notificationMessage .= "🔄 Projects renew:\n" . $mergedRenewText . "\n\n";
            }

            if ($commitProjects->isNotEmpty()) {
                $mergedCommitText = $commitProjects->map(function ($project) {
                    return "- " . $project->title . " commit in " . $project->deadline;
                })->implode("\n");

                $notificationMessage .= "📝 Projects commit:\n" . $mergedCommitText . "\n\n";
            }

            if ($deadlines->isNotEmpty() && boula()) {
                $mergedDateText = $deadlines->map(function ($deadline) {
                    return "- " . $deadline->title . " in " . $deadline->date;
                })->implode("\n");

                $notificationMessage .= "⏳ Deadline actions:\n" . $mergedDateText . "\n\n";
            }

            if ($issues->isNotEmpty() && boula()) {
                $mergedIssueText = $issues->map(function ($issue) {
                    return "- " . $issue->title;
                })->implode("\n");

                $notificationMessage .= "⚠️ Important Issues:\n" . $mergedIssueText . "\n\n";
            }

            // Final output: ONE notification string
            $data["notifications"] = [trim($notificationMessage)];
            $data["period"] = settings()->period;
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
