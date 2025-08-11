<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappOtp extends Model
{
    protected $fillable = [
        'email',
        'otp_code',
        'whatsapp_number',
        'expires_at',
        'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Check if the OTP is valid.
     */
    public function isValid(): bool
    {
        return $this->verified_at === null && $this->expires_at->isFuture();
    }
}
