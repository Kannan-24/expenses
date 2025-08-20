<?php

use App\Console\Commands\SendDailyReminder;
use App\Http\Middleware\EnsureUserIsOnboarded;
use App\Http\Middleware\TrackUrlParameters;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (Schedule $schedule) {
        // Run reminder command every hour to check for users who should receive notifications
        // The command itself will handle user-specific timing and frequency preferences
        $schedule->command(SendDailyReminder::class)
            ->hourly()
            ->withoutOverlapping()
            ->onOneServer()
            ->runInBackground();
            
        // Keep other scheduled tasks as they were
        $schedule->command('streaks:update')->daily();
        $schedule->command('emi:check-due --days=3')->dailyAt('10:00')->timezone('Asia/Kolkata');
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            TrackUrlParameters::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
