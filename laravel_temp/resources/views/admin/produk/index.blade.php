@extends('admin.layouts.app')

@section('title', 'Manajemen Produk')
@section('breadcrumb', 'Produk')

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
    .subtitle { margin-top:8px; color:#788397; }

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
        margin-bottom:20px;
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
    .small { font-size:11px; color:#8792a4; margin-top:4px; }

    .filters {
        display:flex;
        gap:10px;
        flex-wrap:wrap;
        padding:18px 23px;
        border-bottom:1px solid #e8edf4;
    }

    .filters input { flex:1; min-width:180px; }
    .filters select { min-width:160px; }

    input,select,textarea {
        font:inherit;
        border:1px solid #dfe5ee;
        border-radius:9px;
        padding:11px 12px;
        background:white;
        color:#182230;
        outline:none;
        width:100%;
    }

    input:focus,select:focus,textarea:focus {
        border-color:#246bfd;
        box-shadow:0 0 0 3px #246bfd16;
    }

    .filters input,.filters select { width:auto; }

    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; white-space:nowrap; }

    th {
        background:#fafbfd;
        padding:14px 18px;
        color:#788397;
        font-size:11px;
        text-align:left;
        text-transform:uppercase;
        letter-spacing:.5px;
    }

    td { padding:15px 18px; border-top:1px solid #f0f2f6; }
    tbody tr:hover { background:#fafcff; }

    .product-cell {
        display:flex;
        align-items:center;
        gap:12px;
        white-space:normal;
        min-width:220px;
    }

    .product-image {
        width:48px;
        height:48px;
        object-fit:cover;
        border-radius:10px;
        background:#f0f4fa;
        flex-shrink:0;
    }

    .product-name { font-weight:700; color:#202c40; }

    .pill {
        display:inline-block;
        padding:6px 9px;
        border-radius:7px;
        background:#f0f2f6;
        color:#596579;
        font-size:11px;
        font-weight:700;
    }

    .pill-green { background:#e8f8ef; color:#13784e; }
    .pill-red { background:#fff0f0; color:#b42332; }

    .actions { display:flex; gap:7px; align-items:center; }

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

    .empty { padding:40px 20px; text-align:center; color:#788397; }
    .pagination { padding:18px 23px; }
    .pagination nav > div:first-child { margin-bottom:10px; }
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

    @media(max-width:768px) {
        .heading { align-items:flex-start; flex-direction:column; }
        h1 { font-size:25px; }
        .panel-head,.filters { padding:16px; }
    }
</style>
@endpush

@section('content')
    <div class="heading">
        <div>
            <h1>Manajemen Produk</h1>
            <div class="subtitle">Kelola katalog produk elektronik ELECTROMART.</div>
        </div>

        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>

    <section class="panel">
        <div class="panel-head">
            <div>
                <h2 class="panel-title">Daftar Produk</h2>
                <div class="small">Data produk dari database ELECTROMART.</div>
            </div>
            <span class="pill">{{ $produks->total() }} produk</span>
        </div>

        <form method="GET" action="{{ route('admin.produk.index') }}" class="filters">
            <input type="text" name="cari" value="{{ request('cari') }}"
                   placeholder="Cari nama atau ID produk...">

            <select name="kategori">
                <option value="">Semua kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}"
                        @selected((string) request('kategori') === (string) $kategori->id_kategori)>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>

            <a href="{{ route('admin.produk.index') }}" class="btn btn-light">Reset</a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Brand</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produks as $produk)
                        @php
                            $status = strtolower((string) $produk->status_produk);
                        @endphp
                        <tr>
                            <td>#{{ $produk->id_produk }}</td>
                            <td>
                                <div class="product-cell">
                                    @if($produk->gambar)
                                        <img class="product-image"
                                             src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($produk->gambar) }}"
                                             alt="{{ $produk->nama_produk }}">
                                    @else
                                        <div class="product-image" style="display:grid;place-items:center;color:#98a2b3">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="product-name">{{ $produk->nama_produk }}</div>
                                        <div class="small">ID produk: {{ $produk->id_produk }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $produk->brand->nama_brand ?? '-' }}</td>
                            <td style="font-weight:700">
                                Rp {{ number_format($produk->harga_jual,0,',','.') }}
                            </td>
                            <td>
                                @if($produk->stok)
                                    <span class="pill {{ $produk->stok->jumlah_stok <= $produk->stok->stok_minimum ? 'pill-red' : 'pill-green' }}">
                                        {{ $produk->stok->jumlah_stok }}
                                    </span>
                                @else
                                    <span class="pill">Belum diatur</span>
                                @endif
                            </td>
                            <td>
                                <span class="pill {{ in_array($status,['aktif','active','tersedia']) ? 'pill-green' : (in_array($status,['nonaktif','inactive']) ? 'pill-red' : '') }}">
                                    {{ $produk->status_produk ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="icon-btn edit-btn"
                                       href="{{ route('admin.produk.edit', $produk->id_produk) }}"
                                       title="Edit produk">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.produk.destroy', $produk->id_produk) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="icon-btn delete-btn" type="submit" title="Hapus produk">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty">
                                    <i class="fa-solid fa-box-open" style="font-size:30px;margin-bottom:12px"></i>
                                    <div><strong>Belum ada produk</strong></div>
                                    <p>Tambahkan produk pertama ELECTROMART melalui tombol di atas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $produks->links() }}</div>
    </section>
@endsection
