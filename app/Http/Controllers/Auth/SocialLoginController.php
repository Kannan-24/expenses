<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\Controller;
use Google_Client;
use Illuminate\Support\Facades\Session;

class SocialLoginController extends Controller
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

            Session::put('just_registered', true);
            Session::put('registration_method', 'google');
        } else {
            $user->update([
                'google_id' => $googleUser->getId(),
            ]);
        }

        if (!$user->google_id) {
            $user->google_id = $googleUser->getId();
            $user->save();
        }

        if ($user->roles->isEmpty()) {
            $user->syncRoles([config('permission.default_role')]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function handleOneTap(Request $request)
    {
        $token = $request->input('token');

        $client = new Google_Client(['client_id' => config('services.google.client_id')]);
        $payload = $client->verifyIdToken($token);

        if ($payload) {
            $email = $payload['email'];
            $name = $payload['name'];
            $googleId = $payload['sub'];

            // Find or create user
            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'google_id' => $googleId,
                    'password' => bcrypt(Str::random(16)),
                ]);

                Session::put('just_registered', true);
                Session::put('registration_method', 'google');
            } else {
                $user->update(['google_id' => $googleId]);
            }

            if ($user->roles->isEmpty()) {
                $user->syncRoles([config('permission.default_role')]);
            }

            Auth::login($user);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 401);
    }
}
