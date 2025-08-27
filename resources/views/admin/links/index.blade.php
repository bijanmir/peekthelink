@extends('layouts.admin')

@section('page-title', 'Links Management')

@section('content')
<div class="p-6">
    <!-- Header with search and filters -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-medium text-gray-900">All Links</h3>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('admin.export') }}?type=links" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-download mr-2"></i>
                        Export Links
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
                           placeholder="Search links by title, URL, or user..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div class="flex gap-2">
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    
                    <select name="type" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="all">All Types</option>
                        <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="affiliate" {{ request('type') == 'affiliate' ? 'selected' : '' }}>Affiliate</option>
                        <option value="sponsored" {{ request('type') == 'sponsored' ? 'selected' : '' }}>Sponsored</option>
                        <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Product</option>
                    </select>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                    
                    <a href="{{ route('admin.links') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Links Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($links as $link)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-gray-900 max-w-xs truncate">
                                    {{ $link->title }}
                                </div>
                                <div class="text-xs text-gray-500 max-w-xs truncate">
                                    {{ $link->url }}
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $link->user->name ?? 'Unknown' }}</div>
                                    <div class="text-sm text-gray-500">@ {{ $link->user->username ?? 'unknown' }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $typeColors = [
                                    'affiliate' => 'bg-blue-100 text-blue-800',
                                    'sponsored' => 'bg-yellow-100 text-yellow-800',
                                    'product' => 'bg-green-100 text-green-800',
                                    'standard' => 'bg-gray-100 text-gray-800'
                                ];
                                $type = $link->link_type ?? 'standard';
                                $color = $typeColors[$type] ?? $typeColors['standard'];
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($type) }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($link->is_active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Active
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-pause-circle mr-1"></i>Inactive
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="text-sm font-medium">{{ number_format($link->clicks ?? 0) }} clicks</div>
                            <div class="text-xs text-gray-500">{{ number_format($link->conversions ?? 0) }} conversions</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="text-sm font-medium">${{ number_format($link->total_revenue ?? 0, 2) }}</div>
                            @if($link->conversion_rate)
                                <div class="text-xs text-gray-500">{{ number_format($link->conversion_rate, 2) }}% rate</div>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $link->created_at->format('M j, Y') }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ $link->url }}" 
                                   target="_blank"
                                   class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                
                                <a href="{{ route('admin.links.show', $link) }}" 
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
                                            @if($link->is_active)
                                                <form method="POST" action="{{ route('admin.links.status', $link) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="deactivate">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-pause-circle mr-2"></i>Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.links.status', $link) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="activate">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="fas fa-play-circle mr-2"></i>Activate
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('admin.links.status', $link) }}">
                                                @csrf
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this link?')"
                                                        class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                                    <i class="fas fa-trash mr-2"></i>Delete
                                                </button>
                                            </form>
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
        @if($links->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $links->links() }}
        </div>
        @endif
    </div>
    
    @if($links->count() === 0)
    <div class="text-center py-12">
        <i class="fas fa-link text-gray-400 text-6xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No links found</h3>
        <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
    </div>
    @endif
</div>
@endsection
