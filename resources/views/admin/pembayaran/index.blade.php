@extends('layouts.app')

@section('content')
    <div x-data="{ tambahPembayaran: false, editPembayaran: false, pembayaranData: {},openEditPembayaran(data) { this.pembayaranData = { ...data }; this.editPembayaran = true;}}"
        class="p-6 bg-white rounded-xl shadow-md">
        <!-- Judul & Tombol -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-wide">Tagihan Pembayaran</h1>
            <button @click="tambahPembayaran = true"
                class="bg-blue-600 text-white text-lg px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition-all duration-200">
                Tambah Tagihan
            </button>
        </div>

        <!-- Modal Tambah -->
        @include('admin.pembayaran.create')

        <!-- Modal Edit -->
        @include('admin.pembayaran.edit')

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg shadow mt-10">
            <table class="w-full border-collapse bg-white text-gray-800 text-md text-center">
                <thead class="bg-blue-200 text-blue-900 uppercase text-base font-bold tracking-wide">
                    <tr>
                        <th class="px-6 py-4">Nama penghuni</th>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Jatuh Tempo</th>
                        <th class="px-6 py-4">Tanggal Bayar</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Bukti Bayar</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $pembayaran)
                        <tr class="border-t hover:bg-blue-50 text-md">
                            <td class="px-6 py-4">{{ $pembayaran->penghuni->nama }}</td>
                            <td class="px-6 py-4">{{ $pembayaran->penghuni->kamar->nama_kamar ?? '-' }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pembayaran->jatuh_tempo)->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                {{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $pembayaran->status === 'Lunas' ? 'bg-green-200 text-green-800' : ($pembayaran->status === 'Proses' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">{{ ucfirst($pembayaran->status) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($pembayaran->bukti_bayar)
                                    <a href="{{ asset('storage/bukti/' . $pembayaran->bukti_bayar) }}" target="_blank"
                                        class="text-blue-600 hover:underline">Lihat Bukti</a>
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    <button
                                        @click="openEditPembayaran({id: {{ $pembayaran->id }},jumlah: {{ $pembayaran->jumlah }},jatuh_tempo: '{{ \Carbon\Carbon::parse($pembayaran->jatuh_tempo)->format('Y-m-d') }}',tanggal_bayar: '{{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('Y-m-d') : '' }}',status: '{{ $pembayaran->status }}'})"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-5 py-2 rounded-md shadow">Edit</button>
                                    <div x-data="{ openDeleteModal: false }" x-cloak>
                                        <!-- Button untuk membuka modal Tambah Kelas -->
                                        <button type="button"
                                            class="bg-red-600 hover:bg-red-700 text-white text-sm px-5 py-2 rounded-md shadow"
                                            @click="openDeleteModal = true">Hapus</button>
                                        @include('form.hapus-modal', ['actionUrl' => route('admin.pembayaran.destroy', $pembayaran), 'modalTitle' => 'Hapus Tagihan', 'itemName' => "tagihan pembayaran {$pembayaran->penghuni->nama}",])
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center px-6 py-6 text-gray-500 text-lg">
                                Belum ada data pembayaran.
                            </td>
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