@extends('layouts.guest')

@section('content')
<style>
    * { 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
    }
    
    /* Premium gradient system */
    .profile-gradient {
        background: 
            radial-gradient(circle at 20% 80%, {{ $user->theme_color }}08 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, {{ $user->theme_color }}05 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(139, 92, 246, 0.03) 0%, transparent 50%),
            linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #ffffff 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }
    
    /* Glass morphism cards */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.08),
            0 1px 0 rgba(255, 255, 255, 0.8) inset;
    }
    
    /* Premium link cards */
    .link-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid transparent;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(16px);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    }
    
    .link-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s;
    }
    
    .link-card:hover::before {
        left: 100%;
    }
    
    .link-card:hover {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 
            0 24px 48px rgba(0, 0, 0, 0.12),
            0 0 0 1px {{ $user->theme_color }}40;
        background: rgba(255, 255, 255, 1);
        border-color: {{ $user->theme_color }};
    }
    
    .link-card:active {
        transform: translateY(-8px) scale(1.01);
    }
    
    /* Avatar animations */
    .profile-avatar {
        animation: float 6s ease-in-out infinite, glow-pulse 4s ease-in-out infinite alternate;
        position: relative;
    }
    
    .profile-avatar::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: linear-gradient(135deg, {{ $user->theme_color }}, rgba(139, 92, 246, 0.6));
        z-index: -1;
        animation: rotate 8s linear infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-12px) rotate(1deg); }
        66% { transform: translateY(6px) rotate(-1deg); }
    }
    
    @keyframes glow-pulse {
        0% { filter: drop-shadow(0 0 20px {{ $user->theme_color }}60); }
        100% { filter: drop-shadow(0 0 40px {{ $user->theme_color }}80); }
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Slide up animations */
    @keyframes slideUp {
        from { 
            transform: translateY(50px); 
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
        animation: slideUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }
    
    .fade-in {
        animation: fadeIn 1.2s ease-out forwards;
    }
    
    /* Staggered animations */
    .slide-up:nth-child(1) { animation-delay: 0.1s; }
    .slide-up:nth-child(2) { animation-delay: 0.2s; }
    .slide-up:nth-child(3) { animation-delay: 0.3s; }
    .slide-up:nth-child(4) { animation-delay: 0.4s; }
    .slide-up:nth-child(5) { animation-delay: 0.5s; }
    .slide-up:nth-child(6) { animation-delay: 0.6s; }
    
    /* Link icons */
    .link-icon {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .link-card:hover .link-icon {
        transform: scale(1.2) rotate(8deg);
        filter: brightness(1.2);
    }
    
    /* Theme color utilities */
    .theme-accent { color: {{ $user->theme_color }}; }
    .theme-bg { background-color: {{ $user->theme_color }}; }
    .theme-border { border-color: {{ $user->theme_color }}; }
    .theme-gradient {
        background: linear-gradient(135deg, {{ $user->theme_color }} 0%, rgba(139, 92, 246, 0.8) 100%);
    }
    
    /* Floating background elements */
    .floating-elements {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
    }
    
    .floating-orb {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, {{ $user->theme_color }}08, rgba(139, 92, 246, 0.04));
        animation: floatOrb 20s infinite linear;
        filter: blur(2px);
    }
    
    @keyframes floatOrb {
        0% { 
            transform: translateY(100vh) translateX(0) rotate(0deg) scale(0.5);
            opacity: 0;
        }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { 
            transform: translateY(-200px) translateX(100px) rotate(360deg) scale(1);
            opacity: 0;
        }
    }
    
    /* Stats badges */
    .stats-badge {
        background: linear-gradient(135deg, {{ $user->theme_color }}10 0%, rgba(139, 92, 246, 0.06) 100%);
        border: 1px solid {{ $user->theme_color }}20;
        backdrop-filter: blur(8px);
    }
    
    /* Bio text with gradient */
    .bio-text {
        background: linear-gradient(135deg, #374151 0%, #6b7280 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Username badge */
    .username-badge {
        background: linear-gradient(135deg, {{ $user->theme_color }} 0%, rgba(139, 92, 246, 0.9) 100%);
        position: relative;
        overflow: hidden;
    }
    
    .username-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    
    /* Click ripple effect */
    .ripple {
        position: relative;
        overflow: hidden;
    }
    
    .ripple::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }
    
    /* Responsive improvements */
    @media (max-width: 640px) {
        .link-card:hover {
            transform: translateY(-6px) scale(1.02);
        }
        
        .profile-avatar {
            animation: float 8s ease-in-out infinite;
        }
    }
    
    /* Performance optimization */
    .link-card, .glass-card, .profile-avatar {
        will-change: transform;
    }
    
    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .profile-gradient {
            background: 
                radial-gradient(circle at 20% 80%, {{ $user->theme_color }}15 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, {{ $user->theme_color }}10 0%, transparent 50%),
                linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        
        .glass-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .link-card {
            background: rgba(15, 23, 42, 0.9);
            color: #f1f5f9;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }
        
        .link-card:hover {
            background: rgba(15, 23, 42, 0.95);
            box-shadow: 
                0 24px 48px rgba(0, 0, 0, 0.4),
                0 0 0 1px {{ $user->theme_color }}40;
        }
        
        .bio-text {
            background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    }
</style>

<div class="profile-gradient">
    <!-- Floating Background Orbs -->
    <div class="floating-elements">
        <div class="floating-orb w-32 h-32" style="left: 10%; animation-delay: 0s;"></div>
        <div class="floating-orb w-24 h-24" style="left: 80%; animation-delay: 3s;"></div>
        <div class="floating-orb w-20 h-20" style="left: 60%; animation-delay: 6s;"></div>
        <div class="floating-orb w-28 h-28" style="left: 30%; animation-delay: 9s;"></div>
        <div class="floating-orb w-16 h-16" style="left: 70%; animation-delay: 12s;"></div>
    </div>

    <div class="max-w-md mx-auto px-6 py-16 relative z-10">
        
        <!-- Profile Header -->
        <div class="text-center mb-16">
            <!-- Avatar with Premium Effects -->
            <div class="relative inline-block mb-8 slide-up">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                         alt="{{ $user->display_name ?? $user->name }}"
                         class="profile-avatar w-36 h-36 rounded-full mx-auto object-cover shadow-2xl"
                         style="border: 6px solid white;">
                @else
                    <div class="profile-avatar w-36 h-36 rounded-full mx-auto flex items-center justify-center text-white text-5xl font-black shadow-2xl theme-gradient">
                        {{ strtoupper(substr($user->display_name ?? $user->name, 0, 1)) }}
                    </div>
                @endif
                
                <!-- Online Status with Pulse -->
                <div class="absolute -bottom-1 -right-1 w-10 h-10 theme-bg rounded-full border-4 border-white shadow-xl flex items-center justify-center">
                    <div class="w-4 h-4 bg-white rounded-full animate-ping"></div>
                    <div class="w-4 h-4 bg-white rounded-full absolute animate-pulse"></div>
                </div>
            </div>
            
            <!-- Name with Gradient -->
            <h1 class="text-5xl font-black text-gray-900 mb-4 tracking-tight slide-up dark:text-gray-50" style="animation-delay: 0.2s;">
                {{ $user->display_name ?? $user->name }}
            </h1>
            
            <!-- Username Badge -->
            <div class="inline-flex items-center px-6 py-2 username-badge rounded-full text-white font-bold text-lg mb-6 slide-up" style="animation-delay: 0.3s;">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $user->username }}
            </div>
            
            <!-- Bio -->
            @if($user->bio)
                <p class="bio-text text-xl leading-relaxed max-w-sm mx-auto mb-8 slide-up" style="animation-delay: 0.4s;">
                    {{ $user->bio }}
                </p>
            @endif
            
            <!-- Stats Row -->
            <div class="flex justify-center space-x-6 mb-12 slide-up" style="animation-delay: 0.5s;">
                <div class="stats-badge px-4 py-2 rounded-xl">
                    <div class="text-2xl font-black theme-accent">{{ $user->links->where('is_active', true)->count() }}</div>
                    <div class="text-sm text-gray-600 font-medium">Links</div>
                </div>
                <div class="stats-badge px-4 py-2 rounded-xl">
                    <div class="text-2xl font-black theme-accent">{{ $user->links->sum('clicks') }}</div>
                    <div class="text-sm text-gray-600 font-medium">Clicks</div>
                </div>
            </div>
        </div>

        <!-- Links Grid -->
        <div class="space-y-4">
            @forelse($user->links->where('is_active', true)->sortBy('order') as $index => $link)
                <a href="{{ route('profile.link.redirect', ['username' => $user->username, 'link' => $link->id]) }}" 
                   class="link-card glass-card rounded-2xl p-6 block group ripple slide-up"
                   style="animation-delay: {{ 0.6 + ($index * 0.1) }}s;"
                   onclick="return handleLinkClick(this, event);">
                   
                    <div class="flex items-center space-x-4">
                        <!-- Dynamic Icon -->
                        <div class="link-icon w-12 h-12 rounded-xl flex items-center justify-center text-white theme-gradient flex-shrink-0">
                            @if(str_contains($link->url, 'instagram'))
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            @elseif(str_contains($link->url, 'twitter') || str_contains($link->url, 'x.com'))
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            @elseif(str_contains($link->url, 'youtube'))
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            @elseif(str_contains($link->url, 'linkedin'))
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            @elseif(str_contains($link->url, 'github'))
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            @elseif(str_contains($link->url, 'tiktok'))
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                </svg>
                            @endif
                        </div>
                        
                        <!-- Link Content -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:theme-accent transition-colors duration-300">
                                {{ $link->title }}
                            </h3>
                            @if($link->description)
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $link->description }}</p>
                            @endif
                        </div>
                        
                        <!-- Click indicator with count -->
                        <div class="flex flex-col items-center space-y-1">
                            <div class="text-xs text-gray-500 font-medium">{{ $link->clicks }} clicks</div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:theme-accent transform group-hover:translate-x-1 transition-all duration-300" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-16 slide-up" style="animation-delay: 0.6s;">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2 dark:text-gray-50">No Links Yet</h3>
                    <p class="text-gray-600 dark:text-gray-200 max-w-sm mx-auto">This profile doesn't have any active links to display right now.</p>
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        <div class="text-center mt-16 slide-up" style="animation-delay: {{ 0.8 + ($user->links->where('is_active', true)->count() * 0.1) }}s;">
            <div class="inline-flex items-center px-6 py-3 glass-card rounded-full text-sm text-gray-600 font-medium">
                <svg class="w-5 h-5 mr-2 theme-accent" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                Powered by <span class="font-bold theme-accent ml-1">PeekTheLink</span>
            </div>
        </div>
    </div>
</div>

<script>
    // Enhanced click handling with analytics
    function handleLinkClick(linkCard, event) {
        // Visual feedback
        linkCard.style.transform = 'scale(0.95)';
        
        // Create ripple effect
        const ripple = document.createElement('span');
        const rect = linkCard.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: radial-gradient(circle, rgba(255,255,255,0.6) 0%, transparent 70%);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
            z-index: 1000;
        `;
        
        linkCard.appendChild(ripple);
        
        // Clean up ripple
        setTimeout(() => {
            if (ripple.parentNode) {
                ripple.parentNode.removeChild(ripple);
            }
        }, 600);
        
        // Reset transform
        setTimeout(() => {
            linkCard.style.transform = '';
        }, 150);
        
        return true; // Allow navigation
    }

    // Add ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple-animation {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Intersection Observer for scroll animations
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

    // Initialize animations on load
    document.addEventListener('DOMContentLoaded', () => {
        // Observe slide-up elements
        const animatedElements = document.querySelectorAll('.slide-up');
        animatedElements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            observer.observe(el);
        });

        // Preload images for better performance
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            const newImg = new Image();
            newImg.src = img.src;
        });

        // Add touch feedback for mobile
        if ('ontouchstart' in window) {
            const linkCards = document.querySelectorAll('.link-card');
            linkCards.forEach(card => {
                card.addEventListener('touchstart', () => {
                    card.style.transform = 'scale(0.98)';
                });
                
                card.addEventListener('touchend', () => {
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 100);
                });
            });
        }
    });

    // Performance optimization: debounce scroll events
    let ticking = false;
    function updateScrollAnimations() {
        // Add any scroll-based animations here
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(updateScrollAnimations);
            ticking = true;
        }
    });

    // Add keyboard navigation support
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            const focusedElement = document.activeElement;
            if (focusedElement.classList.contains('link-card')) {
                e.preventDefault();
                focusedElement.click();
            }
        }
    });
</script>
@endsection