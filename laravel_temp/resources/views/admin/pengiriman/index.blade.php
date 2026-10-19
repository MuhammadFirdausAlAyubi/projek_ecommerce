@extends('admin.layouts.app')

@section('title', 'Pengiriman')
@section('breadcrumb', 'Pengiriman')

@push('styles')
<style>
    .ship-page {
        color: #182230;
    }

    .ship-heading {
        margin-bottom: 24px;
    }

    .ship-heading h2 {
        margin: 0 0 7px;
        color: #101828;
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .ship-heading p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .ship-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .ship-stat {
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

    .ship-stat-label {
        color: #788397;
        font-size: 12px;
        font-weight: 600;
    }

    .ship-stat-number {
        margin-top: 8px;
        color: #101828;
        font-size: 27px;
        font-weight: 800;
    }

    .ship-stat-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 18px;
    }

    .ship-blue {
        color: #246bfd;
        background: #edf3ff;
    }

    .ship-orange {
        color: #d97706;
        background: #fff5e5;
    }

    .ship-purple {
        color: #7655d9;
        background: #f2edff;
    }

    .ship-green {
        color: #159765;
        background: #e8f8f0;
    }

    .ship-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        box-shadow: 0 3px 12px #10182805;
    }

    .ship-panel-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e8edf4;
    }

    .ship-panel-title {
        margin: 0;
        color: #101828;
        font-size: 16px;
        font-weight: 800;
    }

    .ship-panel-subtitle {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .ship-alert {
        margin: 16px 24px 0;
        padding: 12px 15px;
        border-radius: 9px;
        font-size: 13px;
    }

    .ship-alert-success {
        color: #13865c;
        background: #e8f8f0;
        border: 1px solid #c9efdc;
    }

    .ship-alert-danger {
        color: #c03939;
        background: #fff0f0;
        border: 1px solid #ffdada;
    }

    .ship-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        padding: 20px 24px;
    }

    .ship-input,
    .ship-select {
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

    .ship-input {
        flex: 1 1 250px;
    }

    .ship-select {
        flex: 0 1 200px;
    }

    .ship-input:focus,
    .ship-select:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd15;
    }

    .ship-btn {
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

    .ship-btn-primary {
        color: #fff;
        background: #246bfd;
    }

    .ship-btn-primary:hover {
        color: #fff;
        background: #1558e8;
    }

    .ship-btn-light {
        color: #526075;
        background: #fff;
        border-color: #e1e7f0;
    }

    .ship-btn-light:hover {
        color: #182230;
        background: #f5f7fb;
    }

    .ship-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .ship-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .ship-table thead th {
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

    .ship-table tbody td {
        padding: 16px 18px;
        color: #344054;
        border-bottom: 1px solid #edf0f5;
        font-size: 13px;
        vertical-align: middle;
    }

    .ship-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .ship-table tbody tr:hover {
        background: #fafcff;
    }

    .ship-id {
        color: #246bfd;
        font-weight: 800;
    }

    .ship-main {
        color: #182230;
        font-weight: 700;
    }

    .ship-muted {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .ship-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .ship-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
        background: currentColor;
    }

    .ship-status-menunggu {
        color: #b77912;
        background: #fff5d9;
    }

    .ship-status-dikemas {
        color: #7655d9;
        background: #f2edff;
    }

    .ship-status-dikirim {
        color: #246bfd;
        background: #edf3ff;
    }

    .ship-status-diterima {
        color: #13865c;
        background: #e8f8f0;
    }

    .ship-status-gagal {
        color: #d04444;
        background: #fff0f0;
    }

    .ship-action {
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

    .ship-action:hover {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    .ship-empty {
        padding: 50px 20px !important;
        color: #788397 !important;
        text-align: center;
    }

    .ship-empty i {
        display: block;
        margin-bottom: 12px;
        color: #b7c2d3;
        font-size: 30px;
    }

    .ship-empty strong {
        display: block;
        color: #344054;
        font-size: 14px;
    }

    .ship-empty div {
        margin-top: 6px;
        font-size: 12px;
    }

    .ship-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px 24px;
        border-top: 1px solid #e8edf4;
    }

    .ship-pagination-info {
        color: #788397;
        font-size: 12px;
    }

    .ship-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .ship-pagination nav > div {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .ship-pagination nav a,
    .ship-pagination nav span {
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

    .ship-pagination nav [aria-current="page"] span {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    @media (max-width: 1100px) {
        .ship-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .ship-heading h2 {
            font-size: 21px;
        }

        .ship-stats {
            gap: 10px;
        }

        .ship-stat {
            padding: 14px;
        }

        .ship-stat-number {
            font-size: 23px;
        }

        .ship-stat-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .ship-panel-header,
        .ship-filters {
            padding: 16px;
        }

        .ship-input,
        .ship-select {
            flex: 1 1 100%;
            width: 100%;
        }

        .ship-filters .ship-btn {
            flex: 1;
        }

        .ship-alert {
            margin-right: 16px;
            margin-left: 16px;
        }

        .ship-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="ship-page">

    <div class="ship-heading">
        <h2>Pengiriman</h2>
        <p>Pantau perjalanan pesanan dan kelola informasi pengiriman pelanggan.</p>
    </div>

    <div class="ship-stats">
        <div class="ship-stat">
            <div>
                <div class="ship-stat-label">Total Pengiriman</div>
                <div class="ship-stat-number">{{ $totalPengiriman }}</div>
            </div>
            <div class="ship-stat-icon ship-blue">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
        </div>

        <div class="ship-stat">
            <div>
                <div class="ship-stat-label">Menunggu</div>
                <div class="ship-stat-number">{{ $totalMenunggu }}</div>
            </div>
            <div class="ship-stat-icon ship-orange">
                <i class="fa-regular fa-clock"></i>
            </div>
        </div>

        <div class="ship-stat">
            <div>
                <div class="ship-stat-label">Dalam Perjalanan</div>
                <div class="ship-stat-number">{{ $totalDikirim }}</div>
            </div>
            <div class="ship-stat-icon ship-purple">
                <i class="fa-solid fa-route"></i>
            </div>
        </div>

        <div class="ship-stat">
            <div>
                <div class="ship-stat-label">Sudah Diterima</div>
                <div class="ship-stat-number">{{ $totalDiterima }}</div>
            </div>
            <div class="ship-stat-icon ship-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>

    <section class="ship-panel">
        <div class="ship-panel-header">
            <h3 class="ship-panel-title">Daftar Pengiriman</h3>
            <div class="ship-panel-subtitle">
                Data ekspedisi, nomor resi, dan status paket.
            </div>
        </div>

        @if(session('success'))
            <div class="ship-alert ship-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="ship-alert ship-alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.pengiriman.index') }}" method="GET" class="ship-filters">
            <input
                type="text"
                name="search"
                class="ship-input"
                placeholder="Cari ID, nomor resi, nama, atau email..."
                value="{{ request('search') }}"
            >

            <select name="status" class="ship-select">
                <option value="">Semua Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="ship-btn ship-btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.pengiriman.index') }}" class="ship-btn ship-btn-light">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>

        <div class="ship-table-wrap">
            <table class="ship-table">
                <thead>
                    <tr>
                        <th>ID Pengiriman</th>
                        <th>Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Ekspedisi</th>
                        <th>Nomor Resi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pengiriman as $item)
                        <tr>
                            <td>
                                <span class="ship-id">#{{ $item->id_pengiriman }}</span>
                            </td>

                            <td>
                                <span class="ship-main">
                                    #{{ $item->pesanan->id_pesanan ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="ship-main">
                                    {{ $item->pesanan->user->nama ?? 'Pelanggan tidak ditemukan' }}
                                </div>
                                <div class="ship-muted">
                                    {{ $item->pesanan->user->email ?? '-' }}
                                </div>
                            </td>

                            <td>{{ $item->ekspedisi->nama_ekspedisi ?? '-' }}</td>

                            <td>
                                @if($item->no_resi)
                                    <span class="ship-main">{{ $item->no_resi }}</span>
                                @else
                                    <span class="ship-muted">Belum tersedia</span>
                                @endif
                            </td>

                            <td>
                                <span class="ship-badge ship-status-{{ $item->status_pengiriman }}">
                                    {{ ucfirst($item->status_pengiriman) }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.pengiriman.show', $item->id_pengiriman) }}"
                                    class="ship-action"
                                    title="Detail Pengiriman"
                                    aria-label="Detail pengiriman {{ $item->id_pengiriman }}"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="ship-empty">
                                <i class="fa-solid fa-truck-fast"></i>
                                <strong>Belum ada data pengiriman</strong>
                                <div>Data pengiriman akan tampil di halaman ini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="ship-pagination">
            <span class="ship-pagination-info">
                Menampilkan {{ $pengiriman->firstItem() ?? 0 }}–{{ $pengiriman->lastItem() ?? 0 }}
                dari {{ $pengiriman->total() }} pengiriman
            </span>

            {{ $pengiriman->appends(request()->query())->links() }}
        </div>
    </section>
</div>
@endsection
