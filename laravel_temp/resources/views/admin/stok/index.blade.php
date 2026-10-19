@extends('admin.layouts.app')

@section('title', 'Manajemen Stok')
@section('breadcrumb', 'Stok')

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

    .stock-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stock-stat {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        padding: 22px;
    }

    .stock-stat p {
        color: #788397;
        margin: 0 0 10px;
        font-size: 13px;
    }

    .stock-stat h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #202c40;
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
        flex-wrap: wrap;
    }

    .filters input,
    .filters select {
        font: inherit;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        padding: 11px 12px;
        background: white;
        color: #182230;
        outline: none;
        font-size: 13px;
    }

    .filters input {
        flex: 1;
        min-width: 200px;
    }

    .filters select {
        min-width: 180px;
    }

    .filters input:focus,
    .filters select:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd16;
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

    .btn-light:hover {
        background: #e2e8f0;
        color: #202c40;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .stock-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .stock-table th {
        background: #fafbfd;
        padding: 14px 18px;
        color: #788397;
        font-size: 11px;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .stock-table td {
        padding: 16px 18px;
        border-top: 1px solid #f0f2f6;
        vertical-align: middle;
        color: #475467;
    }

    .stock-table tbody tr:hover {
        background: #fafcff;
    }

    .product-name {
        min-width: 170px;
        font-weight: 700;
        color: #202c40;
    }

    .product-id {
        margin-top: 5px;
        color: #8792a4;
        font-size: 11px;
    }

    .stock-number {
        color: #202c40;
        font-weight: 700;
        white-space: nowrap;
    }

    .stock-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .stock-low {
        color: #b42332;
        background: #fff0f0;
    }

    .stock-safe {
        color: #067647;
        background: #ecfdf3;
    }

    .stock-empty {
        color: #fff;
        background: #dc2626;
    }

    .stock-date {
        min-width: 130px;
        color: #667085;
        white-space: nowrap;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 7px;
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
        text-decoration: none;
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

    @media (max-width: 700px) {
        .stock-stats {
            grid-template-columns: 1fr;
        }

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

        .filters input,
        .filters select {
            width: 100%;
            min-width: 0;
        }

        .stock-table th,
        .stock-table td {
            padding: 14px;
        }
    }
</style>
@endpush

@section('content')

    <div class="heading">
        <div>
            <h1>Manajemen Stok</h1>
            <div class="subtitle">
                Pantau dan perbarui persediaan produk ELECTROMART.
            </div>
        </div>
    </div>

    {{-- STATISTIK STOK --}}
    <div class="stock-stats">
        <div class="stock-stat">
            <p>Produk dengan Data Stok</p>
            <h2>{{ number_format($totalProduk) }}</h2>
        </div>

        <div class="stock-stat">
            <p>Total Unit Stok</p>
            <h2>{{ number_format($totalUnit) }}</h2>
        </div>

        <div class="stock-stat">
            <p>Stok Menipis</p>
            <h2 style="color:#dc2626;">
                {{ number_format($stokMenipis) }}
            </h2>
        </div>
    </div>

    {{-- DAFTAR STOK --}}
    <section class="panel">

        <div class="panel-head">
            <div>
                <h2 class="panel-title">Daftar Stok Produk</h2>
                <div class="small">
                    Pantau jumlah stok dan kondisi persediaan produk.
                </div>
            </div>
        </div>

        {{-- PENCARIAN DAN FILTER --}}
        <form
            action="{{ route('admin.stok.index') }}"
            method="GET"
            class="filters"
        >
            <input
                type="text"
                name="cari"
                placeholder="Cari nama atau ID produk..."
                value="{{ request('cari') }}"
            >

            {{-- FILTER KATEGORI --}}
            <select name="kategori">
                <option value="">Semua Kategori</option>

                @foreach ($kategoris as $kategori)
                    <option
                        value="{{ $kategori->id_kategori }}"
                        {{ (string) request('kategori') === (string) $kategori->id_kategori ? 'selected' : '' }}
                    >
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            {{-- FILTER KONDISI STOK --}}
            <select name="status">
                <option value="">Semua kondisi stok</option>

                <option
                    value="menipis"
                    {{ request('status') === 'menipis' ? 'selected' : '' }}
                >
                    Stok menipis
                </option>

                <option
                    value="aman"
                    {{ request('status') === 'aman' ? 'selected' : '' }}
                >
                    Stok aman
                </option>
            </select>

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Terapkan Filter
            </button>

            @if (request()->hasAny(['cari', 'kategori', 'status']))
                <a
                    href="{{ route('admin.stok.index') }}"
                    class="btn btn-light"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>
            @endif
        </form>

        {{-- TABEL STOK --}}
        <div class="table-wrap">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Brand</th>
                        <th>Jumlah Stok</th>
                        <th>Stok Minimum</th>
                        <th>Kondisi</th>
                        <th>Terakhir Diperbarui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($stoks as $stok)
                        <tr>
                            <td>
                                <div class="product-name">
                                    {{ $stok->nama_produk }}
                                </div>

                                <div class="product-id">
                                    ID: {{ $stok->id_produk }}
                                </div>
                            </td>

                            <td>
                                {{ $stok->nama_kategori ?? '-' }}
                            </td>

                            <td>
                                {{ $stok->nama_brand ?? '-' }}
                            </td>

                            <td>
                                <span class="stock-number">
                                    {{ number_format($stok->jumlah_stok) }}
                                </span>
                            </td>

                            <td>
                                {{ number_format($stok->stok_minimum) }}
                            </td>

                            <td>
                                @if ($stok->jumlah_stok <= 0)
                                    <span class="stock-badge stock-empty">
                                        Habis
                                    </span>
                                @elseif ($stok->jumlah_stok <= $stok->stok_minimum)
                                    <span class="stock-badge stock-low">
                                        Menipis
                                    </span>
                                @else
                                    <span class="stock-badge stock-safe">
                                        Aman
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="stock-date">
                                    @if ($stok->update_at)
                                        {{ \Carbon\Carbon::parse($stok->update_at)->format('d/m/Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('admin.stok.edit', $stok->id_stok) }}"
                                        class="icon-btn edit-btn"
                                        title="Edit stok"
                                        aria-label="Edit stok {{ $stok->nama_produk }}"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty">
                                    <i class="fa-solid fa-boxes-stacked"></i>

                                    <div>
                                        <strong>Data stok tidak ditemukan</strong>
                                    </div>

                                    <p>
                                        Coba ubah kata pencarian atau filter
                                        kategori dan kondisi stok.
                                    </p>

                                    @if (request()->hasAny(['cari', 'kategori', 'status']))
                                        <a
                                            href="{{ route('admin.stok.index') }}"
                                            class="btn btn-light"
                                        >
                                            Reset Filter
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pagination">
            {{ $stoks->links() }}
        </div>

    </section>

@endsection
