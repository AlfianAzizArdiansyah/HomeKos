<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class penghuniController extends Controller
{
    public function index()
    {
        $penghunis = penghuni::with('kamar')->paginate(10);
        $kamars = Kamar::where('status', 'tersedia')->get();
        return view('admin.penghuni.index', compact('penghunis', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'nik' => 'required|string|max:16',
            'foto_ktp' => 'required|image|max:2048',
            'kamar_id' => 'nullable|exists:kamars,id',
            'tanggal_masuk' => 'required|date',
        ]);

        $path = $request->file('foto_ktp')->store('ktp', 'public');

        $penghuni = penghuni::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
            'foto_ktp' => $path,
            'kamar_id' => $request->kamar_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'status' => 'aktif',
            'user_id' => auth()->id(),
        ]);

        // Ubah status kamar jadi 'terisi' jika dipilih
        if ($request->kamar_id) {
            Kamar::where('id', $request->kamar_id)->update(['status' => 'terisi']);
        }

        return redirect()->route('admin.penghuni.index')->with('success', 'penghuni berhasil ditambahkan.');
    }

    public function edit(penghuni $penghuni)
    {
        $kamars = Kamar::all();
        return view('admin.penghuni.create', compact('penghuni', 'kamars'));
    }

    public function update(Request $request, Penghuni $penghuni)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'nik' => 'required|string|max:16',
            'status' => 'required|in:aktif,keluar',
            'kamar_id' => 'nullable|exists:kamars,id',
            'tanggal_masuk' => 'required|date',
        ]);

        $kamarLama = $penghuni->kamar_id;

        // Update foto jika ada
        if ($request->hasFile('foto_ktp')) {
            if ($penghuni->foto_ktp) {
                Storage::disk('public')->delete($penghuni->foto_ktp);
            }
            $penghuni->foto_ktp = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $penghuni->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
            'status' => $request->status,
            'kamar_id' => $request->kamar_id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'foto_ktp' => $penghuni->foto_ktp,
        ]);

        // Jika pindah kamar atau keluar, kamar lama jadi tersedia
        if ($kamarLama && ($request->status === 'keluar' || $request->kamar_id !== $kamarLama)) {
            Kamar::where('id', $kamarLama)->update(['status' => 'tersedia']);
        }

        // Jika status aktif dan kamar baru ada, tandai sebagai 'terisi'
        if ($request->status === 'aktif' && !is_null($request->kamar_id)) {
            Kamar::where('id', $request->kamar_id)->update(['status' => 'terisi']);
        }

        return redirect()->route('admin.penghuni.index')->with('success', 'Data penghuni diperbarui.');
    }


    public function destroy(penghuni $penghuni)
    {
        if ($penghuni->foto_ktp) {
            Storage::disk('public')->delete($penghuni->foto_ktp);
        }

        // Kosongkan kamar
        if ($penghuni->kamar) {
            $penghuni->kamar->update(['status' => 'tersedia']);
        }

        $penghuni->delete();

        return redirect()->route('admin.penghuni.index')->with('success', 'penghuni dihapus.');
    }
}