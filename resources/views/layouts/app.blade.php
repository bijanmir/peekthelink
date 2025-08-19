<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Primary Meta Tags -->
    <title>{{ $title ?? config('app.name', 'PeekTheLink') }}</title>
    <meta name="title" content="{{ $title ?? config('app.name', 'PeekTheLink') }}">
    <meta name="description" content="{{ $description ?? 'Create beautiful link-in-bio pages with PeekTheLink. Share all your important links in one stunning, mobile-optimized landing page.' }}">
    <meta name="keywords" content="{{ $keywords ?? 'link in bio, social media links, landing page, linktree alternative' }}">
    <meta name="author" content="PeekTheLink">
    <meta name="robots" content="index, follow">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? config('app.name', 'PeekTheLink') }}">
    <meta property="og:description" content="{{ $description ?? 'Create beautiful link-in-bio pages with PeekTheLink.' }}">
    <meta property="og:image" content="{{ asset('images/peek-logo.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ config('app.name', 'PeekTheLink') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? config('app.name', 'PeekTheLink') }}">
    <meta property="twitter:description" content="{{ $description ?? 'Create beautiful link-in-bio pages with PeekTheLink.' }}">
    <meta property="twitter:image" content="{{ asset('images/peek-logo.png') }}">
    
    <!-- Theme -->
    <meta name="theme-color" content="#667eea">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Head Content -->
    @stack('head')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

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
            document.documentElement.style.visibility = 'visible';
        });
    </script>
</body>
</html>