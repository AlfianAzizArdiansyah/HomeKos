@extends('layouts.app')

@section('content')
    <div class="w-full mt-12 mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Riwayat Pembayaran</h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('penghuni.pembayaran.cetak-pdf') }}" target="_blank"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow transition duration-200">
                    Unduh PDF
                </a>
            </div>
        </div>

        <div class="p-6 bg-white rounded-xl shadow-md">
            {{-- <h1 class="text-3xl font-bold text-gray-800 mb-6">
                Daftar Pembayaran Bulanan {{ $pembayaran->penghuni->nama }}
            </h1>

            <div class="mb-4">
                <p><strong>Kamar :</strong> {{ $pembayaran->penghuni->kamar->nama_kamar ?? '-' }}</p>
                <p><strong>Harga :</strong> Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
            </div> --}}

            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-2">Riwayat Bayar Bulanan</h2>
                <table class="w-full text-center border-collapse bg-white text-gray-800 shadow rounded-lg">
                    <thead class="bg-indigo-100 text-indigo-900">
                        <tr>
                            <th class="py-2 px-4 border">Bulan</th>
                            <th class="py-2 px-4 border">Tanggal Bayar</th>
                            <th class="py-2 px-4 border">Jumlah</th>
                            <th class="py-2 px-4 border">Bukti Bayar</th>
                            <th class="py-2 px-4 border">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPembayaran as $data)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_bayar)->translatedFormat('F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_bayar)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($data->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if ($data->bukti_bayar)
                                        <a href="{{ asset('storage/bukti/' . $data->bukti_bayar) }}" target="_blank"
                                            class="text-blue-600 underline">
                                            Lihat Bukti</a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('penghuni.pembayaran.invoice', $data->id) }}" target="_blank"
                                        class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded-md shadow inline-flex items-center justify-center"
                                        title="Download Invoice">
                                        <!-- Ikon Download -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">
                                    Belum ada riwayat pembayaran bulanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection