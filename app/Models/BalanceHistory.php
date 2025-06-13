<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'updated_by',
        'cash_before',
        'cash_after',
        'bank_before',
        'bank_after',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
