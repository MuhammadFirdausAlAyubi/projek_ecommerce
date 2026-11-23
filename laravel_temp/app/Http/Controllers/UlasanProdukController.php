<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\UlasanProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanProdukController extends Controller
{
    public function store(Request $request, $idDetailPesanan)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $detail = DetailPesanan::where(
            'id_detail_pesanan',
            $idDetailPesanan
        )
        ->whereHas('pesanan', function ($query) use ($user) {
            $query->where('id_user', $user->id_user)
                  ->where('status_pesanan', 'selesai');
        })
        ->firstOrFail();

        $sudahDiulas = UlasanProduk::where(
            'id_detail_pesanan',
            $detail->id_detail_pesanan
        )->exists();

        if ($sudahDiulas) {
            return back()->with(
                'error',
                'Item pesanan ini sudah kamu ulas.'
            );
        }

        UlasanProduk::create([
            'id_detail_pesanan' => $detail->id_detail_pesanan,
            'id_produk' => $detail->id_produk,
            'id_user' => $user->id_user,
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'] ?? null,
        ]);

        return back()->with(
            'success',
            'Ulasan produk berhasil disimpan.'
        );
    }
}