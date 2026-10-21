<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\ReturProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReturPelangganController extends Controller
{
    /**
     * Menampilkan halaman pengajuan retur.
     */
    public function create(string $id_pesanan)
    {
        $pesanan = Pesanan::with([
            'detailPesanan.produk',
            'detailPesanan.returProduk',
        ])
            ->where('id_pesanan', $id_pesanan)
            ->where('id_user', Auth::user()->id_user)
            ->where('status_pesanan', 'selesai')
            ->firstOrFail();

        return view('customer.retur.create', compact('pesanan'));
    }

    /**
     * Menyimpan pengajuan retur pelanggan.
     */
    public function store(
        Request $request,
        string $id_pesanan
    ) {
        $validated = $request->validate([
            'id_detail_pesanan' => [
                'required',
                'integer',
            ],
            'jumlah_retur' => [
                'required',
                'integer',
                'min:1',
            ],
            'alasan' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
        ], [
            'id_detail_pesanan.required' =>
                'Produk yang ingin diretur wajib dipilih.',
            'jumlah_retur.required' =>
                'Jumlah produk yang diretur wajib diisi.',
            'jumlah_retur.integer' =>
                'Jumlah retur harus berupa angka bulat.',
            'jumlah_retur.min' =>
                'Jumlah retur minimal 1 produk.',
            'alasan.required' =>
                'Alasan retur wajib diisi.',
            'alasan.min' =>
                'Alasan retur minimal 10 karakter.',
            'alasan.max' =>
                'Alasan retur maksimal 5000 karakter.',
        ]);

        DB::transaction(function () use (
            $id_pesanan,
            $validated
        ) {
            $detail = DetailPesanan::where(
                'id_detail_pesanan',
                $validated['id_detail_pesanan']
            )
                ->where('id_pesanan', $id_pesanan)
                ->whereHas('pesanan', function ($query) {
                    $query
                        ->where(
                            'id_user',
                            Auth::user()->id_user
                        )
                        ->where('status_pesanan', 'selesai');
                })
                ->lockForUpdate()
                ->firstOrFail();

            $jumlahSudahDiretur = ReturProduk::where(
                'id_detail_pesanan',
                $detail->id_detail_pesanan
            )
                ->whereIn('status_retur', [
                    'diajukan',
                    'disetujui',
                    'selesai',
                ])
                ->sum('jumlah_retur');

            $sisaJumlah = (int) $detail->jumlah
                - (int) $jumlahSudahDiretur;

            if (
                $sisaJumlah < 1 ||
                (int) $validated['jumlah_retur'] > $sisaJumlah
            ) {
                throw ValidationException::withMessages([
                    'jumlah_retur' =>
                        'Jumlah retur melebihi sisa produk yang masih bisa diretur.',
                ]);
            }

            ReturProduk::create([
                'id_detail_pesanan' =>
                    $detail->id_detail_pesanan,
                'tanggal_retur' => now(),
                'jumlah_retur' =>
                    $validated['jumlah_retur'],
                'alasan' => $validated['alasan'],
                'status_retur' => 'diajukan',
                'keputusan_admin' => null,
            ]);
        });

        return redirect()
            ->route('pesanan-saya.show', $id_pesanan)
            ->with(
                'success',
                'Pengajuan retur berhasil dikirim dan menunggu pemeriksaan admin.'
            );
    }
}
