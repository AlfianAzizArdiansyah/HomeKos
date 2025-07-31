@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white rounded-xl shadow-md">
        <!-- Judul -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-wide">Riwayat Pembayaran</h1>
        </div>

        <!-- Tabel Riwayat -->
        <div class="overflow-x-auto rounded-lg shadow mt-4">
            <table class="w-full border-collapse bg-white text-gray-800 text-lg text-center">
                <thead class="bg-blue-200 text-blue-900 uppercase text-base font-bold tracking-wide">
                    <tr>
                        <th class="px-6 py-4">Nama Penghuni</th>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Harga Kamar</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $pembayaran)
                        <tr class="border-t hover:bg-blue-50">
                            <td class="px-6 py-4">{{ $pembayaran->penghuni->nama }}</td>
                            <td class="px-6 py-4">{{ $pembayaran->penghuni->kamar->nama_kamar ?? '-' }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pembayaran.riwayatbayar', $pembayaran->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-5 py-2 rounded-md shadow">
                                    Daftar bayar bulanan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 px-6 py-6">Belum ada riwayat pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6">
                {{ $pembayarans->links() }}
            </div>
        </div>
    </div>
@endsection