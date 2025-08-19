<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link;
use App\Models\LinkClick;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected $analyticsService;
    
    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display the user's profile page
     */
    public function show(User $user, Request $request)
    {
        // Check if user profile is active
        if (!$user->is_active) {
            abort(404, 'Profile not found');
        }

        // Track the profile view with enhanced analytics
        try {
            $this->analyticsService->trackProfileView($user->id, $request);
        } catch (\Exception $e) {
            // Log the error but don't break the page load
            Log::warning("Failed to track profile view for user {$user->id}: " . $e->getMessage());
        }

        // Get active links ordered by their position
        $links = $user->links()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Get basic profile stats for the user (optional display)
        $profileStats = [
            'total_views' => \App\Models\ProfileView::where('user_id', $user->id)
                ->realVisitors()
                ->count(),
            'total_clicks' => $user->links()->sum('clicks'),
            'links_count' => $links->count(),
        ];

        return view('profile.show', compact('user', 'links', 'profileStats'));
    }

    /**
     * Handle link redirects with enhanced tracking
     */
    public function redirect(User $user, Link $link, Request $request)
    {
        // Verify the link belongs to the user
        if ($link->user_id !== $user->id) {
            abort(404, 'Link not found');
        }

        // Check if link is active
        if (!$link->is_active) {
            abort(404, 'Link not available');
        }

        // Track the click with enhanced analytics
        try {
            $this->analyticsService->trackLinkClick($link->id, $request);
        } catch (\Exception $e) {
            // Log the error but don't break the redirect
            Log::warning("Failed to track link click for link {$link->id}: " . $e->getMessage());
        }

        // Increment the simple click counter on the link
        $link->increment('clicks');

        // Handle different URL formats
        $url = $link->url;
        
        // Add protocol if missing
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }

        // Validate URL before redirect
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            abort(400, 'Invalid URL');
        }

        // Log the redirect for debugging
        Log::info("Redirecting to: {$url} from link: {$link->title} (ID: {$link->id})");

        return redirect()->away($url);
    }

    /**
     * API endpoint to get link performance data
     */
    public function linkPerformance(User $user, Link $link, Request $request)
    {
        // Verify ownership
        if ($link->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $startDate = $request->get('start_date', now()->subDays(30));
        $endDate = $request->get('end_date', now());

        // Get detailed analytics for this specific link
        $analytics = [
            'total_clicks' => LinkClick::where('link_id', $link->id)
                ->realVisitors()
                ->count(),
            
            'unique_clicks' => LinkClick::where('link_id', $link->id)
                ->realVisitors()
                ->distinct('ip_address')
                ->count(),
            
            'clicks_by_country' => LinkClick::where('link_id', $link->id)
                ->realVisitors()
                ->select('country_name', \DB::raw('COUNT(*) as clicks'))
                ->whereNotNull('country_name')
                ->groupBy('country_name')
                ->orderBy('clicks', 'desc')
                ->limit(10)
                ->get(),
            
            'clicks_by_device' => LinkClick::where('link_id', $link->id)
                ->realVisitors()
                ->select('device_type', \DB::raw('COUNT(*) as clicks'))
                ->whereNotNull('device_type')
                ->groupBy('device_type')
                ->get(),
            
            'clicks_by_source' => LinkClick::where('link_id', $link->id)
                ->realVisitors()
                ->select('traffic_source', \DB::raw('COUNT(*) as clicks'))
                ->whereNotNull('traffic_source')
                ->groupBy('traffic_source')
                ->get(),
            
            'daily_clicks' => LinkClick::where('link_id', $link->id)
                ->realVisitors()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('COUNT(*) as clicks'))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ];

        return response()->json($analytics);
    }

    /**
     * Get real-time visitor information for profile
     */
    public function realtimeVisitors(User $user)
    {
        // Get visitors in the last 5 minutes
        $currentVisitors = \App\Models\ProfileView::where('user_id', $user->id)
            ->realVisitors()
            ->where('created_at', '>=', now()->subMinutes(5))
            ->select('country_name', 'city', 'device_type', 'created_at')
            ->latest()
            ->limit(10)
            ->get();

        // Get recent link clicks
        $recentClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->realVisitors()
            ->with('link:id,title')
            ->where('created_at', '>=', now()->subMinutes(30))
            ->select('link_id', 'country_name', 'city', 'device_type', 'created_at')
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'current_visitors' => $currentVisitors,
            'recent_clicks' => $recentClicks,
            'visitors_count' => $currentVisitors->count(),
        ]);
    }

    /**
     * Get geographic data for mapping
     */
    public function geographicData(User $user, Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(7));
        $endDate = $request->get('end_date', now());

        // Get all profile views with coordinates
        $profileViews = \App\Models\ProfileView::where('user_id', $user->id)
            ->realVisitors()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('latitude', 'longitude', 'city', 'country_name', \DB::raw('COUNT(*) as views'))
            ->groupBy('latitude', 'longitude', 'city', 'country_name')
            ->get();

        // Get link clicks with coordinates
        $linkClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->realVisitors()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('latitude', 'longitude', 'city', 'country_name', \DB::raw('COUNT(*) as clicks'))
            ->groupBy('latitude', 'longitude', 'city', 'country_name')
            ->get();

        return response()->json([
            'profile_views' => $profileViews,
            'link_clicks' => $linkClicks,
        ]);
    }

    /**
     * Export analytics data
     */
    public function exportAnalytics(User $user, Request $request)
    {
        // This would generate CSV/Excel export of analytics data
        $format = $request->get('format', 'csv');
        $startDate = $request->get('start_date', now()->subDays(30));
        $endDate = $request->get('end_date', now());

        // Get comprehensive analytics data
        $data = [
            'profile_views' => \App\Models\ProfileView::where('user_id', $user->id)
                ->realVisitors()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get(),
            
            'link_clicks' => LinkClick::whereIn('link_id', $user->links()->pluck('id'))
                ->realVisitors()
                ->with('link:id,title,url')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get(),
        ];

        // Return appropriate format
        if ($format === 'json') {
            return response()->json($data);
        }
        
        // For CSV export, you'd use a package like League/CSV
        // This is a simplified version
        return response()->json([
            'message' => 'Export functionality to be implemented',
            'data_count' => [
                'profile_views' => $data['profile_views']->count(),
                'link_clicks' => $data['link_clicks']->count(),
            ]
        ]);
    }
}