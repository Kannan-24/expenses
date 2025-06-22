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

    /**
     * Display the user's active sessions.
     */
    public function sessions()
    {
        $user = Auth::user();
        $sessions = collect(session()->getHandler()->read(session()->getId()))
            ? $this->getUserSessions($user)
            : [];

        return view('profile.account-settings', [
            'user' => $user,
            'sessions' => $sessions,
        ]);
    }

    /**
     * Logout other browser sessions except current.
     */
    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [], [], 'logoutOtherDevice');

        Auth::logoutOtherDevices($request->password);

        return back()->with('status', 'other-sessions-logged-out');
    }

    /**
     * Logout a specific device by session ID.
     */
    public function logoutOtherDevice($sessionId)
    {
        $user = Auth::user();
        $this->deleteSessionById($user, $sessionId);

        return back()->with('status', 'device-logged-out');
    }

    /**
     * Helper to get user sessions.
     */
    protected function getUserSessions($user)
    {
        $sessions = collect();
        if (config('session.driver') === 'database') {
            $dbSessions = \DB::table('sessions')
                ->where('user_id', $user->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get();

            foreach ($dbSessions as $session) {
                $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent($session->user_agent);

                $sessions->push((object)[
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'agent' => $agent,
                    'is_current_device' => $session->id === session()->getId(),
                    'last_active' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                ]);
            }
        }
        return $sessions;
    }

    /**
     * Helper to delete a session by ID.
     */
    protected function deleteSessionById($user, $sessionId)
    {
        if (config('session.driver') === 'database') {
            \DB::table('sessions')
                ->where('user_id', $user->getAuthIdentifier())
                ->where('id', $sessionId)
                ->delete();
        }
    }
}
