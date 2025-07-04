<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::paginate(10);
        return view('admin.kamar.index', compact('kamars'));
    }


    public function create()
    {
        return view('admin.kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kamar' => 'required|string|max:255',
            'status' => 'required|in:tersedia,terisi',
            'harga' => 'required|numeric|min:0',
        ]);

        Kamar::create([
            'nama_kamar' => $request->nama_kamar,
            'status' => $request->status ?? 'tersedia',
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Kamar $kamar)
    {
        return view('admin.kamar.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'nama_kamar' => 'required|string|max:255',
            'status' => 'required|in:tersedia,terisi',
            'harga' => 'required|numeric|min:0',
        ]);

        $kamar->update([
            'nama_kamar' => $request->nama_kamar,
            'status' => $request->status,
            'fasilitas' => $request->fasilitas,
            'harga' => $request->harga,
        ]);

        return redirect()->route('admin.kamar.index')->with('success', 'Kamar diperbarui.');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar dihapus.');
    }
}
