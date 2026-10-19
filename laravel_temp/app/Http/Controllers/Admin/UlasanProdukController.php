<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UlasanProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('ulasan_produk')
            ->leftJoin('user', 'ulasan_produk.id_user', '=', 'user.id_user')
            ->leftJoin('produk', 'ulasan_produk.id_produk', '=', 'produk.id_produk')
            ->select(
                'ulasan_produk.*',
                'user.nama as nama_pelanggan',
                'user.email as email_pelanggan',
                'produk.nama_produk'
            );

        if ($request->filled('q')) {
            $keyword = $request->q;

            $query->where(function ($q) use ($keyword) {
                $q->where('user.nama', 'like', "%{$keyword}%")
                    ->orWhere('user.email', 'like', "%{$keyword}%")
                    ->orWhere('produk.nama_produk', 'like', "%{$keyword}%")
                    ->orWhere('ulasan_produk.komentar', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('rating')) {
            $query->where('ulasan_produk.rating', $request->rating);
        }

        $ulasan = $query
            ->orderByDesc('ulasan_produk.created_at')
            ->paginate(10)
            ->withQueryString();

        $totalUlasan = DB::table('ulasan_produk')->count();

        $rataRataRating = round(
            (float) DB::table('ulasan_produk')->avg('rating'),
            1
        );

        $totalBintangLima = DB::table('ulasan_produk')
            ->where('rating', 5)
            ->count();

        return view('admin.ulasan.index', compact(
            'ulasan',
            'totalUlasan',
            'rataRataRating',
            'totalBintangLima'
        ));
    }

    public function destroy($id)
    {
        $ulasan = DB::table('ulasan_produk')
            ->where('id_ulasan_produk', $id)
            ->first();

        abort_if(!$ulasan, 404);

        DB::table('ulasan_produk')
            ->where('id_ulasan_produk', $id)
            ->delete();

        return redirect()
            ->route('admin.ulasan.index')
            ->with('success', 'Ulasan berhasil dihapus.');
    }
}
