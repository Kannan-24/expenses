<?php

namespace App\Listeners;

use App\Services\ActivityTracker;
use Illuminate\Auth\Events\Login;

class LoginEventListener
{
    public function handle(Login $event)
    {
        ActivityTracker::logLogin($event->user->id);
    }
}