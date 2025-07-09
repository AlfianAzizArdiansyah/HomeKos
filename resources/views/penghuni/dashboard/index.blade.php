@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Dashboard Penghuni</h1>

        <!-- Status Pembayaran -->
        <div class="bg-white shadow rounded-xl p-4 mb-6">
            <h2 class="text-lg font-semibold mb-2">Status Pembayaran</h2>
            <ul>
                @forelse($pembayaran as $item)
                    <li class="border-b py-2 flex justify-between items-center">
                        <div>
                            <p class="font-medium">Tanggal:
                                {{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}</p>
                            <p class="text-sm text-gray-500">Jumlah: Rp{{ number_format($item->jumlah, 0, ',', '.') }}</p>
                        </div>
                        <span
                            class="text-sm px-3 py-1 rounded-full 
                    {{ $item->status == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </li>
                @empty
                    <li class="text-gray-500">Belum ada riwayat pembayaran.</li>
                @endforelse
            </ul>
        </div>


        <!-- Tagihan Bulanan -->
        <div class="bg-white shadow rounded-xl p-4 mb-6">
            <h2 class="text-lg font-semibold mb-2">Tagihan Bulanan</h2>
            <ul>
                @foreach ($tagihan as $item)
                    <li class="py-2 flex justify-between items-center border-b">
                        <div>
                            <p class="font-medium">{{ $item['bulan'] }}</p>
                            <p class="text-sm text-gray-500">Rp{{ number_format($item['jumlah'], 0, ',', '.') }}</p>
                        </div>
                        <span
                            class="text-sm px-3 py-1 rounded-full 
                    {{ strtolower($item['status']) === 'lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $item['status'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>



        {{-- <!-- Pengumuman -->
        <div class="bg-white shadow rounded-xl p-4 mb-6">
            <h2 class="text-lg font-semibold mb-2">Pengumuman</h2>
            <ul>
                @foreach ($pengumuman as $item)
                    <li class="py-2 border-b">
                        <strong>{{ $item->judul }}</strong><br>
                        <span class="text-sm text-gray-500">{{ $item->tanggal }}</span><br>
                        <p>{{ $item->isi }}</p>
                    </li>
                @endforeach
            </ul>
        </div>


        <!-- Pengaduan/Bantuan -->
        <div class="bg-white shadow rounded-xl p-4 mb-6">
            <h2 class="text-lg font-semibold mb-2">Form Pengaduan / Permintaan Bantuan</h2>
            <form action="{{ route('penghuni.pengaduan.store') }}" method="POST">
                @csrf
                <textarea name="isi" class="w-full border rounded p-2 mb-2" rows="4" placeholder="Tuliskan pengaduan Anda..."></textarea>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>
            </form>
        </div>


        <!-- Update Data Diri -->
        <div class="bg-white shadow rounded-xl p-4 mb-6">
            <h2 class="text-lg font-semibold mb-2">Update Data Diri</h2>
            <form action="{{ route('penghuni.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="nama" value="{{ $user->name }}" class="w-full border rounded p-2 mb-2"
                    placeholder="Nama Lengkap">
                <input type="text" name="kamar" value="{{ $user->kamar }}" class="w-full border rounded p-2 mb-2"
                    placeholder="No Kamar">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
            </form>
        </div>


        <!-- Chat Admin -->
        @if ($chatAvailable)
            <div class="bg-white shadow rounded-xl p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">Chat Admin</h2>
                <div class="h-60 overflow-y-scroll border p-2 mb-2 bg-gray-100">
                    @foreach ($messages as $message)
                        <div class="{{ $message->from == 'admin' ? 'text-left' : 'text-right' }}">
                            <p class="inline-block bg-white rounded px-3 py-1 mb-1 shadow">
                                {{ $message->isi }}
                            </p>
                        </div>
                    @endforeach
                </div>
                <form action="{{ route('penghuni.chat.send') }}" method="POST">
                    @csrf
                    <input type="text" name="isi" class="w-full border rounded p-2 mb-2"
                        placeholder="Tulis pesan...">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Kirim</button>
                </form>
            </div>
        @endif --}}

    </div>
@endsection
