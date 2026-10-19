<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AlamatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alamat::with('user');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('nama_penerima', 'like', "%{$search}%")
                    ->orWhere('no_telp_penerima', 'like', "%{$search}%")
                    ->orWhere('provinsi', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('kode_pos', 'like', "%{$search}%")
                    ->orWhere('alamat_lengkap', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->input('utama') === '1') {
            $query->where('is_utama', 1);
        } elseif ($request->input('utama') === '0') {
            $query->where('is_utama', 0);
        }

        $alamat = $query
            ->orderByDesc('is_utama')
            ->orderByDesc('id_alamat')
            ->paginate(10)
            ->withQueryString();

        $totalAlamat = Alamat::count();
        $totalUtama = Alamat::where('is_utama', 1)->count();
        $totalPelanggan = Alamat::distinct('id_user')->count('id_user');

        return view('admin.alamat.index', compact(
            'alamat',
            'totalAlamat',
            'totalUtama',
            'totalPelanggan'
        ));
    }

    public function create()
    {
        $users = User::orderBy('nama')->get();

        return view('admin.alamat.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateAlamat($request);

        DB::transaction(function () use ($validated) {
            $isUtama = (bool) ($validated['is_utama'] ?? false);

            if ($isUtama) {
                Alamat::where('id_user', $validated['id_user'])
                    ->update(['is_utama' => 0]);
            }

            Alamat::create([
                ...$validated,
                'is_utama' => $isUtama,
            ]);
        });

        return redirect()
            ->route('admin.alamat.index')
            ->with('success', 'Alamat pelanggan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $alamat = Alamat::with('user')->findOrFail($id);

        return view('admin.alamat.show', compact('alamat'));
    }

    public function edit(string $id)
    {
        $alamat = Alamat::findOrFail($id);
        $users = User::orderBy('nama')->get();

        return view('admin.alamat.edit', compact('alamat', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $alamat = Alamat::findOrFail($id);
        $validated = $this->validateAlamat($request);

        DB::transaction(function () use ($alamat, $validated) {
            $isUtama = (bool) ($validated['is_utama'] ?? false);

            if ($isUtama) {
                Alamat::where('id_user', $validated['id_user'])
                    ->where('id_alamat', '!=', $alamat->id_alamat)
                    ->update(['is_utama' => 0]);
            }

            $alamat->update([
                ...$validated,
                'is_utama' => $isUtama,
            ]);
        });

        return redirect()
            ->route('admin.alamat.index')
            ->with('success', 'Alamat pelanggan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $alamat = Alamat::findOrFail($id);

        // Periksa tabel transaksi yang memiliki kolom id_alamat.
        // Jangan menghapus alamat jika masih dipakai transaksi.
        $referensi = [
            'pesanan' => 'id_alamat',
        ];

        foreach ($referensi as $table => $column) {
            if (
                DB::getSchemaBuilder()->hasTable($table) &&
                DB::getSchemaBuilder()->hasColumn($table, $column) &&
                DB::table($table)->where($column, $alamat->id_alamat)->exists()
            ) {
                return redirect()
                    ->route('admin.alamat.index')
                    ->with('error', 'Alamat tidak dapat dihapus karena masih digunakan oleh transaksi.');
            }
        }

        $alamat->delete();

        return redirect()
            ->route('admin.alamat.index')
            ->with('success', 'Alamat pelanggan berhasil dihapus.');
    }

    private function validateAlamat(Request $request): array
    {
        return $request->validate([
            'id_user' => [
                'required',
                'integer',
                Rule::exists('user', 'id_user'),
            ],
            'nama_penerima' => ['required', 'string', 'max:100'],
            'no_telp_penerima' => ['required', 'string', 'max:20'],
            'provinsi' => ['required', 'string', 'max:100'],
            'kota' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'kode_pos' => ['required', 'string', 'max:10'],
            'alamat_lengkap' => ['required', 'string'],
            'is_utama' => ['nullable', 'boolean'],
        ]);
    }
}
