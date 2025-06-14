<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpensePerson extends Model
{
    protected $table = 'expense_people';

    protected $fillable = [
        'user_id',
        'name',
    ];
    
}
