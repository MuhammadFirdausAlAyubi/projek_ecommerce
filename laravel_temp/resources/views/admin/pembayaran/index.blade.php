@extends('admin.layouts.app')

@section('title', 'Pembayaran')
@section('breadcrumb', 'Pembayaran')

@push('styles')
<style>
    .pembayaran-page {
        color: #182230;
    }

    .pembayaran-heading {
        margin-bottom: 24px;
    }

    .pembayaran-heading h2 {
        margin: 0 0 7px;
        color: #101828;
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .pembayaran-heading p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .pembayaran-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .pembayaran-stat {
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

    .pembayaran-stat-label {
        color: #788397;
        font-size: 12px;
        font-weight: 600;
    }

    .pembayaran-stat-number {
        margin-top: 8px;
        color: #101828;
        font-size: 27px;
        font-weight: 800;
    }

    .pembayaran-stat-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 18px;
    }

    .pembayaran-blue {
        color: #246bfd;
        background: #edf3ff;
    }

    .pembayaran-orange {
        color: #d97706;
        background: #fff5e5;
    }

    .pembayaran-green {
        color: #159765;
        background: #e8f8f0;
    }

    .pembayaran-red {
        color: #d04444;
        background: #fff0f0;
    }

    .pembayaran-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        box-shadow: 0 3px 12px #10182805;
    }

    .pembayaran-panel-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e8edf4;
    }

    .pembayaran-panel-title {
        margin: 0;
        color: #101828;
        font-size: 16px;
        font-weight: 800;
    }

    .pembayaran-panel-subtitle {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .pembayaran-alert {
        margin: 16px 24px 0;
        padding: 12px 15px;
        border-radius: 9px;
        font-size: 13px;
    }

    .pembayaran-alert-success {
        color: #13865c;
        background: #e8f8f0;
        border: 1px solid #c9efdc;
    }

    .pembayaran-alert-danger {
        color: #c03939;
        background: #fff0f0;
        border: 1px solid #ffdada;
    }

    .pembayaran-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        padding: 20px 24px;
    }

    .pembayaran-input,
    .pembayaran-select {
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

    .pembayaran-input {
        flex: 1 1 250px;
    }

    .pembayaran-select {
        flex: 0 1 210px;
    }

    .pembayaran-input:focus,
    .pembayaran-select:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd15;
    }

    .pembayaran-btn {
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

    .pembayaran-btn-primary {
        color: #fff;
        background: #246bfd;
    }

    .pembayaran-btn-primary:hover {
        color: #fff;
        background: #1558e8;
    }

    .pembayaran-btn-light {
        color: #526075;
        background: #fff;
        border-color: #e1e7f0;
    }

    .pembayaran-btn-light:hover {
        color: #182230;
        background: #f5f7fb;
    }

    .pembayaran-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .pembayaran-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .pembayaran-table thead th {
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

    .pembayaran-table tbody td {
        padding: 16px 18px;
        color: #344054;
        border-bottom: 1px solid #edf0f5;
        font-size: 13px;
        vertical-align: middle;
    }

    .pembayaran-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .pembayaran-table tbody tr:hover {
        background: #fafcff;
    }

    .pembayaran-id {
        color: #246bfd;
        font-weight: 800;
    }

    .pembayaran-main-text {
        color: #182230;
        font-weight: 700;
    }

    .pembayaran-muted {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .pembayaran-amount {
        color: #101828;
        font-weight: 800;
    }

    .pembayaran-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .pembayaran-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
        background: currentColor;
    }

    .pembayaran-status-menunggu {
        color: #b77912;
        background: #fff5d9;
    }

    .pembayaran-status-berhasil {
        color: #13865c;
        background: #e8f8f0;
    }

    .pembayaran-status-gagal {
        color: #d04444;
        background: #fff0f0;
    }

    .pembayaran-status-dikembalikan {
        color: #7655d9;
        background: #f2edff;
    }

    .pembayaran-action {
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

    .pembayaran-action:hover {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    .pembayaran-empty {
        padding: 50px 20px !important;
        color: #788397 !important;
        text-align: center;
    }

    .pembayaran-empty i {
        display: block;
        margin-bottom: 12px;
        color: #b7c2d3;
        font-size: 30px;
    }

    .pembayaran-empty strong {
        display: block;
        color: #344054;
        font-size: 14px;
    }

    .pembayaran-empty div {
        margin-top: 6px;
        font-size: 12px;
    }

    .pembayaran-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px 24px;
        border-top: 1px solid #e8edf4;
    }

    .pembayaran-pagination-info {
        color: #788397;
        font-size: 12px;
    }

    .pembayaran-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .pembayaran-pagination nav > div {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .pembayaran-pagination nav a,
    .pembayaran-pagination nav span {
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

    .pembayaran-pagination nav [aria-current="page"] span {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    @media (max-width: 1100px) {
        .pembayaran-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .pembayaran-heading h2 {
            font-size: 21px;
        }

        .pembayaran-stats {
            gap: 10px;
        }

        .pembayaran-stat {
            padding: 14px;
        }

        .pembayaran-stat-number {
            font-size: 23px;
        }

        .pembayaran-stat-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .pembayaran-filters,
        .pembayaran-panel-header {
            padding: 16px;
        }

        .pembayaran-input,
        .pembayaran-select {
            flex: 1 1 100%;
            width: 100%;
        }

        .pembayaran-filters .pembayaran-btn {
            flex: 1;
        }

        .pembayaran-alert {
            margin-right: 16px;
            margin-left: 16px;
        }

        .pembayaran-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="pembayaran-page">

    <div class="pembayaran-heading">
        <h2>Pembayaran</h2>
        <p>Pantau status dan informasi pembayaran transaksi pelanggan.</p>
    </div>

    <div class="pembayaran-stats">
        <div class="pembayaran-stat">
            <div>
                <div class="pembayaran-stat-label">Total Pembayaran</div>
                <div class="pembayaran-stat-number">{{ $totalPembayaran }}</div>
            </div>
            <div class="pembayaran-stat-icon pembayaran-blue">
                <i class="fa-solid fa-credit-card"></i>
            </div>
        </div>

        <div class="pembayaran-stat">
            <div>
                <div class="pembayaran-stat-label">Menunggu</div>
                <div class="pembayaran-stat-number">{{ $totalMenunggu }}</div>
            </div>
            <div class="pembayaran-stat-icon pembayaran-orange">
                <i class="fa-regular fa-clock"></i>
            </div>
        </div>

        <div class="pembayaran-stat">
            <div>
                <div class="pembayaran-stat-label">Berhasil</div>
                <div class="pembayaran-stat-number">{{ $totalBerhasil }}</div>
            </div>
            <div class="pembayaran-stat-icon pembayaran-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="pembayaran-stat">
            <div>
                <div class="pembayaran-stat-label">Gagal</div>
                <div class="pembayaran-stat-number">{{ $totalGagal }}</div>
            </div>
            <div class="pembayaran-stat-icon pembayaran-red">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>
    </div>

    <section class="pembayaran-panel">
        <div class="pembayaran-panel-header">
            <h3 class="pembayaran-panel-title">Daftar Pembayaran</h3>
            <div class="pembayaran-panel-subtitle">
                Informasi nominal, metode, dan status pembayaran.
            </div>
        </div>

        @if(session('success'))
            <div class="pembayaran-alert pembayaran-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="pembayaran-alert pembayaran-alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="pembayaran-filters">
            <input
                type="text"
                name="search"
                class="pembayaran-input"
                placeholder="Cari ID pembayaran, nama, atau email..."
                value="{{ request('search') }}"
            >

            <select name="status" class="pembayaran-select">
                <option value="">Semua Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="pembayaran-btn pembayaran-btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.pembayaran.index') }}" class="pembayaran-btn pembayaran-btn-light">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>

        <div class="pembayaran-table-wrap">
            <table class="pembayaran-table">
                <thead>
                    <tr>
                        <th>ID Pembayaran</th>
                        <th>Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Metode</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pembayaran as $item)
                        <tr>
                            <td>
                                <span class="pembayaran-id">#{{ $item->id_pembayaran }}</span>
                            </td>

                            <td>
                                <span class="pembayaran-main-text">
                                    #{{ $item->pesanan->id_pesanan ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="pembayaran-main-text">
                                    {{ $item->pesanan->user->nama ?? 'Pelanggan tidak ditemukan' }}
                                </div>
                                <div class="pembayaran-muted">
                                    {{ $item->pesanan->user->email ?? '-' }}
                                </div>
                            </td>

                            <td>{{ strtoupper($item->metode_pembayaran) }}</td>

                            <td>
                                {{ $item->tanggal_pembayaran ? $item->tanggal_pembayaran->format('d M Y') : '-' }}
                                <div class="pembayaran-muted">
                                    {{ $item->tanggal_pembayaran ? $item->tanggal_pembayaran->format('H:i') : 'Belum tercatat' }}
                                </div>
                            </td>

                            <td>
                                <span class="pembayaran-amount">
                                    Rp {{ number_format((float) $item->nominal, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="pembayaran-badge pembayaran-status-{{ $item->status_pembayaran }}">
                                    {{ ucfirst($item->status_pembayaran) }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.pembayaran.show', $item->id_pembayaran) }}"
                                    class="pembayaran-action"
                                    title="Detail Pembayaran"
                                    aria-label="Detail pembayaran {{ $item->id_pembayaran }}"
                                >
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="pembayaran-empty">
                                <i class="fa-solid fa-receipt"></i>
                                <strong>Belum ada pembayaran</strong>
                                <div>Data pembayaran akan tampil di halaman ini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pembayaran-pagination">
            <span class="pembayaran-pagination-info">
                Menampilkan {{ $pembayaran->firstItem() ?? 0 }}–{{ $pembayaran->lastItem() ?? 0 }}
                dari {{ $pembayaran->total() }} pembayaran
            </span>

            {{ $pembayaran->appends(request()->query())->links() }}
        </div>
    </section>
</div>
@endsection
