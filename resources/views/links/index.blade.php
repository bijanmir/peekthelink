<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center">
                    <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    Manage Links
                </h2>
                <p class="text-gray-600 mt-1">Organize and customize your LinkBio links</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('profile.show', Auth::user()->username) }}" 
                   target="_blank"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                    </svg>
                    Preview Profile
                </a>
                <a href="{{ route('links.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 flex items-center shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Link
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-4 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Stats Summary --}}
            @if($links->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-4 border border-blue-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-2xl font-bold text-gray-900">{{ $links->count() }}</p>
                                <p class="text-xs text-gray-600">Total Links</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-emerald-50 to-teal-100 rounded-xl p-4 border border-emerald-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-2xl font-bold text-gray-900">{{ $links->where('is_active', true)->count() }}</p>
                                <p class="text-xs text-gray-600">Active Links</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-100 rounded-xl p-4 border border-purple-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($links->sum('clicks')) }}</p>
                                <p class="text-xs text-gray-600">Total Clicks</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-red-100 rounded-xl p-4 border border-orange-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $links->count() > 0 ? number_format($links->sum('clicks') / $links->count(), 1) : '0' }}
                                </p>
                                <p class="text-xs text-gray-600">Avg. Clicks</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Links Management --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                                Link Management
                            </h3>
                            <p class="text-gray-500 mt-1">
                                @if($links->count() > 0)
                                    Drag and drop to reorder • Click to edit • Toggle status
                                @else
                                    Start building your LinkBio by adding your first link
                                @endif
                            </p>
                        </div>
                        @if($links->count() > 0)
                            <div class="text-sm text-gray-500">
                                {{ $links->count() }} {{ Str::plural('link', $links->count()) }} total
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    @if($links->count() > 0)
                        <div id="links-container" class="space-y-4">
                            @foreach($links as $link)
                                <div class="link-item group bg-gray-50 hover:bg-gray-100 border-2 border-gray-200 hover:border-blue-300 rounded-xl p-5 transition-all duration-200 cursor-move" data-id="{{ $link->id }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center flex-1">
                                            {{-- Drag Handle --}}
                                            <div class="mr-4 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                                </svg>
                                            </div>

                                            {{-- Link Icon --}}
                                            <div class="w-12 h-12 bg-gradient-to-br {{ $link->is_active ? 'from-emerald-400 to-emerald-600' : 'from-gray-400 to-gray-600' }} rounded-xl flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                </svg>
                                            </div>

                                            {{-- Link Content --}}
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <h3 class="font-semibold text-lg text-gray-900 truncate">{{ $link->title }}</h3>
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $link->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                                        <div class="w-2 h-2 rounded-full {{ $link->is_active ? 'bg-emerald-500' : 'bg-red-500' }} mr-1"></div>
                                                        {{ $link->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600 mb-1 truncate">
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                                        </svg>
                                                        {{ $link->url }}
                                                    </span>
                                                </p>
                                                @if($link->description)
                                                    <p class="text-sm text-gray-500 truncate">{{ $link->description }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex items-center space-x-4 ml-4">
                                            {{-- Click Count --}}
                                            <div class="text-center">
                                                <p class="text-2xl font-bold text-gray-900">{{ number_format($link->clicks) }}</p>
                                                <p class="text-xs text-gray-500">clicks</p>
                                            </div>

                                            {{-- Action Buttons - Always visible now --}}
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('links.edit', $link) }}" 
                                                   class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition duration-200 tooltip"
                                                   title="Edit Link">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                
                                                {{-- Fixed Toggle Button - Always Show --}}
                                                <form method="POST" action="{{ route('links.update', $link) }}" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="title" value="{{ $link->title }}">
                                                    <input type="hidden" name="url" value="{{ $link->url }}">
                                                    <input type="hidden" name="description" value="{{ $link->description }}">
                                                    <input type="hidden" name="is_active" value="{{ $link->is_active ? '0' : '1' }}">
                                                    <button type="submit" 
                                                            onclick="return confirm('Are you sure you want to {{ $link->is_active ? 'deactivate' : 'activate' }} this link?')"
                                                            class="p-2 rounded-lg transition duration-200 tooltip text-white {{ $link->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-emerald-600 hover:bg-emerald-700' }}"
                                                            title="{{ $link->is_active ? 'Deactivate' : 'Activate' }} Link">
                                                        @if($link->is_active)
                                                            {{-- Deactivate Icon --}}
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18 18M5.636 5.636L6 6"></path>
                                                            </svg>
                                                        @else
                                                            {{-- Activate Icon --}}
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @endif
                                                    </button>
                                                </form>

                                                {{-- Delete Button --}}
                                                <form method="POST" action="{{ route('links.destroy', $link) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Are you sure you want to delete &quot;{{ $link->title }}&quot;? This action cannot be undone.')"
                                                            class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition duration-200 tooltip"
                                                            title="Delete Link">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-20">
                            <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full mx-auto mb-8 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">No links yet</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                                Create your first link to start building your LinkBio. Add links to your social media, website, portfolio, or anything you want to share!
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('links.create') }}" 
                                   class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Your First Link
                                </a>
                                <a href="{{ route('profile.show', Auth::user()->username) }}" 
                                   target="_blank"
                                   class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-lg transition duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                    </svg>
                                    Preview Profile
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .tooltip {
            position: relative;
        }
        
        .tooltip:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 0.25rem;
        }
    </style>
</x-app-layout>