<?php

namespace App\Services;

use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityTracker
{
    public static function log(
        string $activityType,
        string $description,
        ?array $metadata = null,
        ?int $userId = null,
        string $status = 'success'
    ): UserActivity {
        $request = request();
        $user = $userId ? \App\Models\User::find($userId) : Auth::user();

        if (!$user) {
            throw new \Exception('User not found for activity logging');
        }

        return UserActivity::create([
            'user_id' => $user->id,
            'activity_type' => $activityType,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? $request->userAgent() : null,
            'location' => self::getLocationFromIp($request ? $request->ip() : null),
            'status' => $status,
        ]);
    }

    public static function logLogin(?int $userId = null): UserActivity
    {
        return self::log(
            UserActivity::TYPE_LOGIN,
            'User logged in successfully',
            ['login_method' => 'credentials'],
            $userId
        );
    }

    public static function logLogout(?int $userId = null): UserActivity
    {
        return self::log(
            UserActivity::TYPE_LOGOUT,
            'User logged out',
            [],
            $userId
        );
    }

    public static function logProfileUpdate(array $changes = [], ?int $userId = null): UserActivity
    {
        return self::log(
            UserActivity::TYPE_PROFILE_UPDATE,
            'Profile information updated',
            ['changes' => $changes],
            $userId
        );
    }

    public static function logPasswordChange(?int $userId = null): UserActivity
    {
        return self::log(
            UserActivity::TYPE_PASSWORD_CHANGE,
            'Password changed successfully',
            ['security_level' => 'high'],
            $userId
        );
    }

    public static function logAccountCreated(?int $userId = null): UserActivity
    {
        return self::log(
            UserActivity::TYPE_ACCOUNT_CREATED,
            'Welcome to the platform',
            ['registration_method' => 'web'],
            $userId
        );
    }

    private static function getLocationFromIp(?string $ip): ?string
    {
        if (!$ip || $ip === '127.0.0.1' || $ip === '::1') {
            return 'Local Development';
        }

        $userActivity = UserActivity::where('ip_address', $ip)->first();
        if ($userActivity && $userActivity->location) {
            return $userActivity->location;
        }

        $response = file_get_contents("https://ipapi.co/{$ip}/json/");
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['city']) && isset($data['country_name'])) {
                return "{$data['city']}, {$data['country_name']}";
            }
        }

        return 'Unknown Location';
    }
}
