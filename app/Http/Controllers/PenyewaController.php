<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyewaController extends Controller
{
    public function index()
    {
        $penyewas = Penyewa::with('kamar')->paginate(10);
        $kamars = Kamar::where('status', 'tersedia')->get();
        return view('admin.penyewa.index', compact('penyewas', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'nik' => 'required|string|max:16',
            'foto_ktp' => 'required|image|max:2048',
            'kamar_id' => 'nullable|exists:kamars,id'
        ]);

        $path = $request->file('foto_ktp')->store('ktp', 'public');

        $penyewa = Penyewa::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
            'foto_ktp' => $path,
            'kamar_id' => $request->kamar_id,
            'status' => 'aktif',
        ]);

        // Ubah status kamar jadi 'terisi' jika dipilih
        if ($request->kamar_id) {
            Kamar::where('id', $request->kamar_id)->update(['status' => 'terisi']);
        }

        return redirect()->route('admin.penyewa.index')->with('success', 'Penyewa berhasil ditambahkan.');
    }

    public function edit(Penyewa $penyewa)
    {
        $kamars = Kamar::all();
        return view('admin.penyewa.create', compact('penyewa', 'kamars'));
    }

    public function update(Request $request, Penyewa $penyewa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'nik' => 'required|string|max:16',
            'status' => 'required|in:aktif,keluar',
            'kamar_id' => 'nullable|exists:kamars,id',
        ]);

        $kamarLama = $penyewa->kamar_id; // simpan kamar sebelum diubah

        // Update foto jika ada
        if ($request->hasFile('foto_ktp')) {
            if ($penyewa->foto_ktp) {
                Storage::disk('public')->delete($penyewa->foto_ktp);
            }
            $penyewa->foto_ktp = $request->file('foto_ktp')->store('ktp', 'public');
        }

        // Update data penyewa
        $penyewa->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'nik' => $request->nik,
            'status' => $request->status,
            'kamar_id' => $request->kamar_id,
            'foto_ktp' => $penyewa->foto_ktp,
        ]);

        // Update kamar lama (jika keluar atau pindah)
        if ($kamarLama && ($request->status == 'keluar' || $kamarLama != $request->kamar_id)) {
            Kamar::where('id', $kamarLama)->update(['status' => 'tersedia']);
        }

        // Update kamar baru (jika masih aktif dan pilih kamar)
        if ($request->kamar_id && $request->status == 'aktif') {
            Kamar::where('id', $request->kamar_id)->update(['status' => 'terisi']);
        }

        return redirect()->route('admin.penyewa.index')->with('success', 'Data penyewa diperbarui.');
    }


    public function destroy(Penyewa $penyewa)
    {
        if ($penyewa->foto_ktp) {
            Storage::disk('public')->delete($penyewa->foto_ktp);
        }

        // Kosongkan kamar
        if ($penyewa->kamar) {
            $penyewa->kamar->update(['status' => 'tersedia']);
        }

        $penyewa->delete();

        return redirect()->route('admin.penyewa.index')->with('success', 'Penyewa dihapus.');
    }
}
