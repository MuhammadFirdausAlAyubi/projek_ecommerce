<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with([
            'kategori',
            'brand',
            'stok',
            'fotoProduk',
            'varianProduk',
        ]);

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('nama_produk', 'like', "%{$cari}%")
                    ->orWhere('id_produk', $cari);
            });
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $produks = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.produk.index', compact('produks', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $brands = Brand::orderBy('nama_brand')->get();

        return view('admin.produk.create', compact('kategoris', 'brands'));
    }

    private function rulesProduk(): array
    {
        return [
            'id_kategori' => ['required', 'integer', 'exists:kategori,id_kategori'],
            'id_brand' => ['required', 'integer', 'exists:brand,id_brand'],
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'spesifikasi' => ['nullable', 'string'],
            'harga_jual' => ['required', 'numeric', 'min:0'],
            'gambar' => ['nullable', 'array', 'max:4'],
            'gambar.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status_produk' => ['required', 'string', 'max:50'],
            'jumlah_stok' => ['required', 'integer', 'min:0'],
            'stok_minimum' => ['required', 'integer', 'min:0'],

            'varian' => ['nullable', 'array', 'max:30'],
            'varian.*.id_varian' => ['nullable', 'integer'],
            'varian.*.nama_varian' => ['nullable', 'string', 'max:255'],
            'varian.*.warna' => ['nullable', 'string', 'max:100'],
            'varian.*.kapasitas' => ['nullable', 'string', 'max:100'],
            'varian.*.harga' => ['nullable', 'numeric', 'min:0'],
            'varian.*.jumlah_stok' => ['nullable', 'integer', 'min:0'],
            'varian.*.status_varian' => ['nullable', 'boolean'],
            'varian.*.hapus' => ['nullable', 'boolean'],
            'varian.*.gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    private function simpanVarian(
        Request $request,
        Produk $produk,
        bool $modeEdit = false
    ): array {
        $pathsBaru = [];
        $varianInput = $request->input('varian', []);

        foreach ($varianInput as $index => $data) {
            $idVarian = $data['id_varian'] ?? null;

            if ($modeEdit && $idVarian) {
                $varian = VarianProduk::where('id_produk', $produk->id_produk)
                    ->findOrFail($idVarian);
            } else {
                $varian = null;
            }

            if (!empty($data['hapus']) && $varian) {
                if ($varian->gambar) {
                    $pathsBaru['hapus'][] = $varian->gambar;
                }

                $varian->delete();
                continue;
            }

            $nama = trim($data['nama_varian'] ?? '');
            $warna = trim($data['warna'] ?? '');
            $kapasitas = trim($data['kapasitas'] ?? '');
            $harga = $data['harga'] ?? null;
            $stok = $data['jumlah_stok'] ?? null;

            // Baris varian kosong dilewati.
            if ($nama === '' && $warna === '' && $kapasitas === ''
                && ($harga === null || $harga === '')
                && ($stok === null || $stok === '')
                && !$request->hasFile("varian.$index.gambar")) {
                continue;
            }

            if ($nama === '') {
                $nama = trim(implode(' ', array_filter([$warna, $kapasitas])));
            }

            if ($nama === '' || $harga === null || $harga === ''
                || $stok === null || $stok === '') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "varian.$index.nama_varian" =>
                        'Isi nama, harga, dan stok untuk setiap varian yang digunakan.',
                ]);
            }

            $gambar = $varian?->gambar;

            if ($request->hasFile("varian.$index.gambar")) {
                $gambarBaru = $request->file("varian.$index.gambar")
                    ->store('produk/varian', 'public');

                $pathsBaru['baru'][] = $gambarBaru;

                if ($gambar) {
                    $pathsBaru['hapus'][] = $gambar;
                }

                $gambar = $gambarBaru;
            }

            $payload = [
                'id_produk' => $produk->id_produk,
                'nama_varian' => $nama,
                'warna' => $warna !== '' ? $warna : null,
                'kapasitas' => $kapasitas !== '' ? $kapasitas : null,
                'harga' => $harga,
                'jumlah_stok' => $stok,
                'gambar' => $gambar,
                'status_varian' => isset($data['status_varian'])
                    ? (bool) $data['status_varian']
                    : true,
            ];

            if ($varian) {
                $varian->update($payload);
            } else {
                VarianProduk::create($payload);
            }
        }

        return $pathsBaru;
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rulesProduk());

        $pathsFoto = [];
        $pathsVarian = [];

        try {
            foreach ($request->file('gambar', []) as $file) {
                $pathsFoto[] = $file->store('produk', 'public');
            }

            DB::transaction(function () use (
                $validated,
                $pathsFoto,
                $request,
                &$pathsVarian
            ) {
                $produk = Produk::create([
                    'id_kategori' => $validated['id_kategori'],
                    'id_brand' => $validated['id_brand'],
                    'nama_produk' => $validated['nama_produk'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'spesifikasi' => $validated['spesifikasi'] ?? null,
                    'harga_jual' => $validated['harga_jual'],
                    'gambar' => $pathsFoto[0] ?? null,
                    'status_produk' => $validated['status_produk'],
                    'created_at' => now(),
                ]);

                foreach ($pathsFoto as $index => $path) {
                    $produk->fotoProduk()->create([
                        'gambar' => $path,
                        'urutan' => $index + 1,
                    ]);
                }

                Stok::create([
                    'id_produk' => $produk->id_produk,
                    'jumlah_stok' => $validated['jumlah_stok'],
                    'stok_minimum' => $validated['stok_minimum'],
                    'update_at' => now(),
                ]);

                $pathsVarian = $this->simpanVarian($request, $produk);
            });
        } catch (\Throwable $e) {
            foreach ($pathsFoto as $path) {
                Storage::disk('public')->delete($path);
            }

            foreach (($pathsVarian['baru'] ?? []) as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $produk->load(['stok', 'fotoProduk', 'varianProduk']);

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $brands = Brand::orderBy('nama_brand')->get();

        return view('admin.produk.edit', compact('produk', 'kategoris', 'brands'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate($this->rulesProduk());

        $pathsFotoBaru = [];
        $pathsFotoLama = [];
        $pathsVarian = [];

        try {
            foreach ($request->file('gambar', []) as $file) {
                $pathsFotoBaru[] = $file->store('produk', 'public');
            }

            DB::transaction(function () use (
                $validated,
                $produk,
                $pathsFotoBaru,
                $request,
                &$pathsFotoLama,
                &$pathsVarian
            ) {
                $produk->load('fotoProduk');

                if ($pathsFotoBaru) {
                    $pathsFotoLama = $produk->fotoProduk->pluck('gambar')->all();

                    if ($produk->gambar) {
                        $pathsFotoLama[] = $produk->gambar;
                    }

                    $produk->fotoProduk()->delete();
                }

                $produk->update([
                    'id_kategori' => $validated['id_kategori'],
                    'id_brand' => $validated['id_brand'],
                    'nama_produk' => $validated['nama_produk'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'spesifikasi' => $validated['spesifikasi'] ?? null,
                    'harga_jual' => $validated['harga_jual'],
                    'status_produk' => $validated['status_produk'],
                    'gambar' => $pathsFotoBaru[0] ?? $produk->gambar,
                ]);

                foreach ($pathsFotoBaru as $index => $path) {
                    $produk->fotoProduk()->create([
                        'gambar' => $path,
                        'urutan' => $index + 1,
                    ]);
                }

                Stok::updateOrCreate(
                    ['id_produk' => $produk->id_produk],
                    [
                        'jumlah_stok' => $validated['jumlah_stok'],
                        'stok_minimum' => $validated['stok_minimum'],
                        'update_at' => now(),
                    ]
                );

                $pathsVarian = $this->simpanVarian($request, $produk, true);
            });
        } catch (\Throwable $e) {
            foreach ($pathsFotoBaru as $path) {
                Storage::disk('public')->delete($path);
            }

            foreach (($pathsVarian['baru'] ?? []) as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        foreach (array_unique($pathsFotoLama) as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }

        foreach (array_unique($pathsVarian['hapus'] ?? []) as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->load(['fotoProduk', 'varianProduk']);

        if (
            $produk->detailKeranjang()->exists()
            || $produk->detailPesanan()->exists()
            || $produk->detailPembelian()->exists()
        ) {
            return back()->with(
                'error',
                'Produk memiliki riwayat transaksi. Ubah status produk jika tidak ingin menjualnya lagi.'
            );
        }

        $paths = $produk->fotoProduk->pluck('gambar')->all();

        if ($produk->gambar) {
            $paths[] = $produk->gambar;
        }

        $paths = array_merge(
            $paths,
            $produk->varianProduk->pluck('gambar')->filter()->all()
        );

        DB::transaction(function () use ($produk) {
            Stok::where('id_produk', $produk->id_produk)->delete();
            $produk->varianProduk()->delete();
            $produk->delete();
        });

        foreach (array_unique($paths) as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }

        return redirect()
            ->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
