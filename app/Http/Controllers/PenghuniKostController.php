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
    // public function index()
    // {
    //     // Misal kamu punya relasi pengguna dengan penghuni melalui user_id
    //     // $user = auth()->user();
    //     $penghuni = Penghuni::with('kamar')->where('user_id', auth()->id())->first();
    //     $pembayaran = Pembayaran::where('penghuni_id', auth()->id())
    //         ->orderBy('tanggal_bayar', 'desc')
    //         ->get();
    //     // $tagihan = Tagihan::where('penghuni_id', $user->id)->get();
    //     // $pengumuman = Pengumuman::latest()->take(5)->get();
    //     // $messages = Chat::where('penghuni_id', $user->id)->get();
    //     // $chatAvailable = true; // bisa diganti sesuai kondisi

    //     return view('penghuni.dashboard.index', compact('penghuni', 'pembayaran', 'tagihan', 'pengumuman', 'messages', 'chatAvailable', 'user'));
    // }

    public function index()
    {
        $user = Auth::user();
        $penghuni = Penghuni::with('kamar')->where('user_id', $user->id)->first();

        $pembayaran = Pembayaran::where('penghuni_id', $user->id)->get()->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_bayar)->format('Y-m');
        });

        // Generate tagihan bulanan (6 bulan terakhir)
        $now = Carbon::now();
        $tagihan = collect();

        for ($i = 0; $i < 6; $i++) {
            $bulan = $now->copy()->subMonths($i)->format('Y-m');
            $tanggalFormat = $now->copy()->subMonths($i)->translatedFormat('F Y'); // misal: Juli 2025

            $status = $pembayaran->has($bulan) ? 'Lunas' : 'Belum Lunas';

            $tagihan->push([
                'bulan' => $tanggalFormat,
                'status' => $status,
                'jumlah' => $penghuni,
            ]);
        }

        // $pengumuman = Pengumuman::latest()->take(5)->get();
        // $messages = Chat::where('penghuni_id', $user->id)->get();
        // $chatAvailable = true;

        return view('penghuni.dashboard.index', compact('pembayaran', 'tagihan'));
    }


    public function storePengaduan(Request $request)
    {
        $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        Pengaduan::create([
            'penghuni_id' => Auth::id(),
            'isi' => $request->isi,
        ]);

        return back()->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kamar' => 'required|string|max:100',
        ]);

        $user = Auth::user();
        $user->name = $request->nama;
        $user->kamar = $request->kamar;
        $user->save();

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function sendChat(Request $request)
    {
        $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        Chat::create([
            'penghuni_id' => Auth::id(),
            'from' => 'penghuni',
            'isi' => $request->isi,
        ]);

        return back()->with('success', 'Pesan terkirim.');
    }
}
