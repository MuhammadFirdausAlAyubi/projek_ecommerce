
@extends('admin.layouts.app')

@section('title', 'Manajemen Brand')
@section('breadcrumb', 'Brand')

@push('styles')
<style>
    .heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .heading h1 {
        font-size: 29px;
        margin: 0;
        letter-spacing: -.7px;
        font-weight: 700;
    }

    .subtitle {
        color: #788397;
        margin-top: 8px;
        font-size: 14px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 9px;
        padding: 11px 15px;
        font-weight: 700;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-primary {
        background: #246bfd;
        color: white;
    }

    .btn-primary:hover {
        background: #1557df;
        color: white;
    }

    .btn-light {
        background: #f0f4fa;
        color: #344054;
    }

    .panel {
        background: white;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
    }

    .panel-head {
        padding: 20px 23px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        border-bottom: 1px solid #e8edf4;
    }

    .panel-title {
        margin: 0;
        font-weight: 800;
        font-size: 16px;
        color: #202c40;
    }

    .small {
        font-size: 11px;
        color: #8792a4;
        margin-top: 5px;
    }

    .filters {
        display: flex;
        gap: 10px;
        padding: 18px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .filters input {
        flex: 1;
        min-width: 0;
        font: inherit;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        padding: 11px 12px;
        background: white;
        color: #182230;
        outline: none;
        font-size: 13px;
    }

    .filters input:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd16;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .brand-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .brand-table th {
        background: #fafbfd;
        padding: 14px 18px;
        color: #788397;
        font-size: 11px;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .brand-table td {
        padding: 16px 18px;
        border-top: 1px solid #f0f2f6;
        vertical-align: middle;
        color: #475467;
    }

    .brand-table tbody tr:hover {
        background: #fafcff;
    }

    .brand-id {
        color: #788397;
        white-space: nowrap;
    }

    .brand-name {
        font-weight: 700;
        color: #202c40;
        min-width: 140px;
    }

    .brand-description {
        color: #667085;
        max-width: 350px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .count-pill {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 7px;
        background: #edf4ff;
        color: #246bfd;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .actions form {
        margin: 0;
    }

    .icon-btn {
        width: 34px;
        height: 34px;
        padding: 0;
        border: 0;
        display: grid;
        place-items: center;
        border-radius: 8px;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .edit-btn {
        background: #edf4ff;
        color: #246bfd;
    }

    .edit-btn:hover {
        background: #246bfd;
        color: white;
    }

    .delete-btn {
        background: #fff0f0;
        color: #b42332;
    }

    .delete-btn:hover {
        background: #b42332;
        color: white;
    }

    .empty {
        padding: 40px 20px;
        text-align: center;
        color: #788397;
    }

    .empty i {
        font-size: 32px;
        margin-bottom: 12px;
    }

    .pagination {
        padding: 18px 23px;
    }

    .pagination nav > div:last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination span[aria-current] span {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #e8edf4;
        border-radius: 7px;
        margin: 2px;
        color: #344054;
    }

    .pagination span[aria-current] span {
        background: #246bfd;
        color: white;
    }

    @media (max-width: 650px) {
        .heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .heading h1 {
            font-size: 25px;
        }

        .panel-head,
        .filters {
            padding: 16px;
        }

        .filters {
            flex-wrap: wrap;
        }

        .filters input {
            flex-basis: 100%;
        }

        .brand-table th,
        .brand-table td {
            padding: 14px;
        }
    }
</style>
@endpush

@section('content')
    <div class="heading">
        <div>
            <h1>Manajemen Brand</h1>
            <div class="subtitle">
                Kelola merek produk ELECTROMART.
            </div>
        </div>

        <a href="{{ route('admin.brand.create') }}"
           class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Brand
        </a>
    </div>

    <section class="panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Daftar Brand</h2>
                <div class="small">
                    Brand yang digunakan untuk mengelompokkan produk.
                </div>
            </div>

            <span class="count-pill">
                {{ $brands->total() }} brand
            </span>
        </div>

        <form method="GET"
              action="{{ route('admin.brand.index') }}"
              class="filters">

            <input type="text"
                   name="cari"
                   value="{{ request('cari') }}"
                   placeholder="Cari nama atau ID brand...">

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.brand.index') }}"
               class="btn btn-light">
                Reset
            </a>
        </form>

        <div class="table-wrap">
            <table class="brand-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Brand</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td class="brand-id">
                                #{{ $brand->id_brand }}
                            </td>

                            <td>
                                <div class="brand-name">
                                    {{ $brand->nama_brand }}
                                </div>
                            </td>

                            <td>
                                <div class="brand-description">
                                    {{ $brand->deskripsi ?: 'Belum ada deskripsi' }}
                                </div>
                            </td>

                            <td>
                                <span class="count-pill">
                                    {{ $brand->produk_count }} produk
                                </span>
                            </td>

                            <td>
                                <div class="actions">
                                    <a class="icon-btn edit-btn"
                                       href="{{ route('admin.brand.edit', $brand->id_brand) }}"
                                       title="Edit brand">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.brand.destroy', $brand->id_brand) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus brand {{ $brand->nama_brand }}?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="icon-btn delete-btn"
                                                type="submit"
                                                title="Hapus brand">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty">
                                    <i class="fa-solid fa-tags"></i>
                                    <div>
                                        <strong>Belum ada brand</strong>
                                    </div>
                                    <p>
                                        Tambahkan brand pertama untuk mulai
                                        mengelompokkan produk.
                                    </p>
                                    <a href="{{ route('admin.brand.create') }}"
                                       style="color:#246bfd;font-weight:700">
                                        Tambah brand sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $brands->links() }}
        </div>
    </section>
@endsection
