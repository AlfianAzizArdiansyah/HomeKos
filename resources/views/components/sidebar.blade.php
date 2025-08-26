@if (Auth::user()->role === 'admin')
    <x-sidebar-link href="{{ route('admin.dashboard') }}" icon="layout-dashboard" :active="request()->routeIs('dashboard')">
        Dashboard
    </x-sidebar-link>

    <div class="pt-2 pb-1 text-xs text-gray-500 uppercase tracking-wider">Menu</div>

    <x-sidebar-link href="{{ route('admin.kamar.index') }}" icon="door-open" :active="request()->routeIs('kamar.*')">
        Kamar
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('admin.penghuni.index') }}" icon="users" :active="request()->routeIs('penghuni.*')">
        Penghuni
    </x-sidebar-link>

    <x-dropdown title="Pembayaran" icon="wallet" :open="request()->routeIs('admin.pembayaran.*')">
        <x-dropdown-link href="{{ route('admin.pembayaran.index') }}" :active="request()->routeIs('admin.pembayaran.index')">Tagihan</x-dropdown-link>
        <x-dropdown-link href="{{ route('admin.pembayaran.riwayat') }}" :active="request()->routeIs('admin.pembayaran.riwayat')">Riwayat
            Pembayaran</x-dropdown-link>
    </x-dropdown>

    <x-sidebar-link href="{{ route('admin.pengaduan.index') }}" icon="file-text" :active="request()->routeIs('pengaduan.*')">
        Data Pengaduan
    </x-sidebar-link>
@endif

@if (Auth::user()->role === 'penghuni')
    <x-sidebar-link href="{{ route('penghuni.dashboard') }}" icon="layout-dashboard" :active="request()->routeIs('penghuni.dashboard')">
        Dashboard
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('penghuni.pembayaran.riwayat-bayar') }}" icon="history" :active="request()->routeIs('penghuni.riwayat-bayar')">
        Riwayat Pembayaran
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('penghuni.pengaduan.index') }}" icon="alert-triangle" :active="request()->routeIs('penghuni.pengaduan.*')">
        Pengaduan
    </x-sidebar-link>

    <x-sidebar-link href="{{ route('penghuni.password.update-password') }}" icon="lock-keyhole"
        :active="request()->routeIs('penghuni.update-password')">
        Update Password
    </x-sidebar-link>

    <x-sidebar-link href="https://wa.me/{{ preg_replace('/^0/', '62', '085876014181') }}"
        icon="message-circle" target="_blank">
        Hubungi Admin
    </x-sidebar-link>
@endif
