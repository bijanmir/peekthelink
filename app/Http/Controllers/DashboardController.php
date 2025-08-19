<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Date ranges
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisWeek = Carbon::now()->startOfWeek();
        $lastWeek = Carbon::now()->subWeek()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        // Basic metrics (works with current database)
        $totalLinksCount = $user->links()->count();
        $activeLinksCount = $user->links()->where('is_active', true)->count();
        $totalClicks = $user->links()->sum('clicks');
        
        // Profile views (simulate for now since ProfileView table doesn't exist yet)
        $profileViews = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->distinct('ip_address')
            ->count();
            
        $profileViewsToday = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereDate('created_at', $today)
            ->distinct('ip_address')
            ->count();
            
        // Calculate clicks this week vs last week
        $clicksThisWeek = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->where('created_at', '>=', $thisWeek)
            ->count();
            
        $clicksLastWeek = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereBetween('created_at', [$lastWeek, $thisWeek])
            ->count();
        
        $clicksPercentageChange = $this->calculatePercentageChange($clicksThisWeek, $clicksLastWeek);
        
        // Profile views this week vs last week
        $profileViewsThisWeek = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->where('created_at', '>=', $thisWeek)
            ->distinct('ip_address')
            ->count();
            
        $profileViewsLastWeek = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereBetween('created_at', [$lastWeek, $thisWeek])
            ->distinct('ip_address')
            ->count();
            
        $profileViewsPercentageChange = $this->calculatePercentageChange($profileViewsThisWeek, $profileViewsLastWeek);
        
        // Today's clicks
        $todayClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereDate('created_at', $today)
            ->count();
        
        // Monthly revenue (placeholder calculation)
        $monthlyRevenue = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count() * 0.05; // $0.05 per click
            
        $lastMonthRevenue = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count() * 0.05;
            
        $revenuePercentageChange = $this->calculatePercentageChange($monthlyRevenue, $lastMonthRevenue);
        
        // Conversion rate
        $conversionRate = $totalLinksCount > 0 ? round(($activeLinksCount / $totalLinksCount) * 100) : 0;
        
        // Daily analytics for chart (last 7 days)
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
        
        // Fill in missing days with 0 clicks (7 days)
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->format('D');
            $chartLabels[] = $dayName;
            $chartData[] = $dailyClicks->get($date)?->clicks ?? 0;
        }

        // Daily analytics for chart (last 30 days)
        $dailyClicks30d = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as clicks')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        // Fill in missing days with 0 clicks (30 days)
        $chartData30d = [];
        $chartLabels30d = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->format('M j');
            $chartLabels30d[] = $dayName;
            $chartData30d[] = $dailyClicks30d->get($date)?->clicks ?? 0;
        }
        
        // Top performing links
        $topLinks = $user->links()
            ->where('is_active', true)
            ->orderBy('clicks', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'totalLinksCount',
            'activeLinksCount',
            'totalClicks',
            'profileViews',
            'profileViewsToday',
            'profileViewsPercentageChange',
            'clicksPercentageChange',
            'todayClicks',
            'monthlyRevenue',
            'revenuePercentageChange',
            'conversionRate',
            'chartData',
            'chartLabels',
            'chartData30d',
            'chartLabels30d',
            'topLinks'
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
    
    /**
     * Calculate percentage change between two values
     */
    protected function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100, 1);
    }
}