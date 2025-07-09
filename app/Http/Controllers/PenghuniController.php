<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghunis = Penghuni::with('kamar')->paginate(10);
        $kamars = Kamar::where('status', 'tersedia')->get();
        return view('admin.penghuni.index', compact('penghunis', 'kamars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'nik' => 'required|string',
            'foto_ktp' => 'required|image',
            'tanggal_masuk' => 'required|date',
            'kamar_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        $validated['user_id'] = auth()->id(); // atau ambil dari input jika user memilih user

        Penghuni::create($validated);

        // Ubah status kamar jadi 'terisi' jika dipilih
        if ($request->kamar_id) {
            Kamar::where('id', $request->kamar_id)->update(['status' => 'terisi']);
        }

        return redirect()->route('admin.penghuni.index')->with('success', 'Data penghuni berhasil disimpan.');
    }

    public function edit(penghuni $penghuni)
    {
        $kamars = Kamar::all();
        return view('admin.penghuni.create', compact('penghuni', 'kamars'));
    }

    public function update(Request $request, penghuni $penghuni)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'nik' => 'required|string|max:16',
            'status' => 'required|in:aktif,keluar',
            'tanggal_masuk' => 'required|date',
            'kamar_id' => 'nullable|exists:kamars,id',
        ]);

        $kamarLama = $penghuni->kamar_id; // simpan kamar sebelum diubah

        // Update foto jika ada
        if ($request->hasFile('foto_ktp')) {
            if ($penghuni->foto_ktp) {
                Storage::disk('public')->delete($penghuni->foto_ktp);
            }
            $penghuni->foto_ktp = $request->file('foto_ktp')->store('ktp', 'public');
        }

        // Update data penghuni
        $penghuni->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
            'status' => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'kamar_id' => $request->kamar_id,
            'foto_ktp' => $penghuni->foto_ktp,
        ]);

        // Update kamar lama (jika keluar atau pindah)
        if ($kamarLama && ($request->status == 'keluar' || $kamarLama != $request->kamar_id)) {
            Kamar::where('id', $kamarLama)->update(['status' => 'tersedia']);
        }

        // Update kamar baru (jika masih aktif dan pilih kamar)
        if ($request->kamar_id && $request->status == 'aktif') {
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
