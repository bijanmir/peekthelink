{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            Profile Settings
        </h2>
        <p class="text-gray-600 mt-1">Manage your account settings and profile information</p>
    </div>
    <div class="hidden md:flex space-x-3">
        <a href="{{ route('profile.show', Auth::user()->username) }}" 
           target="_blank"
           class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
            </svg>
            View Public Profile
        </a>
    </div>
</div>
@endsection

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    * { font-family: 'Inter', sans-serif; }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .form-section {
        transition: all 0.3s ease;
    }
    .form-section:hover {
        transform: translateY(-2px);
    }
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .slide-up { animation: slideUp 0.6s ease-out; }
</style>
@endpush

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        {{-- Success Message --}}
        @if(session('status') === 'profile-updated')
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 slide-up">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Profile updated successfully!
                </div>
            </div>
        @endif

        {{-- Profile Information Form --}}
        <div class="glass-card shadow-xl rounded-2xl form-section">
            <div class="p-8">
                <header class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Profile Information
                    </h3>
                    <p class="text-gray-600">
                        Update your account's profile information, display name, username, and bio.
                    </p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    {{-- Profile Image Upload --}}
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                @if($user->profile_image)
                                    <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg" 
                                         src="{{ asset('storage/' . $user->profile_image) }}" 
                                         alt="{{ $user->display_name ?? $user->name }}"
                                         id="profile-preview">
                                @else
                                    <div class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-white shadow-lg"
                                         id="profile-preview">
                                        {{ strtoupper(substr($user->display_name ?? $user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" 
                                       id="profile_image" 
                                       name="profile_image" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-blue-50 file:to-purple-50 file:text-blue-700 hover:file:bg-gradient-to-r hover:file:from-blue-100 hover:file:to-purple-100 transition duration-200"
                                       onchange="previewImage(this)">
                                <p class="mt-2 text-xs text-gray-500">
                                    JPG, GIF or PNG. Max size 2MB.
                                </p>
                                @error('profile_image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Account Name --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Account Name</label>
                            <input id="name" 
                                   name="name" 
                                   type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   value="{{ old('name', $user->name) }}" 
                                   required 
                                   autofocus 
                                   autocomplete="name">
                            <p class="mt-1 text-xs text-gray-500">
                                Used for login and account management.
                            </p>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Display Name --}}
                        <div>
                            <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">Display Name</label>
                            <input id="display_name" 
                                   name="display_name" 
                                   type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   value="{{ old('display_name', $user->display_name) }}" 
                                   placeholder="Your public display name">
                            <p class="mt-1 text-xs text-gray-500">
                                Shown on your public profile (optional).
                            </p>
                            @error('display_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Username and Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">@</span>
                                </div>
                                <input id="username" 
                                       name="username" 
                                       type="text" 
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                       value="{{ old('username', $user->username) }}" 
                                       required 
                                       pattern="[a-zA-Z0-9_-]+" 
                                       title="Only letters, numbers, hyphens, and underscores allowed">
                            </div>
                            <div id="username-feedback" class="hidden mt-2">
                                <p id="username-status" class="text-sm"></p>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Your unique profile URL: {{ config('app.url') }}/<strong>{{ $user->username }}</strong>
                            </p>
                            @error('username')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input id="email" 
                                   name="email" 
                                   type="email" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   value="{{ old('email', $user->email) }}" 
                                   required 
                                   autocomplete="email">
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-gray-800">
                                        Your email address is unverified.
                                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Click here to re-send the verification email.
                                        </button>
                                    </p>
                                </div>
                            @endif
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Bio --}}
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea id="bio" 
                                  name="bio" 
                                  rows="4" 
                                  maxlength="500"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition duration-200" 
                                  placeholder="Tell visitors about yourself...">{{ old('bio', $user->bio) }}</textarea>
                        <div class="flex justify-between mt-1">
                            <p class="text-xs text-gray-500">Appears on your public profile</p>
                            <p class="text-xs text-gray-500">
                                <span id="bio-count">{{ strlen($user->bio ?? '') }}</span>/500 characters
                            </p>
                        </div>
                        @error('bio')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Theme Color --}}
                    <div>
                        <label for="theme_color" class="block text-sm font-medium text-gray-700 mb-2">Theme Color</label>
                        <div class="flex items-center space-x-4">
                            <input type="color" 
                                   id="theme_color" 
                                   name="theme_color" 
                                   value="{{ old('theme_color', $user->theme_color) }}" 
                                   class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" 
                                   id="theme_color_hex" 
                                   value="{{ old('theme_color', $user->theme_color) }}" 
                                   readonly 
                                   class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm font-mono">
                            <button type="button" 
                                    onclick="resetThemeColor()" 
                                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-lg transition duration-200">
                                Reset
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            Customize your profile's accent color
                        </p>
                        @error('theme_color')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Profile Status --}}
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center">
                            <input id="is_active" 
                                   name="is_active" 
                                   type="checkbox" 
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <div class="ml-3">
                                <label for="is_active" class="font-medium text-gray-900">Profile is active and visible</label>
                                <p class="text-sm text-gray-500">When disabled, your public profile will be hidden</p>
                            </div>
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                        <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Password Update Section --}}
        <div class="glass-card shadow-xl rounded-2xl form-section">
            <div class="p-8">
                <header class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Update Password
                    </h3>
                    <p class="text-gray-600">
                        Ensure your account is using a long, random password to stay secure.
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                        <input id="update_password_current_password" 
                               name="current_password" 
                               type="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input id="update_password_password" 
                               name="password" 
                               type="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <input id="update_password_password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                        <button type="submit"
                                class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-3 px-8 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danger Zone - Delete Account --}}
        <div class="glass-card shadow-xl rounded-2xl form-section border-2 border-red-200">
            <div class="p-8">
                <header class="mb-8">
                    <h3 class="text-xl font-semibold text-red-900 mb-2">
                        Delete Account
                    </h3>
                    <p class="text-red-600">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                </header>

                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6" id="delete-form">
                    @csrf
                    @method('delete')

                    <div>
                        <label for="password_delete" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="password_delete" 
                               name="password" 
                               type="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200" 
                               placeholder="Enter your password to confirm deletion">
                        @error('password', 'userDeletion')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                        <button type="button"
                                onclick="confirmDelete()"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endif
@endsection

@push('scripts')
<script>
    let usernameCheckTimeout;
    
    // Image preview function
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profile-preview');
                preview.innerHTML = `<img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg" src="${e.target.result}" alt="Profile Preview">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Theme color sync
    document.getElementById('theme_color').addEventListener('change', function() {
        document.getElementById('theme_color_hex').value = this.value;
    });

    // Reset theme color to default
    function resetThemeColor() {
        const defaultColor = '#3B82F6';
        document.getElementById('theme_color').value = defaultColor;
        document.getElementById('theme_color_hex').value = defaultColor;
    }

    // Bio character counter
    document.getElementById('bio').addEventListener('input', function() {
        document.getElementById('bio-count').textContent = this.value.length;
    });

    // Live username validation
    document.getElementById('username').addEventListener('input', function() {
        const username = this.value.trim();
        const feedback = document.getElementById('username-feedback');
        const status = document.getElementById('username-status');
        const usernameField = this;
        
        // Clear previous timeout
        clearTimeout(usernameCheckTimeout);
        
        // Reset styling
        usernameField.classList.remove('border-red-500', 'border-green-500');
        feedback.classList.add('hidden');
        
        // Basic validation first
        if (username.length === 0) {
            return;
        }
        
        if (!/^[a-zA-Z0-9_-]+$/.test(username)) {
            usernameField.classList.add('border-red-500');
            status.textContent = 'Only letters, numbers, hyphens, and underscores allowed';
            status.className = 'text-red-600';
            feedback.classList.remove('hidden');
            return;
        }
        
        if (username.length < 3) {
            usernameField.classList.add('border-red-500');
            status.textContent = 'Username must be at least 3 characters';
            status.className = 'text-red-600';
            feedback.classList.remove('hidden');
            return;
        }

        // Debounced server-side validation
        usernameCheckTimeout = setTimeout(() => {
            fetch(`/api/profile/check-username?username=${encodeURIComponent(username)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    usernameField.classList.add('border-green-500');
                    status.textContent = data.message;
                    status.className = 'text-green-600';
                } else {
                    usernameField.classList.add('border-red-500');
                    status.textContent = data.message;
                    status.className = 'text-red-600';
                }
                feedback.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Username check failed:', error);
            });
        }, 500);
    });

    // Confirm account deletion
    function confirmDelete() {
        if (confirm('Are you absolutely sure you want to delete your account? This action cannot be undone and all your data will be permanently lost.')) {
            document.getElementById('delete-form').submit();
        }
    }

    // Password update success handling
    @if(session('status') === 'password-updated')
        showNotification('Password updated successfully!', 'success');
    @endif

    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
</script>
@endpush