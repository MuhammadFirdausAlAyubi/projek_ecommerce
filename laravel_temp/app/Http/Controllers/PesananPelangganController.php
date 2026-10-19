<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananPelangganController extends Controller
{
    /**
     * Menampilkan semua pesanan milik pelanggan yang login.
     */
    public function index()
    {
        $pesanan = Pesanan::with([
            'detailPesanan.produk',
            'pembayaran',
            'pengiriman.ekspedisi',
        ])
            ->where('id_user', Auth::user()->id_user)
            ->orderByDesc('tanggal_pesanan')
            ->orderByDesc('id_pesanan')
            ->paginate(10);

        return view('customer.pesanan.index', compact('pesanan'));
    }

    /**
     * Menampilkan detail pesanan beserta ulasan produk.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'detailPesanan.produk.ulasanProduk',
            'pembayaran',
            'pengiriman.ekspedisi',
            'alamat',
        ])
            ->where('id_user', Auth::user()->id_user)
            ->where('id_pesanan', $id)
            ->firstOrFail();

        return view('customer.pesanan.show', compact('pesanan'));
    }
}
