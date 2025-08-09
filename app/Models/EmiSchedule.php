<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmiSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'emi_loan_id',
        'due_date',
        'principal_amount',
        'interest_amount',
        'total_amount',
        'status',
        'paid_date',
        'paid_amount',
        'notes',
        'transaction_id',
        'wallet_id'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
        'principal_amount' => 'decimal:2',
        'interest_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2'
    ];

    public function emiLoan()
    {
        return $this->belongsTo(EmiLoan::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
