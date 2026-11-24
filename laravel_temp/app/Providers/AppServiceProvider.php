<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailKeranjang;
use App\Models\Pesanan;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.customer', function ($view) {

            $jumlahKeranjang = 0;
            $jumlahPesanan = 0;

            if (Auth::check()) {
                $idUser = Auth::id();

                // Total kuantitas produk dalam keranjang aktif user
                $jumlahKeranjang = DetailKeranjang::whereHas(
                    'keranjang',
                    function ($query) use ($idUser) {
                        $query->where('id_user', $idUser)
                              ->where('status_keranjang', 'aktif');
                    }
                )->sum('jumlah');

                // Total pesanan milik user
                $jumlahPesanan = Pesanan::where(
                    'id_user',
                    $idUser
                )->count();
            }

            $view->with([
                'jumlahKeranjang' => $jumlahKeranjang,
                'jumlahPesanan' => $jumlahPesanan,
            ]);
        });
    }
}
