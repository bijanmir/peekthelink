@extends('layouts.app')

@section('content')
<style>
    * { 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
    }
    
    /* Glass card effects */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    }
    
    /* Link item animations */
    .link-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: move;
    }
    
    .link-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .link-item.dragging {
        opacity: 0.5;
        transform: rotate(5deg);
    }
    
    /* Badge styles */
    .revenue-badge {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .performance-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    /* Animation keyframes */
    @keyframes slideUp {
        from { 
            transform: translateY(30px); 
            opacity: 0; 
        }
        to { 
            transform: translateY(0); 
            opacity: 1; 
        }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    /* Animation classes */
    .slide-up { 
        animation: slideUp 0.8s ease-out forwards; 
    }
    
    .live-indicator { 
        animation: pulse 2s infinite; 
    }
    
    /* Tooltip effects */
    .tooltip {
        position: relative;
    }
    
    .tooltip:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        background: #1f2937;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 20;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Metric card hover effects */
    .metric-card {
        transition: all 0.3s ease;
    }
    
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    /* Button hover effects */
    .quick-action-btn {
        transition: all 0.2s ease;
    }
    
    .quick-action-btn:hover {
        transform: scale(1.05);
    }
    
    /* Filter dropdown */
    .search-container {
        position: relative;
    }
    
    .filter-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        z-index: 10;
        display: none;
    }
    
    .filter-dropdown.show {
        display: block;
    }
    
    /* Sortable.js drag states */
    .sortable-ghost {
        opacity: 0.3;
        background: #e5e7eb;
    }
    
    .sortable-chosen {
        transform: rotate(2deg);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    
    .sortable-drag {
        transform: rotate(2deg);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        z-index: 1000;
    }
    
    .dragging {
        opacity: 0.8;
        transform: rotate(2deg);
        z-index: 1000;
    }
    
    /* Background gradient */
    .page-gradient {
        background: 
            radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.03) 0%, transparent 50%),
            linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        min-height: 100vh;
    }
    
    /* Staggered animation delays */
    .slide-up:nth-child(1) { animation-delay: 0.1s; }
    .slide-up:nth-child(2) { animation-delay: 0.2s; }
    .slide-up:nth-child(3) { animation-delay: 0.3s; }
    .slide-up:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="page-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="slide-up mb-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
                <div>
                    <h1 class="font-black text-3xl text-gray-900 leading-tight flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        Link Management Hub
                    </h1>
                    <p class="text-gray-600 mt-2 ml-14">Create, organize, and track your LinkBio performance</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('profile.show', Auth::user()->username) }}" 
                       target="_blank"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-5 rounded-xl transition duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                        </svg>
                        Preview Profile
                    </a>
                    <a href="{{ route('links.create') }}" 
                       class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-5 rounded-xl transition duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Link
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-xl p-4 mb-6 flex items-center slide-up shadow-lg">
                <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-emerald-800 font-semibold">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-600 hover:text-emerald-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Stats Dashboard -->
        @if($links->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                <!-- Total Links -->
                <div class="metric-card glass-card rounded-2xl p-6 border border-blue-200 slide-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <p class="text-3xl font-black text-gray-900 mb-1">{{ $links->count() }}</p>
                            <p class="text-sm text-gray-600 font-medium">Total Links</p>
                        </div>
                    </div>
                </div>

                <!-- Active Links -->
                <div class="metric-card glass-card rounded-2xl p-6 border border-emerald-200 slide-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-3xl font-black text-gray-900 mb-1">{{ $links->where('is_active', true)->count() }}</p>
                            <p class="text-sm text-gray-600 font-medium">Active Links</p>
                        </div>
                        <div class="text-right">
                            <div class="live-indicator w-3 h-3 bg-emerald-500 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Total Clicks -->
                <div class="metric-card glass-card rounded-2xl p-6 border border-purple-200 slide-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                </svg>
                            </div>
                            <p class="text-3xl font-black text-gray-900 mb-1">{{ number_format($links->sum('clicks')) }}</p>
                            <p class="text-sm text-gray-600 font-medium">Total Clicks</p>
                        </div>
                    </div>
                </div>

                <!-- Average Performance -->
                <div class="metric-card glass-card rounded-2xl p-6 border border-orange-200 slide-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <p class="text-3xl font-black text-gray-900 mb-1">
                                {{ $links->count() > 0 ? number_format($links->sum('clicks') / $links->count(), 1) : '0' }}
                            </p>
                            <p class="text-sm text-gray-600 font-medium">Avg Clicks/Link</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Search and Filter Bar -->
        @if($links->count() > 0)
            <div class="glass-card rounded-2xl p-4 sm:p-6 mb-8 border border-white/20 slide-up">
                <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                        <div class="search-container">
                            <div class="relative">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" id="search-links" placeholder="Search links..." 
                                       class="pl-8 sm:pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base w-full sm:w-auto">
                            </div>
                        </div>
                        
                        <div class="relative">
                            <button id="filter-btn" class="flex items-center justify-center space-x-2 px-3 sm:px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors w-full sm:w-auto">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                                </svg>
                                <span class="text-sm font-medium">Filter</span>
                            </button>
                            <div id="filter-dropdown" class="filter-dropdown bg-white rounded-lg shadow-lg border border-gray-200 mt-2 py-2 w-48">
                                <button class="filter-option w-full text-left px-4 py-2 hover:bg-gray-100 text-sm" data-filter="all">All Links</button>
                                <button class="filter-option w-full text-left px-4 py-2 hover:bg-gray-100 text-sm" data-filter="active">Active Only</button>
                                <button class="filter-option w-full text-left px-4 py-2 hover:bg-gray-100 text-sm" data-filter="inactive">Inactive Only</button>
                                <button class="filter-option w-full text-left px-4 py-2 hover:bg-gray-100 text-sm" data-filter="high-performance">High Performance</button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end space-x-3">
                        <span class="text-sm text-gray-600">{{ $links->count() }} {{ Str::plural('link', $links->count()) }} total</span>
                        <button id="sort-btn" class="flex items-center space-x-2 px-3 sm:px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                            </svg>
                            <span class="text-sm font-medium">Sort</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Links Management -->
        <div class="glass-card rounded-2xl shadow-xl border border-white/20 slide-up">
            <div class="p-6 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 flex items-center">
                            <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                            Your Links
                        </h3>
                        <p class="text-gray-600 mt-1">
                            @if($links->count() > 0)
                                Drag to reorder • Click to edit • Monitor performance
                            @else
                                Start building your LinkBio by adding your first link
                            @endif
                        </p>
                    </div>
                    @if($links->count() > 0)
                        <div class="flex items-center space-x-3">
                            <button id="bulk-actions-btn" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                                Bulk Actions
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-6">
                @if($links->count() > 0)
                    <div id="links-container" class="space-y-4">
                        @foreach($links as $link)
                            <div class="link-item bg-white hover:bg-gray-50 border-2 border-gray-200 hover:border-blue-300 rounded-2xl p-6 transition-all duration-300 cursor-move shadow-sm hover:shadow-lg" 
                                 data-id="{{ $link->id }}" 
                                 data-active="{{ $link->is_active ? 'true' : 'false' }}"
                                 data-clicks="{{ $link->clicks }}"
                                 data-title="{{ strtolower($link->title) }}">
                                
                                <!-- Mobile Layout -->
                                <div class="sm:hidden">
                                    <div class="flex items-start justify-between mb-4">
                                        <!-- Mobile Header Row -->
                                        <div class="flex items-center space-x-4 flex-1 min-w-0">
                                            <!-- Drag Handle -->
                                            <div class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                                </svg>
                                            </div>

                                            <!-- Link Icon -->
                                            <div class="relative">
                                                <div class="w-14 h-14 bg-gradient-to-br {{ $link->is_active ? 'from-emerald-400 to-emerald-600' : 'from-gray-400 to-gray-600' }} rounded-2xl flex items-center justify-center shadow-lg">
                                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                    </svg>
                                                </div>
                                                @if($link->clicks > 100)
                                                    <div class="absolute -top-2 -right-2 performance-badge text-xs font-bold text-white px-2 py-1 rounded-full">
                                                        Hot
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Title and Status -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-bold text-xl text-gray-900 truncate mb-2">{{ $link->title }}</h3>
                                                <div class="flex items-center space-x-2">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $link->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                                        <div class="w-2 h-2 rounded-full {{ $link->is_active ? 'bg-emerald-500' : 'bg-red-500' }} mr-2"></div>
                                                        {{ $link->is_active ? 'Live' : 'Paused' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mobile Menu Button -->
                                        <div class="relative">
                                            <button class="mobile-menu-btn quick-action-btn bg-gray-100 hover:bg-gray-200 text-gray-700 p-3 rounded-xl transition duration-200 shadow-sm"
                                                    onclick="toggleMobileMenu({{ $link->id }})"
                                                    title="More Options">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"></path>
                                                </svg>
                                            </button>
                                            
                                            <!-- Mobile Dropdown Menu -->
                                            <div id="mobile-menu-{{ $link->id }}" class="mobile-menu absolute right-0 top-full mt-2 bg-white rounded-xl shadow-xl border border-gray-200 py-3 w-64 z-20 hidden">
                                                <a href="{{ route('profile.show', Auth::user()->username) }}/link/{{ $link->id }}" 
                                                   target="_blank"
                                                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                                    </svg>
                                                    Test Link
                                                </a>
                                                
                                                <form method="POST" action="{{ route('links.destroy', $link) }}" class="border-t border-gray-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Are you sure you want to delete &quot;{{ $link->title }}&quot;? This action cannot be undone.')"
                                                            class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Delete Link
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mobile Content Section -->
                                    <div class="space-y-4">
                                        <!-- URL Section -->
                                        <div class="bg-gray-50 rounded-xl p-4">
                                            <p class="text-sm text-gray-600 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                                </svg>
                                                <span class="truncate">{{ $link->url }}</span>
                                            </p>
                                            @if($link->description)
                                                <p class="text-sm text-gray-500 mt-2">{{ $link->description }}</p>
                                            @endif
                                        </div>

                                        <!-- Mobile Stats and Actions Row -->
                                        <div class="flex items-center justify-between">
                                            <!-- Clicks Metric -->
                                            <div class="bg-blue-50 rounded-xl px-4 py-3 flex-1 mr-3">
                                                <p class="text-3xl font-black text-blue-600">{{ number_format($link->clicks) }}</p>
                                                <p class="text-sm text-blue-600 font-medium">clicks</p>
                                            </div>

                                            <!-- Quick Actions -->
                                            <div class="flex items-center space-x-2">
                                                <!-- Edit Link -->
                                                <a href="{{ route('links.edit', $link) }}" 
                                                   class="quick-action-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-xl transition duration-200 shadow-lg">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                
                                                <!-- Toggle Status -->
                                                <form method="POST" action="{{ route('links.update', $link) }}" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="title" value="{{ $link->title }}">
                                                    <input type="hidden" name="url" value="{{ $link->url }}">
                                                    <input type="hidden" name="description" value="{{ $link->description }}">
                                                    <input type="hidden" name="is_active" value="{{ $link->is_active ? '0' : '1' }}">
                                                    <button type="submit" 
                                                            class="quick-action-btn p-3 rounded-xl transition duration-200 text-white shadow-lg {{ $link->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                                                        @if($link->is_active)
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M15 14h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desktop Layout -->
                                <div class="hidden sm:flex items-center justify-between">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <!-- Drag Handle -->
                                        <div class="mr-5 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                            </svg>
                                        </div>

                                        <!-- Link Icon -->
                                        <div class="relative mr-5">
                                            <div class="w-14 h-14 bg-gradient-to-br {{ $link->is_active ? 'from-emerald-400 to-emerald-600' : 'from-gray-400 to-gray-600' }} rounded-2xl flex items-center justify-center shadow-lg">
                                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                </svg>
                                            </div>
                                            @if($link->clicks > 100)
                                                <div class="absolute -top-2 -right-2 performance-badge text-xs font-bold text-white px-2 py-1 rounded-full">
                                                    Hot
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Link Content -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-3 mb-3">
                                                <h3 class="font-bold text-xl text-gray-900 truncate">{{ $link->title }}</h3>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $link->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                                    <div class="w-2 h-2 rounded-full {{ $link->is_active ? 'bg-emerald-500' : 'bg-red-500' }} mr-2"></div>
                                                    {{ $link->is_active ? 'Live' : 'Paused' }}
                                                </span>
                                                @if($link->clicks > 100)
                                                    <span class="performance-badge text-xs font-bold text-white px-2 py-1 rounded-full">
                                                        High Performer
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                                    </svg>
                                                    <span class="truncate">{{ $link->url }}</span>
                                                </p>
                                                @if($link->description)
                                                    <p class="text-sm text-gray-500 truncate">{{ $link->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Performance Metrics -->
                                    <div class="flex items-center space-x-6 ml-6">
                                        <!-- Clicks Metric -->
                                        <div class="text-center">
                                            <p class="text-3xl font-black text-gray-900">{{ number_format($link->clicks) }}</p>
                                            <p class="text-xs text-gray-500 font-medium">clicks</p>
                                        </div>

                                        <!-- Quick Actions -->
                                        <div class="flex items-center space-x-2">
                                            <!-- Test Link -->
                                            <a href="{{ route('profile.show', Auth::user()->username) }}/link/{{ $link->id }}" 
                                               target="_blank"
                                               class="quick-action-btn bg-gray-600 hover:bg-gray-700 text-white p-3 rounded-xl transition duration-200 tooltip shadow-lg"
                                               title="Test Link">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                                </svg>
                                            </a>

                                            <!-- Edit Link -->
                                            <a href="{{ route('links.edit', $link) }}" 
                                               class="quick-action-btn bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-xl transition duration-200 tooltip shadow-lg"
                                               title="Edit Link">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            
                                            <!-- Toggle Status -->
                                            <form method="POST" action="{{ route('links.update', $link) }}" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="title" value="{{ $link->title }}">
                                                <input type="hidden" name="url" value="{{ $link->url }}">
                                                <input type="hidden" name="description" value="{{ $link->description }}">
                                                <input type="hidden" name="is_active" value="{{ $link->is_active ? '0' : '1' }}">
                                                <button type="submit" 
                                                        class="quick-action-btn p-3 rounded-xl transition duration-200 tooltip text-white shadow-lg {{ $link->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-emerald-600 hover:bg-emerald-700' }}"
                                                        title="{{ $link->is_active ? 'Pause' : 'Activate' }} Link">
                                                    @if($link->is_active)
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M15 14h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>

                                            <!-- Delete Link -->
                                            <form method="POST" action="{{ route('links.destroy', $link) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete &quot;{{ $link->title }}&quot;? This action cannot be undone.')"
                                                        class="quick-action-btn bg-red-600 hover:bg-red-700 text-white p-3 rounded-xl transition duration-200 tooltip shadow-lg"
                                                        title="Delete Link">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-20">
                        <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full mx-auto mb-8 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-4">Ready to build your LinkBio?</h3>
                        <p class="text-gray-600 mb-8 max-w-lg mx-auto text-lg">
                            Create your first link to start building your professional LinkBio. Add links to your social media, website, portfolio, products, or anything you want to share with your audience!
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('links.create') }}" 
                               class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Your First Link
                            </a>
                            <a href="{{ route('profile.show', Auth::user()->username) }}" 
                               target="_blank"
                               class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-8 rounded-xl transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                </svg>
                                Preview Your Profile
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Include Sortable.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

<script>
    // Ensure CSRF token is available
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.head.appendChild(meta);
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded - Initializing features');
        
        // Initialize all features
        initializeDragAndDrop();
        initializeSearch();
        initializeFilters();
        initializeSort();
    });

    function initializeDragAndDrop() {
        const linksContainer = document.getElementById('links-container');
        if (!linksContainer) {
            console.log('Links container not found');
            return;
        }

        console.log('Initializing Sortable on container:', linksContainer);
        
        try {
            const sortable = Sortable.create(linksContainer, {
                animation: 200,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                handle: '.link-item',
                onStart: function(evt) {
                    console.log('Drag started');
                    evt.item.classList.add('dragging');
                    evt.item.style.transform = 'rotate(2deg)';
                    evt.item.style.zIndex = '1000';
                },
                onEnd: function(evt) {
                    console.log('Drag ended');
                    evt.item.classList.remove('dragging');
                    evt.item.style.transform = '';
                    evt.item.style.zIndex = '';
                    
                    // Get the new order of link IDs
                    const newOrder = Array.from(linksContainer.children).map((item, index) => ({
                        id: item.getAttribute('data-id'),
                        order: index + 1
                    }));
                    
                    console.log('New order:', newOrder);
                    
                    // Send AJAX request to update order
                    updateLinkOrder(newOrder);
                    
                    // Show feedback
                    showOrderUpdateFeedback();
                }
            });
            
            console.log('Sortable initialized successfully:', sortable);
        } catch (error) {
            console.error('Error initializing Sortable:', error);
        }
    }

    function initializeSearch() {
        const searchInput = document.getElementById('search-links');
        const linkItems = document.querySelectorAll('.link-item');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                linkItems.forEach(item => {
                    const title = item.getAttribute('data-title');
                    if (title && title.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    }

    function initializeFilters() {
        const filterBtn = document.getElementById('filter-btn');
        const filterDropdown = document.getElementById('filter-dropdown');
        const filterOptions = document.querySelectorAll('.filter-option');
        const linkItems = document.querySelectorAll('.link-item');

        if (filterBtn && filterDropdown) {
            filterBtn.addEventListener('click', function() {
                filterDropdown.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
                    filterDropdown.classList.remove('show');
                }
            });
        }

        if (filterOptions.length > 0) {
            filterOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    
                    linkItems.forEach(item => {
                        const isActive = item.getAttribute('data-active') === 'true';
                        const clicks = parseInt(item.getAttribute('data-clicks'));
                        
                        let show = true;
                        
                        switch (filter) {
                            case 'active':
                                show = isActive;
                                break;
                            case 'inactive':
                                show = !isActive;
                                break;
                            case 'high-performance':
                                show = clicks > 50;
                                break;
                            case 'all':
                            default:
                                show = true;
                                break;
                        }
                        
                        item.style.display = show ? 'block' : 'none';
                    });
                    
                    filterDropdown.classList.remove('show');
                });
            });
        }
    }

    function initializeSort() {
        const sortBtn = document.getElementById('sort-btn');
        const linksContainer = document.getElementById('links-container');
        const linkItems = document.querySelectorAll('.link-item');
        let sortOrder = 'default';

        if (sortBtn && linksContainer) {
            sortBtn.addEventListener('click', function() {
                const links = Array.from(linkItems);
                
                switch (sortOrder) {
                    case 'default':
                        // Sort by clicks (descending)
                        links.sort((a, b) => {
                            const clicksA = parseInt(a.getAttribute('data-clicks'));
                            const clicksB = parseInt(b.getAttribute('data-clicks'));
                            return clicksB - clicksA;
                        });
                        sortOrder = 'clicks';
                        sortBtn.querySelector('span').textContent = 'By Clicks';
                        break;
                    case 'clicks':
                        // Sort alphabetically
                        links.sort((a, b) => {
                            const titleA = a.getAttribute('data-title');
                            const titleB = b.getAttribute('data-title');
                            return titleA.localeCompare(titleB);
                        });
                        sortOrder = 'alphabetical';
                        sortBtn.querySelector('span').textContent = 'A-Z';
                        break;
                    case 'alphabetical':
                        // Sort by status (active first)
                        links.sort((a, b) => {
                            const activeA = a.getAttribute('data-active') === 'true';
                            const activeB = b.getAttribute('data-active') === 'true';
                            return activeB - activeA;
                        });
                        sortOrder = 'status';
                        sortBtn.querySelector('span').textContent = 'By Status';
                        break;
                    case 'status':
                    default:
                        // Reset to default order
                        location.reload();
                        return;
                }
                
                // Clear container and re-add sorted elements
                linksContainer.innerHTML = '';
                links.forEach(link => {
                    linksContainer.appendChild(link);
                });
            });
        }
    }

    // Function to update link order via AJAX
    function updateLinkOrder(orderData) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        console.log('Sending order update:', orderData);

        fetch('/links/update-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
            },
            body: JSON.stringify({
                order: orderData
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                console.log('Link order updated successfully');
            } else {
                console.error('Failed to update link order:', data.message);
            }
        })
        .catch(error => {
            console.error('Error updating link order:', error);
        });
    }

    // Show visual feedback when order is updated
    function showOrderUpdateFeedback() {
        // Create temporary notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transform transition-all duration-300';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Link order updated!
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateY(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    // Mobile menu functionality
    function toggleMobileMenu(linkId) {
        const menu = document.getElementById(`mobile-menu-${linkId}`);
        const allMenus = document.querySelectorAll('.mobile-menu');
        
        // Close all other menus
        allMenus.forEach(m => {
            if (m !== menu) {
                m.classList.add('hidden');
            }
        });
        
        // Toggle current menu
        menu.classList.toggle('hidden');
    }

    // Close mobile menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.mobile-menu-btn') && !e.target.closest('.mobile-menu')) {
            document.querySelectorAll('.mobile-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>
@endsection