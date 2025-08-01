<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\PembayaranDetail;
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
        $penghuni = Penghuni::with('kamar')->where('user_id', Auth::id())->first();

        if (!$penghuni) {
            return redirect()->back()->with('error', 'Data penghuni tidak ditemukan.');
        }

        $kamar = $penghuni->kamar;

        $pembayarans = Pembayaran::where('penghuni_id', auth()->user()->penghuni->id)
            ->orderBy('jatuh_tempo', 'asc')
            ->get();

        $tagihan = Pembayaran::where('penghuni_id', $penghuni->id)
            ->where('status', '!=', 'Lunas')
            ->orderBy('jatuh_tempo', 'desc')
            ->get();

        return view('penghuni.dashboard.dashboard', compact('penghuni', 'kamar', 'tagihan'));
    }

    public function historyPay()
    {
        $user = Auth::user();
        $penghuni = Penghuni::with('kamar')->where('user_id', $user->id)->first();

        if (!$penghuni) {
            return redirect()->back()->with('error', 'Data penghuni tidak ditemukan.');
        }

        // Riwayat pembayaran (status lunas saja)
        $riwayatPembayaran = Pembayaran::where('penghuni_id', $penghuni->id)
            ->where('status', 'Lunas')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return view('penghuni.pembayaran.riwayat-bayar', [
            'riwayatPembayaran' => $riwayatPembayaran,
        ]);
    }

    public function unggahBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pembayaranDetail = Pembayaran::findOrFail($id);

        // Hapus bukti lama jika ada
        if ($pembayaranDetail->bukti_bayar) {
            Storage::delete('public/bukti/' . $pembayaranDetail->bukti_bayar);
        }

        // Simpan file baru
        $file = $request->file('bukti_bayar');
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/bukti', $filename);

        $pembayaranDetail->update([
            'bukti_bayar' => $filename,
            'tanggal_bayar' => now(),
            'status' => 'Proses',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
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
