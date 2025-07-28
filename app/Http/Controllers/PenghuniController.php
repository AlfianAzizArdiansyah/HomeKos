<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\penghuni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class penghuniController extends Controller
{
    public function index()
    {
        $penghunis = penghuni::with(['kamar', 'user'])->paginate(10);
        $kamars = Kamar::where('status', 'tersedia')->get();
        return view('admin.penghuni.index', compact('penghunis', 'kamars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // 'password' => 'required|string|min:6',
            'no_hp' => 'required|string|max:20',
            'nik' => 'required|string|max:20',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_masuk' => 'required|date',
            'kamar_id' => 'nullable|exists:kamars,id',
            'status' => 'required|in:aktif,keluar',
        ]);


        // Simpan user terlebih dahulu
        $user = User::create([
            'name' => $validated['nama'],
            //'email' => strtolower(str_replace(' ', '', $validated['nama'])) . rand(100, 999) . '@gmail.com', // email dummy unik
            'password' => Hash::make('password'), // password default
            'email' => $validated['email'],
            // 'password' => Hash::make($validated['password']),
            'role' => 'penghuni',
        ]);

        // Simpan foto ktp
        $ktpPath = $request->file('foto_ktp')->store('ktp', 'public');

        // Simpan penghuni
        $penghuni = Penghuni::create([
            'user_id' => $user->id,
            'nama' => $validated['nama'],
            'no_hp' => $validated['no_hp'],
            'nik' => $validated['nik'],
            'foto_ktp' => $ktpPath,
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'kamar_id' => $validated['kamar_id'],
            'status' => $validated['status'],
        ]);

        if ($request->kamar_id && $request->status === 'aktif') {
            Kamar::where('id', $request->kamar_id)->update(['status' => 'terisi']);
        }

        return redirect()->back()->with('success', 'Penghuni berhasil ditambahkan.');
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
