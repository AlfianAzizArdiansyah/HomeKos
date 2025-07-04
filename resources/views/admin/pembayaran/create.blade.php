<!-- Modal Tambah Pembayaran -->
<div x-show="tambahPembayaran" x-cloak x-data="{ 
    penyewaList: {{ Js::from($penyewas) }}, 
    selectedId: '', 
    harga: 0, 
    updateHarga() { 
        const selected = this.penyewaList.find(p => p.id == this.selectedId); 
        this.harga = selected ? selected.kamar?.harga ?? 0 : 0;
    }
  }" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4"
  x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
  x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">

  <div @click.away="tambahPembayaran = false"
    class="relative bg-white rounded-xl shadow-2xl w-full max-w-xl p-6 border border-blue-300">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-indigo-700">Tagihan Pembayaran</h2>
      <button @click="tambahPembayaran = false"
        class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-white bg-red-500 hover:bg-red-600 rounded-full shadow-lg text-2xl font-bold transition duration-200"
        title="Tutup">
        ×
      </button>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.pembayaran.store') }}" method="POST">
      @csrf

      <!-- Pilih Penyewa -->
      <div class="mb-4">
        <label class="block font-semibold mb-1">Penyewa</label>
        <select name="penyewa_id" x-model="selectedId" @change="updateHarga()" class="w-full border rounded px-4 py-2"
          required>
          <option value="">-- Pilih Penyewa --</option>
          <template x-for="penyewa in penyewaList" :key="penyewa.id">
            <option :value="penyewa.id" x-text="penyewa.nama + ' (' + (penyewa.kamar?.nama_kamar ?? '-') + ')'">
            </option>
          </template>
        </select>
      </div>

      <!-- Jumlah Pembayaran Otomatis -->
      <div class="mb-4">
        <label class="block font-semibold mb-1">Jumlah Tagihan</label>
        <input type="number" name="jumlah" x-model="harga"
          class="w-full border rounded px-4 py-2 bg-gray-100 cursor-not-allowed" readonly required>
      </div>

      <!-- Jatuh Tempo -->
      <div class="mb-5">
        <label class="block font-semibold text-gray-700 mb-1">Jatuh Tempo</label>
        <input type="date" name="jatuh_tempo"
          class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-blue-500" required>
      </div>

      <!-- Tombol -->
      <div>
        <button type="submit"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow transition duration-200">
          Simpan Tagihan
        </button>
      </div>
    </form>
  </div>
</div>