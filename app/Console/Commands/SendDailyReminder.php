<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\DailyReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendDailyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send {--force : Force send regardless of time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily reminders to users based on their preferences';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = Carbon::now();
        $batchSize = 50;
        $delayBetweenBatches = 10; // seconds
        $totalNotificationsSent = 0;

        // Get users who want reminders
        $query = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })
            ->where('wants_reminder', true)
            ->where('email_reminders', true)
            ->whereNotIn('reminder_frequency', ['never'])
            ->select('id', 'name', 'email', 'reminder_frequency', 'reminder_time', 'timezone', 'custom_weekdays', 'random_min_days', 'random_max_days', 'last_reminder_sent', 'email_reminders', 'push_reminders');

        $this->info("Checking for users to send reminders at " . $currentTime->format('Y-m-d H:i:s T') . " (UTC)");
        Log::info("Starting daily reminder check at " . $currentTime->toIso8601String());


        $query->chunk($batchSize, function ($users, $page) use ($delayBetweenBatches, &$totalNotificationsSent, $currentTime) {
            foreach ($users as $index => $user) {
                // Check if user should receive reminder based on their frequency preference
                if (!$this->option('force') && !$this->shouldSendReminder($user, $currentTime)) {
                    continue;
                }

                // Check if user already received a notification today
                $alreadySentToday = $user->notifications()
                    ->where('type', DailyReminderNotification::class)
                    ->whereDate('created_at', Carbon::today())
                    ->exists();

                if (!$alreadySentToday) {
                    $delaySeconds = ($page * $delayBetweenBatches) + ($index * 2);

                    // Queue notification with delay
                    $user->notify((new DailyReminderNotification())->delay(now()->addSeconds($delaySeconds)));

                    // Update last reminder sent timestamp in user's timezone
                    $userTimezone = $user->timezone ?? config('app.timezone');
                    try {
                        $userCurrentTime = $currentTime->copy()->setTimezone($userTimezone);
                    } catch (\Exception $e) {
                        $userCurrentTime = $currentTime->copy()->setTimezone('UTC');
                    }
                    $user->update(['last_reminder_sent' => $userCurrentTime]);

                    $totalNotificationsSent++;
                    $this->line("Queued reminder for {$user->name} ({$user->email}) - Frequency: {$user->reminder_frequency} - Time: {$userCurrentTime->format('Y-m-d H:i:s T')}");
                } else {
                    $this->line("Skipping {$user->name} - already sent today");
                }
            }

            if ($users->count() > 0) {
                $this->info("Processed batch {$page} with {$users->count()} users");
            }
        });

        $this->info("Total reminder notifications queued: {$totalNotificationsSent}");
        Log::info("Total reminder notifications queued: {$totalNotificationsSent}");

        if ($totalNotificationsSent === 0) {
            $this->info("No reminders sent. This could be because:");
            $this->line("- No users have enabled daily reminders");
            $this->line("- It's not the right time for any user's preference");
            $this->line("- All eligible users already received reminders today");
            $this->line("Use --force flag to ignore time restrictions for testing");
        }
    }

    /**
     * Determine if a user should receive a reminder based on their frequency preference
     */
    private function shouldSendReminder($user, $currentTime)
    {
        // Convert current time to user's timezone
        $userTimezone = $user->timezone ?? 'UTC';
        try {
            $userCurrentTime = $currentTime->copy()->setTimezone($userTimezone);
        } catch (\Exception $e) {
            // Fallback to UTC if timezone is invalid
            $userCurrentTime = $currentTime->copy()->setTimezone('UTC');
            $this->warn("Invalid timezone '{$userTimezone}' for user {$user->email}, using UTC");
        }

        // Check if it's the right time for this user (within 1 hour window)
        $userReminderTime = Carbon::parse($user->reminder_time ?? '09:00')->setTimezone($userTimezone);
        $currentHour = $userCurrentTime->format('H:i');
        $reminderHour = $userReminderTime->format('H:i');

        $currentMinutes = $userCurrentTime->hour * 60 + $userCurrentTime->minute;
        $reminderMinutes = $userReminderTime->hour * 60 + $userReminderTime->minute;

        // Allow 1 hour window (before and after the preferred time)
        if (abs($currentMinutes - $reminderMinutes) > 60) {
            return false;
        }

        $lastReminderSent = $user->last_reminder_sent ? Carbon::parse($user->last_reminder_sent)->setTimezone($userTimezone) : null;

        switch ($user->reminder_frequency) {
            case 'daily':
                return true; // Daily reminders are sent every day at the specified time

            case 'weekly':
                // Send on Mondays only (in user's timezone)
                return $userCurrentTime->dayOfWeek === Carbon::MONDAY;

            case 'every_2_days':
                return $this->shouldSendIntervalReminder($lastReminderSent, $userCurrentTime, 2);

            case 'every_3_days':
                return $this->shouldSendIntervalReminder($lastReminderSent, $userCurrentTime, 3);

            case 'every_4_days':
                return $this->shouldSendIntervalReminder($lastReminderSent, $userCurrentTime, 4);

            case 'every_5_days':
                return $this->shouldSendIntervalReminder($lastReminderSent, $userCurrentTime, 5);

            case 'every_6_days':
                return $this->shouldSendIntervalReminder($lastReminderSent, $userCurrentTime, 6);

            case 'custom_weekdays':
                $customWeekdays = $user->custom_weekdays ?? [];
                // Convert Sunday=0 to Sunday=7 for consistency with Carbon (in user's timezone)
                $currentDayOfWeek = $userCurrentTime->dayOfWeek === 0 ? 7 : $userCurrentTime->dayOfWeek;
                return in_array($currentDayOfWeek, $customWeekdays) || in_array($userCurrentTime->dayOfWeek, $customWeekdays);

            case 'random':
                return $this->shouldSendRandomReminder($user, $lastReminderSent, $userCurrentTime);

            default:
                return false;
        }
    }

    /**
     * Check if an interval-based reminder should be sent
     */
    private function shouldSendIntervalReminder($lastReminderSent, $userCurrentTime, $intervalDays)
    {
        if (!$lastReminderSent) {
            return true; // First reminder
        }

        $daysSinceLastReminder = $lastReminderSent->diffInDays($userCurrentTime);
        return $daysSinceLastReminder >= $intervalDays;
    }

    /**
     * Check if a random frequency reminder should be sent
     */
    private function shouldSendRandomReminder($user, $lastReminderSent, $userCurrentTime)
    {
        if (!$lastReminderSent) {
            return true; // First reminder
        }

        $minDays = $user->random_min_days ?? 1;
        $maxDays = $user->random_max_days ?? 3;

        $daysSinceLastReminder = $lastReminderSent->diffInDays($userCurrentTime);

        // Must wait at least minimum days
        if ($daysSinceLastReminder < $minDays) {
            return false;
        }

        // After minimum days, use probability based on the range
        // Higher probability as we approach maximum days
        $probabilityFactor = ($daysSinceLastReminder - $minDays + 1) / ($maxDays - $minDays + 1);
        $randomThreshold = min($probabilityFactor * 0.5, 0.8); // Max 80% chance per day

        return mt_rand() / mt_getrandmax() < $randomThreshold;
    }
}
