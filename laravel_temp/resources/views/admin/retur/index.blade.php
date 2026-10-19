@extends('admin.layouts.app')

@section('title', 'Retur Produk')
@section('breadcrumb', 'Retur Produk')

@push('styles')
<style>
    .retur-page {
        color: #182230;
    }

    .retur-heading {
        margin-bottom: 24px;
    }

    .retur-heading h2 {
        margin: 0 0 7px;
        color: #101828;
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .retur-heading p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .retur-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .retur-stat {
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

    .retur-stat-label {
        color: #788397;
        font-size: 12px;
        font-weight: 600;
    }

    .retur-stat-number {
        margin-top: 8px;
        color: #101828;
        font-size: 27px;
        font-weight: 800;
    }

    .retur-stat-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 18px;
    }

    .retur-blue {
        color: #246bfd;
        background: #edf3ff;
    }

    .retur-orange {
        color: #d97706;
        background: #fff5e5;
    }

    .retur-purple {
        color: #7655d9;
        background: #f2edff;
    }

    .retur-green {
        color: #159765;
        background: #e8f8f0;
    }

    .retur-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        box-shadow: 0 3px 12px #10182805;
    }

    .retur-panel-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e8edf4;
    }

    .retur-panel-title {
        margin: 0;
        color: #101828;
        font-size: 16px;
        font-weight: 800;
    }

    .retur-panel-subtitle {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .retur-alert {
        margin: 16px 24px 0;
        padding: 12px 15px;
        border-radius: 9px;
        font-size: 13px;
    }

    .retur-alert-success {
        color: #13865c;
        background: #e8f8f0;
        border: 1px solid #c9efdc;
    }

    .retur-alert-danger {
        color: #c03939;
        background: #fff0f0;
        border: 1px solid #ffdada;
    }

    .retur-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        padding: 20px 24px;
    }

    .retur-input,
    .retur-select {
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

    .retur-input {
        flex: 1 1 250px;
    }

    .retur-select {
        flex: 0 1 200px;
    }

    .retur-input:focus,
    .retur-select:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd15;
    }

    .retur-btn {
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

    .retur-btn-primary {
        color: #fff;
        background: #246bfd;
    }

    .retur-btn-primary:hover {
        color: #fff;
        background: #1558e8;
    }

    .retur-btn-light {
        color: #526075;
        background: #fff;
        border-color: #e1e7f0;
    }

    .retur-btn-light:hover {
        color: #182230;
        background: #f5f7fb;
    }

    .retur-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .retur-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .retur-table thead th {
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

    .retur-table tbody td {
        padding: 16px 18px;
        border-bottom: 1px solid #edf0f5;
        color: #344054;
        font-size: 13px;
        vertical-align: middle;
    }

    .retur-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .retur-table tbody tr:hover {
        background: #fafcff;
    }

    .retur-id {
        color: #246bfd;
        font-weight: 800;
    }

    .retur-main {
        color: #182230;
        font-weight: 700;
    }

    .retur-muted {
        max-width: 250px;
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
        white-space: normal;
        line-height: 1.5;
    }

    .retur-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .retur-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
        background: currentColor;
    }

    .retur-status-diajukan {
        color: #b77912;
        background: #fff5d9;
    }

    .retur-status-disetujui {
        color: #246bfd;
        background: #edf3ff;
    }

    .retur-status-ditolak {
        color: #d04444;
        background: #fff0f0;
    }

    .retur-status-selesai {
        color: #13865c;
        background: #e8f8f0;
    }

    .retur-action {
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

    .retur-action:hover {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    .retur-empty {
        padding: 50px 20px !important;
        color: #788397 !important;
        text-align: center;
    }

    .retur-empty i {
        display: block;
        margin-bottom: 12px;
        color: #b7c2d3;
        font-size: 30px;
    }

    .retur-empty strong {
        display: block;
        color: #344054;
        font-size: 14px;
    }

    .retur-empty div {
        margin-top: 6px;
        font-size: 12px;
    }

    .retur-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px 24px;
        border-top: 1px solid #e8edf4;
    }

    .retur-pagination-info {
        color: #788397;
        font-size: 12px;
    }

    .retur-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .retur-pagination nav > div {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .retur-pagination nav a,
    .retur-pagination nav span {
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

    .retur-pagination nav [aria-current="page"] span {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    @media (max-width: 1100px) {
        .retur-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .retur-heading h2 {
            font-size: 21px;
        }

        .retur-stats {
            gap: 10px;
        }

        .retur-stat {
            padding: 14px;
        }

        .retur-stat-number {
            font-size: 23px;
        }

        .retur-stat-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .retur-panel-header,
        .retur-filters {
            padding: 16px;
        }

        .retur-input,
        .retur-select {
            flex: 1 1 100%;
            width: 100%;
        }

        .retur-filters .retur-btn {
            flex: 1;
        }

        .retur-alert {
            margin-right: 16px;
            margin-left: 16px;
        }

        .retur-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="retur-page">

    <div class="retur-heading">
        <h2>Retur Produk</h2>
        <p>Pantau pengajuan retur dan kelola keputusan retur pelanggan.</p>
    </div>

    <div class="retur-stats">
        <div class="retur-stat">
            <div>
                <div class="retur-stat-label">Total Retur</div>
                <div class="retur-stat-number">{{ $totalRetur }}</div>
            </div>
            <div class="retur-stat-icon retur-blue">
                <i class="fa-solid fa-rotate-left"></i>
            </div>
        </div>

        <div class="retur-stat">
            <div>
                <div class="retur-stat-label">Pengajuan Baru</div>
                <div class="retur-stat-number">{{ $totalDiajukan }}</div>
            </div>
            <div class="retur-stat-icon retur-orange">
                <i class="fa-regular fa-clock"></i>
            </div>
        </div>

        <div class="retur-stat">
            <div>
                <div class="retur-stat-label">Disetujui</div>
                <div class="retur-stat-number">{{ $totalDisetujui }}</div>
            </div>
            <div class="retur-stat-icon retur-purple">
                <i class="fa-solid fa-thumbs-up"></i>
            </div>
        </div>

        <div class="retur-stat">
            <div>
                <div class="retur-stat-label">Selesai</div>
                <div class="retur-stat-number">{{ $totalSelesai }}</div>
            </div>
            <div class="retur-stat-icon retur-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>
    </div>

    <section class="retur-panel">
        <div class="retur-panel-header">
            <h3 class="retur-panel-title">Daftar Pengajuan Retur</h3>
            <div class="retur-panel-subtitle">
                Data pengajuan retur berdasarkan produk dan pesanan pelanggan.
            </div>
        </div>

        @if(session('success'))
            <div class="retur-alert retur-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="retur-alert retur-alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.retur.index') }}" method="GET" class="retur-filters">
            <input
                type="text"
                name="search"
                class="retur-input"
                placeholder="Cari ID retur, produk, pelanggan, atau alasan..."
                value="{{ request('search') }}"
            >

            <select name="status" class="retur-select">
                <option value="">Semua Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="retur-btn retur-btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.retur.index') }}" class="retur-btn retur-btn-light">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>

        <div class="retur-table-wrap">
            <table class="retur-table">
                <thead>
                    <tr>
                        <th>ID Retur</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($retur as $item)
                        <tr>
                            <td>
                                <span class="retur-id">#{{ $item->id_retur }}</span>
                            </td>

                            <td>
                                <div class="retur-main">
                                    {{ $item->detailPesanan->pesanan->user->nama ?? 'Pelanggan tidak ditemukan' }}
                                </div>
                                <div class="retur-muted">
                                    {{ $item->detailPesanan->pesanan->user->email ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <div class="retur-main">
                                    {{ $item->detailPesanan->produk->nama_produk ?? 'Produk tidak ditemukan' }}
                                </div>
                                <div class="retur-muted">
                                    Pesanan #{{ $item->detailPesanan->id_pesanan ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $item->tanggal_retur ? $item->tanggal_retur->format('d M Y') : '-' }}
                                <div class="retur-muted">
                                    {{ $item->tanggal_retur ? $item->tanggal_retur->format('H:i') : '' }}
                                </div>
                            </td>

                            <td>{{ $item->jumlah_retur }} unit</td>

                            <td>
                                <span class="retur-badge retur-status-{{ $item->status_retur }}">
                                    {{ ucfirst($item->status_retur) }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.retur.show', $item->id_retur) }}"
                                    class="retur-action"
                                    title="Detail Retur"
                                    aria-label="Detail retur {{ $item->id_retur }}"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="retur-empty">
                                <i class="fa-solid fa-inbox"></i>
                                <strong>Belum ada pengajuan retur</strong>
                                <div>Pengajuan retur akan tampil di sini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="retur-pagination">
            <span class="retur-pagination-info">
                Menampilkan {{ $retur->firstItem() ?? 0 }}–{{ $retur->lastItem() ?? 0 }}
                dari {{ $retur->total() }} retur
            </span>

            {{ $retur->appends(request()->query())->links() }}
        </div>
    </section>
</div>
@endsection
