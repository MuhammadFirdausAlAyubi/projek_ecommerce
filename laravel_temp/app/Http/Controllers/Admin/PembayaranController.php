<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['pesanan.user', 'bank']);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('id_pembayaran', $search)
                    ->orWhereHas('pesanan.user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $statuses = [
            'menunggu',
            'berhasil',
            'gagal',
            'dikembalikan',
        ];

        if (in_array($request->status, $statuses, true)) {
            $query->where(
                'status_pembayaran',
                $request->status
            );
        }

        $pembayaran = $query
            ->orderByDesc('id_pembayaran')
            ->paginate(10)
            ->withQueryString();

        $totalPembayaran = Pembayaran::count();

        $totalMenunggu = Pembayaran::where(
            'status_pembayaran',
            'menunggu'
        )->count();

        $totalBerhasil = Pembayaran::where(
            'status_pembayaran',
            'berhasil'
        )->count();

        $totalGagal = Pembayaran::where(
            'status_pembayaran',
            'gagal'
        )->count();

        return view('admin.pembayaran.index', compact(
            'pembayaran',
            'statuses',
            'totalPembayaran',
            'totalMenunggu',
            'totalBerhasil',
            'totalGagal'
        ));
    }

    public function show(string $id)
    {
        $pembayaran = Pembayaran::with([
            'pesanan.user',
            'bank',
        ])->findOrFail($id);

        return view(
            'admin.pembayaran.show',
            compact('pembayaran')
        );
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status_pembayaran' => [
                'required',
                'in:menunggu,berhasil,gagal,dikembalikan',
            ],
        ]);

        DB::transaction(function () use ($validated, $id) {
            $pembayaran = Pembayaran::with('pesanan')
                ->where('id_pembayaran', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $statusPembayaran = $validated['status_pembayaran'];

            $pembayaran->update([
                'status_pembayaran' => $statusPembayaran,
            ]);

            $pesanan = $pembayaran->pesanan;

            if (
                $pesanan &&
                $statusPembayaran === 'berhasil' &&
                $pesanan->status_pesanan === 'menunggu_pembayaran'
            ) {
                $pesanan->update([
                    'status_pesanan' => 'dibayar',
                ]);
            }
        });

        return redirect()
            ->route('admin.pembayaran.show', $id)
            ->with(
                'success',
                'Status pembayaran berhasil diperbarui.'
            );
    }
}
