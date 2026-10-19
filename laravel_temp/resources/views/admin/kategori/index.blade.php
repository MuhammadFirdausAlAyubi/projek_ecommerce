@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori')
@section('breadcrumb', 'Kategori')

@push('styles')
<style>
    .heading {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:15px;
        margin-bottom:25px;
    }

    h1 { font-size:29px; margin:0; letter-spacing:-.7px; }
    .subtitle { color:#788397; margin-top:8px; }

    .btn {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        border:0;
        border-radius:9px;
        padding:11px 15px;
        font-weight:700;
        cursor:pointer;
        font-size:13px;
    }

    .btn-primary { background:#246bfd; color:white; }
    .btn-primary:hover { background:#1557df; }
    .btn-light { background:#f0f4fa; color:#344054; }
    .btn-danger { background:#fff0f0; color:#b42332; }

    .panel {
        background:white;
        border:1px solid #e8edf4;
        border-radius:15px;
        overflow:hidden;
    }

    .panel-head {
        padding:20px 23px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:15px;
        border-bottom:1px solid #e8edf4;
    }

    .panel-title { margin:0; font-weight:800; font-size:16px; }
    .small { font-size:11px; color:#8792a4; margin-top:5px; }

    .filters {
        display:flex;
        gap:10px;
        padding:18px 23px;
        border-bottom:1px solid #e8edf4;
    }

    .filters input {
        flex:1;
        min-width:0;
    }

    input {
        font:inherit;
        border:1px solid #dfe5ee;
        border-radius:9px;
        padding:11px 12px;
        background:white;
        color:#182230;
        outline:none;
    }

    input:focus {
        border-color:#246bfd;
        box-shadow:0 0 0 3px #246bfd16;
    }

    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }

    th {
        background:#fafbfd;
        padding:14px 18px;
        color:#788397;
        font-size:11px;
        text-align:left;
        text-transform:uppercase;
        letter-spacing:.5px;
        white-space:nowrap;
    }

    td {
        padding:16px 18px;
        border-top:1px solid #f0f2f6;
        vertical-align:middle;
    }

    tbody tr:hover { background:#fafcff; }

    .category-name { font-weight:700; color:#202c40; }
    .description {
        color:#667085;
        max-width:380px;
        line-height:1.5;
        overflow-wrap:anywhere;
    }

    .count-pill {
        display:inline-block;
        padding:6px 10px;
        border-radius:7px;
        background:#edf4ff;
        color:#246bfd;
        font-size:12px;
        font-weight:700;
    }

    .actions { display:flex; align-items:center; gap:7px; }

    .icon-btn {
        width:34px;
        height:34px;
        border:0;
        display:grid;
        place-items:center;
        border-radius:8px;
        cursor:pointer;
    }

    .edit-btn { background:#edf4ff; color:#246bfd; }
    .delete-btn { background:#fff0f0; color:#b42332; }

    .empty {
        padding:40px 20px;
        text-align:center;
        color:#788397;
    }

    .pagination { padding:18px 23px; }

    .pagination nav > div:last-child {
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
    }

    .pagination a,
    .pagination span[aria-current] span {
        display:inline-block;
        padding:8px 12px;
        border:1px solid #e8edf4;
        border-radius:7px;
        margin:2px;
        color:#344054;
    }

    .pagination span[aria-current] span {
        background:#246bfd;
        color:white;
    }

    @media(max-width:650px) {
        .heading { align-items:flex-start; flex-direction:column; }
        h1 { font-size:25px; }
        .panel-head,.filters { padding:16px; }
    }
</style>
@endpush

@section('content')
    <div class="heading">
        <div>
            <h1>Manajemen Kategori</h1>
            <div class="subtitle">Kelola kategori produk ELECTROMART.</div>
        </div>

        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </a>
    </div>

    <section class="panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Daftar Kategori</h2>
                <div class="small">Kategori yang digunakan untuk mengelompokkan produk.</div>
            </div>
            <span class="count-pill">{{ $kategoris->total() }} kategori</span>
        </div>

        <form method="GET" action="{{ route('admin.kategori.index') }}" class="filters">
            <input type="text" name="cari"
                   value="{{ request('cari') }}"
                   placeholder="Cari nama atau ID kategori...">

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>

            <a href="{{ route('admin.kategori.index') }}" class="btn btn-light">
                Reset
            </a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($kategoris as $kategori)
                        <tr>
                            <td>#{{ $kategori->id_kategori }}</td>

                            <td>
                                <div class="category-name">
                                    {{ $kategori->nama_kategori }}
                                </div>
                            </td>

                            <td>
                                <div class="description">
                                    {{ $kategori->deskripsi ?: 'Belum ada deskripsi' }}
                                </div>
                            </td>

                            <td>
                                <span class="count-pill">
                                    {{ $kategori->produk_count }} produk
                                </span>
                            </td>

                            <td>
                                <div class="actions">
                                    <a class="icon-btn edit-btn"
                                       href="{{ route('admin.kategori.edit', $kategori->id_kategori) }}"
                                       title="Edit kategori">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori {{ $kategori->nama_kategori }}?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="icon-btn delete-btn"
                                                type="submit"
                                                title="Hapus kategori">
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
                                    <i class="fa-solid fa-layer-group"
                                       style="font-size:32px;margin-bottom:12px"></i>
                                    <div><strong>Belum ada kategori</strong></div>
                                    <p>Tambahkan kategori pertama untuk mulai mengelompokkan produk.</p>
                                    <a href="{{ route('admin.kategori.create') }}"
                                       style="color:#246bfd;font-weight:700">
                                        Tambah kategori sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $kategoris->links() }}</div>
    </section>
@endsection
