<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'expense_person_id',
        'wallet_id',
        'amount',
        'type',
        'date',
        'note',
        'attachments',
    ];

    protected $casts = [
        'date' => 'date',
        'attachments' => 'array',
    ];

    // Expense belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Expense belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function person()
    {
        return $this->belongsTo(\App\Models\ExpensePerson::class, 'expense_person_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
