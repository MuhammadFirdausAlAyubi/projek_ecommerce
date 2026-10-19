<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('nama_supplier', 'like', "%{$cari}%")
                    ->orWhere('email', 'like', "%{$cari}%")
                    ->orWhere('no_telp', 'like', "%{$cari}%")
                    ->orWhere('id_supplier', 'like', "%{$cari}%");
            });
        }

        $supplier = $query
            ->orderBy('nama_supplier')
            ->paginate(10)
            ->withQueryString();

        return view('admin.supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => ['required', 'string', 'max:100'],
            'alamat_supplier' => ['nullable', 'string'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.max' => 'Nama supplier maksimal 100 karakter.',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'nama_supplier' => ['required', 'string', 'max:100'],
            'alamat_supplier' => ['nullable', 'string'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.max' => 'Nama supplier maksimal 100 karakter.',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
        ]);

        $supplier->update($validated);

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        if (
            $supplier->pembelian()->exists() ||
            $supplier->supplierProduk()->exists()
        ) {
            return redirect()
                ->route('admin.supplier.index')
                ->with(
                    'error',
                    'Supplier tidak dapat dihapus karena sudah digunakan dalam data pembelian atau supplier produk.'
                );
        }

        $supplier->delete();

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
