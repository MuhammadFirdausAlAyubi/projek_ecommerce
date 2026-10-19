<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();

        if ($request->filled('cari')) {
            $cari = trim($request->cari);

            $query->where(function ($q) use ($cari) {
                $q->where('nama_brand', 'like', "%{$cari}%")
                  ->orWhere('id_brand', $cari);
            });
        }

        $brands = $query->withCount('produk')
            ->orderBy('nama_brand')
            ->paginate(10)
            ->withQueryString();

        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_brand' => [
                'required',
                'string',
                'max:100',
                Rule::unique('brand', 'nama_brand'),
            ],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'nama_brand.required' => 'Nama brand wajib diisi.',
            'nama_brand.unique' => 'Nama brand sudah terdaftar.',
            'nama_brand.max' => 'Nama brand maksimal 100 karakter.',
        ]);

        Brand::create($validated);

        return redirect()
            ->route('admin.brand.index')
            ->with('success', 'Brand berhasil ditambahkan.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'nama_brand' => [
                'required',
                'string',
                'max:100',
                Rule::unique('brand', 'nama_brand')
                    ->ignore($brand->id_brand, 'id_brand'),
            ],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'nama_brand.required' => 'Nama brand wajib diisi.',
            'nama_brand.unique' => 'Nama brand sudah terdaftar.',
            'nama_brand.max' => 'Nama brand maksimal 100 karakter.',
        ]);

        $brand->update($validated);

        return redirect()
            ->route('admin.brand.index')
            ->with('success', 'Brand berhasil diperbarui.');
    }

    public function destroy(Brand $brand)
    {
        $digunakan = Produk::where('id_brand', $brand->id_brand)->exists();

        if ($digunakan) {
            return redirect()
                ->route('admin.brand.index')
                ->with('error', 'Brand tidak bisa dihapus karena masih digunakan oleh produk.');
        }

        $brand->delete();

        return redirect()
            ->route('admin.brand.index')
            ->with('success', 'Brand berhasil dihapus.');
    }
}
