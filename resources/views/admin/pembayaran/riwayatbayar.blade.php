@extends('layouts.app')

@section('content')
    <div class="p-6 bg-white rounded-xl shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Daftar Pembayaran Bulanan {{ $pembayaran->penghuni->nama }}
        </h1>

        <div class="mb-4">
            <p><strong>Kamar :</strong> {{ $pembayaran->penghuni->kamar->nama_kamar ?? '-' }}</p>
            <p><strong>Harga :</strong> Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-2">Riwayat Bayar Bulanan</h2>
            <table class="w-full text-center border-collapse bg-white text-gray-800 shadow rounded-lg">
                <thead class="bg-indigo-100 text-indigo-900">
                    <tr>
                        <th class="py-2 px-4 border">Bulan</th>
                        <th class="py-2 px-4 border">Tanggal Bayar</th>
                        <th class="py-2 px-4 border">Jumlah</th>
                        <th class="py-2 px-4 border">Bukti Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semuaPembayaran as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_bayar)->translatedFormat('F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_bayar)->format('d M Y') }}</td>
                            <td>Rp {{ number_format($data->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if ($data->bukti_bayar)
                                    <a href="{{ asset('storage/bukti/' . $data->bukti_bayar) }}" target="_blank">
                                        Lihat Bukti</a>
                                @else
                                    -
                                @endif
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
@endsection
