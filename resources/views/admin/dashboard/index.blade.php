@extends('layouts.app')

@section('content')
    <div x-data class="p-6 bg-white rounded-xl shadow-md">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-8 tracking-wide">Dashboard</h1>

        <!-- Statistik Atas -->
        <div class="flex flex-wrap gap-6 justify-between mb-6">
            <div class="flex-1 min-w-[200px] bg-sky-500 text-white p-6 rounded-xl shadow hover:bg-sky-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Total Kamar</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalKamar }}</p>
                    </div>
                    <i data-lucide="home" class="w-10 h-10 text-white opacity-70"></i>
                </div>
            </div>
            <div class="flex-1 min-w-[200px] bg-emerald-500 text-white p-6 rounded-xl shadow hover:bg-emerald-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Kamar Terisi</p>
                        <p class="text-3xl font-bold mt-2">{{ $kamarTerisi }}</p>
                    </div>
                    <i data-lucide="user-check" class="w-10 h-10 text-white opacity-70"></i>
                </div>
            </div>
            <div class="flex-1 min-w-[200px] bg-yellow-500 text-white p-6 rounded-xl shadow hover:bg-yellow-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold">Kamar Tersedia</p>
                        <p class="text-3xl font-bold mt-2">{{ $kamarTersedia }}</p>
                    </div>
                    <i data-lucide="door-open" class="w-10 h-10 text-white opacity-70"></i>
                </div>
            </div>
            <div class="flex-1 min-w-[200px] bg-pink-500 text-white p-6 rounded-xl shadow hover:bg-pink-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold"> Penghuni Aktif</p>
                        <p class="text-3xl font-bold mt-2">{{ $penghuniAktif }}</p>
                    </div>
                    <i data-lucide="users" class="w-10 h-10 text-white opacity-70"></i>
                </div>
            </div>
        </div>

        <!-- Total Pemasukan -->
        <div class="mb-6 bg-indigo-600 text-white p-6 rounded-xl shadow text-center hover:bg-indigo-700">
            <p class="text-lg font-semibold">Total Pemasukan</p>
            <p class="text-4xl font-extrabold mt-2 tracking-wide">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </p>
        </div>

        <!-- Grafik -->
        <div class="mt-6 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 shadow-md">
                    <h2 class="text-xl font-bold mb-6 text-green-700">Grafik Pemasukan Bulanan ({{ now()->year }})</h2>
                    <canvas id="pemasukanBulananChart" height="100"></canvas>
                </div>

                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6 shadow-md">
                    <h2 class="text-xl font-bold mb-6 text-indigo-700">Grafik Pemasukan Tahunan</h2>
                    <canvas id="pemasukanTahunanChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik Bulanan
        const bulananCtx = document.getElementById('pemasukanBulananChart').getContext('2d');
        new Chart(bulananCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pemasukan (Rp)',
                    data: @json($pemasukanChart),
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgba(22, 163, 74, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                    barThickness: 30
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 500000,
                        max: 1500000,
                        ticks: {
                            stepSize: 250000,
                            callback: value => 'Rp ' + new Intl.NumberFormat('id-ID').format(value)
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y)
                        }
                    }
                }
            }
        });

        // Grafik Tahunan
        const tahunanCtx = document.getElementById('pemasukanTahunanChart').getContext('2d');
        new Chart(tahunanCtx, {
            type: 'line',
            data: {
                labels: @json(array_keys($pemasukanTahunan)),
                datasets: [{
                    label: 'Pemasukan Tahunan (Rp)',
                    data: @json(array_values($pemasukanTahunan)),
                    borderColor: 'rgba(79, 70, 229, 1)',
                    backgroundColor: 'rgba(165, 180, 252, 0.3)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        grid: {
                            display: true
                        },
                        ticks: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y)
                        }
                    }
                }
            }
        });
    </script>
@endpush