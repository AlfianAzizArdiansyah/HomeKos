@extends('layouts.app')

@section('content')
    <div
        class="w-full bg-gradient-to-br from-green-100 via-white to-blue-100 rounded-2xl shadow-2xl p-8 sm:p-12 max-w-4xl mx-auto mt-10 mb-12 border border-green-300">
        <h2 class="text-4xl font-extrabold text-green-700 text-center mb-6 flex items-center justify-center gap-2">
            💸 Instruksi Transfer Bank
        </h2>

        <p class="text-gray-800 text-center mb-8 text-lg italic">
            Silakan lakukan pembayaran sesuai rincian berikut.
        </p>

        <div class="bg-white p-6 rounded-xl border border-gray-300 mb-10 shadow-md">
            <table class="w-full text-left text-gray-800">
                <tbody>
                    <tr class="border-b border-gray-200">
                        <td class="py-3 font-semibold w-1/3">🏦 Bank</td>
                        <td class="py-3">:
                            <span class="text-lg font-bold tracking-wide text-gray-900">BRI</span>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="py-3 font-semibold">👤 Nama Penerima</td>
                        <td class="py-3">:
                            <span class="text-lg font-bold tracking-wide text-gray-900">ARI SETIAWAN ALI</span>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="py-3 font-semibold">💳 No. Rekening</td>
                        <td class="py-3">:
                            <span class="text-lg font-bold tracking-wide text-gray-900">3584 0104 2253 535</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 font-semibold text-green-700">💰 Jumlah</td>
                        <td class="py-3">:
                            <span class="text-green-700 font-bold text-2xl animate-pulse">
                                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Accordion Section --}}
        <div class="space-y-5 mb-10">
            <h3 class="text-xl font-semibold text-gray-800">Panduan Transfer</h3>

            <!-- M-Banking Accordion -->
            <div class="rounded-lg border border-gray-300 overflow-hidden">
                <button type="button" onclick="toggleAccordion('langsung')"
                    class="w-full text-left bg-blue-50 hover:bg-blue-100 px-5 py-3 font-medium transition flex items-center gap-2">
                    💻 Transfer via M-Banking
                </button>
                <div id="mbanking" class="hidden bg-white text-gray-700 text-sm leading-relaxed px-5 py-4">
                    <ul class="list-decimal pl-6 space-y-1">
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
            <div class="rounded-lg border border-gray-300 overflow-hidden">
                <button type="button" onclick="toggleAccordion('langsung')"
                    class="w-full text-left bg-blue-50 hover:bg-blue-100 px-5 py-3 font-medium transition flex items-center gap-2">
                    🏧 Transfer via ATM / Teller Bank
                </button>
                <div id="langsung" class="hidden bg-white text-gray-700 text-sm leading-relaxed px-5 py-4">
                    <ul class="list-decimal pl-6 space-y-1">
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

        <p class="text-center text-sm text-gray-700 mb-6 italic">
            Setelah transfer selesai, silakan kembali dan unggah bukti pembayaran
        </p>

        <div class="flex justify-center">
            <a href="{{ route('penghuni.dashboard') }}"
                class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition duration-200 whitespace-nowrap text-center">
                Kembali ke Dashboard
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