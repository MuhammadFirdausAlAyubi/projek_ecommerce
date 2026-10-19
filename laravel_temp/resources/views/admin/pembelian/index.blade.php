@extends('admin.layouts.app')

@section('title', 'Data Pembelian')
@section('breadcrumb', 'Pembelian')

@push('styles')
<style>
    .pb-page {
        color: #182230;
    }

    /* Heading */
    .pb-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .pb-heading h2 {
        margin: 0;
        font-size: 29px;
        font-weight: 700;
        letter-spacing: -.7px;
        color: #182230;
    }

    .pb-heading p {
        margin: 8px 0 0;
        color: #788397;
        font-size: 14px;
    }

    /* Buttons */
    .pb-btn {
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
        cursor: pointer;
        white-space: nowrap;
        transition: background .2s, color .2s;
    }

    .pb-primary {
        background: #246bfd;
        color: #fff;
    }

    .pb-primary:hover {
        background: #1558df;
        color: #fff;
    }

    .pb-secondary {
        background: #f0f4fa;
        color: #344054;
    }

    .pb-secondary:hover {
        background: #e5ebf4;
        color: #182230;
    }

    /* Cards */
    .pb-card {
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
    }

    .pb-card-header {
        padding: 20px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .pb-card-header h3 {
        margin: 0;
        color: #202c40;
        font-size: 16px;
        font-weight: 800;
    }

    .pb-card-header p {
        margin: 5px 0 0;
        color: #788397;
        font-size: 11px;
    }

    /* Alerts */
    .pb-alert {
        padding: 13px 16px;
        margin-bottom: 18px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
    }

    .pb-success {
        background: #ecfdf3;
        color: #067647;
        border-color: #abefc6;
    }

    .pb-error {
        background: #fef3f2;
        color: #b42318;
        border-color: #fecdca;
    }

    /* Filters */
    .pb-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 23px;
    }

    .pb-input {
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

    .pb-input:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px rgba(36, 107, 253, .1);
    }

    .pb-search {
        flex: 1;
        min-width: 200px;
    }

    /* Table */
    .pb-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .pb-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .pb-table th {
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

    .pb-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #536176;
        vertical-align: middle;
    }

    .pb-table tbody tr:last-child td {
        border-bottom: none;
    }

    .pb-table tbody tr:hover {
        background: #fafcff;
    }

    .pb-id {
        color: #246bfd;
        font-weight: 800;
        white-space: nowrap;
    }

    .pb-total {
        color: #202c40;
        font-weight: 700;
        white-space: nowrap;
    }

    .pb-muted {
        color: #788397;
        font-size: 12px;
    }

    /* Status badges */
    .pb-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .pb-ordered {
        background: #fff6df;
        color: #a56800;
    }

    .pb-received {
        background: #e8f8ef;
        color: #067647;
    }

    .pb-cancelled {
        background: #fff0f0;
        color: #b42332;
    }

    /* Action icons: same as Kategori */
    .pb-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .pb-actions form {
        margin: 0;
    }

    .pb-action {
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

    .pb-detail {
        background: #edf4ff;
        color: #246bfd;
    }

    .pb-detail:hover {
        background: #246bfd;
        color: #fff;
    }

    .pb-edit {
        background: #fff6df;
        color: #a56800;
    }

    .pb-edit:hover {
        background: #e9a008;
        color: #fff;
    }

    .pb-delete {
        background: #fff0f0;
        color: #b42332;
    }

    .pb-delete:hover {
        background: #b42332;
        color: #fff;
    }

    /* Empty state */
    .pb-empty {
        padding: 42px 20px !important;
        text-align: center;
    }

    .pb-empty-icon {
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

    .pb-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: 14px;
        font-weight: 800;
    }

    .pb-empty p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    /* Pagination */
    .pb-pagination {
        padding: 18px 23px;
        border-top: 1px solid #e8edf4;
    }

    .pb-pagination nav svg {
        width: 16px;
        height: 16px;
    }

    .pb-pagination nav a,
    .pb-pagination nav span {
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .pb-heading {
            align-items: flex-start;
        }

        .pb-heading h2 {
            font-size: 25px;
        }

        .pb-filters {
            padding: 16px;
        }

        .pb-search {
            flex-basis: 100%;
            min-width: 0;
        }

        .pb-filters > .pb-btn {
            flex: 1;
        }

        .pb-table th,
        .pb-table td {
            padding: 14px;
        }

        .pb-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="pb-page">

    {{-- HEADING --}}
    <div class="pb-heading">
        <div>
            <h2>Data Pembelian</h2>
            <p>Kelola pembelian barang dari supplier ELECTROMART.</p>
        </div>

        <a href="{{ route('admin.pembelian.create') }}"
           class="pb-btn pb-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Pembelian
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="pb-alert pb-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="pb-alert pb-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDASI --}}
    @if($errors->any())
        <div class="pb-alert pb-error">
            <strong>Terjadi kesalahan:</strong>

            <ul style="margin:8px 0 0;padding-left:20px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FILTER PEMBELIAN --}}
    <div class="pb-card">
        <form action="{{ route('admin.pembelian.index') }}"
              method="GET"
              class="pb-filters">

            <input
                type="text"
                name="search"
                class="pb-input pb-search"
                placeholder="Cari nomor pembelian atau supplier..."
                value="{{ request('search') }}"
            >

            <select name="status" class="pb-input">
                <option value="">Semua Status</option>

                <option value="dipesan"
                    {{ request('status') === 'dipesan' ? 'selected' : '' }}>
                    Dipesan
                </option>

                <option value="diterima"
                    {{ request('status') === 'diterima' ? 'selected' : '' }}>
                    Diterima
                </option>

                <option value="dibatalkan"
                    {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>
                    Dibatalkan
                </option>
            </select>

            <button type="submit" class="pb-btn pb-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.pembelian.index') }}"
               class="pb-btn pb-secondary">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>
    </div>

    {{-- TABEL PEMBELIAN --}}
    <div class="pb-card">
        <div class="pb-card-header">
            <h3>Daftar Pembelian</h3>
            <p>Informasi transaksi pembelian barang dari supplier.</p>
        </div>

        <div class="pb-table-wrap">
            <table class="pb-table">
                <thead>
                    <tr>
                        <th>No. Pembelian</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Jumlah Jenis Produk</th>
                        <th>Total Pembelian</th>
                        <th>Status</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pembelian as $item)
                        <tr>
                            <td>
                                <span class="pb-id">
                                    #PB-{{ $item->id_pembelian }}
                                </span>
                            </td>

                            <td>
                                {{ $item->tanggal_pembelian
                                    ? \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d/m/Y H:i')
                                    : '-' }}
                            </td>

                            <td>
                                {{ $item->supplier->nama_supplier ?? 'Supplier tidak ditemukan' }}
                            </td>

                            <td>
                                {{ $item->detail_pembelian_count ?? $item->detailPembelian->count() }}
                                jenis
                            </td>

                            <td>
                                <span class="pb-total">
                                    Rp {{ number_format((float) $item->total_pembelian, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                @if($item->status_pembelian === 'dipesan')
                                    <span class="pb-status pb-ordered">
                                        Dipesan
                                    </span>
                                @elseif($item->status_pembelian === 'diterima')
                                    <span class="pb-status pb-received">
                                        Diterima
                                    </span>
                                @else
                                    <span class="pb-status pb-cancelled">
                                        Dibatalkan
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="pb-actions">

                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('admin.pembelian.show', $item->id_pembelian) }}"
                                        class="pb-action pb-detail"
                                        title="Detail pembelian"
                                        aria-label="Detail pembelian"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    @if($item->status_pembelian === 'dipesan')

                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('admin.pembelian.edit', $item->id_pembelian) }}"
                                            class="pb-action pb-edit"
                                            title="Ubah status pembelian"
                                            aria-label="Ubah status pembelian"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('admin.pembelian.destroy', $item->id_pembelian) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus pembelian ini beserta detailnya?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="pb-action pb-delete"
                                                title="Hapus pembelian"
                                                aria-label="Hapus pembelian"
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
                            <td colspan="7" class="pb-empty">
                                <div class="pb-empty-icon">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>

                                <strong>Belum ada data pembelian</strong>

                                <p>
                                    Data pembelian akan tampil setelah kamu menambahkannya.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($pembelian->hasPages())
            <div class="pb-pagination">
                {{ $pembelian->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
