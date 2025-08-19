<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'ip_address',
        'user_agent',
        'referer',
        'country_code',
        'country_name', 
        'region',
        'city',
        'latitude',
        'longitude',
        'device_type',
        'browser_name',
        'browser_version',
        'operating_system',
        'screen_resolution',
        'traffic_source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'session_id',
        'is_unique_visitor',
        'session_duration',
        'is_bot',
        'language',
        'timezone',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_unique_visitor' => 'boolean',
        'is_bot' => 'boolean',
        'session_duration' => 'integer',
    ];

    /**
     * Get the link that was clicked.
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    /**
     * Scope to exclude bot traffic - QUICK FIX for current error
     */
    public function scopeRealVisitors($query)
    {
        // For now, just return all clicks since you don't have is_bot field yet
        // After migration, this will filter out bots: return $query->where('is_bot', false);
        return $query;
    }

    /**
     * Scope to get unique visitors only
     */
    public function scopeUniqueVisitors($query)
    {
        // For now, use IP address uniqueness
        // After migration: return $query->where('is_unique_visitor', true);
        return $query->distinct('ip_address');
    }

    /**
     * Scope to get clicks from a specific time period
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}