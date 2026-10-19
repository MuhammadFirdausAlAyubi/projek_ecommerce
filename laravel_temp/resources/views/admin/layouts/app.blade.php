    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin') | ELECTROMART</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --navy: #101828;
            --blue: #246bfd;
            --bg: #f5f7fb;
            --text: #182230;
            --muted: #788397;
            --border: #e8edf4;
        }

        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--text);
            background: var(--bg);
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
            inset: 0 auto 0 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            width: 250px;
            height: 100vh;
            padding: 25px 16px;
            overflow-x: hidden;
            overflow-y: auto;
            color: #b8c3d5;
            background: var(--navy);
            scrollbar-width: thin;
            scrollbar-color: #394860 var(--navy);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #394860;
            border-radius: 10px;
        }

        .brand {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 12px;
            padding: 0 10px 28px;
            color: #fff;
            font-size: 20px;
            font-weight: 800;
        }

        .brand-icon {
            display: grid;
            flex-shrink: 0;
            place-items: center;
            width: 38px;
            height: 38px;
            color: #fff;
            background: var(--blue);
            border-radius: 12px;
        }

        .brand-name span {
            color: #6da0ff;
        }

        .admin-profile {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 11px;
            padding: 15px 10px;
            margin-bottom: 15px;
            border-top: 1px solid #ffffff12;
            border-bottom: 1px solid #ffffff12;
        }

        .avatar {
            display: grid;
            flex-shrink: 0;
            place-items: center;
            width: 40px;
            height: 40px;
            color: #a9c7ff;
            background: #263b59;
            border-radius: 13px;
        }

        .admin-name {
            overflow-wrap: anywhere;
            color: #fff;
            font-weight: 700;
        }

        .admin-role {
            margin-top: 4px;
            color: #8795aa;
            font-size: 12px;
        }

        .nav-label {
            padding: 15px 12px 9px;
            color: #718097;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        .nav-link {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 13px;
            padding: 12px 13px;
            margin-bottom: 4px;
            color: #aebbd0;
            font-weight: 600;
            border-radius: 10px;
            transition: background .2s, color .2s;
        }

        .nav-link i {
            flex-shrink: 0;
            width: 19px;
            text-align: center;
        }

        .nav-link:hover {
            color: #fff;
            background: #ffffff0d;
        }

        .nav-link.active {
            color: #fff;
            background: var(--blue);
        }

        .sidebar-bottom {
            padding-top: 15px;
            margin-top: 15px;
            border-top: 1px solid #ffffff12;
        }

        .logout-button {
            display: flex;
            align-items: center;
            gap: 13px;
            width: 100%;
            padding: 12px 13px;
            color: #aebbd0;
            text-align: left;
            background: transparent;
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            transition: background .2s, color .2s;
        }

        .logout-button i {
            flex-shrink: 0;
            width: 19px;
            text-align: center;
        }

        .logout-button:hover {
            color: #ff9a9a;
            background: #ffffff0d;
        }

        /* MAIN CONTENT */
        .main {
            min-height: 100vh;
            margin-left: 250px;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            min-height: 76px;
            padding: 15px 34px;
            background: #fff;
            border-bottom: 1px solid var(--border);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .breadcrumb {
            overflow-wrap: anywhere;
            color: var(--muted);
        }

        .breadcrumb strong {
            color: var(--text);
        }

        .topbar-user {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .topbar-user i {
            color: var(--blue);
        }

        .content {
            width: 100%;
            max-width: 1650px;
            padding: 32px 34px 45px;
            margin: 0 auto;
        }

        /* MOBILE NAVIGATION */
        .mobile-menu {
            display: none;
            place-items: center;
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            color: var(--text);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 9px;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                padding: 14px 16px;
            }

            .content {
                padding: 24px 16px;
            }

            .mobile-menu {
                display: inline-grid;
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                z-index: 90;
                display: none;
                background: #10182880;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .topbar-user {
                font-size: 12px;
            }
        }

        @media (max-width: 420px) {
            .topbar {
                gap: 8px;
            }

            .topbar-user {
                max-width: 125px;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .breadcrumb {
                font-size: 12px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <span class="brand-icon">
                <i class="fa-solid fa-laptop"></i>
            </span>

            <span class="brand-name">ELECTRO<span>MART</span></span>
        </a>

        <div class="admin-profile">
            <div class="avatar">
                <i class="fa-solid fa-user-gear"></i>
            </div>

            <div>
                <div class="admin-name">
                    {{ auth()->user()->nama ?? 'Administrator' }}
                </div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>

        <div class="nav-label">MENU UTAMA</div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-label">MASTER PRODUK</div>

        <a
            href="{{ route('admin.produk.index') }}"
            class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-box-open"></i>
            <span>Produk</span>
        </a>

        <a
            href="{{ route('admin.kategori.index') }}"
            class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-layer-group"></i>
            <span>Kategori</span>
        </a>

        <a
            href="{{ route('admin.brand.index') }}"
            class="nav-link {{ request()->routeIs('admin.brand.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-tags"></i>
            <span>Brand</span>
        </a>

        <a
            href="{{ route('admin.stok.index') }}"
            class="nav-link {{ request()->routeIs('admin.stok.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Stok</span>
        </a>

        <a
            href="{{ route('admin.ulasan.index') }}"
            class="nav-link {{ request()->routeIs('admin.ulasan.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-star"></i>
            <span>Ulasan Produk</span>
        </a>

        <div class="nav-label">PENGADAAN BARANG</div>

        <a
            href="{{ route('admin.supplier.index') }}"
            class="nav-link {{ request()->routeIs('admin.supplier.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-people-carry-box"></i>
            <span>Supplier</span>
        </a>

        <a
            href="{{ route('admin.supplier-produk.index') }}"
            class="nav-link {{ request()->routeIs('admin.supplier-produk.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-link"></i>
            <span>Supplier Produk</span>
        </a>

        <a
            href="{{ route('admin.pembelian.index') }}"
            class="nav-link {{ request()->routeIs('admin.pembelian.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-cart-flatbed"></i>
            <span>Pembelian</span>
        </a>

        <div class="nav-label">TRANSAKSI PELANGGAN</div>

        <a
            href="{{ route('admin.user.index') }}"
            class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-users"></i>
            <span>User</span>
        </a>

        <a
            href="{{ route('admin.alamat.index') }}"
            class="nav-link {{ request()->routeIs('admin.alamat.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-map-location-dot"></i>
            <span>Alamat Pelanggan</span>
        </a>

        {{-- Keranjang ADMIN, bukan keranjang belanja pelanggan --}}
        <a
            href="{{ route('admin.keranjang.index') }}"
            class="nav-link {{ request()->routeIs('admin.keranjang.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Keranjang</span>
        </a>

        <a
            href="{{ route('admin.pesanan.index') }}"
            class="nav-link {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-receipt"></i>
            <span>Pesanan</span>
        </a>

        <a
            href="{{ route('admin.pembayaran.index') }}"
            class="nav-link {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-money-bill-transfer"></i>
            <span>Pembayaran</span>
        </a>

        <a
            href="{{ route('admin.retur.index') }}"
            class="nav-link {{ request()->routeIs('admin.retur.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-arrow-rotate-left"></i>
            <span>Retur Produk</span>
        </a>

        <div class="nav-label">PENGIRIMAN</div>

        <a
            href="{{ route('admin.pengiriman.index') }}"
            class="nav-link {{ request()->routeIs('admin.pengiriman.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-box"></i>
            <span>Pengiriman</span>
        </a>

        <a
            href="{{ route('admin.ekspedisi.index') }}"
            class="nav-link {{ request()->routeIs('admin.ekspedisi.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-truck-fast"></i>
            <span>Ekspedisi</span>
        </a>

        <div class="nav-label">PENGATURAN PEMBAYARAN</div>

        <a
            href="{{ route('admin.bank.index') }}"
            class="nav-link {{ request()->routeIs('admin.bank.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-building-columns"></i>
            <span>Bank</span>
        </a>

        <div class="sidebar-bottom">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-button">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar dari akun</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button
                    type="button"
                    class="mobile-menu"
                    id="mobileMenu"
                    aria-label="Buka menu"
                    aria-controls="adminSidebar"
                    aria-expanded="false"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="breadcrumb">
                    Admin / <strong>@yield('breadcrumb', 'Dashboard')</strong>
                </div>
            </div>

            <div class="topbar-user">
                <i class="fa-solid fa-circle-user"></i>
                <span>{{ auth()->user()->nama ?? 'Administrator' }}</span>
            </div>
        </header>

        <div class="content">
            @yield('content')
        </div>
    </main>

    <script>
        (() => {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const menu = document.getElementById('mobileMenu');

            const sidebarScrollKey = 'electromart_admin_sidebar_scroll';

            // Pulihkan posisi scroll sidebar saat halaman dibuka.
            try {
                const savedScroll = sessionStorage.getItem(sidebarScrollKey);

                if (savedScroll !== null) {
                    sidebar.scrollTop = Number(savedScroll) || 0;
                }
            } catch (error) {
                // Abaikan jika sessionStorage tidak tersedia.
            }

            // Simpan posisi scroll sidebar.
            sidebar.addEventListener('scroll', function () {
                try {
                    sessionStorage.setItem(
                        sidebarScrollKey,
                        String(sidebar.scrollTop)
                    );
                } catch (error) {
                    // Navigasi tetap berjalan.
                }
            });

            // Simpan posisi sebelum berpindah menu.
            sidebar.querySelectorAll('a.nav-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    try {
                        sessionStorage.setItem(
                            sidebarScrollKey,
                            String(sidebar.scrollTop)
                        );
                    } catch (error) {
                        // Navigasi tetap berjalan.
                    }
                });
            });

            // Buka atau tutup sidebar mobile.
            function toggleAdminSidebar() {
                const isOpen = sidebar.classList.toggle('open');

                overlay.classList.toggle('show', isOpen);
                menu.setAttribute('aria-expanded', String(isOpen));
                document.body.style.overflow = isOpen ? 'hidden' : '';
            }

            function closeAdminSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                menu.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            menu.addEventListener('click', toggleAdminSidebar);
            overlay.addEventListener('click', closeAdminSidebar);

            // Tutup sidebar setelah menu dipilih pada layar mobile.
            sidebar.querySelectorAll('a.nav-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768) {
                        closeAdminSidebar();
                    }
                });
            });

            // Pulihkan tampilan ketika kembali ke layar desktop.
            window.addEventListener('resize', function () {
                if (window.innerWidth > 768) {
                    closeAdminSidebar();
                }
            });

            // Tombol Escape menutup sidebar mobile.
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeAdminSidebar();
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
