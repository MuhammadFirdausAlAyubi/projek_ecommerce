
@extends('admin.layouts.app')

@section('title', 'Ulasan Produk')
@section('breadcrumb', 'Ulasan Produk')

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
        color: #182230;
    }

    .subtitle {
        color: #788397;
        margin-top: 8px;
        font-size: 14px;
    }

    .review-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .review-stat {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 22px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
    }

    .review-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        font-size: 20px;
    }

    .review-stat-icon.blue {
        color: #246bfd;
        background: #edf4ff;
    }

    .review-stat-icon.yellow {
        color: #d99000;
        background: #fff6df;
    }

    .review-stat-icon.green {
        color: #079455;
        background: #e8f8ef;
    }

    .review-stat-label {
        margin-bottom: 5px;
        color: #788397;
        font-size: 12px;
    }

    .review-stat-value {
        color: #182230;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.2;
    }

    .panel {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
    }

    .panel-head {
        padding: 20px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .panel-title {
        margin: 0;
        color: #202c40;
        font-size: 16px;
        font-weight: 800;
    }

    .small {
        margin-top: 5px;
        color: #8792a4;
        font-size: 11px;
    }

    .filters {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .review-input {
        padding: 11px 12px;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        background: #fff;
        color: #182230;
        font: inherit;
        font-size: 13px;
        outline: none;
    }

    .review-search {
        flex: 1;
        min-width: 180px;
    }

    .review-rating-filter {
        width: 180px;
    }

    .review-input:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd16;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 15px;
        border: 0;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-primary {
        background: #246bfd;
        color: #fff;
    }

    .btn-primary:hover {
        background: #1557df;
        color: #fff;
    }

    .btn-light {
        background: #f0f4fa;
        color: #344054;
    }

    .btn-light:hover {
        background: #e5ebf4;
        color: #182230;
    }

    .review-alert {
        margin-bottom: 18px;
        padding: 13px 16px;
        border-radius: 9px;
        font-size: 13px;
    }

    .review-alert-success {
        color: #067647;
        background: #ecfdf3;
        border: 1px solid #abefc6;
    }

    .review-alert-danger {
        color: #b42318;
        background: #fef3f2;
        border: 1px solid #fecdca;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .review-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .review-table th {
        background: #fafbfd;
        padding: 14px 18px;
        color: #788397;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .review-table td {
        padding: 16px 18px;
        border-top: 1px solid #f0f2f6;
        vertical-align: middle;
        color: #475467;
    }

    .review-table tbody tr:hover {
        background: #fafcff;
    }

    .review-number {
        color: #8792a4;
        white-space: nowrap;
    }

    .review-customer {
        min-width: 155px;
    }

    .review-customer strong {
        display: block;
        margin-bottom: 5px;
        color: #202c40;
        font-size: 13px;
    }

    .review-email {
        color: #8792a4;
        font-size: 11px;
        overflow-wrap: anywhere;
    }

    .review-product {
        min-width: 150px;
        color: #202c40;
        font-weight: 700;
    }

    .review-stars {
        color: #f4b400;
        white-space: nowrap;
        letter-spacing: 1px;
    }

    .review-rating-number {
        display: block;
        margin-top: 5px;
        color: #667085;
        font-size: 11px;
    }

    .review-comment {
        min-width: 180px;
        max-width: 300px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .review-date {
        min-width: 125px;
        color: #667085;
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

    .delete-btn {
        background: #fff0f0;
        color: #b42332;
    }

    .delete-btn:hover {
        background: #b42332;
        color: #fff;
    }

    .review-empty {
        padding: 40px 20px !important;
        text-align: center;
        color: #788397 !important;
    }

    .review-empty i {
        display: block;
        margin-bottom: 12px;
        font-size: 32px;
    }

    .review-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: 14px;
    }

    .review-empty p {
        margin: 0;
        font-size: 13px;
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
        color: #fff;
    }

    @media (max-width: 900px) {
        .review-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .filters {
            flex-wrap: wrap;
        }

        .review-search {
            flex-basis: 100%;
        }
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

        .review-search,
        .review-rating-filter {
            width: 100%;
            min-width: 0;
            flex-basis: 100%;
        }

        .review-table th,
        .review-table td {
            padding: 14px;
        }
    }
</style>
@endpush

@section('content')

    {{-- JUDUL HALAMAN --}}
    <div class="heading">
        <div>
            <h1>Ulasan Produk</h1>
            <div class="subtitle">
                Pantau rating dan kelola ulasan pelanggan ELECTROMART.
            </div>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="review-alert review-alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="review-alert review-alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="review-stats">
        <div class="review-stat">
            <div class="review-stat-icon blue">
                <i class="fa-solid fa-comments"></i>
            </div>

            <div>
                <div class="review-stat-label">Total Ulasan</div>
                <div class="review-stat-value">
                    {{ number_format($totalUlasan ?? 0) }}
                </div>
            </div>
        </div>

        <div class="review-stat">
            <div class="review-stat-icon yellow">
                <i class="fa-solid fa-star"></i>
            </div>

            <div>
                <div class="review-stat-label">Rata-rata Rating</div>
                <div class="review-stat-value">
                    {{ number_format((float) ($rataRataRating ?? 0), 1) }}
                    <span style="font-size:13px;color:#98a2b3;">/ 5</span>
                </div>
            </div>
        </div>

        <div class="review-stat">
            <div class="review-stat-icon green">
                <i class="fa-solid fa-award"></i>
            </div>

            <div>
                <div class="review-stat-label">Rating Bintang 5</div>
                <div class="review-stat-value">
                    {{ number_format($totalBintangLima ?? 0) }}
                </div>
            </div>
        </div>
    </div>

    {{-- DAFTAR ULASAN --}}
    <section class="panel">
        <div class="panel-head">
            <h2 class="panel-title">Daftar Ulasan Pelanggan</h2>
            <div class="small">
                Kelola dan pantau ulasan produk dari pelanggan.
            </div>
        </div>

        {{-- PENCARIAN DAN FILTER --}}
        <form action="{{ route('admin.ulasan.index') }}"
              method="GET"
              class="filters">

            <input type="text"
                   name="q"
                   class="review-input review-search"
                   placeholder="Cari nama, email, produk, atau komentar..."
                   value="{{ request('q') }}">

            <select name="rating"
                    class="review-input review-rating-filter">
                <option value="">Semua Rating</option>

                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}"
                        {{ request('rating') == $i ? 'selected' : '' }}>
                        {{ $i }} Bintang
                    </option>
                @endfor
            </select>

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.ulasan.index') }}"
               class="btn btn-light">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>

        {{-- TABEL ULASAN --}}
        <div class="table-wrap">
            <table class="review-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Rating</th>
                        <th>Ulasan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ulasan as $item)
                        <tr>
                            <td class="review-number">
                                {{ $ulasan->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="review-customer">
                                    <strong>
                                        {{ $item->nama_pelanggan ?? 'Pelanggan' }}
                                    </strong>

                                    <span class="review-email">
                                        {{ $item->email_pelanggan ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <div class="review-product">
                                    {{ $item->nama_produk ?? 'Produk tidak ditemukan' }}
                                </div>
                            </td>

                            <td>
                                <div class="review-stars">
                                    @for($bintang = 1; $bintang <= 5; $bintang++)
                                        <i class="{{ $bintang <= (int) $item->rating
                                            ? 'fa-solid fa-star'
                                            : 'fa-regular fa-star' }}"></i>
                                    @endfor
                                </div>

                                <span class="review-rating-number">
                                    {{ $item->rating }}/5
                                </span>
                            </td>

                            <td>
                                <div class="review-comment">
                                    {{ $item->komentar ?: 'Tidak ada komentar.' }}
                                </div>
                            </td>

                            <td>
                                <div class="review-date">
                                    {{ $item->created_at
                                        ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i')
                                        : '-' }}
                                </div>
                            </td>

                            <td>
                                <div class="actions">
                                    <form
                                        action="{{ route('admin.ulasan.destroy', $item->id_ulasan) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus ulasan ini? Tindakan ini tidak dapat dibatalkan.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="icon-btn delete-btn"
                                            type="submit"
                                            title="Hapus ulasan"
                                            aria-label="Hapus ulasan"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="review-empty">
                                <i class="fa-regular fa-comment-dots"></i>
                                <strong>Belum ada ulasan</strong>
                                <p>
                                    Ulasan pelanggan akan ditampilkan di sini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($ulasan->hasPages())
            <div class="pagination">
                {{ $ulasan->links() }}
            </div>
        @endif
    </section>
@endsection
