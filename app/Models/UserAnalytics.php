<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class UserAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'referrer',
        'ip_address',
        'user_agent',
        'action',
        'additional_data',
    ];

    protected $casts = [
        'additional_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function trackFromRequest($request, $userId = null, $action = 'page_visit', $additionalData = [])
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return null;
        }

        return self::create([
            'user_id' => $userId,
            'utm_source' => $request->get('utm_source'),
            'utm_medium' => $request->get('utm_medium'),
            'utm_campaign' => $request->get('utm_campaign'),
            'utm_term' => $request->get('utm_term'),
            'utm_content' => $request->get('utm_content'),
            'referrer' => $request->header('referer'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'action' => $action,
            'additional_data' => $additionalData,
        ]);
    }
}