<div x-show="openDeleteModal" x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4 sm:p-0">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-6 sm:p-8 mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-blue-700">
                {{ $modalTitle ?? 'Konfirmasi Hapus' }}
            </h2>
        </div>

        <p class="text-gray-600 text-sm sm:text-base">
            Apakah Anda yakin ingin menghapus data <span class="font-bold">{{ $itemName ?? 'data ini' }}</span>?
        </p>

        <div class="flex flex-col sm:flex-row justify-end mt-8 gap-2 sm:gap-4">
            <button @click="openDeleteModal = false"
                class="w-full sm:w-auto bg-gray-300 text-gray-700 py-2 px-4 rounded-md">
                Batal
            </button>
            <form action="{{ $actionUrl }}" method="POST" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full sm:w-auto bg-red-600 text-white py-2 px-4 rounded-md">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
