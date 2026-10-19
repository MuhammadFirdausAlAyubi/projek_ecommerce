<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with('user')
            ->withCount('detailPesanan');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('id_pesanan', $search)
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $statuses = [
            'menunggu_pembayaran',
            'dibayar',
            'diproses',
            'dikirim',
            'selesai',
            'dibatalkan',
        ];

        if (in_array($request->status, $statuses, true)) {
            $query->where('status_pesanan', $request->status);
        }

        $pesanan = $query->orderByDesc('tanggal_pesanan')
            ->paginate(10)
            ->withQueryString();

        $totalPesanan = Pesanan::count();
        $totalMenunggu = Pesanan::where(
            'status_pesanan',
            'menunggu_pembayaran'
        )->count();
        $totalDiproses = Pesanan::where(
            'status_pesanan',
            'diproses'
        )->count();
        $totalSelesai = Pesanan::where(
            'status_pesanan',
            'selesai'
        )->count();

        return view('admin.pesanan.index', compact(
            'pesanan',
            'totalPesanan',
            'totalMenunggu',
            'totalDiproses',
            'totalSelesai',
            'statuses'
        ));
    }

    public function show(string $id)
    {
        $pesanan = Pesanan::with([
            'user',
            'detailPesanan.produk',
        ])->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status_pesanan' => [
                'required',
                'in:menunggu_pembayaran,dibayar,diproses,dikirim,selesai,dibatalkan',
            ],
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pesanan->update([
            'status_pesanan' => $validated['status_pesanan'],
        ]);

        return redirect()
            ->route('admin.pesanan.show', $pesanan->id_pesanan)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
