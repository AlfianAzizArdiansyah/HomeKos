<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kost App') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-800 bg-[#f9fafb]">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r shadow-md transition-transform transform md:translate-x-0 md:static md:inset-0 flex flex-col justify-between"
            x-cloak>

            <div>
                <div class="p-4 text-4xl font-extrabold text-blue-700">HomeKos</div>
                <nav class="px-4 py-2 space-y-3 text-[17px]">
                    @include('components.sidebar')
                </nav>
            </div>

            <!-- Logout / Profile -->
            <div class="px-4 pb-4" x-data="{ openProfile: false }">
                <button @click="openProfile = !openProfile"
                    class="w-full flex items-center justify-between px-4 py-2 bg-white border border-blue-200 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center gap-2">
                        <div
                            class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">
                            {{ strtoupper(substr(Auth::check() ? Auth::user()->name : 'GU', 0, 2)) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700">
                            {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                        </span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
                </button>

                <div x-show="openProfile" @click.away="openProfile = false" x-cloak
                    class="mt-1 bg-white border border-blue-200 rounded-md shadow">
                    @if (Auth::check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left">
                                <i data-lucide="log-out" class="inline w-4 h-4 mr-2"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="block px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 text-left">
                            <i data-lucide="log-in" class="inline w-4 h-4 mr-2"></i> Login
                        </a>
                    @endif
                </div>
            </div>
        </aside>

        <!-- Overlay on mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
            class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden"></div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="flex items-center justify-between bg-white shadow px-4 py-3 md:hidden">
                <button @click="sidebarOpen = true" class="text-gray-600 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <h1 class="text-lg font-semibold text-blue-700">HomeKos</h1>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-4 bg-[#f1f5f9]">
                @if (isset($header))
                    <div class="mb-4 text-2xl font-semibold text-gray-800">
                        {{ $header }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
