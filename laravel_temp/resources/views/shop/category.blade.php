
@extends('layouts.customer')

@section('title', $category . ' | ELECTROMART')

@push('styles')
.category-page {
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

.category-heading {
    margin-bottom: 26px;
}

.category-heading h1 {
    font-size: 28px;
    margin: 0 0 8px;
    color: #222;
}

.category-heading p {
    color: #777;
    margin: 0;
    font-size: 14px;
}

.category-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    font-size: 14px;
    color: #666;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 20px;
}

.category-product {
    min-width: 0;
    background: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 10px;
    overflow: hidden;
    transition: transform .2s, box-shadow .2s;
}

.category-product:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
}

.category-product-image {
    height: 210px;
    background: #f7f7f7;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    overflow: hidden;
}

.category-product-image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.category-image-placeholder {
    color: #999;
    font-size: 13px;
    text-align: center;
}

.category-product-info {
    padding: 16px;
}

.category-brand {
    font-size: 12px;
    color: #888;
    margin-bottom: 7px;
}

.category-product-name {
    font-size: 15px;
    line-height: 1.5;
    color: #292929;
    margin: 0 0 12px;
    min-height: 45px;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.category-product-price {
    color: #e53935;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
    overflow-wrap: anywhere;
}

.category-product-stock {
    font-size: 12px;
    color: #777;
}

.category-empty {
    padding: 55px 20px;
    text-align: center;
    background: #fafafa;
    border-radius: 10px;
    color: #777;
}

.category-empty h3 {
    color: #333;
    margin-bottom: 8px;
}

.category-empty a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 18px;
    background: #155eef;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
}

.category-pagination {
    margin-top: 30px;
}

@media (max-width: 1000px) {
    .category-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
    }
}

@media (max-width: 700px) {
    .category-page {
        padding: 22px 14px 40px;
    }

    .category-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .category-product-image {
        height: 160px;
        padding: 10px;
    }

    .category-product-info {
        padding: 12px;
    }

    .category-heading h1 {
        font-size: 23px;
    }

    .category-product-price {
        font-size: 16px;
    }

    .category-toolbar {
        font-size: 12px;
    }
}

@media (max-width: 380px) {
    .category-grid {
        grid-template-columns: 1fr;
    }
}
@endpush

@section('content')
<div class="category-page">

    {{-- BREADCRUMB --}}
    <div class="category-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span> / </span>
        <span>{{ $category }}</span>
    </div>

    {{-- JUDUL KATEGORI --}}
    <div class="category-heading">
        <h1>{{ $category }}</h1>
        <p>
            Temukan produk {{ strtolower($category) }} pilihan di ELECTROMART.
        </p>
    </div>

    {{-- JUMLAH PRODUK --}}
    <div class="category-toolbar">
        <span>{{ $produks->total() }} produk ditemukan</span>

        <span>
            Halaman {{ $produks->currentPage() }}
            dari {{ max(1, $produks->lastPage()) }}
        </span>
    </div>

    {{-- DAFTAR PRODUK --}}
    @if ($produks->count() > 0)
        <div class="category-grid">
            @foreach ($produks as $produk)
                <article class="category-product">

                    {{-- GAMBAR --}}
                    <div class="category-product-image">
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
                                class="category-image-placeholder"
                                style="display:none;"
                            >
                                Gambar tidak tersedia
                            </div>
                        @else
                            <div class="category-image-placeholder">
                                Gambar belum tersedia
                            </div>
                        @endif
                    </div>

                    {{-- INFORMASI PRODUK --}}
                    <div class="category-product-info">

                        <div class="category-brand">
                            {{ $produk->brand->nama_brand ?? 'ELECTROMART' }}
                        </div>

                        <h2 class="category-product-name">
                            {{ $produk->nama_produk }}
                        </h2>

                        <div class="category-product-price">
                            Rp {{ number_format((float) $produk->harga_jual, 0, ',', '.') }}
                        </div>

                        <div class="category-product-stock">
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
        <div class="category-pagination">
            {{ $produks->links() }}
        </div>

    @else
        {{-- KALAU KATEGORI BELUM ADA PRODUK --}}
        <div class="category-empty">
            <h3>Belum ada produk {{ $category }}</h3>

            <p>
                Produk kategori ini belum ditemukan di database.
                Produk akan tampil setelah tersedia di database.
            </p>

            <a href="{{ route('shop.index') }}">
                Lihat Semua Produk
            </a>
        </div>
    @endif

</div>
@endsection
