@extends('layouts.admin')

@section('page-title', 'User Details: ' . $user->name)

@section('content')
<div class="p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Users
        </a>
    </div>

    <!-- User Header -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-16 bg-gray-300 rounded-full flex items-center justify-center">
                        @if($user->profile_image)
                            <img class="h-16 w-16 rounded-full object-cover" src="{{ Storage::url($user->profile_image) }}" alt="">
                        @else
                            <i class="fas fa-user text-gray-600 text-2xl"></i>
                        @endif
                    </div>
                    <div class="ml-6">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-500">@{{ $user->username }}</p>
                        <p class="text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                
                <!-- Status Badges -->
                <div class="flex flex-col space-y-2">
                    @if($user->is_admin)
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                            <i class="fas fa-shield-alt mr-1"></i>Administrator
                        </span>
                    @endif
                    @if($user->is_suspended)
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            <i class="fas fa-ban mr-1"></i>Suspended
                        </span>
                    @elseif($user->is_active)
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Active
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                            <i class="fas fa-pause-circle mr-1"></i>Inactive
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Actions -->
        <div class="px-6 py-4 bg-gray-50">
            <div class="flex flex-wrap gap-2">
                @if($user->is_active)
                    <form method="POST" action="{{ route('admin.users.status', $user) }}" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="deactivate">
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-pause-circle mr-1"></i>Deactivate
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.users.status', $user) }}" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="activate">
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100">
                            <i class="fas fa-play-circle mr-1"></i>Activate
                        </button>
                    </form>
                @endif

                @if($user->is_suspended)
                    <form method="POST" action="{{ route('admin.users.status', $user) }}" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="unsuspend">
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100">
                            <i class="fas fa-check-circle mr-1"></i>Unsuspend
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.users.status', $user) }}" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="suspend">
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-red-50 hover:bg-red-100">
                            <i class="fas fa-ban mr-1"></i>Suspend
                        </button>
                    </form>
                @endif

                @if(!$user->is_admin && $user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.status', $user) }}" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="make_admin">
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-purple-300 text-sm font-medium rounded-md text-purple-700 bg-purple-50 hover:bg-purple-100">
                            <i class="fas fa-shield-alt mr-1"></i>Make Admin
                        </button>
                    </form>
                @elseif($user->is_admin && $user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.status', $user) }}" class="inline">
                        @csrf
                        <input type="hidden" name="action" value="remove_admin">
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-user mr-1"></i>Remove Admin
                        </button>
                    </form>
                @endif

                <a href="{{ route('profile.show', $user->username) }}" 
                   target="_blank"
                   class="inline-flex items-center px-3 py-2 border border-blue-300 text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100">
                    <i class="fas fa-external-link-alt mr-1"></i>View Public Profile
                </a>
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-link text-2xl text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Links</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $user->links->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-mouse-pointer text-2xl text-green-500"></i>
                    </div>
                    <div class="ml-3">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Clicks</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($totalClicks) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-dollar-sign text-2xl text-yellow-500"></i>
                    </div>
                    <div class="ml-3">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                            <dd class="text-lg font-medium text-gray-900">${{ number_format($totalRevenue, 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-eye text-2xl text-purple-500"></i>
                    </div>
                    <div class="ml-3">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Profile Views</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($profileViews) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- User Details -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">User Information</h3>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Username</dt>
                        <dd class="mt-1 text-sm text-gray-900">@{{ $user->username }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>
                    @if($user->display_name)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Display Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->display_name }}</dd>
                    </div>
                    @endif
                    @if($user->bio)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Bio</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->bio }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Joined</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</dd>
                    </div>
                    @if($user->last_login_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->last_login_at->format('F j, Y g:i A') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Admin Notes</h3>
            </div>
            <div class="p-6">
                @if($user->is_suspended && $user->suspended_reason)
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded">
                        <h4 class="text-sm font-medium text-red-800">Suspension Reason</h4>
                        <p class="mt-1 text-sm text-red-700">{{ $user->suspended_reason }}</p>
                        @if($user->suspended_at)
                            <p class="mt-1 text-xs text-red-600">Suspended on {{ $user->suspended_at->format('F j, Y g:i A') }}</p>
                        @endif
                    </div>
                @endif

                @if($user->admin_notes)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700">Notes</h4>
                        <p class="mt-1 text-sm text-gray-600">{{ $user->admin_notes }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                    @csrf
                    <input type="hidden" name="action" value="update_notes">
                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">Add/Update Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Add administrative notes about this user...">{{ $user->admin_notes }}</textarea>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Save Notes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- User's Links -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">User's Links ({{ $user->links->count() }})</h3>
        </div>
        @if($user->links->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Link</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clicks</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($user->links as $link)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900 max-w-xs truncate">{{ $link->title }}</div>
                                    <div class="text-xs text-gray-500 max-w-xs truncate">{{ $link->url }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($link->is_active)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($link->clicks ?? 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($link->total_revenue ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.links.show', $link) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    View
                                </a>
                                <a href="{{ $link->url }}" target="_blank" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-link text-4xl mb-2"></i>
                <p>This user hasn't created any links yet.</p>
            </div>
        @endif
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Clicks -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Link Clicks</h3>
            </div>
            @if($recentClicks->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($recentClicks as $click)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate">{{ $click->link->title ?? 'Unknown Link' }}</div>
                                <div class="text-sm text-gray-500">{{ $click->country_name ?? 'Unknown' }} • {{ $click->device_type ?? 'Unknown' }}</div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $click->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-gray-500">No recent clicks</div>
            @endif
        </div>

        <!-- Recent Profile Views -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Profile Views</h3>
            </div>
            @if($recentViews->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($recentViews as $view)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="text-sm text-gray-900">{{ $view->country_name ?? 'Unknown Country' }}</div>
                                <div class="text-sm text-gray-500">{{ $view->device_type ?? 'Unknown' }} • {{ $view->browser_name ?? 'Unknown' }}</div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $view->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-gray-500">No recent profile views</div>
            @endif
        </div>
    </div>
</div>
@endsection
