@extends('layouts.app')

@section('content')
    <div class="mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Form Pengaduan</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('penghuni.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold">Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                    class="w-full border p-2 rounded focus:outline-none focus:ring focus:border-blue-300">
                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block font-semibold">Deskripsi Pengaduan</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full border p-2 rounded focus:outline-none focus:ring focus:border-blue-300">{{ old('deskripsi') }}</textarea>
                @error('isi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block font-semibold">Lampiran (Opsional)</label>
                <input type="file" name="lampiran"
                    class="w-full border p-2 rounded focus:outline-none focus:ring focus:border-blue-300">
                @error('lampiran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim
                    Pengaduan</button>
            </div>
        </form>
    </div>
    <div class="mt-10 bg-white p-6 rounded shadow">
      <h1 class="text-xl font-semibold">Pengaduan Saya</h1>
      @foreach ($pengaduan as $item)
        <div class="border-t pt-4">
            <h3 class="font-bold text-lg">Judul : {{ $item->judul }}</h3>
            <p class="mb-2 text-gray-600">Deskripsi : {{ $item->deskripsi }}</p>

            @if ($item->lampiran)
                <p>Lampiran:
                    <a href="{{ asset('storage/' . $item->lampiran) }}" class="text-blue-600 underline"
                        target="_blank">Lihat File</a>
                </p>
            @endif

            @if ($item->tanggapan)
                <div class="bg-gray-100 p-3 rounded mt-3">
                    <strong class="block mb-1">Tanggapan Admin:</strong>
                    <p>{{ $item->tanggapan }}</p>
                </div>
            @else
                <p class="text-sm text-gray-400 italic">Belum ada tanggapan</p>
            @endif
        </div>
    @endforeach
    </div>
    
    
@endsection
