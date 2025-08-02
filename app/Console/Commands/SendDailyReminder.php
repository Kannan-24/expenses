<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\DailyReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendDailyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily reminders to users who opted in';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $batchSize = 50; // safe per batch
        $delayBetweenBatches = 10; // seconds

        User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })
            ->where('wants_reminder', true)
            ->select('id', 'name', 'email') // only what’s needed
            ->chunk($batchSize, function ($users, $page) use ($delayBetweenBatches) {

                foreach ($users as $index => $user) {
                    $delaySeconds = ($page * $delayBetweenBatches);

                    // Queue each notification with a slight delay
                    $user->notify((new DailyReminderNotification())->delay(now()->addSeconds($delaySeconds)));
                }
            });

        $this->info('Queued reminder emails successfully.');
    }
}
