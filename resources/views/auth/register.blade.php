@extends('layouts.guest')

@section('content')
<style>
    * { font-family: 'Inter', sans-serif; }
    
    /* Dynamic Professional Gradient Rays Background */
    .gradient-rays {
        background: 
            conic-gradient(from 45deg at 20% 80%, 
                transparent 0deg, 
                rgba(139, 92, 246, 0.08) 45deg,
                rgba(59, 130, 246, 0.06) 90deg, 
                transparent 135deg,
                rgba(167, 139, 250, 0.04) 180deg,
                transparent 225deg,
                rgba(79, 70, 229, 0.05) 270deg,
                transparent 315deg
            ),
            conic-gradient(from 225deg at 80% 20%, 
                transparent 0deg, 
                rgba(167, 139, 250, 0.06) 45deg,
                rgba(139, 92, 246, 0.04) 90deg, 
                transparent 135deg,
                rgba(59, 130, 246, 0.08) 180deg,
                transparent 225deg,
                rgba(79, 70, 229, 0.03) 270deg,
                transparent 315deg
            ),
            conic-gradient(from 135deg at 50% 50%, 
                transparent 0deg, 
                rgba(139, 92, 246, 0.02) 60deg,
                transparent 120deg,
                rgba(59, 130, 246, 0.03) 180deg,
                transparent 240deg,
                rgba(167, 139, 250, 0.02) 300deg,
                transparent 360deg
            );
        animation: rays-rotate 40s linear infinite;
    }
    
    @keyframes rays-rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .professional-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 8px 16px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .enhanced-glow {
        box-shadow: 
            0 0 20px rgba(139, 92, 246, 0.3),
            0 0 40px rgba(59, 130, 246, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    .enhanced-glow:hover {
        box-shadow: 
            0 0 30px rgba(139, 92, 246, 0.5),
            0 0 60px rgba(59, 130, 246, 0.2),
            0 0 100px rgba(167, 139, 250, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .premium-input {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        border: 2px solid rgba(59, 130, 246, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .premium-input:focus {
        background: rgba(255, 255, 255, 0.95);
        border-color: rgba(139, 92, 246, 0.5);
        box-shadow: 
            0 0 0 4px rgba(139, 92, 246, 0.1),
            0 8px 16px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .premium-button {
        background: linear-gradient(135deg, #8b5cf6, #6366f1, #3b82f6);
        box-shadow: 
            0 8px 24px rgba(139, 92, 246, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .premium-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .premium-button:hover::before {
        left: 100%;
    }
    
    .premium-button:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 12px 32px rgba(139, 92, 246, 0.4),
            0 4px 12px rgba(59, 130, 246, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .premium-button:active {
        transform: translateY(-1px);
    }

    .success-checkmark {
        stroke-dasharray: 16;
        stroke-dashoffset: 16;
        animation: checkmark 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    @keyframes checkmark {
        to { stroke-dashoffset: 0; }
    }

    .slide-up {
        animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    
    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }

    .password-strength {
        height: 3px;
        border-radius: 2px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .strength-weak { background: linear-gradient(90deg, #ef4444, #f87171); width: 25%; }
    .strength-fair { background: linear-gradient(90deg, #f59e0b, #fbbf24); width: 50%; }
    .strength-good { background: linear-gradient(90deg, #10b981, #34d399); width: 75%; }
    .strength-strong { background: linear-gradient(90deg, #059669, #10b981); width: 100%; }

    .form-step {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-step.slide-out {
        opacity: 0;
        transform: translateX(-50px);
    }

    .form-step.slide-in {
        opacity: 1;
        transform: translateX(0);
    }

    .gradient-text {
        background: linear-gradient(135deg, #8b5cf6, #6366f1, #3b82f6);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Responsive improvements */
    @media (max-height: 700px) {
        .form-container {
            padding: 1rem 0;
        }
        .professional-card {
            padding: 1.5rem;
        }
        .step-header {
            margin-bottom: 1.5rem;
        }
    }

    @media (max-height: 600px) {
        .professional-card {
            padding: 1rem;
        }
        .step-header {
            margin-bottom: 1rem;
        }
        .form-field {
            margin-bottom: 1rem;
        }
    }

    /* Smooth scrolling for better UX */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(139, 92, 246, 0.3);
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(139, 92, 246, 0.5);
    }
</style>

<!-- Dynamic Background -->
<div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute inset-0 gradient-rays"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50/10 via-transparent to-blue-50/10"></div>
</div>

<!-- Main Container -->
<div class="relative z-10 min-h-screen flex flex-col">
    
    <!-- Header -->
    <header class="flex-shrink-0 p-4 sm:p-6">
        <div class="flex items-center justify-between max-w-6xl mx-auto">
            <!-- Logo -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <div class="w-8 h-8 sm:w-10 sm:h-10 ">
                    <img src="images/peek-logo.png" alt="">
                </div>

            <!-- Step 2: Success -->
            <div id="step2" class="form-step hidden">
                <div class="text-center slide-up">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 professional-card rounded-full mx-auto mb-6 flex items-center justify-center enhanced-glow">
                        <svg class="h-8 h-8 sm:h-10 sm:w-10 text-emerald-600 success-checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl font-bold gradient-text mb-3">Welcome to PeekTheLink!</h1>
                    <p class="text-gray-600 text-base sm:text-lg font-medium mb-8">Your account has been created successfully</p>
                    
                    <div class="professional-card rounded-2xl p-4 sm:p-6 shadow-2xl">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Your PeekTheLink is ready!</h3>
                        <div class="professional-card rounded-xl p-4 mb-6 bg-gradient-to-r from-emerald-50/80 to-green-50/80">
                            <p class="text-sm text-gray-600 mb-1">Your unique URL:</p>
                            <p class="text-base sm:text-lg font-bold text-emerald-600" id="finalUrl">peekthelink.com/username</p>
                        </div>
                        
                        <div class="space-y-3">
                            <button onclick="goToDashboard()" class="w-full premium-button text-white font-bold py-3 px-6 rounded-xl enhanced-glow text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Go to Dashboard
                            </button>
                            <button onclick="copyUrl()" class="w-full professional-card hover:bg-gray-50 text-gray-700 font-semibold py-3 px-6 rounded-xl transition-colors text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy My URL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
                <span class="text-lg sm:text-2xl font-bold gradient-text">PeekTheLink</span>
            </div>
            
            <!-- Already have an account link - Mobile responsive -->
            <div class="flex items-center">
                <a href="{{ route('login') }}" 
                   class="text-gray-600 hover:text-purple-600 font-medium transition-colors duration-200 text-sm sm:text-base">
                    <span class="hidden sm:inline">Already have an account?</span>
                    <span class="sm:hidden">Sign In</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 py-4 form-container">
        <div class="w-full max-w-md">
            
            <!-- Step 1: Registration Form -->
            <div id="step1" class="form-step">
                
                <!-- Step Header -->
                <div class="text-center step-header slide-up">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 professional-card rounded-2xl mx-auto mb-4 flex items-center justify-center enhanced-glow">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold gradient-text mb-2">Join PeekTheLink</h1>
                    <p class="text-gray-600 font-medium text-sm sm:text-base">Create your professional presence in minutes</p>
                </div>

                <!-- Registration Form -->
                <div class="professional-card rounded-2xl p-4 sm:p-6 shadow-2xl slide-up stagger-1">
                    <form id="registrationForm" class="space-y-4">
                        
                        <!-- Full Name -->
                        <div class="form-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-4 h-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input id="fullName" type="text" required 
                                       class="premium-input w-full pl-8 sm:pl-10 pr-4 py-2.5 sm:py-3 rounded-xl focus:outline-none text-sm sm:text-base"
                                       placeholder="Enter your full name">
                            </div>
                            <div id="nameError" class="hidden mt-1 text-sm text-red-600"></div>
                        </div>

                        <!-- Username -->
                        <div class="form-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Choose Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <span class="text-purple-600 font-bold text-sm sm:text-base">@</span>
                                </div>
                                <input id="username" type="text" required 
                                       class="premium-input w-full pl-8 sm:pl-10 pr-10 py-2.5 sm:py-3 rounded-xl focus:outline-none text-sm sm:text-base"
                                       placeholder="yourusername"
                                       oninput="checkUsername(this.value)"
                                       minlength="3" maxlength="30">
                                <div id="usernameStatus" class="absolute inset-y-0 right-0 pr-3 flex items-center hidden"></div>
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <p class="text-xs text-gray-500">peekthelink.com/<span id="preview" class="font-semibold text-purple-600">yourusername</span></p>
                                <div id="usernameAvailability" class="text-xs font-semibold"></div>
                            </div>
                            <div id="usernameError" class="hidden mt-1 text-sm text-red-600"></div>
                        </div>

                        <!-- Email -->
                        <div class="form-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-4 h-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input id="email" type="email" required 
                                       class="premium-input w-full pl-8 sm:pl-10 pr-4 py-2.5 sm:py-3 rounded-xl focus:outline-none text-sm sm:text-base"
                                       placeholder="your@email.com"
                                       oninput="validateEmail(this.value)">
                            </div>
                            <div id="emailError" class="hidden mt-1 text-sm text-red-600"></div>
                        </div>

                        <!-- Password -->
                        <div class="form-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Create Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-4 h-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" type="password" required 
                                       class="premium-input w-full pl-8 sm:pl-10 pr-10 py-2.5 sm:py-3 rounded-xl focus:outline-none text-sm sm:text-base"
                                       placeholder="Create password"
                                       oninput="checkPassword(this.value)"
                                       minlength="8">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                                    <svg class="h-4 h-4 sm:h-5 sm:w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-2">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-medium text-gray-600">Strength:</span>
                                    <span id="strengthText" class="font-semibold text-gray-500">Enter password</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1">
                                    <div id="strengthBar" class="password-strength rounded-full h-1"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-field">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-4 h-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input id="confirmPassword" type="password" required 
                                       class="premium-input w-full pl-8 sm:pl-10 pr-4 py-2.5 sm:py-3 rounded-xl focus:outline-none text-sm sm:text-base"
                                       placeholder="Confirm password"
                                       oninput="validatePasswordMatch()">
                            </div>
                            <div id="passwordMatchError" class="hidden mt-1 text-sm text-red-600"></div>
                            <div id="passwordMatch" class="hidden mt-1 text-sm text-emerald-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Passwords match
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="form-field">
                            <div class="professional-card rounded-xl p-3 sm:p-4 bg-gradient-to-r from-purple-50/80 to-blue-50/80">
                                <label class="flex items-start cursor-pointer">
                                    <input id="termsCheckbox" type="checkbox" required 
                                           class="mt-1 h-4 w-4 text-purple-600 border-2 border-gray-300 rounded focus:ring-purple-500">
                                    <span class="ml-3 text-sm text-gray-700 font-medium">
                                        I agree to the 
                                        <a href="#" class="text-purple-600 hover:text-purple-700 underline font-semibold">Terms</a> 
                                        and 
                                        <a href="#" class="text-purple-600 hover:text-purple-700 underline font-semibold">Privacy Policy</a>
                                    </span>
                                </label>
                                <div id="termsError" class="hidden mt-2 text-sm text-red-600"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full premium-button text-white font-bold py-2.5 sm:py-3 px-6 rounded-xl transition-all duration-300 flex items-center justify-center text-sm sm:text-base enhanced-glow">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Create Account
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>

                        <!-- Security Note -->
                        <div class="flex items-center justify-center text-xs text-gray-500 space-x-2 professional-card rounded-lg p-2 sm:p-3">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium text-center">256-bit SSL encrypted • Free forever • No ads</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="flex-shrink-0 p-4 text-center">
        <p class="text-xs sm:text-sm text-gray-500">
            &copy; {{ date('Y') }} PeekTheLink. All rights reserved. Forever free.
        </p>
    </footer>
</div>

<script>
    let registrationData = {};
    let isUsernameAvailable = false;
    
    // Username validation with real API call
    let usernameTimer;
    async function checkUsername(username) {
        const preview = document.getElementById('preview');
        const status = document.getElementById('usernameStatus');
        const availability = document.getElementById('usernameAvailability');
        const error = document.getElementById('usernameError');
        
        preview.textContent = username || 'yourusername';
        
        if (username.length < 3) {
            status.classList.add('hidden');
            availability.textContent = '';
            error.classList.add('hidden');
            isUsernameAvailable = false;
            return;
        }
        
        status.innerHTML = `<div class="animate-spin rounded-full h-4 w-4 border-b-2 border-purple-500"></div>`;
        status.classList.remove('hidden');
        availability.textContent = 'Checking...';
        availability.className = 'text-xs font-semibold text-gray-500';
        isUsernameAvailable = false;
        
        clearTimeout(usernameTimer);
        usernameTimer = setTimeout(async () => {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch('/api/check-username', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token || '',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ username })
                });
                
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                
                const data = await response.json();
                
                if (data.available) {
                    status.innerHTML = `<svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path class="success-checkmark" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                    availability.textContent = 'Available!';
                    availability.className = 'text-xs font-semibold text-emerald-600';
                    error.classList.add('hidden');
                    isUsernameAvailable = true;
                } else {
                    status.innerHTML = `<svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
                    availability.textContent = 'Taken';
                    availability.className = 'text-xs font-semibold text-red-500';
                    
                    let errorMessage = data.message || 'This username is already taken.';
                    if (data.suggested && data.suggested.length > 0) {
                        errorMessage += ` Try: ${data.suggested.slice(0, 2).join(', ')}`;
                    }
                    
                    error.textContent = errorMessage;
                    error.classList.remove('hidden');
                    isUsernameAvailable = false;
                }
            } catch (err) {
                console.error('Username check failed:', err);
                status.innerHTML = `<svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>`;
                availability.textContent = 'Check failed';
                availability.className = 'text-xs font-semibold text-orange-500';
                error.textContent = 'Unable to check username availability. Please try again.';
                error.classList.remove('hidden');
                isUsernameAvailable = false;
            }
        }, 800);
    }
    
    // Email validation
    let emailTimer;
    async function validateEmail(email) {
        const error = document.getElementById('emailError');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        error.classList.add('hidden');
        if (!email) return;
        
        if (!emailRegex.test(email)) {
            error.textContent = 'Please enter a valid email address.';
            error.classList.remove('hidden');
            return;
        }
        
        clearTimeout(emailTimer);
        emailTimer = setTimeout(async () => {
            try {
                const response = await fetch('/api/check-email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ email })
                });
                
                const data = await response.json();
                if (!data.available) {
                    error.textContent = data.message || 'This email is already registered.';
                    error.classList.remove('hidden');
                }
            } catch (err) {
                console.error('Email check failed:', err);
            }
        }, 1000);
    }
    
    // Password strength checker
    function checkPassword(password) {
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        let strength = 0;
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password)
        };
        
        strength = Object.values(requirements).filter(Boolean).length;
        
        const levels = ['', 'strength-weak', 'strength-fair', 'strength-good', 'strength-strong'];
        const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
        const colors = ['', 'text-red-500', 'text-yellow-500', 'text-emerald-500', 'text-emerald-600'];
        
        strengthBar.className = `password-strength rounded-full h-1 transition-all duration-300 ${levels[strength] || ''}`;
        strengthText.textContent = labels[strength] || 'Enter password';
        strengthText.className = `font-semibold ${colors[strength] || 'text-gray-500'}`;
        
        validatePasswordMatch();
    }
    
    // Password match validation
    function validatePasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const error = document.getElementById('passwordMatchError');
        const match = document.getElementById('passwordMatch');
        
        if (confirmPassword) {
            if (password === confirmPassword) {
                error.classList.add('hidden');
                match.classList.remove('hidden');
            } else {
                error.textContent = 'Passwords do not match.';
                error.classList.remove('hidden');
                match.classList.add('hidden');
            }
        } else {
            error.classList.add('hidden');
            match.classList.add('hidden');
        }
    }
    
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }
    
    // Form submission
    document.getElementById('registrationForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        clearAllErrors();
        
        const fullName = document.getElementById('fullName').value.trim();
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const terms = document.getElementById('termsCheckbox').checked;
        
        // Client-side validation
        let hasErrors = false;
        
        if (!fullName) {
            showError('nameError', 'Please enter your full name.');
            hasErrors = true;
        }
        
        if (username.length < 3) {
            showError('usernameError', 'Username must be at least 3 characters long.');
            hasErrors = true;
        } else if (!isUsernameAvailable) {
            showError('usernameError', 'Please choose an available username.');
            hasErrors = true;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            showError('emailError', 'Please enter your email address.');
            hasErrors = true;
        } else if (!emailRegex.test(email)) {
            showError('emailError', 'Please enter a valid email address.');
            hasErrors = true;
        }
        
        if (!password) {
            showError('passwordError', 'Please create a password.');
            hasErrors = true;
        } else if (password.length < 8) {
            showError('passwordError', 'Password must be at least 8 characters long.');
            hasErrors = true;
        }
        
        if (!confirmPassword) {
            showError('passwordMatchError', 'Please confirm your password.');
            hasErrors = true;
        } else if (password !== confirmPassword) {
            showError('passwordMatchError', 'Passwords do not match.');
            hasErrors = true;
        }
        
        if (!terms) {
            showError('termsError', 'You must agree to the Terms of Service and Privacy Policy.');
            hasErrors = true;
        }
        
        if (hasErrors) return;
        
        // Show loading state
        const submitButton = e.target.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = `
            <div class="flex items-center justify-center">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-3"></div>
                Creating Account...
            </div>
        `;
        submitButton.disabled = true;
        
        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            const requestData = {
                fullName,
                username,
                email,
                password,
                password_confirmation: confirmPassword,
                terms: terms ? 1 : 0
            };
            
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(requestData)
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP ${response.status}: ${errorText}`);
            }
            
            const data = await response.json();
            
            if (data.success) {
                registrationData = {
                    fullName,
                    username,
                    email,
                    userId: data.user.id,
                    profileUrl: data.user.profile_url,
                    isAuthenticated: data.auth_status
                };
                
                submitButton.innerHTML = `
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Account Created!
                    </div>
                `;
                
                setTimeout(() => {
                    goToStep2();
                }, 1000);
                
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const messages = data.errors[field];
                        const errorId = getErrorElementId(field);
                        if (errorId) {
                            showError(errorId, messages[0]);
                        }
                    });
                } else {
                    showError('termsError', data.message || 'Registration failed. Please try again.');
                }
                
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
            
        } catch (error) {
            console.error('Registration failed:', error);
            showError('termsError', 'Network error. Please check your connection and try again.');
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }
    });
    
    function getErrorElementId(laravelField) {
        const mapping = {
            'fullName': 'nameError',
            'username': 'usernameError', 
            'email': 'emailError',
            'password': 'passwordError',
            'terms': 'termsError'
        };
        return mapping[laravelField] || null;
    }
    
    function showError(elementId, message) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = message;
            element.classList.remove('hidden');
            const input = element.previousElementSibling?.querySelector('input') || 
                         element.parentElement.querySelector('input');
            if (input) {
                input.classList.add('border-red-500');
                input.classList.remove('border-gray-200');
            }
        }
    }
    
    function clearAllErrors() {
        const errorElements = ['nameError', 'usernameError', 'emailError', 'passwordError', 'passwordMatchError', 'termsError'];
        errorElements.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.classList.add('hidden');
            }
        });
        
        document.querySelectorAll('input').forEach(input => {
            input.classList.remove('border-red-500');
            input.classList.add('border-gray-200');
        });
    }
    
    function goToStep2() {
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        
        step1.classList.add('slide-out');
        
        setTimeout(() => {
            step1.classList.add('hidden');
            step1.classList.remove('slide-out');
            step2.classList.remove('hidden');
            step2.classList.add('slide-in');
            
            document.getElementById('finalUrl').textContent = `peekthelink.com/${registrationData.username}`;
        }, 500);
    }
    
    function copyUrl() {
        const url = document.getElementById('finalUrl').textContent;
        const fullUrl = `https://${url}`;
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(fullUrl).then(() => {
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = `
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Copied!
                `;
                button.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-200');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-emerald-50', 'text-emerald-600', 'border-emerald-200');
                }, 2000);
            });
        }
    }
    
    function goToDashboard() {
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = `
            <div class="flex items-center justify-center">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-3"></div>
                Loading Dashboard...
            </div>
        `;
        button.disabled = true;
        
        fetch('/api/auth-check', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(() => {
            window.location.href = '/dashboard';
        })
        .catch(() => {
            window.location.href = '/dashboard';
        });
    }
    
    // Initialize form interactions
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const errorElement = this.closest('.form-field')?.querySelector('[id$="Error"]');
                if (errorElement) {
                    errorElement.classList.add('hidden');
                    this.classList.remove('border-red-500');
                }
                
                if (this.id === 'username') {
                    isUsernameAvailable = false;
                }
            });
        });
        
        document.getElementById('termsCheckbox').addEventListener('change', function() {
            const error = document.getElementById('termsError');
            if (this.checked && error) {
                error.classList.add('hidden');
            }
        });
    });
</script>
@endsection