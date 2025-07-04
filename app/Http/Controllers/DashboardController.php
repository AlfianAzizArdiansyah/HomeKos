<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\Penyewa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKamar = Kamar::count();
        $kamarTerisi = Kamar::whereHas('penyewa')->count();
        $kamarTersedia = $totalKamar - $kamarTerisi;
        $penyewaAktif = Penyewa::count();
        $totalPemasukan = Pembayaran::where('status', 'lunas')->sum('jumlah');

        // Data pemasukan per bulan
        $pemasukanBulanan = Pembayaran::selectRaw('MONTH(tanggal_bayar) as bulan, SUM(jumlah) as total')
            ->whereYear('tanggal_bayar', now()->year)
            ->where('status', 'lunas')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $pemasukanChart = [];
        for ($i = 1; $i <= 12; $i++) {
            $pemasukanChart[] = $pemasukanBulanan[$i] ?? 0;
        }

        // Pemasukan tahunan
        $pemasukanTahunan = Pembayaran::selectRaw('YEAR(tanggal_bayar) as tahun, SUM(jumlah) as total')
            ->where('status', 'lunas')
            ->groupBy('tahun')
            ->pluck('total', 'tahun')
            ->toArray();

        return view('admin.dashboard.index', compact(
            'totalKamar',
            'kamarTerisi',
            'kamarTersedia',
            'penyewaAktif',
            'totalPemasukan',
            'pemasukanChart',
            'pemasukanTahunan'
        ));
    }
}
