@extends('layouts.customer')

@section('content')

<style>
    .em-cart {
        --blue: #2563eb;
        --ink: #18243a;
        --muted: #748197;
        --line: #e8edf4;

        background: #f6f8fc;
        color: var(--ink);
        padding: 34px 0 45px;
        min-height: 65vh;
        font-family: inherit;
    }

    .em-cart *,
    .em-cart *::before,
    .em-cart *::after {
        box-sizing: border-box;
    }

    .em-cart-container {
        width: min(1200px, calc(100% - 40px));
        margin: 0 auto;
    }

    /* HEADER */
    .em-cart-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 22px;
    }

    .em-cart-kicker {
        margin-bottom: 6px;
        color: var(--blue);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.2px;
    }

    .em-cart-title {
        margin: 0;
        color: var(--ink);
        font-size: 29px;
        font-weight: 800;
        line-height: 1.35;
    }

    .em-cart-description {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .em-cart-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-shrink: 0;
        padding: 11px 15px;
        border: 1px solid #dce4ef;
        border-radius: 9px;
        background: #fff;
        color: #34445b;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .em-cart-back:hover {
        border-color: var(--blue);
        color: var(--blue);
    }

    /* ALERT */
    .em-cart-alert {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 15px;
        margin-bottom: 15px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
    }

    .em-cart-alert.success {
        border-color: #b7ebcb;
        background: #edfbf2;
        color: #137344;
    }

    .em-cart-alert.error {
        border-color: #ffd0cb;
        background: #fff2f0;
        color: #b42318;
    }

    .em-cart-alert button {
        border: 0;
        background: transparent;
        color: inherit;
        font-size: 20px;
        cursor: pointer;
    }

    /* LAYOUT */
    .em-cart-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 310px;
        align-items: start;
        gap: 20px;
    }

    .em-cart-main {
        min-width: 0;
    }

    .em-cart-card {
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 13px;
        background: #fff;
        box-shadow: 0 3px 12px rgba(23, 42, 75, .025);
    }

    .em-cart-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 20px;
        border-bottom: 1px solid var(--line);
    }

    .em-cart-section-title {
        margin: 0;
        color: var(--ink);
        font-size: 15px;
        font-weight: 800;
    }

    .em-cart-count {
        padding: 6px 9px;
        border-radius: 6px;
        background: #eef4ff;
        color: var(--blue);
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
    }

    /* PRODUK */
    .em-cart-product {
        display: grid;
        grid-template-columns: 94px minmax(0, 1fr);
        gap: 17px;
        padding: 19px 20px;
    }

    .em-cart-product + .em-cart-product {
        border-top: 1px solid var(--line);
    }

    .em-cart-image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 94px;
        height: 94px;
        overflow: hidden;
        border: 1px solid #edf0f5;
        border-radius: 9px;
        background: #fff;
    }

    .em-cart-image img {
        display: block;
        width: 100%;
        height: 100%;
        padding: 6px;
        object-fit: contain;
    }

    .em-cart-image-placeholder {
        padding: 5px;
        color: #a5b1c2;
        font-size: 10px;
        text-align: center;
    }

    .em-cart-product-info {
        min-width: 0;
    }

    .em-cart-product-top {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: start;
        gap: 15px;
    }

    .em-cart-product-name {
        margin: 0 0 6px;
        color: #243149;
        font-size: 14px;
        font-weight: 750;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .em-cart-product-id {
        color: #8994a7;
        font-size: 11px;
        line-height: 1.6;
    }

    .em-cart-price-block {
        min-width: 130px;
        text-align: right;
    }

    .em-cart-label {
        margin-bottom: 4px;
        color: #8994a7;
        font-size: 11px;
    }

    .em-cart-price {
        color: var(--blue);
        font-size: 16px;
        font-weight: 800;
        white-space: nowrap;
    }

    .em-cart-product-bottom {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 15px;
        margin-top: 16px;
        padding-top: 13px;
        border-top: 1px solid #f0f2f7;
    }

    /* JUMLAH BARANG */
    .em-cart-quantity {
        min-width: 0;
    }

    .em-cart-quantity label {
        display: block;
        margin-bottom: 6px;
        color: #778398;
        font-size: 11px;
        font-weight: 650;
    }

    .em-cart-quantity-form {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .em-cart-quantity-input {
        width: 66px;
        height: 35px;
        padding: 0 9px;
        border: 1px solid #dce3ee;
        border-radius: 7px;
        background: #fff;
        color: var(--ink);
        font-size: 13px;
        font-weight: 700;
        outline: none;
    }

    .em-cart-quantity-input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    .em-cart-save {
        height: 35px;
        padding: 0 11px;
        border: 1px solid #cbdcff;
        border-radius: 7px;
        background: #f0f5ff;
        color: var(--blue);
        font-size: 11px;
        font-weight: 750;
        cursor: pointer;
        transition: .2s ease;
    }

    .em-cart-save:hover {
        background: var(--blue);
        color: #fff;
    }

    /* SUBTOTAL DAN HAPUS */
    .em-cart-product-actions {
        display: flex;
        align-items: flex-end;
        gap: 14px;
    }

    .em-cart-subtotal-block {
        text-align: right;
    }

    .em-cart-subtotal {
        color: var(--ink);
        font-size: 14px;
        font-weight: 800;
        white-space: nowrap;
    }

    .em-cart-delete {
        padding: 7px 9px;
        border: 1px solid #f5d6d5;
        border-radius: 7px;
        background: #fff;
        color: #bd3434;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .em-cart-delete:hover {
        border-color: #bd3434;
        background: #fff3f2;
    }

    .em-cart-continue-link {
        margin-top: 15px;
        text-align: center;
    }

    .em-cart-continue-link a {
        color: var(--blue);
        font-size: 12px;
        font-weight: 750;
        text-decoration: none;
    }

    /* RINGKASAN BELANJA */
    .em-cart-summary {
        position: sticky;
        top: 18px;
        min-width: 0;
    }

    .em-cart-summary-body {
        padding: 18px 19px;
    }

    .em-cart-summary-description {
        margin: 0 0 19px;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.65;
    }

    .em-cart-summary-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 15px;
        font-size: 12px;
    }

    .em-cart-summary-row span {
        color: #78859a;
    }

    .em-cart-summary-row strong {
        color: #26354d;
        font-weight: 750;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .em-cart-divider {
        margin: 17px 0;
        border: 0;
        border-top: 1px solid var(--line);
    }

    .em-cart-total-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .em-cart-total-label {
        color: #26354d;
        font-size: 13px;
        font-weight: 800;
    }

    .em-cart-total {
        color: var(--blue);
        font-size: 20px;
        font-weight: 850;
        line-height: 1.4;
        text-align: right;
        overflow-wrap: anywhere;
    }

    /* TOMBOL CHECKOUT - SUDAH AKTIF */
    .em-cart-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 44px;
        margin-top: 19px;
        padding: 11px 14px;
        border: 0;
        border-radius: 8px;
        background: #2563eb;
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        transition: .2s ease;
    }

    .em-cart-checkout:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .em-cart-checkout-note {
        margin: 9px 0 0;
        color: #8792a4;
        font-size: 10px;
        line-height: 1.6;
        text-align: center;
    }

    .em-cart-summary-footer {
        padding: 11px 16px;
        border-top: 1px solid var(--line);
        background: #fafbfe;
        color: #748196;
        font-size: 10px;
        text-align: center;
    }

    /* KERANJANG KOSONG */
    .em-cart-empty {
        padding: 48px 20px;
        text-align: center;
    }

    .em-cart-empty-art {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 76px;
        height: 76px;
        margin: 0 auto 17px;
        border: 1px solid #e1eaff;
        border-radius: 20px;
        background: #f0f5ff;
        color: var(--blue);
        font-size: 23px;
        font-weight: 850;
    }

    .em-cart-empty h2 {
        margin: 0 0 9px;
        font-size: 20px;
        font-weight: 800;
    }

    .em-cart-empty p {
        max-width: 390px;
        margin: 0 auto 20px;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.8;
    }

    .em-cart-shop-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 19px;
        border-radius: 8px;
        background: var(--blue);
        color: #fff;
        font-size: 12px;
        font-weight: 750;
        text-decoration: none;
    }

    .em-cart-shop-button:hover {
        background: #1d4ed8;
        color: #fff;
    }

    /* TABLET */
    @media (max-width: 950px) {
        .em-cart-layout {
            grid-template-columns: minmax(0, 1fr) 280px;
            gap: 15px;
        }

        .em-cart-product {
            grid-template-columns: 80px minmax(0, 1fr);
            gap: 12px;
            padding: 16px;
        }

        .em-cart-image {
            width: 80px;
            height: 80px;
        }

        .em-cart-price-block {
            min-width: 0;
        }

        .em-cart-product-top {
            grid-template-columns: minmax(0, 1fr);
            gap: 10px;
        }

        .em-cart-price-block {
            text-align: left;
        }
    }

    /* MOBILE */
    @media (max-width: 760px) {
        .em-cart {
            padding: 28px 0 35px;
        }

        .em-cart-container {
            width: calc(100% - 24px);
        }

        .em-cart-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 13px;
        }

        .em-cart-title {
            font-size: 25px;
        }

        .em-cart-layout {
            grid-template-columns: minmax(0, 1fr);
            gap: 16px;
        }

        .em-cart-summary {
            position: static;
        }

        .em-cart-section-head {
            padding: 15px;
        }

        .em-cart-product {
            grid-template-columns: 72px minmax(0, 1fr);
            gap: 11px;
            padding: 13px;
        }

        .em-cart-image {
            width: 72px;
            height: 72px;
        }

        .em-cart-product-name {
            font-size: 13px;
        }

        .em-cart-product-bottom {
            align-items: flex-start;
            flex-direction: column;
            gap: 13px;
        }

        .em-cart-product-actions {
            width: 100%;
            align-items: flex-end;
            justify-content: space-between;
        }

        .em-cart-summary-body {
            padding: 17px;
        }

        .em-cart-total {
            font-size: 19px;
        }
    }

    @media (max-width: 380px) {
        .em-cart-product {
            grid-template-columns: 60px minmax(0, 1fr);
            gap: 9px;
            padding: 11px;
        }

        .em-cart-image {
            width: 60px;
            height: 60px;
        }

        .em-cart-product-actions {
            align-items: flex-start;
            flex-direction: column;
        }

        .em-cart-subtotal-block {
            text-align: left;
        }
    }
</style>

<div class="em-cart">
    <div class="em-cart-container">

        {{-- HEADER --}}
        <header class="em-cart-heading">
            <div>
                <div class="em-cart-kicker">ELECTROMART / KERANJANG</div>

                <h1 class="em-cart-title">Keranjang Belanja</h1>

                <p class="em-cart-description">
                    Periksa produk pilihanmu sebelum melanjutkan belanja.
                </p>
            </div>

            
<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
    <a href="{{ route('pesanan-saya.index') }}"
       class="em-cart-back">
        ☰ Lihat Pesanan Saya
    </a>

    <a href="{{ url('/shop') }}" class="em-cart-back">
        &larr; Lanjut Belanja
    </a>
</div>

        </header>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="em-cart-alert success" role="status">
                <div>{{ session('success') }}</div>
                <button type="button"
                        onclick="this.parentElement.remove()"
                        aria-label="Tutup">
                    &times;
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="em-cart-alert error" role="alert">
                <div>{{ session('error') }}</div>
                <button type="button"
                        onclick="this.parentElement.remove()"
                        aria-label="Tutup">
                    &times;
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="em-cart-alert error" role="alert">
                <div>
                    <strong>Periksa kembali data berikut:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @php
            $items = $keranjang->detailKeranjang;
            $jumlahBarang = $items->sum('jumlah');
            $jumlahJenis = $items->count();
        @endphp

        @if ($items->isEmpty())

            {{-- KERANJANG KOSONG --}}
            <div class="em-cart-card">
                <div class="em-cart-empty">
                    <div class="em-cart-empty-art">EM</div>

                    <h2>Keranjangmu masih kosong</h2>

                    <p>
                        Belum ada produk yang kamu pilih. Temukan perangkat
                        elektronik favoritmu di ELECTROMART.
                    </p>

                    <a href="{{ url('/shop') }}" class="em-cart-shop-button">
                        Mulai Belanja
                    </a>
                </div>
            </div>

        @else

            <div class="em-cart-layout">

                {{-- DAFTAR PRODUK --}}
                <main class="em-cart-main">
                    <section class="em-cart-card">

                        <div class="em-cart-section-head">
                            <h2 class="em-cart-section-title">
                                Produk Pilihan
                            </h2>

                            <span class="em-cart-count">
                                {{ $jumlahJenis }} jenis produk
                            </span>
                        </div>

                        @foreach ($items as $item)

                            @if ($item->produk)

                                @php
                                    $harga = (float) $item->produk->harga_jual;
                                    $subtotal = $harga * (int) $item->jumlah;
                                    $stokTersedia = $item->produk->stok->jumlah_stok ?? null;
                                @endphp

                                <article class="em-cart-product">

                                    {{-- GAMBAR PRODUK --}}
                                    <div class="em-cart-image">
                                        @if ($item->produk->gambar)
                                            <img
                                                src="{{ asset('storage/' . $item->produk->gambar) }}"
                                                alt="{{ $item->produk->nama_produk }}"
                                                loading="lazy"
                                            >
                                        @else
                                            <span class="em-cart-image-placeholder">
                                                Tanpa gambar
                                            </span>
                                        @endif
                                    </div>

                                    <div class="em-cart-product-info">

                                        <div class="em-cart-product-top">
                                            <div>
                                                <h3 class="em-cart-product-name">
                                                    {{ $item->produk->nama_produk }}
                                                </h3>

                                                <div class="em-cart-product-id">
                                                    Kode produk: {{ $item->id_produk }}
                                                </div>

                                                @if ($item->id_varian)
                                                    <div class="em-cart-product-id">
                                                        Kode varian: {{ $item->id_varian }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="em-cart-price-block">
                                                <div class="em-cart-label">
                                                    Harga satuan
                                                </div>

                                                <div class="em-cart-price">
                                                    Rp{{ number_format($harga, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="em-cart-product-bottom">

                                            {{-- UBAH JUMLAH --}}
                                            <div class="em-cart-quantity">
                                                <label for="qty-{{ $item->id_detail_keranjang }}">
                                                    Jumlah barang
                                                </label>

                                                <form
                                                    action="{{ route('keranjang.update', $item->id_detail_keranjang) }}"
                                                    method="POST"
                                                    class="em-cart-quantity-form"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <input
                                                        id="qty-{{ $item->id_detail_keranjang }}"
                                                        type="number"
                                                        name="jumlah"
                                                        class="em-cart-quantity-input"
                                                        value="{{ $item->jumlah }}"
                                                        min="1"
                                                        @if ($stokTersedia !== null)
                                                            max="{{ $stokTersedia }}"
                                                        @endif
                                                        required
                                                    >

                                                    <button type="submit" class="em-cart-save">
                                                        Simpan
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- SUBTOTAL DAN HAPUS --}}
                                            <div class="em-cart-product-actions">

                                                <div class="em-cart-subtotal-block">
                                                    <div class="em-cart-label">
                                                        Subtotal
                                                    </div>

                                                    <div class="em-cart-subtotal">
                                                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                                                    </div>
                                                </div>

                                                <form
                                                    action="{{ route('keranjang.hapus', $item->id_detail_keranjang) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="em-cart-delete">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>

                                        </div>
                                    </div>

                                </article>

                            @endif

                        @endforeach

                    </section>

                    <div class="em-cart-continue-link">
                        <a href="{{ url('/shop') }}">
                            + Tambah produk lainnya
                        </a>
                    </div>
                </main>

                {{-- RINGKASAN BELANJA --}}
                <aside class="em-cart-summary">
                    <section class="em-cart-card">

                        <div class="em-cart-section-head">
                            <h2 class="em-cart-section-title">
                                Ringkasan Belanja
                            </h2>
                        </div>

                        <div class="em-cart-summary-body">

                            <p class="em-cart-summary-description">
                                Ringkasan jumlah produk dan total belanja kamu.
                            </p>

                            <div class="em-cart-summary-row">
                                <span>Jenis produk</span>
                                <strong>{{ $jumlahJenis }} jenis</strong>
                            </div>

                            <div class="em-cart-summary-row">
                                <span>Total barang</span>
                                <strong>{{ $jumlahBarang }} barang</strong>
                            </div>

                            <div class="em-cart-summary-row">
                                <span>Subtotal produk</span>
                                <strong>
                                    Rp{{ number_format((float) $total, 0, ',', '.') }}
                                </strong>
                            </div>

                            <div class="em-cart-summary-row">
                                <span>Ongkos kirim</span>
                                <strong>Belum dihitung</strong>
                            </div>

                            <hr class="em-cart-divider">

                            <div class="em-cart-total-line">
                                <div class="em-cart-total-label">
                                    Total sementara
                                </div>

                                <div class="em-cart-total">
                                    Rp{{ number_format((float) $total, 0, ',', '.') }}
                                </div>
                            </div>

                            {{-- TOMBOL CHECKOUT --}}
                            <a
                                href="{{ route('checkout.index') }}"
                                class="em-cart-checkout"
                            >
                                Lanjut ke Checkout
                            </a>

                            <p class="em-cart-checkout-note">
                                Ongkos kirim dan total akhir dihitung saat checkout.
                            </p>

                        </div>

                        <div class="em-cart-summary-footer">
                            Harga ditampilkan dalam Rupiah (IDR).
                        </div>

                    </section>
                </aside>

            </div>

        @endif

    </div>
</div>

@endsection