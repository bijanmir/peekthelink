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
        $thisWeek = Carbon::now()->startOfWeek();
        $lastWeek = Carbon::now()->subWeek()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        // Basic metrics
        $totalLinksCount = $user->links()->count();
        $activeLinksCount = $user->links()->where('is_active', true)->count();
        $totalClicks = $user->links()->sum('clicks');
        
        // Profile views (using LinkClick as proxy)
        $profileViews = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
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

        // === ENHANCED REVENUE CALCULATIONS ===
        
        // Revenue from sponsored links (pay per click)
        $sponsoredRevenue = LinkClick::whereIn('link_id', function($query) use ($user) {
                $query->select('id')
                    ->from('links')
                    ->where('user_id', $user->id)
                    ->where('link_type', 'sponsored');
            })
            ->join('links', 'link_clicks.link_id', '=', 'links.id')
            ->whereBetween('link_clicks.created_at', [$thisMonth, now()])
            ->sum('links.sponsored_rate');
        
        // Estimated revenue from affiliate links
        $affiliateEstimatedRevenue = $user->links()
            ->where('link_type', 'affiliate')
            ->where('is_active', true)
            ->get()
            ->sum(function($link) use ($thisMonth) {
                $monthlyClicks = LinkClick::where('link_id', $link->id)
                    ->whereBetween('created_at', [$thisMonth, now()])
                    ->count();
                
                // Calculate potential: clicks × estimated_value × commission_rate × estimated_conversion_rate
                $estimatedConversionRate = 0.02; // 2% default
                return $monthlyClicks * $link->estimated_value * ($link->commission_rate / 100) * $estimatedConversionRate;
            });
        
        // Revenue from product sales (using total_revenue field)
        $productRevenue = $user->links()
            ->where('link_type', 'product')
            ->sum('total_revenue');
        
        // Total monthly revenue
        $monthlyRevenue = $sponsoredRevenue + $affiliateEstimatedRevenue + $productRevenue;
        
        // Last month revenue for comparison
        $lastMonthSponsored = LinkClick::whereIn('link_id', function($query) use ($user) {
                $query->select('id')
                    ->from('links')
                    ->where('user_id', $user->id)
                    ->where('link_type', 'sponsored');
            })
            ->join('links', 'link_clicks.link_id', '=', 'links.id')
            ->whereBetween('link_clicks.created_at', [$lastMonth, $lastMonth->copy()->endOfMonth()])
            ->sum('links.sponsored_rate');
            
        $lastMonthAffiliate = $user->links()
            ->where('link_type', 'affiliate')
            ->where('is_active', true)
            ->get()
            ->sum(function($link) use ($lastMonth) {
                $monthlyClicks = LinkClick::where('link_id', $link->id)
                    ->whereBetween('created_at', [$lastMonth, $lastMonth->copy()->endOfMonth()])
                    ->count();
                
                $estimatedConversionRate = 0.02;
                return $monthlyClicks * $link->estimated_value * ($link->commission_rate / 100) * $estimatedConversionRate;
            });
            
        $lastMonthRevenue = $lastMonthSponsored + $lastMonthAffiliate;
        $revenuePercentageChange = $this->calculatePercentageChange($monthlyRevenue, $lastMonthRevenue);
        
        // Revenue breakdown by type
        $revenueByType = [
            'affiliate' => $affiliateEstimatedRevenue,
            'sponsored' => $sponsoredRevenue,
            'product' => $productRevenue,
        ];
        
        // Conversion metrics
        $totalConversions = $user->links()->sum('conversions');
        $conversionRate = $totalClicks > 0 ? round(($totalConversions / $totalClicks) * 100, 2) : 0;
        
        // Revenue per click
        $revenuePerClick = $totalClicks > 0 ? round($monthlyRevenue / $totalClicks, 4) : 0;
        
        // Top performing links by revenue potential
        $topRevenueLinks = $user->links()
            ->where('is_active', true)
            ->get()
            ->map(function($link) use ($thisMonth) {
                $monthlyClicks = LinkClick::where('link_id', $link->id)
                    ->whereBetween('created_at', [$thisMonth, now()])
                    ->count();
                
                // Calculate revenue based on link type
                $revenue = 0;
                switch ($link->link_type) {
                    case 'sponsored':
                        $revenue = $monthlyClicks * $link->sponsored_rate;
                        break;
                    case 'affiliate':
                        $revenue = $monthlyClicks * $link->estimated_value * ($link->commission_rate / 100) * 0.02;
                        break;
                    case 'product':
                        $revenue = $link->total_revenue;
                        break;
                }
                
                return [
                    'link' => $link,
                    'revenue' => $revenue,
                    'clicks' => $monthlyClicks,
                    'conversions' => $link->conversions,
                    'conversion_rate' => $monthlyClicks > 0 ? round(($link->conversions / $monthlyClicks) * 100, 2) : 0,
                    'revenue_per_click' => $monthlyClicks > 0 ? round($revenue / $monthlyClicks, 4) : 0,
                ];
            })
            ->sortByDesc('revenue')
            ->take(5)
            ->values();
        
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
        
        // Fill in missing days with 0 clicks
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->format('D');
            $chartLabels[] = $dayName;
            $chartData[] = $dailyClicks->get($date)?->clicks ?? 0;
        }

        // 30-day chart data
        // In your DashboardController.php, replace the 30-day chart section with:
$chartData30d = [];
$chartLabels30d = [];
for ($i = 29; $i >= 0; $i--) {
    $date = now()->subDays($i)->format('Y-m-d');
    $dayName = now()->subDays($i)->format('M j');
    $chartLabels30d[] = $dayName;
    
    // Get actual clicks for this date
    $dayClicks = LinkClick::whereIn('link_id', $user->links()->pluck('id'))
        ->whereDate('created_at', now()->subDays($i))
        ->count();
    $chartData30d[] = $dayClicks;
}
        
        // Top performing links (basic version for compatibility)
        $topLinks = $user->links()
    ->where('clicks', '>', 0)
    ->orderByDesc('clicks')
    ->limit(5)
    ->get();

        return view('dashboard', compact(
            'user',
            'totalLinksCount',
            'activeLinksCount',
            'totalClicks',
            'profileViews',
            'profileViewsPercentageChange',
            'clicksPercentageChange',
            'todayClicks',
            'monthlyRevenue',
            'revenuePercentageChange',
            'conversionRate',
            'revenuePerClick',
            'revenueByType',
            'topRevenueLinks',
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
        
        $todayRevenue = LinkClick::whereIn('link_id', function($query) use ($user) {
                $query->select('id')
                    ->from('links')
                    ->where('user_id', $user->id)
                    ->where('link_type', 'sponsored');
            })
            ->join('links', 'link_clicks.link_id', '=', 'links.id')
            ->whereDate('link_clicks.created_at', today())
            ->sum('links.sponsored_rate');
        
        $data = [
            'total_clicks' => $user->links()->sum('clicks'),
            'today_clicks' => LinkClick::whereIn('link_id', $user->links()->pluck('id'))
                ->whereDate('created_at', today())
                ->count(),
            'today_revenue' => $todayRevenue,
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