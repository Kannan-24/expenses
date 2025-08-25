<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AccountSettingsService
{
    /**
     * Update user profile information
     */
    public function updateProfile(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return $user->fresh();
    }

    /**
     * Update user password
     */
    public function updatePassword(User $user, string $newPassword): User
    {
        $user->update([
            'password' => Hash::make($newPassword),
            'password_updated_at' => now(),
            'has_set_password' => true,
        ]);

        return $user->fresh();
    }

    /**
     * Verify current password
     */
    public function verifyCurrentPassword(User $user, string $currentPassword): bool
    {
        return Hash::check($currentPassword, $user->password);
    }

    /**
     * Update notification preferences
     */
    public function updateNotificationPreferences(User $user, array $data): User
    {
        $updateData = [
            'wants_reminder' => $data['wants_reminder'] ?? false,
            'reminder_frequency' => $data['reminder_frequency'],
            'reminder_time' => $data['reminder_time'],
            'timezone' => $data['timezone'],
            'email_reminders' => $data['email_reminders'] ?? false,
            'push_reminders' => $data['push_reminders'] ?? false,
        ];

        // Handle custom weekdays
        if ($data['reminder_frequency'] === 'custom_weekdays') {
            $updateData['custom_weekdays'] = $data['custom_weekdays'] ?? [];
        } else {
            $updateData['custom_weekdays'] = null;
        }

        // Handle random frequency settings
        if ($data['reminder_frequency'] === 'random') {
            $updateData['random_min_days'] = $data['random_min_days'] ?? 1;
            $updateData['random_max_days'] = max($data['random_max_days'] ?? 3, $updateData['random_min_days']);
        } else {
            $updateData['random_min_days'] = null;
            $updateData['random_max_days'] = null;
        }

        $user->update($updateData);

        return $user->fresh();
    }

    /**
     * Get user profile information
     */
    public function getUserProfile(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'has_set_password' => $user->has_set_password,
            'password_updated_at' => $user->password_updated_at,
        ];
    }

    /**
     * Get user notification preferences
     */
    public function getNotificationPreferences(User $user): array
    {
        return [
            'wants_reminder' => $user->wants_reminder,
            'reminder_frequency' => $user->reminder_frequency,
            'reminder_time' => $user->reminder_time,
            'timezone' => $user->timezone,
            'email_reminders' => $user->email_reminders,
            'push_reminders' => $user->push_reminders,
            'custom_weekdays' => $user->custom_weekdays,
            'random_min_days' => $user->random_min_days,
            'random_max_days' => $user->random_max_days,
            'last_reminder_sent' => $user->last_reminder_sent,
        ];
    }

    /**
     * Get available timezone list
     */
    public function getTimezones(): array
    {
        return [
            'UTC' => 'UTC',
            'America/New_York' => 'Eastern Time',
            'America/Chicago' => 'Central Time',
            'America/Denver' => 'Mountain Time',
            'America/Los_Angeles' => 'Pacific Time',
            'Europe/London' => 'London',
            'Europe/Paris' => 'Paris',
            'Europe/Berlin' => 'Berlin',
            'Asia/Tokyo' => 'Tokyo',
            'Asia/Shanghai' => 'Shanghai',
            'Asia/Kolkata' => 'Mumbai/Kolkata',
            'Asia/Dubai' => 'Dubai',
            'Australia/Sydney' => 'Sydney',
            'Pacific/Auckland' => 'Auckland',
        ];
    }

    /**
     * Get available reminder frequencies
     */
    public function getReminderFrequencies(): array
    {
        return [
            'daily' => 'Daily',
            'every_2_days' => 'Every 2 Days',
            'every_3_days' => 'Every 3 Days',
            'every_4_days' => 'Every 4 Days',
            'every_5_days' => 'Every 5 Days',
            'every_6_days' => 'Every 6 Days',
            'weekly' => 'Weekly',
            'custom_weekdays' => 'Custom Weekdays',
            'random' => 'Random',
            'never' => 'Never',
        ];
    }

    /**
     * Validate notification preferences data
     */
    public function validateNotificationData(array $data): array
    {
        $validatedData = [];

        // Basic validation
        $validatedData['wants_reminder'] = isset($data['wants_reminder']) ? (bool) $data['wants_reminder'] : false;
        $validatedData['email_reminders'] = isset($data['email_reminders']) ? (bool) $data['email_reminders'] : false;
        $validatedData['push_reminders'] = isset($data['push_reminders']) ? (bool) $data['push_reminders'] : false;

        // Validate reminder frequency
        $validFrequencies = array_keys($this->getReminderFrequencies());
        if (!in_array($data['reminder_frequency'], $validFrequencies)) {
            throw new \InvalidArgumentException('Invalid reminder frequency');
        }
        $validatedData['reminder_frequency'] = $data['reminder_frequency'];

        // Validate reminder time format
        if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $data['reminder_time'])) {
            throw new \InvalidArgumentException('Invalid reminder time format');
        }
        $validatedData['reminder_time'] = $data['reminder_time'];

        // Validate timezone
        $validTimezones = array_keys($this->getTimezones());
        if (!in_array($data['timezone'], $validTimezones)) {
            throw new \InvalidArgumentException('Invalid timezone');
        }
        $validatedData['timezone'] = $data['timezone'];

        // Validate custom weekdays
        if ($data['reminder_frequency'] === 'custom_weekdays') {
            if (!isset($data['custom_weekdays']) || !is_array($data['custom_weekdays'])) {
                throw new \InvalidArgumentException('Custom weekdays must be provided as an array');
            }
            
            $validatedWeekdays = [];
            foreach ($data['custom_weekdays'] as $day) {
                if (!is_numeric($day) || $day < 0 || $day > 6) {
                    throw new \InvalidArgumentException('Invalid weekday value');
                }
                $validatedWeekdays[] = (int) $day;
            }
            $validatedData['custom_weekdays'] = array_unique($validatedWeekdays);
        }

        // Validate random frequency settings
        if ($data['reminder_frequency'] === 'random') {
            if (!isset($data['random_min_days']) || !is_numeric($data['random_min_days']) || $data['random_min_days'] < 1 || $data['random_min_days'] > 30) {
                throw new \InvalidArgumentException('Invalid random_min_days value');
            }
            if (!isset($data['random_max_days']) || !is_numeric($data['random_max_days']) || $data['random_max_days'] < 1 || $data['random_max_days'] > 30) {
                throw new \InvalidArgumentException('Invalid random_max_days value');
            }
            if ($data['random_max_days'] < $data['random_min_days']) {
                throw new \InvalidArgumentException('random_max_days must be greater than or equal to random_min_days');
            }
            
            $validatedData['random_min_days'] = (int) $data['random_min_days'];
            $validatedData['random_max_days'] = (int) $data['random_max_days'];
        }

        return $validatedData;
    }

    /**
     * Delete user account with all related data
     */
    public function deleteAccount(User $user): bool
    {
        return DB::transaction(function () use ($user) {
            // Note: Related data cleanup would happen here via model events
            // or explicit cleanup based on your application's requirements
            
            // Delete the user
            $user->delete();
            
            return true;
        });
    }

    /**
     * Get account security information
     */
    public function getAccountSecurity(User $user): array
    {
        return [
            'has_set_password' => $user->has_set_password,
            'password_updated_at' => $user->password_updated_at,
            'email_verified_at' => $user->email_verified_at,
            'two_factor_enabled' => false, // Placeholder for future 2FA implementation
            'last_login_at' => $user->last_login_at,
        ];
    }

    /**
     * Update additional profile fields
     */
    public function updateAdditionalProfile(User $user, array $data): User
    {
        $updateData = [];

        if (isset($data['phone'])) {
            $updateData['phone'] = $data['phone'];
        }

        if (isset($data['address'])) {
            $updateData['address'] = $data['address'];
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        return $user->fresh();
    }

    /**
     * Validate email uniqueness
     */
    public function isEmailUnique(string $email, int $excludeUserId = null): bool
    {
        $query = User::where('email', $email);
        
        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        return $query->doesntExist();
    }

    /**
     * Get user's activity summary for account settings
     */
    public function getAccountActivity(User $user): array
    {
        return [
            'total_transactions' => $user->transactions()->count(),
            'total_budgets' => $user->budgets()->count(),
            'total_wallets' => $user->wallets()->count(),
            'account_created' => $user->created_at,
            'last_activity' => $user->updated_at,
            'streak_days' => $user->streak_days ?? 0,
            'longest_streak' => $user->longest_streak ?? 0,
        ];
    }
}
