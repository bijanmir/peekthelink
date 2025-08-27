<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link;
use App\Models\LinkClick;
use App\Models\ProfileView;
use App\Models\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the main admin dashboard
     */
    public function index()
    {
        $stats = $this->getOverallStats();
        $recentUsers = User::latest()->take(10)->get();
        $recentLinks = Link::with('user')->latest()->take(10)->get();
        $topUsers = $this->getTopUsers();
        
        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentLinks', 'topUsers'));
    }

    /**
     * Display all users with pagination and filtering
     */
    public function users(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhere('username', 'ILIKE', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->status === 'suspended') {
                $query->where('is_suspended', true);
            }
        }
        
        $users = $query->withCount(['links', 'links as active_links_count' => function($q) {
            $q->where('is_active', true);
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(25);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display specific user details
     */
    public function userShow(User $user)
    {
        $user->load(['links' => function($q) {
            $q->orderBy('order');
        }]);
        
        // Get user statistics
        $totalClicks = $user->links()->sum('clicks');
        $totalRevenue = $user->links()->sum('total_revenue');
        $totalConversions = Conversion::where('user_id', $user->id)->confirmed()->count();
        $profileViews = ProfileView::where('user_id', $user->id)->count();
        
        // Get recent activity
        $recentClicks = LinkClick::whereHas('link', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('link')->latest()->take(10)->get();
        
        $recentViews = ProfileView::where('user_id', $user->id)
                                 ->latest()->take(10)->get();
        
        return view('admin.users.show', compact(
            'user', 'totalClicks', 'totalRevenue', 'totalConversions', 
            'profileViews', 'recentClicks', 'recentViews'
        ));
    }

    /**
     * Update user status (activate/deactivate/suspend)
     */
    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,suspend,unsuspend,make_admin,remove_admin'
        ]);
        
        switch ($request->action) {
            case 'activate':
                $user->update(['is_active' => true]);
                $message = 'User activated successfully';
                break;
            case 'deactivate':
                $user->update(['is_active' => false]);
                $message = 'User deactivated successfully';
                break;
            case 'suspend':
                $user->update([
                    'is_suspended' => true,
                    'suspended_at' => now(),
                    'suspended_reason' => $request->reason ?? 'Suspended by admin'
                ]);
                $message = 'User suspended successfully';
                break;
            case 'unsuspend':
                $user->update([
                    'is_suspended' => false,
                    'suspended_at' => null,
                    'suspended_reason' => null
                ]);
                $message = 'User unsuspended successfully';
                break;
            case 'make_admin':
                $user->update(['is_admin' => true]);
                $message = 'User promoted to admin successfully';
                break;
            case 'remove_admin':
                $user->update(['is_admin' => false]);
                $message = 'Admin privileges removed successfully';
                break;
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Display all links with pagination and filtering
     */
    public function links(Request $request)
    {
        $query = Link::with('user');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                  ->orWhere('url', 'ILIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('username', 'ILIKE', "%{$search}%")
                               ->orWhere('name', 'ILIKE', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        // Filter by link type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('link_type', $request->type);
        }
        
        $links = $query->orderBy('created_at', 'desc')
                      ->paginate(25);
        
        return view('admin.links.index', compact('links'));
    }

    /**
     * Display link details
     */
    public function linkShow(Link $link)
    {
        $link->load(['user', 'clicks' => function($q) {
            $q->latest()->take(20);
        }, 'conversions' => function($q) {
            $q->latest()->take(10);
        }]);
        
        // Get performance stats
        $stats = $link->getPerformanceSummary(30);
        
        return view('admin.links.show', compact('link', 'stats'));
    }

    /**
     * Update link status
     */
    public function updateLinkStatus(Request $request, Link $link)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete'
        ]);
        
        switch ($request->action) {
            case 'activate':
                $link->update(['is_active' => true]);
                $message = 'Link activated successfully';
                break;
            case 'deactivate':
                $link->update(['is_active' => false]);
                $message = 'Link deactivated successfully';
                break;
            case 'delete':
                $link->delete();
                return redirect()->route('admin.links')->with('success', 'Link deleted successfully');
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Display comprehensive statistics
     */
    public function statistics(Request $request)
    {
        $period = $request->get('period', '30'); // days
        $startDate = Carbon::now()->subDays($period);
        
        // Overall stats
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_links' => Link::count(),
            'active_links' => Link::where('is_active', true)->count(),
            'total_clicks' => LinkClick::count(),
            'total_revenue' => Conversion::confirmed()->sum('commission_amount') ?: 0,
            'total_conversions' => Conversion::confirmed()->count(),
            'total_profile_views' => ProfileView::count(),
        ];
        
        // Period stats
        $periodStats = [
            'new_users' => User::where('created_at', '>=', $startDate)->count(),
            'new_links' => Link::where('created_at', '>=', $startDate)->count(),
            'period_clicks' => LinkClick::where('created_at', '>=', $startDate)->count(),
            'period_revenue' => Conversion::confirmed()->where('conversion_date', '>=', $startDate)->sum('commission_amount') ?: 0,
            'period_conversions' => Conversion::confirmed()->where('conversion_date', '>=', $startDate)->count(),
            'period_views' => ProfileView::where('created_at', '>=', $startDate)->count(),
        ];
        
        // Growth charts data
        $chartData = $this->getChartData($period);
        
        // Top performers
        $topUsers = $this->getTopUsers($period);
        $topLinks = $this->getTopLinks($period);
        
        return view('admin.statistics', compact(
            'stats', 'periodStats', 'chartData', 'topUsers', 'topLinks', 'period'
        ));
    }

    /**
     * Get overall system statistics
     */
    private function getOverallStats()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'suspended_users' => User::where('is_suspended', true)->count(),
            'total_links' => Link::count(),
            'active_links' => Link::where('is_active', true)->count(),
            'total_clicks' => Link::sum('clicks'),
            'total_conversions' => Conversion::confirmed()->count(),
            'total_revenue' => Conversion::confirmed()->sum('commission_amount'),
            'total_profile_views' => ProfileView::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_links_today' => Link::whereDate('created_at', today())->count(),
            'clicks_today' => LinkClick::whereDate('created_at', today())->count(),
            'revenue_today' => Conversion::confirmed()->whereDate('conversion_date', today())->sum('commission_amount') ?: 0,
        ];
    }

    /**
     * Get top performing users
     */
    private function getTopUsers($days = null)
    {
        // Get users who have links with clicks
        $query = User::whereHas('links', function($q) {
            $q->where('clicks', '>', 0);
        })
        ->with('links')
        ->get()
        ->map(function($user) {
            $user->total_clicks = $user->links->sum('clicks');
            $user->total_revenue = $user->links->sum('total_revenue');
            return $user;
        })
        ->sortByDesc('total_revenue')
        ->sortByDesc('total_clicks')
        ->take(10);
            
        return $query;
    }

    /**
     * Get top performing links
     */
    private function getTopLinks($days = null)
    {
        $query = Link::with('user')
            ->orderBy('total_revenue', 'desc')
            ->orderBy('clicks', 'desc');
            
        if ($days) {
            // For period-based stats, we'd need to join with clicks/conversions tables
            // For now, using overall stats
        }
        
        return $query->take(10)->get();
    }

    /**
     * Get chart data for statistics page
     */
    private function getChartData($days)
    {
        $startDate = Carbon::now()->subDays($days);
        
        // Daily user registrations
        $userGrowth = User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');
            
        // Daily clicks
        $clicksGrowth = LinkClick::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');
            
        // Daily revenue
        $revenueGrowth = Conversion::confirmed()
            ->where('conversion_date', '>=', $startDate)
            ->selectRaw('DATE(conversion_date) as date, SUM(commission_amount) as amount')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('amount', 'date');
        
        return [
            'users' => $userGrowth,
            'clicks' => $clicksGrowth,
            'revenue' => $revenueGrowth,
        ];
    }

    /**
     * Export data to CSV
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'users');
        $filename = $type . '_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response()->stream(function() use ($type) {
            $handle = fopen('php://output', 'w');
            
            switch ($type) {
                case 'users':
                    $this->exportUsers($handle);
                    break;
                case 'links':
                    $this->exportLinks($handle);
                    break;
                case 'clicks':
                    $this->exportClicks($handle);
                    break;
                case 'conversions':
                    $this->exportConversions($handle);
                    break;
            }
            
            fclose($handle);
        }, 200, $headers);
    }

    private function exportUsers($handle)
    {
        fputcsv($handle, ['ID', 'Username', 'Name', 'Email', 'Active', 'Admin', 'Links Count', 'Total Clicks', 'Total Revenue', 'Created At']);
        
        User::withCount('links')
            ->chunk(100, function($users) use ($handle) {
                foreach ($users as $user) {
                    $totalClicks = $user->links()->sum('clicks');
                    $totalRevenue = $user->links()->sum('total_revenue');
                    
                    fputcsv($handle, [
                        $user->id,
                        $user->username,
                        $user->name,
                        $user->email,
                        $user->is_active ? 'Yes' : 'No',
                        $user->is_admin ? 'Yes' : 'No',
                        $user->links_count,
                        $totalClicks,
                        '$' . number_format($totalRevenue, 2),
                        $user->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
    }

    private function exportLinks($handle)
    {
        fputcsv($handle, ['ID', 'User', 'Title', 'URL', 'Type', 'Active', 'Clicks', 'Conversions', 'Revenue', 'Created At']);
        
        Link::with('user')
            ->chunk(100, function($links) use ($handle) {
                foreach ($links as $link) {
                    fputcsv($handle, [
                        $link->id,
                        $link->user->username,
                        $link->title,
                        $link->url,
                        $link->link_type ?? 'standard',
                        $link->is_active ? 'Yes' : 'No',
                        $link->clicks,
                        $link->conversions,
                        '$' . number_format($link->total_revenue ?? 0, 2),
                        $link->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
    }

    private function exportClicks($handle)
    {
        fputcsv($handle, ['ID', 'Link', 'User', 'IP Address', 'Country', 'Device', 'Browser', 'Clicked At']);
        
        LinkClick::with(['link', 'link.user'])
            ->chunk(100, function($clicks) use ($handle) {
                foreach ($clicks as $click) {
                    fputcsv($handle, [
                        $click->id,
                        $click->link->title ?? 'N/A',
                        $click->link->user->username ?? 'N/A',
                        $click->ip_address,
                        $click->country_name ?? 'Unknown',
                        $click->device_type ?? 'Unknown',
                        $click->browser_name ?? 'Unknown',
                        $click->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });
    }

    private function exportConversions($handle)
    {
        fputcsv($handle, ['ID', 'Link', 'User', 'Type', 'Revenue', 'Commission', 'Status', 'Program', 'Converted At']);
        
        Conversion::with(['link', 'user'])
            ->chunk(100, function($conversions) use ($handle) {
                foreach ($conversions as $conversion) {
                    fputcsv($handle, [
                        $conversion->id,
                        $conversion->link->title ?? 'N/A',
                        $conversion->user->username ?? 'N/A',
                        $conversion->conversion_type,
                        '$' . number_format($conversion->revenue_amount ?? 0, 2),
                        '$' . number_format($conversion->commission_amount ?? 0, 2),
                        $conversion->status,
                        $conversion->affiliate_program ?? 'N/A',
                        $conversion->conversion_date->format('Y-m-d H:i:s'),
                    ]);
                }
            });
    }
}
