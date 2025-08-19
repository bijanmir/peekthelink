<?php

namespace App\Services;

use App\Models\LinkClick;
use App\Models\ProfileView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;

class AnalyticsService
{
    protected $agent;
    
    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Track a profile view with enhanced analytics
     */
    public function trackProfileView($userId, Request $request)
    {
        $sessionId = $request->session()->getId();
        $ipAddress = $request->ip();
        
        // Check if this is a unique visitor (first visit from this IP/session)
        $isUniqueVisitor = !ProfileView::where('user_id', $userId)
            ->where(function($query) use ($ipAddress, $sessionId) {
                $query->where('ip_address', $ipAddress)
                      ->orWhere('session_id', $sessionId);
            })
            ->exists();

        // Get geographic data
        $geoData = $this->getGeographicData($ipAddress);
        
        // Parse device and browser info
        $deviceData = $this->parseDeviceData($request);
        
        // Analyze traffic source
        $trafficData = $this->analyzeTrafficSource($request);
        
        // Detect if it's a bot
        $isBot = $this->detectBot($request);

        ProfileView::create([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'session_id' => $sessionId,
            'is_unique_visitor' => $isUniqueVisitor,
            'is_bot' => $isBot,
            
            // Geographic data
            'country_code' => $geoData['country_code'] ?? null,
            'country_name' => $geoData['country_name'] ?? null,
            'region' => $geoData['region'] ?? null,
            'city' => $geoData['city'] ?? null,
            'latitude' => $geoData['latitude'] ?? null,
            'longitude' => $geoData['longitude'] ?? null,
            
            // Device data
            'device_type' => $deviceData['device_type'],
            'browser_name' => $deviceData['browser_name'],
            'browser_version' => $deviceData['browser_version'],
            'operating_system' => $deviceData['operating_system'],
            'screen_resolution' => $deviceData['screen_resolution'],
            
            // Traffic data
            'traffic_source' => $trafficData['traffic_source'],
            'utm_source' => $trafficData['utm_source'] ?? null,
            'utm_medium' => $trafficData['utm_medium'] ?? null,
            'utm_campaign' => $trafficData['utm_campaign'] ?? null,
            'utm_term' => $trafficData['utm_term'] ?? null,
            'utm_content' => $trafficData['utm_content'] ?? null,
            
            // Additional data
            'language' => $request->getPreferredLanguage(),
            'timezone' => $request->header('timezone'),
        ]);
    }

    /**
     * Track a link click with enhanced analytics
     */
    public function trackLinkClick($linkId, Request $request)
    {
        $sessionId = $request->session()->getId();
        $ipAddress = $request->ip();
        
        // Check if this is a unique visitor for this link
        $isUniqueVisitor = !LinkClick::where('link_id', $linkId)
            ->where(function($query) use ($ipAddress, $sessionId) {
                $query->where('ip_address', $ipAddress)
                      ->orWhere('session_id', $sessionId);
            })
            ->exists();

        // Get geographic data
        $geoData = $this->getGeographicData($ipAddress);
        
        // Parse device and browser info
        $deviceData = $this->parseDeviceData($request);
        
        // Analyze traffic source
        $trafficData = $this->analyzeTrafficSource($request);
        
        // Detect if it's a bot
        $isBot = $this->detectBot($request);

        LinkClick::create([
            'link_id' => $linkId,
            'ip_address' => $ipAddress,
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'session_id' => $sessionId,
            'is_unique_visitor' => $isUniqueVisitor,
            'is_bot' => $isBot,
            
            // Geographic data
            'country_code' => $geoData['country_code'] ?? null,
            'country_name' => $geoData['country_name'] ?? null,
            'region' => $geoData['region'] ?? null,
            'city' => $geoData['city'] ?? null,
            'latitude' => $geoData['latitude'] ?? null,
            'longitude' => $geoData['longitude'] ?? null,
            
            // Device data
            'device_type' => $deviceData['device_type'],
            'browser_name' => $deviceData['browser_name'],
            'browser_version' => $deviceData['browser_version'],
            'operating_system' => $deviceData['operating_system'],
            'screen_resolution' => $deviceData['screen_resolution'],
            
            // Traffic data
            'traffic_source' => $trafficData['traffic_source'],
            'utm_source' => $trafficData['utm_source'] ?? null,
            'utm_medium' => $trafficData['utm_medium'] ?? null,
            'utm_campaign' => $trafficData['utm_campaign'] ?? null,
            'utm_term' => $trafficData['utm_term'] ?? null,
            'utm_content' => $trafficData['utm_content'] ?? null,
            
            // Additional data
            'language' => $request->getPreferredLanguage(),
            'timezone' => $request->header('timezone'),
        ]);
    }

    /**
     * Get geographic data from IP address
     */
    protected function getGeographicData($ipAddress)
    {
        // Skip for local/private IPs
        if ($this->isLocalIp($ipAddress)) {
            return [
                'country_code' => 'US',
                'country_name' => 'United States',
                'region' => 'Local',
                'city' => 'Development',
                'latitude' => 37.7749,
                'longitude' => -122.4194,
            ];
        }

        // Cache the result for 24 hours
        return Cache::remember("geo_{$ipAddress}", 86400, function () use ($ipAddress) {
            try {
                // Using ipapi.co (free tier: 1000 requests/day)
                $response = Http::timeout(3)->get("https://ipapi.co/{$ipAddress}/json/");
                
                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'country_code' => $data['country_code'] ?? null,
                        'country_name' => $data['country_name'] ?? null,
                        'region' => $data['region'] ?? null,
                        'city' => $data['city'] ?? null,
                        'latitude' => $data['latitude'] ?? null,
                        'longitude' => $data['longitude'] ?? null,
                    ];
                }
            } catch (\Exception $e) {
                // Log error but don't fail the tracking
                \Log::warning("Geographic lookup failed for IP {$ipAddress}: " . $e->getMessage());
            }
            
            return [];
        });
    }

    /**
     * Parse device and browser information
     */
    protected function parseDeviceData(Request $request)
    {
        $this->agent->setUserAgent($request->userAgent());
        
        return [
            'device_type' => $this->getDeviceType(),
            'browser_name' => $this->agent->browser(),
            'browser_version' => $this->agent->version($this->agent->browser()),
            'operating_system' => $this->agent->platform(),
            'screen_resolution' => $request->header('screen-resolution'), // Would need JS to set this
        ];
    }

    /**
     * Get simplified device type
     */
    protected function getDeviceType()
    {
        if ($this->agent->isMobile()) {
            return 'mobile';
        } elseif ($this->agent->isTablet()) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * Analyze traffic source
     */
    protected function analyzeTrafficSource(Request $request)
    {
        $referer = $request->header('referer');
        $utmSource = $request->get('utm_source');
        
        // Check for UTM parameters first
        if ($utmSource) {
            $trafficSource = 'campaign';
        } elseif (!$referer) {
            $trafficSource = 'direct';
        } else {
            $trafficSource = $this->categorizeReferer($referer);
        }
        
        return [
            'traffic_source' => $trafficSource,
            'utm_source' => $request->get('utm_source'),
            'utm_medium' => $request->get('utm_medium'),
            'utm_campaign' => $request->get('utm_campaign'),
            'utm_term' => $request->get('utm_term'),
            'utm_content' => $request->get('utm_content'),
        ];
    }

    /**
     * Categorize referer into traffic source
     */
    protected function categorizeReferer($referer)
    {
        $referer = strtolower($referer);
        
        // Search engines
        $searchEngines = ['google', 'bing', 'yahoo', 'duckduckgo', 'baidu'];
        foreach ($searchEngines as $engine) {
            if (strpos($referer, $engine) !== false) {
                return 'search';
            }
        }
        
        // Social media
        $socialPlatforms = [
            'facebook', 'instagram', 'twitter', 'x.com', 'linkedin', 
            'tiktok', 'youtube', 'pinterest', 'snapchat', 'reddit'
        ];
        foreach ($socialPlatforms as $platform) {
            if (strpos($referer, $platform) !== false) {
                return 'social';
            }
        }
        
        // Email
        if (strpos($referer, 'mail') !== false || strpos($referer, 'email') !== false) {
            return 'email';
        }
        
        return 'referral';
    }

    /**
     * Detect if the request is from a bot
     */
    protected function detectBot(Request $request)
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        
        $botKeywords = [
            'bot', 'crawler', 'spider', 'scraper', 'facebook', 'twitter',
            'linkedin', 'whatsapp', 'telegram', 'googlebot', 'bingbot'
        ];
        
        foreach ($botKeywords as $keyword) {
            if (strpos($userAgent, $keyword) !== false) {
                return true;
            }
        }
        
        return $this->agent->isRobot();
    }

    /**
     * Check if IP is local/private
     */
    protected function isLocalIp($ip)
    {
        return $ip === '127.0.0.1' || 
               $ip === '::1' || 
               filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    /**
     * Get comprehensive analytics data for dashboard
     */
    public function getDashboardAnalytics($userId, $startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? now()->subDays(30);
        $endDate = $endDate ?? now();

        return [
            'geographic' => ProfileView::getGeographicDistribution($userId, $startDate, $endDate),
            'devices' => ProfileView::getDeviceDistribution($userId, $startDate, $endDate),
            'traffic_sources' => ProfileView::getTrafficSourceDistribution($userId, $startDate, $endDate),
            'browsers' => ProfileView::getBrowserDistribution($userId, $startDate, $endDate),
            'hourly_pattern' => ProfileView::getHourlyDistribution($userId, $startDate, $endDate),
            'top_referrers' => ProfileView::getTopReferrers($userId, $startDate, $endDate),
            'map_data' => ProfileView::getMapCoordinates($userId, $startDate, $endDate),
        ];
    }
}