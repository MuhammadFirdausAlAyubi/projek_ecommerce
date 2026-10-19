<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $query = Bank::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('nama_bank', 'like', "%{$search}%")
                    ->orWhere('no_rekening', 'like', "%{$search}%")
                    ->orWhere('atas_nama', 'like', "%{$search}%");
            });
        }

        if (in_array($request->status, ['aktif', 'nonaktif'], true)) {
            $query->where('status_bank', $request->status);
        }

        $bank = $query->orderBy('nama_bank')
            ->paginate(10)
            ->withQueryString();

        $totalBank = Bank::count();
        $totalAktif = Bank::where('status_bank', 'aktif')->count();
        $totalNonaktif = Bank::where('status_bank', 'nonaktif')->count();

        return view('admin.bank.index', compact(
            'bank',
            'totalBank',
            'totalAktif',
            'totalNonaktif'
        ));
    }

    public function create()
    {
        return view('admin.bank.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bank' => ['required', 'string', 'max:100'],
            'no_rekening' => ['required', 'string', 'max:50'],
            'atas_nama' => ['required', 'string', 'max:100'],
            'status_bank' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        Bank::create($validated);

        return redirect()
            ->route('admin.bank.index')
            ->with('success', 'Data bank berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $bank = Bank::findOrFail($id);

        return view('admin.bank.edit', compact('bank'));
    }

    public function update(Request $request, string $id)
    {
        $bank = Bank::findOrFail($id);

        $validated = $request->validate([
            'nama_bank' => ['required', 'string', 'max:100'],
            'no_rekening' => ['required', 'string', 'max:50'],
            'atas_nama' => ['required', 'string', 'max:100'],
            'status_bank' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $bank->update($validated);

        return redirect()
            ->route('admin.bank.index')
            ->with('success', 'Data bank berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $bank = Bank::findOrFail($id);

        $masihDigunakan = DB::table('pembayaran')
            ->where('id_bank', $bank->id_bank)
            ->exists();

        if ($masihDigunakan) {
            return redirect()
                ->route('admin.bank.index')
                ->with('error', 'Bank tidak dapat dihapus karena sudah digunakan pada data pembayaran. Ubah status menjadi nonaktif jika tidak digunakan lagi.');
        }

        $bank->delete();

        return redirect()
            ->route('admin.bank.index')
            ->with('success', 'Data bank berhasil dihapus.');
    }
}
