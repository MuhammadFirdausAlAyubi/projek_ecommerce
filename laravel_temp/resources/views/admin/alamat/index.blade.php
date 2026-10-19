@extends('admin.layouts.app')

@section('title', 'Alamat Pelanggan')
@section('breadcrumb', 'Alamat Pelanggan')

@push('styles')
<style>
    .alamat-page {
        color: #182230;
    }

    /* Heading */
    .alamat-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .alamat-head h2 {
        margin: 0;
        font-size: 29px;
        font-weight: 700;
        letter-spacing: -.7px;
        color: #182230;
    }

    .alamat-muted {
        margin-top: 8px;
        color: #788397;
        font-size: 12px;
    }

    /* Buttons */
    .alamat-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 15px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .alamat-primary {
        background: #246bfd;
        color: #fff;
    }

    .alamat-primary:hover {
        background: #1558df;
        color: #fff;
    }

    .alamat-secondary {
        background: #f0f4fa;
        color: #344054;
    }

    .alamat-secondary:hover {
        background: #e5ebf4;
        color: #182230;
    }

    /* Statistics */
    .alamat-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .alamat-stat {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 22px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
    }

    .alamat-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #edf4ff;
        color: #246bfd;
        font-size: 20px;
    }

    .alamat-stat-label {
        color: #788397;
        font-size: 12px;
    }

    .alamat-stat-value {
        margin-top: 5px;
        color: #182230;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.2;
    }

    /* Cards */
    .alamat-card {
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
    }

    .alamat-card-header {
        padding: 20px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .alamat-card-header h3 {
        margin: 0;
        color: #202c40;
        font-size: 16px;
        font-weight: 800;
    }

    .alamat-card-header p {
        margin: 5px 0 0;
        color: #788397;
        font-size: 11px;
    }

    /* Filters */
    .alamat-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 23px;
    }

    .alamat-input {
        min-height: 42px;
        padding: 10px 13px;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        background: #fff;
        color: #182230;
        font-family: inherit;
        font-size: 13px;
        outline: none;
    }

    .alamat-input:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px rgba(36, 107, 253, .1);
    }

    .alamat-search {
        flex: 1;
        min-width: 220px;
    }

    /* Alerts */
    .alamat-alert {
        padding: 13px 16px;
        margin-bottom: 18px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
    }

    .alamat-success {
        background: #ecfdf3;
        color: #067647;
        border-color: #abefc6;
    }

    .alamat-error {
        background: #fef3f2;
        color: #b42318;
        border-color: #fecdca;
    }

    /* Table */
    .alamat-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .alamat-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .alamat-table th {
        padding: 14px 18px;
        background: #fafbfd;
        color: #788397;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .5px;
        border-bottom: 1px solid #e8edf4;
        white-space: nowrap;
    }

    .alamat-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #536176;
        vertical-align: middle;
    }

    .alamat-table tbody tr:last-child td {
        border-bottom: none;
    }

    .alamat-table tbody tr:hover {
        background: #fafcff;
    }

    .alamat-recipient {
        color: #202c40;
        font-weight: 700;
    }

    .alamat-detail {
        max-width: 260px;
        white-space: normal;
        line-height: 1.6;
    }

    .alamat-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 20px;
        background: #e8f8ef;
        color: #067647;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Action icons: same size as Kategori */
    .alamat-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .alamat-actions form {
        margin: 0;
    }

    .alamat-action {
        width: 34px;
        height: 34px;
        padding: 0;
        display: grid;
        place-items: center;
        border: 0;
        border-radius: 8px;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .alamat-view {
        background: #edf4ff;
        color: #246bfd;
    }

    .alamat-view:hover {
        background: #246bfd;
        color: #fff;
    }

    .alamat-edit {
        background: #edf4ff;
        color: #246bfd;
    }

    .alamat-edit:hover {
        background: #246bfd;
        color: #fff;
    }

    .alamat-delete {
        background: #fff0f0;
        color: #b42332;
    }

    .alamat-delete:hover {
        background: #b42332;
        color: #fff;
    }

    /* Empty state */
    .alamat-empty {
        padding: 42px 20px !important;
        text-align: center;
    }

    .alamat-empty-icon {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        margin: 0 auto 12px;
        border-radius: 12px;
        background: #edf4ff;
        color: #246bfd;
        font-size: 22px;
    }

    .alamat-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: 14px;
        font-weight: 800;
    }

    .alamat-empty p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    /* Pagination */
    .alamat-pagination {
        padding: 18px 23px;
        border-top: 1px solid #e8edf4;
    }

    .alamat-pagination nav svg {
        width: 16px;
        height: 16px;
    }

    .alamat-pagination nav a,
    .alamat-pagination nav span {
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .alamat-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .alamat-head {
            align-items: flex-start;
        }

        .alamat-head h2 {
            font-size: 25px;
        }

        .alamat-stats {
            grid-template-columns: 1fr;
        }

        .alamat-filters {
            padding: 16px;
        }

        .alamat-search {
            flex-basis: 100%;
            min-width: 0;
        }

        .alamat-filters > .alamat-btn {
            flex: 1;
        }

        .alamat-table th,
        .alamat-table td {
            padding: 14px;
        }

        .alamat-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="alamat-page">

    {{-- HEADING --}}
    <div class="alamat-head">
        <div>
            <h2>Alamat Pelanggan</h2>
            <div class="alamat-muted">
                Kelola alamat pengiriman pelanggan ELECTROMART.
            </div>
        </div>

        <a href="{{ route('admin.alamat.create') }}"
           class="alamat-btn alamat-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Alamat
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alamat-alert alamat-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alamat-alert alamat-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alamat-alert alamat-error">
            <strong>Terjadi kesalahan:</strong>

            <ul style="margin:8px 0 0;padding-left:20px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="alamat-stats">

        <div class="alamat-stat">
            <div class="alamat-stat-icon">
                <i class="fa-solid fa-location-dot"></i>
            </div>

            <div>
                <div class="alamat-stat-label">Total Alamat</div>
                <div class="alamat-stat-value">
                    {{ number_format($totalAlamat, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="alamat-stat">
            <div class="alamat-stat-icon"
                 style="background:#e8f8ef;color:#067647">
                <i class="fa-solid fa-house-circle-check"></i>
            </div>

            <div>
                <div class="alamat-stat-label">Alamat Utama</div>
                <div class="alamat-stat-value">
                    {{ number_format($totalUtama, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="alamat-stat">
            <div class="alamat-stat-icon"
                 style="background:#f1eaff;color:#6d28d9">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>
                <div class="alamat-stat-label">Pelanggan dengan Alamat</div>
                <div class="alamat-stat-value">
                    {{ number_format($totalPelanggan, 0, ',', '.') }}
                </div>
            </div>
        </div>

    </div>

    {{-- FILTER ALAMAT --}}
    <div class="alamat-card">
        <div class="alamat-card-header">
            <h3>Filter Alamat</h3>
            <p>Cari alamat berdasarkan penerima, pelanggan, atau wilayah.</p>
        </div>

        <form method="GET"
              action="{{ route('admin.alamat.index') }}"
              class="alamat-filters">

            <input
                class="alamat-input alamat-search"
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari penerima, pelanggan, kota, provinsi..."
            >

            <select class="alamat-input" name="utama">
                <option value="">Semua Alamat</option>

                <option value="1"
                    {{ request('utama') === '1' ? 'selected' : '' }}>
                    Alamat Utama
                </option>

                <option value="0"
                    {{ request('utama') === '0' ? 'selected' : '' }}>
                    Bukan Alamat Utama
                </option>
            </select>

            <button class="alamat-btn alamat-primary" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.alamat.index') }}"
               class="alamat-btn alamat-secondary">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>
    </div>

    {{-- TABEL ALAMAT --}}
    <div class="alamat-card">

        <div class="alamat-card-header">
            <h3>Daftar Alamat Pelanggan</h3>
            <p>Informasi penerima, kontak, dan lokasi pengiriman.</p>
        </div>

        <div class="alamat-table-wrap">
            <table class="alamat-table">
                <thead>
                    <tr>
                        <th>Penerima</th>
                        <th>Pelanggan</th>
                        <th>Telepon</th>
                        <th>Wilayah</th>
                        <th>Alamat Utama</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($alamat as $item)
                        <tr>
                            <td>
                                <div class="alamat-recipient">
                                    {{ $item->nama_penerima }}
                                </div>

                                <div class="alamat-muted">
                                    ID: {{ $item->id_alamat }}
                                </div>
                            </td>

                            <td>
                                <div class="alamat-recipient">
                                    {{ $item->user?->nama ?? 'User tidak ditemukan' }}
                                </div>

                                <div class="alamat-muted">
                                    {{ $item->user?->email ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $item->no_telp_penerima ?: '-' }}
                            </td>

                            <td>
                                <div class="alamat-detail">
                                    {{ $item->kota ?: '-' }},
                                    {{ $item->provinsi ?: '-' }}
                                </div>

                                <div class="alamat-muted">
                                    {{ $item->kecamatan ?: '-' }}
                                    ·
                                    {{ $item->kode_pos ?: '-' }}
                                </div>
                            </td>

                            <td>
                                @if($item->is_utama)
                                    <span class="alamat-badge">
                                        <i class="fa-solid fa-check"></i>
                                        Utama
                                    </span>
                                @else
                                    <span class="alamat-muted">
                                        Bukan utama
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="alamat-actions">

                                    {{-- DETAIL --}}
                                    <a
                                        class="alamat-action alamat-view"
                                        href="{{ route('admin.alamat.show', $item->id_alamat) }}"
                                        title="Detail alamat"
                                        aria-label="Detail alamat"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    {{-- EDIT --}}
                                    <a
                                        class="alamat-action alamat-edit"
                                        href="{{ route('admin.alamat.edit', $item->id_alamat) }}"
                                        title="Edit alamat"
                                        aria-label="Edit alamat"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    {{-- HAPUS --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.alamat.destroy', $item->id_alamat) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus alamat ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="alamat-action alamat-delete"
                                            type="submit"
                                            title="Hapus alamat"
                                            aria-label="Hapus alamat"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="alamat-empty">
                                <div class="alamat-empty-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>

                                <strong>Alamat tidak ditemukan</strong>

                                <p>
                                    Coba ubah kata pencarian atau filter alamat.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($alamat->hasPages())
            <div class="alamat-pagination">
                {{ $alamat->appends(request()->query())->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
