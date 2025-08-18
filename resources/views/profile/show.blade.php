<x-guest-layout>
    <div class="min-h-screen" style="background-color: {{ $user->theme_color }}20;">
        <div class="max-w-md mx-auto px-4 py-8">
            {{-- Profile Header --}}
            <div class="text-center mb-8">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                         alt="{{ $user->display_name ?? $user->name }}"
                         class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4"
                         style="border-color: {{ $user->theme_color }};">
                @else
                    <div class="w-24 h-24 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold"
                         style="background-color: {{ $user->theme_color }};">
                        {{ strtoupper(substr($user->display_name ?? $user->name, 0, 1)) }}
                    </div>
                @endif
                
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ $user->display_name ?? $user->name }}
                </h1>
                
                @if($user->bio)
                    <p class="text-gray-600 text-sm mb-4">{{ $user->bio }}</p>
                @endif
            </div>

            {{-- Links --}}
            <div class="space-y-4">
                @forelse($links as $link)
                    <a href="{{ route('profile.link', [$user->username, $link->id]) }}"
                       class="block w-full p-4 rounded-lg border-2 text-center transition-all hover:scale-105 hover:shadow-lg"
                       style="border-color: {{ $user->theme_color }}; color: {{ $user->theme_color }};"
                       onclick="handleLinkClick(event, '{{ route('profile.link', [$user->username, $link->id]) }}')">
                        <div class="font-semibold">{{ $link->title }}</div>
                        @if($link->description)
                            <div class="text-sm text-gray-600 mt-1">{{ $link->description }}</div>
                        @endif
                    </a>
                @empty
                    <div class="text-center text-gray-500 py-8">
                        No links available yet.
                    </div>
                @endforelse
            </div>

            {{-- Footer --}}
            <div class="text-center mt-12 text-gray-400 text-xs">
                <p>Powered by LinkBio</p>
            </div>
        </div>
    </div>

    <script>
        function handleLinkClick(event, url) {
            // Debug: Log the URL to console
            console.log('Clicking link:', url);
            
            // Let the default behavior happen (follow the href)
            // The server will handle the redirect
            return true;
        }
    </script>
</x-guest-layout>