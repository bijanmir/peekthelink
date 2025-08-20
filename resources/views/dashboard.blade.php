@extends('layouts.app')

@section('content')
<style>
    * { 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
    }
    
    /* Premium glass card effects */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    }
    
    /* Metric card animations */
    .metric-card {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }
    
    .metric-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.12);
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
    
    @keyframes countUp {
        from { 
            transform: scale(0.8); 
            opacity: 0; 
        }
        to { 
            transform: scale(1); 
            opacity: 1; 
        }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    /* Animation classes */
    .slide-up { 
        animation: slideUp 0.8s ease-out forwards; 
    }
    
    .count-up { 
        animation: countUp 0.8s ease-out forwards; 
    }
    
    .live-indicator {
        animation: pulse 2s infinite;
    }
    
    .floating-element {
        animation: float 6s ease-in-out infinite;
    }
    
    /* Staggered animation delays */
    .slide-up:nth-child(1) { animation-delay: 0.1s; }
    .slide-up:nth-child(2) { animation-delay: 0.2s; }
    .slide-up:nth-child(3) { animation-delay: 0.3s; }
    .slide-up:nth-child(4) { animation-delay: 0.4s; }
    
    /* Dashboard gradient background */
    .dashboard-gradient {
        background: 
            radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.03) 0%, transparent 50%),
            linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        min-height: 100vh;
    }
    
    /* Header gradient */
    .header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    /* Progress ring for metrics */
    .progress-ring {
        transform: rotate(-90deg);
    }
    
    .progress-ring circle {
        transition: stroke-dasharray 1s ease-in-out;
    }
    
    /* Chart container */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    /* Hover effects for buttons */
    .btn-primary {
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }
    
    /* Empty state styling */
    .empty-state {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
</style>

<div class="dashboard-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header Section -->
        <div class="slide-up mb-8">
            <div class="header-gradient rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)" />
                    </svg>
                </div>
                
                <!-- Floating Elements -->
                <div class="absolute top-4 right-4 w-16 h-16 bg-white/10 rounded-full floating-element"></div>
                <div class="absolute bottom-6 left-8 w-8 h-8 bg-white/20 rounded-full floating-element" style="animation-delay: 2s;"></div>
                <div class="absolute top-1/2 right-12 w-4 h-4 bg-white/15 rounded-full live-indicator"></div>
                
                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h1 class="text-4xl font-black tracking-tight">Dashboard Overview</h1>
                            </div>
                            <p class="text-white/90 text-lg leading-relaxed max-w-md mb-6">
                                Track your link performance and manage your PeekTheLink profile
                            </p>
                            
                            <!-- Quick Stats -->
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-emerald-400 rounded-full live-indicator"></div>
                                    <span class="text-sm font-medium text-white/90">Live Tracking</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                                    <span class="text-sm font-medium text-white/90">{{ $activeLinksCount ?? 0 }} Active Links</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                            <a href="{{ route('links.create') }}" 
                               class="btn-primary bg-white/20 hover:bg-white/30 backdrop-blur-md text-white font-semibold py-3 px-6 rounded-xl transition duration-200 flex items-center justify-center border border-white/20">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add New Link
                            </a>
                            <a href="{{ route('profile.show', Auth::user()->username) }}" 
                               target="_blank"
                               class="btn-primary bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition duration-200 flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                </svg>
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <!-- Total Links -->
            <div class="metric-card glass-card rounded-2xl p-6 slide-up">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Links</h3>
                        </div>
                        <div class="count-up text-3xl font-black text-gray-900 mb-2">{{ $totalLinksCount ?? 0 }}</div>
                        <div class="flex items-center">
                            <span class="text-emerald-600 font-semibold text-sm">{{ $activeLinksCount ?? 0 }} active</span>
                            <span class="text-gray-400 mx-2">•</span>
                            <span class="text-gray-500 text-sm">{{ ($totalLinksCount ?? 0) - ($activeLinksCount ?? 0) }} inactive</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Clicks -->
            <div class="metric-card glass-card rounded-2xl p-6 slide-up">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Clicks</h3>
                        </div>
                        <div class="count-up text-3xl font-black text-gray-900 mb-2">{{ number_format($totalClicks ?? 0) }}</div>
                        <div class="flex items-center">
                            <span class="text-emerald-600 font-semibold text-sm">{{ $todayClicks ?? 0 }} today</span>
                            <span class="text-gray-400 mx-2">•</span>
                            <span class="text-gray-500 text-sm">all time</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Views -->
            <div class="metric-card glass-card rounded-2xl p-6 slide-up">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                               <i class="fa fa-eye text-white"></i>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Profile Views</h3>
                        </div>
                        <div class="count-up text-3xl font-black text-gray-900 mb-2">{{ number_format($profileViews ?? 0) }}</div>
                        <div class="flex items-center">
                            <span class="text-{{ ($profileViewsPercentageChange ?? 0) >= 0 ? 'emerald' : 'red' }}-600 font-semibold text-sm">
                                {{ ($profileViewsPercentageChange ?? 0) > 0 ? '+' : '' }}{{ $profileViewsPercentageChange ?? 0 }}%
                            </span>
                            <span class="text-gray-400 mx-2">•</span>
                            <span class="text-gray-500 text-sm">vs last week</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average per Link -->
            <div class="metric-card glass-card rounded-2xl p-6 slide-up">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Clicks per Link</h3>
                        </div>
                        <div class="count-up text-3xl font-black text-gray-900 mb-2">
                            {{ $activeLinksCount > 0 ? number_format(($totalClicks ?? 0) / $activeLinksCount, 1) : '0' }}
                        </div>
                        <div class="flex items-center">
                            <span class="text-blue-600 font-semibold text-sm">Average</span>
                            <span class="text-gray-400 mx-2">•</span>
                            <span class="text-gray-500 text-sm">per active link</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Chart and Top Links -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Activity Chart -->
            <div class="glass-card rounded-2xl p-6 slide-up">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Click Activity</h3>
                    <div class="flex space-x-2">
                        <button id="btn-7d" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors">7D</button>
                        <button id="btn-30d" class="px-3 py-1 text-gray-500 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">30D</button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="activityChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Top Performing Links -->
<div class="glass-card rounded-2xl p-6 slide-up">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900">Top Performing Links</h3>
        <span class="text-sm text-gray-500">By clicks</span>
    </div>
    <div class="space-y-4">
        @forelse($topLinks as $index => $link)
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
            <div class="flex items-center space-x-3">
                <!-- Ranking Badge -->
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm
                    {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-orange-500' : '' }}
                    {{ $index === 1 ? 'bg-gradient-to-br from-gray-400 to-gray-600' : '' }}
                    {{ $index === 2 ? 'bg-gradient-to-br from-amber-600 to-yellow-700' : '' }}
                    {{ $index > 2 ? 'bg-gradient-to-br from-blue-500 to-purple-600' : '' }}">
                    @if($index === 0)
                        🥇
                    @elseif($index === 1)
                        🥈
                    @elseif($index === 2)
                        🥉
                    @else
                        {{ $index + 1 }}
                    @endif
                </div>
                
                <!-- Link Info -->
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-gray-900 truncate flex items-center space-x-2">
                        <span>{{ $link->title }}</span>
                        
                        <!-- Link Type Badge -->
                        @if($link->link_type && $link->link_type !== 'regular')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                            {{ $link->link_type === 'affiliate' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $link->link_type === 'product' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $link->link_type === 'sponsored' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ $link->link_type === 'affiliate' ? '💰' : '' }}
                            {{ $link->link_type === 'product' ? '🛍️' : '' }}
                            {{ $link->link_type === 'sponsored' ? '⭐' : '' }}
                        </span>
                        @endif
                        
                        <!-- High Performer Badge -->
                        @if($link->clicks > 100)
                        <span class="bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            🔥 Hot
                        </span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-500 truncate">{{ $link->url }}</div>
                    
                    <!-- Conversion Info for Revenue Links -->
                    @if($link->link_type && $link->link_type !== 'regular' && $link->conversions > 0)
                    <div class="text-xs text-green-600 font-medium mt-1">
                        {{ $link->conversions }} conversions 
                        ({{ $link->clicks > 0 ? round(($link->conversions / $link->clicks) * 100, 1) : 0 }}% rate)
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Performance Metrics -->
            <div class="text-right">
                <div class="font-bold text-gray-900">{{ number_format($link->clicks) }}</div>
                <div class="text-xs text-gray-500">clicks</div>
                
                <!-- Performance Indicator -->
                @if($index === 0 && $link->clicks > 50)
                <div class="text-xs text-green-600 font-medium mt-1">
                    🚀 Top performer
                </div>
                @elseif($link->clicks > 20)
                <div class="text-xs text-blue-600 font-medium mt-1">
                    📈 Trending
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state text-center py-8 rounded-lg">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
            </svg>
            <p class="text-gray-500 mb-2">No performance data yet</p>
            <p class="text-sm text-gray-400 mb-4">Your links need some clicks to appear here</p>
            <div class="space-y-2">
                <a href="{{ route('links.create') }}" class="block text-blue-600 hover:text-blue-700 font-medium">
                    Create your first link
                </a>
                @if($links && $links->count() > 0)
                <a href="{{ route('profile.show', Auth::user()->username) }}" 
                   target="_blank"
                   class="block text-emerald-600 hover:text-emerald-700 font-medium">
                    Share your profile to get clicks
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- View All Links Button -->
    @if($topLinks && $topLinks->count() >= 5)
    <div class="mt-6 pt-4 border-t border-gray-200">
        <a href="{{ route('links.index') }}" 
           class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center justify-center">
            View all links
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
    @endif
</div>
        </div>

        <!-- Quick Actions -->
        <div class="glass-card rounded-2xl p-6 slide-up">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('links.create') }}" 
                   class="btn-primary flex items-center p-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl transition duration-200">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div>
                        <div class="font-semibold">Add New Link</div>
                        <div class="text-sm opacity-90">Create a new link for your profile</div>
                    </div>
                </a>
                
                <a href="{{ route('links.index') }}" 
                   class="btn-primary flex items-center p-4 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white rounded-xl transition duration-200">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div>
                        <div class="font-semibold">Manage Links</div>
                        <div class="text-sm opacity-90">Edit, reorder, and organize your links</div>
                    </div>
                </a>
                
                <a href="{{ route('profile.show', Auth::user()->username) }}" 
                   target="_blank"
                   class="btn-primary flex items-center p-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl transition duration-200">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                    </svg>
                    <div>
                        <div class="font-semibold">View Public Profile</div>
                        <div class="text-sm opacity-90">See how your profile looks to visitors</div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    // Chart data from backend
    const chartData7d = {!! json_encode($chartData ?? [0,0,0,0,0,0,0]) !!};
    const chartLabels7d = {!! json_encode($chartLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']) !!};
    const chartData30d = {!! json_encode($chartData30d ?? [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]) !!};
    const chartLabels30d = {!! json_encode($chartLabels30d ?? []) !!};

    let currentChart = null;

    // Count up animation for metrics
    function animateCounter(element) {
        const target = parseFloat(element.textContent.replace(/,/g, ''));
        if (isNaN(target)) return;
        
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }

    // Initialize chart
    function initializeChart() {
        if (typeof Chart === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js';
            script.onload = function() {
                createChart(chartLabels7d, chartData7d);
                setupButtons();
            };
            document.head.appendChild(script);
        } else {
            createChart(chartLabels7d, chartData7d);
            setupButtons();
        }
    }

    function createChart(labels, data) {
        if (typeof Chart === 'undefined') return;
        
        const ctx = document.getElementById('activityChart');
        if (!ctx) return;
        
        if (currentChart) {
            currentChart.destroy();
        }

        currentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Clicks',
                    data: data,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            color: '#6B7280'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6B7280'
                        }
                    }
                }
            }
        });
    }

    function setupButtons() {
        const btn7d = document.getElementById('btn-7d');
        const btn30d = document.getElementById('btn-30d');
        
        if (btn7d) {
            btn7d.addEventListener('click', function() {
                setActiveButton('7d');
                createChart(chartLabels7d, chartData7d);
            });
        }
        
        if (btn30d) {
            btn30d.addEventListener('click', function() {
                setActiveButton('30d');
                createChart(chartLabels30d, chartData30d);
            });
        }
    }

    function setActiveButton(period) {
        const btn7d = document.getElementById('btn-7d');
        const btn30d = document.getElementById('btn-30d');
        
        if (btn7d && btn30d) {
            btn7d.className = 'px-3 py-1 text-gray-500 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors';
            btn30d.className = 'px-3 py-1 text-gray-500 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors';
            
            if (period === '7d') {
                btn7d.className = 'px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors';
            } else {
                btn30d.className = 'px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors';
            }
        }
    }

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Animate counters
        const counters = document.querySelectorAll('.count-up');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });
        
        counters.forEach(counter => observer.observe(counter));

        // Initialize chart
        initializeChart();
    });
</script>
@endsection