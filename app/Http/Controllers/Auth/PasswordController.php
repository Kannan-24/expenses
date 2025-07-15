<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Validate the current password
        if (!Hash::check($validated['current_password'], $request->user()->password)) {
            return back()->withErrors([
                'current_password' => 'The provided password does not match your current password.',
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Show password setup form
     */
    public function show()
    {
        $user = User::findOrFail(Auth::id());

        // Redirect if user already has password set
        if ($user->has_set_password) {
            return redirect()->route('dashboard')->with('info', 'You have already set up your password.');
        }

        // Redirect if not OAuth user
        if (!$user->isSocialLogin()) {
            return redirect()->route('dashboard')->with('info', 'Password setup is only for social login users.');
        }

        return view('auth.setup-password');
    }

    /**
     * Store new password
     */
    public function store(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        // Validate user eligibility
        if ($user->has_set_password || !$user->isSocialLogin()) {
            return redirect()->route('dashboard')->with('error', 'Password setup not available.');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults([
                'min' => 8,
                'mixedCase' => true,
                'numbers' => true,
                'symbols' => true,
            ])],
        ]);

        // Update user password
        $user->update([
            'password' => Hash::make($request->password),
            'has_set_password' => true,
            'password_updated_at' => now(),
        ]);

        // Mark password as set
        $user->markPasswordAsSet();

        return redirect()->route('dashboard')->with('success', 'Password set successfully! You can now log in with your email and password.');
    }
}
