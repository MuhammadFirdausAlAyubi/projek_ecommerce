<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index(Request $request)
    {
        // Daftar kategori untuk dropdown filter.
        $kategoris = DB::table('kategori')
            ->orderBy('nama_kategori')
            ->get();

        // Query utama untuk daftar stok.
        $query = DB::table('stok')
            ->join(
                'produk',
                'stok.id_produk',
                '=',
                'produk.id_produk'
            )
            ->leftJoin(
                'kategori',
                'produk.id_kategori',
                '=',
                'kategori.id_kategori'
            )
            ->leftJoin(
                'brand',
                'produk.id_brand',
                '=',
                'brand.id_brand'
            )
            ->select(
                'stok.id_stok',
                'stok.id_produk',
                'stok.jumlah_stok',
                'stok.stok_minimum',
                'stok.update_at',
                'produk.nama_produk',
                'produk.gambar',
                'kategori.nama_kategori',
                'brand.nama_brand'
            );

        // Filter pencarian nama atau ID produk.
        if ($request->filled('cari')) {
            $cari = trim($request->cari);

            $query->where(function ($q) use ($cari) {
                $q->where(
                    'produk.nama_produk',
                    'like',
                    "%{$cari}%"
                )->orWhere(
                    'stok.id_produk',
                    $cari
                );
            });
        }

        // Filter kategori.
        if ($request->filled('kategori')) {
            $query->where(
                'produk.id_kategori',
                $request->kategori
            );
        }

        // Filter kondisi stok.
        if ($request->status === 'menipis') {
            $query->whereColumn(
                'stok.jumlah_stok',
                '<=',
                'stok.stok_minimum'
            );
        } elseif ($request->status === 'aman') {
            $query->whereColumn(
                'stok.jumlah_stok',
                '>',
                'stok.stok_minimum'
            );
        }

        // Daftar stok dengan pagination.
        $stoks = $query
            ->orderBy('produk.nama_produk')
            ->paginate(10)
            ->withQueryString();

        // Statistik keseluruhan stok.
        // Statistik tidak berubah saat filter daftar digunakan.
        $totalProduk = DB::table('stok')->count();

        $totalUnit = DB::table('stok')
            ->sum('jumlah_stok');

        $stokMenipis = DB::table('stok')
            ->whereColumn(
                'jumlah_stok',
                '<=',
                'stok_minimum'
            )
            ->count();

        return view('admin.stok.index', compact(
            'stoks',
            'kategoris',
            'totalProduk',
            'totalUnit',
            'stokMenipis'
        ));
    }

    public function edit($id)
    {
        $stok = DB::table('stok')
            ->join(
                'produk',
                'stok.id_produk',
                '=',
                'produk.id_produk'
            )
            ->where('stok.id_stok', $id)
            ->select(
                'stok.*',
                'produk.nama_produk'
            )
            ->first();

        if (!$stok) {
            abort(404);
        }

        return view('admin.stok.edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jumlah_stok' => [
                'required',
                'integer',
                'min:0',
            ],
            'stok_minimum' => [
                'required',
                'integer',
                'min:0',
            ],
        ], [
            'jumlah_stok.required' =>
                'Jumlah stok wajib diisi.',
            'jumlah_stok.integer' =>
                'Jumlah stok harus berupa bilangan bulat.',
            'jumlah_stok.min' =>
                'Jumlah stok tidak boleh negatif.',
            'stok_minimum.required' =>
                'Stok minimum wajib diisi.',
            'stok_minimum.integer' =>
                'Stok minimum harus berupa bilangan bulat.',
            'stok_minimum.min' =>
                'Stok minimum tidak boleh negatif.',
        ]);

        $stok = DB::table('stok')
            ->where('id_stok', $id)
            ->first();

        if (!$stok) {
            abort(404);
        }

        DB::table('stok')
            ->where('id_stok', $id)
            ->update([
                'jumlah_stok' => $validated['jumlah_stok'],
                'stok_minimum' => $validated['stok_minimum'],
                'update_at' => now(),
            ]);

        return redirect()
            ->route('admin.stok.index')
            ->with(
                'success',
                'Data stok berhasil diperbarui.'
            );
    }
}
