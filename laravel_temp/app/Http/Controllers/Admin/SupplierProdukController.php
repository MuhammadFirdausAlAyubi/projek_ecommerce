<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\SupplierProduk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = SupplierProduk::with(['supplier', 'produk']);

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->whereHas('supplier', function ($supplier) use ($cari) {
                    $supplier->where('nama_supplier', 'like', "%{$cari}%");
                })->orWhereHas('produk', function ($produk) use ($cari) {
                    $produk->where('nama_produk', 'like', "%{$cari}%");
                })->orWhere('id_supplier_produk', 'like', "%{$cari}%");
            });
        }

        $supplierProduk = $query
            ->orderByDesc('id_supplier_produk')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.supplier_produk.index',
            compact('supplierProduk')
        );
    }

    public function create()
    {
        $supplier = Supplier::orderBy('nama_supplier')->get();
        $produk = Produk::orderBy('nama_produk')->get();

        return view(
            'admin.supplier_produk.create',
            compact('supplier', 'produk')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_supplier' => [
                'required',
                'integer',
                'exists:supplier,id_supplier',
            ],
            'id_produk' => [
                'required',
                'integer',
                'exists:produk,id_produk',
                Rule::unique('supplier_produk', 'id_produk')
                    ->where('id_supplier', $request->id_supplier),
            ],
            'harga_beli' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],
            'waktu_penyediaan' => [
                'required',
                'integer',
                'min:0',
            ],
        ], [
            'id_supplier.required' => 'Supplier wajib dipilih.',
            'id_supplier.exists' => 'Supplier yang dipilih tidak ditemukan.',
            'id_produk.required' => 'Produk wajib dipilih.',
            'id_produk.exists' => 'Produk yang dipilih tidak ditemukan.',
            'id_produk.unique' => 'Produk tersebut sudah terdaftar untuk supplier ini.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'harga_beli.min' => 'Harga beli tidak boleh negatif.',
            'waktu_penyediaan.required' => 'Waktu penyediaan wajib diisi.',
            'waktu_penyediaan.integer' => 'Waktu penyediaan harus berupa jumlah hari.',
            'waktu_penyediaan.min' => 'Waktu penyediaan tidak boleh negatif.',
        ]);

        SupplierProduk::create($validated);

        return redirect()
            ->route('admin.supplier-produk.index')
            ->with('success', 'Supplier produk berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $supplierProduk = SupplierProduk::findOrFail($id);
        $supplier = Supplier::orderBy('nama_supplier')->get();
        $produk = Produk::orderBy('nama_produk')->get();

        return view(
            'admin.supplier_produk.edit',
            compact('supplierProduk', 'supplier', 'produk')
        );
    }

    public function update(Request $request, string $id)
    {
        $supplierProduk = SupplierProduk::findOrFail($id);

        $validated = $request->validate([
            'id_supplier' => [
                'required',
                'integer',
                'exists:supplier,id_supplier',
            ],
            'id_produk' => [
                'required',
                'integer',
                'exists:produk,id_produk',
                Rule::unique('supplier_produk', 'id_produk')
                    ->where('id_supplier', $request->id_supplier)
                    ->ignore($supplierProduk->id_supplier_produk, 'id_supplier_produk'),
            ],
            'harga_beli' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],
            'waktu_penyediaan' => [
                'required',
                'integer',
                'min:0',
            ],
        ], [
            'id_supplier.required' => 'Supplier wajib dipilih.',
            'id_supplier.exists' => 'Supplier yang dipilih tidak ditemukan.',
            'id_produk.required' => 'Produk wajib dipilih.',
            'id_produk.exists' => 'Produk yang dipilih tidak ditemukan.',
            'id_produk.unique' => 'Produk tersebut sudah terdaftar untuk supplier ini.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'harga_beli.min' => 'Harga beli tidak boleh negatif.',
            'waktu_penyediaan.required' => 'Waktu penyediaan wajib diisi.',
            'waktu_penyediaan.integer' => 'Waktu penyediaan harus berupa jumlah hari.',
            'waktu_penyediaan.min' => 'Waktu penyediaan tidak boleh negatif.',
        ]);

        $supplierProduk->update($validated);

        return redirect()
            ->route('admin.supplier-produk.index')
            ->with('success', 'Data supplier produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $supplierProduk = SupplierProduk::findOrFail($id);

        $supplierProduk->delete();

        return redirect()
            ->route('admin.supplier-produk.index')
            ->with('success', 'Data supplier produk berhasil dihapus.');
    }
}
