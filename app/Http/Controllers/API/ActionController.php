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
            $notifications = []; // one single string
            $boardProjects = Project::get();
            $moneyProjects = $boardProjects->filter(function ($project) {
                return $project->status == 2 && $project->cost > 0;
            });

            $renewProjects = Project::whereNotNull('renewalDate')
                ->orderBy('renewalDate', 'asc')
                ->get();

            $commitProjects = Project::whereNotNull('deadline')
                ->whereDate('deadline', '<=', Carbon::now()->addMonth())
                ->whereHas('tasks', function ($q) {
                    $q->where('status', 0);
                })
                ->with('feeses') // 👈 needed for rest calculation
                ->orderBy('deadline', 'asc')
                ->get()
                ->filter(function ($project) {
                    return rest($project) > 0; // 👈 only keep projects with positive rest
                });

            $deadlines = Deadline::whereNotNull('date')->whereDate('date', '<=', Carbon::now()->addWeek())
                ->orderBy('date', 'asc')
                ->get();

            $issues = Issue::where('isNotification', 1)
                ->orderBy('title', 'desc')
                ->get();

            if ($moneyProjects->isNotEmpty()) {
                $mergedMoneyText = $moneyProjects->map(function ($project) {
                    return "- " . $project->title . " with " . rest($project);
                })->implode("\n");

                $notifications[] = "💰 Projects billing:\n" . $mergedMoneyText . "\n\n";
            }

            if ($renewProjects->isNotEmpty() && boula()) {
                $mergedRenewText = $renewProjects->map(function ($project) {
                    return "- " . $project->title . " renewal in " . $project->renewalDate;
                })->implode("\n");

                $notifications[] = "🔄 Projects renew:\n" . $mergedRenewText . "\n\n";
            }

            if ($commitProjects->isNotEmpty()) {
                $mergedCommitText = $commitProjects->map(function ($project) {
                    return "- " . $project->title . " in " . $project->deadline;
                })->implode("\n");

                $notifications[] = "⏳ Projects due:\n" . $mergedCommitText . "\n\n";
            }

            if ($deadlines->isNotEmpty() && boula()) {
                $mergedDateText = $deadlines->map(function ($deadline) {
                    return "- " . $deadline->title . " in " . $deadline->date;
                })->implode("\n");

                $notifications[] = "⏰ Deadline actions:\n" . $mergedDateText . "\n\n";
            }

            // if ($issues->isNotEmpty() && boula()) {
            //     $mergedIssueText = $issues->map(function ($issue) {
            //         return "- " . $issue->title;
            //     })->implode("\n");

            //     $notifications[] = "⚠️ Important Issues:\n" . $mergedIssueText . "\n\n";
            // }

            // Final output: ONE notification string
            $data["notifications"] = $notifications;
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
