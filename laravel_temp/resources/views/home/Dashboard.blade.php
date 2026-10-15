@extends('layouts.customer')



@section('title', 'Beranda')



@push('styles')


          .em-home { color: #172033; }

          .em-container { width: min(1320px, 90%); margin: 0 auto; }



          /* HERO SLIDER */

          .em-hero { position: relative; display: block; height: 400px; min-height: 400px; margin: 28px auto 0; overflow: hidden; border-radius: 16px; background: #eaf1ff; }

          .em-hero-track { display: flex; height: 100%; transition: transform .65s cubic-bezier(.22,.61,.36,1); will-change: transform; }

          .em-hero-slide { display: grid; grid-template-columns: 1fr 1fr; flex: 0 0 100%; min-width: 100%; height: 100%; }



.em-hero-copy {

          display: flex;

          flex-direction: column;

          align-items: flex-start;

          justify-content: center;

          padding: 40px clamp(28px, 5vw, 66px);

          min-width: 0;

}



.em-hero h1 {

          max-width: 480px;

          margin: 0 0 16px;

          color: #172033;

          font-size: clamp(32px, 3.6vw, 48px);

          line-height: 1.08;

          letter-spacing: -1.8px;

          font-weight: 800;

}



.em-hero-copy > p {

          max-width: 390px;

          margin: 0 0 18px;

          color: #667085;

          font-size: 13px;

          line-height: 1.65;

}



          .em-eyebrow { display: inline-flex; align-items: center; gap: 8px; color: #155eef; font-size: 11px; font-weight: 800; letter-spacing: 1.4px; text-transform: uppercase; margin-bottom: 18px; }

          .em-eyebrow:before { content: ""; width: 7px; height: 7px; flex: 0 0 7px; border-radius: 50%; background: #155eef; }

          .em-hero h1 { max-width: 520px; margin: 0 0 18px; color: #172033; font-size: clamp(34px,4vw,54px); line-height: 1.08; letter-spacing: -2px; font-weight: 800; }

          .em-hero h1 span { color: #155eef; }

          .em-hero-copy > p { max-width: 390px; margin: 0 0 22px; color: #667085; font-size: 14px; line-height: 1.8; }

          .em-btn { display: inline-flex; align-items: center; justify-content: center; gap: 12px; min-height: 46px; padding: 0 22px; border: 0; border-radius: 7px; background: #155eef; color: #fff; font-size: 12px; font-weight: 700; transition: .2s; }

          .em-btn:hover { background: #1048c7; color: #fff; transform: translateY(-1px); }

          .em-hero-image { min-width: 0; min-height: 0; height: 100%; overflow: hidden; }

          .em-hero-image img { display: block; width: 100%; height: 100%; object-fit: cover; }

          .em-slider-arrow { position: absolute; top: 50%; z-index: 4; display: grid; place-items: center; width: 42px; height: 42px; padding: 0; transform: translateY(-50%); border: 1px solid #ffffffa8; border-radius: 50%; background: #ffffffdf; color: #172033; box-shadow: 0 4px 15px #17203315; cursor: pointer; transition: .2s; }

          .em-slider-arrow:hover { background: #155eef; color: #fff; }

          .em-slider-prev { left: 14px; } .em-slider-next { right: 14px; }

          .em-slider-dots { position: absolute; z-index: 4; bottom: 16px; left: 50%; display: flex; gap: 8px; transform: translateX(-50%); }

          .em-slider-dot { width: 8px; height: 8px; padding: 0; border: 0; border-radius: 20px; background: #ffffffb8; cursor: pointer; transition: width .25s, background .25s; }

          .em-slider-dot.active { width: 25px; background: #155eef; }



          /* KATEGORI DAN PRODUK */

          .em-section { padding: 56px 0 0; }

          .em-section-head { display: flex; justify-content: space-between; align-items: end; gap: 20px; margin-bottom: 24px; }

          .em-section-head h2 { margin: 0; font-size: clamp(22px,3vw,29px); letter-spacing: -.8px; font-weight: 800; }

          .em-section-head p { margin: 7px 0 0; color: #667085; font-size: 13px; }

          .em-text-link { color: #155eef; font-size: 12px; font-weight: 700; white-space: nowrap; }

          .em-category-grid { display: grid; grid-template-columns: repeat(6,minmax(0,1fr)); gap: 14px; }

          .em-category-card { min-height: 145px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px; padding: 18px 8px; border: 1px solid #e6eaf0; border-radius: 12px; background: #fff; transition: .2s; }

          .em-category-card:hover { transform: translateY(-3px); border-color: #b8ccff; box-shadow: 0 10px 25px #15294b0c; color: #155eef; }

          .em-category-icon { display: grid; place-items: center; width: 54px; height: 54px; border-radius: 14px; background: #edf3ff; color: #155eef; font-size: 23px; }

          .em-category-card strong { font-size: 12px; }

          .em-product-grid { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 18px; }

          .em-product-card { min-width: 0; overflow: hidden; border: 1px solid #e6eaf0; border-radius: 12px; background: #fff; transition: .25s; }

          .em-product-card:hover { transform: translateY(-4px); box-shadow: 0 14px 30px #17203312; }

          .em-product-image { display: block; aspect-ratio: 1/1; overflow: hidden; background: #f5f7fb; }

          .em-product-image img { width: 100%; height: 100%; object-fit: contain; padding: 16px; transition: transform .3s; }

          .em-product-card:hover .em-product-image img { transform: scale(1.04); }

          .em-product-info { padding: 16px; }

          .em-product-category { margin: 0 0 7px; color: #667085; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; }

          .em-product-name { min-height: 40px; margin: 0 0 8px; font-size: 13px; line-height: 1.55; font-weight: 700; }

          .em-product-price { margin: 0 0 14px; color: #155eef; font-size: 16px; font-weight: 800; }

          .em-product-action { display: flex; align-items: center; justify-content: center; width: 100%; min-height: 38px; border: 1px solid #cbd8f5; border-radius: 7px; color: #155eef; background: #fff; font-size: 11px; font-weight: 700; }

          .em-product-action:hover { background: #155eef; border-color: #155eef; color: #fff; }

          .em-brand-panel { margin-top: 56px; padding: 32px; border-radius: 14px; background: #111d35; color: #fff; display: flex; align-items: center; justify-content: space-between; gap: 28px; }

          .em-brand-panel h2 { margin: 0 0 10px; font-size: clamp(22px,3vw,32px); font-weight: 800; letter-spacing: -.7px; }

          .em-brand-panel p { max-width: 520px; margin: 0 0 18px; color: #c5cee0; font-size: 13px; line-height: 1.7; }

          .em-brand-panel img { width: 35%; max-height: 220px; object-fit: cover; border-radius: 10px; }



          /* EMPAT INFORMASI LAYANAN - REFINED STRIP */

          .em-service-grid {

                    display: grid;

                    grid-template-columns: repeat(4, minmax(0, 1fr));

                    gap: 0;

                    margin-top: 48px;

                    padding: 25px 0;

                    border-top: 1px solid #e7ecf3;

                    border-bottom: 1px solid #e7ecf3;

                    background: transparent;

          }

          .em-service {

                    display: flex;

                    align-items: center;

                    gap: 13px;

                    min-width: 0;

                    padding: 4px 22px;

                    border-right: 1px solid #e7ecf3;

          }

          .em-service:first-child { padding-left: 0; }

          .em-service:last-child { padding-right: 0; border-right: 0; }

          .em-service-icon {

                    display: grid;

                    place-items: center;

                    width: 46px;

                    height: 46px;

                    flex: 0 0 46px;

                    border-radius: 13px;

                    background: #edf3ff;

                    color: #2463d8;

                    font-size: 17px;

                    box-shadow: inset 0 0 0 1px #e1eaff;

          }

          .em-service-copy { min-width: 0; }

          .em-service strong {

                    display: block;

                    margin: 0 0 5px;

                    color: #172033;

                    font-size: 12px;

                    line-height: 1.35;

                    font-weight: 750;

                    letter-spacing: -.1px;

          }

          .em-service-copy p {

                    margin: 0;

                    color: #778196;

                    font-size: 11px;

                    line-height: 1.5;

          }



          @media (max-width: 1000px) { .em-category-grid { grid-template-columns: repeat(3,minmax(0,1fr)); } .em-product-grid { grid-template-columns: repeat(2,minmax(0,1fr)); } .em-hero h1 { font-size: clamp(30px,4vw,45px); } }

          @media (max-width: 900px) {

                    .em-service-grid { grid-template-columns: repeat(2,minmax(0,1fr)); gap: 0; }

                    .em-service { padding: 16px 14px; border-right: 0; }

                    .em-service:nth-child(odd) { border-right: 1px solid #e7ecf3; }

                    .em-service:first-child, .em-service:nth-child(3) { padding-left: 0; }

                    .em-service:nth-child(2), .em-service:last-child { padding-right: 0; }

                    .em-service:nth-child(-n+2) { border-bottom: 1px solid #e7ecf3; }

          }

          @media (max-width: 650px) {

                    .em-container { width: 92%; }

                    .em-hero { height: auto; min-height: 0; margin-top: 18px; }

                    .em-hero-track { height: auto; }

                    .em-hero-slide { grid-template-columns: 1fr; grid-template-rows: auto 210px; height: auto; }

                    .em-hero-copy { padding: 32px 24px 42px; }

                    .em-hero h1 { font-size: 38px; letter-spacing: -1.4px; }

                    .em-hero-image { height: 210px; }

                    .em-slider-arrow { width: 34px; height: 34px; }

                    .em-slider-prev { left: 8px; } .em-slider-next { right: 8px; }

                    .em-section { padding-top: 42px; }

                    .em-section-head { align-items: flex-start; flex-direction: column; gap: 10px; }

                    .em-category-grid { gap: 9px; }

                    .em-category-card { min-height: 120px; gap: 10px; }

                    .em-category-icon { width: 44px; height: 44px; font-size: 20px; }

                    .em-category-card strong { font-size: 10px; }

                    .em-product-grid { gap: 11px; }

                    .em-product-info { padding: 11px; }

                    .em-product-name { font-size: 12px; }

                    .em-product-price { font-size: 14px; }

                    .em-service-grid { padding: 10px 0; margin-top: 36px; }

                    .em-service { align-items: flex-start; gap: 9px; padding: 14px 8px; }

                    .em-service-icon { width: 34px; height: 34px; flex-basis: 34px; border-radius: 10px; font-size: 13px; }

                    .em-service strong { font-size: 10px; }

                    .em-service-copy p { font-size: 9px; }

                    .em-brand-panel { flex-direction: column; align-items: flex-start; padding: 25px; }

                    .em-brand-panel img { width: 100%; max-height: 190px; }

          }

          @media (max-width: 480px) { .em-service-grid { gap: 20px 10px; } }

          @media (prefers-reduced-motion: reduce) { .em-hero-track { transition: none; } }


    .em-product-no-image { display: grid; place-items: center; width: 100%; height: 100%; padding: 12px; color: #98a2b3; font-size: 12px; text-align: center; }
    .em-empty-products { padding: 40px 20px; border: 1px solid #e6eaf0; border-radius: 12px; background: #fff; text-align: center; }
    .em-empty-products h3 { margin-bottom: 8px; color: #172033; font-size: 18px; }
    .em-empty-products p { margin-bottom: 18px; color: #667085; font-size: 13px; }

@endpush



@section('content')

<div class="em-home">

          <div class="em-container">

                    {{-- HERO SLIDER --}}

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

                                                            <a href="{{ url('/shop?category=smartphone') }}" class="em-btn">Lihat Smartphone <i class="fa-solid fa-arrow-right"></i></a>

                                                  </div>

                                                  <div class="em-hero-image"><img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=85" alt="Smartphone modern" loading="lazy"></div>

                                        </article>

                                        <article class="em-hero-slide">

                                                  <div class="em-hero-copy">

                                                            <div class="em-eyebrow">Produktivitas tanpa batas</div>

                                                            <h1>Temukan perangkat untuk <span>berkarya.</span></h1>

                                                            <p>Jelajahi laptop dan perangkat komputer untuk belajar, bekerja, dan berkreasi.</p>

                                                            <a href="{{ url('/shop?category=laptop') }}" class="em-btn">Jelajahi Laptop <i class="fa-solid fa-arrow-right"></i></a>

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



                    {{-- KATEGORI --}}

                    <section class="em-section">

                              <div class="em-section-head">

                                        <div><h2>Jelajahi Kategori</h2><p>Pilih kategori yang sesuai dengan kebutuhanmu.</p></div>

                                        <a class="em-text-link" href="{{ url('/shop') }}">Semua produk <i class="fa-solid fa-arrow-right ms-1"></i></a>

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



                    {{-- PRODUK PILIHAN DARI DATABASE --}}
        <section class="em-section">
            <div class="em-section-head">
                <div>
                    <h2>Produk Pilihan</h2>
                    <p>Perangkat yang bisa menemani aktivitasmu setiap hari.</p>
                </div>
                <a class="em-text-link" href="{{ route('shop.index') }}">Lihat semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>

            @if (isset($produks) && $produks->isNotEmpty())
                <div class="em-product-grid">
                    @foreach ($produks as $produk)
                        <article class="em-product-card">
                            <a class="em-product-image" href="{{ route('shop.category', ['category' => \Illuminate\Support\Str::slug($produk->kategori->nama_kategori ?? '')]) }}">
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
                                <p class="em-product-price">Rp{{ number_format((float) $produk->harga_jual, 0, ',', '.') }}</p>
                                <a class="em-product-action" href="{{ route('shop.category', ['category' => \Illuminate\Support\Str::slug($produk->kategori->nama_kategori ?? '')]) }}">Lihat kategori</a>
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

        {{-- BANNER TANPA KUPON / DISKON --}}

                    <section class="em-brand-panel">

                              <div><h2>Teknologi yang mendukung setiap langkahmu.</h2><p>Jelajahi pilihan perangkat untuk belajar, bekerja, berkreasi, dan menikmati hiburan. Temukan produk yang sesuai dengan kebutuhanmu.</p><a href="{{ url('/shop') }}" class="em-btn">Lihat katalog <i class="fa-solid fa-arrow-right"></i></a></div>

                              <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1000&q=85" alt="Perangkat teknologi untuk produktivitas" loading="lazy">

                    </section>

          </div>



          {{-- EMPAT INFORMASI LAYANAN --}}

          <section class="em-container em-service-grid" aria-label="Informasi layanan">

                    <div class="em-service">

                              <span class="em-service-icon" aria-hidden="true"><i class="fa-solid fa-truck-fast"></i></span>

                              <div class="em-service-copy"><strong>Informasi Pengiriman</strong><p>Detail pengiriman yang mudah dipahami.</p></div>

                    </div>

                    <div class="em-service">

                              <span class="em-service-icon" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></span>

                              <div class="em-service-copy"><strong>Transaksi Lebih Aman</strong><p>Utamakan keamanan saat berbelanja.</p></div>

                    </div>

                    <div class="em-service">

                              <span class="em-service-icon" aria-hidden="true"><i class="fa-solid fa-circle-info"></i></span>

                              <div class="em-service-copy"><strong>Informasi Produk</strong><p>Bantu pilih perangkat sesuai kebutuhan.</p></div>

                    </div>

                    <div class="em-service">

                              <span class="em-service-icon" aria-hidden="true"><i class="fa-solid fa-headset"></i></span>

                              <div class="em-service-copy"><strong>Bantuan Pelanggan</strong><p>Dukungan untuk pertanyaan produk.</p></div>

                    </div>

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
