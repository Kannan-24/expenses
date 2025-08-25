<?php

namespace App\Http\Controllers;

use App\Services\AccountSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountSettingsController extends Controller
{
    protected $accountSettingsService;

    public function __construct(AccountSettingsService $accountSettingsService)
    {
        $this->accountSettingsService = $accountSettingsService;
    }

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

        try {
            $this->accountSettingsService->updateProfile(Auth::user(), $request->only('name', 'email'));
            
            return redirect()->route('account.settings')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
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

        try {
            $this->accountSettingsService->updatePassword(Auth::user(), $request->password);
            
            return redirect()->route('account.settings')->with('status', 'password-updated');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update password: ' . $e->getMessage()]);
        }
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

        try {
            $data = [
                'wants_reminder' => $request->boolean('wants_reminder'),
                'reminder_frequency' => $request->reminder_frequency,
                'reminder_time' => $request->reminder_time,
                'timezone' => $request->timezone,
                'email_reminders' => $request->boolean('email_reminders'),
                'push_reminders' => $request->boolean('push_reminders'),
                'custom_weekdays' => $request->custom_weekdays,
                'random_min_days' => $request->random_min_days,
                'random_max_days' => $request->random_max_days,
            ];

            $this->accountSettingsService->updateNotificationPreferences(Auth::user(), $data);
            
            return redirect()->route('account.settings')->with('status', 'notification-preferences-updated');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update notification preferences: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        try {
            $user = Auth::user();
            Auth::logout();
            
            $this->accountSettingsService->deleteAccount($user);
            
            return redirect('/')->with('status', 'account-deleted');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete account: ' . $e->getMessage()]);
        }
    }
}
