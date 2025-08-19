<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Primary Meta Tags -->
    <title>{{ $title ?? config('app.name', 'PeekTheLink') . ' - Create Your Perfect Link in Bio Page' }}</title>
    <meta name="title" content="{{ $title ?? config('app.name', 'PeekTheLink') . ' - Create Your Perfect Link in Bio Page' }}">
    <meta name="description" content="{{ $description ?? 'Join thousands of creators using PeekTheLink to share all their important links in one beautiful, mobile-optimized page. Free to start, easy to customize.' }}">
    <meta name="keywords" content="{{ $keywords ?? 'link in bio, linktree alternative, bio link tool, social media links, landing page creator' }}">
    <meta name="author" content="PeekTheLink">
    <meta name="robots" content="index, follow">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? config('app.name', 'PeekTheLink') . ' - Create Your Perfect Link in Bio Page' }}">
    <meta property="og:description" content="{{ $description ?? 'Join thousands of creators using PeekTheLink to share all their important links in one beautiful page.' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/peek-logo.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ config('app.name', 'PeekTheLink') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? config('app.name', 'PeekTheLink') . ' - Create Your Perfect Link in Bio Page' }}">
    <meta property="twitter:description" content="{{ $description ?? 'Join thousands of creators using PeekTheLink to share all their important links.' }}">
    <meta property="twitter:image" content="{{ $ogImage ?? asset('images/peek-logo.png') }}">
    
    <!-- Theme -->
    <meta name="theme-color" content="#667eea">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Structured Data for Profile Pages -->
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
            "url": "{{ route('profile.show', $user->username) }}"
        }
    }
    </script>
    @endif
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Head Content -->
    @stack('head')
    
    <!-- Performance Styles -->
    <style>
        html { visibility: hidden; opacity: 0; }
        html.loaded { visibility: visible; opacity: 1; transition: opacity 0.3s ease-in-out; }
    </style>
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
    
    <!-- Initialize -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('loaded');
        });
    </script>
</body>
</html>