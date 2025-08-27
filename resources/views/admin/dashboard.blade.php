@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="p-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
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
                        <div class="text-sm text-gray-500">
                            {{ number_format($stats['active_users']) }} active
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Links -->
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
                        <div class="text-sm text-gray-500">
                            {{ number_format($stats['active_links']) }} active
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Clicks -->
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
                        <div class="text-sm text-gray-500">
                            {{ number_format($stats['clicks_today']) }} today
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
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
                        <div class="text-sm text-gray-500">
                            ${{ number_format($stats['revenue_today'], 2) }} today
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">User Stats</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Admin Users</span>
                        <span class="text-sm font-medium">{{ number_format($stats['admin_users']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Suspended</span>
                        <span class="text-sm font-medium">{{ number_format($stats['suspended_users']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">New Today</span>
                        <span class="text-sm font-medium">{{ number_format($stats['new_users_today']) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Content Stats</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Profile Views</span>
                        <span class="text-sm font-medium">{{ number_format($stats['total_profile_views']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Conversions</span>
                        <span class="text-sm font-medium">{{ number_format($stats['total_conversions']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">New Links Today</span>
                        <span class="text-sm font-medium">{{ number_format($stats['new_links_today']) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.users') }}" class="block w-full text-left px-3 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded">
                        <i class="fas fa-users mr-2"></i> Manage Users
                    </a>
                    <a href="{{ route('admin.links') }}" class="block w-full text-left px-3 py-2 text-sm text-green-600 hover:bg-green-50 rounded">
                        <i class="fas fa-link mr-2"></i> Manage Links
                    </a>
                    <a href="{{ route('admin.statistics') }}" class="block w-full text-left px-3 py-2 text-sm text-purple-600 hover:bg-purple-50 rounded">
                        <i class="fas fa-chart-line mr-2"></i> View Statistics
                    </a>
                    <a href="{{ route('admin.export') }}?type=users" class="block w-full text-left px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded">
                        <i class="fas fa-download mr-2"></i> Export Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Users</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($recentUsers as $user)
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600 text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">@ {{ $user->username }}</div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-3 border-t border-gray-200">
                <a href="{{ route('admin.users') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    View all users →
                </a>
            </div>
        </div>

        <!-- Recent Links -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Links</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($recentLinks as $link)
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate">{{ $link->title }}</div>
                            <div class="text-sm text-gray-500">by @ {{ $link->user->username ?? 'Unknown' }}</div>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $link->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-3 border-t border-gray-200">
                <a href="{{ route('admin.links') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    View all links →
                </a>
            </div>
        </div>
    </div>

    <!-- Top Performers -->
    @if($topUsers->count() > 0)
    <div class="mt-8">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Top Performing Users</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Clicks</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Links</th>
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
                                        <div class="text-sm text-gray-500">@ {{ $user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($user->total_clicks ?? 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($user->total_revenue ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->links->count() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
