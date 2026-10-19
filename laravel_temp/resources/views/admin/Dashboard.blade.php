<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Admin | ELECTROMART</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --navy: #101828;
            --navy-light: #182438;
            --blue: #246bfd;
            --blue-soft: #edf4ff;
            --bg: #f5f7fb;
            --text: #182230;
            --muted: #788397;
            --border: #e8edf4;
            --white: #ffffff;
            --green: #15966a;
            --orange: #d97706;
            --red: #dc3545;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font: inherit;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            height: 100vh;

            background: var(--navy);
            color: #b8c3d5;
            padding: 25px 16px;

            display: flex;
            flex-direction: column;

            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: #394860 #101828;

            z-index: 100;
            transition: transform .25s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #101828;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #394860;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #526580;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 28px;
            color: white;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -.7px;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            background: var(--blue);
            border-radius: 12px;
            box-shadow: 0 6px 18px #246bfd45;
        }

        .brand span span {
            color: #6da0ff;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 15px 10px;
            margin-bottom: 15px;
            border-top: 1px solid #ffffff12;
            border-bottom: 1px solid #ffffff12;
            flex-shrink: 0;
        }

        .avatar {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 13px;
            background: #263b59;
            color: #a9c7ff;
            display: grid;
            place-items: center;
            font-size: 18px;
        }

        .admin-name {
            color: white;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .admin-role {
            font-size: 12px;
            color: #8795aa;
            margin-top: 4px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.4px;
            color: #718097;
            padding: 15px 12px 9px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 13px;
            border-radius: 10px;
            margin-bottom: 4px;
            color: #aebbd0;
            font-weight: 600;
            transition: background .2s, color .2s;
            flex-shrink: 0;
        }

        .nav-link i {
            width: 19px;
            flex-shrink: 0;
            text-align: center;
            font-size: 15px;
        }

        .nav-link:hover {
            background: #ffffff0d;
            color: white;
        }

        .nav-link.active {
            color: white;
            background: var(--blue);
            box-shadow: 0 6px 18px #246bfd35;
        }

        .sidebar-bottom {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ffffff12;
            flex-shrink: 0;
        }

        .logout-button {
            display: flex;
            align-items: center;
            gap: 13px;
            width: 100%;
            border: 0;
            background: transparent;
            color: #aebbd0;
            padding: 12px 13px;
            cursor: pointer;
            text-align: left;
            border-radius: 10px;
        }

        .logout-button:hover {
            color: #ff9a9a;
            background: #ffffff0d;
        }

        /* MAIN */

        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            height: 76px;
            padding: 0 34px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .menu-toggle {
            display: none;
            width: 38px;
            height: 38px;
            border: 1px solid var(--border);
            background: white;
            border-radius: 10px;
            cursor: pointer;
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 13px;
        }

        .breadcrumb strong {
            color: var(--text);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .online-dot {
            width: 8px;
            height: 8px;
            display: inline-block;
            border-radius: 50%;
            background: #16a36c;
            margin-right: 5px;
        }

        .topbar-avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: var(--blue-soft);
            color: var(--blue);
        }

        .content {
            padding: 32px 34px 45px;
            max-width: 1650px;
            margin: auto;
        }

        .page-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 27px;
        }

        .eyebrow {
            color: var(--blue);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 9px;
        }

        h1 {
            font-size: clamp(25px, 3vw, 32px);
            line-height: 1.2;
            letter-spacing: -1.1px;
            margin: 0;
            font-weight: 800;
        }

        .subtitle {
            color: var(--muted);
            margin: 9px 0 0;
            font-size: 14px;
            line-height: 1.6;
        }

        .date-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1px solid var(--border);
            padding: 11px 14px;
            border-radius: 10px;
            color: #596579;
            white-space: nowrap;
        }

        /* ALERTS */

        .alert {
            padding: 14px 17px;
            border-radius: 12px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .alert-success {
            background: #eaf8f1;
            color: #14774f;
            border: 1px solid #c9efdc;
        }

        .alert-danger {
            background: #fff0f0;
            color: #b42332;
            border: 1px solid #ffd6d6;
        }

        /* STATISTICS */

        .section-caption {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .7px;
            color: #7a8699;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            margin-bottom: 22px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 21px;
            min-width: 0;
            box-shadow: 0 3px 10px #172b4d05;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px #172b4d0c;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 21px;
        }

        .stat-label {
            font-weight: 600;
            color: #667085;
            font-size: 13px;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .icon-blue {
            color: #246bfd;
            background: #edf4ff;
        }

        .icon-green {
            color: #15966a;
            background: #e9f8f1;
        }

        .icon-purple {
            color: #7952d6;
            background: #f1edff;
        }

        .icon-orange {
            color: #d97706;
            background: #fff4df;
        }

        .stat-number {
            font-size: clamp(27px, 2.3vw, 34px);
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .stat-note {
            margin-top: 8px;
            color: #8792a4;
            font-size: 12px;
        }

        /* CONTENT CARDS */

        .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 3px 10px #172b4d05;
            margin-bottom: 22px;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 21px 23px;
            border-bottom: 1px solid var(--border);
        }

        .panel-title {
            font-size: 16px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -.3px;
        }

        .panel-subtitle {
            font-size: 12px;
            color: var(--muted);
            margin-top: 5px;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .heading-icon {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            color: var(--blue);
            background: var(--blue-soft);
            flex-shrink: 0;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        thead {
            background: #fafbfd;
        }

        th {
            text-align: left;
            color: #8792a4;
            font-size: 11px;
            letter-spacing: .6px;
            text-transform: uppercase;
            font-weight: 800;
            padding: 15px 23px;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 17px 23px;
            border-bottom: 1px solid #f0f2f6;
            font-size: 13px;
            color: #475467;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        tbody tr:hover {
            background: #fafcff;
        }

        .product-id {
            font-weight: 700;
            color: #7b8799;
        }

        .product-name {
            font-weight: 700;
            color: #202c40;
        }

        .product-sub {
            display: block;
            color: #98a2b3;
            font-size: 11px;
            margin-top: 4px;
        }

        .price {
            font-weight: 700;
            color: #202c40;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 700;
            background: #f0f2f6;
            color: #596579;
        }

        .pill-active {
            color: #13784e;
            background: #e8f8ef;
        }

        .pill-inactive {
            color: #b42332;
            background: #fff0f0;
        }

        .empty-state {
            text-align: center;
            padding: 42px 20px;
            white-space: normal;
        }

        .empty-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            background: #f0f4fa;
            color: #8a97aa;
            font-size: 21px;
        }

        .empty-title {
            font-weight: 700;
            color: #344054;
            margin-bottom: 6px;
        }

        .empty-description {
            color: #98a2b3;
            font-size: 12px;
        }

        .stock-panel {
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stock-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: #c77712;
            background: #fff4df;
            font-size: 18px;
        }

        .stock-title {
            color: #7b8799;
            font-size: 12px;
            font-weight: 600;
        }

        .stock-number {
            margin-top: 5px;
            font-size: 24px;
            font-weight: 800;
        }

        .footer {
            text-align: center;
            padding: 18px;
            color: #98a2b3;
            font-size: 12px;
        }

        .footer strong {
            color: #667085;
        }

        .overlay {
            display: none;
        }

        /* RESPONSIVE */

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content {
                padding: 27px 24px;
            }

            .topbar {
                padding: 0 24px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .menu-toggle {
                display: grid;
                place-items: center;
            }

            .overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: #10182880;
                z-index: 90;
            }

            .topbar {
                height: 66px;
                padding: 0 17px;
            }

            .content {
                padding: 24px 16px;
            }

            .page-heading {
                flex-direction: column;
            }

            .date-label {
                display: none;
            }

            .stats-grid {
                gap: 11px;
            }

            .stat-card {
                padding: 15px;
                border-radius: 13px;
            }

            .stat-top {
                align-items: flex-start;
                flex-direction: column-reverse;
                margin-bottom: 15px;
                gap: 12px;
            }

            .stat-icon {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }

            .panel-header {
                padding: 17px;
            }

            th, td {
                padding: 14px 16px;
            }

            .breadcrumb {
                font-size: 12px;
            }
        }

        @media (max-width: 380px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-top {
                flex-direction: row;
                align-items: center;
            }
        }
    </style>
</head>

<body>
<div class="app">

    <div class="overlay" id="overlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <a href="{{ route('admin.dashboard') }}" class="brand">
            <span class="brand-icon">
                <i class="fa-solid fa-laptop"></i>
            </span>
            <span>ELECTRO<span>MART</span></span>
        </a>

        <div class="admin-profile">
            <div class="avatar">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div>
                <div class="admin-name">
                    {{ auth()->user()->nama ?? 'Administrator' }}
                </div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>

        <div class="nav-label">MENU UTAMA</div>

        <a href="{{ route('admin.dashboard') }}" class="nav-link active">
            <i class="fa-solid fa-chart-pie"></i>
            Dashboard
        </a>

        <div class="nav-label">MASTER PRODUK</div>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-box"></i>
            Produk
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-list"></i>
            Kategori
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-tags"></i>
            Brand
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-warehouse"></i>
            Stok
        </a>

        <div class="nav-label">PENGADAAN BARANG</div>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-truck-field"></i>
            Supplier
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-link"></i>
            Supplier Produk
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-cart-flatbed"></i>
            Pembelian
        </a>

        <div class="nav-label">TRANSAKSI PELANGGAN</div>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-users"></i>
            Pengguna
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-location-dot"></i>
            Alamat Pelanggan
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-cart-shopping"></i>
            Keranjang
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-receipt"></i>
            Pesanan
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-credit-card"></i>
            Pembayaran
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-rotate-left"></i>
            Retur Produk
        </a>

        <div class="nav-label">PENGIRIMAN</div>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-truck-fast"></i>
            Pengiriman
        </a>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-shipping-fast"></i>
            Ekspedisi
        </a>

        <div class="nav-label">PENGATURAN PEMBAYARAN</div>

        <a href="#" class="nav-link">
            <i class="fa-solid fa-building-columns"></i>
            Bank
        </a>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Keluar dari akun
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">

        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle"
                        type="button" aria-label="Buka menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="breadcrumb">
                    Admin / <strong>Dashboard</strong>
                </div>
            </div>

            <div class="topbar-right">
                <span style="color:#667085;font-size:12px">
                    <span class="online-dot"></span>Admin aktif
                </span>
                <div class="topbar-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>

        <div class="content">

            <div class="page-heading">
                <div>
                    <div class="eyebrow">ELECTROMART ADMIN PANEL</div>
                    <h1>Dashboard Overview</h1>
                    <p class="subtitle">
                        Halo, {{ auth()->user()->nama ?? 'Administrator' }}.
                        Pantau pengelolaan toko elektronik lu dari sini.
                    </p>
                </div>

                <div class="date-label">
                    <i class="fa-regular fa-calendar"></i>
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="section-caption">Ringkasan toko</div>

            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Produk</span>
                        <span class="stat-icon icon-blue">
                            <i class="fa-solid fa-box"></i>
                        </span>
                    </div>
                    <div class="stat-number">
                        {{ number_format($totalProduk, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">Produk terdaftar di katalog</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Kategori</span>
                        <span class="stat-icon icon-green">
                            <i class="fa-solid fa-layer-group"></i>
                        </span>
                    </div>
                    <div class="stat-number">
                        {{ number_format($totalKategori, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">Kategori produk elektronik</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Brand</span>
                        <span class="stat-icon icon-purple">
                            <i class="fa-solid fa-tags"></i>
                        </span>
                    </div>
                    <div class="stat-number">
                        {{ number_format($totalBrand, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">Merek yang tersedia</div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <span class="stat-label">Total Pelanggan</span>
                        <span class="stat-icon icon-orange">
                            <i class="fa-solid fa-users"></i>
                        </span>
                    </div>
                    <div class="stat-number">
                        {{ number_format($totalPelanggan, 0, ',', '.') }}
                    </div>
                    <div class="stat-note">Akun dengan role pelanggan</div>
                </div>

            </div>

            <section class="panel">
                <div class="stock-panel">
                    <div class="stock-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <div class="stock-title">Produk dengan stok menipis</div>
                        <div class="stock-number">
                            {{ number_format($totalStokMenipis, 0, ',', '.') }}
                            <span style="font-size:13px;font-weight:500;color:#8792a4">
                                baris stok
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div class="panel-heading">
                        <div class="heading-icon">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div>
                            <h2 class="panel-title">Produk Terbaru</h2>
                            <div class="panel-subtitle">
                                Lima produk terakhir yang tercatat di katalog.
                            </div>
                        </div>
                    </div>

                    <span class="pill">
                        {{ $produkTerbaru->count() }} produk
                    </span>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Brand</th>
                                <th>Harga Jual</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($produkTerbaru as $produk)
                                <tr>
                                    <td>
                                        <span class="product-id">
                                            #{{ $produk->id_produk }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="product-name">
                                            {{ $produk->nama_produk }}
                                        </span>
                                        <span class="product-sub">
                                            ELECTROMART product catalog
                                        </span>
                                    </td>

                                    <td>{{ $produk->nama_kategori ?? '-' }}</td>

                                    <td>{{ $produk->nama_brand ?? '-' }}</td>

                                    <td class="price">
                                        Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        @php
                                            $status = strtolower((string) $produk->status_produk);
                                        @endphp

                                        <span class="pill {{ in_array($status, ['aktif', 'active', 'tersedia']) ? 'pill-active' : (in_array($status, ['nonaktif', 'inactive']) ? 'pill-inactive' : '') }}">
                                            <i class="fa-solid fa-circle" style="font-size:6px"></i>
                                            {{ $produk->status_produk ?? 'Belum diatur' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fa-solid fa-box-open"></i>
                                            </div>
                                            <div class="empty-title">
                                                Belum ada produk
                                            </div>
                                            <div class="empty-description">
                                                Produk yang ditambahkan akan tampil di bagian ini.
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <footer class="footer">
                © {{ date('Y') }} <strong>ELECTROMART</strong> ·
                Admin Panel · Sistem Pengelolaan Toko Elektronik
            </footer>

        </div>
    </main>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuToggle = document.getElementById('menuToggle');

    function toggleSidebar() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    }

    menuToggle.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
</script>

</body>
</html>
