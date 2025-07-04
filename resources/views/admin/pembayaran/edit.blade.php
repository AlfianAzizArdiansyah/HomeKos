<!-- Modal Edit Pembayaran -->
<div x-show="editPembayaran" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div x-on:click.away="editPembayaran = false"
        class="relative bg-white rounded-xl shadow-2xl w-full max-w-xl p-6 border border-indigo-300">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-700">Edit Pembayaran</h2>
            <button @click="editPembayaran = false"
                class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-white bg-red-500 hover:bg-red-600 rounded-full shadow-lg text-2xl font-bold transition duration-200"
                title="Tutup">
                ×
            </button>
        </div>

        <!-- Form Edit -->
        <form method="POST" :action="'{{ url('/admin/pembayaran/edit') }}/' + pembayaranData.id">
            @csrf
            @method('PUT')

            <!-- Jumlah -->
            <div class="mb-5">
                <label class="block font-semibold text-gray-700 mb-1">Jumlah (Rp)</label>
                <input type="number" name="jumlah" x-model="pembayaranData.jumlah"
                    class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-indigo-500">
            </div>

            <!-- Jatuh Tempo -->
            <div class="mb-5">
                <label class="block font-semibold text-gray-700 mb-1">Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" x-model="pembayaranData.jatuh_tempo"
                    class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-indigo-500">
            </div>

            <!-- Tanggal Bayar -->
            <div class="mb-5">
                <label class="block font-semibold text-gray-700 mb-1">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" x-model="pembayaranData.tanggal_bayar"
                    class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-indigo-500">
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" x-model="pembayaranData.status"
                    class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-indigo-500">
                    <option value="belum bayar">Belum Bayar</option>
                    <option value="lunas">Lunas</option>
                </select>
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
    function openEditPembayaran(data) {
        pembayaranData = {
            id: data.id,
            jumlah: data.jumlah,
            jatuh_tempo: data.jatuh_tempo,
            tanggal_bayar: data.tanggal_bayar,
            status: data.status
        };
        editPembayaran = true;
    }
</script>