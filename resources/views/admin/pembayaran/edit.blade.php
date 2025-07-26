<!-- Modal Edit Pembayaran -->
<div x-show="editPembayaran" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
    <div @click.away="editPembayaran = false"
        class="relative bg-white rounded-xl shadow-2xl w-full max-w-xl p-6 border border-blue-300">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-700">Edit Pembayaran</h2>
            <button @click="editPembayaran = false"
                class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-white bg-red-500 hover:bg-red-600 rounded-full shadow-lg text-2xl font-bold transition duration-200"
                title="Tutup">
                ×
            </button>
        </div>

        <!-- Form -->
        <form method="POST" :action="'/admin/pembayaran/' + pembayaranData.id" x-ref="editForm">
            @csrf
            @method('PUT')

            <!-- Jumlah -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Jumlah (Rp)</label>
                <input type="number" name="jumlah" x-model="pembayaranData.jumlah"
                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-200" required>
            </div>

            <!-- Jatuh Tempo -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Jatuh Tempo</label>
                <input type="date" name="jatuh_tempo" x-model="pembayaranData.jatuh_tempo"
                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>

            <!-- Tanggal Bayar -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Tanggal Bayar</label>
                <input type="date" name="tanggal_bayar" x-model="pembayaranData.tanggal_bayar"
                    class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block font-semibold mb-2 text-gray-700">Status</label>
                <select name="status" x-model="pembayaranData.status" required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    <option value="Lunas">Lunas</option>
                    <option value="Proses">Proses</option>
                    <option value="Belum Lunas">Belum Lunas</option>
                </select>
            </div>

            <!-- Tombol Simpan -->
            <div>
                <button type="button" @click="$refs.editForm.submit()"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pembayaranHandler', () => ({
            editPembayaran: false,
            pembayaranData: {},

            openEditPembayaran(data) {
                this.pembayaranData = { ...data };
                this.editPembayaran = true;
            }
        }));
    });
</script>