@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')
@section('breadcrumb', 'Detail Pesanan')

@push('styles')
<style>
    .detail-page { color: #182230; }
    .detail-heading {
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 15px; margin-bottom: 25px;
    }
    .detail-heading h2 {
        font-size: 25px; font-weight: 800; color: #101828;
        margin: 0 0 6px;
    }
    .detail-heading p { margin: 0; color: #788397; font-size: 13px; }
    .detail-grid {
        display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px; margin-bottom: 20px;
    }
    .detail-panel {
        min-width: 0; background: #fff; border: 1px solid #e8edf4;
        border-radius: 15px; overflow: hidden;
        box-shadow: 0 3px 12px #10182805;
    }
    .detail-panel-header {
        padding: 19px 22px; border-bottom: 1px solid #e8edf4;
        font-size: 15px; font-weight: 800; color: #101828;
    }
    .detail-panel-header i { color: #246bfd; margin-right: 9px; }
    .detail-panel-body { padding: 22px; }
    .detail-info {
        width: 100%; border-collapse: collapse;
    }
    .detail-info th, .detail-info td {
        padding: 12px 0; border-bottom: 1px solid #edf0f5;
        font-size: 13px; text-align: left; vertical-align: top;
    }
    .detail-info tr:last-child th, .detail-info tr:last-child td { border-bottom: 0; }
    .detail-info th { width: 39%; color: #788397; font-weight: 600; padding-right: 12px; }
    .detail-info td { color: #182230; font-weight: 600; overflow-wrap: anywhere; }
    .detail-address {
        font-size: 13px; line-height: 1.9; color: #526075;
        white-space: pre-line; overflow-wrap: anywhere;
    }
    .detail-status {
        display: inline-flex; padding: 7px 11px; border-radius: 20px;
        font-size: 11px; font-weight: 800;
    }
    .detail-status.status-menunggu_pembayaran { color: #b77912; background: #fff5d9; }
    .detail-status.status-dibayar { color: #246bfd; background: #edf3ff; }
    .detail-status.status-diproses { color: #7655d9; background: #f2edff; }
    .detail-status.status-dikirim { color: #087e8b; background: #e5f8fa; }
    .detail-status.status-selesai { color: #13865c; background: #e8f8f0; }
    .detail-status.status-dibatalkan { color: #d04444; background: #fff0f0; }
    .detail-table-wrap { overflow-x: auto; }
    .detail-table { width: 100%; border-collapse: collapse; white-space: nowrap; }
    .detail-table th {
        padding: 14px 20px; background: #f8faff; color: #788397;
        font-size: 11px; text-align: left; text-transform: uppercase;
        letter-spacing: .5px; border-bottom: 1px solid #e8edf4;
    }
    .detail-table td {
        padding: 17px 20px; font-size: 13px;
        border-bottom: 1px solid #edf0f5;
    }
    .detail-table tbody tr:last-child td { border-bottom: 0; }
    .detail-table tfoot th {
        background: #f8faff; padding: 17px 20px;
        border-top: 1px solid #e8edf4; font-size: 13px;
    }
    .detail-product { font-weight: 700; color: #182230; }
    .detail-muted { color: #788397; font-size: 12px; margin-top: 5px; }
    .detail-price { font-weight: 800; color: #101828; }
    .detail-form { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; }
    .detail-field { flex: 1 1 240px; }
    .detail-field label {
        display: block; margin-bottom: 9px; color: #526075;
        font-size: 12px; font-weight: 700;
    }
    .detail-select {
        width: 100%; height: 43px; padding: 0 12px;
        border: 1px solid #e1e7f0; border-radius: 9px;
        color: #182230; background: white; font: inherit; font-size: 13px;
    }
    .detail-select:focus { outline: none; border-color: #246bfd; box-shadow: 0 0 0 3px #246bfd15; }
    .detail-btn {
        display: inline-flex; align-items: center; justify-content: center;
        gap: 8px; min-height: 42px; padding: 0 16px;
        border-radius: 9px; font: inherit; font-size: 13px;
        font-weight: 700; text-decoration: none; cursor: pointer;
        border: 1px solid transparent;
    }
    .detail-btn-primary { background: #246bfd; color: #fff; }
    .detail-btn-primary:hover { background: #1558e8; color: #fff; }
    .detail-btn-back { background: #fff; border-color: #e1e7f0; color: #526075; }
    .detail-btn-back:hover { background: #f5f7fb; color: #182230; }
    .detail-alert { padding: 13px 16px; margin-bottom: 20px; border-radius: 10px; font-size: 13px; }
    .detail-alert-success { color: #13865c; background: #e8f8f0; }
    .detail-alert-danger { color: #c03939; background: #fff0f0; }
    .detail-note { color: #788397; font-size: 12px; margin: 15px 0 0; line-height: 1.7; }
    @media(max-width: 760px) {
        .detail-grid { grid-template-columns: 1fr; gap: 15px; }
        .detail-heading h2 { font-size: 21px; }
        .detail-panel-header, .detail-panel-body { padding: 17px; }
        .detail-form .detail-btn { width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="detail-page">

    <div class="detail-heading">
        <div>
            <h2>Pesanan #{{ $pesanan->id_pesanan }}</h2>
            <p>Informasi transaksi, detail produk, dan pengelolaan status.</p>
        </div>

        <a href="{{ route('admin.pesanan.index') }}" class="detail-btn detail-btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="detail-alert detail-alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="detail-alert detail-alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="detail-grid">
        <section class="detail-panel">
            <div class="detail-panel-header">
                <i class="fa-solid fa-file-invoice"></i> Informasi Pesanan
            </div>
            <div class="detail-panel-body">
                <table class="detail-info">
                    <tr>
                        <th>ID Pesanan</th>
                        <td>#{{ $pesanan->id_pesanan }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pelanggan</th>
                        <td>{{ $pesanan->user->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pesanan->user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td class="detail-price">Rp {{ number_format((float) $pesanan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="detail-status status-{{ $pesanan->status_pesanan }}">
                                {{ ucwords(str_replace('_', ' ', $pesanan->status_pesanan)) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </section>

        <section class="detail-panel">
            <div class="detail-panel-header">
                <i class="fa-solid fa-location-dot"></i> Alamat Pengiriman
            </div>
            <div class="detail-panel-body">
                <div class="detail-address">{{ $pesanan->alamat_pengiriman_snapshot ?: 'Alamat pengiriman tidak tersedia.' }}</div>
            </div>
        </section>
    </div>

    <section class="detail-panel" style="margin-bottom:20px">
        <div class="detail-panel-header">
            <i class="fa-solid fa-box-open"></i> Produk yang Dipesan
        </div>

        <div class="detail-table-wrap">
            <table class="detail-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan->detailPesanan as $detail)
                        <tr>
                            <td>
                                <div class="detail-product">{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</div>
                                <div class="detail-muted">ID Produk: {{ $detail->id_produk }}</div>
                            </td>
                            <td>Rp {{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td class="detail-price">Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding:35px;text-align:center;color:#788397">
                                Belum ada detail produk pada pesanan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align:right">Total Pesanan</th>
                        <th style="color:#246bfd">
                            Rp {{ number_format((float) $pesanan->total_harga, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="detail-panel">
        <div class="detail-panel-header">
            <i class="fa-solid fa-arrows-rotate"></i> Kelola Status Pesanan
        </div>
        <div class="detail-panel-body">
            <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id_pesanan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="detail-form">
                    <div class="detail-field">
                        <label for="status_pesanan">Status Pesanan</label>
                        <select name="status_pesanan" id="status_pesanan" class="detail-select" required>
                            @foreach([
                                'menunggu_pembayaran',
                                'dibayar',
                                'diproses',
                                'dikirim',
                                'selesai',
                                'dibatalkan',
                            ] as $status)
                                <option value="{{ $status }}"
                                    @selected(old('status_pesanan', $pesanan->status_pesanan) === $status)>
                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="detail-btn detail-btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Status
                    </button>
                </div>

                <p class="detail-note">
                    Pastikan status yang dipilih sesuai dengan kondisi transaksi sebenarnya.
                    Perubahan status saat ini tidak otomatis mengubah stok, pembayaran, atau pengiriman.
                </p>
            </form>
        </div>
    </section>

</div>
@endsection
