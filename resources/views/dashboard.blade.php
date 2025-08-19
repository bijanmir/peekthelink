<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Analytics Dashboard
                </h2>
                <p class="text-gray-600 mt-1">Real-time insights and performance metrics</p>
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

        /* Fixed chart container sizes */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Simple chart styles for fallback */
        .simple-chart {
            height: 300px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed rgba(59, 130, 246, 0.3);
        }
    </style>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Real-time Stats Header -->
            <div class="mb-8 slide-up">
                <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-3xl font-black mb-2">Analytics Dashboard</h2>
                                <p class="text-white/90">Real-time insights and performance metrics</p>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="w-2 h-2 bg-emerald-400 rounded-full live-indicator"></div>
                                    <span class="text-sm">Live</span>
                                </div>
                                <div id="real-time-clock" class="text-2xl font-bold"></div>
                                <div class="text-sm text-white/80">
                                    <span id="current-visitors">{{ $profileViews ?? 1 }}</span> total views
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                <!-- Profile Views -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.1s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Profile Views</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ $profileViews ?? 1 }}">{{ $profileViews ?? 1 }}</div>
                            <div class="flex items-center">
                                <span class="text-{{ ($profileViewsPercentageChange ?? 100) >= 0 ? 'emerald' : 'red' }}-600 font-semibold text-sm">
                                    {{ ($profileViewsPercentageChange ?? 100) > 0 ? '+' : '' }}{{ $profileViewsPercentageChange ?? 100 }}%
                                </span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">vs last week</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="w-16 h-16 relative">
                                <svg class="progress-ring w-16 h-16" viewBox="0 0 42 42">
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#e5e7eb" stroke-width="2"/>
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#3b82f6" stroke-width="3" 
                                            stroke-dasharray="{{ min($conversionRate ?? 100, 100) }} 100" stroke-linecap="round"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-xs font-bold text-blue-600">{{ $conversionRate ?? 100 }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Link Clicks -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.2s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Link Clicks</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ $totalClicks ?? 1 }}">{{ $totalClicks ?? 1 }}</div>
                            <div class="flex items-center">
                                <span class="text-{{ ($clicksPercentageChange ?? 100) >= 0 ? 'emerald' : 'red' }}-600 font-semibold text-sm">
                                    {{ ($clicksPercentageChange ?? 100) > 0 ? '+' : '' }}{{ $clicksPercentageChange ?? 100 }}%
                                </span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">vs last week</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-emerald-600">+{{ $todayClicks ?? 1 }}</div>
                            <div class="text-xs text-gray-500">today</div>
                        </div>
                    </div>
                </div>

                <!-- Total Links -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.3s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Links</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ $totalLinksCount ?? 1 }}">{{ $totalLinksCount ?? 1 }}</div>
                            <div class="flex items-center">
                                <span class="text-emerald-600 font-semibold text-sm">{{ $activeLinksCount ?? 1 }} active</span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">{{ ($totalLinksCount ?? 1) - ($activeLinksCount ?? 0) }} inactive</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="metric-card glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.4s">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Est. Revenue</h3>
                            </div>
                            <div class="count-up text-3xl font-black text-gray-900 mb-2" data-count="{{ number_format($monthlyRevenue ?? 0, 0) }}">${{ number_format($monthlyRevenue ?? 0, 0) }}</div>
                            <div class="flex items-center">
                                <span class="text-{{ ($revenuePercentageChange ?? 100) >= 0 ? 'emerald' : 'red' }}-600 font-semibold text-sm">
                                    {{ ($revenuePercentageChange ?? 100) > 0 ? '+' : '' }}{{ $revenuePercentageChange ?? 100 }}%
                                </span>
                                <span class="text-gray-400 mx-2">•</span>
                                <span class="text-gray-500 text-sm">this month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Traffic Analytics Chart -->
                <div class="glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.5s">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Daily Activity</h3>
                        <div class="flex space-x-2">
                            <button id="btn-7d" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors">7D</button>
                            <button id="btn-30d" class="px-3 py-1 text-gray-500 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">30D</button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="trafficChart" width="400" height="300"></canvas>
                        <!-- Fallback chart display -->
                        <div id="chart-fallback" class="simple-chart" style="display: none;">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <p class="text-gray-600 font-medium">Chart Loading...</p>
                                <p class="text-sm text-gray-500">{{ ($totalClicks ?? 1) }} total clicks</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Links Performance -->
                <div class="glass-card rounded-2xl p-6 slide-up" style="animation-delay: 0.6s">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Top Performing Links</h3>
                        <span class="text-sm text-gray-500">Total clicks</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($topLinks ?? [] as $index => $link)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 truncate max-w-xs">{{ $link->title }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($link->url, 40) }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-gray-900">{{ number_format($link->clicks) }}</div>
                                <div class="text-xs text-gray-500">clicks</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <p class="text-gray-500">No links yet</p>
                            <a href="{{ route('links.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">Create your first link</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Separate script tags for data - MUCH SAFER -->
    <script id="chart-labels-7d" type="application/json">
        ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
    </script>
    
    <script id="chart-data-7d" type="application/json">
        [0, 0, 0, {{ $totalClicks ?? 1 }}, 0, 0, 0]
    </script>

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
                    element.textContent = '$' + Math.floor(current).toLocaleString();
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Animate counters
            const counters = document.querySelectorAll('.count-up');
            counters.forEach(counter => {
                if (counter.dataset.count) {
                    animateCounter(counter);
                }
            });

            // Initialize chart
            initializeChart();
        });

        // Simple chart data - no complex JSON parsing
        const simpleChartData = {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            data: [0, 0, 0, {{ $totalClicks ?? 1 }}, 0, 0, 0]
        };

        let currentChart = null;

        // Initialize chart
        function initializeChart() {
            // Try to load Chart.js if not already loaded
            if (typeof Chart === 'undefined') {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js';
                script.onload = function() {
                    createChart(simpleChartData.labels, simpleChartData.data);
                    setupButtons();
                };
                script.onerror = function() {
                    showFallback();
                };
                document.head.appendChild(script);
            } else {
                createChart(simpleChartData.labels, simpleChartData.data);
                setupButtons();
            }
        }

        function createChart(labels, data) {
            if (typeof Chart === 'undefined') return;
            
            const ctx = document.getElementById('trafficChart');
            if (!ctx) return;
            
            // Destroy existing chart
            if (currentChart) {
                currentChart.destroy();
            }

            try {
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
            } catch (error) {
                console.error('Chart creation failed:', error);
                showFallback();
            }
        }

        function showFallback() {
            document.getElementById('trafficChart').style.display = 'none';
            document.getElementById('chart-fallback').style.display = 'flex';
        }

        function setupButtons() {
            const btn7d = document.getElementById('btn-7d');
            const btn30d = document.getElementById('btn-30d');
            
            if (btn7d) {
                btn7d.addEventListener('click', function() {
                    setActiveButton('7d');
                    createChart(simpleChartData.labels, simpleChartData.data);
                });
            }
            
            if (btn30d) {
                btn30d.addEventListener('click', function() {
                    setActiveButton('30d');
                    // Generate 30 day mock data
                    const labels30d = [];
                    const data30d = [];
                    for (let i = 29; i >= 0; i--) {
                        const date = new Date();
                        date.setDate(date.getDate() - i);
                        labels30d.push((date.getMonth() + 1) + '/' + date.getDate());
                        data30d.push(i === 3 ? {{ $totalClicks ?? 1 }} : 0);
                    }
                    createChart(labels30d, data30d);
                });
            }
        }

        function setActiveButton(period) {
            const btn7d = document.getElementById('btn-7d');
            const btn30d = document.getElementById('btn-30d');
            
            if (btn7d && btn30d) {
                // Reset both buttons
                btn7d.className = 'px-3 py-1 text-gray-500 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors';
                btn30d.className = 'px-3 py-1 text-gray-500 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors';
                
                // Set active button
                if (period === '7d') {
                    btn7d.className = 'px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors';
                } else {
                    btn30d.className = 'px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium transition-colors';
                }
            }
        }
    </script>
</x-app-layout>