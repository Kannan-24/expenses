<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOnboarded
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::findOrFail(Auth::id());

        if ($user->hasRole('user') && !$user->hasCompletedAllOnboardingSteps()) {
            if (!$request->routeIs('onboarding.index')) {
                return redirect()->route('onboarding.index');
            }
        }

        return $next($request);
    }
}
