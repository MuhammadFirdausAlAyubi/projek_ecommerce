
@extends('layouts.customer')

@section('title', 'Semua Produk | ELECTROMART')

@push('styles')
.catalog-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 28px 20px 50px;
}

.category-breadcrumb {
    font-size: 13px;
    color: #777;
    margin-bottom: 18px;
}

.category-breadcrumb a {
    color: #555;
    text-decoration: none;
}

.category-breadcrumb a:hover {
    color: #155eef;
}

.catalog-heading {
    margin-bottom: 26px;
}

.catalog-heading h1 {
    margin: 0 0 8px;
    color: #222;
    font-size: 28px;
}

.catalog-heading p {
    margin: 0;
    color: #777;
    font-size: 14px;
}

.catalog-count {
    margin-bottom: 20px;
    color: #666;
    font-size: 14px;
}

.catalog-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 20px;
}

.catalog-card {
    min-width: 0;
    border: 1px solid #e9e9e9;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    transition: transform .2s, box-shadow .2s;
}

.catalog-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
}

.catalog-image {
    height: 210px;
    padding: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f7f7f7;
}

.catalog-image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.catalog-no-image {
    color: #999;
    font-size: 13px;
    text-align: center;
}

.catalog-info {
    padding: 16px;
}

.catalog-brand {
    color: #888;
    font-size: 12px;
    margin-bottom: 7px;
}

.catalog-name {
    color: #292929;
    font-size: 15px;
    line-height: 1.5;
    min-height: 45px;
    margin: 0 0 12px;
    overflow-wrap: anywhere;
}

.catalog-category {
    color: #777;
    font-size: 12px;
    margin-bottom: 8px;
}

.catalog-price {
    color: #e53935;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
    overflow-wrap: anywhere;
}

.catalog-stock {
    color: #777;
    font-size: 12px;
}

.catalog-empty {
    padding: 50px 20px;
    text-align: center;
    background: #fafafa;
    border-radius: 10px;
    color: #777;
}

.catalog-empty h3 {
    color: #333;
    margin-bottom: 8px;
}

.catalog-pagination {
    margin-top: 30px;
}

@media (max-width: 1000px) {
    .catalog-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
    }
}

@media (max-width: 700px) {
    .catalog-page {
        padding: 22px 14px 40px;
    }

    .catalog-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .catalog-image {
        height: 160px;
        padding: 10px;
    }

    .catalog-info {
        padding: 12px;
    }

    .catalog-heading h1 {
        font-size: 23px;
    }

    .catalog-price {
        font-size: 16px;
    }
}

@media (max-width: 380px) {
    .catalog-grid {
        grid-template-columns: 1fr;
    }
}
@endpush

@section('content')
<div class="catalog-page">

    {{-- BREADCRUMB --}}
    <div class="category-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span> / </span>
        <span>Semua Produk</span>
    </div>

    {{-- JUDUL KATALOG --}}
    <div class="catalog-heading">
        <h1>Semua Produk</h1>
        <p>
            Jelajahi koleksi produk elektronik ELECTROMART.
        </p>
    </div>

    {{-- JUMLAH PRODUK --}}
    <div class="catalog-count">
        {{ $produks->total() }} produk tersedia
    </div>

    {{-- DAFTAR PRODUK --}}
    @if ($produks->count() > 0)
        <div class="catalog-grid">
            @foreach ($produks as $produk)
                <article class="catalog-card">

                    {{-- GAMBAR --}}
                    <div class="catalog-image">
                        @if ($produk->gambar)
                            @php
                                $gambar = $produk->gambar;

                                if (!preg_match('/^https?:\/\//i', $gambar)) {
                                    $gambar = asset(
                                        'storage/' . ltrim($gambar, '/')
                                    );
                                }
                            @endphp

                            <img
                                src="{{ $gambar }}"
                                alt="{{ $produk->nama_produk }}"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                            >

                            <div
                                class="catalog-no-image"
                                style="display:none;"
                            >
                                Gambar tidak tersedia
                            </div>
                        @else
                            <div class="catalog-no-image">
                                Gambar belum tersedia
                            </div>
                        @endif
                    </div>

                    {{-- INFORMASI PRODUK --}}
                    <div class="catalog-info">

                        <div class="catalog-brand">
                            {{ $produk->brand->nama_brand ?? 'ELECTROMART' }}
                        </div>

                        <h2 class="catalog-name">
                            {{ $produk->nama_produk }}
                        </h2>

                        <div class="catalog-category">
                            {{ $produk->kategori->nama_kategori ?? 'Tanpa kategori' }}
                        </div>

                        <div class="catalog-price">
                            Rp {{ number_format((float) $produk->harga_jual, 0, ',', '.') }}
                        </div>

                        <div class="catalog-stock">
                            @if ($produk->stok)
                                Stok: {{ $produk->stok->jumlah_stok }}
                            @else
                                Stok belum tercatat
                            @endif
                        </div>

                    </div>
                </article>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div class="catalog-pagination">
            {{ $produks->links() }}
        </div>

    @else
        {{-- JIKA DATABASE KOSONG --}}
        <div class="catalog-empty">
            <h3>Belum ada produk</h3>
            <p>
                Produk akan tampil di sini setelah tersedia di database.
            </p>
        </div>
    @endif

</div>
@endsection
