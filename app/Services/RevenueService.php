<?php

namespace App\Services;

use App\Models\User;
use App\Models\Link;
use App\Models\Conversion;
use App\Models\LinkClick;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueService
{
    /**
     * Get comprehensive revenue data for a user
     */
    public function getUserRevenueData($userId, $startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? now()->startOfMonth();
        $endDate = $endDate ?? now()->endOfMonth();
        
        // 1. Confirmed revenue (verified conversions)
        $confirmedRevenue = Conversion::where('user_id', $userId)
            ->confirmed()
            ->verified()
            ->inDateRange($startDate, $endDate)
            ->sum('commission_amount');
            
        // 2. Pending revenue (unverified conversions)
        $pendingRevenue = Conversion::where('user_id', $userId)
            ->pending()
            ->inDateRange($startDate, $endDate)
            ->sum('commission_amount');
            
        // 3. Sponsored revenue (pay per click)
        $sponsoredRevenue = LinkClick::whereIn('link_id', function($query) use ($userId) {
                $query->select('id')
                    ->from('links')
                    ->where('user_id', $userId)
                    ->where('link_type', 'sponsored');
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->join('links', 'link_clicks.link_id', '=', 'links.id')
            ->sum('links.sponsored_rate');
            
        // 4. Estimated potential revenue
        $estimatedRevenue = $this->calculateEstimatedRevenue($userId, $startDate, $endDate);
        
        // 5. Revenue by type
        $revenueByType = $this->getRevenueByType($userId, $startDate, $endDate);
        
        // 6. Top performing links
        $topPerformingLinks = $this->getTopPerformingLinks($userId, $startDate, $endDate);
        
        // 7. Conversion metrics
        $conversionMetrics = $this->getConversionMetrics($userId, $startDate, $endDate);

        return [
            'confirmed_revenue' => $confirmedRevenue,
            'pending_revenue' => $pendingRevenue,
            'sponsored_revenue' => $sponsoredRevenue,
            'estimated_revenue' => $estimatedRevenue,
            'total_confirmed' => $confirmedRevenue + $sponsoredRevenue,
            'total_potential' => $confirmedRevenue + $pendingRevenue + $sponsoredRevenue + $estimatedRevenue,
            'revenue_by_type' => $revenueByType,
            'top_performing_links' => $topPerformingLinks,
            'conversion_metrics' => $conversionMetrics,
        ];
    }

    /**
     * Calculate estimated revenue from unconverted clicks
     */
    private function calculateEstimatedRevenue($userId, $startDate, $endDate)
    {
        $userLinks = Link::where('user_id', $userId)
            ->whereIn('link_type', ['affiliate', 'product'])
            ->get();
            
        $totalEstimated = 0;
        
        foreach ($userLinks as $link) {
            // Get clicks that haven't converted yet
            $unconvertedClicks = LinkClick::where('link_id', $link->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('conversions')
                        ->whereColumn('conversions.click_id', 'link_clicks.id');
                })
                ->count();
                
            if ($unconvertedClicks > 0) {
                $potentialPerClick = $link->calculatePotentialRevenue();
                $totalEstimated += $unconvertedClicks * $potentialPerClick;
            }
        }
        
        return $totalEstimated;
    }

    /**
     * Get revenue breakdown by link type
     */
    private function getRevenueByType($userId, $startDate, $endDate)
    {
        // Affiliate revenue
        $affiliateRevenue = Conversion::where('user_id', $userId)
            ->whereHas('link', function($query) {
                $query->where('link_type', 'affiliate');
            })
            ->confirmed()
            ->inDateRange($startDate, $endDate)
            ->sum('commission_amount');
            
        // Product sales revenue
        $productRevenue = Conversion::where('user_id', $userId)
            ->whereHas('link', function($query) {
                $query->where('link_type', 'product');
            })
            ->confirmed()
            ->inDateRange($startDate, $endDate)
            ->sum('commission_amount');
            
        // Sponsored revenue
        $sponsoredRevenue = LinkClick::whereIn('link_id', function($query) use ($userId) {
                $query->select('id')
                    ->from('links')
                    ->where('user_id', $userId)
                    ->where('link_type', 'sponsored');
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->join('links', 'link_clicks.link_id', '=', 'links.id')
            ->sum('links.sponsored_rate');

        return [
            'affiliate' => $affiliateRevenue,
            'product' => $productRevenue,
            'sponsored' => $sponsoredRevenue,
        ];
    }

    /**
     * Get top performing links by revenue
     */
    private function getTopPerformingLinks($userId, $startDate, $endDate, $limit = 5)
    {
        return Link::where('user_id', $userId)
            ->with(['conversions' => function($query) use ($startDate, $endDate) {
                $query->confirmed()->inDateRange($startDate, $endDate);
            }])
            ->get()
            ->map(function($link) use ($startDate, $endDate) {
                $revenue = $link->conversions->sum('commission_amount');
                $clicks = $link->clicks()->whereBetween('created_at', [$startDate, $endDate])->count();
                $conversions = $link->conversions->count();
                
                return [
                    'link' => $link,
                    'revenue' => $revenue,
                    'clicks' => $clicks,
                    'conversions' => $conversions,
                    'conversion_rate' => $clicks > 0 ? round(($conversions / $clicks) * 100, 2) : 0,
                    'revenue_per_click' => $clicks > 0 ? round($revenue / $clicks, 4) : 0,
                ];
            })
            ->sortByDesc('revenue')
            ->take($limit)
            ->values();
    }

    /**
     * Get conversion metrics
     */
    private function getConversionMetrics($userId, $startDate, $endDate)
    {
        $totalClicks = LinkClick::whereIn('link_id', function($query) use ($userId) {
                $query->select('id')->from('links')->where('user_id', $userId);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
            
        $totalConversions = Conversion::where('user_id', $userId)
            ->confirmed()
            ->inDateRange($startDate, $endDate)
            ->count();
            
        $averageOrderValue = Conversion::where('user_id', $userId)
            ->confirmed()
            ->inDateRange($startDate, $endDate)
            ->avg('revenue_amount');
            
        $averageCommission = Conversion::where('user_id', $userId)
            ->confirmed()
            ->inDateRange($startDate, $endDate)
            ->avg('commission_amount');

        return [
            'total_clicks' => $totalClicks,
            'total_conversions' => $totalConversions,
            'overall_conversion_rate' => $totalClicks > 0 ? round(($totalConversions / $totalClicks) * 100, 2) : 0,
            'average_order_value' => round($averageOrderValue ?? 0, 2),
            'average_commission' => round($averageCommission ?? 0, 2),
        ];
    }

    /**
     * Track a new conversion
     */
    public function trackConversion($linkId, $data)
    {
        $link = Link::findOrFail($linkId);
        
        return $link->trackConversion([
            'click_id' => $data['click_id'] ?? null,
            'type' => $data['type'] ?? 'sale',
            'revenue_amount' => $data['revenue_amount'],
            'commission_amount' => $data['commission_amount'] ?? $this->calculateCommission($link, $data['revenue_amount']),
            'currency' => $data['currency'] ?? 'USD',
            'order_id' => $data['order_id'] ?? null,
            'transaction_id' => $data['transaction_id'] ?? null,
            'metadata' => $data['metadata'] ?? null,
            'conversion_date' => $data['conversion_date'] ?? now(),
            'status' => $data['status'] ?? 'pending',
            'auto_verify' => $data['auto_verify'] ?? false,
        ]);
    }

    /**
     * Calculate commission based on link settings
     */
    private function calculateCommission($link, $revenueAmount)
    {
        switch ($link->link_type) {
            case 'affiliate':
                return $revenueAmount * ($link->commission_rate / 100);
            case 'product':
                return $revenueAmount; // Full amount for own products
            case 'sponsored':
                return $link->sponsored_rate; // Fixed rate
            default:
                return 0;
        }
    }

    /**
     * Get revenue comparison between periods
     */
    public function getRevenueComparison($userId, $currentStart, $currentEnd, $previousStart, $previousEnd)
    {
        $currentRevenue = $this->getUserRevenueData($userId, $currentStart, $currentEnd);
        $previousRevenue = $this->getUserRevenueData($userId, $previousStart, $previousEnd);
        
        $currentTotal = $currentRevenue['total_confirmed'];
        $previousTotal = $previousRevenue['total_confirmed'];
        
        $percentageChange = $previousTotal > 0 
            ? round((($currentTotal - $previousTotal) / $previousTotal) * 100, 1)
            : ($currentTotal > 0 ? 100 : 0);

        return [
            'current' => $currentRevenue,
            'previous' => $previousRevenue,
            'percentage_change' => $percentageChange,
            'absolute_change' => $currentTotal - $previousTotal,
        ];
    }
}