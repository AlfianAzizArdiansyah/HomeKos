@extends('layouts.app')

@section('content')
    <div class="w-full bg-white rounded-2xl shadow-lg p-6 sm:p-10 max-w-4xl mx-auto mt-10 mb-12">
        <h2 class="text-3xl font-extrabold text-green-700 text-center mb-6">
            Instruksi Transfer Bank
        </h2>

        <p class="text-gray-800 text-center mb-6 text-lg">
            Silakan transfer ke rekening berikut:
        </p>

        <div class="bg-white p-6 rounded-xl border border-gray-300 mb-8 shadow-sm">
            <table class="w-full text-left text-gray-800">
                <tbody>
                    <tr class="border-b border-gray-200">
                        <td class="py-2 font-semibold w-1/3">Bank</td>
                        <td class="py-2">: BRI</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="py-2 font-semibold">Nama Penerima</td>
                        <td class="py-2">: HomeKos</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="py-2 font-semibold">No. Rekening</td>
                        <td class="py-2">:
                            <span class="text-lg font-bold tracking-wide text-gray-900">3584 0104 2253 535</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-2 font-semibold">Jumlah</td>
                        <td class="py-2">:
                            <span class="text-green-700 font-bold text-xl">
                                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Accordion Section --}}
        <div class="space-y-4 mb-10">
            <h3 class="text-lg font-semibold text-gray-800">Panduan Transfer</h3>

            <!-- M-Banking Accordion -->
            <div>
                <button type="button" onclick="toggleAccordion('mbanking')"
                    class="w-full text-left bg-white border border-gray-300 px-4 py-3 rounded-lg hover:bg-gray-50 font-medium transition">
                    💳 Transfer via M-Banking
                </button>
                <div id="mbanking" class="mt-2 hidden text-gray-700 text-sm leading-relaxed px-2">
                    <ul class="list-decimal pl-6 mt-2 space-y-1">
                        <li>Buka aplikasi M-Banking Anda.</li>
                        <li>Pilih menu <em>Transfer</em>.</li>
                        <li>Masukkan nomor rekening <strong>3584 0104 2253 535</strong>.</li>
                        <li>Nama penerima: <strong>HomeKos</strong>.</li>
                        <li>Masukkan nominal yang ditentukan.</li>
                        <li>Konfirmasi dan selesaikan transaksi.</li>
                    </ul>
                </div>
            </div>

            <!-- Transfer Langsung Accordion -->
            <div>
                <button type="button" onclick="toggleAccordion('langsung')"
                    class="w-full text-left bg-white border border-gray-300 px-4 py-3 rounded-lg hover:bg-gray-50 font-medium transition">
                    🏦 Transfer via ATM / Teller Bank
                </button>
                <div id="langsung" class="mt-2 hidden text-gray-700 text-sm leading-relaxed px-2">
                    <ul class="list-decimal pl-6 mt-2 space-y-1">
                        <li>Kunjungi ATM atau cabang bank terdekat.</li>
                        <li>Pilih menu <em>Transfer</em>.</li>
                        <li>Masukkan nomor rekening: <strong>3584 0104 2253 535</strong>.</li>
                        <li>Nama penerima: <strong>HomeKos</strong>.</li>
                        <li>Masukkan jumlah sesuai instruksi.</li>
                        <li>Simpan bukti transfer atau struk.</li>
                    </ul>
                </div>
            </div>
        </div>

        <p class="text-center text-sm text-gray-700 mb-6">
            Setelah transfer, silakan kembali dan unggah bukti pembayaran melalui menu
            <span class="font-medium text-gray-800">Unggah Bukti</span>.
        </p>

        <div class="flex justify-center">
            <a href="{{ route('penghuni.dashboard') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Kembali
            </a>
        </div>
    </div>

    <script>
        function toggleAccordion(id) {
            const el = document.getElementById(id);
            el.classList.toggle('hidden');
        }
    </script>
@endsection