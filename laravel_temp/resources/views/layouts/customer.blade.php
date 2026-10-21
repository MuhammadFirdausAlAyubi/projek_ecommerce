<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Beranda') | ELECTROMART</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --em-primary: #155eef;
            --em-primary-dark: #1048c7;
            --em-ink: #172033;
            --em-muted: #667085;
            --em-line: #e6eaf0;
            --em-bg: #f7f9fc;
            --em-footer: #0b1d38;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 170px;
        }

        body {
            margin: 0;
            color: var(--em-ink);
            background: #fff;
            font-family: 'DM Sans', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select {
            font: inherit;
        }

        /* STICKY HEADER */
        .em-sticky-header {
            position: sticky;
            top: 0;
            z-index: 1050;
            width: 100%;
            background: #fff;
            box-shadow: 0 3px 14px rgba(16, 24, 40, .04);
        }

        /* TOPBAR */
        .em-topbar {
            background: #101828;
            color: #e8edf6;
            font-size: 11px;
        }

        .em-topbar-inner {
            width: calc(100% - 96px);
            max-width: 1400px;
            min-height: 33px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        /* HEADER UTAMA */
        .em-header {
            background: #fff;
            border-bottom: 1px solid var(--em-line);
        }

        .em-header-main {
            width: calc(100% - 96px);
            max-width: 1400px;
            min-height: 84px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: auto minmax(220px, 1fr) auto;
            align-items: center;
            gap: 30px;
        }

        .em-logo {
            color: var(--em-ink);
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1.2px;
            white-space: nowrap;
        }

        .em-logo span {
            color: var(--em-primary);
        }

        .em-logo:hover {
            color: var(--em-ink);
        }

        /* SEARCH BAR */
        .em-search {
            display: flex;
            width: 100%;
            max-width: 650px;
            height: 46px;
            margin: auto;
            overflow: hidden;
            border: 1px solid #d0d5dd;
            border-radius: 8px;
            background: #f9fafb;
            transition: border-color .2s, box-shadow .2s;
        }

        .em-search:focus-within {
            border-color: var(--em-primary);
            box-shadow: 0 0 0 3px rgba(21, 94, 239, .09);
        }

        .em-search input {
            width: 100%;
            min-width: 0;
            padding: 0 15px;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--em-ink);
            font-size: 13px;
        }

        .em-search input::placeholder {
            color: #7b8496;
        }

        .em-search button {
            display: grid;
            place-items: center;
            width: 50px;
            flex: 0 0 50px;
            border: 0;
            background: var(--em-primary);
            color: #fff;
            cursor: pointer;
            transition: background .2s;
        }

        .em-search button:hover {
            background: var(--em-primary-dark);
        }

        /* AKUN DAN KERANJANG */
        .em-actions {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .em-action {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #344054;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .em-action i {
            color: var(--em-primary);
            font-size: 19px;
        }

        .em-action:hover {
            color: var(--em-primary);
        }

        /* NAVIGASI KATEGORI */
        .em-categories {
            background: #fff;
            border-bottom: 1px solid var(--em-line);
        }

        .em-categories-inner {
            width: calc(100% - 96px);
            max-width: 1400px;
            min-height: 46px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 30px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .em-categories-inner::-webkit-scrollbar {
            display: none;
        }

        .em-categories a {
            flex: 0 0 auto;
            padding: 15px 0 13px;
            border-bottom: 2px solid transparent;
            color: #475467;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            transition: color .2s, border-color .2s;
        }

        .em-categories a:hover,
        .em-categories a.active {
            color: var(--em-primary);
            border-bottom-color: var(--em-primary);
        }

        /* KONTEN HALAMAN */
        .em-main {
            min-height: 60vh;
            background: var(--em-bg);
        }

        /* FOOTER */
        .em-footer {
            background: var(--em-footer);
            color: #f8fafc;
        }

        .em-footer-inner {
            width: calc(100% - 96px);
            max-width: 1400px;
            margin: 0 auto;
            padding: 34px 0 18px;
        }

        .em-footer-topline {
            height: 1px;
            margin-bottom: 24px;
            background: rgba(255, 255, 255, .32);
        }

        .em-footer-grid {
            display: grid;
            grid-template-columns: 1.2fr 1.2fr 1fr;
            gap: 48px;
        }

        .em-footer h3 {
            margin: 0 0 14px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
        }

        .em-footer p,
        .em-footer a {
            color: #e2e8f0;
            font-size: 13px;
            line-height: 1.7;
        }

        .em-footer p {
            margin-bottom: 10px;
        }

        .em-footer a:hover {
            color: #8eb4ff;
        }

        .em-footer-contact {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 9px 0;
        }

        .em-footer-contact i {
            width: 15px;
            padding-top: 4px;
            color: #cbd5e1;
            text-align: center;
        }

        .em-footer-links {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .em-footer-socials {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 5px 0 22px;
        }

        .em-footer-socials a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 28px;
            transition: transform .2s, color .2s;
        }

        .em-footer-socials a:hover {
            transform: translateY(-3px);
            color: #8eb4ff;
        }

        .em-footer-brand {
            display: inline-block;
            color: #fff !important;
            font-size: 25px !important;
            font-weight: 800;
            letter-spacing: -.8px;
        }

        .em-footer-brand span {
            color: #8eb4ff;
        }

        .em-footer-brand-note {
            margin-top: 3px;
            color: #b7c5da;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .em-footer-bottom {
            margin-top: 28px;
            color: #f1f5f9;
            font-size: 12px;
            line-height: 1.7;
            text-align: center;
        }

        /* =====================================================
           CARD PRODUK (dipakai beranda, semua produk, kategori)
           Ubah di sini, semua halaman ikut berubah.
        ===================================================== */
        .pcard-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:12px;align-items:stretch;width:100%}
        .pcard{display:flex;flex-direction:column;min-width:0;overflow:hidden;background:#fff;border:1px solid #e6eaf0;border-radius:10px;transition:transform .2s,box-shadow .2s,border-color .2s}
        .pcard:hover{transform:translateY(-2px);border-color:#d5e1fa;box-shadow:0 7px 18px rgba(23,32,51,.07)}
        .pcard-link{display:flex;flex:1;flex-direction:column;min-width:0;color:inherit;text-decoration:none}
        .pcard-link:hover{color:inherit}
        .pcard-image{display:flex;align-items:center;justify-content:center;width:100%;height:165px;padding:10px;overflow:hidden;background:#f7f9fc;box-sizing:border-box}
        .pcard-image img{display:block;width:100%;height:100%;object-fit:contain;transition:transform .25s}
        .pcard:hover .pcard-image img{transform:scale(1.03)}
        .pcard-placeholder{display:flex;align-items:center;justify-content:center;width:100%;height:100%;color:#98a2b3;font-size:11px;text-align:center}
        .pcard-info{display:flex;flex:1;flex-direction:column;align-items:flex-start;gap:5px;min-width:0;padding:10px;box-sizing:border-box}
        .pcard-brand{color:#667085;font-size:10px;line-height:1.4}
        .pcard-name{display:-webkit-box;width:100%;min-height:32px;margin:0;overflow:hidden;color:#172033;font-size:12px;font-weight:600;line-height:1.4;overflow-wrap:anywhere;-webkit-box-orient:vertical;-webkit-line-clamp:2}
        .pcard-rating{display:flex;flex-wrap:wrap;align-items:center;gap:4px;font-size:11px;line-height:1.4}
        .pcard-price{margin-top:auto;padding-top:5px;color:#155eef;font-size:14px;font-weight:700;line-height:1.4;overflow-wrap:anywhere}
        .pcard-stock{color:#667085;font-size:10px}
        .pcard-stock.tersedia{color:#15803d}
        .pcard-stock.habis{color:#dc2626}
        @media(max-width:540px){.pcard-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.pcard-image{height:145px;padding:8px}.pcard-info{padding:9px}.pcard-price{font-size:13px}}
        @media(max-width:380px){.pcard-grid{gap:8px}.pcard-image{height:125px}.pcard-info{padding:8px}.pcard-price{font-size:12px}}

        /* TABLET */
        @media (max-width: 1100px) {
            .em-header-main {
                gap: 18px;
            }

            .em-categories-inner {
                gap: 24px;
            }

            .em-footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }

            .em-footer-social-col {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 900px) {
            .em-header-main {
                grid-template-columns: 1fr auto;
                gap: 15px;
                padding-top: 15px;
                padding-bottom: 15px;
            }

            .em-search {
                grid-column: 1 / -1;
                grid-row: 2;
                max-width: none;
            }

            .em-action .em-action-label {
                display: none;
            }
        }

        /* MOBILE */
        @media (max-width: 560px) {
            html {
                scroll-padding-top: 145px;
            }

            .em-topbar-inner {
                width: calc(100% - 32px);
                min-height: 30px;
                justify-content: center;
                text-align: center;
            }

            .em-topbar-inner span:last-child {
                display: none;
            }

            .em-header-main {
                width: calc(100% - 32px);
                min-height: auto;
                padding: 13px 0;
            }

            .em-logo {
                font-size: 22px;
            }

            .em-actions {
                gap: 15px;
            }

            .em-action i {
                font-size: 18px;
            }

            .em-search {
                height: 42px;
            }

            .em-categories-inner {
                width: calc(100% - 32px);
                min-height: 43px;
                gap: 22px;
            }

            .em-categories a {
                padding: 13px 0 11px;
            }

            .em-footer-inner {
                width: calc(100% - 36px);
                padding-top: 28px;
            }

            .em-footer-grid {
                grid-template-columns: 1fr;
                gap: 26px;
            }

            .em-footer-social-col {
                grid-column: auto;
            }

            .em-footer h3 {
                font-size: 15px;
            }

            .em-footer p,
            .em-footer a {
                font-size: 12px;
            }

            .em-footer-socials a {
                font-size: 25px;
            }

            .em-footer-bottom {
                font-size: 10px;
            }
        }
    </style>

    {{-- CSS KHUSUS HALAMAN --}}
    @stack('styles')
</head>

<body>

    {{-- HEADER STICKY --}}
    <div class="em-sticky-header">

        {{-- TOPBAR --}}
        <div class="em-topbar">
            <div class="em-topbar-inner">
                <span>
                    <i class="fa-solid fa-headset me-2"></i>
                    Temukan perangkat yang sesuai kebutuhanmu
                </span>

                <span>
                    <i class="fa-solid fa-shield-halved me-2"></i>
                    Belanja elektronik dengan lebih praktis
                </span>
            </div>
        </div>

        {{-- HEADER UTAMA --}}
        <header class="em-header">
            <div class="em-header-main">

                <a href="{{ route('home') }}" class="em-logo">
                    ELECTRO<span>MART</span>
                </a>

                <form class="em-search" action="{{ route('shop.index') }}" method="GET" role="search">
                    <input
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari smartphone, laptop, aksesori..."
                        aria-label="Cari produk">

                    <button type="submit" aria-label="Cari produk">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

                <div class="em-actions">

                    {{-- AKUN: profil jika sudah login, login jika belum --}}
                    <a href="{{ auth()->check() ? route('account.profile') : route('login') }}" class="em-action">
                        <i class="fa-regular fa-user"></i>
                        <span class="em-action-label">Akun</span>
                    </a>

                    {{-- KERANJANG --}}
                    <a href="{{ route('keranjang.index') }}" class="em-action">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span class="em-action-label">Keranjang</span>
                    </a>

                </div>
            </div>
        </header>

        {{-- NAVIGASI KATEGORI --}}
        <nav class="em-categories" aria-label="Kategori produk">
            <div class="em-categories-inner">

                <a href="{{ route('shop.index') }}"
                   class="{{ request()->routeIs('shop.index') ? 'active' : '' }}">
                    Semua Produk
                </a>

                <a href="{{ route('shop.category', ['category' => 'smartphone']) }}"
                   class="{{ request()->is('shop/smartphone') ? 'active' : '' }}">
                    Smartphone
                </a>

                <a href="{{ route('shop.category', ['category' => 'laptop']) }}"
                   class="{{ request()->is('shop/laptop') ? 'active' : '' }}">
                    Laptop
                </a>

                <a href="{{ route('shop.category', ['category' => 'komputer']) }}"
                   class="{{ request()->is('shop/komputer') ? 'active' : '' }}">
                    Komputer
                </a>

                <a href="{{ route('shop.category', ['category' => 'aksesori']) }}"
                   class="{{ request()->is('shop/aksesori') ? 'active' : '' }}">
                    Aksesori
                </a>

                <a href="{{ route('shop.category', ['category' => 'gaming']) }}"
                   class="{{ request()->is('shop/gaming') ? 'active' : '' }}">
                    Gaming
                </a>

                <a href="{{ route('shop.category', ['category' => 'networking']) }}"
                   class="{{ request()->is('shop/networking') ? 'active' : '' }}">
                    Networking
                </a>

            </div>
        </nav>

    </div>

    {{-- KONTEN HALAMAN --}}
    <main class="em-main">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="em-footer">
        <div class="em-footer-inner">

            <div class="em-footer-topline"></div>

            <div class="em-footer-grid">

                {{-- INFORMASI KONTAK --}}
                <section>
                    <h3>Informasi Kontak</h3>

                    <p>
                        Jika Anda memerlukan bantuan atau memiliki masukan,
                        silakan hubungi kami.
                    </p>

                    <div class="em-footer-contact">
                        <i class="fa-regular fa-clock"></i>
                        <div>
                            Jam Operasional:
                            <strong>09:00 - 22:00</strong>
                        </div>
                    </div>

                    <div class="em-footer-contact">
                        <i class="fa-brands fa-whatsapp"></i>
                        <div>
                            WhatsApp:
                            <a href="https://wa.me/6285136446683" target="_blank" rel="noopener noreferrer">
                                0851 3644 6683
                            </a>
                        </div>
                    </div>

                    <div class="em-footer-contact">
                        <i class="fa-solid fa-phone"></i>
                        <div>
                            Layanan pelanggan:
                            <a href="tel:+6285136446683">
                                0851 3644 6683
                            </a>
                        </div>
                    </div>

                    <div class="em-footer-contact">
                        <i class="fa-regular fa-envelope"></i>
                        <div>
                            Email:
                            <a href="mailto:muhammadfirdausalayubi22@gmail.com">
                                muhammadfirdausalayubi22@gmail.com
                            </a>
                        </div>
                    </div>

                    <p class="mt-3">
                        ELECTROMART — toko elektronik untuk kebutuhan teknologi Anda.
                    </p>
                </section>

                {{-- KEBIJAKAN DAN PEDOMAN --}}
                <section>
                    <h3>Kebijakan &amp; Pedoman</h3>

                    <div class="em-footer-links">
                        <a href="{{ url('/about') }}">Tentang Kami</a>
                        <a href="{{ url('/warranty') }}">Kebijakan Garansi</a>
                        <a href="{{ url('/returns') }}">Ketentuan Pengembalian dan Penggantian</a>
                        <a href="{{ url('/privacy') }}">Kebijakan Privasi</a>
                        <a href="{{ url('/terms') }}">Syarat dan Ketentuan</a>
                        <a href="{{ url('/shipping') }}">Panduan Pengiriman</a>
                        <a href="{{ url('/help') }}">Pusat Bantuan</a>
                    </div>
                </section>

                {{-- MEDIA SOSIAL --}}
                <section class="em-footer-social-col">
                    <h3>Media Sosial</h3>

                    <div class="em-footer-socials">

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/6285136446683"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="WhatsApp ELECTROMART"
                           title="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>

                        {{-- Instagram --}}
                        <a href="https://www.instagram.com/supriiiiiiiiiiiiiii.i/"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="Instagram"
                           title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        {{-- TikTok --}}
                        <a href="https://www.tiktok.com/@suprieeeeeee"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="TikTok"
                           title="TikTok">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>

                    </div>

                    {{-- LOGO KEMBALI KE BERANDA --}}
                    <a href="{{ route('home') }}"
                       class="em-footer-brand"
                       aria-label="ELECTROMART - Beranda">
                        ELECTRO<span>MART</span>
                    </a>

                    <div class="em-footer-brand-note">
                        ELECTRONICS &amp; TECHNOLOGY
                    </div>
                </section>

            </div>

            <div class="em-footer-bottom">
                &copy; {{ date('Y') }} ELECTROMART.
                SELURUH HAK DILINDUNGI.
            </div>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JAVASCRIPT KHUSUS HALAMAN --}}
    @stack('scripts')

</body>
</html>
