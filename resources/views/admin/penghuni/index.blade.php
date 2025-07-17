@extends('layouts.app')
@section('content')
    <div x-data="{ tambahPenghuni: false, editPenghuni: false, penghuniData: {} }" class="p-6 bg-white rounded-xl shadow-md">

        <!-- Judul & Tombol -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-wide">Manajemen Penghuni</h1>
            <button @click="tambahPenghuni = true"
                class="bg-blue-600 text-white text-lg px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition-all duration-200">
                Tambah Penghuni
            </button>
        </div>

        <!-- Modal Tambah -->
        @include('admin.penghuni.create')

        <!-- Modal Edit -->
        @include('admin.penghuni.edit')

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full border-collapse bg-white text-gray-800 text-lg text-center">
                <thead class="bg-blue-200 text-blue-900 uppercase text-base font-bold tracking-wide">
                    <tr>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">No HP</th>                        
                        <th class="px-6 py-4">Tanggal Masuk</th>                        
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">KTP</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penghunis as $penghuni)
                        <tr class="border-t hover:bg-blue-50 text-lg">
                            <td class="px-6 py-4">{{ $penghuni->kamar->nama_kamar ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $penghuni->nama }}</td>
                            <td class="px-6 py-4">{{ $penghuni->user->email ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $penghuni->no_hp }}</td>
                            <td class="px-6 py-4">{{ $penghuni->tanggal_masuk }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-semibold {{ $penghuni->status === 'aktif' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ ucfirst($penghuni->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($penghuni->foto_ktp)
                                    <a href="{{ asset('storage/' . $penghuni->foto_ktp) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $penghuni->foto_ktp) }}"
                                            class="mx-auto w-24 h-16 object-cover rounded-md border shadow hover:scale-105 transition"
                                            alt="KTP {{ $penghuni->nama }}">
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    <button type="button" @click="editPenghuni = true; penghuniData = @js($penghuni)"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-5 py-2 rounded-md shadow">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.penghuni.destroy', $penghuni) }}"
                                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white text-sm px-5 py-2 rounded-md shadow">
                                            Hapus
                                        </button>
                                    </form>

                                    <!-- Tombol WhatsApp -->
                                    @php
                                        $nomorWA = preg_replace('/^0/', '62', $penghuni->no_hp);
                                        $pesanWA = "Halo $penghuni->nama, saya dari admin kos. Ingin menghubungi terkait tagihan kost bulan ini.";
                                    @endphp

                                    <a href="https://wa.me/{{ $nomorWA }}?text={{ urlencode($pesanWA) }}" target="_blank"
                                        class="bg-green-500 hover:bg-green-600 text-white text-sm px-5 py-2 rounded-md shadow flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M20.52 3.48a11.8 11.8 0 0 0-16.7 0c-4.37 4.36-4.56 11.4-.45 15.99L2 22l2.53-.38c1.11.62 2.33.94 3.58.94 6.29 0 11.4-5.11 11.4-11.4 0-3.03-1.18-5.87-3.28-8a11.86 11.86 0 0 0-2.42-2.07zM12 21c-1.04 0-2.08-.21-3.06-.63l-.23-.1-2.56.38.39-2.55-.1-.23c-.78-1.46-1.16-3.11-1.11-4.76.12-5.27 4.4-9.55 9.67-9.67 2.53-.05 4.92.9 6.68 2.67 1.77 1.76 2.72 4.15 2.67 6.68-.12 5.27-4.4 9.55-9.67 9.67z" />
                                            <path
                                                d="M16.67 13.66c-.23-.12-1.36-.67-1.58-.75-.21-.07-.36-.12-.5.12-.15.23-.58.74-.72.9-.13.15-.27.17-.5.06-.23-.12-.97-.36-1.84-1.13-.68-.6-1.15-1.33-1.29-1.56-.13-.23-.01-.36.1-.48.1-.1.23-.27.35-.4.12-.13.16-.23.23-.39.08-.15.04-.29-.02-.4-.06-.12-.5-1.2-.69-1.65-.18-.43-.36-.37-.5-.37l-.43-.01c-.14 0-.36.05-.55.23-.19.19-.73.71-.73 1.74s.75 2.02.86 2.16c.1.13 1.48 2.26 3.6 3.17 2.12.91 2.12.61 2.5.57.39-.03 1.25-.5 1.43-.98.18-.49.18-.9.13-.98-.06-.08-.22-.13-.45-.25z" />
                                        </svg>
                                        Chat
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-6 text-gray-500 text-lg">
                                Belum ada data penghuni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Navigasi Pagination -->
        <div class="mt-6">
            {{ $penghunis->links() }}
        </div>

    </div>
@endsection