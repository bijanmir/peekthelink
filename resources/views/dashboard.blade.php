<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Welcome back, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-gray-600 mt-1">Manage your LinkBio and track your performance</p>
            </div>
            <div class="hidden md:flex space-x-3">
                <a href="{{ route('links.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Link
                </a>
                <a href="{{ route('profile.show', $user->username) }}" 
                   target="_blank"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                    </svg>
                    View Profile
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Links Card -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 overflow-hidden shadow-lg rounded-2xl border border-blue-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-600">Total Links</h3>
                                <p class="text-3xl font-bold text-gray-900">{{ $links->count() }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($links->count() > 0)
                                        {{ $links->where('is_active', true)->count() }} active
                                    @else
                                        Get started by adding your first link
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Clicks Card -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-100 overflow-hidden shadow-lg rounded-2xl border border-emerald-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-600">Total Clicks</h3>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($totalClicks) }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($totalClicks > 0 && $links->count() > 0)
                                        Avg {{ number_format($totalClicks / $links->count(), 1) }} per link
                                    @else
                                        Start sharing to get clicks
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Performance Card -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-100 overflow-hidden shadow-lg rounded-2xl border border-purple-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-sm font-medium text-gray-600">Profile Status</h3>
                                <p class="text-3xl font-bold text-gray-900">
                                    @if($user->is_active)
                                        <span class="text-emerald-600">Live</span>
                                    @else
                                        <span class="text-red-600">Draft</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-1">Your LinkBio is {{ $user->is_active ? 'public' : 'private' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Section --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl mb-8 border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h3>
                    <p class="text-gray-500 mt-1">Manage your LinkBio with these shortcuts</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('links.create') }}" 
                           class="group bg-gradient-to-br from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 border border-blue-200 rounded-xl p-4 transition duration-200 hover:shadow-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition duration-200">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-900">Add Link</p>
                                    <p class="text-xs text-gray-500">Create new link</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('profile.show', $user->username) }}" 
                           target="_blank"
                           class="group bg-gradient-to-br from-emerald-50 to-teal-50 hover:from-emerald-100 hover:to-teal-100 border border-emerald-200 rounded-xl p-4 transition duration-200 hover:shadow-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition duration-200">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M14 6h6m0 0v6m0-6L10 16"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-900">View Profile</p>
                                    <p class="text-xs text-gray-500">See your public page</p>
                                </div>
                            </div>
                        </a>

                        <button onclick="copyProfileUrl()" 
                                class="group bg-gradient-to-br from-purple-50 to-pink-50 hover:from-purple-100 hover:to-pink-100 border border-purple-200 rounded-xl p-4 transition duration-200 hover:shadow-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition duration-200">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-900">Copy URL</p>
                                    <p class="text-xs text-gray-500">Share your link</p>
                                </div>
                            </div>
                        </button>

                        <a href="{{ route('links.index') }}" 
                           class="group bg-gradient-to-br from-orange-50 to-red-50 hover:from-orange-100 hover:to-red-100 border border-orange-200 rounded-xl p-4 transition duration-200 hover:shadow-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition duration-200">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-900">Manage</p>
                                    <p class="text-xs text-gray-500">Edit all links</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Recent Links Section --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Your Links
                            </h3>
                            <p class="text-gray-500 mt-1">Recent links and performance</p>
                        </div>
                        <a href="{{ route('links.index') }}" 
                           class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center transition duration-200">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($links->count() > 0)
                        <div class="space-y-4">
                            @foreach($links->take(5) as $link)
                                <div class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition duration-200 border border-gray-200">
                                    <div class="flex items-center flex-1">
                                        <div class="w-10 h-10 bg-gradient-to-br {{ $link->is_active ? 'from-emerald-400 to-emerald-600' : 'from-gray-400 to-gray-600' }} rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $link->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ Str::limit($link->url, 50) }}</p>
                                            @if($link->description)
                                                <p class="text-xs text-gray-400 mt-1">{{ Str::limit($link->description, 60) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="text-center">
                                            <p class="text-lg font-bold text-gray-900">{{ $link->clicks }}</p>
                                            <p class="text-xs text-gray-500">clicks</p>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $link->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $link->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <a href="{{ route('links.edit', $link) }}" 
                                           class="text-blue-600 hover:text-blue-700 transition duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No links yet</h3>
                            <p class="text-gray-500 mb-6">Start building your LinkBio by adding your first link!</p>
                            <a href="{{ route('links.create') }}" 
                               class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Your First Link
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyProfileUrl() {
            const url = '{{ route('profile.show', $user->username) }}';
            navigator.clipboard.writeText(url).then(function() {
                // Create a modern toast notification
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full';
                toast.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Profile URL copied to clipboard!
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Animate in
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 3000);
            });
        }
    </script>
</x-app-layout>