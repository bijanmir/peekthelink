<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LinkBio - Your All-in-One Link-in-Bio Solution</title>
    
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
        
        .blob {
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: blob 7s infinite;
        }
        
        @keyframes blob {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: translate(0px, 0px) scale(1); }
            14% { border-radius: 70% 30% 50% 50% / 30% 60% 40% 70%; transform: translate(30px, -50px) scale(1.1); }
            28% { border-radius: 50% 50% 30% 70% / 60% 30% 70% 40%; transform: translate(-20px, 20px) scale(0.9); }
            42% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: translate(50px, -20px) scale(1.2); }
            56% { border-radius: 70% 30% 50% 50% / 30% 60% 40% 70%; transform: translate(-30px, 10px) scale(0.8); }
            70% { border-radius: 50% 50% 30% 70% / 60% 30% 70% 40%; transform: translate(0px, -30px) scale(1.1); }
            84% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: translate(20px, 20px) scale(0.9); }
            100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: translate(0px, 0px) scale(1); }
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-2xl font-bold gradient-text">LinkBio</span>
                    </div>
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="#features" class="text-gray-600 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Features</a>
                        <a href="#how-it-works" class="text-gray-600 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">How it Works</a>
                        <a href="#pricing" class="text-gray-600 hover:text-purple-600 px-3 py-2 text-sm font-medium transition-colors duration-200">Pricing</a>
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
                            Get Started Free
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
                    Create a stunning landing page that showcases all your content. Perfect for creators, businesses, and influencers.
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
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto fade-in-up stagger-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">10K+</div>
                        <div class="text-gray-600">Active Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">500K+</div>
                        <div class="text-gray-600">Links Created</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">1M+</div>
                        <div class="text-gray-600">Clicks Tracked</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Floating Phone Mockup -->
        <div class="absolute right-10 top-1/2 transform -translate-y-1/2 floating hidden xl:block">
            <div class="w-80 h-96 bg-gradient-to-br from-purple-100 to-blue-100 rounded-3xl p-8 shadow-2xl">
                <div class="bg-white rounded-2xl h-full p-6 shadow-lg">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-xl font-bold pulse-slow">
                            JD
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">@johndoe</h3>
                        <p class="text-sm text-gray-600 mb-6">Content Creator</p>
                        
                        <div class="space-y-3">
                            <div class="bg-gradient-to-r from-purple-500 to-blue-500 text-white py-3 px-4 rounded-lg text-sm font-medium transform hover:scale-105 transition duration-200">
                                🌐 My Website
                            </div>
                            <div class="bg-gradient-to-r from-pink-500 to-purple-500 text-white py-3 px-4 rounded-lg text-sm font-medium transform hover:scale-105 transition duration-200">
                                📸 Instagram
                            </div>
                            <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white py-3 px-4 rounded-lg text-sm font-medium transform hover:scale-105 transition duration-200">
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
                    Everything you need to showcase your content and grow your audience
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
                    <p class="text-gray-600 mb-6">Add as many links as you want. No restrictions, no limits. Share everything that matters to your audience.</p>
                    <div class="flex items-center text-purple-600 font-semibold">
                        <span>Learn more</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
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
                    <p class="text-gray-600 mb-6">Track every click, understand your audience, and optimize your content strategy with detailed insights.</p>
                    <div class="flex items-center text-green-600 font-semibold">
                        <span>Learn more</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
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
                    <p class="text-gray-600 mb-6">Personalize your page with beautiful themes, custom colors, and your own branding elements.</p>
                    <div class="flex items-center text-pink-600 font-semibold">
                        <span>Learn more</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
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
                    Create your LinkBio page in minutes, not hours
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
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Create Account</h3>
                    <p class="text-gray-600 text-lg">Sign up for free and choose your unique username that represents your brand.</p>
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
                    <p class="text-gray-600 text-lg">Add links to your social media, website, store, portfolio, and anything else you want to share.</p>
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
                    <p class="text-gray-600 text-lg">Use your LinkBio URL everywhere and watch your audience engage with all your content.</p>
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
                    This is what your LinkBio page will look like
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

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-purple-600 to-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Ready to Get Started?
            </h2>
            <p class="text-xl md:text-2xl text-purple-100 mb-12 max-w-3xl mx-auto">
                Join thousands of creators who are already using LinkBio to grow their audience
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
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl flex items-center justify-center glow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-3xl font-bold gradient-text">LinkBio</span>
                </div>
                <p class="text-gray-400 text-lg mb-8">
                    Made with ❤️ for creators, influencers, and businesses worldwide
                </p>
                <p class="text-gray-500">
                    &copy; {{ date('Y') }} LinkBio. All rights reserved.
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