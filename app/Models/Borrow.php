<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'user_id',
        'person_id',
        'amount',
        'returned_amount',
        'status',
        'borrow_type',
        'wallet_id',
        'date',
        'note',
    ];

    public function person()
    {
        return $this->belongsTo(ExpensePerson::class, 'person_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function histories()
    {
        return $this->hasMany(BorrowHistory::class, 'borrow_id');
    }

}
