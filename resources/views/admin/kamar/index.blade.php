@extends('layouts.app')
@section('content')
    <div x-data="{ tambahKamar: false, editKamar: false, kamarData: {} }" class="p-6 bg-white rounded-xl shadow-md">

        <!-- Judul & Tombol -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-wide">Manajemen Kamar</h1>
            <button @click="tambahKamar = true"
                class="bg-blue-600 text-white text-lg px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition-all duration-200">
                Tambah Kamar
            </button>
        </div>

        <!-- Modal Tambah -->
        @include('admin.kamar.create')

        <!-- Modal Edit -->
        @include('admin.kamar.edit')

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full border-collapse bg-white text-gray-800 text-lg">
                <thead class="bg-blue-200 text-blue-900 uppercase text-base font-bold tracking-wide">
                    <tr>
                        <th class="px-6 py-4 text-center">Kamar</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Fasilitas</th>
                        <th class="px-6 py-4 text-center">Harga</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kamars as $kamar)
                                            <tr class="border-t hover:bg-blue-50 text-lg text-center">
                                                <td class="px-6 py-4 font-medium">{{ $kamar->nama_kamar }}</td>

                                                <td class="px-6 py-4">
                                                    <span
                                                        class="px-3 py-1 rounded-full text-sm font-semibold {{ $kamar->status == 'tersedia' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                        {{ ucfirst($kamar->status) }}
                                                    </span>
                                                </td>

                                                <td class="px-6 py-4 space-x-1">
                                                    @php
                                                        $fasilitas = is_array($kamar->fasilitas) ? $kamar->fasilitas : json_decode($kamar->fasilitas, true);
                                                    @endphp

                                                    @if (!empty($fasilitas))
                                                        @foreach ($fasilitas as $item)
                                                            <span class="inline-block bg-gray-200 text-gray-800 text-sm px-3 py-1 rounded-lg">
                                                                {{ $item }}
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        <span class="inline-block text-gray-500 italic text-sm">Kamar Kosongan</span>
                                                    @endif
                                                </td>

                                                <td class="px-6 py-4">
                                                    Rp{{ number_format($kamar->harga, 0, ',', '.') }}
                                                </td>


                                                <td class="px-6 py-4 inline-flex gap-2">
                                                    <button @click="editKamar = true; kamarData = {{ $kamar->toJson() }}"
                                                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-5 py-2 rounded-md shadow">
                                                        Edit
                                                    </button>

                                                    <div x-data="{ openDeleteModal: false }" x-cloak>
                                                        <!-- Button untuk membuka modal Tambah Kelas -->
                                                        <button type="button"
                                                            class="bg-red-600 hover:bg-red-700 text-white text-sm px-5 py-2 rounded-md shadow"
                                                            @click="openDeleteModal = true">Hapus</button>
                                                        @include('form.hapus-modal', [
                            'actionUrl' => route('admin.kamar.destroy', $kamar),
                            'modalTitle' => 'Hapus Kamar',
                            'itemName' => $kamar->nama_kamar,
                        ])
                                                    </div>
                                                </td>
                                            </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-6 text-gray-500 text-lg">Belum ada data kamar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6">
                {{ $kamars->links() }}
            </div>
        </div>
    </div>
@endsection
