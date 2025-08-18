<x-guest-layout>
    <div class="text-center">
        {{-- Logo/Brand --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">LinkBio</h1>
            <p class="text-gray-600">Your all-in-one link-in-bio solution</p>
        </div>

        {{-- Hero Section --}}
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                Share all your links in one place
            </h2>
            <p class="text-gray-600 mb-6">
                Create a beautiful landing page for your social media bio. 
                Perfect for Instagram, TikTok, Twitter, and more.
            </p>
        </div>

        {{-- Features --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Custom Links</h3>
                <p class="text-sm text-gray-600">Add unlimited links to your page</p>
            </div>
            
            <div class="text-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Analytics</h3>
                <p class="text-sm text-gray-600">Track clicks and engagement</p>
            </div>
            
            <div class="text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-3 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 21h10a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a4 4 0 01-4 4z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Customizable</h3>
                <p class="text-sm text-gray-600">Personalize colors and themes</p>
            </div>
        </div>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            @auth
                <a href="{{ route('dashboard') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Get Started Free
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition duration-200">
                    Sign In
                </a>
            @endauth
        </div>

        {{-- Demo Section --}}
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">How it works</h3>
            <div class="space-y-4 text-left">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                    <div>
                        <h4 class="font-medium text-gray-900">Create your account</h4>
                        <p class="text-sm text-gray-600">Sign up for free and choose your unique username</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                    <div>
                        <h4 class="font-medium text-gray-900">Add your links</h4>
                        <p class="text-sm text-gray-600">Add links to your website, social media, store, and more</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                    <div>
                        <h4 class="font-medium text-gray-900">Share your link</h4>
                        <p class="text-sm text-gray-600">Use your LinkBio URL in your social media bio</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Example Profile Preview --}}
        <div class="bg-white border-2 border-gray-200 rounded-lg p-6 max-w-sm mx-auto">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-xl font-bold">
                    JD
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">@johndoe</h3>
                <p class="text-sm text-gray-600 mb-4">Content Creator & Designer</p>
                
                <div class="space-y-3">
                    <div class="border-2 border-blue-500 text-blue-500 py-2 px-4 rounded-lg text-sm font-medium">
                        🌐 My Website
                    </div>
                    <div class="border-2 border-blue-500 text-blue-500 py-2 px-4 rounded-lg text-sm font-medium">
                        📸 Instagram
                    </div>
                    <div class="border-2 border-blue-500 text-blue-500 py-2 px-4 rounded-lg text-sm font-medium">
                        🎥 YouTube Channel
                    </div>
                    <div class="border-2 border-blue-500 text-blue-500 py-2 px-4 rounded-lg text-sm font-medium">
                        🛍️ Online Store
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-12 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} LinkBio. Made with ❤️ for creators.</p>
        </div>
    </div>
</x-guest-layout>