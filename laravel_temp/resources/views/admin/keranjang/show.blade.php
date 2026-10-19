@extends('admin.layouts.app')

@section('title', 'Detail Keranjang')
@section('breadcrumb', 'Detail Keranjang')

@section('content')
<style>
.kpd-page{color:#263247}
.kpd-card{background:#fff;border:1px solid #e8edf4;border-radius:14px;padding:22px;margin-bottom:18px}
.kpd-title{margin:0;font-size:23px;font-weight:750}
.kpd-muted{font-size:12px;color:#8490a1;margin-top:6px}
.kpd-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;margin-top:22px}
.kpd-label{font-size:12px;color:#8490a1;margin-bottom:6px}
.kpd-value{font-size:14px;font-weight:600;overflow-wrap:anywhere}
.kpd-badge{display:inline-block;padding:6px 10px;border-radius:20px;font-size:11px;font-weight:700}
.kpd-table-wrap{overflow-x:auto}
.kpd-table{width:100%;border-collapse:collapse;white-space:nowrap}
.kpd-table th{background:#f8fafc;color:#64748b;text-align:left;padding:13px 11px;font-size:11px;text-transform:uppercase}
.kpd-table td{padding:14px 11px;border-bottom:1px solid #edf1f6;font-size:13px}
.kpd-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 14px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:650}
.kpd-back{background:#eef2f7;color:#475569}
.kpd-total{display:flex;justify-content:flex-end;font-size:15px;font-weight:750;margin-top:18px}
@media(max-width:600px){.kpd-grid{grid-template-columns:1fr}.kpd-card{padding:15px}}
</style>

<div class="kpd-page">
    <div class="kpd-card">
        <h2 class="kpd-title">Detail Keranjang #{{ $keranjang->id_keranjang }}</h2>
        <div class="kpd-muted">Informasi keranjang dan barang yang ditambahkan pelanggan.</div>

        <div class="kpd-grid">
            <div>
                <div class="kpd-label">Nama pelanggan</div>
                <div class="kpd-value">{{ $keranjang->user?->nama ?? 'User tidak ditemukan' }}</div>
            </div>
            <div>
                <div class="kpd-label">Email pelanggan</div>
                <div class="kpd-value">{{ $keranjang->user?->email ?? '-' }}</div>
            </div>
            <div>
                <div class="kpd-label">Tanggal dibuat</div>
                <div class="kpd-value">
                    {{ $keranjang->tanggal_dibuat ? $keranjang->tanggal_dibuat->format('d/m/Y H:i') : '-' }}
                </div>
            </div>
            <div>
                <div class="kpd-label">Status keranjang</div>
                <div class="kpd-value">
                    @if($keranjang->status_keranjang === 'aktif')
                        <span class="kpd-badge" style="background:#dcfce7;color:#15803d">Aktif</span>
                    @elseif($keranjang->status_keranjang === 'checkout')
                        <span class="kpd-badge" style="background:#dbeafe;color:#1d4ed8">Checkout</span>
                    @else
                        <span class="kpd-badge" style="background:#f1f5f9;color:#64748b">Dikosongkan</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="kpd-card">
        <h3 style="margin:0 0 18px;font-size:16px">Produk dalam Keranjang</h3>

        <div class="kpd-table-wrap">
            <table class="kpd-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>Ditambahkan</th>
                    </tr>
                </thead>
                <tbody>
                @php $total = 0; @endphp

                @forelse($keranjang->detailKeranjang as $detail)
                    @php
                        $harga = (float) ($detail->produk?->harga_jual ?? 0);
                        $subtotal = $harga * (int) $detail->jumlah;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $detail->produk?->nama_produk ?? 'Produk tidak ditemukan' }}</strong>
                            <div class="kpd-muted">ID Produk: {{ $detail->id_produk }}</div>
                        </td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            {{ $detail->tanggal_ditambahkan ? \Carbon\Carbon::parse($detail->tanggal_ditambahkan)->format('d/m/Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:35px">
                            Keranjang ini belum memiliki produk.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="kpd-total">
            Total indikatif: Rp {{ number_format($total, 0, ',', '.') }}
        </div>
        <div class="kpd-muted" style="text-align:right">
            Perkiraan berdasarkan harga produk saat ini, bukan total transaksi checkout.
        </div>
    </div>

    <a href="{{ route('admin.keranjang.index') }}" class="kpd-btn kpd-back">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Keranjang
    </a>
</div>
@endsection
