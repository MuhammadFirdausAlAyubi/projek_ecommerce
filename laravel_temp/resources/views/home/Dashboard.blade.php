@extends('layouts.customer')

@section('title', 'Beranda ELECTROMART')

@php

    $heroImages = [

        [

            'file' => 'iphone-18-pro.png',

            'alt' => 'Promo iPhone 18 Pro ELECTROMART',

        ],

        [

            'file' => 'infinix-xbook-14-neo.png',

            'alt' => 'Promo Infinix XBOOK 14 Neo',

        ],

        [

            'file' => 'starlink-standard-v4.png',

            'alt' => 'Promo Starlink Standard V4',

        ],

        [

            'file' => 'windows-11-campus.png',

            'alt' => 'Promo Windows 11 Back to Campus',

        ],

    ];

    $homeCategories = [

        ['slug' => 'smartphone', 'name' => 'Smartphone', 'icon' => 'fa-mobile-screen-button'],

        ['slug' => 'laptop', 'name' => 'Laptop', 'icon' => 'fa-laptop'],

        ['slug' => 'komputer', 'name' => 'Komputer', 'icon' => 'fa-desktop'],

        ['slug' => 'aksesori', 'name' => 'Aksesori', 'icon' => 'fa-headphones'],

        ['slug' => 'gaming', 'name' => 'Gaming', 'icon' => 'fa-gamepad'],

        ['slug' => 'networking', 'name' => 'Networking', 'icon' => 'fa-wifi'],

    ];

    $homeProducts = collect($produks ?? []);

@endphp

@push('styles')

<style>

.em-home {

    --em-blue: #155eef;

    --em-blue-dark: #1048c7;

    --em-navy: #0b1d38;

    --em-ink: #172033;

    --em-muted: #667085;

    --em-line: #e6eaf0;

    --em-bg: #f7f9fc;

    color: var(--em-ink);

    background: var(--em-bg);

    padding: 0 0 40px;

    overflow-x: clip;

}

.em-home *,

.em-home *::before,

.em-home *::after {

    box-sizing: border-box;

}

.em-home img {

    display: block;

    max-width: 100%;

}

.em-home a {

    text-decoration: none;

}

.em-container {

    width: min(1600px, calc(100% - 36px));

    margin-inline: auto;

}

/* HERO BANNER */

.em-hero-layout {

    display: grid;

    grid-template-columns: minmax(0, 2.15fr) minmax(250px, .9fr);

    gap: 14px;

    margin-top: 16px;

    align-items: stretch;

}

.em-ad-slider {

    position: relative;

    width: 100%;

    height: clamp(300px, 34vw, 470px);

    min-width: 0;

    overflow: hidden;

    border-radius: 14px;

    background: #eef2f7;

    isolation: isolate;

}

.em-ad-track {

    display: flex;

    width: 100%;

    height: 100%;

    transition: transform .55s ease-in-out;

    will-change: transform;

}

.em-ad-slide {

    position: relative;

    display: flex;

    align-items: center;

    justify-content: center;

    flex: 0 0 100%;

    width: 100%;

    height: 100%;

    min-width: 0;

    overflow: hidden;

    background: #fff;

}

.em-ad-slide img {

    width: 100%;

    height: 100%;

    object-fit: contain;

    object-position: center;

}

.em-ad-image-error {

    display: none;

    align-items: center;

    justify-content: center;

    width: 100%;

    height: 100%;

    padding: 20px;

    color: #667085;

    font-size: 13px;

    text-align: center;

    background: #f1f4f8;

}

.em-ad-arrow {

    position: absolute;

    top: 50%;

    z-index: 5;

    display: grid;

    place-items: center;

    width: 42px;

    height: 42px;

    padding: 0;

    transform: translateY(-50%);

    border: 1px solid rgba(255,255,255,.6);

    border-radius: 50%;

    background: rgba(11,29,56,.55);

    color: #fff;

    cursor: pointer;

    opacity: 0;

    transition: opacity .2s ease, background .2s ease;

    backdrop-filter: blur(5px);

}

.em-ad-slider:hover .em-ad-arrow,

.em-ad-slider:focus-within .em-ad-arrow {

    opacity: 1;

}

.em-ad-arrow:hover {

    background: var(--em-blue);

}

.em-ad-prev {

    left: 14px;

}

.em-ad-next {

    right: 14px;

}

.em-ad-dots {

    position: absolute;

    z-index: 5;

    bottom: 14px;

    left: 50%;

    display: flex;

    align-items: center;

    gap: 7px;

    padding: 8px 11px;

    transform: translateX(-50%);

    border-radius: 30px;

    background: rgba(255,255,255,.88);

    backdrop-filter: blur(6px);

}

.em-ad-dots button {

    width: 9px;

    height: 9px;

    padding: 0;

    border: 0;

    border-radius: 20px;

    background: #aab4c3;

    cursor: pointer;

    transition: width .25s ease, background .25s ease;

}

.em-ad-dots button.active {

    width: 25px;

    background: var(--em-blue);

}

/* BANNER KANAN */

/* BANNER KANAN: DUA SLIDER TERPISAH */
.em-hero-aside {
    display: grid;
    grid-template-rows: repeat(2, minmax(0, 1fr));
    gap: 14px;
    height: clamp(300px, 34vw, 470px);
    min-width: 0;
}

.em-side-ad {
    position: relative;
    display: block;
    min-width: 0;
    min-height: 0;
    overflow: hidden;
    border: 1px solid var(--em-line);
    border-radius: 13px;
    background: #fff;
    isolation: isolate;
}

.em-side-track {
    display: flex;
    width: 100%;
    height: 100%;
    transition: transform .55s ease-in-out;
    will-change: transform;
}

.em-side-slide {
    display: block;
    flex: 0 0 100%;
    width: 100%;
    height: 100%;
    min-width: 0;
    overflow: hidden;
}

.em-side-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform .35s ease;
}

.em-side-ad:hover .em-side-slide img {
    transform: scale(1.025);
}

.em-side-arrow {
    position: absolute;
    top: 50%;
    z-index: 5;
    display: grid;
    place-items: center;
    width: 30px;
    height: 30px;
    padding: 0;
    border: 0;
    border-radius: 50%;
    background: rgba(11, 29, 56, .65);
    color: #fff;
    opacity: 0;
    cursor: pointer;
    transform: translateY(-50%);
    transition: opacity .2s ease, background .2s ease;
}

.em-side-ad:hover .em-side-arrow,
.em-side-ad:focus-within .em-side-arrow {
    opacity: 1;
}

.em-side-arrow:hover {
    background: var(--em-blue);
}

.em-side-prev { left: 8px; }
.em-side-next { right: 8px; }

.em-side-dots {
    position: absolute;
    z-index: 5;
    bottom: 8px;
    left: 50%;
    display: flex;
    gap: 5px;
    padding: 6px 8px;
    border-radius: 20px;
    background: rgba(255, 255, 255, .85);
    transform: translateX(-50%);
}

.em-side-dots button {
    width: 7px;
    height: 7px;
    padding: 0;
    border: 0;
    border-radius: 50%;
    background: #aab4c3;
    cursor: pointer;
}

.em-side-dots button.active {
    width: 18px;
    border-radius: 8px;
    background: var(--em-blue);
}

/* BENEFIT BAR */

.em-benefits {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 0;
    margin-top: 18px;
    padding: 25px 24px;
    border: 1px solid rgba(255, 255, 255, .08);
    border-radius: 14px;
    background: var(--em-navy);
    color: #fff;
    box-shadow: 0 6px 18px rgba(11, 29, 56, .08);
}

.em-benefit {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
    padding: 0 15px;
    border-right: 1px solid rgba(255, 255, 255, .18);
}

.em-benefit:first-child {
    padding-left: 0;
}

.em-benefit:last-child {
    padding-right: 0;
    border-right: 0;
}

.em-benefit-icon {
    display: grid;
    place-items: center;
    width: 46px;
    height: 46px;
    flex: 0 0 46px;
    border-radius: 50%;
    background: #254eaa;
    color: #fff;
    font-size: 17px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, .12);
}

.em-benefit strong {
    display: block;
    margin-bottom: 5px;
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    line-height: 1.45;
    letter-spacing: .1px;
}

.em-benefit p {
    margin: 0;
    color: #c5d0e1;
    font-size: 11px;
    line-height: 1.55;
}

/* TABLET */

@media (max-width: 1100px) {
    .em-benefits {
        padding: 20px 16px;
    }

    .em-benefit {
        gap: 9px;
        padding: 0 10px;
    }

    .em-benefit-icon {
        width: 40px;
        height: 40px;
        flex-basis: 40px;
        font-size: 15px;
    }

    .em-benefit strong {
        font-size: 11px;
    }

    .em-benefit p {
        font-size: 10px;
    }
}

/* MOBILE */

@media (max-width: 760px) {
    .em-benefits {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 0;
        padding: 20px 14px;
    }

    .em-benefit {
        gap: 10px;
        padding: 0 10px;
        border-right: 1px solid rgba(255, 255, 255, .18);
    }

    .em-benefit:nth-child(2n) {
        border-right: 0;
    }

    .em-benefit:last-child {
        grid-column: 1 / -1;
        justify-content: center;
        border-right: 0;
    }

    .em-benefit-icon {
        width: 42px;
        height: 42px;
        flex-basis: 42px;
        font-size: 16px;
    }

    .em-benefit strong {
        font-size: 12px;
    }

    .em-benefit p {
        font-size: 10px;
    }
}

@media (max-width: 480px) {
    .em-benefits {
        padding: 17px 9px;
        gap: 16px 0;
        border-radius: 11px;
    }

    .em-benefit {
        gap: 8px;
        padding: 0 6px;
    }

    .em-benefit-icon {
        width: 34px;
        height: 34px;
        flex-basis: 34px;
        font-size: 13px;
    }

    .em-benefit strong {
        font-size: 10px;
    }

    .em-benefit p {
        font-size: 9px;
    }
}

/* SECTION */

.em-section {

    padding-top: 32px;

}

.em-section-head {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 14px;

    margin-bottom: 16px;

}

.em-section-head h2 {

    margin: 0;

    color: var(--em-ink);

    font-size: clamp(20px, 2vw, 27px);

    font-weight: 800;

    line-height: 1.3;

    letter-spacing: -.45px;

}

.em-section-head p {

    margin: 5px 0 0;

    color: var(--em-muted);

    font-size: 12px;

    line-height: 1.6;

}

.em-section-link {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    flex-shrink: 0;

    color: var(--em-blue);

    font-size: 12px;

    font-weight: 800;

    white-space: nowrap;

}

.em-section-link:hover {

    color: var(--em-blue-dark);

}

/* KATEGORI */

.em-category-grid {

    display: grid;

    grid-template-columns: repeat(6, minmax(0, 1fr));

    gap: 12px;

}

.em-category-card {

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    gap: 11px;

    min-width: 0;

    min-height: 132px;

    padding: 14px 8px;

    border: 1px solid var(--em-line);

    border-radius: 13px;

    background: #fff;

    color: var(--em-ink);

    transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;

}

.em-category-card:hover {

    transform: translateY(-3px);

    border-color: #c4d4fb;

    color: var(--em-blue);

    box-shadow: 0 9px 22px rgba(21,94,239,.08);

}

.em-category-icon {

    display: grid;

    place-items: center;

    width: 60px;

    height: 60px;

    border-radius: 18px;

    background: #eef4ff;

    color: var(--em-blue);

    font-size: 23px;

}

.em-category-card strong {

    font-size: 12px;

    line-height: 1.4;

    text-align: center;

}

/* PRODUK */

.em-product-grid {

    display: grid;

    grid-template-columns: repeat(5, minmax(0, 1fr));

    gap: 14px;

}

.em-product-card {

    display: flex;

    flex-direction: column;

    min-width: 0;

    overflow: hidden;

    border: 1px solid var(--em-line);

    border-radius: 13px;

    background: #fff;

    transition: transform .2s ease, box-shadow .2s ease;

}

.em-product-card:hover {

    transform: translateY(-3px);

    box-shadow: 0 10px 24px rgba(23,32,51,.08);

}

.em-product-image {

    display: flex;

    align-items: center;

    justify-content: center;

    aspect-ratio: 1 / .9;

    overflow: hidden;

    border-bottom: 1px solid #f0f2f5;

    background: #fff;

}

.em-product-image img {

    width: 100%;

    height: 100%;

    padding: 13px;

    object-fit: contain;

    transition: transform .25s ease;

}

.em-product-card:hover .em-product-image img {

    transform: scale(1.04);

}

.em-product-info {

    display: flex;

    flex: 1;

    flex-direction: column;

    align-items: flex-start;

    gap: 7px;

    min-width: 0;

    padding: 12px;

}

.em-product-category {

    margin: 0;

    color: var(--em-muted);

    font-size: 10px;

}

.em-product-name {

    display: -webkit-box;

    width: 100%;

    min-height: 36px;

    margin: 0;

    overflow: hidden;

    color: var(--em-ink);

    font-size: 12px;

    font-weight: 750;

    line-height: 1.5;

    overflow-wrap: anywhere;

    -webkit-box-orient: vertical;

    -webkit-line-clamp: 2;

}

.em-product-rating {

    color: #f4ad16;

    font-size: 11px;

}

.em-product-rating span {

    color: var(--em-muted);

}

.em-product-price {

    margin: auto 0 5px;

    padding-top: 5px;

    color: var(--em-blue);

    font-size: 14px;

    font-weight: 850;

    overflow-wrap: anywhere;

}

.em-product-action {

    display: flex;

    align-items: center;

    justify-content: center;

    width: 100%;

    min-height: 36px;

    padding: 0 8px;

    border: 1px solid #cbd8f5;

    border-radius: 7px;

    background: #fff;

    color: var(--em-blue);

    font-size: 11px;

    font-weight: 800;

}

.em-product-action:hover {

    background: var(--em-blue);

    color: #fff;

}

.em-empty {

    padding: 28px 18px;

    border: 1px solid var(--em-line);

    border-radius: 12px;

    background: #fff;

    color: var(--em-muted);

    text-align: center;

}

/* ULASAN */

.em-review-grid {

    display: grid;

    grid-template-columns: repeat(3, minmax(0, 1fr));

    gap: 14px;

}

.em-review-card {

    display: flex;

    flex-direction: column;

    min-width: 0;

    padding: 18px;

    border: 1px solid var(--em-line);

    border-radius: 13px;

    background: #fff;

    box-shadow: 0 4px 12px rgba(23,32,51,.025);

}

.em-review-stars {

    margin-bottom: 10px;

    color: #f4ad16;

    font-size: 13px;

    letter-spacing: 1px;

}

.em-review-text {

    display: -webkit-box;

    min-height: 60px;

    margin: 0 0 14px;

    overflow: hidden;

    color: #475467;

    font-size: 12px;

    line-height: 1.8;

    overflow-wrap: anywhere;

    -webkit-box-orient: vertical;

    -webkit-line-clamp: 3;

}

.em-review-product {

    margin-top: auto;

    padding-top: 11px;

    border-top: 1px solid #eef0f4;

    color: var(--em-ink);

    font-size: 11px;

    font-weight: 800;

    line-height: 1.5;

}

.em-review-rating {

    margin-top: 5px;

    color: var(--em-muted);

    font-size: 10px;

}

/* BANNER BAWAH */

.em-bottom-banner {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 22px;

    margin-top: 34px;

    padding: clamp(22px, 3vw, 38px);

    overflow: hidden;

    border-radius: 15px;

    background: linear-gradient(115deg, #eaf1ff, #f5f8ff 65%, #dce8ff);

}

.em-bottom-copy {

    max-width: 570px;

}

.em-bottom-copy h2 {

    margin: 0 0 11px;

    color: var(--em-ink);

    font-size: clamp(22px, 2.5vw, 32px);

    font-weight: 850;

    line-height: 1.25;

}

.em-bottom-copy p {

    margin: 0 0 17px;

    color: var(--em-muted);

    font-size: 12px;

    line-height: 1.8;

}

.em-home .em-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    min-height: 40px;

    padding: 0 17px;

    border: 0;

    border-radius: 8px;

    background: var(--em-blue);

    color: #fff;

    font-size: 12px;

    font-weight: 800;

    cursor: pointer;

}

.em-home .em-btn:hover {

    background: var(--em-blue-dark);

}

.em-bottom-banner > img {

    width: 30%;

    max-height: 170px;

    object-fit: contain;

}

/* RESPONSIVE */

@media (max-width: 1100px) {

    .em-container {

        width: calc(100% - 28px);

    }

    .em-hero-layout {

        grid-template-columns: minmax(0, 1.7fr) minmax(220px, 1fr);

        gap: 10px;

    }

    .em-ad-slider,

    .em-hero-aside {

        height: 340px;

    }

    .em-hero-aside {

        gap: 10px;

    }

    .em-benefits {

        padding: 16px 13px;

    }

    .em-benefit {

        padding-inline: 9px;

    }

    .em-product-grid {

        grid-template-columns: repeat(4, minmax(0, 1fr));

    }

}

@media (max-width: 760px) {

    .em-hero-layout {

        grid-template-columns: minmax(0, 1fr);

    }

    .em-ad-slider {

        height: clamp(220px, 55vw, 360px);

    }

    .em-ad-arrow {

        width: 34px;

        height: 34px;

        opacity: 1;

    }

    .em-hero-aside {

        height: 250px;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        grid-template-rows: minmax(0, 1fr);

    }

    .em-benefits {

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 16px 0;

    }

    .em-benefit:nth-child(2) {

        border-right: 0;

    }

    .em-benefit:nth-child(3) {

        padding-left: 0;

    }

    .em-benefit:nth-child(4) {

        padding-right: 0;

    }

    .em-category-grid {

        grid-template-columns: repeat(3, minmax(0, 1fr));

    }

    .em-product-grid {

        grid-template-columns: repeat(3, minmax(0, 1fr));

    }

    .em-review-grid {

        grid-template-columns: repeat(2, minmax(0, 1fr));

    }

}

@media (max-width: 480px) {

    .em-container {

        width: calc(100% - 20px);

    }

    .em-ad-slider {

        height: 225px;

        border-radius: 10px;

    }

    .em-ad-dots {

        bottom: 8px;

    }

    .em-ad-arrow {

        width: 30px;

        height: 30px;

    }

    .em-hero-aside {

        height: 190px;

        gap: 8px;

    }

    .em-benefits {

        padding: 15px 10px;

    }

    .em-benefit {

        gap: 8px;

        padding-inline: 7px;

    }

    .em-benefit-icon {

        width: 31px;

        height: 31px;

        flex-basis: 31px;

        font-size: 12px;

    }

    .em-benefit strong {

        font-size: 10px;

    }

    .em-benefit p {

        font-size: 9px;

    }

    .em-section {

        padding-top: 25px;

    }

    .em-section-head h2 {

        font-size: 19px;

    }

    .em-section-head p {

        font-size: 10px;

    }

    .em-category-grid {

        gap: 7px;

    }

    .em-category-card {

        min-height: 100px;

        gap: 8px;

        padding: 9px 4px;

    }

    .em-category-icon {

        width: 44px;

        height: 44px;

        border-radius: 13px;

        font-size: 18px;

    }

    .em-category-card strong {

        font-size: 10px;

    }

    .em-product-grid {

        grid-template-columns: repeat(2, minmax(0, 1fr));

        gap: 10px;

    }

    .em-product-info {

        padding: 9px;

    }

    .em-product-name {

        font-size: 11px;

    }

    .em-product-price {

        font-size: 12px;

    }

    .em-review-grid {

        grid-template-columns: minmax(0, 1fr);

    }

    .em-bottom-banner {

        flex-direction: column;

        align-items: flex-start;

    }

    .em-bottom-banner > img {

        width: 100%;

        max-height: 125px;

    }

}

@media (prefers-reduced-motion: reduce) {

    .em-ad-track {

        transition: none;

    }

}

</style>

@endpush

@section('content')

<div class="em-home">

    <div class="em-container">

        {{-- BANNER UTAMA: 4 GAMBAR --}}

        <section class="em-hero-layout" aria-label="Iklan ELECTROMART">

            <div class="em-ad-slider" data-em-ad-slider>

                <div class="em-ad-track">

                    @foreach ($heroImages as $index => $banner)

                        <a href="{{ route('shop.index') }}"

                           class="em-ad-slide"

                           aria-label="{{ $banner['alt'] }}">

                            <img

                                src="{{ asset('assets/gambar/iklan/' . $banner['file']) }}"

                                alt="{{ $banner['alt'] }}"

                                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"

                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                            <span class="em-ad-image-error">

                                Gambar tidak dapat dimuat.

                                Periksa folder public/assets/gambar/iklan.

                            </span>

                        </a>

                    @endforeach

                </div>

                <button type="button"

                        class="em-ad-arrow em-ad-prev"

                        aria-label="Iklan sebelumnya">

                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>

                </button>

                <button type="button"

                        class="em-ad-arrow em-ad-next"

                        aria-label="Iklan berikutnya">

                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>

                </button>

                <div class="em-ad-dots" aria-label="Navigasi iklan">

                    @foreach ($heroImages as $index => $banner)

                        <button

                            type="button"

                            class="{{ $index === 0 ? 'active' : '' }}"

                            aria-label="Tampilkan iklan {{ $index + 1 }}"

                            aria-current="{{ $index === 0 ? 'true' : 'false' }}">

                        </button>

                    @endforeach

                </div>

            </div>

            {{-- DUA BANNER KANAN: SLIDER TERPISAH --}}
            <div class="em-hero-aside">

                {{-- BANNER KANAN ATAS: KHUSUS SMARTPHONE --}}
                <div class="em-side-ad" data-em-side-slider>
                    <div class="em-side-track">
                        <a href="{{ route('shop.index') }}" class="em-side-slide" aria-label="Promo smartphone 1">
                            <img src="{{ asset('assets/gambar/iklan/promo-smartphone.png') }}"
                                 alt="Promo smartphone premium" loading="eager">
                        </a>
                        <a href="{{ route('shop.index') }}" class="em-side-slide" aria-label="Promo smartphone 2">
                            <img src="{{ asset('assets/gambar/iklan/promo-smartphone-2.png') }}"
                                 alt="Promo smartphone kamera unggulan" loading="lazy">
                        </a>
                        <a href="{{ route('shop.index') }}" class="em-side-slide" aria-label="Promo smartphone 3">
                            <img src="{{ asset('assets/gambar/iklan/promo-smartphone-3.png') }}"
                                 alt="Promo smartphone dan aksesori" loading="lazy">
                        </a>
                    </div>
                    <button type="button" class="em-side-arrow em-side-prev" aria-label="Promo smartphone sebelumnya">
                        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="em-side-arrow em-side-next" aria-label="Promo smartphone berikutnya">
                        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                    </button>
                    <div class="em-side-dots" aria-label="Navigasi promo smartphone">
                        <button type="button" class="active" aria-label="Smartphone slide 1"></button>
                        <button type="button" aria-label="Smartphone slide 2"></button>
                        <button type="button" aria-label="Smartphone slide 3"></button>
                    </div>
                </div>

                {{-- BANNER KANAN BAWAH: KHUSUS GAMING DAN AKSESORI --}}
                <div class="em-side-ad" data-em-side-slider>
                    <div class="em-side-track">
                        <a href="{{ route('shop.index') }}" class="em-side-slide" aria-label="Promo gaming 1">
                            <img src="{{ asset('assets/gambar/iklan/promo-gaming-aksesori.png') }}"
                                 alt="Promo headset gaming dan keyboard" loading="lazy">
                        </a>
                        <a href="{{ route('shop.index') }}" class="em-side-slide" aria-label="Promo gaming 2">
                            <img src="{{ asset('assets/gambar/iklan/promo-gaming-aksesori-2.png') }}"
                                 alt="Promo mouse gaming dan keyboard RGB" loading="lazy">
                        </a>
                        <a href="{{ route('shop.index') }}" class="em-side-slide" aria-label="Promo gaming 3">
                            <img src="{{ asset('assets/gambar/iklan/promo-gaming-aksesori-3.png') }}"
                                 alt="Promo controller, headset, dan aksesori komputer" loading="lazy">
                        </a>
                    </div>
                    <button type="button" class="em-side-arrow em-side-prev" aria-label="Promo gaming sebelumnya">
                        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="em-side-arrow em-side-next" aria-label="Promo gaming berikutnya">
                        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                    </button>
                    <div class="em-side-dots" aria-label="Navigasi promo gaming">
                        <button type="button" class="active" aria-label="Gaming slide 1"></button>
                        <button type="button" aria-label="Gaming slide 2"></button>
                        <button type="button" aria-label="Gaming slide 3"></button>
                    </div>
                </div>

            </div>
</section>
{{-- BENEFIT BAR --}}
<section class="em-benefits" aria-label="Keunggulan ELECTROMART">

    <div class="em-benefit">
        <span class="em-benefit-icon">
            <i class="fa-solid fa-box-open" aria-hidden="true"></i>
        </span>
        <div>
            <strong>5 Hari Rusak, Ganti Baru</strong>
            <p>Garansi penggantian produk</p>
        </div>
    </div>

    <div class="em-benefit">
        <span class="em-benefit-icon">
            <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
        </span>
        <div>
            <strong>Ongkir Terjangkau</strong>
            <p>Ongkir lebih murah</p>
        </div>
    </div>

    <div class="em-benefit">
        <span class="em-benefit-icon">
            <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
        </span>
        <div>
            <strong>Proteksi Produk</strong>
            <p>Perlindungan produk elektronik</p>
        </div>
    </div>

    <div class="em-benefit">
        <span class="em-benefit-icon">
            <i class="fa-solid fa-tags" aria-hidden="true"></i>
        </span>
        <div>
            <strong>Harga Terjangkau</strong>
            <p>Belanja elektronik lebih hemat</p>
        </div>
    </div>

    <div class="em-benefit">
        <span class="em-benefit-icon">
            <i class="fa-solid fa-stopwatch" aria-hidden="true"></i>
        </span>
        <div>
            <strong>Pengiriman Cepat</strong>
            <p>Estimasi 2 jam sampai</p>
        </div>
    </div>

</section>
        {{-- KATEGORI --}}

        <section class="em-section">

            <div class="em-section-head">

                <div>

                    <h2>Belanja Berdasarkan Kategori</h2>

                    <p>Temukan kategori elektronik favoritmu.</p>

                </div>

                <a href="{{ route('shop.index') }}" class="em-section-link">

                    Semua produk

                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>

                </a>

            </div>

            <div class="em-category-grid">

                @foreach ($homeCategories as $category)

                    <a href="{{ route('shop.category', ['category' => $category['slug']]) }}"

                       class="em-category-card">

                        <span class="em-category-icon">

                            <i class="fa-solid {{ $category['icon'] }}" aria-hidden="true"></i>

                        </span>

                        <strong>{{ $category['name'] }}</strong>

                    </a>

                @endforeach

            </div>

        </section>

        {{-- PRODUK PILIHAN --}}

        <section class="em-section">

            <div class="em-section-head">

                <div>

                    <h2>Produk Pilihan</h2>

                    <p>Temukan produk elektronik untuk kebutuhanmu.</p>

                </div>

                <a href="{{ route('shop.index') }}" class="em-section-link">

                    Lihat semua

                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>

                </a>

            </div>

            @if ($homeProducts->isNotEmpty())

                <div class="em-product-grid">

                    @foreach ($homeProducts->take(10) as $produk)

                        @php

                            $gambarProduk = $produk->gambar ?? null;

                            if ($gambarProduk && !preg_match('/^https?:\\/\\//i', $gambarProduk)) {

                                $gambarProduk = asset('storage/' . ltrim($gambarProduk, '/'));

                            }

                            $ulasanProduk = $produk->ulasanProduk ?? collect();

                            $jumlahUlasan = $ulasanProduk->count();

                            $ratingProduk = $jumlahUlasan

                                ? (float) $ulasanProduk->avg('rating')

                                : 0;

                        @endphp

                        <article class="em-product-card">

                            <a href="{{ route('produk.detail', $produk->id_produk) }}"

                               class="em-product-image">

                                @if ($gambarProduk)

                                    <img

                                        src="{{ $gambarProduk }}"

                                        alt="{{ $produk->nama_produk }}"

                                        loading="lazy">

                                @else

                                    <span class="em-ad-image-error" style="display:flex;">

                                        Gambar produk belum tersedia

                                    </span>

                                @endif

                            </a>

                            <div class="em-product-info">

                                <p class="em-product-category">

                                    {{ $produk->kategori->nama_kategori ?? 'Produk elektronik' }}

                                </p>

                                \<h3 class="em-product-name">

                                    {{ $produk->nama_produk }}

                                \</h3>

                                <div class="em-product-rating">

                                    @if ($jumlahUlasan > 0)

                                        <i class="fa-solid fa-star" aria-hidden="true"></i>

                                        {{ number_format($ratingProduk, 1) }}

                                        <span>({{ $jumlahUlasan }} ulasan)</span>

                                    @else

                                        <span>Belum ada ulasan</span>

                                    @endif

                                </div>

                                <p class="em-product-price">

                                    Rp {{ number_format((float) $produk->harga_jual, 0, ',', '.') }}

                                </p>

                                <a href="{{ route('produk.detail', $produk->id_produk) }}"

                                   class="em-product-action">

                                    Lihat Detail

                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="em-empty">

                    Produk belum tersedia. Tambahkan produk melalui dashboard admin.

                </div>

            @endif

        </section>

        {{-- ULASAN PELANGGAN --}}

        @php

            $homeReviews = collect();

            foreach ($homeProducts as $itemProduk) {

                $reviews = $itemProduk->ulasanProduk ?? collect();

                foreach ($reviews as $review) {

                    $isiReview = $review->komentar

                        ?? $review->isi_ulasan

                        ?? $review->ulasan

                        ?? $review->review

                        ?? null;

                    $ratingReview = (float) ($review->rating ?? 0);

                    if ($isiReview || $ratingReview > 0) {

                        $homeReviews->push([

                            'produk' => $itemProduk->nama_produk,

                            'isi' => $isiReview,

                            'rating' => $ratingReview,

                        ]);

                    }

                }

            }

        @endphp

        <section class="em-section">

            <div class="em-section-head">

                <div>

                    <h2>Ulasan Pelanggan</h2>

                    <p>Penilaian pelanggan yang tersimpan pada produk.</p>

                </div>

                <a href="{{ route('shop.index') }}" class="em-section-link">

                    Jelajahi produk

                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>

                </a>

            </div>

            @if ($homeReviews->isNotEmpty())

                <div class="em-review-grid">

                    @foreach ($homeReviews->take(3) as $review)

                        <article class="em-review-card">

                            <div class="em-review-stars">

                                @for ($star = 1; $star <= 5; $star++)

                                    <i class="{{ $star <= round($review['rating']) ? 'fa-solid' : 'fa-regular' }} fa-star"

                                       aria-hidden="true"></i>

                                @endfor

                            </div>

                            <p class="em-review-text">

                                {{ $review['isi'] ?: 'Pelanggan memberikan penilaian pada produk ini.' }}

                            </p>

                            <div class="em-review-product">

                                {{ $review['produk'] }}

                            </div>

                            <div class="em-review-rating">

                                Rating {{ number_format($review['rating'], 1) }} dari 5

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="em-empty">

                    Belum ada ulasan yang tersedia. Ulasan akan tampil di sini

                    setelah data penilaian produk tersimpan di database.

                </div>

            @endif

        </section>

        {{-- BANNER PENUTUP --}}

        <section class="em-bottom-banner">

            <div class="em-bottom-copy">

                <h2>Teknologi untuk aktivitasmu.</h2>

                <p>

                    Temukan smartphone, laptop, komputer, aksesori, gaming,

                    dan perangkat networking untuk kebutuhan sehari-hari.

                </p>

                <a href="{{ route('shop.index') }}" class="em-btn">

                    Jelajahi Semua Produk

                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>

                </a>

            </div>

            <img

                src="{{ asset('assets/gambar/iklan/infinix-xbook-14-neo.png') }}"

                alt="Perangkat teknologi ELECTROMART"

                loading="lazy">

        </section>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-em-ad-slider]').forEach(function (slider) {

        const track = slider.querySelector('.em-ad-track');

        const slides = slider.querySelectorAll('.em-ad-slide');

        const dots = slider.querySelectorAll('.em-ad-dots button');

        const prev = slider.querySelector('.em-ad-prev');

        const next = slider.querySelector('.em-ad-next');

        if (!track || slides.length < 2) return;

        let currentIndex = 0;

        let timer = null;

        const interval = 4500;

        const reduceMotion = window.matchMedia(

            '(prefers-reduced-motion: reduce)'

        ).matches;

        function showSlide(index) {

            currentIndex = (index + slides.length) % slides.length;

            track.style.transform =

                'translateX(-' + (currentIndex * 100) + '%)';

            dots.forEach(function (dot, dotIndex) {

                const active = dotIndex === currentIndex;

                dot.classList.toggle('active', active);

                dot.setAttribute('aria-current', active ? 'true' : 'false');

            });

        }

        function stopSlider() {

            if (timer !== null) {

                clearInterval(timer);

                timer = null;

            }

        }

        function startSlider() {

            stopSlider();

            if (reduceMotion || document.hidden) return;

            timer = setInterval(function () {

                showSlide(currentIndex + 1);

            }, interval);

        }

        if (prev) {

            prev.addEventListener('click', function () {

                showSlide(currentIndex - 1);

                startSlider();

            });

        }

        if (next) {

            next.addEventListener('click', function () {

                showSlide(currentIndex + 1);

                startSlider();

            });

        }

        dots.forEach(function (dot, index) {

            dot.addEventListener('click', function () {

                showSlide(index);

                startSlider();

            });

        });

        /*

         * Hover tidak menghentikan slider.

         * Gambar terus berganti otomatis walaupun kursor berada di banner.

         */

        slider.addEventListener('keydown', function (event) {

            if (event.key === 'ArrowLeft') {

                showSlide(currentIndex - 1);

                startSlider();

            }

            if (event.key === 'ArrowRight') {

                showSlide(currentIndex + 1);

                startSlider();

            }

        });

        document.addEventListener('visibilitychange', function () {

            if (document.hidden) {

                stopSlider();

            } else {

                startSlider();

            }

        });

        showSlide(0);

        startSlider();

    });

    // SLIDER OTOMATIS UNTUK MASING-MASING BANNER KECIL
    document.querySelectorAll("[data-em-side-slider]").forEach(function (slider) {
        const track = slider.querySelector(".em-side-track");
        const slides = slider.querySelectorAll(".em-side-slide");
        const dots = slider.querySelectorAll(".em-side-dots button");
        const prev = slider.querySelector(".em-side-prev");
        const next = slider.querySelector(".em-side-next");

        if (!track || slides.length < 2) return;

        let currentIndex = 0;
        let timer = null;

        function showSideSlide(index) {
            currentIndex = (index + slides.length) % slides.length;
            track.style.transform = "translateX(-" + (currentIndex * 100) + "%)";
            dots.forEach(function (dot, dotIndex) {
                dot.classList.toggle("active", dotIndex === currentIndex);
            });
        }

        function stopSideSlider() {
            if (timer !== null) {
                clearInterval(timer);
                timer = null;
            }
        }

        function startSideSlider() {
            stopSideSlider();
            if (document.hidden) return;
            timer = setInterval(function () {
                showSideSlide(currentIndex + 1);
            }, 4000);
        }

        if (prev) prev.addEventListener("click", function () {
            showSideSlide(currentIndex - 1);
            startSideSlider();
        });

        if (next) next.addEventListener("click", function () {
            showSideSlide(currentIndex + 1);
            startSideSlider();
        });

        dots.forEach(function (dot, index) {
            dot.addEventListener("click", function () {
                showSideSlide(index);
                startSideSlider();
            });
        });

        // Slider tetap berjalan ketika kursor berada di atas banner.
        slider.addEventListener("mouseenter", startSideSlider);
        slider.addEventListener("mouseleave", startSideSlider);

        document.addEventListener("visibilitychange", function () {
            if (document.hidden) stopSideSlider();
            else startSideSlider();
        });

        showSideSlide(0);
        startSideSlider();
    });
});

</script>

@endpush