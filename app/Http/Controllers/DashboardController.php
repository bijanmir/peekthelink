<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's links
        $links = $user->links()->orderBy('order')->get();
        
        // Calculate total clicks
        $totalClicks = $user->links()->sum('clicks');
        
        // Get recent clicks (last 7 days)
        $recentClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        
        // Calculate percentage change vs previous 7 days
        $previousWeekClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
            ->count();
        
        $clicksPercentageChange = $previousWeekClicks > 0 
            ? round((($recentClicks - $previousWeekClicks) / $previousWeekClicks) * 100, 1)
            : ($recentClicks > 0 ? 100 : 0);
        
        // Calculate profile views percentage change
        $currentWeekUniqueViews = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->where('created_at', '>=', now()->subDays(7))
            ->distinct('ip_address')
            ->count();
            
        $previousWeekUniqueViews = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
            ->distinct('ip_address')
            ->count();
            
        $profileViewsPercentageChange = $previousWeekUniqueViews > 0 
            ? round((($currentWeekUniqueViews - $previousWeekUniqueViews) / $previousWeekUniqueViews) * 100, 1)
            : ($currentWeekUniqueViews > 0 ? 100 : 0);
        
        // Calculate monthly revenue change
        $thisMonthClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $lastMonthClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $revenuePercentageChange = $lastMonthClicks > 0 
            ? round((($thisMonthClicks - $lastMonthClicks) / $lastMonthClicks) * 100, 1)
            : ($thisMonthClicks > 0 ? 100 : 0);
        
        // Get daily clicks for chart (last 7 days)
        $dailyClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as clicks')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        // Fill in missing days with 0 clicks
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->format('D');
            $chartLabels[] = $dayName;
            $chartData[] = $dailyClicks->get($date)?->clicks ?? 0;
        }
        
        // Get top performing links
        $topLinks = $user->links()
            ->where('is_active', true)
            ->orderBy('clicks', 'desc')
            ->take(5)
            ->get();
        
        // Profile performance metrics
        $activeLinksCount = $user->links()->where('is_active', true)->count();
        $totalLinksCount = $user->links()->count();
        $conversionRate = $totalLinksCount > 0 ? round(($activeLinksCount / $totalLinksCount) * 100) : 0;
        
        // Calculate profile views (simulate with link clicks for now)
        $profileViews = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->distinct('ip_address')
            ->count();
        
        // Today's activity
        $todayClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereDate('created_at', today())
            ->count();
        
        // This month's revenue (placeholder - you can integrate with actual payment system)
        $monthlyRevenue = $totalClicks * 0.05; // Example: $0.05 per click
        
        return view('dashboard', compact(
            'user',
            'links',
            'totalClicks',
            'recentClicks',
            'clicksPercentageChange',
            'chartData',
            'chartLabels',
            'topLinks',
            'activeLinksCount',
            'totalLinksCount',
            'conversionRate',
            'profileViews',
            'profileViewsPercentageChange',
            'todayClicks',
            'monthlyRevenue',
            'revenuePercentageChange'
        ));
    }
    
    /**
     * API endpoint for real-time dashboard data
     */
    public function realtimeData()
    {
        $user = Auth::user();
        
        $data = [
            'total_clicks' => $user->links()->sum('clicks'),
            'today_clicks' => LinkClick::whereIn('link_id', $user->links()->pluck('id'))
                ->whereDate('created_at', today())
                ->count(),
            'active_links' => $user->links()->where('is_active', true)->count(),
            'profile_views' => LinkClick::whereIn('link_id', $user->links()->pluck('id'))
                ->distinct('ip_address')
                ->count(),
            'latest_click' => LinkClick::whereIn('link_id', $user->links()->pluck('id'))
                ->with('link')
                ->latest()
                ->first(),
        ];
        
        return response()->json($data);
    }
}