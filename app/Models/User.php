<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\ActivityTracker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            'last_login_at' => 'datetime',
        ];
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
}
