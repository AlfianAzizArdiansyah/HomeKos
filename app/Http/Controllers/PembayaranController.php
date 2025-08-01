<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('penghuni.kamar')
            ->whereIn('status', ['Proses', 'Belum Lunas', 'Lunas'])
            ->latest()
            ->paginate(10);

        $penghunis = Penghuni::with(['kamar', 'jatuhTempo'])->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'nama' => $p->nama,
                'tanggal_masuk' => $p->tanggal_masuk,
                'kamar' => [
                    'nama_kamar' => $p->kamar->nama_kamar ?? '-',
                    'harga' => $p->kamar->harga ?? 0,
                ],
                'pembayaran_terakhir' => $p->jatuhTempo ? [
                    'jatuh_tempo' => $p->jatuhTempo->jatuh_tempo,
                ] : null,
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

        Pembayaran::create([
            'penghuni_id' => $request->penghuni_id,
            'jumlah' => $request->jumlah,
            'status' => 'Belum Lunas',
            'jatuh_tempo' => $request->jatuh_tempo,
        ]);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Tagihan berhasil dibuat.');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $penghunis = Penghuni::all();
        return view('admin.pembayaran.edit', compact('pembayaran', 'penghunis'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'tanggal_bayar' => 'required_if:status,Lunas|nullable|date',
            'jumlah' => 'required|numeric',
            'status' => 'required|in:Lunas,Proses,Belum Lunas',
            'jatuh_tempo' => 'required|date',
        ]);

        $data = [
            'jumlah' => $request->jumlah,
            'status' => $request->status,
            'jatuh_tempo' => $request->jatuh_tempo,
        ];

        $data['tanggal_bayar'] = $request->status === 'Lunas'
            ? ($request->tanggal_bayar ?? now()->format('Y-m-d'))
            : null;

        $pembayaran->update($data);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Data pembayaran diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('admin.pembayaran.index')->with('success', 'Data pembayaran dihapus.');
    }

    public function cetakInvoice($id)
    {
        $pembayaran = Pembayaran::with('penghuni.kamar')->findOrFail($id);

        return Pdf::loadView('penghuni.pembayaran.invoice', compact('pembayaran'))
            ->stream('invoice-' . $pembayaran->id . '.pdf');
    }

    public function riwayat()
    {
        $latestPayments = Pembayaran::select(DB::raw('MAX(id) as id'))
            ->groupBy('penghuni_id');

        $pembayarans = Pembayaran::with('penghuni.kamar')
            ->whereIn('id', $latestPayments)
            ->latest()
            ->paginate(10);

        return view('admin.pembayaran.riwayat', compact('pembayarans'));
    }

    public function riwayatBayar($id)
    {
        $pembayaran = Pembayaran::with('penghuni.kamar')->findOrFail($id);

        $semuaPembayaran = Pembayaran::where('penghuni_id', $pembayaran->penghuni_id)
            ->where('status', 'Lunas')
            ->orderBy('tanggal_bayar')
            ->get();

        return view('admin.pembayaran.riwayatbayar', [
            'pembayaran' => $pembayaran,
            'semuaPembayaran' => $semuaPembayaran,
        ]);
    }

    public function showTransfer($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        return view('penghuni.pembayaran.transfer', compact('pembayaran'));
    }

    public function cetakPDF()
    {
        $userId = Auth::id();

        $riwayatPembayaran = Pembayaran::with('penghuni.kamar')
            ->where('status', 'Lunas')
            ->whereHas('penghuni', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return Pdf::loadView('penghuni.pembayaran.cetak-pdf', compact('riwayatPembayaran'))->stream('riwayat_pembayaran.pdf');
    }
}