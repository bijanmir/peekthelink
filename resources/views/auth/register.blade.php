<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PeekTheLink - Premium Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #059669 25%, #0d9488 50%, #0f766e 75%, #06b6d4 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(-100%); opacity: 0; }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes checkmark {
            0% { stroke-dashoffset: 16; }
            100% { stroke-dashoffset: 0; }
        }
        
        .slide-in { animation: slideIn 0.5s ease-out; }
        .slide-out { animation: slideOut 0.5s ease-out; }
        .pulse-animate { animation: pulse 2s infinite; }
        
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-weak { background: #ef4444; width: 25%; }
        .strength-fair { background: #f59e0b; width: 50%; }
        .strength-good { background: #10b981; width: 75%; }
        .strength-strong { background: #059669; width: 100%; }
        
        .success-checkmark {
            stroke-dasharray: 16;
            stroke-dashoffset: 16;
            animation: checkmark 0.6s ease-out forwards;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: float 6s linear infinite;
        }
        
        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        .premium-button {
            background: linear-gradient(135deg, #10b981, #059669, #0d9488);
            transition: all 0.3s ease;
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .premium-button:hover::before {
            left: 100%;
        }
        
        .premium-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg relative overflow-hidden">
    <!-- Floating Particles Background -->
    <div class="floating-particles">
        <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 1s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 3s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 4s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 5s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 6s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 7s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 8s;"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 py-8 relative z-10">
        <div class="w-full max-w-md">
            <!-- Step 1: Account Setup -->
            <div id="step1" class="step-container">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="mx-auto h-20 w-20 glass-card rounded-3xl flex items-center justify-center mb-6 pulse-animate">
                        <svg class="h-10 w-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-4xl font-black text-white mb-3">Join PeekTheLink</h1>
                    <p class="text-white/90 text-lg font-medium">Create your professional presence in minutes</p>
                    
                    <!-- Progress -->
                    <div class="flex items-center justify-center space-x-3 mt-8">
                        <div class="w-10 h-2 bg-white rounded-full shadow-lg"></div>
                        <div class="w-10 h-2 bg-white/30 rounded-full"></div>
                        <div class="w-10 h-2 bg-white/30 rounded-full"></div>
                    </div>
                    <p class="text-white/70 text-sm mt-3 font-medium">Step 1 of 3 - Account Setup</p>
                </div>

                <!-- Form Card -->
                <div class="glass-card rounded-3xl p-8 shadow-2xl">
                    <form id="registrationForm" class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Full Name</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input id="fullName" type="text" required 
                                       class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-300 text-lg font-medium"
                                       placeholder="Enter your full name">
                                <div id="nameError" class="hidden mt-2 text-sm text-red-600"></div>
                            </div>
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Choose Your Username</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center">
                                    <span class="text-emerald-500 font-bold text-lg">@</span>
                                </div>
                                <input id="username" type="text" required 
                                       class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-300 text-lg font-medium"
                                       placeholder="yourusername"
                                       oninput="checkUsername(this.value)"
                                       minlength="3"
                                       maxlength="30">
                                <div id="usernameStatus" class="absolute inset-y-0 right-0 pr-4 flex items-center hidden">
                                    <!-- Will be populated by JS -->
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <p class="text-sm text-gray-600">peekthelink.com/<span id="preview" class="font-semibold text-emerald-600">yourusername</span></p>
                                <div id="usernameAvailability" class="text-sm font-semibold"></div>
                            </div>
                            <div id="usernameError" class="hidden mt-2 text-sm text-red-600"></div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Email Address</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input id="email" type="email" required 
                                       class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-300 text-lg font-medium"
                                       placeholder="Enter your email address"
                                       oninput="validateEmail(this.value)">
                                <div id="emailError" class="hidden mt-2 text-sm text-red-600"></div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Create Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" type="password" required 
                                       class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-300 text-lg font-medium"
                                       placeholder="Create a strong password"
                                       oninput="checkPassword(this.value)"
                                       minlength="8">
                                <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center" onclick="togglePassword('password')">
                                    <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-3">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="font-medium text-gray-700">Password strength:</span>
                                    <span id="strengthText" class="font-semibold text-gray-500">Enter password</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="strengthBar" class="password-strength rounded-full h-2 transition-all duration-300"></div>
                                </div>
                                <div id="passwordRequirements" class="mt-3 space-y-1 text-xs">
                                    <div id="req-length" class="flex items-center text-gray-500">
                                        <span class="w-4 h-4 mr-2">○</span> At least 8 characters
                                    </div>
                                    <div id="req-uppercase" class="flex items-center text-gray-500">
                                        <span class="w-4 h-4 mr-2">○</span> One uppercase letter
                                    </div>
                                    <div id="req-lowercase" class="flex items-center text-gray-500">
                                        <span class="w-4 h-4 mr-2">○</span> One lowercase letter
                                    </div>
                                    <div id="req-number" class="flex items-center text-gray-500">
                                        <span class="w-4 h-4 mr-2">○</span> One number
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Confirm Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input id="confirmPassword" type="password" required 
                                       class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all duration-300 text-lg font-medium"
                                       placeholder="Confirm your password"
                                       oninput="validatePasswordMatch()">
                            </div>
                            <div id="passwordMatchError" class="hidden mt-2 text-sm text-red-600"></div>
                            <div id="passwordMatch" class="hidden mt-2 text-sm text-emerald-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Passwords match
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="bg-emerald-50/80 border-2 border-emerald-200 rounded-xl p-5">
                            <label class="flex items-start cursor-pointer group">
                                <input id="termsCheckbox" type="checkbox" required 
                                       class="mt-1 h-5 w-5 text-emerald-600 border-2 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2 transition-all duration-200">
                                <span class="ml-4 text-sm text-gray-700 font-medium leading-relaxed">
                                    I agree to the 
                                    <a href="#" class="text-emerald-600 font-semibold hover:text-emerald-700 underline decoration-2 underline-offset-2" onclick="event.stopPropagation()">Terms of Service</a> 
                                    and 
                                    <a href="#" class="text-emerald-600 font-semibold hover:text-emerald-700 underline decoration-2 underline-offset-2" onclick="event.stopPropagation()">Privacy Policy</a>
                                </span>
                            </label>
                            <div id="termsError" class="hidden mt-2 text-sm text-red-600"></div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full premium-button text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center text-lg">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Create PeekTheLink Account
                            <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>

                        <!-- Security Note -->
                        <div class="flex items-center justify-center text-sm text-gray-600 space-x-3 bg-gray-50 rounded-lg p-4">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">256-bit SSL encrypted • SOC 2 compliant • Cancel anytime</span>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Already have an account?
                                <a href="#" class="text-emerald-600 font-semibold hover:text-emerald-700 underline decoration-2 underline-offset-2">Sign in here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Step 2: Profile Setup -->
            <div id="step2" class="step-container hidden">
                <div class="text-center mb-8">
                    <div class="mx-auto h-20 w-20 glass-card rounded-3xl flex items-center justify-center mb-6">
                        <svg class="h-10 w-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-4xl font-black text-white mb-3">Customize Your Profile</h1>
                    <p class="text-white/90 text-lg font-medium">Make your PeekTheLink uniquely yours</p>
                    
                    <!-- Progress -->
                    <div class="flex items-center justify-center space-x-3 mt-8">
                        <div class="w-10 h-2 bg-white/50 rounded-full"></div>
                        <div class="w-10 h-2 bg-white rounded-full shadow-lg"></div>
                        <div class="w-10 h-2 bg-white/30 rounded-full"></div>
                    </div>
                    <p class="text-white/70 text-sm mt-3 font-medium">Step 2 of 3 - Profile Setup</p>
                </div>

                <div class="glass-card rounded-3xl p-8 shadow-2xl">
                    <div class="text-center mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                            <span id="userInitials">JD</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Welcome, <span id="welcomeName">John</span>!</h3>
                        <p class="text-gray-600">Your PeekTheLink is almost ready</p>
                    </div>
                    
                    <button onclick="goToStep3()" class="w-full premium-button text-white font-bold py-4 px-6 rounded-xl">
                        Continue Setup →
                    </button>
                </div>
            </div>

            <!-- Step 3: Success -->
            <div id="step3" class="step-container hidden">
                <div class="text-center">
                    <div class="mx-auto h-32 w-32 glass-card rounded-full flex items-center justify-center mb-8">
                        <svg class="h-16 w-16 text-emerald-600 success-checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-5xl font-black text-white mb-4">Welcome to PeekTheLink!</h1>
                    <p class="text-white/90 text-xl font-medium mb-8">Your account has been created successfully</p>
                    
                    <div class="glass-card rounded-3xl p-8 shadow-2xl text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Your PeekTheLink is ready!</h3>
                        <div class="bg-emerald-50 border-2 border-emerald-200 rounded-xl p-6 mb-6">
                            <p class="text-sm text-gray-600 mb-2">Your unique URL:</p>
                            <p class="text-xl font-bold text-emerald-600" id="finalUrl">peekthelink.com/johndoe</p>
                        </div>
                        
                        <div class="space-y-3">
                            <button onclick="goToDashboard()" class="w-full premium-button text-white font-bold py-4 px-6 rounded-xl">
                                Go to Dashboard
                            </button>
                            <button onclick="copyUrl()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-4 px-6 rounded-xl transition-colors">
                                Copy My URL
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let registrationData = {};
        let isUsernameAvailable = false; // Track username availability
        
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
            
            // Show loading
            status.innerHTML = `
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-emerald-500"></div>
            `;
            status.classList.remove('hidden');
            availability.textContent = 'Checking...';
            availability.className = 'text-sm font-semibold text-gray-500';
            isUsernameAvailable = false;
            
            clearTimeout(usernameTimer);
            usernameTimer = setTimeout(async () => {
                try {
                    // Get CSRF token
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
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('Username check response:', data); // Debug log
                    
                    if (data.available) {
                        status.innerHTML = `
                            <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path class="success-checkmark" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        `;
                        availability.textContent = 'Available!';
                        availability.className = 'text-sm font-semibold text-emerald-600';
                        error.classList.add('hidden');
                        isUsernameAvailable = true;
                    } else {
                        status.innerHTML = `
                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        `;
                        availability.textContent = 'Taken';
                        availability.className = 'text-sm font-semibold text-red-500';
                        
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
                    status.innerHTML = `
                        <svg class="h-5 w-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    `;
                    availability.textContent = 'Check failed';
                    availability.className = 'text-sm font-semibold text-orange-500';
                    error.textContent = 'Unable to check username availability. Please try again.';
                    error.classList.remove('hidden');
                    isUsernameAvailable = false;
                }
            }, 800);
        }
        
        // Email validation with real API call
        let emailTimer;
        async function validateEmail(email) {
            const error = document.getElementById('emailError');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            // Clear previous errors
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
                    // Don't show error for failed check, just log it
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
            
            // Update requirement indicators
            Object.keys(requirements).forEach(req => {
                const element = document.getElementById(`req-${req}`);
                if (requirements[req]) {
                    element.innerHTML = element.innerHTML.replace('○', '✓');
                    element.className = 'flex items-center text-emerald-600';
                    strength++;
                } else {
                    element.innerHTML = element.innerHTML.replace('✓', '○');
                    element.className = 'flex items-center text-gray-500';
                }
            });
            
            const levels = ['', 'strength-weak', 'strength-fair', 'strength-good', 'strength-strong'];
            const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
            const colors = ['', 'text-red-500', 'text-yellow-500', 'text-emerald-500', 'text-emerald-600'];
            
            strengthBar.className = `password-strength rounded-full h-2 transition-all duration-300 ${levels[strength] || ''}`;
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
        
        // Form submission with real API call
        document.getElementById('registrationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Clear all previous errors
            clearAllErrors();
            
            // Get form values
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
                // Get CSRF token
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                console.log('CSRF Token:', token); // Debug log
                
                const requestData = {
                    fullName,
                    username,
                    email,
                    password,
                    password_confirmation: confirmPassword,
                    terms: terms ? 1 : 0
                };
                
                console.log('Sending registration data:', requestData); // Debug log
                
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token || '',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin', // Important: include cookies for session
                    body: JSON.stringify(requestData)
                });
                
                console.log('Response status:', response.status); // Debug log
                console.log('Response headers:', response.headers); // Debug log
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Response not OK:', response.status, errorText);
                    throw new Error(`HTTP ${response.status}: ${errorText}`);
                }
                
                const data = await response.json();
                console.log('Registration response:', data); // Debug log
                
                if (data.success) {
                    // Success! Store user data and continue to next step
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
                    // Handle validation errors from server
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const messages = data.errors[field];
                            const errorId = getErrorElementId(field);
                            if (errorId) {
                                showError(errorId, messages[0]);
                            }
                        });
                    } else {
                        // Show general error
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
        
        // Map Laravel field names to frontend error element IDs
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
                // Add red border to associated input
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
            
            // Remove red borders from all inputs
            document.querySelectorAll('input').forEach(input => {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-200');
            });
        }
        
        function goToStep2() {
            // Hide step 1 and show step 2
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            
            step1.classList.add('slide-out');
            
            setTimeout(() => {
                step1.classList.add('hidden');
                step1.classList.remove('slide-out');
                step2.classList.remove('hidden');
                step2.classList.add('slide-in');
                
                // Set user data
                const firstName = registrationData.fullName.split(' ')[0];
                const initials = registrationData.fullName.split(' ')
                    .map(name => name.charAt(0))
                    .join('')
                    .toUpperCase()
                    .substring(0, 2);
                
                document.getElementById('welcomeName').textContent = firstName;
                document.getElementById('userInitials').textContent = initials;
                
                currentStep = 2;
            }, 500);
        }
        
        function goToStep3() {
            // Hide step 2 and show step 3
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');
            
            step2.classList.add('slide-out');
            
            setTimeout(() => {
                step2.classList.add('hidden');
                step2.classList.remove('slide-out');
                step3.classList.remove('hidden');
                step3.classList.add('slide-in');
                
                document.getElementById('finalUrl').textContent = `peekthelink.com/${registrationData.username}`;
                currentStep = 3;
            }, 500);
        }
        
        function copyUrl() {
            const url = document.getElementById('finalUrl').textContent;
            const fullUrl = `https://${url}`;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(fullUrl).then(() => {
                    // Show success feedback
                    const button = event.target;
                    const originalText = button.textContent;
                    button.textContent = 'Copied!';
                    button.classList.add('bg-emerald-100', 'text-emerald-600');
                    button.classList.remove('bg-gray-100', 'text-gray-800');
                    
                    setTimeout(() => {
                        button.textContent = originalText;
                        button.classList.remove('bg-emerald-100', 'text-emerald-600');
                        button.classList.add('bg-gray-100', 'text-gray-800');
                    }, 2000);
                }).catch(() => {
                    // Fallback for older browsers
                    fallbackCopyUrl(fullUrl);
                });
            } else {
                fallbackCopyUrl(fullUrl);
            }
        }
        
        function fallbackCopyUrl(url) {
            const textArea = document.createElement('textarea');
            textArea.value = url;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            setTimeout(() => {
                button.textContent = originalText;
            }, 2000);
        }
        
        function goToDashboard() {
            // Show loading state
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = `
                <div class="flex items-center justify-center">
                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-3"></div>
                    Loading Dashboard...
                </div>
            `;
            button.disabled = true;
            
            // First, let's verify the user is still authenticated
            fetch('/api/auth-check', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin' // Important: include cookies
            })
            .then(response => response.json())
            .then(data => {
                console.log('Auth check:', data);
                // Redirect to dashboard regardless
                window.location.href = '/dashboard';
            })
            .catch(error => {
                console.log('Auth check failed, redirecting anyway:', error);
                // Still redirect to dashboard
                window.location.href = '/dashboard';
            });
        }
        
        // Initialize form interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Clear errors when user starts typing
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', function() {
                    // Clear error for this field
                    const errorElement = this.parentElement.parentElement.querySelector('[id$="Error"]');
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                        this.classList.remove('border-red-500');
                        this.classList.add('border-gray-200');
                    }
                    
                    // Reset username availability when user types
                    if (this.id === 'username') {
                        isUsernameAvailable = false;
                    }
                });
                
                input.addEventListener('focus', function() {
                    this.classList.add('border-emerald-500');
                    this.classList.remove('border-gray-200', 'border-red-500');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.classList.contains('border-red-500')) {
                        this.classList.remove('border-emerald-500');
                        this.classList.add('border-gray-200');
                    }
                });
            });
            
            // Handle terms checkbox
            document.getElementById('termsCheckbox').addEventListener('change', function() {
                const error = document.getElementById('termsError');
                if (this.checked && error) {
                    error.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>