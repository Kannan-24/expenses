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
        // $users = User::whereHas('roles', function ($query) {
        //     $query->where('name', 'user');
        // })->where('wants_reminder', true)->get();

        // if ($users->isEmpty()) {
        //     $this->info('No users opted in for daily reminders.');
        //     return;
        // }

        // Notification::send($users, new DailyReminderNotification());
        // $this->info('Daily reminders sent successfully to ' . $users->count() . ' users.');
        User::where('email', 'jp008882@gmail.com')
            ->first()
            ->notify(new DailyReminderNotification());
    }
}
