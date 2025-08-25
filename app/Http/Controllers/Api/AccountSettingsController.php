<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AccountSettingsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AccountSettingsController extends Controller
{
    protected $accountSettingsService;

    public function __construct(AccountSettingsService $accountSettingsService)
    {
        $this->middleware('auth:sanctum');
        $this->accountSettingsService = $accountSettingsService;
    }

    /**
     * Get user profile information
     * 
     * @return JsonResponse
     */
    public function getProfile(): JsonResponse
    {
        try {
            $user = Auth::user();
            $profile = $this->accountSettingsService->getUserProfile($user);

            return response()->json([
                'success' => true,
                'data' => $profile,
                'message' => 'Profile retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve profile: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user profile information
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500']
        ]);

        try {
            $user = Auth::user();
            
            // Check email uniqueness
            if ($request->email !== $user->email) {
                if (!$this->accountSettingsService->isEmailUnique($request->email, $user->id)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email already exists',
                        'errors' => ['email' => ['The email has already been taken.']]
                    ], 422);
                }
            }

            // Update basic profile
            $updatedUser = $this->accountSettingsService->updateProfile($user, $request->only(['name', 'email']));
            
            // Update additional fields if provided
            if ($request->has(['phone', 'address'])) {
                $updatedUser = $this->accountSettingsService->updateAdditionalProfile(
                    $updatedUser, 
                    $request->only(['phone', 'address'])
                );
            }

            $profile = $this->accountSettingsService->getUserProfile($updatedUser);

            return response()->json([
                'success' => true,
                'data' => $profile,
                'message' => 'Profile updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update profile: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update user password
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        try {
            $user = Auth::user();
            
            // Verify current password
            if (!$this->accountSettingsService->verifyCurrentPassword($user, $request->current_password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect',
                    'errors' => ['current_password' => ['The current password is incorrect.']]
                ], 422);
            }

            // Update password
            $this->accountSettingsService->updatePassword($user, $request->password);

            // Log successful password update
            Log::info('Password updated successfully for user: ' . $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update password for user ' . Auth::id() . ': ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update password',
                'error' => 'An unexpected error occurred while updating your password'
            ], 500);
        }
    }

    /**
     * Get notification preferences
     * 
     * @return JsonResponse
     */
    public function getNotificationPreferences(): JsonResponse
    {
        try {
            $user = Auth::user();
            $preferences = $this->accountSettingsService->getNotificationPreferences($user);

            return response()->json([
                'success' => true,
                'data' => $preferences,
                'message' => 'Notification preferences retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve notification preferences: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve notification preferences',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update notification preferences
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function updateNotificationPreferences(Request $request): JsonResponse
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
            'random_max_days' => ['integer', 'min:1', 'max:30']
        ]);

        try {
            $user = Auth::user();
            
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

            // Validate data using service
            $validatedData = $this->accountSettingsService->validateNotificationData($data);
            
            $updatedUser = $this->accountSettingsService->updateNotificationPreferences($user, $validatedData);
            $preferences = $this->accountSettingsService->getNotificationPreferences($updatedUser);

            return response()->json([
                'success' => true,
                'data' => $preferences,
                'message' => 'Notification preferences updated successfully'
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Failed to update notification preferences: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update notification preferences',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get account security information
     * 
     * @return JsonResponse
     */
    public function getAccountSecurity(): JsonResponse
    {
        try {
            $user = Auth::user();
            $security = $this->accountSettingsService->getAccountSecurity($user);

            return response()->json([
                'success' => true,
                'data' => $security,
                'message' => 'Account security information retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve account security: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve account security information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get account activity summary
     * 
     * @return JsonResponse
     */
    public function getAccountActivity(): JsonResponse
    {
        try {
            $user = Auth::user();
            $activity = $this->accountSettingsService->getAccountActivity($user);

            return response()->json([
                'success' => true,
                'data' => $activity,
                'message' => 'Account activity retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve account activity: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve account activity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available configuration options
     * 
     * @return JsonResponse
     */
    public function getConfigOptions(): JsonResponse
    {
        try {
            $timezones = $this->accountSettingsService->getTimezones();
            $frequencies = $this->accountSettingsService->getReminderFrequencies();

            return response()->json([
                'success' => true,
                'data' => [
                    'timezones' => $timezones,
                    'reminder_frequencies' => $frequencies,
                    'weekdays' => [
                        0 => 'Sunday',
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday'
                    ]
                ],
                'message' => 'Configuration options retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve config options: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve configuration options',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete user account
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAccount(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
            'confirmation' => ['required', 'string', 'in:DELETE']
        ]);

        try {
            $user = Auth::user();
            
            // Verify current password
            if (!$this->accountSettingsService->verifyCurrentPassword($user, $request->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password verification failed',
                    'errors' => ['password' => ['The password is incorrect.']]
                ], 422);
            }

            // Revoke all tokens before deletion
            try {
                $user->tokens()->delete();
            } catch (\Exception $tokenException) {
                // Continue with deletion even if token revocation fails
                Log::warning('Failed to revoke tokens during account deletion: ' . $tokenException->getMessage());
            }
            
            // Delete account
            $this->accountSettingsService->deleteAccount($user);

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete account: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete account',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all account settings in one response
     * 
     * @return JsonResponse
     */
    public function getAllSettings(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            $profile = $this->accountSettingsService->getUserProfile($user);
            $notifications = $this->accountSettingsService->getNotificationPreferences($user);
            $security = $this->accountSettingsService->getAccountSecurity($user);
            $activity = $this->accountSettingsService->getAccountActivity($user);

            return response()->json([
                'success' => true,
                'data' => [
                    'profile' => $profile,
                    'notifications' => $notifications,
                    'security' => $security,
                    'activity' => $activity
                ],
                'message' => 'All account settings retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve all settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve account settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
