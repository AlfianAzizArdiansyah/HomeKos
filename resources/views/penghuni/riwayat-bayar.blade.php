@extends('layouts.app')

@section('content')
    <div class="w-full mt-12 mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Riwayat Pembayaran</h2>
            <div class="flex items-center gap-4">
                <select class="border rounded-md px-3 py-1 text-gray-700">
                    <option>2025</option>
                    <!-- Tambahkan tahun lainnya jika perlu -->
                </select>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md">
                    Unduh PDF
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Bulan</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border">
                        <td class="px-4 py-2 border">1</td>
                        <td class="px-4 py-2 border">April 2025</td>
                        <td class="px-4 py-2 border">Rp 1.000.000</td>
                        <td class="px-4 py-2 border text-green-600 font-semibold">Lunas</td>
                        <td class="px-4 py-2 border">10-04-2025</td>
                    </tr>
                    <tr class="border">
                        <td class="px-4 py-2 border">2</td>
                        <td class="px-4 py-2 border">Mei 2025</td>
                        <td class="px-4 py-2 border">Rp 1.000.000</td>
                        <td class="px-4 py-2 border text-green-600 font-semibold">Lunas</td>
                        <td class="px-4 py-2 border">09-05-2025</td>
                    </tr>
                    <tr class="border">
                        <td class="px-4 py-2 border">3</td>
                        <td class="px-4 py-2 border">Juni 2025</td>
                        <td class="px-4 py-2 border">Rp 1.000.000</td>
                        <td class="px-4 py-2 border text-red-600 font-semibold">Belum<br>Lunas</td>
                        <td class="px-4 py-2 border">Bayar sebelum 10 Juni</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
