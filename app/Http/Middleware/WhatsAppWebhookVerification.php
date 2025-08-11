<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class WhatsAppWebhookVerification
{
    /**
     * Handle an incoming request for WhatsApp webhook verification.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Handle WhatsApp webhook verification (GET request)
        if ($request->isMethod('GET')) {
            $mode = $request->query('hub_mode');
            $token = $request->query('hub_verify_token');
            $challenge = $request->query('hub_challenge');

            if ($mode === 'subscribe' && $token === config('services.whatsapp.webhook_token')) {
                Log::info('WhatsApp webhook verified successfully');
                return response($challenge, 200);
            } else {
                Log::warning('WhatsApp webhook verification failed', [
                    'mode' => $mode,
                    'token' => $token ? 'provided' : 'missing',
                    'expected_token' => config('services.whatsapp.webhook_token') ? 'configured' : 'not_configured'
                ]);
                return response('Forbidden', 403);
            }
        }

        // For POST requests, add rate limiting
        if ($request->isMethod('POST')) {
            $clientIp = $request->ip();
            $cacheKey = "whatsapp_webhook_rate_limit:{$clientIp}";
            
            // Allow 100 requests per minute per IP
            $currentAttempts = Cache::get($cacheKey, 0);
            
            if ($currentAttempts >= 100) {
                Log::warning('WhatsApp webhook rate limit exceeded', [
                    'ip' => $clientIp,
                    'attempts' => $currentAttempts
                ]);
                return response()->json([
                    'error' => 'Rate limit exceeded'
                ], 429);
            }

            Cache::put($cacheKey, $currentAttempts + 1, now()->addMinute());
        }

        return $next($request);
    }
}
