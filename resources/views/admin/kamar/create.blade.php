<!-- Modal Tambah Kamar -->
<div x-show="tambahKamar" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div x-on:click.away="tambahKamar = false"
         class="relative bg-white rounded-xl shadow-2xl w-full max-w-xl p-6 border border-blue-300">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-700">
                Tambah Kamar
            </h2>
            <button @click="tambahKamar = false"
                class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-white bg-red-500 hover:bg-red-600 rounded-full shadow-lg text-2xl font-bold transition duration-200"
                title="Tutup">
                ×
            </button>
        </div>

        <!-- Form Tambah -->
        <form method="POST" action="{{ route('admin.kamar.store') }}">
            @csrf

            <!-- Nama Kamar -->
            <div class="mb-5">
                <label for="nama_kamar" class="block text-base font-semibold text-gray-700 mb-1">Nama Kamar</label>
                <input type="text" name="nama_kamar" id="nama_kamar" required
                       value="{{ old('nama_kamar') }}"
                       class="w-full px-4 py-2 rounded-lg border border-blue-300 bg-white text-gray-800 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm">
            </div>

            <!-- Status -->
            <div class="mb-5">
                <label for="status" class="block text-base font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" id="status"
                        class="w-full px-4 py-2 rounded-lg border border-blue-300 bg-white text-gray-800 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm">
                    <option value="tersedia">Tersedia</option>
                    <option value="terisi">Terisi</option>
                </select>
            </div>

            <!-- Harga -->
            <div class="mb-5">
                <label for="harga" class="block text-base font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" required min="0"
                       value="{{ old('harga') }}"
                       class="w-full px-4 py-2 rounded-lg border border-blue-300 bg-white text-gray-800 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm">
            </div>

            <!-- Fasilitas -->
            <div class="mb-6">
                <label class="block text-base font-semibold text-gray-700 mb-2">Fasilitas</label>
                <div class="grid grid-cols-2 gap-2">
                    @php
                        $selectedFasilitas = old('fasilitas', []);
                    @endphp
                    @foreach (['AC', 'Kamar Mandi Dalam', 'WiFi', 'Kasur', 'Lemari', 'Meja'] as $item)
                        <label class="flex items-center space-x-2 text-gray-700 text-sm">
                            <input type="checkbox" name="fasilitas[]" value="{{ $item }}"
                                   class="rounded text-blue-600 border-blue-300 focus:ring-blue-500"
                                   {{ in_array($item, $selectedFasilitas) ? 'checked' : '' }}>
                            <span>{{ $item }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-lg transition duration-200 text-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>