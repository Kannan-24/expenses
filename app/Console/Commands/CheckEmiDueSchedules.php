<?php

namespace App\Console\Commands;

use App\Models\EmiSchedule;
use App\Models\User;
use App\Notifications\EmiDueNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckEmiDueSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emi:check-due {--days= : Number of days to check ahead}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for EMI schedules that are due within the specified number of days and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notificationDays = intval($this->option('days') ?? env('EMI_NOTIFICATION_DAYS', 3));
        $checkDate = Carbon::now()->addDays($notificationDays);

        $this->info("Checking for EMI schedules due within {$notificationDays} days...");

        // Get EMI schedules due within the notification period
        $dueSchedules = EmiSchedule::with(['emiLoan', 'user'])
            ->where('status', 'upcoming')
            ->where('due_date', '<=', $checkDate)
            ->where('due_date', '>=', Carbon::now()->startOfDay())
            ->get();

        if ($dueSchedules->isEmpty()) {
            $this->info('No EMI schedules found due within the specified period.');
            return;
        }

        $notificationCount = 0;

        foreach ($dueSchedules as $schedule) {
            try {
                // Check if notification was already sent for this schedule today
                $lastNotificationToday = $schedule->user->notifications()
                    ->where('type', 'App\Notifications\EmiDueNotification')
                    ->whereDate('created_at', Carbon::today())
                    ->where('data->schedule_id', $schedule->id)
                    ->exists();

                if (!$lastNotificationToday) {
                    $schedule->user->notify(new EmiDueNotification($schedule));
                    $notificationCount++;
                    
                    $this->line("Notification sent to {$schedule->user->name} for EMI due on {$schedule->due_date->format('Y-m-d')}");
                }
            } catch (\Exception $e) {
                $this->error("Failed to send notification for schedule ID {$schedule->id}: {$e->getMessage()}");
            }
        }

        $this->info("Total notifications sent: {$notificationCount}");
        
        // Update late schedules
        $this->updatelateSchedules();
    }

    /**
     * Update schedules that are late
     */
    private function updatelateSchedules()
    {
        $lateCount = EmiSchedule::where('status', 'pending')
            ->where('due_date', '<', Carbon::now()->startOfDay())
            ->update(['status' => 'late']);

        if ($lateCount > 0) {
            $this->info("Updated {$lateCount} schedules to late status.");
        }
    }
}
