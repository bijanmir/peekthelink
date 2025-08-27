@extends('layouts.admin')

@section('page-title', 'Users Management')

@section('content')
<div class="p-6">
    <!-- Header with search and filters -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-medium text-gray-900">All Users</h3>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('admin.export') }}?type=users" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-download mr-2"></i>
                        Export Users
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Search and Filters -->
        <div class="px-6 py-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search users by name, email, or username..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div class="flex gap-2">
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="admin" {{ request('status') == 'admin' ? 'selected' : '' }}>Admins</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                    
                    <a href="{{ route('admin.users') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Links</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center">
                                    @if($user->profile_image)
                                        <img class="h-10 w-10 rounded-full" src="{{ Storage::url($user->profile_image) }}" alt="">
                                    @else
                                        <i class="fas fa-user text-gray-600"></i>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">@{{ $user->username }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $user->email }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1">
                                @if($user->is_admin)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        <i class="fas fa-shield-alt mr-1"></i>Admin
                                    </span>
                                @endif
                                @if($user->is_suspended)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-ban mr-1"></i>Suspended
                                    </span>
                                @elseif($user->is_active)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="fas fa-pause-circle mr-1"></i>Inactive
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="text-sm font-medium">{{ $user->links_count }} total</div>
                            <div class="text-xs text-gray-500">{{ $user->active_links_count }} active</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $totalClicks = $user->links()->sum('clicks') ?? 0;
                                $totalRevenue = $user->links()->sum('total_revenue') ?? 0;
                            @endphp
                            <div class="text-sm font-medium">{{ number_format($totalClicks) }} clicks</div>
                            <div class="text-xs text-gray-500">${{ number_format($totalRevenue, 2) }} revenue</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M j, Y') }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                        <div class="py-1">
                                            @if($user->is_active)
                                                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="deactivate">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-pause-circle mr-2"></i>Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="activate">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-play-circle mr-2"></i>Activate
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($user->is_suspended)
                                                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="unsuspend">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-check-circle mr-2"></i>Unsuspend
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="suspend">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                                        <i class="fas fa-ban mr-2"></i>Suspend
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(!$user->is_admin && $user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="make_admin">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-purple-700 hover:bg-gray-100">
                                                        <i class="fas fa-shield-alt mr-2"></i>Make Admin
                                                    </button>
                                                </form>
                                            @elseif($user->is_admin && $user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="remove_admin">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-user mr-2"></i>Remove Admin
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
    
    @if($users->count() === 0)
    <div class="text-center py-12">
        <i class="fas fa-users text-gray-400 text-6xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
        <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
    </div>
    @endif
</div>
@endsection
