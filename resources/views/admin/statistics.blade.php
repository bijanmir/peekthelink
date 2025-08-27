@extends('layouts.admin')

@section('page-title', 'Statistics & Analytics')

@section('content')
<div class="p-6">
    <!-- Time Period Selector -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-medium text-gray-900">Platform Analytics</h3>
                <div class="mt-4 sm:mt-0">
                    <form method="GET" class="inline-flex">
                        <select name="period" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="7" {{ $period == '7' ? 'selected' : '' }}>Last 7 days</option>
                            <option value="30" {{ $period == '30' ? 'selected' : '' }}>Last 30 days</option>
                            <option value="90" {{ $period == '90' ? 'selected' : '' }}>Last 90 days</option>
                            <option value="365" {{ $period == '365' ? 'selected' : '' }}>Last year</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-users text-3xl text-blue-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total_users']) }}</dd>
                        </dl>
                        <div class="text-sm text-green-600 font-medium">
                            +{{ number_format($periodStats['new_users']) }} this period
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-link text-3xl text-green-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Links</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total_links']) }}</dd>
                        </dl>
                        <div class="text-sm text-green-600 font-medium">
                            +{{ number_format($periodStats['new_links']) }} this period
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-mouse-pointer text-3xl text-purple-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Clicks</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total_clicks']) }}</dd>
                        </dl>
                        <div class="text-sm text-green-600 font-medium">
                            +{{ number_format($periodStats['period_clicks']) }} this period
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-dollar-sign text-3xl text-yellow-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                            <dd class="text-lg font-medium text-gray-900">${{ number_format($stats['total_revenue'], 2) }}</dd>
                        </dl>
                        <div class="text-sm text-green-600 font-medium">
                            +${{ number_format($periodStats['period_revenue'], 2) }} this period
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">User Activity</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Active Users</span>
                        <span class="text-sm font-medium">{{ number_format($stats['active_users']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Profile Views</span>
                        <span class="text-sm font-medium">{{ number_format($stats['total_profile_views']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Views This Period</span>
                        <span class="text-sm font-medium">{{ number_format($periodStats['period_views']) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Content Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Active Links</span>
                        <span class="text-sm font-medium">{{ number_format($stats['active_links']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Avg Links/User</span>
                        <span class="text-sm font-medium">
                            {{ $stats['total_users'] > 0 ? number_format($stats['total_links'] / $stats['total_users'], 1) : '0' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Avg Clicks/Link</span>
                        <span class="text-sm font-medium">
                            {{ $stats['total_links'] > 0 ? number_format($stats['total_clicks'] / $stats['total_links'], 1) : '0' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Revenue Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Conversions</span>
                        <span class="text-sm font-medium">{{ number_format($stats['total_conversions']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Revenue/User</span>
                        <span class="text-sm font-medium">
                            ${{ $stats['total_users'] > 0 ? number_format($stats['total_revenue'] / $stats['total_users'], 2) : '0.00' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Revenue/Click</span>
                        <span class="text-sm font-medium">
                            ${{ $stats['total_clicks'] > 0 ? number_format($stats['total_revenue'] / $stats['total_clicks'], 4) : '0.0000' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Growth Chart Placeholder -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Growth Over Time</h3>
            </div>
            <div class="p-6">
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-chart-line text-4xl mb-4"></i>
                    <p>Chart visualization would be displayed here</p>
                    <p class="text-sm mt-2">Integration with Chart.js or similar library needed</p>
                </div>
            </div>
        </div>

        <!-- Activity Heatmap Placeholder -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Activity Distribution</h3>
            </div>
            <div class="p-6">
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-chart-bar text-4xl mb-4"></i>
                    <p>Activity distribution chart would be displayed here</p>
                    <p class="text-sm mt-2">Shows clicks and views by time of day</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Users -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Top Performing Users</h3>
            </div>
            <div class="overflow-hidden">
                @if($topUsers->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clicks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($topUsers->take(5) as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">@{{ $user->username }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($user->total_clicks ?? 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($user->total_revenue ?? 0, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-6 text-gray-500">No data available</div>
                @endif
            </div>
        </div>

        <!-- Top Links -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Top Performing Links</h3>
            </div>
            <div class="overflow-hidden">
                @if($topLinks->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Link</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clicks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($topLinks->take(5) as $link)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <div class="text-sm font-medium text-gray-900 max-w-xs truncate">{{ $link->title }}</div>
                                        <div class="text-sm text-gray-500">by @{{ $link->user->username ?? 'unknown' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($link->clicks ?? 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($link->total_revenue ?? 0, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-6 text-gray-500">No data available</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="mt-8 bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Data Export</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <a href="{{ route('admin.export') }}?type=users" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-users mr-2"></i>
                    Export Users
                </a>
                
                <a href="{{ route('admin.export') }}?type=links" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-link mr-2"></i>
                    Export Links
                </a>
                
                <a href="{{ route('admin.export') }}?type=clicks" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-mouse-pointer mr-2"></i>
                    Export Clicks
                </a>
                
                <a href="{{ route('admin.export') }}?type=conversions" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-chart-line mr-2"></i>
                    Export Conversions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
