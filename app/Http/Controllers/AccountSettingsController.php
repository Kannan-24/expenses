<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountSettingsController extends Controller
{
    /**
     * Display the account settings page.
     */
    public function index()
    {
        return view('profile.account-settings', ['user' => Auth::user()]);
    }

    /**
     * Update profile information.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return redirect()->route('account.settings')->with('status', 'profile-updated');
    }

    /**
     * Update the password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('account.settings')->with('status', 'password-updated');
    }

    /**
     * Update notification preferences.
     */
    public function updateNotificationPreferences(Request $request)
    {
        $request->validate([
            'wants_reminder' => ['boolean'],
            'reminder_frequency' => ['required', 'in:daily,every_2_days,every_3_days,every_4_days,every_5_days,every_6_days,weekly,custom_weekdays,random,never'],
            'reminder_time' => ['required', 'date_format:H:i'],
            'timezone' => ['required', 'string'],
            'email_reminders' => ['boolean'],
            'push_reminders' => ['boolean'],
            'custom_weekdays' => ['array'],
            'custom_weekdays.*' => ['integer', 'between:0,6'],
            'random_min_days' => ['integer', 'min:1', 'max:30'],
            'random_max_days' => ['integer', 'min:1', 'max:30'],
        ]);

        $data = [
            'wants_reminder' => $request->boolean('wants_reminder'),
            'reminder_frequency' => $request->reminder_frequency,
            'reminder_time' => $request->reminder_time,
            'timezone' => $request->timezone,
            'email_reminders' => $request->boolean('email_reminders'),
            'push_reminders' => $request->boolean('push_reminders'),
        ];

        // Handle custom weekdays
        if ($request->reminder_frequency === 'custom_weekdays') {
            $data['custom_weekdays'] = $request->custom_weekdays ?? [];
        } else {
            $data['custom_weekdays'] = null;
        }

        // Handle random frequency settings
        if ($request->reminder_frequency === 'random') {
            $data['random_min_days'] = $request->random_min_days ?? 1;
            $data['random_max_days'] = max($request->random_max_days ?? 3, $data['random_min_days']);
        }

        Auth::user()->update($data);

        return redirect()->route('account.settings')->with('status', 'notification-preferences-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('status', 'account-deleted');
    }
}
