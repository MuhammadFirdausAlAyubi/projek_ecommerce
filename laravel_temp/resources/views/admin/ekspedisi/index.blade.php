@extends('admin.layouts.app')

@section('title', 'Ekspedisi')
@section('breadcrumb', 'Ekspedisi')

@push('styles')
<style>
    .exp-page {
        color: #182230;
    }

    .exp-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
    }

    .exp-heading h2 {
        margin: 0 0 7px;
        color: #101828;
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .exp-heading p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .exp-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .exp-stat {
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

    .exp-stat-label {
        color: #788397;
        font-size: 12px;
        font-weight: 600;
    }

    .exp-stat-number {
        margin-top: 8px;
        color: #101828;
        font-size: 27px;
        font-weight: 800;
    }

    .exp-stat-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 18px;
    }

    .exp-blue {
        color: #246bfd;
        background: #edf3ff;
    }

    .exp-green {
        color: #159765;
        background: #e8f8f0;
    }

    .exp-red {
        color: #d04444;
        background: #fff0f0;
    }

    .exp-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        box-shadow: 0 3px 12px #10182805;
    }

    .exp-panel-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e8edf4;
    }

    .exp-panel-title {
        margin: 0;
        color: #101828;
        font-size: 16px;
        font-weight: 800;
    }

    .exp-panel-subtitle {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .exp-alert {
        margin: 16px 24px 0;
        padding: 12px 15px;
        border-radius: 9px;
        font-size: 13px;
    }

    .exp-success {
        color: #13865c;
        background: #e8f8f0;
        border: 1px solid #c9efdc;
    }

    .exp-danger-alert {
        color: #c03939;
        background: #fff0f0;
        border: 1px solid #ffdada;
    }

    .exp-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px 24px;
    }

    .exp-input,
    .exp-select {
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

    .exp-input {
        flex: 1 1 250px;
    }

    .exp-select {
        flex: 0 1 180px;
    }

    .exp-input:focus,
    .exp-select:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd15;
    }

    .exp-btn {
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

    .exp-btn-primary {
        color: #fff;
        background: #246bfd;
    }

    .exp-btn-primary:hover {
        color: #fff;
        background: #1558e8;
    }

    .exp-btn-light {
        color: #526075;
        background: #fff;
        border-color: #e1e7f0;
    }

    .exp-btn-light:hover {
        color: #182230;
        background: #f5f7fb;
    }

    .exp-btn-danger {
        color: #d04444;
        background: #fff0f0;
        border-color: #ffdddd;
    }

    .exp-btn-danger:hover {
        color: #b42323;
        background: #ffe2e2;
    }

    .exp-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .exp-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .exp-table thead th {
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

    .exp-table tbody td {
        padding: 16px 18px;
        color: #344054;
        border-bottom: 1px solid #edf0f5;
        font-size: 13px;
        vertical-align: middle;
    }

    .exp-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .exp-table tbody tr:hover {
        background: #fafcff;
    }

    .exp-id {
        color: #246bfd;
        font-weight: 800;
    }

    .exp-name {
        color: #182230;
        font-weight: 700;
    }

    .exp-muted {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .exp-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .exp-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
        background: currentColor;
    }

    .exp-status-aktif {
        color: #13865c;
        background: #e8f8f0;
    }

    .exp-status-nonaktif {
        color: #d04444;
        background: #fff0f0;
    }

    .exp-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .exp-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        padding: 0;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 13px;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .exp-action-edit {
        color: #246bfd;
        background: #edf3ff;
        border-color: #dce8ff;
    }

    .exp-action-edit:hover {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    .exp-action-delete {
        color: #d04444;
        background: #fff0f0;
        border-color: #ffdddd;
    }

    .exp-action-delete:hover {
        color: #fff;
        background: #d04444;
        border-color: #d04444;
    }

    .exp-empty {
        padding: 50px 20px !important;
        color: #788397 !important;
        text-align: center;
    }

    .exp-empty i {
        display: block;
        margin-bottom: 12px;
        color: #b7c2d3;
        font-size: 30px;
    }

    .exp-empty strong {
        display: block;
        color: #344054;
        font-size: 14px;
    }

    .exp-empty div {
        margin-top: 6px;
        font-size: 12px;
    }

    .exp-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px 24px;
        border-top: 1px solid #e8edf4;
    }

    .exp-pagination-info {
        color: #788397;
        font-size: 12px;
    }

    .exp-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .exp-pagination nav > div {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .exp-pagination nav a,
    .exp-pagination nav span {
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

    .exp-pagination nav [aria-current="page"] span {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    @media (max-width: 850px) {
        .exp-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .exp-heading h2 {
            font-size: 21px;
        }

        .exp-stats {
            gap: 10px;
        }

        .exp-stat {
            padding: 14px;
        }

        .exp-stat-number {
            font-size: 23px;
        }

        .exp-stat-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .exp-panel-header,
        .exp-filters {
            padding: 16px;
        }

        .exp-input,
        .exp-select {
            flex: 1 1 100%;
            width: 100%;
        }

        .exp-filters .exp-btn {
            flex: 1;
        }

        .exp-alert {
            margin-right: 16px;
            margin-left: 16px;
        }

        .exp-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="exp-page">

    <div class="exp-heading">
        <div>
            <h2>Ekspedisi</h2>
            <p>Kelola jasa kurir yang digunakan untuk pengiriman pesanan.</p>
        </div>

        <a href="{{ route('admin.ekspedisi.create') }}" class="exp-btn exp-btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Ekspedisi
        </a>
    </div>

    <div class="exp-stats">
        <div class="exp-stat">
            <div>
                <div class="exp-stat-label">Total Ekspedisi</div>
                <div class="exp-stat-number">{{ $totalEkspedisi }}</div>
            </div>
            <div class="exp-stat-icon exp-blue">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
        </div>

        <div class="exp-stat">
            <div>
                <div class="exp-stat-label">Ekspedisi Aktif</div>
                <div class="exp-stat-number">{{ $totalAktif }}</div>
            </div>
            <div class="exp-stat-icon exp-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="exp-stat">
            <div>
                <div class="exp-stat-label">Ekspedisi Nonaktif</div>
                <div class="exp-stat-number">{{ $totalNonaktif }}</div>
            </div>
            <div class="exp-stat-icon exp-red">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>
    </div>

    <section class="exp-panel">
        <div class="exp-panel-header">
            <h3 class="exp-panel-title">Daftar Ekspedisi</h3>
            <div class="exp-panel-subtitle">
                Kelola nama jasa kurir dan status penggunaannya.
            </div>
        </div>

        @if(session('success'))
            <div class="exp-alert exp-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="exp-alert exp-danger-alert">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="exp-alert exp-danger-alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.ekspedisi.index') }}" method="GET" class="exp-filters">
            <input
                type="text"
                name="search"
                class="exp-input"
                placeholder="Cari nama ekspedisi..."
                value="{{ request('search') }}"
            >

            <select name="status" class="exp-select">
                <option value="">Semua Status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>
                    Aktif
                </option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>
                    Nonaktif
                </option>
            </select>

            <button type="submit" class="exp-btn exp-btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.ekspedisi.index') }}" class="exp-btn exp-btn-light">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>

        <div class="exp-table-wrap">
            <table class="exp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Ekspedisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ekspedisi as $item)
                        <tr>
                            <td>
                                <span class="exp-id">#{{ $item->id_ekspedisi }}</span>
                            </td>

                            <td>
                                <div class="exp-name">{{ $item->nama_ekspedisi }}</div>
                                <div class="exp-muted">Jasa pengiriman</div>
                            </td>

                            <td>
                                <span class="exp-badge exp-status-{{ $item->status_ekspedisi }}">
                                    {{ ucfirst($item->status_ekspedisi) }}
                                </span>
                            </td>

                            <td>
                                <div class="exp-actions">
                                    <a
                                        href="{{ route('admin.ekspedisi.edit', $item->id_ekspedisi) }}"
                                        class="exp-action exp-action-edit"
                                        title="Edit Ekspedisi"
                                        aria-label="Edit ekspedisi {{ $item->nama_ekspedisi }}"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.ekspedisi.destroy', $item->id_ekspedisi) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus ekspedisi {{ $item->nama_ekspedisi }}?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="exp-action exp-action-delete"
                                            title="Hapus Ekspedisi"
                                            aria-label="Hapus ekspedisi {{ $item->nama_ekspedisi }}"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="exp-empty">
                                <i class="fa-solid fa-truck-fast"></i>
                                <strong>Belum ada data ekspedisi</strong>
                                <div>
                                    Klik tombol Tambah Ekspedisi untuk menambahkan jasa kurir.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="exp-pagination">
            <span class="exp-pagination-info">
                Menampilkan {{ $ekspedisi->firstItem() ?? 0 }}–{{ $ekspedisi->lastItem() ?? 0 }}
                dari {{ $ekspedisi->total() }} ekspedisi
            </span>

            {{ $ekspedisi->appends(request()->query())->links() }}
        </div>
    </section>
</div>
@endsection
