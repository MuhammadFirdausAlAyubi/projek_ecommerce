@extends('admin.layouts.app')

@section('title', 'Pesanan')
@section('breadcrumb', 'Pesanan')

@push('styles')
<style>
    .pesanan-page {
        color: #182230;
    }

    .pesanan-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }

    .pesanan-heading h2 {
        margin: 0 0 7px;
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.6px;
        color: #101828;
    }

    .pesanan-heading p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .pesanan-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .pesanan-stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        min-width: 0;
        padding: 20px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        box-shadow: 0 3px 12px #10182805;
    }

    .pesanan-stat-label {
        color: #788397;
        font-size: 12px;
        font-weight: 600;
    }

    .pesanan-stat-value {
        margin-top: 8px;
        color: #101828;
        font-size: 27px;
        font-weight: 800;
    }

    .pesanan-stat-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 18px;
    }

    .stat-blue {
        color: #246bfd;
        background: #edf3ff;
    }

    .stat-orange {
        color: #d97706;
        background: #fff5e5;
    }

    .stat-purple {
        color: #7655d9;
        background: #f2edff;
    }

    .stat-green {
        color: #159765;
        background: #e8f8f0;
    }

    .pesanan-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        box-shadow: 0 3px 12px #10182805;
    }

    .pesanan-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 22px 24px;
        border-bottom: 1px solid #e8edf4;
    }

    .pesanan-panel-title {
        margin: 0;
        color: #101828;
        font-size: 16px;
        font-weight: 800;
    }

    .pesanan-panel-subtitle {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .pesanan-alert {
        margin: 16px 24px 0;
        padding: 12px 15px;
        border-radius: 9px;
        font-size: 13px;
    }

    .pesanan-alert-success {
        color: #13865c;
        background: #e8f8f0;
        border: 1px solid #c9efdc;
    }

    .pesanan-alert-danger {
        color: #c03939;
        background: #fff0f0;
        border: 1px solid #ffdada;
    }

    .pesanan-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px 24px;
    }

    .pesanan-input,
    .pesanan-select {
        height: 42px;
        min-width: 0;
        padding: 0 13px;
        color: #182230;
        background: #fff;
        border: 1px solid #e1e7f0;
        border-radius: 9px;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: .2s;
    }

    .pesanan-input {
        flex: 1 1 250px;
    }

    .pesanan-select {
        flex: 0 1 210px;
    }

    .pesanan-input:focus,
    .pesanan-select:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd15;
    }

    .pesanan-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        padding: 0 14px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: .2s;
    }

    .pesanan-btn-primary {
        color: #fff;
        background: #246bfd;
    }

    .pesanan-btn-primary:hover {
        color: #fff;
        background: #1558e8;
    }

    .pesanan-btn-light {
        color: #526075;
        background: #fff;
        border-color: #e1e7f0;
    }

    .pesanan-btn-light:hover {
        color: #182230;
        background: #f5f7fb;
    }

    .pesanan-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .pesanan-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .pesanan-table thead th {
        padding: 14px 18px;
        color: #788397;
        background: #f8faff;
        border-top: 1px solid #e8edf4;
        border-bottom: 1px solid #e8edf4;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .45px;
        font-size: 11px;
        font-weight: 800;
    }

    .pesanan-table tbody td {
        padding: 16px 18px;
        border-bottom: 1px solid #edf0f5;
        color: #344054;
        font-size: 13px;
        vertical-align: middle;
    }

    .pesanan-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .pesanan-table tbody tr:hover {
        background: #fafcff;
    }

    .pesanan-id {
        color: #246bfd;
        font-weight: 800;
    }

    .pesanan-customer {
        color: #182230;
        font-weight: 700;
    }

    .pesanan-email,
    .pesanan-date {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .pesanan-price {
        color: #101828;
        font-weight: 800;
    }

    .pesanan-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .pesanan-status::before {
        content: '';
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
        background: currentColor;
    }

    .status-menunggu_pembayaran {
        color: #b77912;
        background: #fff5d9;
    }

    .status-dibayar {
        color: #246bfd;
        background: #edf3ff;
    }

    .status-diproses {
        color: #7655d9;
        background: #f2edff;
    }

    .status-dikirim {
        color: #087e8b;
        background: #e5f8fa;
    }

    .status-selesai {
        color: #13865c;
        background: #e8f8f0;
    }

    .status-dibatalkan {
        color: #d04444;
        background: #fff0f0;
    }

    .pesanan-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        color: #246bfd;
        background: #edf3ff;
        border: 1px solid #dce8ff;
        border-radius: 8px;
        text-decoration: none;
        transition: .2s;
    }

    .pesanan-action:hover {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    .pesanan-empty {
        padding: 55px 20px !important;
        color: #788397 !important;
        text-align: center;
    }

    .pesanan-empty i {
        display: block;
        margin-bottom: 13px;
        color: #b7c2d3;
        font-size: 30px;
    }

    .pesanan-empty strong {
        display: block;
        color: #344054;
        font-size: 14px;
    }

    .pesanan-empty div {
        margin-top: 6px;
        font-size: 12px;
    }

    .pesanan-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px 24px;
        border-top: 1px solid #e8edf4;
    }

    .pesanan-pagination-info {
        color: #788397;
        font-size: 12px;
    }

    .pesanan-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .pesanan-pagination nav > div {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .pesanan-pagination nav a,
    .pesanan-pagination nav span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        min-height: 34px;
        padding: 6px 10px;
        color: #526075;
        border: 1px solid #e8edf4;
        border-radius: 8px;
        font-size: 12px;
        text-decoration: none;
    }

    .pesanan-pagination nav [aria-current="page"] span {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    @media (max-width: 1100px) {
        .pesanan-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .pesanan-heading h2 {
            font-size: 21px;
        }

        .pesanan-stats {
            gap: 10px;
        }

        .pesanan-stat {
            padding: 14px;
        }

        .pesanan-stat-value {
            font-size: 23px;
        }

        .pesanan-stat-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .pesanan-panel-header,
        .pesanan-filters {
            padding: 16px;
        }

        .pesanan-input,
        .pesanan-select {
            flex: 1 1 100%;
            width: 100%;
        }

        .pesanan-filters .pesanan-btn {
            flex: 1;
        }

        .pesanan-alert {
            margin-right: 16px;
            margin-left: 16px;
        }

        .pesanan-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="pesanan-page">

    <div class="pesanan-heading">
        <div>
            <h2>Pesanan</h2>
            <p>Pantau dan kelola transaksi pelanggan ELECTROMART.</p>
        </div>
    </div>

    <div class="pesanan-stats">
        <div class="pesanan-stat">
            <div>
                <div class="pesanan-stat-label">Total Pesanan</div>
                <div class="pesanan-stat-value">{{ $totalPesanan }}</div>
            </div>
            <div class="pesanan-stat-icon stat-blue">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
        </div>

        <div class="pesanan-stat">
            <div>
                <div class="pesanan-stat-label">Menunggu Pembayaran</div>
                <div class="pesanan-stat-value">{{ $totalMenunggu }}</div>
            </div>
            <div class="pesanan-stat-icon stat-orange">
                <i class="fa-regular fa-clock"></i>
            </div>
        </div>

        <div class="pesanan-stat">
            <div>
                <div class="pesanan-stat-label">Sedang Diproses</div>
                <div class="pesanan-stat-value">{{ $totalDiproses }}</div>
            </div>
            <div class="pesanan-stat-icon stat-purple">
                <i class="fa-solid fa-box"></i>
            </div>
        </div>

        <div class="pesanan-stat">
            <div>
                <div class="pesanan-stat-label">Pesanan Selesai</div>
                <div class="pesanan-stat-value">{{ $totalSelesai }}</div>
            </div>
            <div class="pesanan-stat-icon stat-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>

    <div class="pesanan-panel">
        <div class="pesanan-panel-header">
            <div>
                <h3 class="pesanan-panel-title">Daftar Pesanan</h3>
                <div class="pesanan-panel-subtitle">
                    Informasi transaksi dan status pesanan pelanggan.
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="pesanan-alert pesanan-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="pesanan-alert pesanan-alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.pesanan.index') }}" method="GET" class="pesanan-filters">
            <input
                type="text"
                name="search"
                class="pesanan-input"
                placeholder="Cari ID pesanan, nama, atau email..."
                value="{{ request('search') }}"
            >

            <select name="status" class="pesanan-select">
                <option value="">Semua Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="pesanan-btn pesanan-btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.pesanan.index') }}" class="pesanan-btn pesanan-btn-light">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>

        <div class="pesanan-table-wrap">
            <table class="pesanan-table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Jumlah Item</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pesanan as $item)
                        <tr>
                            <td>
                                <span class="pesanan-id">#{{ $item->id_pesanan }}</span>
                            </td>

                            <td>
                                <div class="pesanan-customer">
                                    {{ $item->user->nama ?? 'Pelanggan tidak ditemukan' }}
                                </div>
                                <div class="pesanan-email">
                                    {{ $item->user->email ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $item->tanggal_pesanan ? $item->tanggal_pesanan->format('d M Y') : '-' }}
                                <div class="pesanan-date">
                                    {{ $item->tanggal_pesanan ? $item->tanggal_pesanan->format('H:i') : '' }}
                                </div>
                            </td>

                            <td>{{ $item->detail_pesanan_count ?? 0 }} item</td>

                            <td>
                                <span class="pesanan-price">
                                    Rp {{ number_format((float) $item->total_harga, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="pesanan-status status-{{ $item->status_pesanan }}">
                                    {{ ucwords(str_replace('_', ' ', $item->status_pesanan)) }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.pesanan.show', $item->id_pesanan) }}"
                                    class="pesanan-action"
                                    title="Detail Pesanan"
                                    aria-label="Detail pesanan {{ $item->id_pesanan }}"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="pesanan-empty">
                                <i class="fa-solid fa-inbox"></i>
                                <strong>Belum ada pesanan</strong>
                                <div>Pesanan yang cocok dengan pencarian akan muncul di sini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pesanan-pagination">
            <span class="pesanan-pagination-info">
                Menampilkan {{ $pesanan->firstItem() ?? 0 }}–{{ $pesanan->lastItem() ?? 0 }}
                dari {{ $pesanan->total() }} pesanan
            </span>

            {{ $pesanan->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
