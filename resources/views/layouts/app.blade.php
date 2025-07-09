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

<body class="h-screen overflow-hidden bg-[#f9fafb] text-gray-800 antialiased font-sans">
    <div class="h-full flex" x-data="{ menuOpen: false, submenuOpen: false }">
        <aside class="w-64 h-full flex flex-col justify-between bg-white border-r shadow-sm">
            <div class="p-4 text-4xl font-extrabold text-blue-700 tracking-wide">HomeKos</div>

            <nav class="flex-1 space-y-4 px-4 py-4 text-[17px]">
                @if (Auth::user()->role === 'admin')
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition hover:bg-blue-100 text-xl font-bold {{ request()->routeIs('dashboard') ? 'bg-blue-200 text-blue-900' : 'text-gray-700' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        Dashboard
                    </a>

                    <!-- Label MENU -->
                    <div class=" pt-2 pb-2 text-xs text-gray-500 uppercase tracking-wider">
                        MENU
                    </div>

                    <!-- Kamar -->
                    <a href="{{ route('admin.kamar.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition hover:bg-blue-100 text-[16px] font-semibold {{ request()->routeIs('kamar.*') ? 'bg-blue-200 text-blue-900' : 'text-gray-700' }}">
                        <i data-lucide="door-open" class="w-5 h-5"></i>
                        Kamar
                    </a>

                    <!-- Penghuni -->
                    <a href="{{ route('admin.penghuni.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg transition hover:bg-blue-100 text-[16px] font-semibold {{ request()->routeIs('penghuni.*') ? 'bg-blue-200 text-blue-900' : 'text-gray-700' }}">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        Penghuni
                    </a>

                    <!-- Pembayaran -->
                    <div x-data="{ open: {{ request()->routeIs('admin.pembayaran.*') ? 'true' : 'false' }} }" class="relative">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-blue-100 transition text-[16px] font-semibold {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-200 text-blue-900' : 'text-gray-700' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="wallet" class="w-5 h-5"></i>
                                Pembayaran
                            </span>
                            <i data-lucide="chevron-right" :class="{ 'rotate-90': open }"
                                class="w-5 h-5 transform transition-transform"></i>
                        </button>

                        <div x-show="open" x-cloak x-transition class="mt-1 space-y-1">
                            <a href="{{ route('admin.pembayaran.index') }}"
                                class="block px-4 py-2 text-[16px] rounded hover:bg-blue-50 {{ request()->routeIs('admin.pembayaran.index') ? 'text-blue-700 font-medium' : 'text-gray-600' }}">
                                Tagihan
                            </a>
                            <a href="{{ route('admin.pembayaran.riwayat') }}"
                                class="block px-4 py-2 text-[16px] rounded hover:bg-blue-50 {{ request()->routeIs('admin.pembayaran.riwayat') ? 'text-blue-700 font-medium' : 'text-gray-600' }}">
                                Riwayat Pembayaran
                            </a>
                        </div>
                    </div>
                @endif

                {{-- <!-- Laporan -->
                <a href="{{ route('admin.laporan.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition hover:bg-blue-100 text-[16px] font-semibold {{ request()->routeIs('laporan.*') ? 'bg-blue-200 text-blue-900' : 'text-gray-700' }}">
                    <i data-lucide="file-bar-chart" class="w-5 h-5"></i>
                    Laporan
                </a> --}}
            </nav>

            <!-- Logout -->
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
                    class="mt-1 w-full bg-white border border-blue-200 rounded-md shadow z-50">
                    @if (Auth::check())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left rounded-b-md">
                                <i data-lucide="log-out" class="inline w-4 h-4 mr-2"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="block px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 text-left rounded-b-md">
                            <i data-lucide="log-in" class="inline w-4 h-4 mr-2"></i> Login
                        </a>
                    @endif
                </div>
            </div>
        </aside>

        <main class="flex-1 p-6 bg-[#f1f5f9] overflow-y-auto h-full">
            @if (isset($header))
                <header class="mb-4">
                    <div class="text-2xl font-semibold text-gray-800">
                        {{ $header }}
                    </div>
                </header>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
