<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // If user has 2FA enabled and device not trusted, log them out and send to challenge
        if ($user->two_factor_enabled) {
            $trustedCookie = request()->cookie('trusted_device_'.$user->id);
            $trustedOk = false;
            if ($trustedCookie) {
                $trustedOk = $user->trustedDevices()->where('device_key',$trustedCookie)->exists();
            }
            if (!$trustedOk) {
                // Temporarily logout and store user id for challenge
                Auth::logout();
                session(['2fa:user:id'=>$user->id]);
                return redirect()->route('auth.2fa.challenge');
            }
        }

        $request->session()->regenerate();
        if ($user->roles->isEmpty()) {
            $user->assignRole(config('permission.default_role'));
        }
        $user->update(['last_login_at'=>now(),'last_login_ip'=>$request->ip(),'last_login_user_agent'=>$request->userAgent()]);
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
