@extends('layouts.guest')

@section('content')
<style>
    * { font-family: 'Inter', sans-serif; }
    
    /* Premium animations */
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-10px) rotate(1deg); }
        66% { transform: translateY(5px) rotate(-1deg); }
    }
    
    @keyframes pulse-ring {
        0% { transform: scale(0.8); opacity: 1; }
        100% { transform: scale(2.4); opacity: 0; }
    }
    
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    @keyframes morphing {
        0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
        50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
    }
    
    @keyframes particle-float {
        0%, 100% { transform: translateY(0px) translateX(0px); opacity: 0.7; }
        25% { transform: translateY(-20px) translateX(10px); opacity: 1; }
        50% { transform: translateY(-10px) translateX(-5px); opacity: 0.8; }
        75% { transform: translateY(-15px) translateX(8px); opacity: 0.9; }
    }
    
    .shimmer {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        background-size: 1000px 100%;
        animation: shimmer 3s infinite;
    }
    
    .floating { animation: float 6s ease-in-out infinite; }
    .floating-delayed { animation: float 6s ease-in-out infinite 2s; }
    .floating-delayed-2 { animation: float 6s ease-in-out infinite 4s; }
    
    .gradient-animate {
        background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
        background-size: 400% 400%;
        animation: gradient-shift 8s ease infinite;
    }
    
    .morphing-blob {
        animation: morphing 8s ease-in-out infinite;
    }
    
    .glass-effect {
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .input-glow:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1), 0 0 20px rgba(99, 102, 241, 0.3);
    }
    
    .button-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        position: relative;
        overflow: hidden;
    }
    
    .button-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }
    
    .button-premium:hover::before {
        left: 100%;
    }
    
    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
    }
    
    .particle:nth-child(1) { top: 20%; left: 10%; animation: particle-float 4s infinite; }
    .particle:nth-child(2) { top: 60%; left: 20%; animation: particle-float 6s infinite 1s; }
    .particle:nth-child(3) { top: 40%; left: 80%; animation: particle-float 5s infinite 2s; }
    .particle:nth-child(4) { top: 80%; left: 70%; animation: particle-float 7s infinite 3s; }
    .particle:nth-child(5) { top: 30%; left: 60%; animation: particle-float 4.5s infinite 0.5s; }
    
    .logo-glow {
        filter: drop-shadow(0 10px 20px rgba(99, 102, 241, 0.3));
    }
    
    .text-gradient {
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .premium-border {
        position: relative;
    }
    
    .premium-border::before {
        content: '';
        position: absolute;
        inset: 0;
        padding: 2px;
        background: linear-gradient(135deg, #667eea, #764ba2, #f093fb);
        border-radius: inherit;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
    }
    
    .stats-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

<div class="min-h-screen flex relative overflow-hidden">
    <!-- Background particles for the entire page -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Left Side - Premium Login Form -->
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 relative z-10">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <!-- Premium Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-20 w-20 relative mb-6">
                    <!-- Animated rings around logo -->
                    <div class="absolute inset-0 rounded-full border-2 border-indigo-300 opacity-30"></div>
                    <div class="absolute inset-2 rounded-full border-2 border-purple-300 opacity-40 animate-spin"></div>
                    <div class="absolute inset-4 rounded-full border-2 border-pink-300 opacity-20 animate-ping"></div>
                    
                    <div class="relative h-full w-full bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 rounded-2xl flex items-center justify-center logo-glow">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                </div>
                
                <h2 class="text-4xl font-black text-gradient mb-3">
                    Welcome Back
                </h2>
                <p class="text-lg text-gray-600 font-medium">
                    Access your premium PeekTheLink workspace
                </p>
                
                <!-- Trust indicators -->
                <div class="flex items-center justify-center space-x-4 mt-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                        <span>99.9% Uptime</span>
                    </div>
                    <div class="w-px h-4 bg-gray-300"></div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span>Enterprise Grade</span>
                    </div>
                </div>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Premium Form Card -->
            <div class="premium-border rounded-2xl p-8 glass-effect">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address with enhanced styling -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-3">
                            Email Address
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   value="{{ old('email') }}"
                                   class="block w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:border-indigo-500 input-glow transition-all duration-300 text-lg font-medium bg-white/50 backdrop-blur-sm @error('email') border-red-500 @enderror"
                                   placeholder="Enter your email address">
                            <!-- Shimmer effect overlay -->
                            <div class="absolute inset-0 shimmer opacity-0 group-focus-within:opacity-100 rounded-xl pointer-events-none"></div>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password with enhanced styling -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-3">
                            Password
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input id="password" 
                                   name="password" 
                                   type="password" 
                                   required 
                                   autocomplete="current-password"
                                   class="block w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:border-indigo-500 input-glow transition-all duration-300 text-lg font-medium bg-white/50 backdrop-blur-sm @error('password') border-red-500 @enderror"
                                   placeholder="Enter your password">
                            <!-- Password visibility toggle -->
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePassword()">
                                    <svg id="passwordHide" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg id="passwordShow" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464a11.1 11.1 0 00-2.597 2.775M9.878 9.878l-.637-.775a11.04 11.04 0 016.5-.775M15.878 15.878l3.674 3.674a11.073 11.073 0 00-2.597-2.775"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="absolute inset-0 shimmer opacity-0 group-focus-within:opacity-100 rounded-xl pointer-events-none"></div>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Enhanced options -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" 
                                   name="remember" 
                                   type="checkbox" 
                                   class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-all duration-200 cursor-pointer">
                            <label for="remember_me" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                                Keep me signed in
                            </label>
                        </div>

                        <div class="text-sm">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition duration-200 relative group">
                                    Reset password
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Premium Submit Button -->
                    <div>
                        <button type="submit" 
                                class="group relative w-full flex justify-center py-4 px-6 border border-transparent rounded-xl text-lg font-semibold text-white button-premium focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                                <svg class="h-6 w-6 text-white/80 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                            </span>
                            <span class="relative z-10">Access PeekTheLink Pro</span>
                        </button>
                    </div>

                    <!-- Security badge -->
                    <div class="flex items-center justify-center text-xs text-gray-500 space-x-2">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>256-bit SSL encryption</span>
                        <span>•</span>
                        <span>SOC 2 compliant</span>
                    </div>

                    <!-- Register Link with premium styling -->
                    <div class="text-center pt-4">
                        <p class="text-sm text-gray-600">
                            New to PeekTheLink Pro?
                            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition duration-200 relative group ml-1">
                                Start your free trial
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Side - Premium Illustration -->
    <div class="hidden lg:block relative w-0 flex-1">
        <div class="absolute inset-0 gradient-animate">
            <!-- Enhanced decorative elements -->
            <div class="absolute inset-0 bg-black/10"></div>
            
            <!-- Floating geometric shapes -->
            <div class="absolute top-20 left-20 w-32 h-32 bg-white/20 rounded-full blur-xl floating"></div>
            <div class="absolute bottom-32 right-32 w-40 h-40 bg-white/10 morphing-blob floating-delayed"></div>
            <div class="absolute top-1/3 right-1/4 w-24 h-24 bg-white/15 rounded-full blur-lg floating-delayed-2"></div>
            <div class="absolute bottom-1/4 left-1/3 w-28 h-28 bg-white/10 rounded-full blur-xl floating"></div>
            
            <!-- Premium content -->
            <div class="relative h-full flex flex-col justify-center items-center text-center px-12">
                <div class="max-w-lg">
                    <!-- Premium badge -->
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 glass-effect text-white text-sm font-semibold mb-8">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full mr-2 animate-pulse"></span>
                        Enterprise Ready Platform
                    </div>
                    
                    <h3 class="text-5xl font-black text-white mb-6 leading-tight">
                        Your Digital
                        <span class="block bg-gradient-to-r from-yellow-300 to-pink-300 bg-clip-text text-transparent">
                            Empire
                        </span>
                    </h3>
                    
                    <p class="text-xl text-white/90 mb-12 leading-relaxed font-medium">
                        Advanced analytics, custom domains, team collaboration, and enterprise integrations. Everything you need to scale your digital presence.
                    </p>
                    
                    <!-- Premium stats -->
                    <div class="grid grid-cols-2 gap-6 mb-12">
                        <div class="stats-card rounded-2xl p-6 text-left">
                            <div class="text-3xl font-black text-white mb-2">99.9%</div>
                            <div class="text-white/80 text-sm font-medium">Uptime SLA</div>
                        </div>
                        <div class="stats-card rounded-2xl p-6 text-left">
                            <div class="text-3xl font-black text-white mb-2">10M+</div>
                            <div class="text-white/80 text-sm font-medium">Links Served</div>
                        </div>
                        <div class="stats-card rounded-2xl p-6 text-left">
                            <div class="text-3xl font-black text-white mb-2">500+</div>
                            <div class="text-white/80 text-sm font-medium">Enterprise Clients</div>
                        </div>
                        <div class="stats-card rounded-2xl p-6 text-left">
                            <div class="text-3xl font-black text-white mb-2">24/7</div>
                            <div class="text-white/80 text-sm font-medium">Premium Support</div>
                        </div>
                    </div>
                    
                    <!-- Trust indicators -->
                    <div class="flex items-center justify-center space-x-8 opacity-60">
                        <div class="text-white text-sm font-semibold">SOC 2</div>
                        <div class="text-white text-sm font-semibold">GDPR</div>
                        <div class="text-white text-sm font-semibold">ISO 27001</div>
                        <div class="text-white text-sm font-semibold">HIPAA</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Password visibility toggle
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const hideIcon = document.getElementById('passwordHide');
        const showIcon = document.getElementById('passwordShow');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            hideIcon.classList.add('hidden');
            showIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            hideIcon.classList.remove('hidden');
            showIcon.classList.add('hidden');
        }
    }

    // Add premium interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Clear errors when user starts typing
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('border-indigo-500');
                this.classList.remove('border-gray-200', 'border-red-500');
                this.parentElement.classList.add('scale-[1.02]');
            });
            
            input.addEventListener('blur', function() {
                if (!this.classList.contains('border-red-500')) {
                    this.classList.remove('border-indigo-500');
                    this.classList.add('border-gray-200');
                }
                this.parentElement.classList.remove('scale-[1.02]');
            });
        });
        
        // Button click ripple effect
        const button = document.querySelector('button[type="submit"]');
        button.addEventListener('click', function(e) {
            if (e.target.closest('button')) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255,255,255,0.6);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }
        });
        
        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection