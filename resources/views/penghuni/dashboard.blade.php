@extends('layouts.app')

@section('content')
    <div x-data="{ openUnggahBukti: false, selectedId: null }">

        <h1 class="text-2xl font-bold mb-6">Selamat datang, {{ Auth::user()->name }}</h1>

        <div class="space-y-6">
            <!-- Informasi Kamar -->
            <div class="bg-white rounded-lg shadow">
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


            <!-- Tagihan Pembayaran -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Tagihan Pembayaran</h2>

                <div class="overflow-x-auto rounded-lg shadow">
                    <table class="w-full border-collapse bg-white text-gray-800 text-md text-center">
                        <thead class="bg-blue-200 text-blue-900 uppercase text-base font-bold tracking-wide">
                            <tr>
                                <th class="px-4 py-3">Bulan</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Jatuh Tempo</th>
                                <th class="px-4 py-3">Bukti Bayar</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tagihan as $item)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($item->jatuh_tempo)->locale('id')->translatedFormat('F Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 rounded text-white
                                        {{ $item->status == 'Lunas' ? 'bg-green-500' : ($item->status == 'Proses' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>

                                    </td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if (!empty($item->bukti_bayar))
                                            <a href="{{ asset('storage/bukti/' . $item->bukti_bayar) }}" target="_blank"
                                                class="text-blue-600 underline">
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-gray-500">Belum Upload</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <!-- Tombol Buka Modal -->
                                        <button @click="openUnggahBukti = true; selectedId = {{ $item->id }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded shadow">
                                            Unggah Bukti
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada data
                                        pembayaran.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal Upload Bukti -->
            <div x-show="openUnggahBukti" x-cloak x-transition
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div @click.away="openUnggahBukti = false" class="bg-white p-6 rounded-lg w-full max-w-md shadow-lg text-left">
                    <h2 class="text-xl font-bold mb-4">Unggah Bukti Pembayaran</h2>
                    <form :action="`{{ route('penghuni.bukti-bayar', ':id') }}`.replace(':id', selectedId)" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="bukti_bayar" accept="image/*,.pdf"
                            class="block w-full text-sm mb-4 border border-gray-300 rounded px-3 py-2" required>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="openUnggahBukti = false"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
