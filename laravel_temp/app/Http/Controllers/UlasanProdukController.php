<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\UlasanProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UlasanProdukController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $produk = Produk::findOrFail($id);

        // Pastikan pelanggan pernah membeli produk
        // dan pesanannya sudah selesai.
        $sudahMembeli = DB::table('detail_pesanan')
            ->join(
                'pesanan',
                'detail_pesanan.id_pesanan',
                '=',
                'pesanan.id_pesanan'
            )
            ->where('pesanan.id_user', $user->id_user)
            ->where('pesanan.status_pesanan', 'selesai')
            ->where('detail_pesanan.id_produk', $produk->id_produk)
            ->exists();

        if (!$sudahMembeli) {
            return back()->with(
                'error',
                'Kamu hanya bisa mengulas produk yang sudah dibeli dan pesanannya selesai.'
            );
        }

        UlasanProduk::updateOrCreate(
            [
                'id_produk' => $produk->id_produk,
                'id_user' => $user->id_user,
            ],
            [
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]
        );

        return back()->with(
            'success',
            'Ulasan produk berhasil disimpan.'
        );
    }
}
