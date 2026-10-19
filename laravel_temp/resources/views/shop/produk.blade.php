
@extends('layouts.customer')

@section('title', 'Semua Produk')

@push('styles')
<style>
.shop-container{width:100%;max-width:1400px;margin:0 auto;padding:28px 36px 48px;box-sizing:border-box}
.shop-breadcrumb{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-bottom:20px;color:#667085;font-size:12px}
.shop-breadcrumb a{color:#155eef;text-decoration:none}
.shop-heading{margin-bottom:24px}
.shop-heading h1{margin:0 0 7px;color:#172033;font-size:clamp(25px,3vw,32px);font-weight:700;line-height:1.3}
.shop-heading p{margin:0;color:#667085;font-size:13px;line-height:1.6}
.shop-layout{display:grid;grid-template-columns:230px minmax(0,1fr);gap:20px;align-items:start}
.shop-sidebar{padding:16px;background:#fff;border:1px solid #e6eaf0;border-radius:10px;box-sizing:border-box}
.filter-heading{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:15px}
.filter-heading h2{margin:0;color:#172033;font-size:16px}
.filter-reset{color:#155eef;font-size:11px;text-decoration:none}
.filter-section{padding-top:14px;border-top:1px solid #e6eaf0}
.filter-section h3{margin:0 0 13px;color:#172033;font-size:13px}
.filter-price-values{display:flex;justify-content:space-between;gap:8px;margin-bottom:16px}
.filter-price-value{min-width:0;color:#172033;font-size:11px;font-weight:700;overflow-wrap:anywhere}
.filter-price-value small{display:block;margin-bottom:4px;color:#667085;font-size:10px;font-weight:400}
.filter-slider{position:relative;height:6px;margin:0 9px 20px;background:#dbe4f5;border-radius:99px}
.filter-slider-track{position:absolute;height:6px;background:#155eef;border-radius:99px}
.filter-slider input[type=range]{position:absolute;top:-7px;left:0;width:100%;height:20px;margin:0;background:none;pointer-events:none;appearance:none;-webkit-appearance:none}
.filter-slider input[type=range]::-webkit-slider-thumb{width:19px;height:19px;border:3px solid #fff;border-radius:50%;background:#155eef;box-shadow:0 0 0 1px #155eef;pointer-events:auto;appearance:none;-webkit-appearance:none;cursor:grab}
.filter-slider input[type=range]::-moz-range-thumb{width:14px;height:14px;border:3px solid #fff;border-radius:50%;background:#155eef;box-shadow:0 0 0 1px #155eef;pointer-events:auto;cursor:grab}
.filter-price-inputs{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px}
.filter-price-inputs label{display:grid;gap:5px;color:#667085;font-size:10px}
.filter-price-inputs input{width:100%;min-width:0;padding:8px 6px;border:1px solid #d0d5dd;border-radius:7px;font-size:11px;box-sizing:border-box}
.filter-price-inputs input:focus{outline:none;border-color:#155eef;box-shadow:0 0 0 3px rgba(21,94,239,.1)}
.filter-ranges{display:grid;gap:9px;margin:15px 0}
.filter-range{display:flex;align-items:center;gap:7px;color:#475467;font-size:11px;cursor:pointer}
.filter-range input{accent-color:#155eef}
.filter-apply{width:100%;margin-top:12px;padding:10px;border:0;border-radius:7px;background:#155eef;color:#fff;font-size:12px;font-weight:600;cursor:pointer}
.filter-apply:hover{background:#1048c7}
.shop-main{min-width:0}
.shop-toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}
.shop-count{margin:0;color:#667085;font-size:12px}
.produk-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));align-items:stretch;gap:12px;width:100%}
.produk-card{display:flex;flex-direction:column;min-width:0;overflow:hidden;background:#fff;border:1px solid #e6eaf0;border-radius:10px;transition:transform .2s,box-shadow .2s,border-color .2s}
.produk-card:hover{transform:translateY(-2px);border-color:#d5e1fa;box-shadow:0 7px 18px rgba(23,32,51,.07)}
.produk-card-link{display:flex;flex:1;flex-direction:column;min-width:0;color:inherit;text-decoration:none}
.produk-card-link:hover{color:inherit}
.produk-image{display:flex;align-items:center;justify-content:center;width:100%;height:165px;padding:10px;overflow:hidden;background:#f7f9fc;box-sizing:border-box}
.produk-image img{display:block;width:100%;height:100%;object-fit:contain;transition:transform .25s}
.produk-card:hover .produk-image img{transform:scale(1.03)}
.produk-no-image{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;width:100%;height:100%;color:#98a2b3;font-size:11px;text-align:center}
.produk-no-image i{font-size:27px}
.produk-info{display:flex;flex:1;flex-direction:column;align-items:flex-start;gap:5px;min-width:0;padding:10px;box-sizing:border-box}
.produk-brand{color:#667085;font-size:10px;line-height:1.4}
.produk-name{display:-webkit-box;width:100%;min-height:32px;margin:0;overflow:hidden;color:#172033;font-size:12px;font-weight:600;line-height:1.4;overflow-wrap:anywhere;-webkit-box-orient:vertical;-webkit-line-clamp:2}
.produk-category{color:#667085;font-size:10px;line-height:1.4}
.produk-rating{display:flex;flex-wrap:wrap;align-items:center;gap:4px;font-size:11px;line-height:1.4}
.produk-price{margin-top:auto;padding-top:5px;color:#155eef;font-size:14px;font-weight:700;line-height:1.4;overflow-wrap:anywhere}
.produk-stock{color:#667085;font-size:10px}
.produk-stock.tersedia{color:#15803d}
.produk-stock.habis{color:#dc2626}
.produk-action{padding:0 10px 10px}
.produk-button{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;min-height:32px;padding:7px 9px;border:1px solid #155eef;border-radius:6px;background:#155eef;color:#fff;font-size:10px;font-weight:600;text-align:center;text-decoration:none;box-sizing:border-box}
.produk-button:hover{border-color:#1048c7;background:#1048c7;color:#fff}
.produk-empty{grid-column:1/-1;padding:35px 16px;border:1px dashed #d0d5dd;border-radius:10px;background:#fff;text-align:center}
.produk-empty i{margin-bottom:10px;color:#98a2b3;font-size:32px}
.produk-empty h2{margin:0 0 7px;color:#172033;font-size:18px;font-weight:700}
.produk-empty p{margin:0;color:#667085;font-size:12px}
.shop-pagination{display:flex;justify-content:center;margin-top:25px}
.shop-pagination nav{max-width:100%}
@media(min-width:1250px){.produk-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
@media(max-width:1000px){.shop-container{padding-right:24px;padding-left:24px}.shop-layout{grid-template-columns:205px minmax(0,1fr);gap:14px}.produk-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:10px}.produk-image{height:145px}.produk-info{padding:9px}}
@media(max-width:768px){.shop-container{padding:24px 18px 36px}.shop-layout{grid-template-columns:1fr}.shop-sidebar{padding:14px}.produk-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:9px}.produk-image{height:140px}}
@media(max-width:540px){.shop-container{padding:20px 12px 30px}.shop-layout{gap:15px}.produk-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.produk-image{height:145px;padding:8px}.produk-info{gap:5px;padding:9px}.produk-name{font-size:12px}.produk-price{font-size:13px}.produk-action{padding:0 9px 9px}.produk-button{min-height:31px;font-size:10px}}
</style>
@endpush

@section('content')
<div class="shop-container">
    <nav class="shop-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a><span>/</span>
        <span aria-current="page">Semua Produk</span>
    </nav>

    <header class="shop-heading">
        <h1>Semua Produk</h1>
        <p>Jelajahi koleksi produk elektronik ELECTROMART.</p>
    </header>

    <div class="shop-layout">
        <aside class="shop-sidebar">
            <div class="filter-heading">
                <h2>Filter Produk</h2>
                <a href="{{ route('shop.index') }}" class="filter-reset">Reset</a>
            </div>

            @php
                $priceMin = max(0, min(50000000, (int) request('min_price', $minPrice ?? 0)));
                $priceMax = max(0, min(50000000, (int) request('max_price', $maxPrice ?? 50000000)));
                if ($priceMin > $priceMax) {
                    $priceMin = 0;
                    $priceMax = 50000000;
                }
                $selectedRange = request('price_range', $selectedRange ?? '');
                $ranges = [
                    'under500' => ['label' => 'Di bawah Rp500.000', 'min' => 0, 'max' => 499999],
                    '500to1m' => ['label' => 'Rp500.000 – Rp1.000.000', 'min' => 500000, 'max' => 1000000],
                    '1to3m' => ['label' => 'Rp1.000.001 – Rp3.000.000', 'min' => 1000001, 'max' => 3000000],
                    'above3m' => ['label' => 'Di atas Rp3.000.000', 'min' => 3000001, 'max' => 50000000],
                ];
            @endphp

            <form action="{{ route('shop.index') }}" method="GET" id="productPriceFilter">
                <div class="filter-section">
                    <h3>Rentang Harga</h3>

                    <div class="filter-price-values">
                        <div class="filter-price-value"><small>Harga minimum</small><span id="productMinLabel">Rp{{ number_format($priceMin, 0, ',', '.') }}</span></div>
                        <div class="filter-price-value" style="text-align:right"><small>Harga maksimum</small><span id="productMaxLabel">Rp{{ number_format($priceMax, 0, ',', '.') }}</span></div>
                    </div>

                    <div class="filter-slider">
                        <div class="filter-slider-track" id="productRangeTrack"></div>
                        <input type="range" id="productMinRange" min="0" max="50000000" step="100000" value="{{ $priceMin }}" aria-label="Harga minimum">
                        <input type="range" id="productMaxRange" min="0" max="50000000" step="100000" value="{{ $priceMax }}" aria-label="Harga maksimum">
                    </div>

                    <div class="filter-price-inputs">
                        <label>Minimum (Rp)<input type="number" id="productMinInput" name="min_price" min="0" max="50000000" step="1000" value="{{ request('min_price', $minPrice ?? '') }}" placeholder="Minimum"></label>
                        <label>Maksimum (Rp)<input type="number" id="productMaxInput" name="max_price" min="0" max="50000000" step="1000" value="{{ request('max_price', $maxPrice ?? '') }}" placeholder="Maksimum"></label>
                    </div>

                    <div class="filter-ranges">
                        @foreach ($ranges as $value => $range)
                            <label class="filter-range">
                                <input type="radio" name="price_range" value="{{ $value }}" data-min="{{ $range['min'] }}" data-max="{{ $range['max'] }}" {{ $selectedRange === $value ? 'checked' : '' }}>
                                <span>{{ $range['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="filter-apply">Terapkan Filter</button>
                </div>
            </form>
        </aside>

        <main class="shop-main">
            <div class="shop-toolbar"><p class="shop-count">{{ $produk->total() }} produk tersedia</p></div>

            <div class="produk-grid">
                @forelse ($produk as $item)
                    @php
                        $stokTersedia = (int) ($item->stok->jumlah_stok ?? 0);
                        $namaBrand = $item->brand->nama_brand ?? null;
                        $namaKategori = $item->kategori->nama_kategori ?? null;
                        $jumlahUlasan = $item->ulasanProduk->count();
                        $rataRataRating = $jumlahUlasan > 0 ? $item->ulasanProduk->avg('rating') : 0;
                    @endphp
                    <article class="produk-card">
                        <a href="{{ route('produk.detail', $item->id_produk) }}" class="produk-card-link" aria-label="Lihat detail {{ $item->nama_produk }}">
                            <div class="produk-image">
                                @if ($item->gambar)
                                    @php
                                        $gambar = $item->gambar;
                                        if (!preg_match('/^https?:\/\//i', $gambar)) {
                                            $gambar = asset('storage/' . ltrim($gambar, '/'));
                                        }
                                    @endphp
                                    <img src="{{ $gambar }}" alt="{{ $item->nama_produk }}" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                    <div class="produk-no-image" style="display:none">Gambar tidak tersedia</div>
                                @else
                                    <div class="produk-no-image"><i class="fa-regular fa-image"></i><span>Gambar belum tersedia</span></div>
                                @endif
                            </div>
                            <div class="produk-info">
                                <span class="produk-brand">{{ $namaBrand ?: 'ELECTROMART' }}</span>
                                <h2 class="produk-name">{{ $item->nama_produk }}</h2>
                                @if ($namaKategori)<span class="produk-category">{{ $namaKategori }}</span>@endif
                                <div class="produk-rating">
                                    @if ($jumlahUlasan > 0)
                                        <span style="color:#f59e0b;">★ {{ number_format($rataRataRating, 1) }}</span>
                                        <span style="color:#667085;">({{ $jumlahUlasan }} ulasan)</span>
                                    @else
                                        <span style="color:#98a2b3;">Belum ada ulasan</span>
                                    @endif
                                </div>
                                <div class="produk-price">Rp {{ number_format((float) $item->harga_jual, 0, ',', '.') }}</div>
                                <span class="produk-stock {{ $stokTersedia > 0 ? 'tersedia' : 'habis' }}">
                                    @if ($stokTersedia > 0) Stok: {{ $stokTersedia }} @else Stok habis @endif
                                </span>
                            </div>
                        </a>
                        <div class="produk-action"><a href="{{ route('produk.detail', $item->id_produk) }}" class="produk-button">Lihat Detail <i class="fa-solid fa-arrow-right"></i></a></div>
                    </article>
                @empty
                    <div class="produk-empty">
                        <i class="fa-solid fa-box-open"></i>
                        <h2>Produk Tidak Ditemukan</h2>
                        <p>Tidak ada produk pada rentang harga tersebut. Silakan ubah filter harga.</p>
                    </div>
                @endforelse
            </div>

            @if (method_exists($produk, 'links'))
                <div class="shop-pagination">{{ $produk->appends(request()->query())->links() }}</div>
            @endif
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('productPriceFilter');
    if (!form) return;

    const minRange = document.getElementById('productMinRange');
    const maxRange = document.getElementById('productMaxRange');
    const minInput = document.getElementById('productMinInput');
    const maxInput = document.getElementById('productMaxInput');
    const minLabel = document.getElementById('productMinLabel');
    const maxLabel = document.getElementById('productMaxLabel');
    const track = document.getElementById('productRangeTrack');
    const maxValue = 50000000;
    const gap = 100000;
    const rupiah = value => 'Rp' + Number(value).toLocaleString('id-ID');

    function update(source, syncInputs = true) {
        let min = Number(minRange.value);
        let max = Number(maxRange.value);

        if (max - min < gap) {
            if (source === 'min') min = max - gap;
            else max = min + gap;
        }

        min = Math.max(0, min);
        max = Math.min(maxValue, max);
        minRange.value = min;
        maxRange.value = max;

        if (syncInputs) {
            minInput.value = min;
            maxInput.value = max;
        }

        minLabel.textContent = rupiah(min);
        maxLabel.textContent = rupiah(max);
        track.style.left = (min / maxValue * 100) + '%';
        track.style.width = ((max - min) / maxValue * 100) + '%';

        form.querySelectorAll('input[name="price_range"]').forEach(radio => {
            radio.checked = Number(radio.dataset.min) === min && Number(radio.dataset.max) === max;
        });
    }

    minRange.addEventListener('input', () => update('min'));
    maxRange.addEventListener('input', () => update('max'));

    minInput.addEventListener('input', function () {
        const min = Math.max(0, Math.min(maxValue, Number(this.value || 0)));
        minRange.value = min;
        update('min', false);
    });

    maxInput.addEventListener('input', function () {
        const max = Math.max(0, Math.min(maxValue, Number(this.value || maxValue)));
        maxRange.value = max;
        update('max', false);
    });

    form.querySelectorAll('input[name="price_range"]').forEach(radio => {
        radio.addEventListener('change', function () {
            minRange.value = this.dataset.min;
            maxRange.value = this.dataset.max;
            minInput.value = this.dataset.min;
            maxInput.value = this.dataset.max;
            update('max');
        });
    });

    update('max', false);
});
</script>
@endpush
