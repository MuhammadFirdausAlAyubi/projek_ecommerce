<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturProduk;
use Illuminate\Http\Request;

class ReturProdukController extends Controller
{
    public function index(Request $request)
    {
        $statuses = ['diajukan', 'disetujui', 'ditolak', 'selesai'];

        $query = ReturProduk::with([
            'detailPesanan.pesanan.user',
            'detailPesanan.produk',
        ]);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('id_retur', $search)
                    ->orWhere('alasan', 'like', "%{$search}%")
                    ->orWhereHas('detailPesanan.pesanan.user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('detailPesanan.produk', function ($produkQuery) use ($search) {
                        $produkQuery->where('nama_produk', 'like', "%{$search}%");
                    });
            });
        }

        if (in_array($request->status, $statuses, true)) {
            $query->where('status_retur', $request->status);
        }

        $retur = $query->orderByDesc('tanggal_retur')
            ->paginate(10)
            ->withQueryString();

        $totalRetur = ReturProduk::count();
        $totalDiajukan = ReturProduk::where('status_retur', 'diajukan')->count();
        $totalDisetujui = ReturProduk::where('status_retur', 'disetujui')->count();
        $totalSelesai = ReturProduk::where('status_retur', 'selesai')->count();

        return view('admin.retur.index', compact(
            'retur',
            'statuses',
            'totalRetur',
            'totalDiajukan',
            'totalDisetujui',
            'totalSelesai'
        ));
    }

    public function show(string $id)
    {
        $retur = ReturProduk::with([
            'detailPesanan.pesanan.user',
            'detailPesanan.produk',
        ])->findOrFail($id);

        return view('admin.retur.show', compact('retur'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status_retur' => [
                'required',
                'in:diajukan,disetujui,ditolak,selesai',
            ],
            'keputusan_admin' => ['nullable', 'string', 'max:5000'],
        ]);

        $retur = ReturProduk::findOrFail($id);

        $retur->update([
            'status_retur' => $validated['status_retur'],
            'keputusan_admin' => $validated['keputusan_admin'] ?? null,
        ]);

        return redirect()
            ->route('admin.retur.show', $retur->id_retur)
            ->with('success', 'Status retur berhasil diperbarui.');
    }
}
