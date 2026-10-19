@extends('admin.layouts.app')

@section('title', 'Supplier Produk')
@section('breadcrumb', 'Supplier Produk')

@push('styles')
<style>
    .sp-page {
        color: #182230;
    }

    /* Heading */
    .sp-heading {
        margin-bottom: 25px;
    }

    .sp-heading h2 {
        margin: 0;
        font-size: 29px;
        font-weight: 700;
        letter-spacing: -.7px;
        color: #182230;
    }

    .sp-heading p {
        margin: 8px 0 0;
        color: #788397;
        font-size: 14px;
    }

    /* Panel */
    .sp-card {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
    }

    .sp-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .sp-card-header h3 {
        margin: 0;
        color: #202c40;
        font-size: 16px;
        font-weight: 800;
    }

    .sp-card-header p {
        margin: 5px 0 0;
        color: #788397;
        font-size: 11px;
    }

    /* Buttons */
    .sp-btn {
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

    .sp-primary {
        color: #fff;
        background: #246bfd;
    }

    .sp-primary:hover {
        color: #fff;
        background: #1558df;
    }

    .sp-light {
        color: #344054;
        background: #f0f4fa;
    }

    .sp-light:hover {
        background: #e5ebf4;
        color: #182230;
    }

    /* Search */
    .sp-search {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .sp-search input {
        flex: 1;
        min-width: 220px;
        padding: 11px 13px;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        background: #fff;
        color: #182230;
        outline: none;
        font-family: inherit;
        font-size: 13px;
    }

    .sp-search input:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px rgba(36, 107, 253, .1);
    }

    /* Table */
    .sp-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .sp-table {
        width: 100%;
        min-width: 780px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .sp-table th {
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

    .sp-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #536176;
        vertical-align: middle;
    }

    .sp-table tbody tr:last-child td {
        border-bottom: none;
    }

    .sp-table tbody tr:hover {
        background: #fafcff;
    }

    .sp-id {
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

    .sp-name {
        color: #202c40 !important;
        font-weight: 700;
    }

    .sp-price {
        color: #067647 !important;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Action icons: same as Kategori */
    .sp-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .sp-actions form {
        margin: 0;
    }

    .sp-small {
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

    .sp-edit {
        background: #edf4ff;
        color: #246bfd;
    }

    .sp-edit:hover {
        background: #246bfd;
        color: #fff;
    }

    .sp-delete {
        background: #fff0f0;
        color: #b42332;
    }

    .sp-delete:hover {
        background: #b42332;
        color: #fff;
    }

    /* Alerts */
    .sp-alert {
        padding: 13px 16px;
        margin-bottom: 18px;
        border-radius: 9px;
        font-size: 13px;
    }

    .sp-success {
        color: #067647;
        background: #ecfdf3;
        border: 1px solid #abefc6;
    }

    .sp-error {
        color: #b42318;
        background: #fef3f2;
        border: 1px solid #fecdca;
    }

    /* Empty state */
    .sp-empty {
        padding: 42px 20px !important;
        text-align: center;
    }

    .sp-empty-icon {
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

    .sp-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: 14px;
        font-weight: 800;
    }

    .sp-empty span {
        color: #788397;
        font-size: 13px;
    }

    /* Pagination */
    .sp-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        padding: 18px 23px;
        border-top: 1px solid #e8edf4;
        color: #788397;
        font-size: 12px;
    }

    .sp-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .sp-pagination nav svg {
        width: 16px;
        height: 16px;
    }

    .sp-pagination nav a,
    .sp-pagination nav span {
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .sp-heading h2 {
            font-size: 25px;
        }

        .sp-card-header,
        .sp-search {
            padding: 16px;
        }

        .sp-card-header {
            align-items: flex-start;
        }

        .sp-search input {
            min-width: 0;
            flex-basis: 100%;
        }

        .sp-search > .sp-btn {
            flex: 1;
        }

        .sp-table th,
        .sp-table td {
            padding: 14px;
        }

        .sp-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="sp-page">

    {{-- HEADING --}}
    <div class="sp-heading">
        <h2>Supplier Produk</h2>
        <p>Kelola hubungan pemasok dengan produk yang disediakan.</p>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="sp-alert sp-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="sp-alert sp-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDASI --}}
    @if($errors->any())
        <div class="sp-alert sp-error">
            <strong>Periksa kembali data:</strong>

            <ul style="margin:8px 0 0;padding-left:20px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PANEL UTAMA --}}
    <div class="sp-card">

        <div class="sp-card-header">
            <div>
                <h3>Daftar Supplier Produk</h3>
                <p>Data pemasok, produk, harga beli, dan waktu penyediaan.</p>
            </div>

            <a href="{{ route('admin.supplier-produk.create') }}"
               class="sp-btn sp-primary">
                <i class="fa-solid fa-plus"></i>
                Tambah Supplier Produk
            </a>
        </div>

        {{-- PENCARIAN --}}
        <form action="{{ route('admin.supplier-produk.index') }}"
              method="GET"
              class="sp-search">

            <input
                type="text"
                name="cari"
                value="{{ request('cari') }}"
                placeholder="Cari nama supplier, produk, atau ID..."
            >

            <button type="submit" class="sp-btn sp-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            @if(request()->filled('cari'))
                <a href="{{ route('admin.supplier-produk.index') }}"
                   class="sp-btn sp-light">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>
            @endif
        </form>

        {{-- TABEL --}}
        <div class="sp-table-wrap">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Supplier</th>
                        <th>Produk</th>
                        <th>Harga Beli</th>
                        <th>Waktu Penyediaan</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($supplierProduk as $item)
                        <tr>
                            <td>
                                <span class="sp-id">
                                    #{{ $item->id_supplier_produk }}
                                </span>
                            </td>

                            <td class="sp-name">
                                {{ $item->supplier->nama_supplier ?? 'Supplier tidak ditemukan' }}
                            </td>

                            <td class="sp-name">
                                {{ $item->produk->nama_produk ?? 'Produk tidak ditemukan' }}
                            </td>

                            <td class="sp-price">
                                Rp {{ number_format((float) $item->harga_beli, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->waktu_penyediaan }} hari
                            </td>

                            <td>
                                <div class="sp-actions">

                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.supplier-produk.edit', $item->id_supplier_produk) }}"
                                        class="sp-small sp-edit"
                                        title="Edit supplier produk"
                                        aria-label="Edit supplier produk"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('admin.supplier-produk.destroy', $item->id_supplier_produk) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus hubungan supplier dan produk ini? Tindakan ini tidak dapat dibatalkan.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="sp-small sp-delete"
                                            title="Hapus supplier produk"
                                            aria-label="Hapus supplier produk"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="sp-empty">
                                <div class="sp-empty-icon">
                                    <i class="fa-solid fa-link"></i>
                                </div>

                                <strong>Belum ada data supplier produk</strong>

                                <span>
                                    Tambahkan hubungan antara supplier dan produk untuk memulai.
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($supplierProduk->total() > 0)
            <div class="sp-pagination">

                <span>
                    Menampilkan {{ $supplierProduk->firstItem() ?? 0 }}
                    – {{ $supplierProduk->lastItem() ?? 0 }}
                    dari {{ $supplierProduk->total() }} data
                </span>

                <div>
                    {{ $supplierProduk->appends(request()->query())->links() }}
                </div>

            </div>
        @endif

    </div>
</div>
@endsection
