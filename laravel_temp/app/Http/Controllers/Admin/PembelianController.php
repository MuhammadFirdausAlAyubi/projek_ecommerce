<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPembelian;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with('supplier')
            ->withCount('detailPembelian')
            ->orderByDesc('id_pembelian');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id_pembelian', $search)
                    ->orWhereHas('supplier', function ($supplier) use ($search) {
                        $supplier->where('nama_supplier', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status_pembelian', $request->status);
        }

        $pembelian = $query->paginate(10)->withQueryString();

        return view('admin.pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $supplier = Supplier::orderBy('nama_supplier')->get();
        $produk = Produk::orderBy('nama_produk')->get();

        return view('admin.pembelian.create', compact(
            'supplier',
            'produk'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_supplier' => [
                'required',
                'integer',
                Rule::exists('supplier', 'id_supplier'),
            ],
            'tanggal_pembelian' => ['required', 'date'],
            'id_produk' => ['required', 'array', 'min:1'],
            'id_produk.*' => [
                'required',
                'integer',
                Rule::exists('produk', 'id_produk'),
                'distinct',
            ],
            'jumlah' => ['required', 'array'],
            'jumlah.*' => ['required', 'integer', 'min:1'],
            'harga_beli' => ['required', 'array'],
            'harga_beli.*' => ['required', 'numeric', 'min:0'],
        ]);

        if (
            count($validated['id_produk']) !== count($validated['jumlah']) ||
            count($validated['id_produk']) !== count($validated['harga_beli'])
        ) {
            return back()->withInput()
                ->withErrors(['id_produk' => 'Data produk tidak lengkap.']);
        }

        DB::transaction(function () use ($validated) {
            $total = 0;

            foreach ($validated['id_produk'] as $i => $idProduk) {
                $total += (int) $validated['jumlah'][$i]
                    * (float) $validated['harga_beli'][$i];
            }

            $pembelian = Pembelian::create([
                'id_supplier' => $validated['id_supplier'],
                'tanggal_pembelian' => $validated['tanggal_pembelian'],
                'total_pembelian' => $total,
                'status_pembelian' => 'dipesan',
            ]);

            foreach ($validated['id_produk'] as $i => $idProduk) {
                $jumlah = (int) $validated['jumlah'][$i];
                $harga = (float) $validated['harga_beli'][$i];

                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_produk' => $idProduk,
                    'jumlah' => $jumlah,
                    'harga_beli' => $harga,
                    'subtotal' => $jumlah * $harga,
                ]);
            }
        });

        return redirect()->route('admin.pembelian.index')
            ->with('success', 'Pembelian berhasil dibuat.');
    }

    public function show(string $id)
    {
        $pembelian = Pembelian::with([
            'supplier',
            'detailPembelian.produk',
        ])->findOrFail($id);

        return view('admin.pembelian.show', compact('pembelian'));
    }

    public function edit(string $id)
    {
        $pembelian = Pembelian::with('supplier')->findOrFail($id);

        if ($pembelian->status_pembelian !== 'dipesan') {
            return redirect()->route('admin.pembelian.index')
                ->with('error', 'Hanya pembelian berstatus dipesan yang bisa diubah.');
        }

        $supplier = Supplier::orderBy('nama_supplier')->get();
        $produk = Produk::orderBy('nama_produk')->get();

        return view('admin.pembelian.edit', compact(
            'pembelian',
            'supplier',
            'produk'
        ));
    }

    public function update(Request $request, string $id)
    {
        $pembelian = Pembelian::with('detailPembelian')->findOrFail($id);

        $validated = $request->validate([
            'status_pembelian' => [
                'required',
                Rule::in(['dipesan', 'diterima', 'dibatalkan']),
            ],
        ]);

        DB::transaction(function () use ($pembelian, $validated) {
            $statusLama = $pembelian->status_pembelian;
            $statusBaru = $validated['status_pembelian'];

            if ($statusLama === $statusBaru) {
                return;
            }

            if ($statusLama !== 'dipesan') {
                throw new \RuntimeException(
                    'Status pembelian yang sudah diproses tidak dapat diubah lagi.'
                );
            }

            if ($statusBaru === 'diterima') {
                foreach ($pembelian->detailPembelian as $detail) {
                    $stok = Stok::where(
                        'id_produk',
                        $detail->id_produk
                    )->lockForUpdate()->first();

                    if (!$stok) {
                        throw new \RuntimeException(
                            'Data stok produk ID ' . $detail->id_produk .
                            ' belum tersedia. Buat data stok terlebih dahulu.'
                        );
                    }

                    $stok->jumlah_stok += $detail->jumlah;
                    $stok->update_at = now();
                    $stok->save();
                }
            }

            $pembelian->status_pembelian = $statusBaru;
            $pembelian->save();
        });

        return redirect()->route('admin.pembelian.index')
            ->with('success', 'Status pembelian berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        if ($pembelian->status_pembelian !== 'dipesan') {
            return redirect()->route('admin.pembelian.index')
                ->with('error', 'Hanya pembelian berstatus dipesan yang bisa dihapus.');
        }

        DB::transaction(function () use ($pembelian) {
            $pembelian->detailPembelian()->delete();
            $pembelian->delete();
        });

        return redirect()->route('admin.pembelian.index')
            ->with('success', 'Pembelian berhasil dihapus.');
    }
}
