<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        $statuses = [
            'menunggu',
            'dikemas',
            'dikirim',
            'diterima',
            'gagal',
        ];

        $query = Pengiriman::with(['pesanan.user', 'ekspedisi']);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('id_pengiriman', $search)
                    ->orWhere('no_resi', 'like', "%{$search}%")
                    ->orWhereHas('pesanan.user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if (in_array($request->status, $statuses, true)) {
            $query->where('status_pengiriman', $request->status);
        }

        $pengiriman = $query
            ->orderByDesc('id_pengiriman')
            ->paginate(10)
            ->withQueryString();

        $totalPengiriman = Pengiriman::count();
        $totalMenunggu = Pengiriman::where('status_pengiriman', 'menunggu')->count();
        $totalDikirim = Pengiriman::where('status_pengiriman', 'dikirim')->count();
        $totalDiterima = Pengiriman::where('status_pengiriman', 'diterima')->count();

        return view('admin.pengiriman.index', compact(
            'pengiriman',
            'statuses',
            'totalPengiriman',
            'totalMenunggu',
            'totalDikirim',
            'totalDiterima'
        ));
    }

    public function show(string $id)
    {
        $pengiriman = Pengiriman::with([
            'pesanan.user',
            'pesanan.detailPesanan.produk',
            'ekspedisi',
        ])->findOrFail($id);

        return view('admin.pengiriman.show', compact('pengiriman'));
    }

   
public function updateStatus(Request $request, string $id)
{
    $validated = $request->validate([
        'status_pengiriman' => [
            'required',
            'in:menunggu,dikemas,dikirim,diterima,gagal',
        ],
        'no_resi' => ['nullable', 'string', 'max:100'],
    ]);

    $pengiriman = Pengiriman::findOrFail($id);

    $statusBaru = $validated['status_pengiriman'];
    $statusLama = $pengiriman->status_pengiriman;

    $data = [
        'status_pengiriman' => $statusBaru,
        'no_resi' => $validated['no_resi'] ?? null,
    ];

    // Catat waktu pertama kali pengiriman berstatus dikirim.
    if (
        $statusBaru === 'dikirim' &&
        $statusLama !== 'dikirim' &&
        !$pengiriman->tanggal_pengiriman
    ) {
        $data['tanggal_pengiriman'] = now();
    }

    // Catat waktu pertama kali pesanan berstatus diterima.
    if (
        $statusBaru === 'diterima' &&
        $statusLama !== 'diterima' &&
        !$pengiriman->tanggal_diterima
    ) {
        $data['tanggal_diterima'] = now();

        // Jika tanggal pengiriman belum tercatat,
        // isi juga agar urutan waktunya tetap masuk akal.
        if (!$pengiriman->tanggal_pengiriman) {
            $data['tanggal_pengiriman'] = now();
        }
    }

    $pengiriman->update($data);

    return redirect()
        ->route('admin.pengiriman.show', $pengiriman->id_pengiriman)
        ->with('success', 'Data pengiriman berhasil diperbarui.');
}

}
