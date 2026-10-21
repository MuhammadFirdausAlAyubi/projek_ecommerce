@extends('layouts.customer')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .em-detail {
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

    .em-detail *, .em-detail *::before, .em-detail *::after {
        box-sizing: border-box;
    }

    .em-wrap {
        width: min(1100px, calc(100% - 32px));
        margin: 0 auto;
    }

    .em-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        color: var(--blue-dark);
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .em-back:hover {
        text-decoration: underline;
    }

    /* HERO */
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

    .em-hero::before {
        width: 260px;
        height: 260px;
        right: -60px;
        top: -110px;
    }

    .em-hero::after {
        width: 150px;
        height: 150px;
        right: 170px;
        bottom: -90px;
        background: rgba(56, 189, 248, .16);
    }

    .em-hero-text {
        position: relative;
        z-index: 1;
    }

    .em-hero h1 {
        margin: 0 0 6px;
        font-size: 28px;
        font-weight: 800;
    }

    .em-hero p {
        margin: 0;
        color: rgba(255, 255, 255, .78);
        font-size: 14px;
    }

    .em-status {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
        background: #fff;
    }

    .em-status.warn { color: #a15c07; }
    .em-status.info { color: #1d4ed8; }
    .em-status.ship { color: #5b3fd1; }
    .em-status.ok { color: #137344; }
    .em-status.bad { color: #b42318; }

    /* ALERT */
    .em-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 16px;
        margin-bottom: 16px;
        border: 1px solid transparent;
        border-radius: 12px;
        font-size: 13px;
    }

    .em-alert.success {
        border-color: #b7ebcb;
        background: #edfbf2;
        color: #137344;
    }

    .em-alert.error {
        border-color: #ffd0cb;
        background: #fff2f0;
        color: #b42318;
    }

    .em-alert ul {
        margin: 6px 0 0;
        padding-left: 18px;
    }

    /* TRACKER */
    .em-track {
        padding: 24px 28px;
        margin-bottom: 22px;
    }

    .em-track-list {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        position: relative;
    }

    .em-track-step {
        position: relative;
        text-align: center;
        padding: 0 6px;
    }

    .em-track-step::before {
        content: "";
        position: absolute;
        top: 20px;
        left: -50%;
        width: 100%;
        height: 3px;
        background: #e2e8f0;
        z-index: 0;
    }

    .em-track-step:first-child::before {
        display: none;
    }

    .em-track-step.done::before {
        background: var(--blue);
    }

    .em-track-dot {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #94a3b8;
        font-size: 15px;
    }

    .em-track-step.done .em-track-dot {
        background: var(--blue);
        color: #fff;
    }

    .em-track-step.current .em-track-dot {
        box-shadow: 0 0 0 6px rgba(37, 99, 235, .16);
    }

    .em-track-label {
        margin-top: 10px;
        font-size: 12.5px;
        font-weight: 700;
        color: #94a3b8;
    }

    .em-track-step.done .em-track-label {
        color: var(--navy);
    }

    /* KARTU */
    .em-card {
        overflow: hidden;
        margin-bottom: 22px;
        border: 1px solid var(--line);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 6px 22px rgba(20, 33, 61, .05);
    }

    .em-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 20px 26px;
        background: #f8faff;
        border-bottom: 1px solid var(--line);
    }

    .em-label {
        display: block;
        margin-bottom: 5px;
        color: #8a97ab;
        font-size: 11.5px;
        font-weight: 600;
    }

    .em-card-head h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 800;
        color: var(--navy);
    }

    .em-date {
        text-align: right;
    }

    .em-date strong {
        font-size: 14px;
        font-weight: 700;
    }

    .em-card-body {
        padding: 24px 26px;
    }

    .em-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 16px;
        font-size: 16px;
        font-weight: 800;
        color: var(--navy);
    }

    .em-title .ico {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: var(--soft);
        color: var(--blue);
        font-size: 14px;
    }

    .em-title.spaced {
        margin-top: 28px;
    }

    /* PRODUK */
    .em-product {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 16px 0;
        border-bottom: 1px solid #f0f3f8;
    }

    .em-product-info {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
    }

    .em-thumb {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 82px;
        height: 82px;
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 13px;
        background: #f8faff;
        color: #a5b1c2;
        font-size: 26px;
    }

    .em-thumb img {
        width: 100%;
        height: 100%;
        padding: 6px;
        object-fit: contain;
    }

    .em-product h4 {
        margin: 0 0 7px;
        font-size: 14px;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .em-product p {
        margin: 0;
        color: var(--muted);
        font-size: 12.5px;
    }

    .em-product-subtotal {
        font-size: 15px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* BARIS INFO */
    .em-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
        align-items: stretch;
    }

    .em-grid .em-card {
        margin-bottom: 0;
        height: 100%;
    }

    .em-info-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid #f0f3f8;
        font-size: 13px;
    }

    .em-info-row span {
        color: var(--muted);
    }

    .em-info-row strong {
        text-align: right;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .em-muted {
        color: var(--muted);
        font-size: 14px;
    }

    .em-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 18px;
        padding: 15px 18px;
        border-radius: 14px;
        background: var(--soft);
    }

    .em-total-row span {
        font-size: 14px;
        font-weight: 700;
        color: #34445b;
    }

    .em-total-row strong {
        color: var(--blue);
        font-size: 22px;
        font-weight: 800;
        text-align: right;
    }

    .em-bottom {
        display: flex;
        justify-content: flex-end;
        margin-top: 22px;
    }

    .em-btn-shop {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 26px;
        border-radius: 12px;
        background: linear-gradient(120deg, #1d4ed8, #2563eb);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .25);
        transition: .2s ease;
    }

    .em-btn-shop:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    /* TOMBOL RETUR */
    .em-btn-retur {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 13px 26px;
        border: 1px solid #ea580c;
        border-radius: 12px;
        background: #fff;
        color: #ea580c;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .em-btn-retur:hover {
        background: #ea580c;
        color: #fff;
        transform: translateY(-2px);
    }

    /* FORM UMUM (RETUR & ULASAN) */
    .em-box {
        margin: 6px 0 18px;
        padding: 20px;
        border-radius: 14px;
    }

    .em-box h4 {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0 0 12px;
        font-size: 15px;
        font-weight: 800;
    }

    .em-box label {
        display: block;
        margin: 14px 0 6px;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
    }

    .em-box input,
    .em-box select,
    .em-box textarea {
        display: block;
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d5deec;
        border-radius: 10px;
        background: #fff;
        color: var(--ink);
        font: inherit;
        font-size: 14px;
    }

    .em-box textarea {
        resize: vertical;
        min-height: 90px;
    }

    .em-box-desc {
        margin: 0 0 6px;
        color: #57534e;
        font-size: 13px;
        line-height: 1.7;
    }

    .em-error {
        margin: 6px 0 0;
        color: #b91c1c;
        font-size: 12.5px;
    }

    .em-submit {
        margin-top: 16px;
        padding: 12px 20px;
        border: 0;
        border-radius: 10px;
        color: #fff;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    /* RETUR */
    .em-return {
        border: 1px solid #fed7aa;
        background: #fffaf5;
    }

    .em-return h4 {
        color: #9a3412;
    }

    .em-return input:focus,
    .em-return textarea:focus {
        outline: none;
        border-color: #ea580c;
        box-shadow: 0 0 0 3px rgba(234, 88, 12, .12);
    }

    .em-return .em-submit {
        background: #ea580c;
    }

    .em-return .em-submit:hover {
        background: #c2410c;
    }

    .em-history {
        margin: 14px 0;
        padding: 14px 16px;
        border: 1px solid #e7e5e4;
        border-radius: 11px;
        background: #fff;
    }

    .em-history > strong {
        display: block;
        margin-bottom: 6px;
        color: #44403c;
        font-size: 13px;
    }

    .em-history-item {
        padding: 10px 0;
        border-top: 1px solid #f0eeec;
    }

    .em-history-item p {
        margin: 4px 0;
        color: #57534e;
        font-size: 13px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .em-history-item p strong {
        color: #9a3412;
    }

    .em-note {
        margin: 8px 0 0;
        color: #78716c;
        font-size: 13px;
        line-height: 1.7;
    }

    /* ULASAN */
    .em-review {
        border: 1px solid #dbeafe;
        background: #f8fbff;
    }

    .em-review h4 {
        color: var(--blue-dark);
    }

    .em-review select:focus,
    .em-review textarea:focus {
        outline: none;
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .em-review .em-submit {
        background: var(--blue);
    }

    .em-review .em-submit:hover {
        background: var(--blue-dark);
    }

    .em-stars {
        color: #f59e0b;
        font-size: 22px;
        letter-spacing: 2px;
    }

    .em-rating-text {
        margin: 6px 0;
        color: #475467;
        font-size: 13px;
    }

    .em-comment {
        margin: 0 0 8px;
        color: #475467;
        font-size: 14px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .em-review-note {
        margin: 0;
        color: #15803d;
        font-size: 13px;
    }

    @media (max-width: 760px) {
        .em-detail {
            padding: 18px 0 40px;
        }

        .em-hero {
            flex-direction: column;
            align-items: flex-start;
            padding: 22px 20px;
        }

        .em-hero h1 {
            font-size: 23px;
        }

        .em-track {
            padding: 20px 10px;
        }

        .em-track-dot {
            width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .em-track-step::before {
            top: 17px;
        }

        .em-track-label {
            font-size: 11px;
        }

        .em-card-head {
            flex-direction: column;
            align-items: flex-start;
            padding: 18px;
        }

        .em-date {
            text-align: left;
        }

        .em-card-body {
            padding: 18px;
        }

        .em-grid {
            grid-template-columns: 1fr;
            gap: 22px;
        }

        .em-product {
            flex-direction: column;
            align-items: flex-start;
        }

        .em-product-subtotal {
            margin-left: 97px;
        }

        .em-box {
            padding: 15px;
        }

        .em-submit {
            width: 100%;
        }

        .em-bottom .em-btn-shop,
        .em-bottom .em-btn-retur {
            width: 100%;
            justify-content: center;
        }
    }
</style>

@php
    $statusMap = [
        'menunggu' => ['warn', 'fa-clock'],
        'menunggu_pembayaran' => ['warn', 'fa-clock'],
        'diproses' => ['info', 'fa-gear'],
        'dikirim' => ['ship', 'fa-truck-fast'],
        'selesai' => ['ok', 'fa-circle-check'],
        'dibatalkan' => ['bad', 'fa-circle-xmark'],
    ];

    $statusKey = $pesanan->status_pesanan ?? 'menunggu';
    [$statusClass, $statusIcon] = $statusMap[$statusKey] ?? ['info', 'fa-circle-info'];

    $langkah = [
        ['key' => 'menunggu', 'label' => 'Dipesan', 'icon' => 'fa-receipt'],
        ['key' => 'diproses', 'label' => 'Diproses', 'icon' => 'fa-gear'],
        ['key' => 'dikirim', 'label' => 'Dikirim', 'icon' => 'fa-truck-fast'],
        ['key' => 'selesai', 'label' => 'Selesai', 'icon' => 'fa-circle-check'],
    ];

    $urutan = array_column($langkah, 'key');
    $indeksSekarang = $statusKey === 'menunggu_pembayaran' ? 0 : array_search($statusKey, $urutan);
    $indeksSekarang = $indeksSekarang === false ? 0 : $indeksSekarang;
@endphp

<div class="em-detail">
    <div class="em-wrap">

        <a href="{{ route('pesanan-saya.index') }}" class="em-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Pesanan Saya
        </a>

        {{-- HERO --}}
        <header class="em-hero">
            <div class="em-hero-text">
                <h1>Detail Pesanan</h1>
                <p>Informasi lengkap transaksi ELECTROMART kamu.</p>
            </div>

            <span class="em-status {{ $statusClass }}">
                <i class="fa-solid {{ $statusIcon }}"></i>
                {{ ucwords(str_replace('_', ' ', $statusKey)) }}
            </span>
        </header>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="em-alert success">
                <i class="fa-solid fa-circle-check"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="em-alert error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="em-alert error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div>
                    <strong>Periksa kembali data ulasan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- PROGRES PESANAN --}}
        @if ($statusKey === 'dibatalkan')
            <div class="em-alert error">
                <i class="fa-solid fa-circle-xmark"></i>
                <div>Pesanan ini telah dibatalkan.</div>
            </div>
        @else
            <section class="em-card em-track">
                <div class="em-track-list">
                    @foreach ($langkah as $i => $step)
                        <div class="em-track-step {{ $i <= $indeksSekarang ? 'done' : '' }} {{ $i === $indeksSekarang ? 'current' : '' }}">
                            <span class="em-track-dot">
                                <i class="fa-solid {{ $step['icon'] }}"></i>
                            </span>
                            <div class="em-track-label">{{ $step['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- PRODUK --}}
        <section class="em-card">
            <div class="em-card-head">
                <div>
                    <span class="em-label">Nomor pesanan</span>
                    <h2>#{{ $pesanan->id_pesanan }}</h2>
                </div>

                <div class="em-date">
                    <span class="em-label">Tanggal pesanan</span>
                    <strong>
                        {{ $pesanan->tanggal_pesanan
                            ? \Illuminate\Support\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y, H:i')
                            : '-' }}
                    </strong>
                </div>
            </div>

            <div class="em-card-body">
                <h3 class="em-title">
                    <span class="ico"><i class="fa-solid fa-box-open"></i></span>
                    Produk yang Dibeli
                </h3>

                @forelse ($pesanan->detailPesanan as $detail)
                    <div class="em-product">
                        <div class="em-product-info">
                            <div class="em-thumb">
                                @if ($detail->produk && $detail->produk->gambar)
                                    <img
                                        src="{{ asset('storage/' . $detail->produk->gambar) }}"
                                        alt="{{ $detail->produk->nama_produk }}"
                                        loading="lazy"
                                    >
                                @else
                                    <i class="fa-solid fa-box"></i>
                                @endif
                            </div>

                            <div>
                                <h4>{{ $detail->produk->nama_produk ?? 'Produk tidak tersedia' }}</h4>
                                <p>
                                    {{ $detail->jumlah }} barang &times;
                                    Rp{{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <strong class="em-product-subtotal">
                            Rp{{ number_format((float) $detail->subtotal, 0, ',', '.') }}
                        </strong>
                    </div>
                        {{-- RIWAYAT RETUR PRODUK --}}
                        @if ($pesanan->status_pesanan === 'selesai' && auth()->check())
                            @php
                                $daftarRetur = $detail->returProduk ?? collect();

                                $statusReturMap = [
                                    'diajukan' => [
                                        'label' => 'Menunggu Pemeriksaan',
                                        'warna' => '#b45309',
                                        'ikon' => 'fa-clock',
                                    ],
                                    'disetujui' => [
                                        'label' => 'Retur Disetujui',
                                        'warna' => '#15803d',
                                        'ikon' => 'fa-circle-check',
                                    ],
                                    'ditolak' => [
                                        'label' => 'Retur Ditolak',
                                        'warna' => '#b91c1c',
                                        'ikon' => 'fa-circle-xmark',
                                    ],
                                    'selesai' => [
                                        'label' => 'Retur Selesai',
                                        'warna' => '#15803d',
                                        'ikon' => 'fa-check-double',
                                    ],
                                ];
                            @endphp

                            @if ($daftarRetur->isNotEmpty())
                                <div class="em-box em-return">
                                    <h4>
                                        <i class="fa-solid fa-rotate-left"></i>
                                        Riwayat Retur Produk
                                    </h4>

                                    @foreach ($daftarRetur->sortByDesc('tanggal_retur') as $retur)
                                        @php
                                            $statusInfo = $statusReturMap[$retur->status_retur]
                                                ?? [
                                                    'label' => ucwords(str_replace('_', ' ', $retur->status_retur)),
                                                    'warna' => '#1d4ed8',
                                                    'ikon' => 'fa-circle-info',
                                                ];
                                        @endphp

                                        <div class="em-history">
                                            <strong>
                                                Pengajuan Retur
                                                @if ($retur->tanggal_retur)
                                                    — {{ \Illuminate\Support\Carbon::parse($retur->tanggal_retur)->format('d M Y, H:i') }}
                                                @endif
                                            </strong>

                                            <div class="em-history-item">
                                                <p>
                                                    Jumlah:
                                                    <strong>{{ $retur->jumlah_retur }} produk</strong>
                                                </p>

                                                <p>Alasan: {{ $retur->alasan }}</p>

                                                <p>
                                                    Status:
                                                    <strong style="color: {{ $statusInfo['warna'] }}">
                                                        <i class="fa-solid {{ $statusInfo['ikon'] }}"></i>
                                                        {{ $statusInfo['label'] }}
                                                    </strong>
                                                </p>

                                                @if ($retur->keputusan_admin)
                                                    <p>
                                                        Keputusan Admin:
                                                        {{ $retur->keputusan_admin }}
                                                    </p>
                                                @endif

                                                @if ($retur->status_retur === 'diajukan')
                                                    <p class="em-note">
                                                        Pengajuan kamu sedang menunggu pemeriksaan admin.
                                                    </p>
                                                @elseif ($retur->status_retur === 'disetujui')
                                                    <p class="em-note">
                                                        Pengajuan retur kamu telah disetujui oleh admin.
                                                        Silakan periksa catatan keputusan untuk instruksi selanjutnya.
                                                    </p>
                                                @elseif ($retur->status_retur === 'ditolak')
                                                    <p class="em-note">
                                                        Pengajuan retur kamu ditolak. Silakan periksa catatan keputusan admin.
                                                    </p>
                                                @elseif ($retur->status_retur === 'selesai')
                                                    <p class="em-note">
                                                        Proses retur kamu telah selesai.
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    {{-- ULASAN PRODUK --}}
                    @if ($pesanan->status_pesanan === 'selesai' && $detail->produk && auth()->check())
                        @php
                            $daftarUlasanProduk = $detail->produk->ulasanProduk ?? collect();
                            $ulasanSaya = $daftarUlasanProduk->firstWhere('id_user', auth()->user()->id_user);
                        @endphp

                        <div class="em-box em-review">
                            @if ($ulasanSaya)
                                <h4><i class="fa-solid fa-star"></i> Ulasan Kamu</h4>

                                <div class="em-stars">
                                    {{ str_repeat('★', (int) $ulasanSaya->rating) }}{{ str_repeat('☆', 5 - (int) $ulasanSaya->rating) }}
                                </div>

                                <p class="em-rating-text">Rating: {{ $ulasanSaya->rating }}/5</p>

                                <p class="em-comment">
                                    {{ $ulasanSaya->komentar ?: 'Kamu memberikan rating tanpa komentar.' }}
                                </p>

                                <p class="em-review-note">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Ulasan sudah dikirim dan tidak dapat diubah.
                                </p>
                            @else
                                <h4><i class="fa-solid fa-star"></i> Beri Ulasan Produk</h4>

                                <p class="em-box-desc">
                                    Bagikan pengalaman kamu setelah menerima produk.
                                </p>

                                <form
                                    action="{{ route('ulasan.store', ['id' => $detail->produk->id_produk]) }}"
                                    method="POST"
                                >
                                    @csrf

                                    <label for="rating-{{ $detail->produk->id_produk }}">
                                        Rating bintang
                                    </label>

                                    <select id="rating-{{ $detail->produk->id_produk }}" name="rating" required>
                                        <option value="">Pilih rating</option>

                                        @for ($bintang = 5; $bintang >= 1; $bintang--)
                                            <option
                                                value="{{ $bintang }}"
                                                @selected((int) old('rating') === $bintang)
                                            >
                                                {{ $bintang }} bintang
                                            </option>
                                        @endfor
                                    </select>

                                    <label for="komentar-{{ $detail->produk->id_produk }}">
                                        Komentar (opsional)
                                    </label>

                                    <textarea
                                        id="komentar-{{ $detail->produk->id_produk }}"
                                        name="komentar"
                                        rows="3"
                                        maxlength="2000"
                                        placeholder="Bagaimana pengalamanmu menggunakan produk ini?"
                                    >{{ old('komentar') }}</textarea>

                                    @error('rating')
                                        <p class="em-error">{{ $message }}</p>
                                    @enderror

                                    @error('komentar')
                                        <p class="em-error">{{ $message }}</p>
                                    @enderror

                                    <button type="submit" class="em-submit">Kirim Ulasan</button>
                                </form>
                            @endif
                        </div>
                    @endif
                @empty
                    <p class="em-muted">Rincian produk untuk pesanan ini belum tersedia.</p>
                @endforelse
            </div>
        </section>

        <div class="em-grid">

            {{-- ALAMAT & PENGIRIMAN --}}
            <section class="em-card">
                <div class="em-card-body">
                    <h3 class="em-title">
                        <span class="ico"><i class="fa-solid fa-location-dot"></i></span>
                        Alamat Pengiriman
                    </h3>

                    @if ($pesanan->alamat)
                        @foreach ([
                            'nama_penerima' => 'Nama Penerima',
                            'no_telp' => 'Nomor Telepon',
                            'alamat_lengkap' => 'Alamat',
                            'kelurahan' => 'Kelurahan',
                            'kecamatan' => 'Kecamatan',
                            'kota' => 'Kota/Kabupaten',
                            'provinsi' => 'Provinsi',
                            'kode_pos' => 'Kode Pos',
                        ] as $field => $label)
                            @if (filled(data_get($pesanan->alamat, $field)))
                                <div class="em-info-row">
                                    <span>{{ $label }}</span>
                                    <strong>{{ data_get($pesanan->alamat, $field) }}</strong>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="em-muted">Informasi alamat tidak tersedia.</p>
                    @endif

                    <h3 class="em-title spaced">
                        <span class="ico"><i class="fa-solid fa-truck-fast"></i></span>
                        Informasi Pengiriman
                    </h3>

                    @if ($pesanan->pengiriman)
                        <div class="em-info-row">
                            <span>Ekspedisi</span>
                            <strong>
                                {{ $pesanan->pengiriman->ekspedisi->nama_ekspedisi ?? 'Belum ditentukan' }}
                            </strong>
                        </div>

                        <div class="em-info-row">
                            <span>Status Pengiriman</span>
                            <strong>
                                {{ ucwords(str_replace('_', ' ', $pesanan->pengiriman->status_pengiriman ?? 'menunggu')) }}
                            </strong>
                        </div>

                        <div class="em-info-row">
                            <span>Nomor Resi</span>
                            <strong>{{ $pesanan->pengiriman->no_resi ?: 'Belum tersedia' }}</strong>
                        </div>

                        <div class="em-info-row">
                            <span>Tanggal Pengiriman</span>
                            <strong>
                                {{ $pesanan->pengiriman->tanggal_pengiriman
                                    ? \Illuminate\Support\Carbon::parse($pesanan->pengiriman->tanggal_pengiriman)->format('d M Y, H:i')
                                    : 'Belum dikirim' }}
                            </strong>
                        </div>
                    @else
                        <p class="em-muted">Informasi pengiriman belum tersedia.</p>
                    @endif
                </div>
            </section>

            {{-- PEMBAYARAN --}}
            <section class="em-card">
                <div class="em-card-body">
                    <h3 class="em-title">
                        <span class="ico"><i class="fa-solid fa-credit-card"></i></span>
                        Informasi Pembayaran
                    </h3>

                    @if ($pesanan->pembayaran)
                        <div class="em-info-row">
                            <span>Metode Pembayaran</span>
                            <strong>{{ strtoupper($pesanan->pembayaran->metode_pembayaran ?? '-') }}</strong>
                        </div>

                        <div class="em-info-row">
                            <span>Status Pembayaran</span>
                            <strong>
                                {{ ucwords(str_replace('_', ' ', $pesanan->pembayaran->status_pembayaran ?? 'menunggu')) }}
                            </strong>
                        </div>

                        <div class="em-info-row">
                            <span>Tanggal Pembayaran</span>
                            <strong>
                                {{ $pesanan->pembayaran->tanggal_pembayaran
                                    ? \Illuminate\Support\Carbon::parse($pesanan->pembayaran->tanggal_pembayaran)->format('d M Y, H:i')
                                    : 'Belum dibayar' }}
                            </strong>
                        </div>
                    @else
                        <p class="em-muted">Informasi pembayaran belum tersedia.</p>
                    @endif

                    <h3 class="em-title spaced">
                        <span class="ico"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                        Rincian Total
                    </h3>

                    <div class="em-info-row">
                        <span>Subtotal Produk</span>
                        <strong>
                            Rp{{ number_format((float) $pesanan->detailPesanan->sum('subtotal'), 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="em-info-row">
                        <span>Ongkos Kirim</span>
                        <strong>Rp{{ number_format((float) $pesanan->ongkir, 0, ',', '.') }}</strong>
                    </div>

                    <div class="em-total-row">
                        <span>Total Pembayaran</span>
                        <strong>
                            Rp{{ number_format((float) $pesanan->total_harga, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
            </section>

        </div>

        {{-- AKSI PESANAN --}}
        <div class="em-bottom" style="gap: 12px; flex-wrap: wrap;">
            @if ($pesanan->status_pesanan === 'selesai')
                <a
                    href="{{ route('pesanan-saya.retur.create', $pesanan->id_pesanan) }}"
                    class="em-btn-retur"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Ajukan Retur
                </a>
            @endif

            <a href="{{ route('shop.index') }}" class="em-btn-shop">
                <i class="fa-solid fa-bag-shopping"></i>
                Belanja Lagi
            </a>
        </div>

    </div>
</div>

@endsection