<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Bank;
use App\Models\DetailPesanan;
use App\Models\Ekspedisi;
use App\Models\Keranjang;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $user = Auth::user();

        $keranjang = Keranjang::with([
            'detailKeranjang.produk',
        ])
            ->where('id_user', $user->id_user)
            ->where('status_keranjang', 'aktif')
            ->first();

        if (
            !$keranjang ||
            $keranjang->detailKeranjang->isEmpty()
        ) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        $alamat = Alamat::where('id_user', $user->id_user)
            ->orderByDesc('is_utama')
            ->orderByDesc('id_alamat')
            ->get();

        if ($alamat->isEmpty()) {
            return redirect()
                ->route('account.profile')
                ->with(
                    'error',
                    'Tambahkan alamat pengiriman terlebih dahulu.'
                );
        }

        $bank = Bank::where('status_bank', 'aktif')
            ->orderBy('nama_bank')
            ->get();

        $ekspedisi = Ekspedisi::where(
            'status_ekspedisi',
            'aktif'
        )
            ->orderBy('nama_ekspedisi')
            ->get();

        $total = $keranjang->detailKeranjang->sum(
            function ($detail) {
                return (float) (
                    $detail->produk->harga_jual ?? 0
                ) * (int) $detail->jumlah;
            }
        );

        return view('customer.checkout', compact(
            'keranjang',
            'alamat',
            'bank',
            'ekspedisi',
            'total'
        ));
    }

    /**
     * Memproses checkout dan menyimpan pesanan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_alamat' => [
                'required',
                'integer',
                'exists:alamat,id_alamat',
            ],

            'id_ekspedisi' => [
                'required',
                'integer',
                'exists:ekspedisi,id_ekspedisi',
            ],

            'metode_pembayaran' => [
                'required',
                'in:transfer,cod,ewallet',
            ],

            'id_bank' => [
                'nullable',
                'required_if:metode_pembayaran,transfer',
                'integer',
            ],
        ], [
            'id_alamat.required' =>
                'Pilih alamat pengiriman terlebih dahulu.',

            'id_ekspedisi.required' =>
                'Pilih ekspedisi pengiriman.',

            'metode_pembayaran.required' =>
                'Pilih metode pembayaran.',

            'metode_pembayaran.in' =>
                'Metode pembayaran tidak valid.',

            'id_bank.required_if' =>
                'Pilih bank untuk pembayaran transfer.',
        ]);

        $user = Auth::user();

        /*
         * Pastikan alamat milik pelanggan yang login.
         */
        $alamat = Alamat::where(
            'id_alamat',
            $validated['id_alamat']
        )
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        /*
         * Pastikan ekspedisi masih aktif.
         */
        $ekspedisi = Ekspedisi::where(
            'id_ekspedisi',
            $validated['id_ekspedisi']
        )
            ->where('status_ekspedisi', 'aktif')
            ->first();

        if (!$ekspedisi) {
            throw ValidationException::withMessages([
                'id_ekspedisi' =>
                    'Ekspedisi tidak tersedia. Silakan pilih ekspedisi lain.',
            ]);
        }

        /*
         * Tarif diambil dari database,
         * bukan dari input yang dikirim browser.
         */
        $ongkir = (float) $ekspedisi->ongkir;

        $metode = $validated['metode_pembayaran'];
        $bank = null;

        /*
         * Validasi bank untuk pembayaran transfer.
         */
        if ($metode === 'transfer') {
            $bank = Bank::where(
                'id_bank',
                $validated['id_bank'] ?? null
            )
                ->where('status_bank', 'aktif')
                ->first();

            if (!$bank) {
                throw ValidationException::withMessages([
                    'id_bank' =>
                        'Bank tidak tersedia. Silakan pilih bank lain.',
                ]);
            }
        }

        /*
         * Simpan salinan alamat saat checkout.
         * Perubahan alamat pelanggan nantinya tidak mengubah
         * alamat pengiriman yang tercatat pada pesanan.
         */
        $alamatSnapshot = implode(', ', array_filter([
            $alamat->nama_penerima,
            $alamat->no_telp_penerima,
            $alamat->alamat_lengkap,
            $alamat->kecamatan,
            $alamat->kota,
            $alamat->provinsi,
            $alamat->kode_pos,
        ]));

        /*
         * Seluruh proses checkout berada dalam transaksi.
         * Jika salah satu proses gagal, perubahan database
         * di dalam transaksi akan dibatalkan.
         */
        $idPesanan = DB::transaction(function () use (
            $user,
            $alamat,
            $alamatSnapshot,
            $ekspedisi,
            $ongkir,
            $metode,
            $bank
        ) {
            /*
             * Kunci keranjang aktif untuk mengurangi risiko
             * checkout ganda pada keranjang yang sama.
             */
            $keranjang = Keranjang::where(
                'id_user',
                $user->id_user
            )
                ->where('status_keranjang', 'aktif')
                ->lockForUpdate()
                ->first();

            if (!$keranjang) {
                throw ValidationException::withMessages([
                    'keranjang' =>
                        'Keranjang aktif tidak ditemukan. Silakan periksa pesanan kamu.',
                ]);
            }

            /*
             * Ambil detail keranjang beserta produknya.
             */
            $items = $keranjang->detailKeranjang()
                ->with('produk')
                ->lockForUpdate()
                ->get();

            if ($items->isEmpty()) {
                throw ValidationException::withMessages([
                    'keranjang' =>
                        'Keranjang kamu masih kosong.',
                ]);
            }

            $subtotalPesanan = 0;
            $rincian = [];

            /*
             * Periksa produk dan stok.
             * Stok belum dikurangi sebelum validasi setiap
             * produk berhasil.
             */
            foreach ($items as $item) {
                $produk = $item->produk;
                $jumlahBeli = (int) $item->jumlah;

                if (!$produk || $produk->status_produk !== 'aktif') {
                    throw ValidationException::withMessages([
                        'keranjang' =>
                            'Ada produk yang sudah tidak tersedia.',
                    ]);
                }

                if ($jumlahBeli < 1) {
                    throw ValidationException::withMessages([
                        'keranjang' =>
                            'Jumlah pembelian produk tidak valid.',
                    ]);
                }

                /*
                 * Kunci baris stok produk agar jumlah stok
                 * diperiksa ulang sebelum dikurangi.
                 */
                $stok = DB::table('stok')
                    ->where('id_produk', $produk->id_produk)
                    ->lockForUpdate()
                    ->first();

                if (
                    !$stok ||
                    (int) $stok->jumlah_stok < $jumlahBeli
                ) {
                    throw ValidationException::withMessages([
                        'keranjang' =>
                            'Stok ' . $produk->nama_produk
                            . ' tidak mencukupi. Silakan periksa kembali keranjang kamu.',
                    ]);
                }

                $harga = (float) $produk->harga_jual;
                $subtotal = $harga * $jumlahBeli;

                $rincian[] = [
                    'id_produk' => $produk->id_produk,
                    'jumlah' => $jumlahBeli,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal,
                ];

                $subtotalPesanan += $subtotal;
            }

            /*
             * Hitung total produk ditambah ongkir.
             */
            $totalAkhir = $subtotalPesanan + $ongkir;

            /*
             * Buat pesanan.
             */
            $pesanan = new Pesanan();

            $pesanan->id_user = $user->id_user;
            $pesanan->id_alamat = $alamat->id_alamat;
            $pesanan->alamat_pengiriman_snapshot =
                $alamatSnapshot;
            $pesanan->tanggal_pesanan = now();
            $pesanan->total_harga = $totalAkhir;
            $pesanan->ongkir = $ongkir;
            $pesanan->status_pesanan =
                'menunggu_pembayaran';

            $pesanan->save();

            /*
             * Simpan detail produk yang dibeli.
             */
            foreach ($rincian as $detail) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $detail['id_produk'],
                    'jumlah' => $detail['jumlah'],
                    'harga_satuan' =>
                        $detail['harga_satuan'],
                    'subtotal' => $detail['subtotal'],
                ]);
            }

            /*
             * Kurangi stok setelah pesanan dan detail
             * berhasil disiapkan.
             *
             * Pemeriksaan jumlah stok dilakukan lagi pada
             * query UPDATE untuk menjaga konsistensi.
             *
             * Jika UPDATE gagal, lempar exception agar
             * seluruh transaksi dibatalkan.
             */
            foreach ($rincian as $detail) {
                $jumlahBeli = $detail['jumlah'];

                $stokBerhasilDikurangi = DB::table('stok')
                    ->where('id_produk', $detail['id_produk'])
                    ->where(
                        'jumlah_stok',
                        '>=',
                        $jumlahBeli
                    )
                    ->decrement(
                        'jumlah_stok',
                        $jumlahBeli,
                        [
                            'update_at' => now(),
                        ]
                    );

                if ($stokBerhasilDikurangi !== 1) {
                    throw ValidationException::withMessages([
                        'keranjang' =>
                            'Stok produk berubah atau tidak mencukupi. Silakan coba checkout kembali.',
                    ]);
                }
            }

            /*
             * Simpan data pembayaran.
             * Status pembayaran mengikuti struktur kode
             * sebelumnya: menunggu.
             */
            Pembayaran::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_bank' => $bank?->id_bank,
                'metode_pembayaran' => $metode,
                'tanggal_pembayaran' => null,
                'nominal' => $totalAkhir,
                'status_pembayaran' => 'menunggu',
            ]);

            /*
             * Catat ekspedisi yang dipilih pelanggan.
             */
            DB::table('pengiriman')->insert([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_ekspedisi' => $ekspedisi->id_ekspedisi,
                'no_resi' => null,
                'tanggal_pengiriman' => null,
                'tanggal_diterima' => null,
                'status_pengiriman' => 'menunggu',
            ]);

            /*
             * Tandai keranjang sudah checkout.
             * Keranjang ini tidak dapat diproses kembali
             * sebagai keranjang aktif.
             */
            $keranjang->update([
                'status_keranjang' => 'checkout',
            ]);

            return $pesanan->id_pesanan;
        });

        /*
         * Redirect setelah transaksi berhasil.
         */
        return redirect()
            ->route('keranjang.index')
            ->with(
                'success',
                'Pesanan #' . $idPesanan
                . ' berhasil dibuat. Total sudah termasuk ongkir. '
                . 'Status pembayaran masih menunggu.'
            );
    }
}
