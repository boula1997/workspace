<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Task;
use App\Services\WhatsAppNotifier;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBoulaTasksWhatsApp extends Command
{
    protected $signature = 'tasks:whatsapp-digest {--dry-run : Print the message instead of sending it}';

    protected $description = "WhatsApp Boula D the list of his open tasks (overdue first)";

    public function handle(WhatsAppNotifier $whatsapp): int
    {
        $boula = Admin::where('name', 'Boula D')->first();
        if (!$boula) {
            $this->error('No admin named "Boula D".');
            return self::FAILURE;
        }

        // Same rule as the app's reminders: active, not done, assigned to Boula D
        $tasks = Task::where('is_active', 1)
            ->where('status', 0)
            ->orderBy('date', 'asc')
            ->get()
            ->filter(function ($task) use ($boula) {
                $employeeIds = is_array($task->employees)
                    ? $task->employees
                    : (json_decode($task->employees, true) ?? []);
                return in_array($boula->id, $employeeIds);
            })
            ->values();

        if ($tasks->isEmpty()) {
            $this->info('No open Boula D tasks - nothing to send.');
            return self::SUCCESS;
        }

        $message = $this->buildMessage($tasks);

        if ($this->option('dry-run')) {
            $this->line($message);
            return self::SUCCESS;
        }

        $to = config('services.whatsapp.to') ?: ($boula->whatsapp ?: $boula->phone);
        if (!$to) {
            $this->error('No WhatsApp number: set WHATSAPP_TO or the whatsapp field of Boula D.');
            return self::FAILURE;
        }

        try {
            $whatsapp->send((string) $to, $message);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        $this->info("Sent {$tasks->count()} task(s) to WhatsApp.");
        return self::SUCCESS;
    }

    private function buildMessage($tasks): string
    {
        $today = Carbon::today();
        $lines = ["📋 Boula D - {$tasks->count()} open task" . ($tasks->count() === 1 ? '' : 's')];

        foreach ($tasks as $task) {
            $date = $task->date ? Carbon::parse($task->date) : null;
            if ($date && $date->lt($today)) {
                $when = '🔴 overdue since ' . $date->format('d M');
            } elseif ($date && $date->isSameDay($today)) {
                $when = '🟠 due today';
            } elseif ($date) {
                $when = 'due ' . $date->format('d M');
            } else {
                $when = 'no date';
            }
            $lines[] = "• {$task->title} ({$when})";
        }

        return implode("\n", $lines);
    }
}
