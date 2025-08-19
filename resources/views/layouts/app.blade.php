<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <!-- Primary Meta Tags -->
        <title>{{ isset($title) ? $title . ' | ' . config('app.name', 'PeekTheLink') : config('app.name', 'PeekTheLink') . ' - Your Link in Bio Platform' }}</title>
        <meta name="title" content="{{ isset($title) ? $title . ' | ' . config('app.name', 'PeekTheLink') : config('app.name', 'PeekTheLink') . ' - Your Link in Bio Platform' }}">
        <meta name="description" content="{{ $description ?? 'Create beautiful link-in-bio pages with PeekTheLink. Share all your important links in one stunning, mobile-optimized landing page. Free to start, easy to customize.' }}">
        <meta name="keywords" content="{{ $keywords ?? 'link in bio, social media links, landing page, linktree alternative, bio link, social media tools, content creator tools' }}">
        <meta name="author" content="PeekTheLink">
        <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ $canonical ?? url()->current() }}">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="{{ $ogType ?? 'website' }}">
        <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
        <meta property="og:title" content="{{ $ogTitle ?? (isset($title) ? $title . ' | ' . config('app.name', 'PeekTheLink') : config('app.name', 'PeekTheLink') . ' - Your Link in Bio Platform') }}">
        <meta property="og:description" content="{{ $ogDescription ?? ($description ?? 'Create beautiful link-in-bio pages with PeekTheLink. Share all your important links in one stunning, mobile-optimized landing page.') }}">
        <meta property="og:image" content="{{ $ogImage ?? asset('images/peek-logo.png') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ $ogImageAlt ?? 'PeekTheLink - Link in Bio Platform' }}">
        <meta property="og:site_name" content="{{ config('app.name', 'PeekTheLink') }}">
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
        
        <!-- Twitter -->
        <meta property="twitter:card" content="{{ $twitterCard ?? 'summary_large_image' }}">
        <meta property="twitter:url" content="{{ $twitterUrl ?? url()->current() }}">
        <meta property="twitter:title" content="{{ $twitterTitle ?? (isset($title) ? $title . ' | ' . config('app.name', 'PeekTheLink') : config('app.name', 'PeekTheLink') . ' - Your Link in Bio Platform') }}">
        <meta property="twitter:description" content="{{ $twitterDescription ?? ($description ?? 'Create beautiful link-in-bio pages with PeekTheLink. Share all your important links in one stunning, mobile-optimized landing page.') }}">
        <meta property="twitter:image" content="{{ $twitterImage ?? asset('images/peek-logo.png') }}">
        <meta property="twitter:image:alt" content="{{ $twitterImageAlt ?? 'PeekTheLink - Link in Bio Platform' }}">
        @if(isset($twitterSite))
        <meta property="twitter:site" content="{{ $twitterSite }}">
        @endif
        @if(isset($twitterCreator))
        <meta property="twitter:creator" content="{{ $twitterCreator }}">
        @endif
        
        <!-- LinkedIn -->
        <meta property="linkedin:owner" content="{{ $linkedinOwner ?? '' }}">
        
        <!-- Additional Meta Tags -->
        <meta name="theme-color" content="#667eea">
        <meta name="msapplication-TileColor" content="#667eea">
        <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/android-chrome-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/android-chrome-512x512.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        
        <!-- Preconnect for Performance -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- JSON-LD Structured Data -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebApplication",
            "name": "{{ config('app.name', 'PeekTheLink') }}",
            "description": "Create beautiful link-in-bio pages with PeekTheLink. Share all your important links in one stunning, mobile-optimized landing page.",
            "url": "{{ config('app.url') }}",
            "logo": "{{ asset('images/peek-logo.png') }}",
            "sameAs": [
                "{{ $socialMedia['facebook'] ?? '' }}",
                "{{ $socialMedia['twitter'] ?? '' }}",
                "{{ $socialMedia['instagram'] ?? '' }}",
                "{{ $socialMedia['linkedin'] ?? '' }}"
            ],
            "applicationCategory": "Social Media Tool",
            "operatingSystem": "Web",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "USD",
                "availability": "https://schema.org/InStock"
            },
            "creator": {
                "@type": "Organization",
                "name": "{{ config('app.name', 'PeekTheLink') }}",
                "url": "{{ config('app.url') }}"
            }
        }
        </script>
        
        <!-- Additional Custom Head Content -->
        @stack('head')
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom Styles -->
        <style>
            /* Prevent flash of unstyled content */
            html { visibility: hidden; opacity: 0; }
            html.loaded { visibility: visible; opacity: 1; transition: opacity 0.3s ease-in-out; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <!-- Footer Scripts -->
        @stack('scripts')
        
        <!-- Initialize -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.documentElement.classList.add('loaded');
            });
        </script>
        
        <!-- Analytics placeholder -->
        @if(config('app.env') === 'production')
            <!-- Add your analytics code here -->
        @endif
    </body>
</html>