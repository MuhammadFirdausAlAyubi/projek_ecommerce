@extends('layouts.customer')

@section('title', $data['title'])

@push('styles')
    <style>
        .footer-info-page {
            padding: 42px 0 64px;
            background: #f7f9fc;
        }

        .footer-info-breadcrumb {
            font-size: 13px;
            margin-bottom: 24px;
        }

        .footer-info-breadcrumb a {
            color: #155eef;
            text-decoration: none;
        }

        .footer-info-breadcrumb a:hover {
            text-decoration: underline;
        }

        .footer-info-card {
            background: #fff;
            border: 1px solid #e6eaf0;
            border-radius: 14px;
            padding: 36px;
            box-shadow: 0 8px 30px rgba(16, 24, 40, .04);
        }

        .footer-info-label {
            display: inline-block;
            background: #eaf1ff;
            color: #155eef;
            border-radius: 6px;
            padding: 6px 11px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .footer-info-title {
            color: #172033;
            font-size: 30px;
            line-height: 1.3;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .footer-info-subtitle {
            color: #155eef;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .footer-info-description {
            color: #667085;
            font-size: 14px;
            line-height: 1.8;
            margin-bottom: 0;
        }

        .footer-info-divider {
            border: 0;
            border-top: 1px solid #e6eaf0;
            margin: 28px 0;
            opacity: 1;
        }

        .footer-info-section {
            margin-bottom: 30px;
        }

        .footer-info-section:last-child {
            margin-bottom: 0;
        }

        .footer-info-section-title {
            color: #172033;
            font-size: 20px;
            line-height: 1.5;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .footer-info-points {
            padding-left: 22px;
            margin: 0;
            color: #344054;
        }

        .footer-info-points li {
            padding-left: 2px;
            margin-bottom: 9px;
            font-size: 14px;
            line-height: 1.85;
        }

        .footer-info-points li:last-child {
            margin-bottom: 0;
        }

        .footer-info-points li::marker {
            color: #155eef;
        }

        .footer-info-help {
            background: #f3f6fb;
            border: 1px solid #e6eaf0;
            border-radius: 10px;
            padding: 22px;
            margin-top: 34px;
        }

        .footer-info-help-title {
            color: #172033;
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .footer-info-help p {
            color: #667085;
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 16px;
        }

        .footer-info-home-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #155eef;
            color: #fff !important;
            border-radius: 7px;
            padding: 11px 17px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s;
        }

        .footer-info-home-btn:hover {
            background: #1048c7;
            color: #fff !important;
        }

        @media (max-width: 576px) {
            .footer-info-page {
                padding: 26px 0 40px;
            }

            .footer-info-card {
                padding: 22px 18px;
                border-radius: 10px;
            }

            .footer-info-title {
                font-size: 24px;
            }

            .footer-info-subtitle {
                font-size: 16px;
            }

            .footer-info-section-title {
                font-size: 17px;
            }

            .footer-info-points {
                padding-left: 20px;
            }

            .footer-info-points li {
                font-size: 13px;
                line-height: 1.8;
            }

            .footer-info-help {
                padding: 17px;
            }
        }
    </style>
@endpush

@section('content')
    <main class="footer-info-page">
        <div class="container">

            {{-- BREADCRUMB --}}
            <nav class="footer-info-breadcrumb"
                 aria-label="Breadcrumb">
                <a href="{{ route('home') }}">
                    Beranda
                </a>

                <span class="mx-2">/</span>

                <span aria-current="page">
                    {{ $data['title'] }}
                </span>
            </nav>

            {{-- KONTEN UTAMA --}}
            <article class="footer-info-card">

                {{-- JUDUL HALAMAN --}}
                <header>
                    <span class="footer-info-label">
                        ELECTROMART
                    </span>

                    <h1 class="footer-info-title">
                        {{ $data['title'] }}
                    </h1>

                    <h2 class="footer-info-subtitle">
                        {{ $data['subtitle'] }}
                    </h2>

                    <p class="footer-info-description">
                        {{ $data['description'] }}
                    </p>
                </header>

                <hr class="footer-info-divider">

                {{-- DAFTAR KETENTUAN --}}
                <div class="footer-info-content">
                    @foreach ($data['sections'] as $section)
                        <section class="footer-info-section">

                            <h3 class="footer-info-section-title">
                                {{ $section['heading'] }}
                            </h3>

                            <ul class="footer-info-points">
                                @foreach ($section['points'] as $point)
                                    <li>{{ $point }}</li>
                                @endforeach
                            </ul>

                        </section>
                    @endforeach
                </div>

                {{-- PUSAT BANTUAN --}}
                <div class="footer-info-help">
                    <h3 class="footer-info-help-title">
                        Masih Membutuhkan Bantuan?
                    </h3>

                    <p>
                        Jika Anda memiliki pertanyaan lebih lanjut
                        mengenai {{ strtolower($data['title']) }},
                        silakan hubungi layanan pelanggan ELECTROMART
                        melalui informasi kontak yang tersedia di footer.
                    </p>

                    <a href="{{ route('home') }}"
                       class="footer-info-home-btn">
                        <i class="fa-solid fa-house"></i>
                        Kembali ke Beranda
                    </a>
                </div>

            </article>
        </div>
    </main>
@endsection
