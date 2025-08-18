<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'url', 'description', 
        'order', 'is_active', 'clicks'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'clicks' => 'integer',
            'order' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function linkClicks()
    {
        return $this->hasMany(LinkClick::class);
    }

    public function incrementClicks($request)
    {
        $this->increment('clicks');
        
        $this->linkClicks()->create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->headers->get('referer'),
        ]);
    }
}