@extends('admin.layouts.app')

@section('title', 'Detail Pembelian')
@section('breadcrumb', 'Detail Pembelian')

@section('content')
<style>
    .ps-page{color:#263247}
    .ps-heading{display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap;margin-bottom:22px}
    .ps-heading h2{margin:0;font-size:24px;font-weight:750}
    .ps-heading p{margin:6px 0 0;color:#7b8798;font-size:13px}
    .ps-card{background:#fff;border:1px solid #e8edf4;border-radius:14px;padding:22px;margin-bottom:18px}
    .ps-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:22px}
    .ps-label{font-size:12px;color:#8490a1;margin-bottom:7px}
    .ps-value{font-size:14px;font-weight:700;overflow-wrap:anywhere}
    .ps-status{display:inline-block;padding:6px 10px;border-radius:20px;font-size:11px;font-weight:700}
    .ps-ordered{background:#fff7ed;color:#c2410c}
    .ps-received{background:#dcfce7;color:#15803d}
    .ps-cancelled{background:#fee2e2;color:#b91c1c}
    .ps-table-wrap{overflow-x:auto}
    .ps-table{width:100%;border-collapse:collapse;white-space:nowrap}
    .ps-table th{padding:13px 12px;text-align:left;background:#f8fafc;color:#64748b;font-size:11px;text-transform:uppercase;letter-spacing:.4px}
    .ps-table td{padding:14px 12px;border-bottom:1px solid #edf1f6;font-size:13px}
    .ps-table tr:last-child td{border-bottom:0}
    .ps-total{display:flex;justify-content:flex-end;align-items:center;gap:28px;margin-top:20px;padding:18px;background:#f8fafc;border-radius:10px}
    .ps-total span{font-size:13px;color:#64748b}
    .ps-total strong{font-size:22px;color:#2563eb}
    .ps-btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 15px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:650;border:0;cursor:pointer}
    .ps-primary{background:#2563eb;color:#fff}
    .ps-secondary{background:#eef2f7;color:#475569}
    .ps-empty{text-align:center;padding:25px;color:#8490a1}
    @media(max-width:600px){.ps-grid{grid-template-columns:1fr}.ps-card{padding:15px}.ps-heading h2{font-size:21px}}
</style>

<div class="ps-page">
    <div class="ps-heading">
        <div>
            <h2>Detail Pembelian #PB-{{ $pembelian->id_pembelian }}</h2>
            <p>Informasi lengkap transaksi pembelian barang.</p>
        </div>

        <div style="display:flex;gap:9px;flex-wrap:wrap">
            <a href="{{ route('admin.pembelian.index') }}" class="ps-btn ps-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>

            @if($pembelian->status_pembelian === 'dipesan')
                <a href="{{ route('admin.pembelian.edit', $pembelian->id_pembelian) }}" class="ps-btn ps-primary">
                    <i class="fa-solid fa-pen"></i> Proses Pembelian
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div style="padding:13px 16px;border-radius:9px;margin-bottom:16px;background:#ecfdf3;color:#167447">
            {{ session('success') }}
        </div>
    @endif

    <div class="ps-card">
        <h3 style="font-size:15px;font-weight:750;margin:0 0 22px">Informasi Transaksi</h3>

        <div class="ps-grid">
            <div>
                <div class="ps-label">Nomor Pembelian</div>
                <div class="ps-value">#PB-{{ $pembelian->id_pembelian }}</div>
            </div>

            <div>
                <div class="ps-label">Supplier</div>
                <div class="ps-value">{{ $pembelian->supplier->nama_supplier ?? 'Supplier tidak ditemukan' }}</div>
            </div>

            <div>
                <div class="ps-label">Tanggal Pembelian</div>
                <div class="ps-value">{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d F Y, H:i') }}</div>
            </div>

            <div>
                <div class="ps-label">Status Pembelian</div>
                <div>
                    @if($pembelian->status_pembelian === 'dipesan')
                        <span class="ps-status ps-ordered">Dipesan</span>
                    @elseif($pembelian->status_pembelian === 'diterima')
                        <span class="ps-status ps-received">Diterima</span>
                    @else
                        <span class="ps-status ps-cancelled">Dibatalkan</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="ps-card">
        <h3 style="font-size:15px;font-weight:750;margin:0 0 20px">Produk yang Dibeli</h3>

        <div class="ps-table-wrap">
            <table class="ps-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Beli</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelian->detailPembelian as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</strong>
                            </td>
                            <td>{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format((float)$detail->harga_beli, 0, ',', '.') }}</td>
                            <td>
                                <strong>Rp {{ number_format((float)$detail->subtotal, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="ps-empty">Belum ada detail produk pada pembelian ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="ps-total">
            <span>Total Pembelian</span>
            <strong>Rp {{ number_format((float)$pembelian->total_pembelian, 0, ',', '.') }}</strong>
        </div>
    </div>
</div>
@endsection
