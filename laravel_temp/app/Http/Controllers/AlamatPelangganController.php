<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlamatPelangganController extends Controller
{
    /**
     * Menampilkan daftar alamat milik pelanggan yang login.
     */
    public function index()
    {
        $user = Auth::user();

        $alamat = Alamat::where('id_user', $user->id_user)
            ->orderByDesc('is_utama')
            ->orderByDesc('id_alamat')
            ->get();

        return view('customer.alamat.index', compact('alamat'));
    }

    /**
     * Menampilkan form tambah alamat beserta data provinsi.
     */
    public function create()
    {
        $provinsi = DB::table('indonesia_provinces')
            ->orderBy('name')
            ->get(['id', 'code', 'name']);

        return view('customer.alamat.create', compact('provinsi'));
    }

    /**
     * Mengambil kabupaten/kota berdasarkan kode provinsi.
     */
    public function getKota($kode_provinsi)
    {
        $kota = DB::table('indonesia_cities')
            ->where('province_code', $kode_provinsi)
            ->orderBy('name')
            ->get(['code', 'name']);

        return response()->json($kota);
    }

    /**
     * Mengambil kecamatan berdasarkan kode kabupaten/kota.
     */
    public function getKecamatan($kode_kota)
    {
        $kecamatan = DB::table('indonesia_districts')
            ->where('city_code', $kode_kota)
            ->orderBy('name')
            ->get(['code', 'name']);

        return response()->json($kecamatan);
    }

    /**
     * Menyimpan alamat baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penerima' => ['required', 'string', 'max:100'],
            'no_telp_penerima' => ['required', 'string', 'max:20'],
            'provinsi' => ['required', 'string', 'max:100'],
            'kota' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'kode_pos' => ['required', 'string', 'max:10'],
            'alamat_lengkap' => ['required', 'string', 'max:1000'],
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($validated, $user) {
            $sudahAdaAlamat = Alamat::where('id_user', $user->id_user)
                ->lockForUpdate()
                ->exists();

            Alamat::create([
                ...$validated,
                'id_user' => $user->id_user,
                'is_utama' => $sudahAdaAlamat ? 0 : 1,
            ]);
        });

        return redirect()
            ->route('alamat.index')
            ->with('success', 'Alamat pengiriman berhasil ditambahkan.');
    }

    /**
     * Menghapus alamat milik pelanggan.
     */
    public function destroy($id_alamat)
    {
        $user = Auth::user();

        $alamat = Alamat::where('id_alamat', $id_alamat)
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        // Jangan hapus alamat yang masih dipakai pesanan.
        if (
            DB::getSchemaBuilder()->hasTable('pesanan') &&
            DB::getSchemaBuilder()->hasColumn('pesanan', 'id_alamat') &&
            DB::table('pesanan')
                ->where('id_alamat', $alamat->id_alamat)
                ->exists()
        ) {
            return redirect()
                ->route('alamat.index')
                ->with(
                    'error',
                    'Alamat tidak dapat dihapus karena masih digunakan oleh pesanan.'
                );
        }

        $alamatUtama = $alamat->is_utama;

        $alamat->delete();

        // Jika alamat utama dihapus, jadikan alamat lain sebagai utama.
        if ($alamatUtama) {
            $alamatBerikutnya = Alamat::where('id_user', $user->id_user)
                ->orderByDesc('id_alamat')
                ->first();

            if ($alamatBerikutnya) {
                $alamatBerikutnya->update(['is_utama' => 1]);
            }
        }

        return redirect()
            ->route('alamat.index')
            ->with('success', 'Alamat berhasil dihapus.');
    }
}
