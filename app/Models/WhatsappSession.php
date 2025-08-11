<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappSession extends Model
{
    protected $fillable = [
        'user_id',
        'whatsapp_number',
        'state',
        'temp_data',
        'last_message_at',
    ];

    protected $casts = [
        'temp_data' => 'array',
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the user associated with the WhatsApp session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
