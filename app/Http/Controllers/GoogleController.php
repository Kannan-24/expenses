<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if user exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Register new user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)),
            ]);
        } else {
            $user->update([
                'google_id' => $googleUser->getId(),
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
