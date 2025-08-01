<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class AdminPengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('user')->latest()->get();
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required|string',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->tanggapan = $request->tanggapan;
        $pengaduan->save();

        return redirect()->back()->with('success', 'Tanggapan berhasil disimpan.');
    }
}
