<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PeekTheLink - Your All-in-One Link-in-Bio Solution</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% 200%;
            animation: gradient-shift 3s ease-in-out infinite;
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        
        .floating {
            animation: floating 6s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translate(0, 0px); }
            50% { transform: translate(0, -20px); }
            100% { transform: translate(0, -0px); }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
        .stagger-6 { animation-delay: 0.6s; }
        
        .pulse-slow {
            animation: pulse-slow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.3);
            transition: box-shadow 0.3s ease;
        }
        
        .glow:hover {
            box-shadow: 0 0 40px rgba(139, 92, 246, 0.6);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .typing {
            overflow: hidden;
            border-right: 2px solid #667eea;
            white-space: nowrap;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }
        
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: #667eea; }
        }

        .blob {
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: blob-morph 10s infinite, blob-move 20s infinite;
        }

        @keyframes blob-morph {
            0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            25% { border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%; }
            50% { border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%; }
            75% { border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%; }
        }

        @keyframes blob-move {
            0%, 100% { transform: translateX(0) translateY(0) rotate(0deg); }
            33% { transform: translateX(30px) translateY(-50px) rotate(120deg); }
            66% { transform: translateX(-20px) translateY(20px) rotate(240deg); }
        }
    </style>
</head>
<body class="font-inter antialiased">
    <!-- Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-72 h-72 blob opacity-10"></div>
        <div class="absolute top-1/2 right-10 w-96 h-96 blob opacity-5" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-10 left-1/3 w-64 h-64 blob opacity-8" style="animation-delay: -4s;"></div>
    </div>
    
    <!-- Navigation -->
    <nav class="relative z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl flex items-center justify-center glow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-2xl font-bold gradient-text">PeekTheLink</span>
                    </div>
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="#features" class="text-gray-600 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Features</a>
                        <a href="#how-it-works" class="text-gray-600 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">How it Works</a>
                        <a href="#demo" class="text-gray-600 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Demo</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-2 px-6 rounded-full transition duration-300 transform hover:scale-105 glow">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-gray-600 hover:text-purple-600 px-4 py-2 text-sm font-medium transition-colors duration-200">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold py-2 px-6 rounded-full transition duration-300 transform hover:scale-105 glow">
                            Start Free
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <!-- Hero Title -->
                <h1 class="text-5xl md:text-7xl font-black text-gray-900 mb-6 fade-in-up">
                    Share
                    <span class="gradient-text">Everything</span>
                    <br>
                    <span class="typing inline-block">In One Link</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto fade-in-up stagger-2">
                    Create a stunning landing page that showcases all your content. Perfect for creators, businesses, and influencers. <strong>Completely free, forever.</strong>
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16 fade-in-up stagger-3">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105 glow">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-full text-lg transition duration-300 transform hover:scale-105 glow">
                            Start Building Free
                        </a>
                        <a href="#demo" 
                           class="bg-white/80 backdrop-blur-sm hover:bg-white text-gray-800 font-bold py-4 px-8 rounded-full text-lg border-2 border-gray-200 hover:border-purple-300 transition duration-300 transform hover:scale-105">
                            See Demo
                        </a>
                    @endauth
                </div>
                
                <!-- Free Badge -->
                <div class="mb-8 fade-in-up stagger-4">
                    <span class="inline-flex items-center px-6 py-3 rounded-full text-lg font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        100% Free Forever - No Hidden Fees
                    </span>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto fade-in-up stagger-5">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">15K+</div>
                        <div class="text-gray-600">Happy Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">750K+</div>
                        <div class="text-gray-600">Links Created</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">2M+</div>
                        <div class="text-gray-600">Clicks Tracked</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Floating Phone Mockup -->
        <div class="absolute right-10 top-1/2 transform -translate-y-1/2 floating hidden xl:block">
            <div class="w-80 h-full bg-gradient-to-br from-purple-100 to-blue-100 rounded-3xl p-8 shadow-2xl">
                <div class="bg-white rounded-2xl h-full p-6 shadow-lg">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-xl font-bold pulse-slow">
                            JD
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">@johndoe</h3>
                        <p class="text-sm text-gray-600 mb-6">Content Creator</p>
                        
                        <div class="space-y-3">
                            <div class="hover:cursor-pointer bg-gradient-to-r from-purple-500 to-blue-500 text-white py-3 px-4 rounded-lg text-sm font-medium transform hover:scale-105 transition duration-200">
                                🌐 My Website
                            </div>
                            <div class="hover:cursor-pointer bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 px-4 rounded-lg text-sm font-medium transform hover:scale-105 transition duration-200">
                                📸 Instagram
                            </div>
                            <div class="hover:cursor-pointer bg-gradient-to-r from-red-500 to-pink-500 text-white py-3 px-4 rounded-lg text-sm font-medium transform hover:scale-105 transition duration-200">
                                🎥 YouTube
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Powerful Features for
                    <span class="gradient-text">Modern Creators</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Everything you need to showcase your content and grow your audience - completely free
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg card-hover">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6 pulse-slow">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Unlimited Links</h3>
                    <p class="text-gray-600 mb-6">Add as many links as you want. No restrictions, no limits. Share everything that matters to your audience - all for free.</p>
                    <div class="flex items-center text-purple-600 font-semibold">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Always Free
                        </span>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg card-hover">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mb-6 pulse-slow">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Advanced Analytics</h3>
                    <p class="text-gray-600 mb-6">Track every click, understand your audience, and optimize your content strategy with detailed insights - no premium required.</p>
                    <div class="flex items-center text-green-600 font-semibold">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Always Free
                        </span>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg card-hover">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 pulse-slow">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 21h10a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a4 4 0 01-4 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Custom Themes</h3>
                    <p class="text-gray-600 mb-6">Personalize your page with beautiful themes, custom colors, and your own branding elements - all included free.</p>
                    <div class="flex items-center text-pink-600 font-semibold">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Always Free
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Get Started in
                    <span class="gradient-text">3 Simple Steps</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Create your PeekTheLink page in minutes, not hours - and it's completely free
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold shadow-2xl pulse-slow glow">
                            1
                        </div>
                        <div class="absolute -top-4 -right-4 w-8 h-8 bg-yellow-400 rounded-full animate-bounce"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Create Free Account</h3>
                    <p class="text-gray-600 text-lg">Sign up for free and choose your unique username that represents your brand. No credit card required.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-teal-500 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold shadow-2xl pulse-slow glow">
                            2
                        </div>
                        <div class="absolute -top-4 -right-4 w-8 h-8 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Add Your Links</h3>
                    <p class="text-gray-600 text-lg">Add unlimited links to your social media, website, store, portfolio, and anything else you want to share.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-pink-500 to-red-500 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold shadow-2xl pulse-slow glow">
                            3
                        </div>
                        <div class="absolute -top-4 -right-4 w-8 h-8 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 1s;"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Share & Grow</h3>
                    <p class="text-gray-600 text-lg">Use your PeekTheLink URL everywhere and watch your audience engage with all your content for free.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-20 bg-gradient-to-br from-purple-100 to-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    See It In
                    <span class="gradient-text">Action</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    This is what your PeekTheLink page will look like - completely free
                </p>
            </div>
            
            <div class="max-w-sm mx-auto">
                <div class="bg-white rounded-3xl p-8 shadow-2xl card-hover">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full mx-auto mb-6 flex items-center justify-center text-white text-2xl font-bold pulse-slow">
                            JD
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">@johndoe</h3>
                        <p class="text-gray-600 mb-6">Content Creator & Designer</p>
                        
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-purple-500 to-blue-500 text-white py-4 px-6 rounded-xl text-lg font-semibold transform hover:scale-105 transition duration-300 cursor-pointer glow">
                                🌐 My Website
                            </div>
                            <div class="bg-gradient-to-r from-pink-500 to-purple-500 text-white py-4 px-6 rounded-xl text-lg font-semibold transform hover:scale-105 transition duration-300 cursor-pointer glow">
                                📸 Instagram
                            </div>
                            <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white py-4 px-6 rounded-xl text-lg font-semibold transform hover:scale-105 transition duration-300 cursor-pointer glow">
                                🎥 YouTube Channel
                            </div>
                            <div class="bg-gradient-to-r from-green-500 to-teal-500 text-white py-4 px-6 rounded-xl text-lg font-semibold transform hover:scale-105 transition duration-300 cursor-pointer glow">
                                🛍️ Online Store
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Free Forever Section -->
    <section class="py-20 bg-gradient-to-br from-green-50 to-emerald-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Why Is PeekTheLink
                    <span class="gradient-text">Completely Free?</span>
                </h2>
                <p class="text-xl text-gray-600 mb-12">
                    We believe everyone should have access to powerful link-in-bio tools, regardless of budget. No hidden fees, no premium tiers, no limitations.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-green-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No Hidden Costs</h3>
                        <p class="text-gray-600">Every feature is included free forever. No surprise charges.</p>
                    </div>
                    
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No Limitations</h3>
                        <p class="text-gray-600">Unlimited links, unlimited clicks, unlimited possibilities.</p>
                    </div>
                    
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
                        <div class="w-12 h-12 bg-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">No Ads</h3>
                        <p class="text-gray-600">Clean, professional pages with no advertisements or branding.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-purple-600 to-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Ready to Get Started?
            </h2>
            <p class="text-xl md:text-2xl text-purple-100 mb-12 max-w-3xl mx-auto">
                Join thousands of creators who are already using PeekTheLink to grow their audience - completely free
            </p>
            
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="bg-white text-purple-600 hover:bg-gray-100 font-bold py-4 px-12 rounded-full text-xl transition duration-300 transform hover:scale-105 inline-block shadow-2xl">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" 
                   class="bg-white text-purple-600 hover:bg-gray-100 font-bold py-4 px-12 rounded-full text-xl transition duration-300 transform hover:scale-105 inline-block shadow-2xl">
                    Start Building for Free
                </a>
            @endauth
            
            <div class="mt-8">
                <p class="text-purple-200 text-lg">
                    ✓ No credit card required &nbsp;•&nbsp; ✓ Free forever &nbsp;•&nbsp; ✓ Setup in 2 minutes
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl flex items-center justify-center glow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-3xl font-bold gradient-text">PeekTheLink</span>
                </div>
                <p class="text-gray-400 text-lg mb-8">
                    Made with ❤️ for creators, influencers, and businesses worldwide
                </p>
                <p class="text-gray-500">
                    &copy; {{ date('Y') }} PeekTheLink. All rights reserved. Forever free.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add intersection observer for animations
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

        // Observe all elements with fade-in-up class
        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>