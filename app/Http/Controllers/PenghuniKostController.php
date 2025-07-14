<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\Penghuni;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenghuniKostController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $penghuni = Penghuni::where('user_id', Auth::id())->first(); 
        $kamar = $penghuni->kamar;

        // Ambil pembayaran 3 bulan terakhir
        $pembayaranBulanIni = $penghuni->pembayarans()
            ->orderBy('tanggal_bayar', 'desc') // jika memakai kolom periode
            ->take(3)
            ->get();

        return view('penghuni.dashboard', compact('penghuni', 'kamar', 'pembayaranBulanIni'));
    }

    public function historyPay() {
        return view('penghuni.riwayat-bayar');
    }


    // public function storePengaduan(Request $request)
    // {
    //     $request->validate([
    //         'isi' => 'required|string|max:1000',
    //     ]);

    //     Pengaduan::create([
    //         'penghuni_id' => Auth::id(),
    //         'isi' => $request->isi,
    //     ]);

    //     return back()->with('success', 'Pengaduan berhasil dikirim.');
    // }

    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'kamar' => 'required|string|max:100',
    //     ]);

    //     $user = Auth::user();
    //     $user->name = $request->nama;
    //     $user->kamar = $request->kamar;
    //     $user->save();

    //     return back()->with('success', 'Data berhasil diperbarui.');
    // }

    // public function sendChat(Request $request)
    // {
    //     $request->validate([
    //         'isi' => 'required|string|max:1000',
    //     ]);

    //     Chat::create([
    //         'penghuni_id' => Auth::id(),
    //         'from' => 'penghuni',
    //         'isi' => $request->isi,
    //     ]);

    //     return back()->with('success', 'Pesan terkirim.');
    // }
}
