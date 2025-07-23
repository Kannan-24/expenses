<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowHistory extends Model
{
    protected $fillable = [
        'borrow_id',
        'wallet_id',
        'amount',
        'date'
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
