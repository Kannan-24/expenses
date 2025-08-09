<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmiLoan extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'total_amount',
        'interest_rate',
        'start_date',
        'tenure_months',
        'monthly_emi',
        'is_auto_deduct',
        'loan_type',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'is_auto_deduct' => 'boolean',
        'interest_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'monthly_emi' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function emiSchedules()
    {
        return $this->hasMany(EmiSchedule::class);
    }
}
