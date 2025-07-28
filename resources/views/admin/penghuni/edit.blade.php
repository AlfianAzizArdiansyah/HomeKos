<div x-show="editPenghuni" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div x-on:click.away="editPenghuni = false"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl py-6 px-6 overflow-auto max-h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Penghuni</h2>
            <button @click="editPenghuni = false"
                class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-white bg-red-500 hover:bg-red-600 rounded-full shadow-lg text-2xl font-bold transition duration-200"
                title="Tutup">
                ×
            </button>
        </div>

        <!-- Error -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4 text-sm border border-red-300">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" :action="'/admin/penghuni/' + penghuniData.id" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label for="edit_nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" id="edit_nama" placeholder="Nama" x-model="penghuniData.nama"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>

            <!-- No HP -->
            <div>
                <label for="edit_no_hp" class="block text-sm font-semibold text-gray-700 mb-1">No HP</label>
                <input type="text" name="no_hp" id="edit_no_hp" placeholder="08xxxx" x-model="penghuniData.no_hp"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>

            <!-- NIK -->
            <div>
                <label for="edit_nik" class="block text-sm font-semibold text-gray-700 mb-1">NIK</label>
                <input type="text" name="nik" id="edit_nik" placeholder="NIK" x-model="penghuniData.nik"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>

            <!-- Foto KTP -->
            <div>
                <label for="edit_foto_ktp" class="block text-sm font-semibold text-gray-700 mb-1">Foto KTP</label>
                <input type="file" name="foto_ktp" id="edit_foto_ktp"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none bg-white"
                    accept="image/*">
                <template x-if="penghuniData.foto_ktp">
                    <p class="text-sm text-gray-600 mt-2 italic">
                        File saat ini: <span class="font-medium" x-text="penghuniData.foto_ktp.split('/').pop()"></span>
                    </p>
                </template>
            </div>

            <!-- Pilih Kamar -->
            <div>
                <label for="edit_kamar_id" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kamar</label>
                @if ($kamars->isEmpty())
                    <p class="text-sm text-red-600 bg-red-100 px-3 py-2 rounded-md">Tidak ada kamar tersedia.</p>
                @else
                    <select name="kamar_id" id="edit_kamar_id" x-model="penghuniData.kamar_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Kamar --</option>
                        @foreach ($kamars as $kamar)
                            <option value="{{ $kamar->id }}">{{ $kamar->nama_kamar }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

            <!-- Tanggal Masuk -->
            <div>
                <label for="edit_tanggal_masuk" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal
                    Masuk</label>
                <input type="date" name="tanggal_masuk" id="edit_tanggal_masuk" x-model="penghuniData.tanggal_masuk"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>

            <!-- Status -->
            <div>
                <label for="edit_status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" id="edit_status" x-model="penghuniData.status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
                    <option value="aktif">Aktif</option>
                    <option value="keluar">Keluar</option>
                </select>
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition-all">
                    Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>