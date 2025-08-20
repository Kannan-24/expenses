<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\ActivityTracker;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'has_set_password',
        'password_updated_at',
        'google_id',
        'wants_reminder',
        'reminder_frequency',
        'custom_weekdays',
        'random_min_days',
        'random_max_days',
        'last_reminder_sent',
        'reminder_time',
        'timezone',
        'email_reminders',
        'push_reminders',
        'last_login_at',

        'streak_days',
        'last_transaction_date',
        'strea_start_date',
        'longest_streak',
        'monthly_savings_goal',
        'current_month_savings'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'has_set_password' => 'boolean',
            'password_updated_at' => 'datetime',
            'wants_reminder' => 'boolean',
            'custom_weekdays' => 'array',
            'last_reminder_sent' => 'date',
            'reminder_time' => 'datetime',
            'email_reminders' => 'boolean',
            'push_reminders' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Specifies the user's FCM tokens
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->notificationTokens->pluck('fcm_token')->toArray();
    }

    /**
     * Check if the user has registered via google.
     */
    public function isSocialLogin(): bool
    {
        return !is_null($this->google_id);
    }

    /**
     * Check if user should see password reminder banner
     */
    public function shouldShowPasswordReminder(): bool
    {
        // Don't show if user has set password
        if ($this->has_set_password) {
            return false;
        }

        // Don't show if not OAuth user
        if (!$this->isSocialLogin()) {
            return false;
        }

        return true;
    }

    /**
     * Mark password as set
     */
    public function markPasswordAsSet(): void
    {
        $this->update([
            'has_set_password' => true,
            'password_reminder_dismissed_at' => null
        ]);
    }

    /**
     * Get the onboardings for the user.
     */
    public function onboardings(): HasMany
    {
        return $this->hasMany(Onboarding::class);
    }

    /**
     * Check if the user has completed a specific onboarding step.
     *
     * @param string $stepKey
     * @return bool
     */
    public function hasCompletedOnboardingStep(string $stepKey): bool
    {
        return $this->onboardings()
            ->where('step_key', $stepKey)
            ->where('is_completed', true)
            ->exists();
    }

    /**
     * Check if the user has completed all onboarding steps.
     *
     * @return bool
     */
    public function hasCompletedAllOnboardingSteps(): bool
    {
        $onboardingSteps = config('app.onboarding.steps', [
            'wallets',
            'categories',
            'expense-people',
            'user-preferences',
        ]);

        foreach ($onboardingSteps as $step) {
            if (!$this->hasCompletedOnboardingStep($step)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the user fcm tokens associated with the user.
     */
    public function notificationTokens(): HasMany
    {
        return $this->hasMany(UserToken::class);
    }

    /**
     * Get the categories associated with the user.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the wallets associated with the user.
     */
    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * Get the transactions associated with the user.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the budgets associated with the user.
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    /**
     * Get the support tickets associated with the user.
     */
    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    /**
     * Get the expense people associated with the user.
     */
    public function expensePeople(): HasMany
    {
        return $this->hasMany(ExpensePerson::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class)->latest();
    }

    public function recentActivities(int $limit = 10): HasMany
    {
        return $this->hasMany(UserActivity::class)
            ->latest()
            ->limit($limit);
    }

    // Boot method to log account creation
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            ActivityTracker::logAccountCreated($user->id);
        });

        static::updated(function ($user) {
            if ($user->wasChanged('password')) {
                ActivityTracker::logPasswordChange($user->id);

                $user->password_updated_at = now();
                $user->save();
            }
        });
    }

    public function preferences()
    {
        return $this->hasOne(UserPreference::class);
    }

    /**
     * Get the next reminder date based on user's frequency preference
     */
    public function getNextReminderDate()
    {
        $now = Carbon::now();
        $reminderTime = Carbon::parse($this->reminder_time ?? '09:00');
        $lastSent = $this->last_reminder_sent ? Carbon::parse($this->last_reminder_sent) : null;

        switch ($this->reminder_frequency) {
            case 'daily':
                return $now->copy()->setTime($reminderTime->hour, $reminderTime->minute);

            case 'weekly':
                return $now->copy()->next(Carbon::MONDAY)->setTime($reminderTime->hour, $reminderTime->minute);

            case 'every_2_days':
            case 'every_3_days':
            case 'every_4_days':
            case 'every_5_days':
            case 'every_6_days':
                $intervalDays = (int) str_replace(['every_', '_days'], '', $this->reminder_frequency);
                $baseDate = $lastSent ?? $now;
                return $baseDate->copy()->addDays($intervalDays)->setTime($reminderTime->hour, $reminderTime->minute);

            case 'custom_weekdays':
                return $this->getNextCustomWeekdayDate($reminderTime);

            case 'random':
                $minDays = $this->random_min_days ?? 1;
                $maxDays = $this->random_max_days ?? 3;
                $randomDays = rand($minDays, $maxDays);
                $baseDate = $lastSent ?? $now;
                return $baseDate->copy()->addDays($randomDays)->setTime($reminderTime->hour, $reminderTime->minute);

            default:
                return null;
        }
    }

    /**
     * Get the next reminder date for custom weekdays
     */
    private function getNextCustomWeekdayDate($reminderTime)
    {
        $customWeekdays = $this->custom_weekdays ?? [];
        if (empty($customWeekdays)) {
            return null;
        }

        $now = Carbon::now();
        
        // Find the next occurrence of any of the custom weekdays
        for ($i = 0; $i < 7; $i++) {
            $checkDate = $now->copy()->addDays($i);
            $dayOfWeek = $checkDate->dayOfWeek === 0 ? 7 : $checkDate->dayOfWeek; // Convert Sunday=0 to Sunday=7
            
            if (in_array($dayOfWeek, $customWeekdays) || in_array($checkDate->dayOfWeek, $customWeekdays)) {
                return $checkDate->setTime($reminderTime->hour, $reminderTime->minute);
            }
        }

        return null;
    }

    /**
     * Check if user should receive a reminder today
     */
    public function shouldReceiveReminderToday()
    {
        $now = Carbon::now();
        $reminderTime = Carbon::parse($this->reminder_time ?? '09:00');
        
        // Check if it's within the reminder time window (1 hour)
        $currentMinutes = $now->hour * 60 + $now->minute;
        $reminderMinutes = $reminderTime->hour * 60 + $reminderTime->minute;
        
        if (abs($currentMinutes - $reminderMinutes) > 60) {
            return false;
        }

        $lastSent = $this->last_reminder_sent ? Carbon::parse($this->last_reminder_sent) : null;

        switch ($this->reminder_frequency) {
            case 'daily':
                return true;

            case 'weekly':
                return $now->dayOfWeek === Carbon::MONDAY;

            case 'every_2_days':
            case 'every_3_days':
            case 'every_4_days':
            case 'every_5_days':
            case 'every_6_days':
                if (!$lastSent) return true;
                $intervalDays = (int) str_replace(['every_', '_days'], '', $this->reminder_frequency);
                return $lastSent->diffInDays($now) >= $intervalDays;

            case 'custom_weekdays':
                $customWeekdays = $this->custom_weekdays ?? [];
                $dayOfWeek = $now->dayOfWeek === 0 ? 7 : $now->dayOfWeek;
                return in_array($dayOfWeek, $customWeekdays) || in_array($now->dayOfWeek, $customWeekdays);

            case 'random':
                if (!$lastSent) return true;
                $minDays = $this->random_min_days ?? 1;
                $maxDays = $this->random_max_days ?? 3;
                $daysSinceLastReminder = $lastSent->diffInDays($now);
                
                if ($daysSinceLastReminder < $minDays) return false;
                
                $probabilityFactor = ($daysSinceLastReminder - $minDays + 1) / ($maxDays - $minDays + 1);
                $randomThreshold = min($probabilityFactor * 0.5, 0.8);
                
                return mt_rand() / mt_getrandmax() < $randomThreshold;

            default:
                return false;
        }
    }
}
