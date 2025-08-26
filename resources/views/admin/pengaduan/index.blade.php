@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Daftar Pengaduan Penghuni</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if($pengaduans->count())
            <div class="overflow-x-auto rounded-lg shadow mt-10">
                <table class="min-w-full table-auto border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm">
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Penghuni</th>
                            <th class="px-4 py-2 border">Judul</th>
                            <th class="px-4 py-2 border">Deskripsi</th>
                            <th class="px-4 py-2 border">Lampiran</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Tanggapan</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $index => $item)
                            <tr class="text-sm">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $item->user->name }}</td>
                                <td class="px-4 py-2 border">{{ $item->judul }}</td>
                                <td class="px-4 py-2 border">{{ $item->deskripsi }}</td>
                                <td class="px-4 py-2 border">
                                    @if ($item->lampiran)
                                        <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-2 border">
                                    <form action="{{ route('admin.pengaduan.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="tanggapan" rows="2" class="border p-1 w-full text-sm">{{ old('tanggapan', $item->tanggapan) }}</textarea>
                                </td>
                                <td class="px-4 py-2 border">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-sm rounded">Kirim</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Belum ada pengaduan dari penghuni.</p>
        @endif
    </div>
@endsection
