<?php

namespace App\Http\Controllers;


use App\Models\Pembayaran;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('penyewa.kamar')->latest()->paginate(10);
        $penyewas = Penyewa::with('kamar')->get()->map(function ($p) {
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
            'penyewas' => $penyewas,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penyewa_id' => 'required|exists:penyewas,id',
            'jumlah' => 'required|numeric',
            'jatuh_tempo' => 'required|date',
        ]);

        $penyewa = Penyewa::with('kamar')->findOrFail($request->penyewa_id);

        Pembayaran::create([
            'penyewa_id' => $request->penyewa_id,
            'jumlah' => $request->jumlah,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'belum lunas',
            'tanggal_bayar' => null,
            'nomor_kamar' => $penyewa->kamar->nama_kamar ?? '-', // ← otomatis isi
        ]);


        return redirect()->route('admin.pembayaran.index')->with('success', 'Tagihan berhasil dibuat.');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $penyewas = Penyewa::all();
        return view('admin.pembayaran.edit', compact('pembayaran', 'penyewas'));
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
        $pembayaran = Pembayaran::with('penyewa.kamar')->findOrFail($id);
        $pdf = Pdf::loadView('admin.pembayaran.struk', compact('pembayaran'));
        return $pdf->stream('struk_pembayaran_' . $pembayaran->id . '.pdf');
    }


    // public function export()
    // {
    //     return Excel::download(new TransaksiExport, 'transaksi.xlsx');
    // }
}
