<?php

namespace App\Providers;

use App\Listeners\LoginEventListener;
use App\Listeners\LogoutEventListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LoginEventListener::class,
        ],
        Logout::class => [
            LogoutEventListener::class,
        ],
    ];
}