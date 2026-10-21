@extends('layouts.customer')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .em-cart {
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --navy: #0b1b3a;
        --ink: #14213d;
        --muted: #6b7a90;
        --line: #e6ebf3;
        --soft: #eef4ff;

        background: #f4f7fc;
        color: var(--ink);
        padding: 28px 0 56px;
        min-height: 70vh;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
    }

    .em-cart *, .em-cart *::before, .em-cart *::after { box-sizing: border-box; }

    .em-wrap { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }

    /* ===== HERO ===== */
    .em-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 28px 32px;
        margin-bottom: 22px;
        border-radius: 20px;
        color: #fff;
        background: linear-gradient(120deg, #0b1b3a 0%, #1e40af 55%, #2563eb 100%);
        box-shadow: 0 14px 34px rgba(37, 99, 235, .22);
    }

    .em-hero::before,
    .em-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
        pointer-events: none;
    }
    .em-hero::before { width: 260px; height: 260px; right: -60px; top: -110px; }
    .em-hero::after  { width: 150px; height: 150px; right: 170px; bottom: -90px; background: rgba(56, 189, 248, .16); }

    .em-hero-text { position: relative; z-index: 1; }
    .em-hero h1 { margin: 0 0 6px; font-size: 28px; font-weight: 800; line-height: 1.25; }
    .em-hero p  { margin: 0; color: rgba(255, 255, 255, .78); font-size: 14px; }

    .em-hero-actions { position: relative; z-index: 1; display: flex; flex-wrap: wrap; gap: 10px; }

    .em-btn-ghost {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 16px;
        border: 1px solid rgba(255, 255, 255, .35);
        border-radius: 11px;
        background: rgba(255, 255, 255, .1);
        color: #fff; font-size: 13px; font-weight: 700; text-decoration: none;
        backdrop-filter: blur(4px);
        transition: .2s ease;
    }
    .em-btn-ghost:hover { background: #fff; color: var(--blue-dark); }

    /* ===== LANGKAH ===== */
    .em-steps { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; font-size: 13px; font-weight: 700; color: #94a3b8; flex-wrap: wrap; }
    .em-step { display: inline-flex; align-items: center; gap: 8px; }
    .em-step i {
        display: inline-flex; align-items: center; justify-content: center;
        width: 26px; height: 26px; border-radius: 50%;
        background: #e2e8f0; color: #64748b; font-style: normal; font-size: 12px;
    }
    .em-step.active { color: var(--blue); }
    .em-step.active i { background: var(--blue); color: #fff; box-shadow: 0 0 0 4px rgba(37, 99, 235, .15); }
    .em-step-line { width: 34px; height: 2px; background: #dbe3ef; border-radius: 2px; }

    /* ===== ALERT ===== */
    .em-alert {
        display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
        padding: 13px 16px; margin-bottom: 16px;
        border: 1px solid transparent; border-radius: 12px; font-size: 13px;
    }
    .em-alert.success { border-color: #b7ebcb; background: #edfbf2; color: #137344; }
    .em-alert.error   { border-color: #ffd0cb; background: #fff2f0; color: #b42318; }
    .em-alert button  { border: 0; background: transparent; color: inherit; font-size: 20px; line-height: 1; cursor: pointer; }
    .em-alert ul { margin: 6px 0 0; padding-left: 18px; }

    /* ===== LAYOUT ===== */
    .em-layout { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 22px; align-items: start; }

    .em-card {
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 6px 22px rgba(20, 33, 61, .05);
    }

    .em-card-head {
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        padding: 18px 22px;
        border-bottom: 1px solid var(--line);
    }
    .em-card-title { margin: 0; font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 10px; }
    .em-card-title .ico {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 10px; background: var(--soft); color: var(--blue); font-size: 14px;
    }
    .em-count { padding: 6px 12px; border-radius: 999px; background: var(--soft); color: var(--blue); font-size: 12px; font-weight: 700; white-space: nowrap; }

    /* ===== PRODUK ===== */
    .em-item { display: grid; grid-template-columns: 112px minmax(0, 1fr); gap: 18px; padding: 22px; }
    .em-item + .em-item { border-top: 1px solid var(--line); }

    .em-thumb {
        display: flex; align-items: center; justify-content: center;
        width: 112px; height: 112px; overflow: hidden;
        border: 1px solid var(--line); border-radius: 14px; background: #f8faff;
    }
    .em-thumb img { width: 100%; height: 100%; padding: 8px; object-fit: contain; display: block; }
    .em-thumb span { padding: 6px; color: #a5b1c2; font-size: 11px; text-align: center; }

    .em-info { min-width: 0; display: flex; flex-direction: column; gap: 14px; }

    .em-top { display: flex; justify-content: space-between; gap: 16px; align-items: flex-start; }
    .em-name { margin: 0 0 8px; font-size: 15px; font-weight: 700; line-height: 1.5; color: var(--navy); overflow-wrap: anywhere; }
    .em-tags { display: flex; flex-wrap: wrap; gap: 6px; }
    .em-tag { padding: 4px 10px; border-radius: 8px; background: #f1f5f9; color: #5b6b82; font-size: 11px; font-weight: 600; }

    .em-price { text-align: right; flex-shrink: 0; }
    .em-price small { display: block; margin-bottom: 3px; color: #8a97ab; font-size: 11px; }
    .em-price strong { color: var(--blue); font-size: 17px; font-weight: 800; white-space: nowrap; }

    .em-bottom {
        display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap;
        padding-top: 14px; border-top: 1px dashed var(--line);
    }

    /* Stepper jumlah */
    .em-qty-form { display: inline-flex; align-items: center; margin: 0; }
    .em-qty {
        display: inline-flex; align-items: center;
        border: 1px solid #d5deec; border-radius: 12px; background: #fff; overflow: hidden;
    }
    .em-qty button {
        width: 38px; height: 38px; border: 0; background: #f4f7fc; color: var(--blue);
        font-size: 16px; font-weight: 800; cursor: pointer; transition: .15s ease;
    }
    .em-qty button:hover { background: var(--blue); color: #fff; }
    .em-qty input {
        width: 52px; height: 38px; border: 0; text-align: center;
        font: inherit; font-size: 14px; font-weight: 800; color: var(--navy); outline: none; background: #fff;
        -moz-appearance: textfield;
    }
    .em-qty input::-webkit-outer-spin-button,
    .em-qty input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .em-qty:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(37, 99, 235, .12); }
    .em-stock { margin-left: 10px; color: #8a97ab; font-size: 11px; }

    .em-right { display: flex; align-items: center; gap: 16px; }
    .em-subtotal { text-align: right; }
    .em-subtotal small { display: block; color: #8a97ab; font-size: 11px; margin-bottom: 2px; }
    .em-subtotal strong { font-size: 16px; font-weight: 800; color: var(--navy); white-space: nowrap; }

    .em-trash {
        display: inline-flex; align-items: center; justify-content: center;
        width: 40px; height: 40px; border: 1px solid #f6d5d3; border-radius: 12px;
        background: #fff; color: #d14343; font-size: 14px; cursor: pointer; transition: .2s ease;
    }
    .em-trash:hover { background: #d14343; border-color: #d14343; color: #fff; }

    .em-more { display: flex; justify-content: center; margin-top: 16px; }
    .em-more a {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 20px; border: 1.5px dashed #b9cdf7; border-radius: 12px;
        color: var(--blue); font-size: 13px; font-weight: 700; text-decoration: none; transition: .2s ease;
    }
    .em-more a:hover { background: var(--soft); border-style: solid; }

    /* ===== RINGKASAN ===== */
    .em-summary { position: sticky; top: 18px; }
    .em-sum-body { padding: 20px 22px 22px; }
    .em-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 14px; font-size: 13px; }
    .em-row span { color: var(--muted); }
    .em-row strong { color: var(--ink); font-weight: 700; text-align: right; }
    .em-line { margin: 16px 0; border: 0; border-top: 1px dashed #d5deec; }

    .em-total {
        display: flex; justify-content: space-between; align-items: center; gap: 12px;
        padding: 14px 16px; border-radius: 14px; background: var(--soft);
    }
    .em-total span { font-size: 13px; font-weight: 700; color: #34445b; }
    .em-total strong { font-size: 22px; font-weight: 800; color: var(--blue); text-align: right; }

    .em-checkout {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; min-height: 50px; margin-top: 18px; padding: 12px 16px;
        border-radius: 14px; background: linear-gradient(120deg, #1d4ed8, #2563eb);
        color: #fff; font-size: 14px; font-weight: 800; text-decoration: none;
        box-shadow: 0 10px 22px rgba(37, 99, 235, .3);
        transition: .2s ease;
    }
    .em-checkout:hover { transform: translateY(-2px); box-shadow: 0 14px 28px rgba(37, 99, 235, .38); color: #fff; }

    .em-note { margin: 12px 0 0; color: #8a97ab; font-size: 11.5px; line-height: 1.6; text-align: center; }

    .em-sum-foot {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 16px; border-top: 1px solid var(--line); background: #fafbfe;
        color: #6b7a90; font-size: 11.5px;
    }
    .em-sum-foot i { color: #16a34a; }

    /* ===== KOSONG ===== */
    .em-empty { padding: 64px 20px; text-align: center; }
    .em-empty-art {
        display: flex; align-items: center; justify-content: center;
        width: 96px; height: 96px; margin: 0 auto 20px; border-radius: 28px;
        background: linear-gradient(135deg, #e0ecff, #f0f6ff); color: var(--blue); font-size: 38px;
    }
    .em-empty h2 { margin: 0 0 8px; font-size: 22px; font-weight: 800; }
    .em-empty p { max-width: 400px; margin: 0 auto 22px; color: var(--muted); font-size: 14px; line-height: 1.7; }
    .em-shop-btn {
        display: inline-flex; align-items: center; gap: 8px; padding: 13px 24px; border-radius: 12px;
        background: var(--blue); color: #fff; font-size: 14px; font-weight: 700; text-decoration: none;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .25); transition: .2s ease;
    }
    .em-shop-btn:hover { background: var(--blue-dark); color: #fff; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 960px) {
        .em-layout { grid-template-columns: 1fr; }
        .em-summary { position: static; }
    }

    @media (max-width: 640px) {
        .em-cart { padding: 18px 0 40px; }
        .em-hero { flex-direction: column; align-items: flex-start; padding: 22px 20px; }
        .em-hero h1 { font-size: 23px; }
        .em-item { grid-template-columns: 82px minmax(0, 1fr); gap: 13px; padding: 16px; }
        .em-thumb { width: 82px; height: 82px; }
        .em-top { flex-direction: column; gap: 8px; }
        .em-price { text-align: left; }
        .em-bottom { flex-direction: column; align-items: stretch; }
        .em-right { justify-content: space-between; }
        .em-card-head { padding: 15px 16px; }
        .em-sum-body { padding: 18px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .em-cart * { transition: none !important; }
    }
</style>

<div class="em-cart">
    <div class="em-wrap">

        {{-- HERO --}}
        <header class="em-hero">
            <div class="em-hero-text">
                <h1>Keranjang Belanja</h1>
                <p>Periksa produk pilihanmu, atur jumlahnya, lalu lanjut ke checkout.</p>
            </div>

            <div class="em-hero-actions">
                <a href="{{ route('pesanan-saya.index') }}" class="em-btn-ghost">
                    <i class="fa-solid fa-receipt"></i> Pesanan Saya
                </a>
                <a href="{{ url('/shop') }}" class="em-btn-ghost">
                    <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                </a>
            </div>
        </header>

        {{-- LANGKAH --}}
        <div class="em-steps" aria-label="Langkah belanja">
            <span class="em-step active"><i>1</i> Keranjang</span>
            <span class="em-step-line"></span>
            <span class="em-step"><i>2</i> Checkout</span>
            <span class="em-step-line"></span>
            <span class="em-step"><i>3</i> Selesai</span>
        </div>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="em-alert success" role="status">
                <div>{{ session('success') }}</div>
                <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="em-alert error" role="alert">
                <div>{{ session('error') }}</div>
                <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="em-alert error" role="alert">
                <div>
                    <strong>Periksa kembali data berikut:</strong>
                    <ul>
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
            <div class="em-card">
                <div class="em-empty">
                    <div class="em-empty-art"><i class="fa-solid fa-cart-shopping"></i></div>
                    <h2>Keranjangmu masih kosong</h2>
                    <p>Belum ada produk yang kamu pilih. Temukan perangkat elektronik favoritmu di ELECTROMART.</p>
                    <a href="{{ url('/shop') }}" class="em-shop-btn">
                        <i class="fa-solid fa-bag-shopping"></i> Mulai Belanja
                    </a>
                </div>
            </div>

        @else

            <div class="em-layout">

                {{-- DAFTAR PRODUK --}}
                <main>
                    <section class="em-card">

                        <div class="em-card-head">
                            <h2 class="em-card-title">
                                <span class="ico"><i class="fa-solid fa-cart-shopping"></i></span>
                                Produk di Keranjang
                            </h2>
                            <span class="em-count">{{ $jumlahJenis }} jenis produk</span>
                        </div>

                        @foreach ($items as $item)
                            @if ($item->produk)

                                @php
                                    $harga = (float) $item->produk->harga_jual;
                                    $subtotal = $harga * (int) $item->jumlah;
                                    $stokTersedia = $item->produk->stok->jumlah_stok ?? null;
                                @endphp

                                <article class="em-item">

                                    {{-- GAMBAR --}}
                                    <div class="em-thumb">
                                        @if ($item->produk->gambar)
                                            <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                                                 alt="{{ $item->produk->nama_produk }}"
                                                 loading="lazy">
                                        @else
                                            <span>Tanpa gambar</span>
                                        @endif
                                    </div>

                                    <div class="em-info">

                                        <div class="em-top">
                                            <div>
                                                <h3 class="em-name">{{ $item->produk->nama_produk }}</h3>

                                                <div class="em-tags">
                                                    <span class="em-tag">Kode produk: {{ $item->id_produk }}</span>
                                                    @if ($item->id_varian)
                                                        <span class="em-tag">Kode varian: {{ $item->id_varian }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="em-price">
                                                <small>Harga satuan</small>
                                                <strong>Rp{{ number_format($harga, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>

                                        <div class="em-bottom">

                                            {{-- UBAH JUMLAH --}}
                                            <form action="{{ route('keranjang.update', $item->id_detail_keranjang) }}"
                                                  method="POST"
                                                  class="em-qty-form">
                                                @csrf
                                                @method('PATCH')

                                                <div class="em-qty">
                                                    <button type="button" onclick="emStep(this, -1)" aria-label="Kurangi jumlah">&minus;</button>

                                                    <input id="qty-{{ $item->id_detail_keranjang }}"
                                                           type="number"
                                                           name="jumlah"
                                                           value="{{ $item->jumlah }}"
                                                           min="1"
                                                           @if ($stokTersedia !== null) max="{{ $stokTersedia }}" @endif
                                                           onchange="this.form.submit()"
                                                           aria-label="Jumlah barang"
                                                           required>

                                                    <button type="button" onclick="emStep(this, 1)" aria-label="Tambah jumlah">+</button>
                                                </div>

                                                @if ($stokTersedia !== null)
                                                    <span class="em-stock">Stok {{ $stokTersedia }}</span>
                                                @endif

                                                <noscript>
                                                    <button type="submit" class="em-btn-ghost" style="color:#2563eb;border-color:#2563eb;margin-left:8px">Simpan</button>
                                                </noscript>
                                            </form>

                                            {{-- SUBTOTAL DAN HAPUS --}}
                                            <div class="em-right">
                                                <div class="em-subtotal">
                                                    <small>Subtotal</small>
                                                    <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                                                </div>

                                                <form action="{{ route('keranjang.hapus', $item->id_detail_keranjang) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="em-trash" aria-label="Hapus produk" title="Hapus">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                </article>

                            @endif
                        @endforeach

                    </section>

                    <div class="em-more">
                        <a href="{{ url('/shop') }}">
                            <i class="fa-solid fa-plus"></i> Tambah produk lainnya
                        </a>
                    </div>
                </main>

                {{-- RINGKASAN --}}
                <aside class="em-summary">
                    <section class="em-card">

                        <div class="em-card-head">
                            <h2 class="em-card-title">
                                <span class="ico"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                                Ringkasan Belanja
                            </h2>
                        </div>

                        <div class="em-sum-body">

                            <div class="em-row">
                                <span>Jenis produk</span>
                                <strong>{{ $jumlahJenis }} jenis</strong>
                            </div>

                            <div class="em-row">
                                <span>Total barang</span>
                                <strong>{{ $jumlahBarang }} barang</strong>
                            </div>

                            <div class="em-row">
                                <span>Subtotal produk</span>
                                <strong>Rp{{ number_format((float) $total, 0, ',', '.') }}</strong>
                            </div>

                            <div class="em-row">
                                <span>Ongkos kirim</span>
                                <strong>Dihitung saat checkout</strong>
                            </div>

                            <hr class="em-line">

                            <div class="em-total">
                                <span>Total sementara</span>
                                <strong>Rp{{ number_format((float) $total, 0, ',', '.') }}</strong>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="em-checkout">
                                <i class="fa-solid fa-lock"></i> Lanjut ke Checkout
                            </a>

                            <p class="em-note">Ongkos kirim dan total akhir dihitung saat checkout.</p>

                        </div>

                        <div class="em-sum-foot">
                            <i class="fa-solid fa-shield-halved"></i>
                            Harga ditampilkan dalam Rupiah (IDR)
                        </div>

                    </section>
                </aside>

            </div>

        @endif

    </div>
</div>

<script>
    function emStep(btn, delta) {
        const form  = btn.closest('form');
        const input = form.querySelector('input[name="jumlah"]');
        const min   = parseInt(input.min || 1, 10);
        const max   = input.max ? parseInt(input.max, 10) : Infinity;
        const next  = (parseInt(input.value, 10) || min) + delta;

        if (next < min || next > max) return;

        input.value = next;
        form.submit();
    }
</script>

@endsection