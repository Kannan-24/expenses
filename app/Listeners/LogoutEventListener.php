<?php

namespace App\Listeners;

use App\Services\ActivityTracker;
use Illuminate\Auth\Events\Logout;

class LogoutEventListener
{
    public function handle(Logout $event)
    {
        if ($event->user) {
            ActivityTracker::logLogout($event->user->id);
        }
    }
}