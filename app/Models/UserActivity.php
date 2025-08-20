<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_type',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
        'location',
        'status',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // set login user ID if not set
            if (!$model->user_id) {
                $model->user_id = Auth::id();
            }
            $model->created_at = now();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Activity type constants
    public const TYPE_LOGIN = 'login';
    public const TYPE_LOGOUT = 'logout';
    public const TYPE_PROFILE_UPDATE = 'profile_update';
    public const TYPE_PASSWORD_CHANGE = 'password_change';
    public const TYPE_EMAIL_VERIFICATION = 'email_verification';
    public const TYPE_ACCOUNT_CREATED = 'account_created';
    public const TYPE_SETTINGS_UPDATE = 'settings_update';
    public const TYPE_SECURITY_ALERT = 'security_alert';

    // Get activity icon and color
    public function getActivityIconAttribute(): array
    {
        return match ($this->activity_type) {
            self::TYPE_LOGIN => [
                'icon' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1',
                'bg_color' => 'bg-green-100',
                'text_color' => 'text-green-600',
                'badge_color' => 'bg-green-100 text-green-600',
                'badge_text' => 'Success'
            ],
            self::TYPE_LOGOUT => [
                'icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1',
                'bg_color' => 'bg-gray-100',
                'text_color' => 'text-gray-600',
                'badge_color' => 'bg-gray-100 text-gray-600',
                'badge_text' => 'Logged Out'
            ],
            self::TYPE_PROFILE_UPDATE => [
                'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                'bg_color' => 'bg-blue-100',
                'text_color' => 'text-blue-600',
                'badge_color' => 'bg-blue-100 text-blue-600',
                'badge_text' => 'Updated'
            ],
            self::TYPE_PASSWORD_CHANGE => [
                'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                'bg_color' => 'bg-orange-100',
                'text_color' => 'text-orange-600',
                'badge_color' => 'bg-orange-100 text-orange-600',
                'badge_text' => 'Security'
            ],
            self::TYPE_ACCOUNT_CREATED => [
                'icon' => 'M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h4a1 1 0 011 1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h4z',
                'bg_color' => 'bg-purple-100',
                'text_color' => 'text-purple-600',
                'badge_color' => 'bg-purple-100 text-purple-600',
                'badge_text' => 'Milestone'
            ],
            default => [
                'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'bg_color' => 'bg-gray-100',
                'text_color' => 'text-gray-600',
                'badge_color' => 'bg-gray-100 text-gray-600',
                'badge_text' => 'Info'
            ]
        };
    }

    // Get formatted location
    public function getFormattedLocationAttribute(): string
    {
        if ($this->location) {
            return $this->location;
        }

        if ($this->ip_address) {
            return "IP: {$this->ip_address}";
        }

        return 'Unknown location';
    }
}
