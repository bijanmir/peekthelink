<x-guest-layout>
    <style>
        * { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
        }
        
        .profile-gradient {
            background: linear-gradient(135deg, {{ $user->theme_color }}15 0%, {{ $user->theme_color }}25 50%, {{ $user->theme_color }}10 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .link-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        
        .link-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: {{ $user->theme_color }};
            background: rgba(255, 255, 255, 0.95);
        }
        
        .profile-avatar {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
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
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .slide-up {
            animation: slideUp 0.8s ease-out forwards;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
        
        .link-icon {
            transition: all 0.3s ease;
        }
        
        .link-card:hover .link-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .theme-accent {
            color: {{ $user->theme_color }};
        }
        
        .theme-bg {
            background-color: {{ $user->theme_color }};
        }
        
        .theme-border {
            border-color: {{ $user->theme_color }};
        }
        
        .theme-gradient {
            background: linear-gradient(135deg, {{ $user->theme_color }} 0%, {{ $user->theme_color }}dd 100%);
        }
        
        .floating-elements {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }
        
        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: {{ $user->theme_color }}20;
            animation: floatCircle 20s infinite linear;
        }
        
        @keyframes floatCircle {
            0% { transform: translateY(100vh) rotate(0deg); }
            100% { transform: translateY(-100px) rotate(360deg); }
        }
        
        .stats-badge {
            background: linear-gradient(135deg, {{ $user->theme_color }}20 0%, {{ $user->theme_color }}10 100%);
            border: 1px solid {{ $user->theme_color }}30;
        }
        
        .pulse-ring {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 {{ $user->theme_color }}40;
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px {{ $user->theme_color }}00;
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 {{ $user->theme_color }}00;
            }
        }
    </style>

    <div class="min-h-screen profile-gradient relative">
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-circle w-32 h-32" style="left: 10%; animation-delay: 0s;"></div>
            <div class="floating-circle w-20 h-20" style="left: 80%; animation-delay: 5s;"></div>
            <div class="floating-circle w-16 h-16" style="left: 60%; animation-delay: 10s;"></div>
            <div class="floating-circle w-24 h-24" style="left: 30%; animation-delay: 15s;"></div>
        </div>

        <div class="max-w-lg mx-auto px-6 py-12 relative z-10">
            
            {{-- Profile Header --}}
            <div class="text-center mb-12 slide-up">
                <div class="relative inline-block mb-8">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" 
                             alt="{{ $user->display_name ?? $user->name }}"
                             class="profile-avatar w-32 h-32 rounded-full mx-auto object-cover shadow-2xl pulse-ring"
                             style="border: 4px solid {{ $user->theme_color }};">
                    @else
                        <div class="profile-avatar w-32 h-32 rounded-full mx-auto flex items-center justify-center text-white text-4xl font-black shadow-2xl pulse-ring theme-gradient">
                            {{ strtoupper(substr($user->display_name ?? $user->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <!-- Online Status Indicator -->
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 theme-bg rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                        <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
                    </div>
                </div>
                
                <h1 class="text-4xl font-black text-gray-900 mb-4 tracking-tight">
                    {{ $user->display_name ?? $user->name }}
                </h1>
                
                <div class="flex items-center justify-center mb-6">
                    <div class="stats-badge px-4 py-2 rounded-full text-sm font-bold theme-accent">
                        {{ $user->username }}
                    </div>
                </div>
                
                @if($user->bio)
                    <p class="text-gray-700 text-lg leading-relaxed mb-8 max-w-md mx-auto">
                        {{ $user->bio }}
                    </p>
                @endif               
            </div>

            {{-- Links Grid --}}
            <div class="space-y-6 mb-12">
                @forelse($links as $index => $link)
                    <div class="slide-up" style="animation-delay: {{ 0.2 + ($index * 0.1) }}s;">
                        <a href="{{ route('profile.link', [$user->username, $link->id]) }}"
                           class="link-card block w-full p-6 rounded-2xl shadow-lg hover:shadow-2xl group"
                           onclick="handleLinkClick(event, '{{ route('profile.link', [$user->username, $link->id]) }}')">
                            
                            <div class="flex items-center space-x-4">
                                <!-- Link Icon -->
                                <div class="link-icon w-14 h-14 theme-gradient rounded-xl flex items-center justify-center shadow-lg">
                                    @if($link->link_type === 'affiliate')
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    @elseif($link->link_type === 'product')
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    @elseif($link->link_type === 'sponsored')
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    @else
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Link Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-bold text-xl text-gray-900 truncate">
                                            {{ $link->title }}
                                        </h3>
                                        
                                        <!-- Arrow Icon -->
                                        <svg class="w-6 h-6 theme-accent transform group-hover:translate-x-1 transition-transform duration-300" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </div>
                                    
                                    @if($link->description)
                                        <p class="text-gray-600 text-sm leading-relaxed mb-3">
                                            {{ $link->description }}
                                        </p>
                                    @endif

                                    <!-- Link Metadata -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            @if($link->link_type !== 'regular')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold theme-accent" 
                                                      style="background-color: {{ $user->theme_color }}15;">
                                                    {{ ucfirst($link->link_type) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-16 slide-up">
                        <div class="w-24 h-24 mx-auto mb-6 theme-gradient rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No links yet</h3>
                        <p class="text-gray-600">{{ $user->display_name ?? $user->name }} hasn't added any links yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Social Proof Section --}}
            @if($links->count() > 0)
            <div class="glass-card rounded-2xl p-6 text-center mb-8 slide-up" style="animation-delay: {{ 0.5 + ($links->count() * 0.1) }}s;">
                <div class="flex items-center justify-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-bold text-gray-900">Verified Profile</span>
                </div>
                <p class="text-xs text-gray-600">
                    This LinkBio has been viewed {{ number_format($links->sum('clicks')) }} times
                </p>
            </div>
            @endif

            {{-- Footer --}}
            <div class="text-center slide-up" style="animation-delay: {{ 0.7 + ($links->count() * 0.1) }}s;">
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-center space-x-2 mb-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">LinkBio</span>
                    </div>
                    <p class="text-xs text-gray-500 mb-4">Create your own LinkBio</p>
                    <a href="{{ route('welcome') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-bold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Get Started Free
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleLinkClick(event, url) {
            // Add click analytics
            console.log('Link clicked:', url);
            
            // Add a subtle click animation
            const linkCard = event.currentTarget;
            linkCard.style.transform = 'scale(0.98)';
            
            setTimeout(() => {
                linkCard.style.transform = '';
            }, 150);
            
            // Allow the default behavior to continue
            return true;
        }

        // Add scroll-triggered animations for better mobile experience
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.slide-up');
            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                observer.observe(el);
            });
        });

        // Preload images for better performance
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                const newImg = new Image();
                newImg.src = img.src;
            });
        });
    </script>
</x-guest-layout>