<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\DomainChangedNotification;
use Illuminate\Console\Command;

class SendDomainChangeEmails extends Command
{
    protected $signature = 'emails:domain-change';
    protected $description = 'Send email to all users about the domain change';

    public function handle()
    {
        $this->info('Sending domain change notification to all users...');

        User::chunk(50, function ($users) {
            foreach ($users as $user) {
                $user->notify(new DomainChangedNotification());
            }
        });

        $this->info('All notifications have been queued.');
    }
}
