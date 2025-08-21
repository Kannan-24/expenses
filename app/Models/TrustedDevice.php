<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrustedDevice extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id','device_key','device_name','ip','user_agent','last_used_at' ];

    protected $casts = [ 'last_used_at' => 'datetime' ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    // Human-friendly device name derived from user agent or stored device_name
    public function getDisplayNameAttribute()
    {
        // Always pick the best source: user_agent or device_name
        $source = $this->user_agent ?: $this->device_name ?: '';
        $source = trim($source);
        if($source === '') return 'Device';

        $lower = strtolower($source);

        // strip IP addresses appended at end
        $source = preg_replace('/\s+\d{1,3}(?:\.\d{1,3}){3}\b/', '', $source);

        // Mobile detection and model extraction
        if(str_contains($lower, 'iphone')) return 'iPhone';
        if(str_contains($lower, 'ipad')) return 'iPad';
        if(str_contains($lower, 'android')){
            // try to extract 'Android; <Model>' style
            if(preg_match('/android[^;\)]*;\s*([^;\)\/]*)/i', $source, $m)){
                $maybe = trim($m[1]);
                if($maybe) return $maybe;
            }
            return 'Android Device';
        }

        // Browser detection
        if(preg_match('/\b(chrome)\/[0-9\.]+/i', $source, $m) && !str_contains($lower,'edg') && !str_contains($lower,'opr')) return 'Chrome';
        if(str_contains($lower,'edg') || str_contains($lower,'edge')) return 'Edge';
        if(preg_match('/\b(firefox)\/[0-9\.]+/i', $source)) return 'Firefox';
        if(str_contains($lower,'safari') && !str_contains($lower,'chrome')) return 'Safari';

        // As a last resort return the first meaningful token (avoid long UA)
        $short = preg_split('/[\/;()\s]+/', $source);
        foreach($short as $tok){
            $tok = trim($tok);
            if($tok === '' || preg_match('/mozilla|applewebkit|khtml|like|gecko|safari|windows|linux|compatible|http/i', $tok)) continue;
            // strip any IP-like token
            if(preg_match('/^\d{1,3}(?:\.\d{1,3}){3}$/', $tok)) continue;
            return strlen($tok) > 20 ? substr($tok,0,20) : $tok;
        }

        return 'Device';
    }
}
