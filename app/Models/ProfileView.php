<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class ProfileView extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
     * Get the user that owns the profile view.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to exclude bot traffic
     */
    public function scopeRealVisitors($query)
    {
        return $query->where('is_bot', false);
    }

    /**
     * Scope to get unique visitors only
     */
    public function scopeUniqueVisitors($query)
    {
        return $query->where('is_unique_visitor', true);
    }

    /**
     * Scope to get views from a specific time period
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get geographic distribution of views
     */
    public static function getGeographicDistribution($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->realVisitors()
            ->select('country_code', 'country_name', DB::raw('COUNT(*) as views'))
            ->whereNotNull('country_code')
            ->groupBy('country_code', 'country_name')
            ->orderBy('views', 'desc');

        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }

        return $query->get();
    }

    /**
     * Get device type distribution
     */
    public static function getDeviceDistribution($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->realVisitors()
            ->select('device_type', DB::raw('COUNT(*) as views'))
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderBy('views', 'desc');

        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }

        return $query->get();
    }

    /**
     * Get traffic source distribution
     */
    public static function getTrafficSourceDistribution($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->realVisitors()
            ->select('traffic_source', DB::raw('COUNT(*) as views'))
            ->whereNotNull('traffic_source')
            ->groupBy('traffic_source')
            ->orderBy('views', 'desc');

        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }

        return $query->get();
    }

    /**
     * Get browser distribution
     */
    public static function getBrowserDistribution($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->realVisitors()
            ->select('browser_name', DB::raw('COUNT(*) as views'))
            ->whereNotNull('browser_name')
            ->groupBy('browser_name')
            ->orderBy('views', 'desc')
            ->limit(10);

        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }

        return $query->get();
    }

    /**
     * Get hourly view distribution
     */
    public static function getHourlyDistribution($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->realVisitors()
            ->select(DB::raw('HOUR(created_at) as hour, COUNT(*) as views'))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour');

        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }

        return $query->get();
    }

    /**
     * Get top referring domains
     */
    public static function getTopReferrers($userId, $startDate = null, $endDate = null, $limit = 10)
    {
        $query = self::where('user_id', $userId)
            ->realVisitors()
            ->whereNotNull('referer')
            ->where('referer', '!=', '')
            ->select(DB::raw('
                CASE 
                    WHEN referer LIKE "%google%" THEN "Google"
                    WHEN referer LIKE "%facebook%" THEN "Facebook"
                    WHEN referer LIKE "%instagram%" THEN "Instagram"
                    WHEN referer LIKE "%twitter%" OR referer LIKE "%x.com%" THEN "Twitter/X"
                    WHEN referer LIKE "%linkedin%" THEN "LinkedIn"
                    WHEN referer LIKE "%tiktok%" THEN "TikTok"
                    WHEN referer LIKE "%youtube%" THEN "YouTube"
                    ELSE SUBSTRING_INDEX(SUBSTRING_INDEX(referer, "/", 3), "//", -1)
                END as referrer_domain,
                COUNT(*) as views
            '))
            ->groupBy('referrer_domain')
            ->orderBy('views', 'desc')
            ->limit($limit);

        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }

        return $query->get();
    }

    /**
     * Get coordinate data for map visualization
     */
    public static function getMapCoordinates($userId, $startDate = null, $endDate = null)
    {
        $query = self::where('user_id', $userId)
            ->realVisitors()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('latitude', 'longitude', 'city', 'country_name', DB::raw('COUNT(*) as views'))
            ->groupBy('latitude', 'longitude', 'city', 'country_name')
            ->orderBy('views', 'desc');

        if ($startDate && $endDate) {
            $query->inDateRange($startDate, $endDate);
        }

        return $query->get();
    }
}