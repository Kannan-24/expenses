<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetHistory extends Model
{
    protected $fillable = [
        'budget_id',
        'allocated_amount',
        'roll_over_amount',
        'spent_amount',
        'start_date',
        'end_date',
        'status',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
