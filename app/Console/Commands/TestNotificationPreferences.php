<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestNotificationPreferences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification-preferences {user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test and display user notification preferences';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        if ($userId) {
            $user = \App\Models\User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found");
                return;
            }
            $users = collect([$user]);
        } else {
            $users = \App\Models\User::whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })->get();
        }

        $this->info('User Notification Preferences:');
        $this->line('');

        foreach ($users as $user) {
            $this->line("User: {$user->name} ({$user->email})");
            $this->line("  Wants Reminders: " . ($user->wants_reminder ? 'Yes' : 'No'));
            $this->line("  Frequency: {$user->reminder_frequency}");
            $this->line("  Time: " . ($user->reminder_time ? $user->reminder_time->format('H:i') : 'Not set'));
            $this->line("  Timezone: {$user->timezone}");
            $this->line("  Email Reminders: " . ($user->email_reminders ? 'Yes' : 'No'));
            $this->line("  Push Reminders: " . ($user->push_reminders ? 'Yes' : 'No'));
            $this->line('');
        }

        $this->info('Total users: ' . $users->count());
    }
}
