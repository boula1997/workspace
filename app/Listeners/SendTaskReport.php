<?php

namespace App\Listeners;

use App\Events\TaskChanged;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use App\Services\MailService;
class SendTaskReport
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskChanged $event): void
    {
        \Log::info('SendTaskReport listener triggered');
        // $this->emailTasks();
    }

    /**
     * Send tasks report email.
     */
    // private function emailTasks(): void
    // {
    //     // Email details
    //     $to = "nessimboula@gmail.com";
    //     $toName = "Boula Nessim";
    //     $subject = 'Tasks Report';

    //     // Get tasks
    //     $tasks = Task::where('status', 0)
    //                 ->orderBy('project_id', 'desc')
    //                 ->get()
    //                 ->unique('title');

    //     // Construct the email content
    //     $body = '<html lang="en"><head><meta charset="UTF-8"><title>Tasks Report</title></head><body>';
    //     $body .= '<h1>Tasks Report</h1>';

    //     // Combined Tasks Table
    //     $body .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
    //     $body .= '<thead><tr><th>Task</th><th>Project</th><th>Difficulty</th></tr></thead><tbody>';

    //     foreach ($tasks as $task) {
    //         $difficulty = $task->level == 1 ? 'Mobile' : 'PC';
    //         $body .= '<tr>';
    //         $body .= '<td>' . htmlspecialchars($task->title, ENT_QUOTES, 'UTF-8') . '</td>';
    //         $body .= '<td>' . htmlspecialchars($task->project->title ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';
    //         $body .= '<td>' . $difficulty . '</td>';
    //         $body .= '</tr>';
    //     }

    //     $body .= '</tbody></table>';
    //     $body .= '</body></html>';

    //     // Send the email
    //     $result = MailService::sendMail($to, $toName, $subject, $body);

    // }
}
