@extends('layouts.app')

@section('content')
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
    .input-group {
        transition: all 0.2s ease;
    }
    .input-group:focus-within {
        transform: translateY(-1px);
    }
    .premium-input {
        transition: all 0.2s ease;
        border: 2px solid #e5e7eb;
    }
    .premium-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }
    .premium-select {
        transition: all 0.2s ease;
        border: 2px solid #e5e7eb;
    }
    .premium-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    .potential-revenue {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
</style>

<!-- Page Header -->
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div>
                <h2 class="font-black text-3xl text-gray-900 leading-tight flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    {{ isset($link) ? 'Edit Link' : 'Create New Link' }}
                </h2>
                <p class="text-gray-600 mt-2 ml-14">{{ isset($link) ? 'Update your link settings and revenue tracking' : 'Add a new link to your LinkBio with revenue tracking' }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('links.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-5 rounded-xl transition duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Links
                </a>
                @if(isset($link))
                <a href="{{ route('profile.show', Auth::user()->username) }}/link/{{ $link->id }}" 
                   target="_blank"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-5 rounded-xl transition duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                    </svg>
                    Test Link
                </a>
                @endif
            </div>
        </div>
    </div>
</header>

<div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        @if(isset($link))
        <!-- Link Stats Header for Edit Mode -->
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
        @endif

        <div class="glass-card rounded-2xl shadow-xl border border-white/20 slide-up" style="animation-delay: 0.1s">
            <div class="p-8 sm:p-10">
                
                <form method="POST" action="{{ isset($link) ? route('links.update', $link) : route('links.store') }}">
                    @csrf
                    @if(isset($link))
                        @method('PUT')
                    @endif

                    <!-- Basic Link Information -->
                    <div class="form-section mb-10 p-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                            <svg class="w-7 h-7 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            Basic Information
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Title -->
                            <div class="input-group space-y-2">
                                <label for="title" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                    Link Title *
                                </label>
                                <input id="title" type="text" name="title" 
                                       value="{{ old('title', $link->title ?? '') }}" 
                                       required autofocus
                                       class="premium-input block w-full px-4 py-4 text-lg rounded-xl shadow-sm focus:outline-none"
                                       placeholder="Enter a descriptive title...">
                                @error('title')
                                    <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-sm">This will be displayed on your LinkBio</p>
                            </div>

                            <!-- URL -->
                            <div class="input-group space-y-2">
                                <label for="url" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                    Destination URL *
                                </label>
                                <input id="url" type="url" name="url" 
                                       value="{{ old('url', $link->url ?? '') }}" 
                                       required
                                       class="premium-input block w-full px-4 py-4 text-lg rounded-xl shadow-sm focus:outline-none"
                                       placeholder="https://example.com">
                                @error('url')
                                    <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                                @enderror
                                <p class="text-gray-500 text-sm">Where visitors will be redirected</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="input-group space-y-2 mt-8">
                            <label for="description" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                Description (Optional)
                            </label>
                            <textarea id="description" name="description" rows="4" 
                                     class="premium-input block w-full px-4 py-4 text-lg rounded-xl shadow-sm focus:outline-none resize-none"
                                     placeholder="Brief description of this link...">{{ old('description', $link->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm">Optional subtitle that appears below the title</p>
                        </div>
                    </div>

                    <!-- Revenue Settings -->
                    <div class="form-section mb-10 p-8 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border border-green-200">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                            <svg class="w-7 h-7 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Revenue Tracking Settings
                        </h3>
                        
                        <!-- Link Type -->
                        <div class="input-group space-y-2 mb-8">
                            <label for="link_type" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                Link Type
                            </label>
                            <select id="link_type" name="link_type" 
                                    class="premium-select block w-full px-4 py-4 text-lg rounded-xl shadow-sm focus:outline-none"
                                    onchange="toggleRevenueFields()">
                                <option value="regular" {{ old('link_type', $link->link_type ?? 'regular') === 'regular' ? 'selected' : '' }}>
                                    🔗 Regular Link (No revenue tracking)
                                </option>
                                <option value="affiliate" {{ old('link_type', $link->link_type ?? '') === 'affiliate' ? 'selected' : '' }}>
                                    💰 Affiliate Link (Commission-based)
                                </option>
                                <option value="product" {{ old('link_type', $link->link_type ?? '') === 'product' ? 'selected' : '' }}>
                                    🛍️ Product Sale (Your own product)
                                </option>
                                <option value="sponsored" {{ old('link_type', $link->link_type ?? '') === 'sponsored' ? 'selected' : '' }}>
                                    📈 Sponsored Content (Pay per click)
                                </option>
                            </select>
                            @error('link_type')
                                <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm">Choose how this link generates revenue</p>
                        </div>

                        <!-- Revenue Fields (shown/hidden based on link type) -->
                        <div id="revenue-fields" class="space-y-8">
                            
                            <!-- Affiliate Fields -->
                            <div id="affiliate-fields" class="bg-white rounded-2xl p-6 border border-emerald-200" style="display: none;">
                                <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                    <span class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </span>
                                    Affiliate Link Settings
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="input-group space-y-2">
                                        <label for="commission_rate" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                            Commission Rate (%)
                                        </label>
                                        <input id="commission_rate" type="number" name="commission_rate" 
                                               step="0.01" min="0" max="100"
                                               value="{{ old('commission_rate', $link->commission_rate ?? '') }}"
                                               class="premium-input block w-full px-4 py-3 text-lg rounded-xl shadow-sm focus:outline-none"
                                               placeholder="5.50">
                                        <p class="text-gray-500 text-sm">E.g., 5.50 for 5.5% commission</p>
                                    </div>
                                    
                                    <div class="input-group space-y-2">
                                        <label for="estimated_value" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                            Estimated Order Value ($)
                                        </label>
                                        <input id="estimated_value" type="number" name="estimated_value" 
                                               step="0.01" min="0"
                                               value="{{ old('estimated_value', $link->estimated_value ?? '') }}"
                                               class="premium-input block w-full px-4 py-3 text-lg rounded-xl shadow-sm focus:outline-none"
                                               placeholder="50.00">
                                        <p class="text-gray-500 text-sm">Average order value for this product</p>
                                    </div>
                                    
                                    <div class="input-group space-y-2">
                                        <label for="affiliate_program" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                            Affiliate Program
                                        </label>
                                        <select id="affiliate_program" name="affiliate_program" 
                                                class="premium-select block w-full px-4 py-3 text-lg rounded-xl shadow-sm focus:outline-none">
                                            <option value="">Select program...</option>
                                            <option value="Amazon Associates" {{ old('affiliate_program', $link->affiliate_program ?? '') === 'Amazon Associates' ? 'selected' : '' }}>Amazon Associates</option>
                                            <option value="ClickBank" {{ old('affiliate_program', $link->affiliate_program ?? '') === 'ClickBank' ? 'selected' : '' }}>ClickBank</option>
                                            <option value="ShareASale" {{ old('affiliate_program', $link->affiliate_program ?? '') === 'ShareASale' ? 'selected' : '' }}>ShareASale</option>
                                            <option value="Commission Junction" {{ old('affiliate_program', $link->affiliate_program ?? '') === 'Commission Junction' ? 'selected' : '' }}>Commission Junction</option>
                                            <option value="Other" {{ old('affiliate_program', $link->affiliate_program ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    
                                    <div class="input-group space-y-2">
                                        <label for="affiliate_tag" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                            Affiliate Tag/ID
                                        </label>
                                        <input id="affiliate_tag" type="text" name="affiliate_tag" 
                                               value="{{ old('affiliate_tag', $link->affiliate_tag ?? '') }}"
                                               class="premium-input block w-full px-4 py-3 text-lg rounded-xl shadow-sm focus:outline-none"
                                               placeholder="your-affiliate-id">
                                        <p class="text-gray-500 text-sm">Your unique affiliate tracking ID</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Fields -->
                            <div id="product-fields" class="bg-white rounded-2xl p-6 border border-blue-200" style="display: none;">
                                <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                    <span class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </span>
                                    Product Sales Settings
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="input-group space-y-2">
                                        <label for="product_price" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                            Product Price ($)
                                        </label>
                                        <input id="product_price" type="number" name="estimated_value" 
                                               step="0.01" min="0"
                                               value="{{ old('estimated_value', $link->estimated_value ?? '') }}"
                                               class="premium-input block w-full px-4 py-3 text-lg rounded-xl shadow-sm focus:outline-none"
                                               placeholder="99.00">
                                        <p class="text-gray-500 text-sm">Your product's selling price</p>
                                    </div>
                                    
                                    <div class="input-group space-y-2">
                                        <label for="total_revenue" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                            Total Revenue to Date ($)
                                        </label>
                                        <input id="total_revenue" type="number" name="total_revenue" 
                                               step="0.01" min="0"
                                               value="{{ old('total_revenue', $link->total_revenue ?? 0) }}"
                                               class="premium-input block w-full px-4 py-3 text-lg rounded-xl shadow-sm focus:outline-none"
                                               placeholder="0.00">
                                        <p class="text-gray-500 text-sm">Total revenue generated from this link</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sponsored Fields -->
                            <div id="sponsored-fields" class="bg-white rounded-2xl p-6 border border-purple-200" style="display: none;">
                                <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                    <span class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </span>
                                    Sponsored Content Settings
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="input-group space-y-2">
                                        <label for="sponsored_rate" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                            Pay Per Click ($)
                                        </label>
                                        <input id="sponsored_rate" type="number" name="sponsored_rate" 
                                               step="0.01" min="0"
                                               value="{{ old('sponsored_rate', $link->sponsored_rate ?? '') }}"
                                               class="premium-input block w-full px-4 py-3 text-lg rounded-xl shadow-sm focus:outline-none"
                                               placeholder="0.50">
                                        <p class="text-gray-500 text-sm">Amount you earn per click</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Potential Revenue Calculator -->
                            <div id="revenue-calculator" class="potential-revenue rounded-2xl p-6 text-white" style="display: none;">
                                <h4 class="text-lg font-bold mb-4 flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 0v6m0-6l-6 6"></path>
                                    </svg>
                                    Potential Revenue Calculator
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                                    <div class="bg-white/20 rounded-xl p-4">
                                        <div class="text-2xl font-bold" id="potential-per-click">$0.00</div>
                                        <div class="text-sm opacity-90">Per Click</div>
                                    </div>
                                    <div class="bg-white/20 rounded-xl p-4">
                                        <div class="text-2xl font-bold" id="potential-monthly">$0.00</div>
                                        <div class="text-sm opacity-90">Monthly (100 clicks)</div>
                                    </div>
                                    <div class="bg-white/20 rounded-xl p-4">
                                        <div class="text-2xl font-bold" id="potential-yearly">$0.00</div>
                                        <div class="text-sm opacity-90">Yearly (1200 clicks)</div>
                                    </div>
                                </div>
                                <p class="text-sm opacity-90 mt-4 text-center">*Estimates based on industry average conversion rates</p>
                            </div>

                        </div>
                    </div>

                    <!-- Advanced Settings -->
                    <div class="form-section mb-10 p-8 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl border border-purple-200">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                            <svg class="w-7 h-7 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Advanced Settings
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Order -->
                            <div class="input-group space-y-2">
                                <label for="order" class="block text-sm font-bold text-gray-900 uppercase tracking-wide">
                                    Display Order
                                </label>
                                <input id="order" type="number" name="order" min="1"
                                       value="{{ old('order', $link->order ?? '') }}"
                                       class="premium-input block w-full px-4 py-4 text-lg rounded-xl shadow-sm focus:outline-none"
                                       placeholder="1">
                                <p class="text-gray-500 text-sm">Lower numbers appear first on your profile</p>
                            </div>

                            <!-- Active Status -->
                            <div class="input-group space-y-2">
                                <label class="block text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">
                                    Link Status
                                </label>
                                <label class="flex items-center bg-white p-6 rounded-xl border-2 border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                    <input id="is_active" name="is_active" type="checkbox" value="1"
                                           {{ old('is_active', $link->is_active ?? true) ? 'checked' : '' }}
                                           class="w-5 h-5 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                                    <div class="ml-4">
                                        <div class="font-bold text-gray-900">Link is active and visible</div>
                                        <div class="text-sm text-gray-500">Inactive links won't appear on your profile</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 pt-8 border-t border-gray-200">
                        <a href="{{ route('links.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-4 px-8 rounded-xl transition duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Cancel
                        </a>
                        
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                            @if(isset($link))
                                <button type="submit" name="action" value="save"
                                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl transition duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Link
                                </button>
                            @else
                                <button type="submit" name="action" value="save"
                                        class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold py-4 px-8 rounded-xl transition duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Create Link
                                </button>
                                <button type="submit" name="action" value="save_and_add"
                                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-xl transition duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Save & Add Another
                                </button>
                            @endif
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
        const revenueCalculator = document.getElementById('revenue-calculator');
        
        // Hide all fields first
        affiliateFields.style.display = 'none';
        productFields.style.display = 'none';
        sponsoredFields.style.display = 'none';
        revenueCalculator.style.display = 'none';
        
        // Show relevant fields based on link type
        if (linkType !== 'regular') {
            revenueCalculator.style.display = 'block';
            
            switch (linkType) {
                case 'affiliate':
                    affiliateFields.style.display = 'block';
                    break;
                case 'product':
                    productFields.style.display = 'block';
                    break;
                case 'sponsored':
                    sponsoredFields.style.display = 'block';
                    break;
            }
            
            // Trigger calculation
            calculatePotentialRevenue();
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleRevenueFields();
    });
    
    // Enhanced revenue calculation with visual display
    function calculatePotentialRevenue() {
        const linkType = document.getElementById('link_type').value;
        const commissionRate = parseFloat(document.getElementById('commission_rate')?.value || 0);
        const estimatedValue = parseFloat(document.getElementById('estimated_value')?.value || 0);
        const sponsoredRate = parseFloat(document.getElementById('sponsored_rate')?.value || 0);
        
        let potentialPerClick = 0;
        
        switch (linkType) {
            case 'affiliate':
                potentialPerClick = estimatedValue * (commissionRate / 100) * 0.02; // 2% conversion rate
                break;
            case 'product':
                potentialPerClick = estimatedValue * 0.05; // 5% conversion rate for own products
                break;
            case 'sponsored':
                potentialPerClick = sponsoredRate;
                break;
        }
        
        const potentialMonthly = potentialPerClick * 100;
        const potentialYearly = potentialPerClick * 1200;
        
        // Update the display
        document.getElementById('potential-per-click').textContent = '$' + potentialPerClick.toFixed(2);
        document.getElementById('potential-monthly').textContent = '$' + potentialMonthly.toFixed(2);
        document.getElementById('potential-yearly').textContent = '$' + potentialYearly.toFixed(2);
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
@endsection