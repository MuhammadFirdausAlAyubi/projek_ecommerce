<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik produk, kategori, brand, dan pelanggan
        $totalProduk = DB::table('produk')->count();

        $totalKategori = DB::table('kategori')->count();

        $totalBrand = DB::table('brand')->count();

        $totalPelanggan = DB::table('user')
            ->where('role', 'pelanggan')
            ->count();

        // Produk dengan stok kurang dari atau sama dengan stok minimum
        $totalStokMenipis = DB::table('stok')
            ->whereColumn('jumlah_stok', '<=', 'stok_minimum')
            ->count();

        // Lima produk terbaru beserta kategori dan brand
        $produkTerbaru = DB::table('produk')
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
                'produk.id_produk',
                'produk.nama_produk',
                'produk.harga_jual',
                'produk.status_produk',
                'produk.created_at',
                'kategori.nama_kategori',
                'brand.nama_brand'
            )
            ->orderByDesc('produk.created_at')
            ->limit(5)
            ->get();

        // Tampilkan dashboard AdminLTE
        return view('admin.Dashboard', compact(
            'totalProduk',
            'totalKategori',
            'totalBrand',
            'totalPelanggan',
            'totalStokMenipis',
            'produkTerbaru'
        ));
    }
}
