<!-- Modal Edit Kamar -->
<div x-show="editKamar" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div x-on:click.away="editKamar = false"
        class="relative bg-white rounded-xl shadow-2xl w-full max-w-xl p-6 border border-blue-300">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-700">Edit Kamar</h2>
            <button @click="editKamar = false"
                class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-white bg-red-500 hover:bg-red-600 rounded-full shadow-lg text-2xl font-bold transition duration-200"
                title="Tutup">
                ×
            </button>
        </div>

        <!-- Form Edit -->
        <form method="POST" :action="'{{ url('/admin/kamar') }}/' + kamarData.id">
            @csrf
            @method('PUT')

            <!-- Nama Kamar -->
            <div class="mb-5">
                <label class="block font-semibold text-gray-700 mb-1">Nama Kamar</label>
                <input type="text" name="nama_kamar" x-model="kamarData.nama_kamar"
                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-blue-500">
            </div>

            <!-- Status -->
            <div class="mb-5">
                <label class="block font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" x-model="kamarData.status"
                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-blue-500">
                    <option value="tersedia">Tersedia</option>
                    <option value="terisi">Terisi</option>
                </select>
            </div>

            <!-- Harga -->
            <div class="mb-5">
                <label class="block font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" name="harga" x-model="kamarData.harga"
                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-blue-500">
            </div>

            <!-- Fasilitas -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Fasilitas</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach (['AC', 'Kamar Mandi Dalam', 'WiFi', 'Kasur', 'Lemari', 'Meja'] as $item)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" :checked="kamarData.fasilitas?.includes('{{ $item }}')"
                                @change="toggleFasilitas('{{ $item }}')" name="fasilitas[]" value="{{ $item }}"
                                class="text-blue-600 border-blue-300 rounded focus:ring-blue-500">
                            <span>{{ $item }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Tombol -->
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleFasilitas(item) {
        if (!Array.isArray(kamarData.fasilitas)) {
            kamarData.fasilitas = [];
        }

        const index = kamarData.fasilitas.indexOf(item);
        if (index === -1) {
            kamarData.fasilitas.push(item);
        } else {
            kamarData.fasilitas.splice(index, 1);
        }
    }
</script>