<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpensePerson extends Model
{
    protected $table = 'expense_people';

    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     * Get the user that owns the expense person
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the expense person
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'expense_person_id');
    }
}
