<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <!-- Primary Meta Tags -->
        <title>{{ isset($title) ? $title . ' | ' . config('app.name', 'PeekTheLink') : config('app.name', 'PeekTheLink') . ' - Create Your Perfect Link in Bio Page' }}</title>
        <meta name="title" content="{{ isset($title) ? $title . ' | ' . config('app.name', 'PeekTheLink') : config('app.name', 'PeekTheLink') . ' - Create Your Perfect Link in Bio Page' }}">
        <meta name="description" content="{{ $description ?? 'Join thousands of creators using PeekTheLink to share all their important links in one beautiful, mobile-optimized page. Free to start, easy to customize, perfect for social media bios.' }}">
        <meta name="keywords" content="{{ $keywords ?? 'link in bio, linktree alternative, bio link tool, social media links, landing page creator, content creator tools, influencer tools, free bio link' }}">
        <meta name="author" content="PeekTheLink">
        <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ $canonical ?? url()->current() }}">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="{{ $ogType ?? 'website' }}">
        <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
        <meta property="og:title" content="{{ $ogTitle ?? (isset($title) ? $title . ' | ' . config('app.name', 'PeekTheLink') : config('app.name', 'PeekTheLink') . ' - Create Your Perfect Link in Bio Page') }}">
        <meta property="og:description" content="{{ $ogDescription ?? ($description ?? 'Join thousands of creators using PeekTheLink to share all their important links in one beautiful, mobile-optimized page. Free to start, easy to customize.') }}">
        <meta property="og:image" content="{{ $ogImage ?? asset('images/peek-logo-social.png') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ $ogImageAlt ?? 'PeekTheLink - The Ultimate Link in Bio Platform' }}">
        <meta property="og:site_name" content="{{ config('app.name', 'PeekTheLink') }}">
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
        
        <!-- Twitter -->
        <meta property="twitter:card" content="{{ $twitterCard ?? 'summary_large_image' }}">
        <meta property="twitter:url" content="{{ $twitterUrl ?? url()->current() }}">
        <meta property="twitter:title" content="{{ $twitterTitle ?? (isset($title) ? $title . ' | ' . config('app.name', 'PeekTheLink') : config('app.name', 'PeekTheLink') . ' - Create Your Perfect Link in Bio Page') }}">
        <meta property="twitter:description" content="{{ $twitterDescription ?? ($description ?? 'Join thousands of creators using PeekTheLink to share all their important links in one beautiful, mobile-optimized page.') }}">
        <meta property="twitter:image" content="{{ $twitterImage ?? asset('images/peek-logo-social.png') }}">
        <meta property="twitter:image:alt" content="{{ $twitterImageAlt ?? 'PeekTheLink - The Ultimate Link in Bio Platform' }}">
        @if(isset($twitterSite))
        <meta property="twitter:site" content="{{ $twitterSite }}">
        @endif
        @if(isset($twitterCreator))
        <meta property="twitter:creator" content="{{ $twitterCreator }}">
        @endif
        
        <!-- LinkedIn -->
        <meta property="linkedin:owner" content="{{ $linkedinOwner ?? '' }}">
        
        <!-- Additional Meta Tags for Public Pages -->
        <meta name="theme-color" content="#667eea">
        <meta name="msapplication-TileColor" content="#667eea">
        <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name', 'PeekTheLink') }}">
        
        <!-- Favicon and Icons -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/android-chrome-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/android-chrome-512x512.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('images/safari-pinned-tab.svg') }}" color="#667eea">
        
        <!-- Preconnect for Performance -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <!-- JSON-LD Structured Data for Homepage/Landing -->
        @if(request()->is('/'))
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "SoftwareApplication",
            "name": "{{ config('app.name', 'PeekTheLink') }}",
            "description": "Create beautiful link-in-bio pages with PeekTheLink. Share all your important links in one stunning, mobile-optimized landing page.",
            "url": "{{ config('app.url') }}",
            "logo": "{{ asset('images/peek-logo.png') }}",
            "image": "{{ asset('images/peek-logo-social.png') }}",
            "applicationCategory": "BusinessApplication",
            "operatingSystem": "Any",
            "browserRequirements": "Modern web browser",
            "softwareVersion": "1.0",
            "datePublished": "{{ now()->toISOString() }}",
            "author": {
                "@type": "Organization",
                "name": "{{ config('app.name', 'PeekTheLink') }}",
                "url": "{{ config('app.url') }}"
            },
            "publisher": {
                "@type": "Organization", 
                "name": "{{ config('app.name', 'PeekTheLink') }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('images/peek-logo.png') }}"
                }
            },
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "USD",
                "availability": "https://schema.org/InStock",
                "validFrom": "{{ now()->toISOString() }}"
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.8",
                "ratingCount": "1247",
                "bestRating": "5",
                "worstRating": "1"
            },
            "featureList": [
                "Unlimited links",
                "Custom themes",
                "Analytics tracking",
                "Mobile optimization",
                "Fast loading",
                "Free to use"
            ]
        }
        </script>
        @endif
        
        <!-- Profile Page Structured Data -->
        @if(isset($user) && request()->route()->getName() === 'profile.show')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ProfilePage",
            "mainEntity": {
                "@type": "Person",
                "name": "{{ $user->display_name ?: $user->name }}",
                "alternateName": "{{ $user->username }}",
                "description": "{{ $user->bio ?? 'Check out my links on ' . config('app.name', 'PeekTheLink') }}",
                "url": "{{ route('profile.show', $user->username) }}",
                "sameAs": [
                    @if($user->links->isNotEmpty())
                        @foreach($user->links->where('is_active', true)->take(5) as $link)
                            "{{ $link->url }}"{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    @endif
                ]
            },
            "about": "{{ $user->bio ?? 'Links and content from ' . ($user->display_name ?: $user->name) }}",
            "dateCreated": "{{ $user->created_at->toISOString() }}",
            "dateModified": "{{ $user->updated_at->toISOString() }}",
            "isPartOf": {
                "@type": "WebSite",
                "name": "{{ config('app.name', 'PeekTheLink') }}",
                "url": "{{ config('app.url') }}"
            }
        }
        </script>
        @endif
        
        <!-- Additional Custom Head Content -->
        @stack('head')
        
        <!-- Performance optimizations -->
        <link rel="preload" href="{{ asset('images/peek-logo.png') }}" as="image">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom Styles for Guest Pages -->
        <style>
            /* Prevent flash of unstyled content */
            html { visibility: hidden; opacity: 0; }
            html.loaded { visibility: visible; opacity: 1; transition: opacity 0.3s ease-in-out; }
            
            /* Performance optimizations for animations */
            * {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            
            /* Optimize for mobile */
            @media (max-width: 768px) {
                * {
                    -webkit-tap-highlight-color: transparent;
                }
            }
        </style>
        
        <!-- Cookie Consent (if required) -->
        @if(config('app.env') === 'production')
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            // Add your tracking ID here
        </script>
        @endif
    </head>
    <body class="font-sans antialiased">
        <!-- Skip to main content for accessibility -->
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50">
            Skip to main content
        </a>
        
        <!-- Main Content -->
        <main id="main-content">
            {{ $slot }}
        </main>
        
        <!-- Footer Scripts -->
        @stack('scripts')
        
        <!-- Initialize and Performance -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.documentElement.classList.add('loaded');
                
                // Preload critical images
                const criticalImages = [
                    '{{ asset('images/peek-logo.png') }}'
                ];
                
                criticalImages.forEach(src => {
                    const img = new Image();
                    img.src = src;
                });
            });
            
            // Service Worker for PWA capabilities (optional)
            if ('serviceWorker' in navigator && '{{ config('app.env') }}' === 'production') {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js')
                        .then(function(registration) {
                            console.log('SW registered: ', registration);
                        })
                        .catch(function(registrationError) {
                            console.log('SW registration failed: ', registrationError);
                        });
                });
            }
        </script>
        
        <!-- Analytics and Tracking (Production) -->
        @if(config('app.env') === 'production')
            <!-- Google Analytics, Facebook Pixel, etc. -->
        @endif
    </body>
</html>