<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'default_currency_id',
        'default_wallet_id',
        'timezone',
        'dark_mode',
    ];

    /**
     * Get the user that owns the preference.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the default wallet for the user.
     */
    public function defaultWallet()
    {
        return $this->belongsTo(Wallet::class, 'default_wallet_id');
    }

    /**
     * Get the default currency for the user.
     */
    public function defaultCurrency()
    {
        return $this->belongsTo(Currency::class, 'default_currency_id');
    }
}
