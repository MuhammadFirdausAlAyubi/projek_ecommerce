@extends('layouts.customer')

@section('title', 'Beranda')

@push('styles')
<style>
.em-home{color:#172033}
.em-container{width:min(1320px,94%);margin:0 auto}
.em-hero{position:relative;height:400px;min-height:400px;margin:24px auto 0;overflow:hidden;border-radius:14px;background:#eaf1ff}
.em-hero-track{display:flex;height:100%;transition:transform .65s cubic-bezier(.22,.61,.36,1);will-change:transform}
.em-hero-slide{display:grid;grid-template-columns:1fr 1fr;flex:0 0 100%;min-width:100%;height:100%}
.em-hero-copy{display:flex;flex-direction:column;align-items:flex-start;justify-content:center;min-width:0;padding:32px clamp(24px,4vw,55px)}
.em-eyebrow{display:inline-flex;align-items:center;gap:8px;margin-bottom:14px;color:#155eef;font-size:10px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase}
.em-eyebrow:before{content:"";width:7px;height:7px;flex:0 0 7px;border-radius:50%;background:#155eef}
.em-hero h1{max-width:480px;margin:0 0 14px;color:#172033;font-size:clamp(30px,3.5vw,48px);line-height:1.08;letter-spacing:-1.5px;font-weight:800}
.em-hero h1 span{color:#155eef}
.em-hero-copy>p{max-width:390px;margin:0 0 18px;color:#667085;font-size:13px;line-height:1.7}
.em-btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;min-height:40px;padding:0 18px;border:0;border-radius:7px;background:#155eef;color:#fff;font-size:11px;font-weight:700;text-decoration:none;transition:.2s}
.em-btn:hover{background:#1048c7;color:#fff;transform:translateY(-1px)}
.em-hero-image{min-width:0;min-height:0;height:100%;overflow:hidden}
.em-hero-image img{display:block;width:100%;height:100%;object-fit:cover}
.em-slider-arrow{position:absolute;top:50%;z-index:4;display:grid;place-items:center;width:36px;height:36px;padding:0;transform:translateY(-50%);border:1px solid #ffffffa8;border-radius:50%;background:#ffffffdf;color:#172033;cursor:pointer;transition:.2s}
.em-slider-arrow:hover{background:#155eef;color:#fff}
.em-slider-prev{left:12px}
.em-slider-next{right:12px}
.em-slider-dots{position:absolute;z-index:4;bottom:14px;left:50%;display:flex;gap:7px;transform:translateX(-50%)}
.em-slider-dot{width:7px;height:7px;padding:0;border:0;border-radius:20px;background:#ffffffb8;cursor:pointer;transition:width .25s,background .25s}
.em-slider-dot.active{width:22px;background:#155eef}
.em-section{padding:42px 0 0}
.em-section-head{display:flex;justify-content:space-between;align-items:end;gap:16px;margin-bottom:18px}
.em-section-head h2{margin:0;font-size:clamp(20px,2.5vw,26px);letter-spacing:-.5px;font-weight:800}
.em-section-head p{margin:6px 0 0;color:#667085;font-size:12px}
.em-text-link{color:#155eef;font-size:11px;font-weight:700;white-space:nowrap;text-decoration:none}
.em-category-grid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:10px}
.em-category-card{display:flex;min-width:0;min-height:115px;flex-direction:column;align-items:center;justify-content:center;gap:10px;padding:12px 6px;border:1px solid #e6eaf0;border-radius:10px;background:#fff;text-decoration:none;transition:.2s}
.em-category-card:hover{transform:translateY(-2px);border-color:#b8ccff;box-shadow:0 7px 18px #15294b0c;color:#155eef}
.em-category-icon{display:grid;place-items:center;width:42px;height:42px;border-radius:11px;background:#edf3ff;color:#155eef;font-size:19px}
.em-category-card strong{font-size:11px;text-align:center}
.em-product-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:12px;align-items:stretch}
.em-product-card{display:flex;min-width:0;flex-direction:column;overflow:hidden;border:1px solid #e6eaf0;border-radius:10px;background:#fff;transition:transform .2s,box-shadow .2s}
.em-product-card:hover{transform:translateY(-2px);box-shadow:0 8px 20px #17203312}
.em-product-image{display:flex;align-items:center;justify-content:center;aspect-ratio:1/0.82;overflow:hidden;background:#f7f9fc;text-decoration:none}
.em-product-image img{display:block;width:100%;height:100%;padding:9px;object-fit:contain;box-sizing:border-box;transition:transform .25s}
.em-product-card:hover .em-product-image img{transform:scale(1.03)}
.em-product-info{display:flex;flex:1;flex-direction:column;align-items:flex-start;gap:4px;padding:10px;min-width:0}
.em-product-category{margin:0;color:#667085;font-size:10px;font-weight:600;line-height:1.4}
.em-product-name{display:-webkit-box;width:100%;min-height:32px;margin:0;overflow:hidden;color:#172033;font-size:12px;line-height:1.4;font-weight:700;overflow-wrap:anywhere;-webkit-box-orient:vertical;-webkit-line-clamp:2}
.em-product-price{margin:auto 0 7px;padding-top:5px;color:#155eef;font-size:14px;font-weight:800;overflow-wrap:anywhere}
.em-product-action{display:flex;align-items:center;justify-content:center;width:100%;min-height:32px;box-sizing:border-box;border:1px solid #cbd8f5;border-radius:6px;color:#155eef;background:#fff;font-size:10px;font-weight:700;text-decoration:none}
.em-product-action:hover{background:#155eef;border-color:#155eef;color:#fff}
.em-product-no-image{display:grid;place-items:center;width:100%;height:100%;padding:8px;color:#98a2b3;font-size:11px;text-align:center;box-sizing:border-box}
.em-empty-products{padding:30px 16px;border:1px solid #e6eaf0;border-radius:10px;background:#fff;text-align:center}
.em-empty-products h3{margin:0 0 8px;color:#172033;font-size:17px}
.em-empty-products p{margin:0 0 16px;color:#667085;font-size:12px}
.em-brand-panel{display:flex;align-items:center;justify-content:space-between;gap:22px;margin-top:42px;padding:26px;border-radius:12px;background:#111d35;color:#fff}
.em-brand-panel h2{margin:0 0 9px;font-size:clamp(20px,2.5vw,28px);font-weight:800;letter-spacing:-.5px}
.em-brand-panel p{max-width:520px;margin:0 0 14px;color:#c5cee0;font-size:12px;line-height:1.7}
.em-brand-panel img{width:34%;max-height:190px;object-fit:cover;border-radius:9px}
.em-service-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:0;margin-top:36px;padding:20px 0;border-top:1px solid #e7ecf3;border-bottom:1px solid #e7ecf3}
.em-service{display:flex;align-items:center;gap:10px;min-width:0;padding:4px 14px;border-right:1px solid #e7ecf3}
.em-service:first-child{padding-left:0}
.em-service:last-child{padding-right:0;border-right:0}
.em-service-icon{display:grid;place-items:center;width:38px;height:38px;flex:0 0 38px;border-radius:10px;background:#edf3ff;color:#2463d8;font-size:15px}
.em-service-copy{min-width:0}
.em-service strong{display:block;margin:0 0 4px;color:#172033;font-size:11px;line-height:1.35;font-weight:750}
.em-service-copy p{margin:0;color:#778196;font-size:10px;line-height:1.5}
@media(max-width:1100px){
    .em-container{width:94%}
    .em-product-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}
    .em-category-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
}
@media(max-width:900px){
    .em-service-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
    .em-service{padding:12px 10px;border-right:0}
    .em-service:nth-child(odd){border-right:1px solid #e7ecf3}
    .em-service:first-child,.em-service:nth-child(3){padding-left:0}
    .em-service:nth-child(2),.em-service:last-child{padding-right:0}
    .em-service:nth-child(-n+2){border-bottom:1px solid #e7ecf3}
}
@media(max-width:650px){
    .em-container{width:92%}
    .em-hero{height:auto;min-height:0;margin-top:16px}
    .em-hero-track{height:auto}
    .em-hero-slide{grid-template-columns:1fr;grid-template-rows:auto 190px;height:auto}
    .em-hero-copy{padding:28px 22px 36px}
    .em-hero h1{font-size:34px;letter-spacing:-1px}
    .em-hero-image{height:190px}
    .em-slider-arrow{width:32px;height:32px}
    .em-slider-prev{left:7px}
    .em-slider-next{right:7px}
    .em-section{padding-top:32px}
    .em-section-head{align-items:flex-start;gap:9px}
    .em-category-grid{gap:8px}
    .em-category-card{min-height:100px;gap:8px}
    .em-category-icon{width:36px;height:36px;font-size:17px}
    .em-category-card strong{font-size:10px}
    .em-product-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:8px}
    .em-product-image{aspect-ratio:1/0.9}
    .em-product-image img{padding:6px}
    .em-product-info{padding:8px}
    .em-product-name{font-size:11px;min-height:30px}
    .em-product-price{font-size:12px}
    .em-product-action{font-size:9px;min-height:29px}
    .em-brand-panel{flex-direction:column;align-items:flex-start;padding:20px}
    .em-brand-panel img{width:100%;max-height:170px}
    .em-service-grid{margin-top:28px;padding:8px 0}
    .em-service{align-items:flex-start;gap:8px;padding:12px 7px}
    .em-service-icon{width:30px;height:30px;flex-basis:30px;font-size:12px}
    .em-service strong{font-size:10px}
    .em-service-copy p{font-size:9px}
}
@media(max-width:480px){
    .em-product-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:8px}
    .em-product-image{aspect-ratio:1/0.8}
    .em-product-info{padding:9px}
    .em-product-name{font-size:12px}
    .em-product-price{font-size:13px}
    .em-section-head h2{font-size:20px}
    .em-section-head p{font-size:11px}
}
@media(prefers-reduced-motion:reduce){.em-hero-track{transition:none}}
</style>
@endpush

@section('content')
<div class="em-home">
    <div class="em-container">
        <section class="em-hero" id="emHeroSlider" aria-label="Banner utama">
            <div class="em-hero-track">
                <article class="em-hero-slide">
                    <div class="em-hero-copy">
                        <div class="em-eyebrow">Teknologi untuk keseharian</div>
                        <h1>Upgrade duniamu dengan <span>teknologi.</span></h1>
                        <p>Temukan smartphone, laptop, dan perangkat elektronik untuk menunjang aktivitasmu.</p>
                        <a href="{{ url('/shop') }}" class="em-btn">Jelajahi Produk <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="em-hero-image"><img src="https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=1200&q=85" alt="Perangkat elektronik modern" fetchpriority="high"></div>
                </article>
                <article class="em-hero-slide">
                    <div class="em-hero-copy">
                        <div class="em-eyebrow">Temukan perangkat pilihan</div>
                        <h1>Teknologi pintar untuk <span>aktivitasmu.</span></h1>
                        <p>Pilih smartphone dan aksesori yang mendukung komunikasi, kreativitas, dan produktivitasmu.</p>
                        <a href="{{ route('shop.category', ['category' => 'smartphone']) }}" class="em-btn">Lihat Smartphone <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="em-hero-image"><img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=85" alt="Smartphone modern" loading="lazy"></div>
                </article>
                <article class="em-hero-slide">
                    <div class="em-hero-copy">
                        <div class="em-eyebrow">Produktivitas tanpa batas</div>
                        <h1>Temukan perangkat untuk <span>berkarya.</span></h1>
                        <p>Jelajahi laptop dan perangkat komputer untuk belajar, bekerja, dan berkreasi.</p>
                        <a href="{{ route('shop.category', ['category' => 'laptop']) }}" class="em-btn">Jelajahi Laptop <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="em-hero-image"><img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=1200&q=85" alt="Laptop untuk produktivitas" loading="lazy"></div>
                </article>
            </div>
            <button type="button" class="em-slider-arrow em-slider-prev" aria-label="Slide sebelumnya"><i class="fa-solid fa-chevron-left"></i></button>
            <button type="button" class="em-slider-arrow em-slider-next" aria-label="Slide berikutnya"><i class="fa-solid fa-chevron-right"></i></button>
            <div class="em-slider-dots" aria-label="Pilih slide">
                <button type="button" class="em-slider-dot active" aria-label="Slide 1" aria-current="true"></button>
                <button type="button" class="em-slider-dot" aria-label="Slide 2"></button>
                <button type="button" class="em-slider-dot" aria-label="Slide 3"></button>
            </div>
        </section>

        <section class="em-section">
            <div class="em-section-head">
                <div><h2>Jelajahi Kategori</h2><p>Pilih kategori yang sesuai dengan kebutuhanmu.</p></div>
                <a class="em-text-link" href="{{ route('shop.index') }}">Semua produk <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="em-category-grid">
                <a class="em-category-card" href="{{ route('shop.category', ['category' => 'smartphone']) }}"><span class="em-category-icon"><i class="fa-solid fa-mobile-screen-button"></i></span><strong>Smartphone</strong></a>
                <a class="em-category-card" href="{{ route('shop.category', ['category' => 'laptop']) }}"><span class="em-category-icon"><i class="fa-solid fa-laptop"></i></span><strong>Laptop</strong></a>
                <a class="em-category-card" href="{{ route('shop.category', ['category' => 'komputer']) }}"><span class="em-category-icon"><i class="fa-solid fa-desktop"></i></span><strong>Komputer</strong></a>
                <a class="em-category-card" href="{{ route('shop.category', ['category' => 'aksesori']) }}"><span class="em-category-icon"><i class="fa-solid fa-headphones"></i></span><strong>Aksesori</strong></a>
                <a class="em-category-card" href="{{ route('shop.category', ['category' => 'gaming']) }}"><span class="em-category-icon"><i class="fa-solid fa-gamepad"></i></span><strong>Gaming</strong></a>
                <a class="em-category-card" href="{{ route('shop.category', ['category' => 'networking']) }}"><span class="em-category-icon"><i class="fa-solid fa-wifi"></i></span><strong>Networking</strong></a>
            </div>
        </section>

        <section class="em-section">
            <div class="em-section-head">
                <div><h2>Produk Pilihan</h2><p>Perangkat yang bisa menemani aktivitasmu setiap hari.</p></div>
                <a class="em-text-link" href="{{ route('shop.index') }}">Lihat semua <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            @if (isset($produks) && $produks->isNotEmpty())
                <div class="em-product-grid">
                    @foreach ($produks as $produk)
                        @php
                            $slugKategori = \Illuminate\Support\Str::slug($produk->kategori->nama_kategori ?? '');
                            $jumlahUlasan = $produk->ulasanProduk->count();
                            $rataRataRating = $jumlahUlasan > 0 ? $produk->ulasanProduk->avg('rating') : 0;
                        @endphp
                        <article class="em-product-card">
                            <a class="em-product-image" href="{{ route('produk.detail', $produk->id_produk) }}">
                                @if ($produk->gambar)
                                    @php
                                        $gambar = $produk->gambar;
                                        if (!preg_match('/^https?:\/\//i', $gambar)) {
                                            $gambar = asset('storage/' . ltrim($gambar, '/'));
                                        }
                                    @endphp
                                    <img src="{{ $gambar }}" alt="{{ $produk->nama_produk }}" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';">
                                    <span class="em-product-no-image" style="display:none;">Gambar tidak tersedia</span>
                                @else
                                    <span class="em-product-no-image">Gambar belum tersedia</span>
                                @endif
                            </a>
                            <div class="em-product-info">
                                <p class="em-product-category">{{ $produk->kategori->nama_kategori ?? 'Produk' }}</p>
                                <h3 class="em-product-name">{{ $produk->nama_produk }}</h3>
                                <div style="font-size:11px;line-height:1.4;">
                                    @if ($jumlahUlasan > 0)
                                        <span style="color:#f59e0b;">★ {{ number_format($rataRataRating, 1) }}</span>
                                        <span style="color:#667085;">({{ $jumlahUlasan }})</span>
                                    @else
                                        <span style="color:#98a2b3;">Belum ada ulasan</span>
                                    @endif
                                </div>
                                <p class="em-product-price">Rp {{ number_format((float) $produk->harga_jual, 0, ',', '.') }}</p>
                                <a class="em-product-action" href="{{ route('produk.detail', $produk->id_produk) }}">Lihat Detail</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="em-empty-products">
                    <h3>Belum ada produk</h3>
                    <p>Produk akan tampil di sini setelah tersedia di database.</p>
                    <a href="{{ route('shop.index') }}" class="em-btn">Jelajahi katalog</a>
                </div>
            @endif
        </section>

        <section class="em-brand-panel">
            <div><h2>Teknologi yang mendukung setiap langkahmu.</h2><p>Jelajahi pilihan perangkat untuk belajar, bekerja, berkreasi, dan menikmati hiburan. Temukan produk yang sesuai dengan kebutuhanmu.</p><a href="{{ route('shop.index') }}" class="em-btn">Lihat katalog <i class="fa-solid fa-arrow-right"></i></a></div>
            <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1000&q=85" alt="Perangkat teknologi untuk produktivitas" loading="lazy">
        </section>
    </div>

    <section class="em-container em-service-grid" aria-label="Informasi layanan">
        <div class="em-service"><span class="em-service-icon" aria-hidden="true"><i class="fa-solid fa-truck-fast"></i></span><div class="em-service-copy"><strong>Informasi Pengiriman</strong><p>Detail pengiriman yang mudah dipahami.</p></div></div>
        <div class="em-service"><span class="em-service-icon" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></span><div class="em-service-copy"><strong>Transaksi Lebih Aman</strong><p>Utamakan keamanan saat berbelanja.</p></div></div>
        <div class="em-service"><span class="em-service-icon" aria-hidden="true"><i class="fa-solid fa-circle-info"></i></span><div class="em-service-copy"><strong>Informasi Produk</strong><p>Bantu pilih perangkat sesuai kebutuhan.</p></div></div>
        <div class="em-service"><span class="em-service-icon" aria-hidden="true"><i class="fa-solid fa-headset"></i></span><div class="em-service-copy"><strong>Bantuan Pelanggan</strong><p>Dukungan untuk pertanyaan produk.</p></div></div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('emHeroSlider');
    if (!slider) return;
    const track = slider.querySelector('.em-hero-track');
    const slides = slider.querySelectorAll('.em-hero-slide');
    const dots = slider.querySelectorAll('.em-slider-dot');
    const prev = slider.querySelector('.em-slider-prev');
    const next = slider.querySelector('.em-slider-next');
    if (!track || !slides.length || !prev || !next) return;
    let current = 0;
    let timer = null;
    function showSlide(index) {
        current = (index + slides.length) % slides.length;
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
        dots.forEach(function (dot, i) {
            dot.classList.toggle('active', i === current);
            if (i === current) dot.setAttribute('aria-current', 'true');
            else dot.removeAttribute('aria-current');
        });
    }
    function stopAutoSlide() {
        if (timer) clearInterval(timer);
        timer = null;
    }
    function startAutoSlide() {
        stopAutoSlide();
        timer = setInterval(function () { showSlide(current + 1); }, 5000);
    }
    prev.addEventListener('click', function () { showSlide(current - 1); startAutoSlide(); });
    next.addEventListener('click', function () { showSlide(current + 1); startAutoSlide(); });
    dots.forEach(function (dot, index) {
        dot.addEventListener('click', function () { showSlide(index); startAutoSlide(); });
    });
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
    slider.addEventListener('focusin', stopAutoSlide);
    slider.addEventListener('focusout', startAutoSlide);
    showSlide(0);
    startAutoSlide();
});
</script>
@endpush
