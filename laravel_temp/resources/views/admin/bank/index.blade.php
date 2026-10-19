@extends('admin.layouts.app')

@section('title', 'Bank')
@section('breadcrumb', 'Bank')

@push('styles')
<style>
    .bank-page {
        color: #182230;
    }

    .bank-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
    }

    .bank-heading h2 {
        margin: 0 0 7px;
        color: #101828;
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .bank-heading p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .bank-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .bank-stat {
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

    .bank-stat-label {
        color: #788397;
        font-size: 12px;
        font-weight: 600;
    }

    .bank-stat-number {
        margin-top: 8px;
        color: #101828;
        font-size: 27px;
        font-weight: 800;
    }

    .bank-stat-icon {
        display: grid;
        place-items: center;
        flex-shrink: 0;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 18px;
    }

    .bank-blue {
        color: #246bfd;
        background: #edf3ff;
    }

    .bank-green {
        color: #159765;
        background: #e8f8f0;
    }

    .bank-red {
        color: #d04444;
        background: #fff0f0;
    }

    .bank-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        box-shadow: 0 3px 12px #10182805;
    }

    .bank-panel-header {
        padding: 22px 24px;
        border-bottom: 1px solid #e8edf4;
    }

    .bank-panel-title {
        margin: 0;
        color: #101828;
        font-size: 16px;
        font-weight: 800;
    }

    .bank-panel-subtitle {
        margin-top: 5px;
        color: #788397;
        font-size: 12px;
    }

    .bank-alert {
        margin: 16px 24px 0;
        padding: 12px 15px;
        border-radius: 9px;
        font-size: 13px;
    }

    .bank-success {
        color: #13865c;
        background: #e8f8f0;
        border: 1px solid #c9efdc;
    }

    .bank-error {
        color: #c03939;
        background: #fff0f0;
        border: 1px solid #ffdada;
    }

    .bank-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px 24px;
    }

    .bank-input,
    .bank-select {
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

    .bank-input {
        flex: 1 1 250px;
    }

    .bank-select {
        flex: 0 1 180px;
    }

    .bank-input:focus,
    .bank-select:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd15;
    }

    .bank-btn {
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

    .bank-btn-primary {
        color: #fff;
        background: #246bfd;
    }

    .bank-btn-primary:hover {
        color: #fff;
        background: #1558e8;
    }

    .bank-btn-light {
        color: #526075;
        background: #fff;
        border-color: #e1e7f0;
    }

    .bank-btn-light:hover {
        color: #182230;
        background: #f5f7fb;
    }

    .bank-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .bank-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .bank-table thead th {
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

    .bank-table tbody td {
        padding: 16px 18px;
        color: #344054;
        border-bottom: 1px solid #edf0f5;
        font-size: 13px;
        vertical-align: middle;
    }

    .bank-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .bank-table tbody tr:hover {
        background: #fafcff;
    }

    .bank-id {
        color: #246bfd;
        font-weight: 800;
    }

    .bank-name {
        color: #182230;
        font-weight: 700;
    }

    .bank-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .bank-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
        background: currentColor;
    }

    .bank-status-aktif {
        color: #13865c;
        background: #e8f8f0;
    }

    .bank-status-nonaktif {
        color: #d04444;
        background: #fff0f0;
    }

    .bank-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .bank-action {
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

    .bank-action-edit {
        color: #246bfd;
        background: #edf3ff;
        border-color: #dce8ff;
    }

    .bank-action-edit:hover {
        color: #fff;
        background: #246bfd;
        border-color: #246bfd;
    }

    .bank-action-delete {
        color: #d04444;
        background: #fff0f0;
        border-color: #ffdddd;
    }

    .bank-action-delete:hover {
        color: #fff;
        background: #d04444;
        border-color: #d04444;
    }

    .bank-empty {
        padding: 50px 20px !important;
        color: #788397 !important;
        text-align: center;
    }

    .bank-empty i {
        display: block;
        margin-bottom: 12px;
        color: #b7c2d3;
        font-size: 30px;
    }

    .bank-empty strong {
        display: block;
        color: #344054;
        font-size: 14px;
    }

    .bank-empty div {
        margin-top: 6px;
        font-size: 12px;
    }

    .bank-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 18px 24px;
        border-top: 1px solid #e8edf4;
    }

    .bank-pagination-info {
        color: #788397;
        font-size: 12px;
    }

    .bank-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 850px) {
        .bank-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .bank-heading h2 {
            font-size: 21px;
        }

        .bank-stats {
            gap: 10px;
        }

        .bank-stat {
            padding: 14px;
        }

        .bank-stat-number {
            font-size: 23px;
        }

        .bank-stat-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .bank-panel-header,
        .bank-filters {
            padding: 16px;
        }

        .bank-input,
        .bank-select {
            flex: 1 1 100%;
            width: 100%;
        }

        .bank-filters .bank-btn {
            flex: 1;
        }

        .bank-alert {
            margin-right: 16px;
            margin-left: 16px;
        }

        .bank-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="bank-page">

    <div class="bank-heading">
        <div>
            <h2>Bank</h2>
            <p>Kelola rekening bank yang digunakan dalam transaksi pembayaran.</p>
        </div>

        <a href="{{ route('admin.bank.create') }}" class="bank-btn bank-btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Bank
        </a>
    </div>

    <div class="bank-stats">
        <div class="bank-stat">
            <div>
                <div class="bank-stat-label">Total Bank</div>
                <div class="bank-stat-number">{{ $totalBank }}</div>
            </div>
            <div class="bank-stat-icon bank-blue">
                <i class="fa-solid fa-building-columns"></i>
            </div>
        </div>

        <div class="bank-stat">
            <div>
                <div class="bank-stat-label">Bank Aktif</div>
                <div class="bank-stat-number">{{ $totalAktif }}</div>
            </div>
            <div class="bank-stat-icon bank-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="bank-stat">
            <div>
                <div class="bank-stat-label">Bank Nonaktif</div>
                <div class="bank-stat-number">{{ $totalNonaktif }}</div>
            </div>
            <div class="bank-stat-icon bank-red">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>
    </div>

    <section class="bank-panel">
        <div class="bank-panel-header">
            <h3 class="bank-panel-title">Daftar Bank</h3>
            <div class="bank-panel-subtitle">
                Informasi nama bank, rekening, pemilik, dan status.
            </div>
        </div>

        @if(session('success'))
            <div class="bank-alert bank-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bank-alert bank-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bank-alert bank-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.bank.index') }}" method="GET" class="bank-filters">
            <input
                type="text"
                name="search"
                class="bank-input"
                placeholder="Cari nama bank, nomor rekening, atau pemilik..."
                value="{{ request('search') }}"
            >

            <select name="status" class="bank-select">
                <option value="">Semua Status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>
                    Aktif
                </option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>
                    Nonaktif
                </option>
            </select>

            <button type="submit" class="bank-btn bank-btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.bank.index') }}" class="bank-btn bank-btn-light">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>

        <div class="bank-table-wrap">
            <table class="bank-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Bank</th>
                        <th>Nomor Rekening</th>
                        <th>Atas Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bank as $item)
                        <tr>
                            <td>
                                <span class="bank-id">#{{ $item->id_bank }}</span>
                            </td>

                            <td>
                                <div class="bank-name">{{ $item->nama_bank }}</div>
                            </td>

                            <td>{{ $item->no_rekening }}</td>

                            <td>{{ $item->atas_nama }}</td>

                            <td>
                                <span class="bank-badge bank-status-{{ $item->status_bank }}">
                                    {{ ucfirst($item->status_bank) }}
                                </span>
                            </td>

                            <td>
                                <div class="bank-actions">
                                    <a
                                        href="{{ route('admin.bank.edit', $item->id_bank) }}"
                                        class="bank-action bank-action-edit"
                                        title="Edit Bank"
                                        aria-label="Edit bank {{ $item->nama_bank }}"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.bank.destroy', $item->id_bank) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data bank ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bank-action bank-action-delete"
                                            title="Hapus Bank"
                                            aria-label="Hapus bank {{ $item->nama_bank }}"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="bank-empty">
                                <i class="fa-solid fa-building-columns"></i>
                                <strong>Belum ada data bank</strong>
                                <div>
                                    Klik Tambah Bank untuk memasukkan rekening bank.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bank-pagination">
            <span class="bank-pagination-info">
                Menampilkan {{ $bank->firstItem() ?? 0 }}–{{ $bank->lastItem() ?? 0 }}
                dari {{ $bank->total() }} bank
            </span>

            {{ $bank->appends(request()->query())->links() }}
        </div>
    </section>
</div>
@endsection
