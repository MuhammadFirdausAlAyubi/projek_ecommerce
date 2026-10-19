
@extends('admin.layouts.app')

@section('title', 'Keranjang Pelanggan')
@section('breadcrumb', 'Keranjang Pelanggan')

@push('styles')
<style>
    .kp-page {
        color: #182230;
    }

    /* Heading */
    .kp-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .kp-head h2 {
        margin: 0;
        font-size: 29px;
        font-weight: 700;
        letter-spacing: -.7px;
        color: #182230;
    }

    .kp-muted {
        margin-top: 8px;
        color: #788397;
        font-size: 12px;
    }

    /* Statistics */
    .kp-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .kp-stat {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
    }

    .kp-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #edf4ff;
        color: #246bfd;
        font-size: 19px;
    }

    .kp-stat-label {
        color: #788397;
        font-size: 12px;
    }

    .kp-stat-value {
        margin-top: 5px;
        color: #182230;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.2;
    }

    /* Cards */
    .kp-card {
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
    }

    .kp-card-header {
        padding: 20px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .kp-card-header h3 {
        margin: 0;
        color: #202c40;
        font-size: 16px;
        font-weight: 800;
    }

    .kp-card-header p {
        margin: 5px 0 0;
        color: #788397;
        font-size: 11px;
    }

    /* Filters */
    .kp-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 23px;
    }

    .kp-input {
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

    .kp-input:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px rgba(36, 107, 253, .1);
    }

    .kp-search {
        flex: 1;
        min-width: 220px;
    }

    /* Buttons */
    .kp-btn {
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

    .kp-primary {
        background: #246bfd;
        color: #fff;
    }

    .kp-primary:hover {
        background: #1558df;
        color: #fff;
    }

    .kp-secondary {
        background: #f0f4fa;
        color: #344054;
    }

    .kp-secondary:hover {
        background: #e5ebf4;
        color: #182230;
    }

    /* Alerts */
    .kp-alert {
        padding: 13px 16px;
        margin-bottom: 18px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
    }

    .kp-success {
        background: #ecfdf3;
        color: #067647;
        border-color: #abefc6;
    }

    .kp-error {
        background: #fef3f2;
        color: #b42318;
        border-color: #fecdca;
    }

    /* Table */
    .kp-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .kp-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .kp-table th {
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

    .kp-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #536176;
        vertical-align: middle;
    }

    .kp-table tbody tr:last-child td {
        border-bottom: none;
    }

    .kp-table tbody tr:hover {
        background: #fafcff;
    }

    .kp-id {
        color: #246bfd;
        font-weight: 800;
        white-space: nowrap;
    }

    .kp-user-name {
        color: #202c40;
        font-weight: 700;
    }

    /* Status badges */
    .kp-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .kp-aktif {
        background: #e8f8ef;
        color: #067647;
    }

    .kp-checkout {
        background: #edf4ff;
        color: #246bfd;
    }

    .kp-dikosongkan {
        background: #f0f2f5;
        color: #667085;
    }

    /* Action icons */
    .kp-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .kp-actions form {
        margin: 0;
    }

    .kp-action {
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

    .kp-detail {
        background: #edf4ff;
        color: #246bfd;
    }

    .kp-detail:hover {
        background: #246bfd;
        color: #fff;
    }

    .kp-danger {
        background: #fff0f0;
        color: #b42332;
    }

    .kp-danger:hover {
        background: #b42332;
        color: #fff;
    }

    /* Empty state */
    .kp-empty {
        padding: 42px 20px !important;
        text-align: center;
    }

    .kp-empty-icon {
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

    .kp-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: 14px;
        font-weight: 800;
    }

    .kp-empty p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    /* Pagination */
    .kp-pagination {
        padding: 18px 23px;
        border-top: 1px solid #e8edf4;
    }

    .kp-pagination nav svg {
        width: 16px;
        height: 16px;
    }

    .kp-pagination nav a,
    .kp-pagination nav span {
        font-size: 12px;
    }

    @media (max-width: 1100px) {
        .kp-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .kp-head {
            align-items: flex-start;
        }

        .kp-head h2 {
            font-size: 25px;
        }

        .kp-stats {
            grid-template-columns: 1fr;
        }

        .kp-filters {
            padding: 16px;
        }

        .kp-search {
            flex-basis: 100%;
            min-width: 0;
        }

        .kp-filters > .kp-btn {
            flex: 1;
        }

        .kp-table th,
        .kp-table td {
            padding: 14px;
        }

        .kp-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="kp-page">

    {{-- HEADING --}}
    <div class="kp-head">
        <div>
            <h2>Keranjang Pelanggan</h2>
            <div class="kp-muted">
                Pantau keranjang belanja pelanggan ELECTROMART.
            </div>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="kp-alert kp-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="kp-alert kp-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="kp-stats">

        <div class="kp-stat">
            <div class="kp-stat-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

            <div>
                <div class="kp-stat-label">Total Keranjang</div>
                <div class="kp-stat-value">
                    {{ number_format($totalKeranjang, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="kp-stat">
            <div class="kp-stat-icon"
                 style="background:#e8f8ef;color:#067647">
                <i class="fa-solid fa-cart-plus"></i>
            </div>

            <div>
                <div class="kp-stat-label">Keranjang Aktif</div>
                <div class="kp-stat-value">
                    {{ number_format($totalAktif, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="kp-stat">
            <div class="kp-stat-icon"
                 style="background:#edf4ff;color:#246bfd">
                <i class="fa-solid fa-credit-card"></i>
            </div>

            <div>
                <div class="kp-stat-label">Checkout</div>
                <div class="kp-stat-value">
                    {{ number_format($totalCheckout, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="kp-stat">
            <div class="kp-stat-icon"
                 style="background:#f0f2f5;color:#667085">
                <i class="fa-solid fa-cart-arrow-down"></i>
            </div>

            <div>
                <div class="kp-stat-label">Dikosongkan</div>
                <div class="kp-stat-value">
                    {{ number_format($totalDikosongkan, 0, ',', '.') }}
                </div>
            </div>
        </div>

    </div>

    {{-- FILTER KERANJANG --}}
    <div class="kp-card">
        <div class="kp-card-header">
            <h3>Filter Keranjang</h3>
            <p>Cari berdasarkan ID, pelanggan, atau status keranjang.</p>
        </div>

        <form action="{{ route('admin.keranjang.index') }}"
              method="GET"
              class="kp-filters">

            <input
                class="kp-input kp-search"
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari ID keranjang, nama pelanggan, email..."
            >

            <select class="kp-input" name="status">
                <option value="">Semua Status</option>

                <option value="aktif"
                    {{ request('status') === 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="checkout"
                    {{ request('status') === 'checkout' ? 'selected' : '' }}>
                    Checkout
                </option>

                <option value="dikosongkan"
                    {{ request('status') === 'dikosongkan' ? 'selected' : '' }}>
                    Dikosongkan
                </option>
            </select>

            <button type="submit" class="kp-btn kp-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.keranjang.index') }}"
               class="kp-btn kp-secondary">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>
    </div>

    {{-- TABEL KERANJANG --}}
    <div class="kp-card">

        <div class="kp-card-header">
            <h3>Daftar Keranjang Pelanggan</h3>
            <p>Informasi keranjang dan aktivitas belanja pelanggan.</p>
        </div>

        <div class="kp-table-wrap">
            <table class="kp-table">
                <thead>
                    <tr>
                        <th>ID Keranjang</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Dibuat</th>
                        <th>Jumlah Jenis Produk</th>
                        <th>Status</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($keranjang as $item)
                        <tr>
                            <td>
                                <span class="kp-id">
                                    #{{ $item->id_keranjang }}
                                </span>
                            </td>

                            <td>
                                <div class="kp-user-name">
                                    {{ $item->user?->nama ?? 'User tidak ditemukan' }}
                                </div>

                                <div class="kp-muted">
                                    {{ $item->user?->email ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $item->tanggal_dibuat
                                    ? $item->tanggal_dibuat->format('d/m/Y H:i')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $item->detail_keranjang_count ?? 0 }}
                                jenis
                            </td>

                            <td>
                                @if($item->status_keranjang === 'aktif')
                                    <span class="kp-badge kp-aktif">
                                        Aktif
                                    </span>
                                @elseif($item->status_keranjang === 'checkout')
                                    <span class="kp-badge kp-checkout">
                                        Checkout
                                    </span>
                                @else
                                    <span class="kp-badge kp-dikosongkan">
                                        Dikosongkan
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="kp-actions">

                                    {{-- DETAIL --}}
                                    <a
                                        class="kp-action kp-detail"
                                        href="{{ route('admin.keranjang.show', $item->id_keranjang) }}"
                                        title="Lihat detail"
                                        aria-label="Lihat detail"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    {{-- KOSONGKAN KERANJANG AKTIF --}}
                                    @if($item->status_keranjang === 'aktif')
                                        <form
                                            method="POST"
                                            action="{{ route('admin.keranjang.destroy', $item->id_keranjang) }}"
                                            onsubmit="return confirm('Yakin ingin mengosongkan isi keranjang ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="kp-action kp-danger"
                                                type="submit"
                                                title="Kosongkan keranjang"
                                                aria-label="Kosongkan keranjang"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="kp-empty">
                                <div class="kp-empty-icon">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>

                                <strong>Keranjang tidak ditemukan</strong>

                                <p>
                                    Coba ubah kata pencarian atau filter status.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($keranjang->hasPages())
            <div class="kp-pagination">
                {{ $keranjang->appends(request()->query())->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
