<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }} - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" 
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="flex flex-col w-64 bg-gray-900">
            <div class="flex items-center justify-center h-16 px-4 bg-gray-800">
                <h1 class="text-white text-xl font-semibold">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Admin Dashboard
                </h1>
            </div>
            
            <nav class="mt-5 flex-1 px-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-tachometer-alt mr-3 w-5 h-5"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.users') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-users mr-3 w-5 h-5"></i>
                    Users
                </a>
                
                <a href="{{ route('admin.links') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.links*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-link mr-3 w-5 h-5"></i>
                    Links
                </a>
                
                <a href="{{ route('admin.statistics') }}" 
                   class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.statistics') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-chart-line mr-3 w-5 h-5"></i>
                    Statistics
                </a>
                
                <div class="border-t border-gray-700 mt-5 pt-5">
                    <a href="{{ route('dashboard') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                        <i class="fas fa-arrow-left mr-3 w-5 h-5"></i>
                        Back to Dashboard
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="group w-full flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-sign-out-alt mr-3 w-5 h-5"></i>
                            Sign Out
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Top bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-900">
                        @yield('page-title', 'Admin Dashboard')
                    </h2>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500">
                            Welcome, {{ auth()->user()->name }}
                        </div>
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto">
                <!-- Flash messages -->
                @if(session('success'))
                    <div class="mx-6 mt-4">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-6 mt-4">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
