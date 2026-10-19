<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    /**
     * Menampilkan seluruh keranjang pelanggan.
     */
    public function index(Request $request)
    {
        // Statistik seluruh keranjang
        $totalKeranjang = Keranjang::count();

        $totalAktif = Keranjang::where(
            'status_keranjang',
            'aktif'
        )->count();

        $totalCheckout = Keranjang::where(
            'status_keranjang',
            'checkout'
        )->count();

        $totalDikosongkan = Keranjang::where(
            'status_keranjang',
            'dikosongkan'
        )->count();

        // Query daftar keranjang
        $query = Keranjang::with('user')
            ->withCount('detailKeranjang');

        // Filter pencarian ID keranjang, nama, dan email pelanggan
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where(
                        'id_keranjang',
                        (int) $search
                    );
                }

                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where(
                        'nama',
                        'like',
                        '%' . $search . '%'
                    )->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    );
                });
            });
        }

        // Filter status keranjang
        $statusValid = [
            'aktif',
            'checkout',
            'dikosongkan',
        ];

        if (
            $request->filled('status')
            && in_array($request->input('status'), $statusValid, true)
        ) {
            $query->where(
                'status_keranjang',
                $request->input('status')
            );
        }

        // Urutkan keranjang terbaru terlebih dahulu
        $keranjang = $query
            ->orderByDesc('tanggal_dibuat')
            ->orderByDesc('id_keranjang')
            ->paginate(10)
            ->withQueryString();

        return view('admin.keranjang.index', compact(
            'keranjang',
            'totalKeranjang',
            'totalAktif',
            'totalCheckout',
            'totalDikosongkan'
        ));
    }

    /**
     * Menampilkan detail satu keranjang pelanggan.
     */
    public function show(string $id)
    {
        $keranjang = Keranjang::with([
            'user',
            'detailKeranjang.produk',
            'detailKeranjang.varian',
        ])->findOrFail($id);

        $total = $keranjang->detailKeranjang->sum(function ($detail) {
            return (float) ($detail->produk->harga_jual ?? 0)
                * (int) $detail->jumlah;
        });

        return view(
            'admin.keranjang.show',
            compact('keranjang', 'total')
        );
    }

    /**
     * Mengosongkan isi keranjang yang masih aktif.
     * Data keranjang dan akun pelanggan tetap dipertahankan.
     */
    public function destroy(string $id)
    {
        $keranjang = Keranjang::findOrFail($id);

        if ($keranjang->status_keranjang !== 'aktif') {
            return redirect()
                ->route('admin.keranjang.index')
                ->with(
                    'error',
                    'Hanya keranjang aktif yang dapat dikosongkan.'
                );
        }

        DB::transaction(function () use ($keranjang) {
            $keranjang->detailKeranjang()->delete();
        });

        return redirect()
            ->route('admin.keranjang.index')
            ->with(
                'success',
                'Isi keranjang pelanggan berhasil dikosongkan.'
            );
    }
}
