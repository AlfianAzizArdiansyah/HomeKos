<div x-show="tambahPenghuni" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div x-on:click.away="tambahPenghuni = false" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ isset($penghuni) ? 'Edit penghuni' : 'Tambah penghuni' }}
            </h2>
            <button @click="tambahPenghuni = false"
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
        <form method="POST"
            action="{{ isset($penghuni) ? route('admin.penghuni.update', $penghuni) : route('admin.penghuni.store') }}"
            enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if (isset($penghuni))
                @method('PUT')
            @endif

            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" id="nama" placeholder="Nama"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required value="{{ old('nama', $penghuni->nama ?? '') }}">
            </div>

            {{-- <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" placeholder="email@example.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required value="{{ old('email') }}">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" placeholder="Password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div> --}}

            <!-- No HP -->
            <div>
                <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-1">No HP</label>
                <input type="text" name="no_hp" id="no_hp" placeholder="08xxxx"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required value="{{ old('no_hp', $penghuni->no_hp ?? '') }}">
            </div>

            <!-- NIK -->
            <div>
                <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1">NIK</label>
                <input type="text" name="nik" id="nik" placeholder="NIK"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required value="{{ old('nik', $penghuni->nik ?? '') }}">
            </div>

            <!-- Foto KTP -->
            <div>
                <label for="foto_ktp" class="block text-sm font-semibold text-gray-700 mb-1">Foto KTP</label>
                <input type="file" name="foto_ktp" id="foto_ktp"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none bg-white"
                    {{ isset($penghuni) ? '' : 'required' }} accept="image/*">
                @if (isset($penghuni) && $penghuni->foto_ktp)
                    <img src="{{ asset('storage/' . $penghuni->foto_ktp) }}" alt="Foto KTP"
                        class="w-32 mt-2 rounded shadow border">
                @endif
            </div>

            <!-- Pilih Kamar -->
            <div>
                <label for="kamar_id" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kamar</label>
                @if ($kamars->isEmpty())
                    <p class="text-sm text-red-600 bg-red-100 px-3 py-2 rounded-md">Tidak ada kamar tersedia.</p>
                @else
                    <select name="kamar_id" id="kamar_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Kamar --</option>
                        @foreach ($kamars as $kamar)
                            <option value="{{ $kamar->id }}"
                                {{ old('kamar_id', $penghuni->kamar_id ?? '') == $kamar->id ? 'selected' : '' }}>
                                {{ $kamar->nama_kamar }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <!-- Tanggal Masuk -->
            <div>
                <label for="tanggal_masuk" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required
                    value="{{ old('tanggal_masuk', isset($penghuni->tanggal_masuk) ? \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('Y-m-d') : '') }}">
            </div>


            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" id="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
                    <option value="aktif" {{ old('status', $penghuni->status ?? '') == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="keluar" {{ old('status', $penghuni->status ?? '') == 'keluar' ? 'selected' : '' }}>
                        Keluar</option>
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
