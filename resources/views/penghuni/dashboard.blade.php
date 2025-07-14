@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Selamat datang, {{ Auth::user()->name }}</h1>

    <div class="space-y-6">
        <!-- Informasi Kamar -->
        <div class="rounded-lg shadow">
            <div class="bg-blue-400 text-white p-4 rounded-t-xl flex items-center justify-between">
                <h1 class="text-xl font-bold">Informasi Kamar</h1>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-[150px_1fr] gap-y-2 text-md text-gray-700 p-6">
                {{-- Nomor Kamar --}}
                <div class="font-semibold">Nomor Kamar </div>
                <div>: {{ $kamar->nama_kamar ?? '-' }}</div>

                {{-- Fasilitas --}}
                <div class="font-semibold">Fasilitas </div>
                <div class="flex flex-wrap gap-2">:
                    @foreach ($kamar->fasilitas as $fasilitas)
                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                            {{ $fasilitas }}
                        </span>
                    @endforeach
                </div>

                {{-- Harga --}}
                <div class="font-semibold">Harga </div>
                <div>: Rp {{ number_format($kamar->harga ?? 0, 0, ',', '.') }}/bulan</div>

                {{-- Status --}}
                <div class="font-semibold">Status </div>
                <div>: {{ $kamar->status ?? '-' }}</div>
            </div>
        </div>


        <!-- Status Pembayaran -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Tagihan Pembayaran</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-md text-left border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Bulan</th>
                            <th class="px-4 py-2">Jumlah</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Batas Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembayaranBulanIni as $pembayaran)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $pembayaran->bulan }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                <td
                                    class="px-4 py-2 font-medium {{ $pembayaran->status === 'Lunas' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $pembayaran->status }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada data pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- resources/views/tenant/dashboard.blade.php -->
    {{-- <div class="min-h-screen bg-gray-100 p-6">
        <!-- Header -->
        <div class="bg-navy-800 text-white p-4 rounded-t-xl flex items-center justify-between">
            <h1 class="text-xl font-bold">whkost <span class="font-normal">| Tenant</span></h1>
            <div class="bg-white p-2 rounded-full">
                <svg class="w-6 h-6 text-navy-800" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.2c-3.1 0-9.3 1.6-9.3 4.9v2.2h18.6v-2.2c0-3.3-6.2-4.9-9.3-4.9z" />
                </svg>
            </div>
        </div>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 bg-white p-6 rounded-b-xl shadow">
            <!-- Status Pembayaran -->
            <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                <div class="flex justify-center mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-semibold">Status Pembayaran</p>
                <p class="text-green-700 font-bold">LUNAS</p>
            </div>

            <!-- Pengumuman -->
            <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                <div class="flex justify-center mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9 3a1 1 0 011-1h1a1 1 0 011 1v2.382a1 1 0 01-.553.894l-3 1.5A1 1 0 018 6.618V3zM5 10a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm12-1a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1z" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-semibold">Pengumuman</p>
                <p class="text-sm text-gray-500">Pengumuman penting untuk penghuni kost...</p>
            </div>

            <!-- Tagihan Bulanan -->
            <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                <div class="flex justify-center mb-2">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 3h14a1 1 0 011 1v2H2V4a1 1 0 011-1zm15 4v9a1 1 0 01-1 1H3a1 1 0 01-1-1V7h16z" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-semibold">Tagihan Bulanan</p>
                <p class="font-bold text-gray-700">Rp 1.500.000</p>
            </div>

            <!-- Pengaduan -->
            <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                <div class="flex justify-center mb-2">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M12 20h9" />
                            <path stroke-width="2" d="M12 4v16m0 0l-3-3m3 3l3-3" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-semibold">Pengaduan</p>
                <button class="mt-2 px-4 py-2 bg-navy-700 text-white rounded hover:bg-navy-800">Buat Pengaduan</button>
            </div>

            <!-- Update Data -->
            <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                <div class="flex justify-center mb-2">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a5 5 0 00-3.58 8.53A7 7 0 003 17h2a5 5 0 015-5h2a5 5 0 015 5h2a7 7 0 00-3.42-6.47A5 5 0 0010 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-semibold">Update Data</p>
                <p class="text-sm text-gray-500">Data Diri / Kamar</p>
            </div>

            <!-- Chat Admin -->
            <div class="bg-white p-4 rounded-xl border text-center shadow-sm">
                <div class="flex justify-center mb-2">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-semibold">Chat dengan Admin</p>
            </div>
        </div>
    </div>

    <style>
        .bg-navy-800 {
            background-color: #1E293B;
            /* Tailwind slate-800 or custom navy */
        }

        .bg-navy-700 {
            background-color: #334155;
        }

        .hover\:bg-navy-800:hover {
            background-color: #1E293B;
        }
    </style> --}}


    <!-- resources/views/penghuni/dashboard.blade.php -->
    {{-- <div class="bg-gray-100 min-h-screen">
        <!-- Navbar -->
        <nav class="bg-blue-400 p-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="text-2xl">🏠</div>
                <span class="text-xl font-semibold">HomeKos</span>
            </div>
            <div class="text-3xl">≡</div>
        </nav>

        <!-- Table Pembayaran -->
        <div class="p-6">
            <table class="w-full table-auto border border-black text-center">
                <thead class="bg-blue-200 border border-black">
                    <tr>
                        <th class="px-4 py-2 border">No. Kamar</th>
                        <th class="px-4 py-2 border">Tgl Bayar Terakhir</th>
                        <th class="px-4 py-2 border">Durasi Bayar</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-blue-50">
                    <tr>
                        <td class="px-4 py-2 border">2</td>
                        <td class="px-4 py-2 border">16-06-2024</td>
                        <td class="px-4 py-2 border">2 Bulan</td>
                        <td class="px-4 py-2 border space-x-2">
                            <button class="bg-blue-400 hover:bg-blue-500 px-4 py-1 rounded">Bayar</button>
                            <button class="bg-blue-400 hover:bg-blue-500 px-4 py-1 rounded">Keluhan</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Contact Section -->
        <div class="text-center my-10">
            <h2 class="text-2xl font-semibold underline decoration-blue-400">Contact</h2>
            <p class="mt-2 text-gray-600">Kontak untuk pertanyaan lebih lanjut silakan hubungi</p>

            <div class="mx-auto mt-6 bg-blue-200 max-w-sm p-6 rounded-2xl shadow-md">
                <h3 class="text-xl font-semibold">Rusdi Awamalum</h3>
                <p class="text-lg text-gray-800">087731366528</p>

                <div class="flex justify-center mt-4 space-x-4">
                    <button onclick="navigator.clipboard.writeText('087731366528')"
                        class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded">
                        Copy Number
                    </button>
                    <a href="https://wa.me/6287731366528" target="_blank"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12.01 2c5.53 0 10 4.47 10 10 0 1.77-.46 3.43-1.28 4.88l1.16 4.22-4.34-1.13C15.5 21.15 13.81 21.7 12 21.7c-5.52 0-10-4.48-10-10s4.48-9.7 10.01-9.7zm0-2C5.37 0 0 5.37 0 12c0 2.03.51 3.94 1.41 5.6L0 24l6.73-1.78A11.97 11.97 0 0 0 12 24c6.63 0 12-5.37 12-12S18.63 0 12.01 0z" />
                        </svg>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-blue-400 py-6 text-center text-black">
            <div class="flex justify-center space-x-4 mb-2 text-2xl">
                <a href="#" class="hover:text-gray-700">📘</a>
                <a href="#" class="hover:text-gray-700">📷</a>
                <a href="#" class="hover:text-gray-700">✈️</a>
            </div>
            <p class="text-sm">&copy; 2025, HomeKos</p>
        </footer>
    </div> --}}
@endsection
