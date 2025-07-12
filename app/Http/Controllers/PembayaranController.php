<?php

namespace App\Http\Controllers;


use App\Models\Pembayaran;
use App\Models\penghuni;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('penghuni.kamar')->latest()->paginate(10);
        $penghunis = penghuni::with('kamar')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'nama' => $p->nama,
                'kamar' => [
                    'nama_kamar' => $p->kamar->nama_kamar ?? '-',
                    'harga' => $p->kamar->harga ?? 0,
                ],
            ];
        });

        return view('admin.pembayaran.index', [
            'pembayarans' => $pembayarans,
            'penghunis' => $penghunis,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penghuni_id' => 'required|exists:penghunis,id',
            'jumlah' => 'required|numeric',
            'jatuh_tempo' => 'required|date',
        ]);

        $penghuni = penghuni::with('kamar')->findOrFail($request->penghuni_id);

        Pembayaran::create([
            'penghuni_id' => $request->penghuni_id,
            'jumlah' => $request->jumlah,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'belum lunas',
            'tanggal_bayar' => null,
            //'nomor_kamar' => $penghuni->kamar->nama_kamar ?? '-', // ← otomatis isi
        ]);


        return redirect()->route('admin.pembayaran.index')->with('success', 'Tagihan berhasil dibuat.');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $penghunis = penghuni::all();
        return view('admin.pembayaran.edit', compact('pembayaran', 'penghunis'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|numeric',
            'status' => 'required|in:lunas,belum lunas'
        ]);

        $pembayaran->update($request->all());
        return redirect()->route('admin.pembayaran.index')->with('success', 'Data pembayaran diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('admin.pembayaran.index')->with('success', 'Data pembayaran dihapus.');
    }

    public function cetak($id)
    {
        $pembayaran = Pembayaran::with('penghuni.kamar')->findOrFail($id);
        $pdf = Pdf::loadView('admin.pembayaran.struk', compact('pembayaran'));
        return $pdf->stream('struk_pembayaran_' . $pembayaran->id . '.pdf');
    }


    // public function export()
    // {
    //     return Excel::download(new TransaksiExport, 'transaksi.xlsx');
    // }
}