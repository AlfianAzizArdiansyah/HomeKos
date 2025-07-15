@extends('layouts.app')

@section('content')
    <div x-data="{ tambahPembayaran: false, editPembayaran: false, pembayaranData: {}, openEditPembayaran(data) { this.pembayaranData = { ...data };
            this.editPembayaran = true; } }" class="p-6 bg-white rounded-xl shadow-md">

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
        <div x-show="editPembayaran" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">

            <div @click.away="editPembayaran = false"
                class="relative bg-white rounded-xl shadow-2xl w-full max-w-xl p-6 border border-indigo-300">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-indigo-700">Edit Pembayaran</h2>
                    <button @click="editPembayaran = false"
                        class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-white bg-red-500 hover:bg-red-600 rounded-full shadow-lg text-2xl font-bold transition duration-200"
                        title="Tutup">
                        &times;
                    </button>
                </div>

                <form method="POST" :action="'/admin/pembayaran/' + pembayaranData.id">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 mb-1">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" x-model="pembayaranData.jumlah"
                            class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-indigo-500">
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 mb-1">Jatuh Tempo</label>
                        <input type="date" name="jatuh_tempo" x-model="pembayaranData.jatuh_tempo"
                            class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-indigo-500">
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold text-gray-700 mb-1">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" x-model="pembayaranData.tanggal_bayar"
                            class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold text-gray-700 mb-1">Status</label>
                        <select name="status" x-model="pembayaranData.status"
                            class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-indigo-500">
                            <option value="belum bayar">Belum Bayar</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow transition duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

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
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $pembayaran)
                        <tr class="border-t hover:bg-blue-50 text-md">
                            <td class="px-6 py-4">{{ $pembayaran->penghuni->nama }}</td>
                            <td class="px-6 py-4">{{ $pembayaran->penghuni->kamar->nama_kamar ?? '-' }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pembayaran->jatuh_tempo)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $pembayaran->status === 'Lunas' ? 'bg-green-200 text-green-800' : ($pembayaran->status === 'Proses' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                                    {{ ucfirst($pembayaran->status) }}
                                </span>
                            </td>
                            <td class="px-6
                                    py-4">
                                    <div class="flex justify-center items-center gap-2">
                                        <button
                                            @click="openEditPembayaran({id: {{ $pembayaran->id }}, jumlah: {{ $pembayaran->jumlah }}, jatuh_tempo: '{{ $pembayaran->jatuh_tempo }}',tanggal_bayar: '{{ $pembayaran->tanggal_bayar }}',status: '{{ $pembayaran->status }}'})"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-5 py-2 rounded-md shadow">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.pembayaran.destroy', $pembayaran) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pembayaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white text-sm px-5 py-2 rounded-md shadow">
                                                Hapus
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.pembayaran.struk', $pembayaran->id) }}" target="_blank"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-5 py-2 rounded-md shadow">
                                            Cetak Struk
                                        </a>
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
