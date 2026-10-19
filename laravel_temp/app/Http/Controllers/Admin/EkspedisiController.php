<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekspedisi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EkspedisiController extends Controller
{
    public function index(Request $request)
    {
        $query = Ekspedisi::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where('nama_ekspedisi', 'like', "%{$search}%");
        }

        if (in_array($request->status, ['aktif', 'nonaktif'], true)) {
            $query->where('status_ekspedisi', $request->status);
        }

        $ekspedisi = $query
            ->orderBy('nama_ekspedisi')
            ->paginate(10)
            ->withQueryString();

        $totalEkspedisi = Ekspedisi::count();
        $totalAktif = Ekspedisi::where('status_ekspedisi', 'aktif')->count();
        $totalNonaktif = Ekspedisi::where('status_ekspedisi', 'nonaktif')->count();

        return view('admin.ekspedisi.index', compact(
            'ekspedisi',
            'totalEkspedisi',
            'totalAktif',
            'totalNonaktif'
        ));
    }

    public function create()
    {
        return view('admin.ekspedisi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ekspedisi' => [
                'required',
                'string',
                'max:50',
                'unique:ekspedisi,nama_ekspedisi',
            ],
            'status_ekspedisi' => [
                'required',
                Rule::in(['aktif', 'nonaktif']),
            ],
        ]);

        Ekspedisi::create($validated);

        return redirect()
            ->route('admin.ekspedisi.index')
            ->with('success', 'Ekspedisi berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $ekspedisi = Ekspedisi::findOrFail($id);

        return view('admin.ekspedisi.edit', compact('ekspedisi'));
    }

    public function update(Request $request, string $id)
    {
        $ekspedisi = Ekspedisi::findOrFail($id);

        $validated = $request->validate([
            'nama_ekspedisi' => [
                'required',
                'string',
                'max:50',
                Rule::unique('ekspedisi', 'nama_ekspedisi')
                    ->ignore($ekspedisi->id_ekspedisi, 'id_ekspedisi'),
            ],
            'status_ekspedisi' => [
                'required',
                Rule::in(['aktif', 'nonaktif']),
            ],
        ]);

        $ekspedisi->update($validated);

        return redirect()
            ->route('admin.ekspedisi.index')
            ->with('success', 'Data ekspedisi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $ekspedisi = Ekspedisi::findOrFail($id);

        $masihDigunakan = DB::table('pengiriman')
            ->where('id_ekspedisi', $ekspedisi->id_ekspedisi)
            ->exists();

        if ($masihDigunakan) {
            return redirect()
                ->route('admin.ekspedisi.index')
                ->with('error', 'Ekspedisi tidak dapat dihapus karena sudah digunakan pada data pengiriman. Ubah statusnya menjadi nonaktif jika tidak digunakan lagi.');
        }

        $ekspedisi->delete();

        return redirect()
            ->route('admin.ekspedisi.index')
            ->with('success', 'Ekspedisi berhasil dihapus.');
    }
}
