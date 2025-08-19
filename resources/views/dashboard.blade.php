<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Welcome back, {{ $user->name }}! 👋
                </h2>
                <p class="text-gray-600 mt-1">Manage your PeekTheLink and track your performance</p>
            </div>
            <div class="hidden md:flex space-x-3">
                <a href="{{ route('links.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Link
                </a>
                <a href="{{ route('profile.show', $user->username) }}" 
                   target="_blank"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                    </svg>
                    View Profile
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Include CSS and JS -->
    @push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        /* Premium animations */
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
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Real-time Stats Header -->
            <div class="mb-8 slide-up">
                <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-black mb-2">Your Performance Today</h2>
                                <p class="text-white/90">Real-time analytics and insights</p>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                                    <span class="text-sm">Live</span>
                                </div>
                                <div id="real-time-clock" class="text-2xl font-bold"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                <!-- Total Links Card -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.1s">
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
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ $totalLinksCount }}">0</div>
                            <div class="flex items-center">
                                <span class="text-emerald-600 font-semibold text-sm">{{ $activeLinksCount }} active</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">{{ $conversionRate }}% rate</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="w-16 h-16 relative">
                                <svg class="progress-ring w-16 h-16" viewBox="0 0 42 42">
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#e5e7eb" stroke-width="2"/>
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#3b82f6" stroke-width="3" 
                                            stroke-dasharray="{{ $conversionRate }} 100" stroke-linecap="round"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-xs font-bold text-blue-600">{{ $conversionRate }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Clicks Card -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.2s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Clicks</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ $totalClicks }}">0</div>
                            <div class="flex items-center">
                                <span class="text-{{ $clicksPercentageChange >= 0 ? 'emerald' : 'red' }}-600 font-semibold text-sm">{{ $clicksPercentageChange > 0 ? '+' : '' }}{{ $clicksPercentageChange }}%</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">vs last week</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-emerald-600">+{{ $todayClicks }}</div>
                            <div class="text-xs text-gray-500">today</div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Card -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.3s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Revenue</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ number_format($monthlyRevenue, 0) }}">$0</div>
                            <div class="flex items-center">
                                <span class="text-{{ $revenuePercentageChange >= 0 ? 'emerald' : 'red' }}-600 font-semibold text-sm">{{ $revenuePercentageChange > 0 ? '+' : '' }}{{ $revenuePercentageChange }}%</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">this month</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Views Card -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.4s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Profile Views</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ $profileViews }}">0</div>
                            <div class="flex items-center">
                                <span class="text-{{ $profileViewsPercentageChange >= 0 ? 'emerald' : 'red' }}-600 font-semibold text-sm">{{ $profileViewsPercentageChange > 0 ? '+' : '' }}{{ $profileViewsPercentageChange }}%</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">vs last week</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Quick Actions would continue here... -->
            
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
            document.getElementById('real-time-clock').textContent = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Count up animation for metrics
        function animateCounter(element) {
            const target = parseInt(element.dataset.count);
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                if (element.dataset.count.includes('$')) {
                    element.textContent = '$' + Math.floor(current).toLocaleString();
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        // Initialize counters
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
        });
    </script>
</x-app-layout>