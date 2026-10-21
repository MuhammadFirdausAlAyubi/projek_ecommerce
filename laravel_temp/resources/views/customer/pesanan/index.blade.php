@extends('layouts.customer')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .em-orders {
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
    .em-orders *, .em-orders *::before, .em-orders *::after { box-sizing: border-box; }
    .em-wrap { width: min(1100px, calc(100% - 32px)); margin: 0 auto; }

    /* HERO */
    .em-hero {
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: space-between; gap: 20px;
        padding: 28px 32px; margin-bottom: 22px; border-radius: 20px; color: #fff;
        background: linear-gradient(120deg, #0b1b3a 0%, #1e40af 55%, #2563eb 100%);
        box-shadow: 0 14px 34px rgba(37, 99, 235, .22);
    }
    .em-hero::before, .em-hero::after { content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.07); pointer-events: none; }
    .em-hero::before { width: 260px; height: 260px; right: -60px; top: -110px; }
    .em-hero::after  { width: 150px; height: 150px; right: 170px; bottom: -90px; background: rgba(56,189,248,.16); }
    .em-hero-text { position: relative; z-index: 1; }
    .em-hero h1 { margin: 0 0 6px; font-size: 28px; font-weight: 800; }
    .em-hero p { margin: 0; color: rgba(255,255,255,.78); font-size: 14px; }
    .em-btn-light {
        position: relative; z-index: 1;
        display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px;
        border-radius: 12px; background: #fff; color: var(--blue-dark);
        font-size: 13px; font-weight: 800; text-decoration: none; transition: .2s ease;
    }
    .em-btn-light:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(0,0,0,.18); color: var(--blue-dark); }

    /* ALERT */
    .em-alert { display: flex; align-items: center; gap: 10px; padding: 13px 16px; margin-bottom: 16px; border: 1px solid #b7ebcb; border-radius: 12px; background: #edfbf2; color: #137344; font-size: 13px; }

    /* KARTU */
    .em-card { overflow: hidden; border: 1px solid var(--line); border-radius: 18px; background: #fff; box-shadow: 0 6px 22px rgba(20,33,61,.05); }
    .em-tabs { display: flex; align-items: center; justify-content: space-between; padding: 0 22px; border-bottom: 1px solid var(--line); }
    .em-tabs a { display: inline-flex; align-items: center; gap: 8px; padding: 16px 2px; border-bottom: 3px solid var(--blue); color: var(--blue); font-size: 14px; font-weight: 800; text-decoration: none; }
    .em-tabs small { color: var(--muted); font-size: 12px; font-weight: 600; }

    .em-list { padding: 20px; display: grid; gap: 18px; }

    /* PESANAN */
    .em-order { overflow: hidden; border: 1px solid var(--line); border-radius: 16px; background: #fff; transition: .2s ease; }
    .em-order:hover { border-color: #bcd0f7; box-shadow: 0 10px 26px rgba(37,99,235,.09); }

    .em-order-head {
        display: flex; align-items: center; flex-wrap: wrap; gap: 18px;
        padding: 15px 20px; background: #f8faff; border-bottom: 1px solid var(--line);
    }
    .em-meta small { display: block; margin-bottom: 3px; color: #8a97ab; font-size: 11px; font-weight: 600; }
    .em-meta strong { font-size: 14px; font-weight: 800; color: var(--navy); }
    .em-meta .date { font-size: 13px; font-weight: 600; color: #4b5b73; }

    .em-status {
        margin-left: auto; display: inline-flex; align-items: center; gap: 7px;
        padding: 7px 13px; border-radius: 999px; font-size: 12px; font-weight: 800;
    }
    .em-status.warn { background: #fff7e0; color: #a15c07; }
    .em-status.info { background: #e8f0ff; color: #1d4ed8; }
    .em-status.ship { background: #ece9ff; color: #5b3fd1; }
    .em-status.ok   { background: #e3f8ec; color: #137344; }
    .em-status.bad  { background: #ffeceb; color: #b42318; }

    .em-products { padding: 4px 20px; }
    .em-product { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 16px 0; border-bottom: 1px solid #f0f3f8; }
    .em-product:last-child { border-bottom: 0; }
    .em-product-info { display: flex; align-items: center; gap: 15px; min-width: 0; }
    .em-thumb {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        width: 80px; height: 80px; overflow: hidden; border: 1px solid var(--line); border-radius: 13px; background: #f8faff; color: #a5b1c2; font-size: 26px;
    }
    .em-thumb img { width: 100%; height: 100%; padding: 6px; object-fit: contain; }
    .em-product h3 { margin: 0 0 6px; font-size: 14px; font-weight: 700; color: var(--navy); line-height: 1.5; overflow-wrap: anywhere; }
    .em-product p { margin: 0; color: var(--muted); font-size: 12.5px; }
    .em-product p b { color: #4b5b73; font-weight: 700; }
    .em-line-total { text-align: right; flex-shrink: 0; }
    .em-line-total small { display: block; margin-bottom: 3px; color: #8a97ab; font-size: 11px; }
    .em-line-total strong { font-size: 14px; font-weight: 800; color: var(--navy); white-space: nowrap; }

    .em-order-foot {
        display: flex; align-items: center; justify-content: space-between; gap: 18px;
        padding: 16px 20px; border-top: 1px dashed #d5deec; background: #f8faff;
    }
    .em-order-total small { display: block; margin-bottom: 3px; color: var(--muted); font-size: 12px; }
    .em-order-total strong { color: var(--blue); font-size: 21px; font-weight: 800; }
    .em-btn-detail {
        display: inline-flex; align-items: center; gap: 8px; padding: 11px 20px; border-radius: 12px;
        background: linear-gradient(120deg, #1d4ed8, #2563eb); color: #fff;
        font-size: 13px; font-weight: 700; text-decoration: none; white-space: nowrap;
        box-shadow: 0 8px 18px rgba(37,99,235,.25); transition: .2s ease;
    }
    .em-btn-detail:hover { transform: translateY(-2px); color: #fff; }

    /* KOSONG */
    .em-empty { padding: 70px 20px; text-align: center; }
    .em-empty-art { display: flex; align-items: center; justify-content: center; width: 96px; height: 96px; margin: 0 auto 20px; border-radius: 28px; background: linear-gradient(135deg, #e0ecff, #f0f6ff); color: var(--blue); font-size: 38px; }
    .em-empty h2 { margin: 0 0 8px; font-size: 22px; font-weight: 800; }
    .em-empty p { margin: 0 0 22px; color: var(--muted); font-size: 14px; }
    .em-shop-btn { display: inline-flex; align-items: center; gap: 8px; padding: 13px 24px; border-radius: 12px; background: var(--blue); color: #fff; font-size: 14px; font-weight: 700; text-decoration: none; }
    .em-shop-btn:hover { background: var(--blue-dark); color: #fff; }

    .em-pagination { padding: 0 20px 22px; }

    @media (max-width: 640px) {
        .em-orders { padding: 18px 0 40px; }
        .em-hero { flex-direction: column; align-items: flex-start; padding: 22px 20px; }
        .em-hero h1 { font-size: 23px; }
        .em-list { padding: 12px; }
        .em-order-head { padding: 13px 14px; gap: 12px; }
        .em-status { margin-left: 0; }
        .em-products { padding: 4px 14px; }
        .em-product { flex-direction: column; align-items: flex-start; }
        .em-line-total { text-align: left; margin-left: 95px; }
        .em-order-foot { flex-direction: column; align-items: stretch; padding: 14px; }
        .em-btn-detail { justify-content: center; }
    }
</style>

<div class="em-orders">
    <div class="em-wrap">

        {{-- HERO --}}
        <header class="em-hero">
            <div class="em-hero-text">
                <h1>Pesanan Saya</h1>
                <p>Pantau status dan riwayat belanja kamu di ELECTROMART.</p>
            </div>

            <a href="{{ route('shop.index') }}" class="em-btn-light">
                <i class="fa-solid fa-bag-shopping"></i> Belanja Lagi
            </a>
        </header>

        <div class="em-card">

            <div class="em-tabs">
                <a href="{{ route('pesanan-saya.index') }}">
                    <i class="fa-solid fa-box-open"></i> Semua Pesanan
                </a>
                @if (! $pesanan->isEmpty())
                    <small>{{ method_exists($pesanan, 'total') ? $pesanan->total() : $pesanan->count() }} pesanan</small>
                @endif
            </div>

            @if (session('success'))
                <div class="em-alert" style="margin:20px 20px 0">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            @if ($pesanan->isEmpty())

                <div class="em-empty">
                    <div class="em-empty-art"><i class="fa-solid fa-box-open"></i></div>
                    <h2>Belum ada pesanan</h2>
                    <p>Pesanan yang kamu buat akan muncul di halaman ini.</p>
                    <a href="{{ route('shop.index') }}" class="em-shop-btn">
                        <i class="fa-solid fa-bag-shopping"></i> Mulai Belanja
                    </a>
                </div>

            @else

                <div class="em-list">
                    @foreach ($pesanan as $item)

                        @php
                            $statusMap = [
                                'menunggu'            => ['warn', 'fa-clock'],
                                'menunggu_pembayaran' => ['warn', 'fa-clock'],
                                'diproses'            => ['info', 'fa-gear'],
                                'dikirim'             => ['ship', 'fa-truck-fast'],
                                'selesai'             => ['ok',   'fa-circle-check'],
                                'dibatalkan'          => ['bad',  'fa-circle-xmark'],
                            ];
                            $statusKey = $item->status_pesanan ?? 'menunggu';
                            [$statusClass, $statusIcon] = $statusMap[$statusKey] ?? ['info', 'fa-circle-info'];
                        @endphp

                        <article class="em-order">

                            <div class="em-order-head">
                                <div class="em-meta">
                                    <small>No. pesanan</small>
                                    <strong>#{{ $item->id_pesanan }}</strong>
                                </div>

                                <div class="em-meta">
                                    <small>Tanggal pesanan</small>
                                    <span class="date">
                                        {{ $item->tanggal_pesanan ? $item->tanggal_pesanan->format('d M Y, H:i') : '-' }}
                                    </span>
                                </div>

                                <span class="em-status {{ $statusClass }}">
                                    <i class="fa-solid {{ $statusIcon }}"></i>
                                    {{ ucwords(str_replace('_', ' ', $statusKey)) }}
                                </span>
                            </div>

                            <div class="em-products">
                                @foreach ($item->detailPesanan as $detail)
                                    <div class="em-product">
                                        <div class="em-product-info">
                                            <div class="em-thumb">
                                                @if ($detail->produk && $detail->produk->gambar)
                                                    <img src="{{ asset('storage/' . $detail->produk->gambar) }}"
                                                         alt="{{ $detail->produk->nama_produk }}"
                                                         loading="lazy">
                                                @else
                                                    <i class="fa-solid fa-box"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h3>{{ $detail->produk->nama_produk ?? 'Produk tidak tersedia' }}</h3>
                                                <p>
                                                    <b>{{ $detail->jumlah }} barang</b> &times;
                                                    Rp{{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="em-line-total">
                                            <small>Subtotal</small>
                                            <strong>Rp{{ number_format((float) $detail->subtotal, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="em-order-foot">
                                <div class="em-order-total">
                                    <small>Total pesanan</small>
                                    <strong>Rp{{ number_format((float) $item->total_harga, 0, ',', '.') }}</strong>
                                </div>

                                <a href="{{ route('pesanan-saya.show', $item->id_pesanan) }}" class="em-btn-detail">
                                    Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>

                        </article>
                    @endforeach
                </div>

                <div class="em-pagination">
                    {{ $pesanan->links() }}
                </div>

            @endif
        </div>

    </div>
</div>

@endsection