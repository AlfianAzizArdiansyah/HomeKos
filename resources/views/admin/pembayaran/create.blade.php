<!-- Modal Tambah Pembayaran -->
<div x-show="tambahPembayaran" x-cloak x-data="tambahPembayaranModal()"
  class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4"
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

      <!-- Penghuni -->
      <div class="mb-4">
        <label class="block font-semibold mb-1">Penghuni</label>
        <select name="penghuni_id" x-model="selectedId" @change="updateHarga()" class="w-full border rounded px-4 py-2"
          required>
          <option value="">-- Pilih penghuni --</option>
          <template x-for="penghuni in penghuniList" :key="penghuni.id">
            <option :value="penghuni.id" x-text="penghuni.nama + ' - ' + (penghuni.kamar?.nama_kamar ?? '-')">
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
        <input type="date" name="jatuh_tempo" x-model="jatuhTempo"
          class="w-full px-4 py-2 bg-gray-100 border border-blue-300 rounded-lg cursor-not-allowed" readonly required>
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

<script>
  function tambahPembayaranModal() {
    return {
      penghuniList: @json($penghunis),
      selectedId: '',
      harga: 0,
      jatuhTempo: '',
      updateHarga() {
        const selected = this.penghuniList.find(p => p.id == this.selectedId);
        this.harga = selected ? (selected.kamar?.harga ?? 0) : 0;

        let baseDate = null;

        if (selected?.pembayaran_terakhir?.jatuh_tempo) {
          baseDate = new Date(selected.pembayaran_terakhir.jatuh_tempo);
        } else if (selected?.tanggal_masuk) {
          baseDate = new Date(selected.tanggal_masuk);
        }

        if (baseDate) {
          const originalDate = baseDate.getDate();
          baseDate.setMonth(baseDate.getMonth() + 1);

          if (baseDate.getDate() !== originalDate) {
            baseDate.setDate(0);
          }

          this.jatuhTempo = baseDate.toISOString().split('T')[0];
        } else {
          this.jatuhTempo = '';
        }
      }
    }
  }
</script>