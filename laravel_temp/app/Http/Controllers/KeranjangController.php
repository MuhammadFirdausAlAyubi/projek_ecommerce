<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\DetailKeranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    // Mengambil atau membuat keranjang aktif milik user
    private function keranjangAktif()
    {
        return Keranjang::firstOrCreate(
            [
                'id_user' => Auth::id(),
                'status_keranjang' => 'aktif',
            ],
            [
                'tanggal_dibuat' => now(),
            ]
        );
    }

    // Menampilkan isi keranjang
    public function index()
    {
        $keranjang = $this->keranjangAktif();

        $keranjang->load('detailKeranjang.produk');

        $total = $keranjang->detailKeranjang->sum(function ($detail) {
            return $detail->jumlah * $detail->produk->harga_jual;
        });

        return view('customer.keranjang', compact(
            'keranjang',
            'total'
        ));
    }

    // Menambahkan produk ke keranjang
    public function tambah(Request $request, $id_produk)
    {
        $request->validate([
            'jumlah' => ['nullable', 'integer', 'min:1'],
        ]);

        $jumlah = (int) $request->input('jumlah', 1);

        $hasil = DB::transaction(function () use ($id_produk, $jumlah) {
            $produk = Produk::where('id_produk', $id_produk)
                ->where('status_produk', 'aktif')
                ->first();

            if (!$produk) {
                return 'Produk tidak ditemukan atau tidak aktif.';
            }

            $stok = DB::table('stok')
                ->where('id_produk', $id_produk)
                ->lockForUpdate()
                ->first();

            if (!$stok || $stok->jumlah_stok < 1) {
                return 'Stok produk sedang kosong.';
            }

            $keranjang = $this->keranjangAktif();

            $detail = DetailKeranjang::where(
                'id_keranjang',
                $keranjang->id_keranjang
            )->where('id_produk', $id_produk)
                ->lockForUpdate()
                ->first();

            $jumlahBaru = $jumlah + ($detail->jumlah ?? 0);

            if ($jumlahBaru > $stok->jumlah_stok) {
                return 'Jumlah melebihi stok yang tersedia (' .
                    $stok->jumlah_stok . ').';
            }

            if ($detail) {
                $detail->update([
                    'jumlah' => $jumlahBaru,
                ]);
            } else {
                DetailKeranjang::create([
                    'id_keranjang' => $keranjang->id_keranjang,
                    'id_produk' => $produk->id_produk,
                    'jumlah' => $jumlah,
                    'tanggal_ditambahkan' => now(),
                ]);
            }

            return null;
        });

        if ($hasil !== null) {
            return back()->with('error', $hasil);
        }

        return redirect()->route('keranjang.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Mengubah jumlah produk
    public function update(Request $request, $id_detail_keranjang)
    {
        $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $keranjang = $this->keranjangAktif();

        $detail = DetailKeranjang::where(
            'id_keranjang',
            $keranjang->id_keranjang
        )->where(
            'id_detail_keranjang',
            $id_detail_keranjang
        )->with('produk')->firstOrFail();

        $stok = DB::table('stok')
            ->where('id_produk', $detail->id_produk)
            ->value('jumlah_stok');

        if ($stok === null || $request->jumlah > $stok) {
            return back()->with(
                'error',
                'Jumlah melebihi stok yang tersedia (' .
                ($stok ?? 0) . ').'
            );
        }

        $detail->update([
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('keranjang.index')
            ->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    // Menghapus produk dari keranjang
    public function hapus($id_detail_keranjang)
    {
        $keranjang = $this->keranjangAktif();

        $detail = DetailKeranjang::where(
            'id_keranjang',
            $keranjang->id_keranjang
        )->where(
            'id_detail_keranjang',
            $id_detail_keranjang
        )->firstOrFail();

        $detail->delete();

        return redirect()->route('keranjang.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
