<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        Password::defaults(function () {
            $rule = Password::min(8);

            if ($this->app->environment('production')) {
                $rule = $rule->letters()->numbers()->symbols()->mixedCase()->uncompromised(3);
            }

            return $rule;
        });
    }
}
