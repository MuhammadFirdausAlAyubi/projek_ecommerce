@extends('layouts.customer')

@section('title', 'Semua Produk')

@push('styles')
<style>
.shop-container{width:100%;max-width:1400px;margin:0 auto;padding:16px 36px 36px;box-sizing:border-box}
.shop-breadcrumb{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-bottom:12px;color:#667085;font-size:12px}
.shop-breadcrumb a{color:#155eef;text-decoration:none}
.shop-heading{margin-bottom:24px}
.shop-heading h1{margin:0 0 7px;color:#172033;font-size:clamp(25px,3vw,32px);font-weight:700;line-height:1.3}
.shop-heading p{margin:0;color:#667085;font-size:13px;line-height:1.6}
.shop-layout{display:grid;grid-template-columns:230px minmax(0,1fr);gap:20px;align-items:start}
.shop-sidebar{padding:16px;background:#fff;border:1px solid #e6eaf0;border-radius:10px;box-sizing:border-box}
.filter-heading{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:12px}
.filter-heading h2{margin:0;color:#172033;font-size:16px}
.filter-reset{color:#155eef;font-size:11px;text-decoration:none}
.filter-section{padding-top:12px;border-top:1px solid #e6eaf0}
.filter-section h3{margin:0 0 10px;color:#172033;font-size:13px}
.filter-price-values{display:flex;justify-content:space-between;gap:8px;margin-bottom:12px}
.filter-price-value{min-width:0;color:#172033;font-size:11px;font-weight:700;overflow-wrap:anywhere}
.filter-price-value small{display:block;margin-bottom:4px;color:#667085;font-size:10px;font-weight:400}
.filter-slider{position:relative;height:6px;margin:0 9px 16px;background:#dbe4f5;border-radius:99px}
.filter-slider-track{position:absolute;height:6px;background:#155eef;border-radius:99px}
.filter-slider input[type=range]{position:absolute;top:-7px;left:0;width:100%;height:20px;margin:0;background:none;pointer-events:none;appearance:none;-webkit-appearance:none}
.filter-slider input[type=range]::-webkit-slider-thumb{width:19px;height:19px;border:3px solid #fff;border-radius:50%;background:#155eef;box-shadow:0 0 0 1px #155eef;pointer-events:auto;appearance:none;-webkit-appearance:none;cursor:grab}
.filter-slider input[type=range]::-moz-range-thumb{width:14px;height:14px;border:3px solid #fff;border-radius:50%;background:#155eef;box-shadow:0 0 0 1px #155eef;pointer-events:auto;cursor:grab}
.filter-price-inputs{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px}
.filter-price-inputs label{display:grid;gap:5px;color:#667085;font-size:10px}
.filter-price-inputs input{width:100%;min-width:0;padding:8px 6px;border:1px solid #d0d5dd;border-radius:7px;font-size:11px;box-sizing:border-box}
.filter-price-inputs input:focus{outline:none;border-color:#155eef;box-shadow:0 0 0 3px rgba(21,94,239,.1)}
.filter-ranges{display:grid;gap:8px;margin:12px 0 4px}
.filter-range{display:flex;align-items:center;gap:7px;color:#475467;font-size:11px;cursor:pointer}
.filter-range input{accent-color:#155eef}
.filter-apply{width:100%;margin-top:14px;padding:10px;border:0;border-radius:7px;background:#155eef;color:#fff;font-size:12px;font-weight:600;cursor:pointer}
.filter-apply:hover{background:#1048c7}
.filter-section + .filter-section{margin-top:14px}
.filter-brand-list{display:grid;gap:8px;max-height:200px;overflow-y:auto;padding-right:4px}
.filter-brand-option{display:flex;align-items:center;gap:8px;color:#475467;font-size:12px;cursor:pointer}
.filter-brand-option:hover{color:#155eef}
.filter-brand-option input{width:15px;height:15px;accent-color:#155eef;cursor:pointer}
.filter-brand-empty{margin:0;color:#98a2b3;font-size:11px}
.shop-main{min-width:0}
.shop-toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:10px}
.shop-count{margin:0;color:#667085;font-size:12px}
/* (CSS card produk ada di layouts/customer.blade.php, class .pcard-*) */
.produk-empty{grid-column:1/-1;padding:35px 16px;border:1px dashed #d0d5dd;border-radius:10px;background:#fff;text-align:center}
.produk-empty i{margin-bottom:10px;color:#98a2b3;font-size:32px}
.produk-empty h2{margin:0 0 7px;color:#172033;font-size:18px;font-weight:700}
.produk-empty p{margin:0;color:#667085;font-size:12px}
.shop-pagination{display:flex;justify-content:center;margin-top:25px}
.shop-pagination nav{max-width:100%}
@media(max-width:1000px){.shop-container{padding-right:24px;padding-left:24px}.shop-layout{grid-template-columns:205px minmax(0,1fr);gap:14px}}
@media(max-width:768px){.shop-container{padding:14px 18px 30px}.shop-layout{grid-template-columns:1fr}.shop-sidebar{padding:14px}}
@media(max-width:540px){.shop-container{padding:12px 12px 26px}.shop-layout{gap:15px}}
</style>
@endpush

@section('content')
<div class="shop-container">
    <nav class="shop-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a><span>/</span>
        <span aria-current="page">Semua Produk</span>
    </nav>

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

                // Daftar brand untuk filter (pakai $brands dari controller kalau ada)
                $brandList = isset($brands)
                    ? collect($brands)
                    : (class_exists(\App\Models\Brand::class)
                        ? \App\Models\Brand::orderBy('nama_brand')->get()
                        : collect());
                $selectedBrands = array_map('intval', (array) request('brand', []));
                $ranges = [
                    'under500' => ['label' => 'Di bawah Rp500.000', 'min' => 0, 'max' => 499999],
                    '500to1m' => ['label' => 'Rp500.000 – Rp1.000.000', 'min' => 500000, 'max' => 1000000],
                    '1to3m' => ['label' => 'Rp1.000.001 – Rp3.000.000', 'min' => 1000001, 'max' => 3000000],
                    'above3m' => ['label' => 'Di atas Rp3.000.000', 'min' => 3000001, 'max' => 50000000],
                ];
            @endphp

            <form action="{{ route('shop.index') }}" method="GET" id="productPriceFilter">
                @if (request()->filled('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif

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
                </div>

                <div class="filter-section">
                    <h3>Brand</h3>

                    @if ($brandList->isNotEmpty())
                        <div class="filter-brand-list">
                            @foreach ($brandList as $brandItem)
                                <label class="filter-brand-option">
                                    <input type="checkbox" name="brand[]" value="{{ $brandItem->id_brand }}"
                                        {{ in_array((int) $brandItem->id_brand, $selectedBrands, true) ? 'checked' : '' }}>
                                    <span>{{ $brandItem->nama_brand }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="filter-brand-empty">Brand belum tersedia.</p>
                    @endif
                </div>

                <button type="submit" class="filter-apply">Terapkan Filter</button>
            </form>
        </aside>

        <main class="shop-main">
            <div class="shop-toolbar"><p class="shop-count">{{ $produk->total() }} produk tersedia</p></div>

            <div class="pcard-grid">
                @forelse ($produk as $item)
                    @include('partials.product-card', ['produk' => $item])
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