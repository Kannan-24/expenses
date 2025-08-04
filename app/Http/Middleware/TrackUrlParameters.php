<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserAnalytics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrackUrlParameters
{
    public function handle(Request $request, Closure $next)
    {
        // Only track if user is authenticated and has UTM parameters
        if (Auth::check() && $this->hasUtmParameters($request)) {
            try {
                UserAnalytics::trackFromRequest(
                    $request, 
                    Auth::id(), 
                    'email_click',
                    [
                        'url' => $request->fullUrl(),
                        'route' => $request->route()?->getName(),
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Failed to track UTM parameters: ' . $e->getMessage());
            }
        }

        return $next($request);
    }

    private function hasUtmParameters(Request $request): bool
    {
        return $request->has(['utm_source']) || 
               $request->has(['utm_medium']) || 
               $request->has(['utm_campaign']);
    }
}