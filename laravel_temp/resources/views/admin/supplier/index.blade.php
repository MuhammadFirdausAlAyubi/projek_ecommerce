
@extends('admin.layouts.app')

@section('title', 'Master Supplier')
@section('breadcrumb', 'Supplier')

@push('styles')
<style>
    .supplier-page {
        color: #182230;
    }

    /* Heading */
    .supplier-heading {
        margin-bottom: 25px;
    }

    .supplier-heading h2 {
        margin: 0;
        font-size: 29px;
        font-weight: 700;
        letter-spacing: -.7px;
        color: #182230;
    }

    .supplier-heading p {
        margin: 8px 0 0;
        color: #788397;
        font-size: 14px;
    }

    /* Panel */
    .supplier-card {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
    }

    .supplier-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .supplier-card-header h3 {
        margin: 0;
        color: #202c40;
        font-size: 16px;
        font-weight: 800;
    }

    .supplier-card-header p {
        margin: 5px 0 0;
        color: #788397;
        font-size: 11px;
    }

    /* General buttons */
    .supplier-btn {
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
        cursor: pointer;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s, color .2s;
    }

    .supplier-btn-primary {
        background: #246bfd;
        color: #fff;
    }

    .supplier-btn-primary:hover {
        background: #1558df;
        color: #fff;
    }

    .supplier-btn-light {
        background: #f0f4fa;
        color: #344054;
    }

    .supplier-btn-light:hover {
        background: #e5ebf4;
        color: #182230;
    }

    /* Search */
    .supplier-search {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .supplier-search-field {
        position: relative;
        flex: 1;
        min-width: 220px;
    }

    .supplier-search-field i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #98a2b3;
        pointer-events: none;
    }

    .supplier-input {
        width: 100%;
        min-height: 42px;
        padding: 10px 13px;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        background: #fff;
        color: #182230;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .supplier-search-field .supplier-input {
        padding-left: 40px;
    }

    .supplier-input:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px rgba(36, 107, 253, .1);
    }

    /* Table */
    .supplier-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .supplier-table {
        width: 100%;
        min-width: 760px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .supplier-table thead th {
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

    .supplier-table tbody td {
        padding: 16px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #536176;
        vertical-align: middle;
    }

    .supplier-table tbody tr:last-child td {
        border-bottom: none;
    }

    .supplier-table tbody tr:hover {
        background: #fafcff;
    }

    .supplier-id {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        min-height: 28px;
        padding: 4px 9px;
        border-radius: 7px;
        background: #edf4ff;
        color: #246bfd;
        font-size: 12px;
        font-weight: 800;
    }

    .supplier-name {
        color: #202c40 !important;
        font-weight: 700;
    }

    .supplier-email {
        overflow-wrap: anywhere;
    }

    /* Action icons: same size as Kategori */
    .supplier-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .supplier-actions form {
        margin: 0;
    }

    .supplier-btn-sm {
        width: 34px;
        height: 34px;
        min-height: 34px;
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

    .supplier-btn-edit {
        background: #edf4ff;
        color: #246bfd;
    }

    .supplier-btn-edit:hover {
        background: #246bfd;
        color: #fff;
    }

    .supplier-btn-delete {
        background: #fff0f0;
        color: #b42332;
    }

    .supplier-btn-delete:hover {
        background: #b42332;
        color: #fff;
    }

    /* Empty state */
    .supplier-empty {
        padding: 42px 20px !important;
        text-align: center;
    }

    .supplier-empty-icon {
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

    .supplier-empty h4 {
        margin: 0 0 6px;
        color: #344054;
        font-size: 14px;
        font-weight: 800;
    }

    .supplier-empty p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    /* Alerts */
    .supplier-alert {
        margin-bottom: 18px;
        padding: 13px 16px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
    }

    .supplier-alert-success {
        color: #067647;
        background: #ecfdf3;
        border-color: #abefc6;
    }

    .supplier-alert-error {
        color: #b42318;
        background: #fef3f2;
        border-color: #fecdca;
    }

    /* Pagination */
    .supplier-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        padding: 18px 23px;
        border-top: 1px solid #e8edf4;
    }

    .supplier-pagination-info {
        color: #788397;
        font-size: 12px;
    }

    .supplier-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .supplier-pagination nav p {
        margin: 0;
    }

    .supplier-pagination nav svg {
        width: 16px;
        height: 16px;
    }

    .supplier-pagination nav a,
    .supplier-pagination nav span {
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .supplier-heading h2 {
            font-size: 25px;
        }

        .supplier-card-header,
        .supplier-search {
            padding: 16px;
        }

        .supplier-card-header {
            align-items: flex-start;
        }

        .supplier-search-field {
            flex-basis: 100%;
            min-width: 0;
        }

        .supplier-search > .supplier-btn {
            flex: 1;
        }

        .supplier-table th,
        .supplier-table td {
            padding: 14px;
        }

        .supplier-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="supplier-page">

    {{-- HEADING --}}
    <div class="supplier-heading">
        <h2>Master Supplier</h2>
        <p>Kelola informasi pemasok dan mitra pengadaan produk ELECTROMART.</p>
    </div>

    {{-- NOTIFIKASI BERHASIL --}}
    @if(session('success'))
        <div class="supplier-alert supplier-alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if(session('error'))
        <div class="supplier-alert supplier-alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDASI FORM --}}
    @if($errors->any())
        <div class="supplier-alert supplier-alert-error">
            <strong>Periksa kembali data yang dimasukkan:</strong>

            <ul style="margin:8px 0 0;padding-left:20px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PANEL DAFTAR SUPPLIER --}}
    <div class="supplier-card">

        <div class="supplier-card-header">
            <div>
                <h3>Daftar Supplier</h3>
                <p>Informasi supplier yang terdaftar dalam sistem.</p>
            </div>

            <a href="{{ route('admin.supplier.create') }}"
               class="supplier-btn supplier-btn-primary">
                <i class="fa-solid fa-plus"></i>
                Tambah Supplier
            </a>
        </div>

        {{-- PENCARIAN --}}
        <form action="{{ route('admin.supplier.index') }}"
              method="GET"
              class="supplier-search">

            <div class="supplier-search-field">
                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="cari"
                    class="supplier-input"
                    placeholder="Cari nama, email, telepon, atau ID supplier..."
                    value="{{ request('cari') }}"
                >
            </div>

            <button type="submit"
                    class="supplier-btn supplier-btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            @if(request()->filled('cari'))
                <a href="{{ route('admin.supplier.index') }}"
                   class="supplier-btn supplier-btn-light">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>
            @endif
        </form>

        {{-- TABEL SUPPLIER --}}
        <div class="supplier-table-wrap">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($supplier as $item)
                        <tr>
                            <td>
                                <span class="supplier-id">
                                    #{{ $item->id_supplier }}
                                </span>
                            </td>

                            <td class="supplier-name">
                                {{ $item->nama_supplier }}
                            </td>

                            <td>
                                {{ $item->alamat_supplier ?: '—' }}
                            </td>

                            <td>
                                {{ $item->no_telp ?: '—' }}
                            </td>

                            <td class="supplier-email">
                                {{ $item->email ?: '—' }}
                            </td>

                            <td>
                                <div class="supplier-actions">

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.supplier.edit', $item->id_supplier) }}"
                                       class="supplier-btn-sm supplier-btn-edit"
                                       title="Edit supplier"
                                       aria-label="Edit supplier">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('admin.supplier.destroy', $item->id_supplier) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus supplier ini? Tindakan ini tidak dapat dibatalkan.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="supplier-btn-sm supplier-btn-delete"
                                            title="Hapus supplier"
                                            aria-label="Hapus supplier"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="supplier-empty">
                                <div class="supplier-empty-icon">
                                    <i class="fa-solid fa-truck-field"></i>
                                </div>

                                <h4>
                                    {{ request()->filled('cari')
                                        ? 'Supplier tidak ditemukan'
                                        : 'Belum ada data supplier' }}
                                </h4>

                                <p>
                                    {{ request()->filled('cari')
                                        ? 'Coba gunakan kata kunci pencarian yang lain.'
                                        : 'Mulai dengan menambahkan supplier pertama ke sistem.' }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($supplier->hasPages() || $supplier->total() > 0)
            <div class="supplier-pagination">

                <div class="supplier-pagination-info">
                    Menampilkan {{ $supplier->firstItem() ?? 0 }}
                    – {{ $supplier->lastItem() ?? 0 }}
                    dari {{ $supplier->total() }} supplier
                </div>

                <div>
                    {{ $supplier->appends(request()->query())->links() }}
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
