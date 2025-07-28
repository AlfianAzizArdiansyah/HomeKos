<div x-show="openDeleteModal" x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg max-w-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-700">
                {{ $modalTitle ?? 'Konfirmasi Hapus' }}
            </h2>
        </div>

        <p class="text-gray-600">Apakah Anda yakin ingin menghapus data <span
                class="font-bold">{{ $itemName ?? 'data ini' }}</span>?</p>

        <div class="flex justify-end mt-10">
            <button @click="openDeleteModal = false"
                class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md mr-2">Batal</button>
            <form action="{{ $actionUrl }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md">Hapus</button>
            </form>
        </div>
    </div>
</div>