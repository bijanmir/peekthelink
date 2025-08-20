{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information, display name, and bio.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Profile Image Upload --}}
        <div>
            <x-input-label for="profile_image" :value="__('Profile Photo')" />
            <div class="mt-2 flex items-center space-x-6">
                <div class="flex-shrink-0">
                    @if($user->profile_image)
                        <img class="h-20 w-20 rounded-full object-cover" 
                             src="{{ asset('storage/' . $user->profile_image) }}" 
                             alt="{{ $user->display_name ?? $user->name }}"
                             id="profile-preview">
                    @else
                        <div class="h-20 w-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold"
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
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                           onchange="previewImage(this)">
                    <p class="mt-2 text-xs text-gray-500">
                        JPG, GIF or PNG. Max size 2MB.
                    </p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
        </div>

        {{-- Account Name (Email-based) --}}
        <div>
            <x-input-label for="name" :value="__('Account Name')" />
            <x-text-input id="name" 
                          name="name" 
                          type="text" 
                          class="mt-1 block w-full" 
                          :value="old('name', $user->name)" 
                          required 
                          autofocus 
                          autocomplete="name" />
            <p class="mt-1 text-xs text-gray-500">
                This is your account name, primarily used for login and account management.
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Display Name (Public-facing) --}}
        <div>
            <x-input-label for="display_name" :value="__('Display Name')" />
            <x-text-input id="display_name" 
                          name="display_name" 
                          type="text" 
                          class="mt-1 block w-full" 
                          :value="old('display_name', $user->display_name)" 
                          autocomplete="nickname" 
                          placeholder="How you want to appear to visitors" />
            <p class="mt-1 text-xs text-gray-500">
                This is the name visitors see on your public profile. Leave blank to use your account name.
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('display_name')" />
        </div>

        {{-- Username --}}
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <div class="mt-1 flex rounded-md shadow-sm">
                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                    {{ config('app.url') }}/
                </span>
                <x-text-input id="username" 
                              name="username" 
                              type="text" 
                              class="flex-1 block w-full rounded-none rounded-r-md" 
                              :value="old('username', $user->username)" 
                              required 
                              autocomplete="username" 
                              pattern="[a-zA-Z0-9_-]+"
                              title="Only letters, numbers, hyphens, and underscores allowed" />
            </div>
            
            <!-- Live validation feedback -->
            <div id="username-feedback" class="mt-1 text-xs hidden">
                <span id="username-status"></span>
            </div>
            
            <p class="mt-1 text-xs text-gray-500">
                Your unique URL. Only letters, numbers, hyphens, and underscores allowed.
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" 
                          name="email" 
                          type="email" 
                          class="mt-1 block w-full" 
                          :value="old('email', $user->email)" 
                          required 
                          autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Bio --}}
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" 
                      name="bio" 
                      rows="4" 
                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                      placeholder="Tell visitors about yourself..."
                      maxlength="500">{{ old('bio', $user->bio) }}</textarea>
            <p class="mt-1 text-xs text-gray-500">
                <span id="bio-count">{{ strlen($user->bio ?? '') }}</span>/500 characters
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        {{-- Theme Color --}}
        <div>
            <x-input-label for="theme_color" :value="__('Theme Color')" />
            <div class="mt-2 flex items-center space-x-4">
                <input type="color" 
                       id="theme_color" 
                       name="theme_color" 
                       value="{{ old('theme_color', $user->theme_color) }}"
                       class="h-10 w-20 rounded border border-gray-300 cursor-pointer">
                <div class="flex-1">
                    <x-text-input id="theme_color_hex" 
                                  name="theme_color_text" 
                                  type="text" 
                                  class="block w-full" 
                                  :value="old('theme_color', $user->theme_color)"
                                  readonly />
                </div>
                <button type="button" 
                        onclick="resetThemeColor()" 
                        class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800">
                    Reset
                </button>
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Choose your profile's accent color. This affects buttons, links, and highlights.
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('theme_color')" />
        </div>

        {{-- Profile Status --}}
        <div>
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                    Profile is public and visible
                </label>
            </div>
            <p class="mt-1 text-xs text-gray-500">
                When unchecked, your profile will be hidden from public view.
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endif

<script>
    let usernameCheckTimeout;
    const originalUsername = '{{ $user->username }}';

    // Profile image preview
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById('profile-preview');
                preview.innerHTML = '';
                preview.className = 'h-20 w-20 rounded-full object-cover';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-20 w-20 rounded-full object-cover';
                preview.appendChild(img);
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Theme color sync
    document.getElementById('theme_color').addEventListener('change', function() {
        document.getElementById('theme_color_hex').value = this.value;
    });

    document.getElementById('theme_color_hex').addEventListener('input', function() {
        if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(this.value)) {
            document.getElementById('theme_color').value = this.value;
        }
    });

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
        
        // If it's the same as original username, mark as available
        if (username === originalUsername) {
            usernameField.classList.add('border-green-500');
            status.textContent = 'Current username';
            status.className = 'text-green-600';
            feedback.classList.remove('hidden');
            return;
        }
        
        // Show checking status
        status.textContent = 'Checking availability...';
        status.className = 'text-gray-600';
        feedback.classList.remove('hidden');
        
        // Debounce the API call
        usernameCheckTimeout = setTimeout(() => {
            checkUsernameAvailability(username, usernameField, status, feedback);
        }, 500);
    });
    
    async function checkUsernameAvailability(username, field, statusElement, feedbackElement) {
        try {
            const response = await fetch('/api/profile/check-username', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ username: username })
            });
            
            const data = await response.json();
            
            if (data.available) {
                field.classList.remove('border-red-500');
                field.classList.add('border-green-500');
                statusElement.textContent = '✓ Username is available';
                statusElement.className = 'text-green-600';
            } else {
                field.classList.remove('border-green-500');
                field.classList.add('border-red-500');
                statusElement.textContent = '✗ ' + data.message;
                statusElement.className = 'text-red-600';
            }
            
            feedbackElement.classList.remove('hidden');
            
        } catch (error) {
            console.error('Error checking username:', error);
            statusElement.textContent = 'Error checking availability';
            statusElement.className = 'text-red-600';
            feedbackElement.classList.remove('hidden');
        }
    }

    // Initialize form interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add CSRF token if not present
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }
        
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const errorElement = this.closest('.form-field')?.querySelector('[id$="Error"]');
                if (errorElement) {
                    errorElement.classList.add('hidden');
                    this.classList.remove('border-red-500');
                }
            });
        });
    });
</script>