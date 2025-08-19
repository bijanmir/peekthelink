<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Edit Link
                </h2>
                <p class="text-gray-600 mt-1">Update your link settings and revenue tracking</p>
            </div>
            <div class="hidden md:flex space-x-3">
                <a href="{{ route('links.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Links
                </a>
                <a href="{{ route('profile.show', Auth::user()->username) }}/link/{{ $link->id }}" 
                   target="_blank"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                    </svg>
                    Test Link
                </a>
            </div>
        </div>
    </x-slot>

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
        .revenue-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .slide-up { animation: slideUp 0.6s ease-out; }
    </style>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Link Stats Header -->
            <div class="mb-8 slide-up">
                <div class="glass-card rounded-2xl p-6 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2">{{ $link->title }}</h3>
                            <p class="text-gray-600">{{ $link->url }}</p>
                        </div>
                        <div class="text-right">
                            <div class="space-y-2">
                                <div class="revenue-badge px-3 py-1 rounded-full text-xs font-bold text-white">
                                    {{ $link->clicks }} clicks
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $link->is_active ? 'Active' : 'Inactive' }} • 
                                    {{ ucfirst($link->link_type ?? 'regular') }} link
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl shadow-xl border border-white/20 slide-up" style="animation-delay: 0.1s">
                <div class="p-8">
                    
                    <form method="POST" action="{{ route('links.update', $link) }}">
                        @csrf
                        @method('PUT')

                        <!-- Basic Link Information -->
                        <div class="form-section mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Basic Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Title -->
                                <div>
                                    <x-input-label for="title" :value="__('Link Title')" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" 
                                                  :value="old('title', $link->title)" required autofocus />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <!-- URL -->
                                <div>
                                    <x-input-label for="url" :value="__('Destination URL')" />
                                    <x-text-input id="url" class="block mt-1 w-full" type="url" name="url" 
                                                  :value="old('url', $link->url)" required 
                                                  placeholder="https://example.com" />
                                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mt-6">
                                <x-input-label for="description" :value="__('Description (Optional)')" />
                                <textarea id="description" name="description" rows="3" 
                                         class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                         placeholder="Brief description of this link...">{{ old('description', $link->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Revenue Settings -->
                        <div class="form-section mb-8 p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Revenue Tracking Settings
                            </h3>
                            
                            <!-- Link Type -->
                            <div class="mb-6">
                                <x-input-label for="link_type" :value="__('Link Type')" />
                                <select id="link_type" name="link_type" 
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        onchange="toggleRevenueFields()">
                                    <option value="regular" {{ old('link_type', $link->link_type ?? 'regular') === 'regular' ? 'selected' : '' }}>
                                        Regular Link (No revenue tracking)
                                    </option>
                                    <option value="affiliate" {{ old('link_type', $link->link_type) === 'affiliate' ? 'selected' : '' }}>
                                        Affiliate Link (Commission-based)
                                    </option>
                                    <option value="product" {{ old('link_type', $link->link_type) === 'product' ? 'selected' : '' }}>
                                        Product Sale (Your own product)
                                    </option>
                                    <option value="sponsored" {{ old('link_type', $link->link_type) === 'sponsored' ? 'selected' : '' }}>
                                        Sponsored Content (Pay per click)
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('link_type')" class="mt-2" />
                            </div>

                            <!-- Revenue Fields (shown/hidden based on link type) -->
                            <div id="revenue-fields" class="space-y-6">
                                
                                <!-- Affiliate Fields -->
                                <div id="affiliate-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
                                    <div>
                                        <x-input-label for="commission_rate" :value="__('Commission Rate (%)')" />
                                        <x-text-input id="commission_rate" class="block mt-1 w-full" type="number" 
                                                      name="commission_rate" step="0.01" min="0" max="100"
                                                      :value="old('commission_rate', $link->commission_rate)"
                                                      placeholder="5.50" />
                                        <p class="text-xs text-gray-500 mt-1">E.g., 5.50 for 5.5% commission</p>
                                    </div>
                                    
                                    <div>
                                        <x-input-label for="estimated_value" :value="__('Estimated Order Value ($)')" />
                                        <x-text-input id="estimated_value" class="block mt-1 w-full" type="number" 
                                                      name="estimated_value" step="0.01" min="0"
                                                      :value="old('estimated_value', $link->estimated_value)"
                                                      placeholder="50.00" />
                                        <p class="text-xs text-gray-500 mt-1">Average order value for this product</p>
                                    </div>
                                    
                                    <div>
                                        <x-input-label for="affiliate_program" :value="__('Affiliate Program')" />
                                        <select id="affiliate_program" name="affiliate_program" 
                                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">Select program...</option>
                                            <option value="Amazon Associates" {{ old('affiliate_program', $link->affiliate_program) === 'Amazon Associates' ? 'selected' : '' }}>Amazon Associates</option>
                                            <option value="ClickBank" {{ old('affiliate_program', $link->affiliate_program) === 'ClickBank' ? 'selected' : '' }}>ClickBank</option>
                                            <option value="ShareASale" {{ old('affiliate_program', $link->affiliate_program) === 'ShareASale' ? 'selected' : '' }}>ShareASale</option>
                                            <option value="Commission Junction" {{ old('affiliate_program', $link->affiliate_program) === 'Commission Junction' ? 'selected' : '' }}>Commission Junction</option>
                                            <option value="Other" {{ old('affiliate_program', $link->affiliate_program) === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <x-input-label for="affiliate_tag" :value="__('Affiliate Tag/ID')" />
                                        <x-text-input id="affiliate_tag" class="block mt-1 w-full" type="text" 
                                                      name="affiliate_tag" 
                                                      :value="old('affiliate_tag', $link->affiliate_tag)"
                                                      placeholder="your-affiliate-id" />
                                        <p class="text-xs text-gray-500 mt-1">Your unique affiliate tracking ID</p>
                                    </div>
                                </div>

                                <!-- Product Fields -->
                                <div id="product-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
                                    <div>
                                        <x-input-label for="product_price" :value="__('Product Price ($)')" />
                                        <x-text-input id="product_price" class="block mt-1 w-full" type="number" 
                                                      name="estimated_value" step="0.01" min="0"
                                                      :value="old('estimated_value', $link->estimated_value)"
                                                      placeholder="99.00" />
                                        <p class="text-xs text-gray-500 mt-1">Your product's selling price</p>
                                    </div>
                                    
                                    <div>
                                        <x-input-label for="total_revenue" :value="__('Total Revenue to Date ($)')" />
                                        <x-text-input id="total_revenue" class="block mt-1 w-full" type="number" 
                                                      name="total_revenue" step="0.01" min="0"
                                                      :value="old('total_revenue', $link->total_revenue ?? 0)"
                                                      placeholder="0.00" />
                                        <p class="text-xs text-gray-500 mt-1">Total revenue generated from this link</p>
                                    </div>
                                </div>

                                <!-- Sponsored Fields -->
                                <div id="sponsored-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
                                    <div>
                                        <x-input-label for="sponsored_rate" :value="__('Pay Per Click ($)')" />
                                        <x-text-input id="sponsored_rate" class="block mt-1 w-full" type="number" 
                                                      name="sponsored_rate" step="0.01" min="0"
                                                      :value="old('sponsored_rate', $link->sponsored_rate)"
                                                      placeholder="0.50" />
                                        <p class="text-xs text-gray-500 mt-1">Amount you earn per click</p>
                                    </div>
                                </div>

                                <!-- Conversion Tracking -->
                                <div id="conversion-fields" class="bg-white p-4 rounded-lg border border-gray-200">
                                    <h4 class="font-semibold text-gray-900 mb-3">Conversion Tracking</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="conversions" :value="__('Total Conversions')" />
                                            <x-text-input id="conversions" class="block mt-1 w-full" type="number" 
                                                          name="conversions" min="0"
                                                          :value="old('conversions', $link->conversions ?? 0)"
                                                          placeholder="0" />
                                            <p class="text-xs text-gray-500 mt-1">Number of successful sales/conversions</p>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <div class="text-sm text-gray-600">
                                                <strong>Conversion Rate:</strong> 
                                                <span id="conversion-rate">
                                                    {{ $link->clicks > 0 ? round(($link->conversions ?? 0) / $link->clicks * 100, 2) : 0 }}%
                                                </span>
                                                <br>
                                                <small class="text-gray-500">Based on {{ $link->clicks }} total clicks</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="form-section mb-8 p-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Advanced Settings
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Order -->
                                <div>
                                    <x-input-label for="order" :value="__('Display Order')" />
                                    <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" min="1"
                                                  :value="old('order', $link->order)" />
                                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first on your profile</p>
                                </div>

                                <!-- Active Status -->
                                <div class="flex items-center space-y-2">
                                    <label class="flex items-center bg-white p-4 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input id="is_active" name="is_active" type="checkbox" value="1"
                                               {{ old('is_active', $link->is_active) ? 'checked' : '' }}
                                               class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2">
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900">Link is active and visible</div>
                                            <div class="text-sm text-gray-500">Inactive links won't appear on your profile</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('links.index') }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancel
                            </a>
                            
                            <div class="space-x-3">
                                <button type="submit" name="action" value="save"
                                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Link
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleRevenueFields() {
            const linkType = document.getElementById('link_type').value;
            const revenueFields = document.getElementById('revenue-fields');
            const affiliateFields = document.getElementById('affiliate-fields');
            const productFields = document.getElementById('product-fields');
            const sponsoredFields = document.getElementById('sponsored-fields');
            const conversionFields = document.getElementById('conversion-fields');
            
            // Hide all fields first
            affiliateFields.style.display = 'none';
            productFields.style.display = 'none';
            sponsoredFields.style.display = 'none';
            
            // Show relevant fields based on link type
            if (linkType !== 'regular') {
                conversionFields.style.display = 'block';
                
                switch (linkType) {
                    case 'affiliate':
                        affiliateFields.style.display = 'grid';
                        break;
                    case 'product':
                        productFields.style.display = 'grid';
                        break;
                    case 'sponsored':
                        sponsoredFields.style.display = 'grid';
                        break;
                }
            } else {
                conversionFields.style.display = 'none';
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleRevenueFields();
            calculateConversionRate();
        });
        
        // Auto-calculate conversion rate
        function calculateConversionRate() {
            const conversions = parseInt(document.getElementById('conversions')?.value || 0);
            const totalClicks = {{ $link->clicks }};
            const conversionRate = totalClicks > 0 ? ((conversions / totalClicks) * 100).toFixed(2) : 0;
            
            const conversionRateElement = document.getElementById('conversion-rate');
            if (conversionRateElement) {
                conversionRateElement.textContent = conversionRate + '%';
            }
        }
        
        // Add event listener for conversion calculation
        document.addEventListener('DOMContentLoaded', function() {
            const conversionsField = document.getElementById('conversions');
            if (conversionsField) {
                conversionsField.addEventListener('input', calculateConversionRate);
            }
        });
        
        // Auto-calculate potential revenue display
        function calculatePotentialRevenue() {
            const linkType = document.getElementById('link_type').value;
            const commissionRate = parseFloat(document.getElementById('commission_rate')?.value || 0);
            const estimatedValue = parseFloat(document.getElementById('estimated_value')?.value || 0);
            const sponsoredRate = parseFloat(document.getElementById('sponsored_rate')?.value || 0);
            
            let potential = 0;
            
            switch (linkType) {
                case 'affiliate':
                    potential = estimatedValue * (commissionRate / 100) * 0.02; // Assume 2% conversion rate
                    break;
                case 'product':
                    potential = estimatedValue * 0.05; // Assume 5% conversion rate for own products
                    break;
                case 'sponsored':
                    potential = sponsoredRate;
                    break;
            }
            
            console.log('Potential revenue per click: $' + potential.toFixed(4));
        }
        
        // Add event listeners for real-time calculation
        document.addEventListener('DOMContentLoaded', function() {
            ['commission_rate', 'estimated_value', 'sponsored_rate', 'product_price'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', calculatePotentialRevenue);
                }
            });
        });
    </script>
</x-app-layout>