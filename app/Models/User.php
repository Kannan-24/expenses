<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        ];
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
}
