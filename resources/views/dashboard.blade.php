<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div>
                <h2 class="font-black text-3xl text-gray-900 leading-tight flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    Revenue Analytics Dashboard
                </h2>
                <p class="text-gray-600 mt-2 ml-14">Track your earnings and performance in real-time</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('links.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-3 px-5 rounded-xl transition duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Link
                </a>
                <a href="{{ route('profile.show', $user->username) }}" 
                   target="_blank"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-5 rounded-xl transition duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                    </svg>
                    View Profile
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        * { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .metric-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .progress-ring {
            transform: rotate(-90deg);
        }
        .progress-ring circle {
            transition: stroke-dasharray 1s ease-in-out;
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes countUp {
            from { transform: scale(0.5); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .slide-up { animation: slideUp 0.6s ease-out; }
        .count-up { animation: countUp 0.8s ease-out; }
        .live-indicator {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .revenue-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .earning-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
    </style>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Enhanced Revenue Overview Header -->
            <div class="mb-8 slide-up">
                <div class="revenue-gradient rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl">
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
                    <div class="absolute top-4 right-4 w-16 h-16 bg-white/10 rounded-full animate-pulse"></div>
                    <div class="absolute bottom-6 left-8 w-8 h-8 bg-white/20 rounded-full animate-bounce" style="animation-delay: 1s;"></div>
                    <div class="absolute top-1/2 right-12 w-4 h-4 bg-white/15 rounded-full animate-ping" style="animation-delay: 2s;"></div>
                    
                    <div class="relative z-10">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-4xl font-black tracking-tight">Revenue Dashboard</h2>
                                </div>
                                <p class="text-white/90 text-lg leading-relaxed max-w-md">
                                    Track your earnings and conversions in real-time with advanced analytics
                                </p>
                                
                                <!-- Quick Stats -->
                                <div class="flex items-center space-x-6 mt-6">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse"></div>
                                        <span class="text-sm font-medium text-white/90">Live Tracking</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                                        <span class="text-sm font-medium text-white/90">{{ $activeLinksCount ?? 0 }} Active Links</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Real-time Stats Panel -->
                            <div class="lg:ml-8">
                                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                                    <div class="text-center mb-4">
                                        <div class="flex items-center justify-center space-x-2 mb-2">
                                            <svg class="w-5 h-5 text-emerald-400 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                                <circle cx="10" cy="10" r="3"/>
                                            </svg>
                                            <span class="text-sm font-semibold text-white/90">Live Tracking</span>
                                        </div>
                                        <div id="real-time-clock" class="text-3xl font-black text-white mb-1"></div>
                                        <div class="text-sm text-white/70">Current Time</div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-white/80">This Month</span>
                                            <div class="earning-badge px-3 py-1 rounded-full">
                                                <span class="text-sm font-black text-white">
                                                    ${{ number_format($monthlyRevenue ?? 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-white/80">Today's Clicks</span>
                                            <span class="text-lg font-bold text-white">{{ $todayClicks ?? 0 }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-white/80">Conversion Rate</span>
                                            <span class="text-lg font-bold text-emerald-300">{{ $conversionRate ?? 0 }}%</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Progress Bar for Monthly Goal -->
                                    <div class="mt-4 pt-4 border-t border-white/20">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs text-white/70">Monthly Goal</span>
                                            <span class="text-xs text-white/70">{{ min(round(($monthlyRevenue ?? 0) / 1000 * 100, 1), 100) }}%</span>
                                        </div>
                                        <div class="w-full bg-white/20 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-emerald-400 to-blue-400 h-2 rounded-full transition-all duration-1000" 
                                                 style="width: {{ min(($monthlyRevenue ?? 0) / 1000 * 100, 100) }}%"></div>
                                        </div>
                                        <div class="text-xs text-white/60 mt-1">Target: $1,000/month</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Revenue Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                <!-- Monthly Revenue -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.1s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Monthly Revenue</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ number_format($monthlyRevenue ?? 0, 0) }}">${{ number_format($monthlyRevenue ?? 0, 2) }}</div>
                            <div class="flex items-center">
                                <span class="text-{{ ($revenuePercentageChange ?? 0) >= 0 ? 'emerald' : 'red' }}-600 font-semibold text-sm">
                                    {{ ($revenuePercentageChange ?? 0) > 0 ? '+' : '' }}{{ $revenuePercentageChange ?? 0 }}%
                                </span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conversion Rate -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.2s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Conversion Rate</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ $conversionRate ?? 0 }}">{{ $conversionRate ?? 0 }}%</div>
                            <div class="flex items-center">
                                <span class="text-gray-600 font-semibold text-sm">{{ $totalClicks ?? 0 }} clicks</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">this month</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="w-16 h-16 relative">
                                <svg class="progress-ring w-16 h-16" viewBox="0 0 42 42">
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#e5e7eb" stroke-width="2"/>
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#3b82f6" stroke-width="3" 
                                            stroke-dasharray="{{ min($conversionRate ?? 0, 100) }} 100" stroke-linecap="round"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-xs font-bold text-blue-600">{{ round($conversionRate ?? 0) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Per Click -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.3s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Revenue/Click</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ number_format($revenuePerClick ?? 0, 3) }}">${{ number_format($revenuePerClick ?? 0, 4) }}</div>
                            <div class="flex items-center">
                                <span class="text-gray-600 font-semibold text-sm">{{ $activeLinksCount ?? 0 }} active links</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">earning</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Links -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.4s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Links</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ $totalLinksCount ?? 0 }}">{{ $totalLinksCount ?? 0 }}</div>
                            <div class="flex items-center">
                                <span class="text-emerald-600 font-semibold text-sm">{{ $activeLinksCount ?? 0 }} active</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">{{ ($totalLinksCount ?? 0) - ($activeLinksCount ?? 0) }} inactive</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Breakdown & Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Revenue by Type -->
                <div class="glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.5s">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Revenue by Type</h3>
                        <span class="text-sm text-gray-500">This month</span>
                    </div>
                    <div class="space-y-4">
                        @if(isset($revenueByType) && array_sum($revenueByType) > 0)
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Affiliate Commissions</span>
                            </div>
                            <span class="font-bold text-gray-900">${{ number_format($revenueByType['affiliate'] ?? 0, 2) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Product Sales</span>
                            </div>
                            <span class="font-bold text-gray-900">${{ number_format($revenueByType['product'] ?? 0, 2) }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">Sponsored Content</span>
                            </div>
                            <span class="font-bold text-gray-900">${{ number_format($revenueByType['sponsored'] ?? 0, 2) }}</span>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <p class="text-gray-500 mb-2">No revenue data yet</p>
                            <p class="text-sm text-gray-400 mb-4">Set up affiliate links to start earning</p>
                            <a href="{{ route('links.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">Create your first revenue link</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Top Revenue Links -->
                <div class="glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.6s">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Top Revenue Links</h3>
                        <span class="text-sm text-gray-500">This month</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($topRevenueLinks ?? [] as $index => $linkData)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 truncate max-w-xs">{{ $linkData['link']->title }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ ucfirst($linkData['link']->link_type) }} • {{ $linkData['conversion_rate'] }}% conversion
                                        @if($linkData['revenue_per_click'] > 0)
                                        • ${{ number_format($linkData['revenue_per_click'], 4) }}/click
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-gray-900">${{ number_format($linkData['revenue'], 2) }}</div>
                                <div class="text-xs text-gray-500">{{ $linkData['clicks'] }} clicks</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <p class="text-gray-500 mb-2">No revenue links yet</p>
                            <a href="{{ route('links.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">Create revenue-generating links</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Daily Activity Chart -->
            <div class="glass-card rounded-2xl p-6 slide-up mb-8" style="animation-delay: 0.7s">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Daily Activity</h3>
                    <div class="flex space-x-2">
                        <button id="btn-7d" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors">7D</button>
                        <button id="btn-30d" class="px-3 py-1 text-gray-500 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">30D</button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="trafficChart" width="400" height="300"></canvas>
                </div>
            </div>

        </div>
    </div>

   <script>
        // Real-time clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: false, 
                hour: '2-digit', 
                minute: '2-digit'
            });
            const clockElement = document.getElementById('real-time-clock');
            if (clockElement) {
                clockElement.textContent = timeString;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Count up animation for metrics
        function animateCounter(element) {
            const target = parseFloat(element.dataset.count);
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
                
                if (element.textContent.includes('$')) {
                    element.textContent = '$' + current.toFixed(2);
                } else if (element.textContent.includes('%')) {
                    element.textContent = current.toFixed(1) + '%';
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        // Initialize counters and charts
        document.addEventListener('DOMContentLoaded', function() {
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

        // Chart data - Fixed PHP array handling
        const chartData7d   = {!! json_encode($chartData ?? [0,0,0,0,0,0,0]) !!};
        const chartLabels7d = {!! json_encode($chartLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']) !!};
        const chartData30d  = {!! json_encode($chartData30d ?? array_fill(0, 30, 0)) !!};
        const chartLabels30d= {!! json_encode($chartLabels30d ?? []) !!};

        let currentChart = null;

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
            
            const ctx = document.getElementById('trafficChart');
            if (!ctx) return;
            
            if (currentChart) {
                currentChart.destroy();
            }

            currentChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Daily Clicks',
                        data: data,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
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
                            min: 0,
                            max: Math.max(Math.max(...data) + 2, 5),
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: '#6B7280',
                                stepSize: 1
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
    </script>
</x-app-layout>