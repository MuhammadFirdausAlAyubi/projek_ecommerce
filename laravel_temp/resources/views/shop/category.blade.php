@extends('layouts.customer')

@section('title', $category . ' | ELECTROMART')

@push('styles')
<style>
.category-page{width:100%;max-width:1400px;margin:0 auto;padding:16px 36px 36px;box-sizing:border-box}
.category-breadcrumb{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-bottom:12px;color:#667085;font-size:12px}
.category-breadcrumb a{color:#155eef;text-decoration:none}
.category-heading{margin-bottom:22px}
.category-heading h1{margin:0 0 7px;color:#172033;font-size:clamp(25px,3vw,32px);font-weight:700;line-height:1.3}
.category-heading p{margin:0;color:#667085;font-size:13px;line-height:1.6}
.category-layout{display:grid;grid-template-columns:230px minmax(0,1fr);gap:20px;align-items:start}
.category-sidebar{padding:16px;background:#fff;border:1px solid #e6eaf0;border-radius:10px;box-sizing:border-box}
.category-filter-heading{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:12px}
.category-filter-heading h2{margin:0;color:#172033;font-size:16px}
.category-filter-heading a{color:#155eef;font-size:11px;text-decoration:none}
.category-filter-section{padding-top:12px;border-top:1px solid #e6eaf0}
.category-filter-section h3{margin:0 0 10px;color:#172033;font-size:13px}
.category-price-values{display:flex;justify-content:space-between;gap:8px;margin-bottom:12px}
.category-price-value{min-width:0;color:#172033;font-size:11px;font-weight:700;overflow-wrap:anywhere}
.category-price-value small{display:block;margin-bottom:4px;color:#667085;font-size:10px;font-weight:400}
.category-slider{position:relative;height:6px;margin:0 9px 16px;background:#dbe4f5;border-radius:99px}
.category-slider-track{position:absolute;height:6px;background:#155eef;border-radius:99px}
.category-slider input[type=range]{position:absolute;top:-7px;left:0;width:100%;height:20px;margin:0;background:none;pointer-events:none;appearance:none;-webkit-appearance:none}
.category-slider input[type=range]::-webkit-slider-thumb{width:19px;height:19px;border:3px solid #fff;border-radius:50%;background:#155eef;box-shadow:0 0 0 1px #155eef;pointer-events:auto;appearance:none;-webkit-appearance:none;cursor:grab}
.category-slider input[type=range]::-moz-range-thumb{width:14px;height:14px;border:3px solid #fff;border-radius:50%;background:#155eef;box-shadow:0 0 0 1px #155eef;pointer-events:auto;cursor:grab}
.category-price-inputs{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px}
.category-price-inputs label{display:grid;gap:5px;color:#667085;font-size:10px}
.category-price-inputs input{width:100%;min-width:0;padding:8px 6px;border:1px solid #d0d5dd;border-radius:7px;font-size:11px;box-sizing:border-box}
.category-price-ranges{display:grid;gap:8px;margin:12px 0 4px}
.category-price-range{display:flex;align-items:center;gap:7px;color:#475467;font-size:11px;cursor:pointer}
.category-price-range input{accent-color:#155eef}
.category-filter-apply{width:100%;margin-top:14px;padding:10px;border:0;border-radius:7px;background:#155eef;color:#fff;font-size:12px;font-weight:600;cursor:pointer}
.category-filter-apply:hover{background:#1048c7}
.category-filter-section + .category-filter-section{margin-top:14px}
.category-brand-list{display:grid;gap:8px;max-height:200px;overflow-y:auto;padding-right:4px}
.category-brand-option{display:flex;align-items:center;gap:8px;color:#475467;font-size:12px;cursor:pointer}
.category-brand-option:hover{color:#155eef}
.category-brand-option input{width:15px;height:15px;accent-color:#155eef;cursor:pointer}
.category-brand-empty{margin:0;color:#98a2b3;font-size:11px}
.category-results{min-width:0}
.category-toolbar{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:10px;color:#667085;font-size:12px}
/* (CSS card produk ada di layouts/customer.blade.php, class .pcard-*) */
.category-empty{grid-column:1/-1;padding:35px 16px;border:1px dashed #d0d5dd;border-radius:10px;background:#fff;color:#667085;text-align:center}
.category-empty h3{margin:0 0 8px;color:#172033;font-size:18px}
.category-empty p{margin:0;font-size:12px}
.category-empty a{display:inline-block;margin-top:13px;padding:9px 14px;border-radius:6px;background:#155eef;color:#fff;text-decoration:none;font-size:12px}
.category-empty a:hover{background:#1048c7}
.category-pagination{display:flex;justify-content:center;margin-top:25px}
.category-pagination nav{max-width:100%}
@media(max-width:1100px){.category-page{padding-right:24px;padding-left:24px}.category-layout{grid-template-columns:205px minmax(0,1fr);gap:14px}}
@media(max-width:768px){.category-page{padding:14px 18px 30px}.category-layout{grid-template-columns:1fr}.category-sidebar{padding:14px}}
@media(max-width:540px){.category-page{padding:12px 12px 26px}.category-layout{gap:15px}}
@media(max-width:380px){.category-page{padding-right:12px;padding-left:12px}}
</style>
@endpush

@section('content')
<div class="category-page">
    <nav class="category-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span>/</span>
        <span aria-current="page">{{ $category }}</span>
    </nav>

    @php
        $priceMin = max(0, min(50000000, (int) request('min_price', 0)));
        $priceMax = max(0, min(50000000, (int) request('max_price', 50000000)));
        if ($priceMin > $priceMax) {
            $priceMin = 0;
            $priceMax = 50000000;
        }
        $selectedRange = request('price_range', '');

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

    <div class="category-layout">
        <aside class="category-sidebar">
            <div class="category-filter-heading">
                <h2>Filter Produk</h2>
                <a href="{{ url()->current() }}">Reset</a>
            </div>

            <form action="{{ url()->current() }}" method="GET" id="categoryPriceFilter">
                <div class="category-filter-section">
                    <h3>Rentang Harga</h3>

                    <div class="category-price-values">
                        <div class="category-price-value"><small>Harga minimum</small><span id="categoryMinLabel">Rp{{ number_format($priceMin, 0, ',', '.') }}</span></div>
                        <div class="category-price-value" style="text-align:right"><small>Harga maksimum</small><span id="categoryMaxLabel">Rp{{ number_format($priceMax, 0, ',', '.') }}</span></div>
                    </div>

                    <div class="category-slider">
                        <div class="category-slider-track" id="categoryRangeTrack"></div>
                        <input type="range" id="categoryMinRange" min="0" max="50000000" step="100000" value="{{ $priceMin }}" aria-label="Harga minimum">
                        <input type="range" id="categoryMaxRange" min="0" max="50000000" step="100000" value="{{ $priceMax }}" aria-label="Harga maksimum">
                    </div>

                    <div class="category-price-inputs">
                        <label>Minimum (Rp)<input type="number" id="categoryMinInput" name="min_price" min="0" max="50000000" step="1000" value="{{ request('min_price', '') }}" placeholder="Minimum"></label>
                        <label>Maksimum (Rp)<input type="number" id="categoryMaxInput" name="max_price" min="0" max="50000000" step="1000" value="{{ request('max_price', '') }}" placeholder="Maksimum"></label>
                    </div>

                    <div class="category-price-ranges">
                        @foreach ($ranges as $value => $range)
                            <label class="category-price-range">
                                <input type="radio" name="price_range" value="{{ $value }}" data-min="{{ $range['min'] }}" data-max="{{ $range['max'] }}" {{ $selectedRange === $value ? 'checked' : '' }}>
                                <span>{{ $range['label'] }}</span>
                            </label>
                        @endforeach
                    </div>

                </div>

                <div class="category-filter-section">
                    <h3>Brand</h3>

                    @if ($brandList->isNotEmpty())
                        <div class="category-brand-list">
                            @foreach ($brandList as $brandItem)
                                <label class="category-brand-option">
                                    <input type="checkbox" name="brand[]" value="{{ $brandItem->id_brand }}"
                                        {{ in_array((int) $brandItem->id_brand, $selectedBrands, true) ? 'checked' : '' }}>
                                    <span>{{ $brandItem->nama_brand }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="category-brand-empty">Brand belum tersedia.</p>
                    @endif
                </div>

                <button type="submit" class="category-filter-apply">Terapkan Filter</button>
            </form>
        </aside>

        <main class="category-results">
            <div class="category-toolbar">
                <span>{{ $produks->total() }} produk ditemukan</span>
                <span>Halaman {{ $produks->currentPage() }} dari {{ max(1, $produks->lastPage()) }}</span>
            </div>

            <div class="pcard-grid">
                @forelse ($produks as $produk)
                    @include('partials.product-card', ['produk' => $produk])
                @empty
                    <div class="category-empty">
                        <h3>Belum ada produk {{ $category }}</h3>
                        <p>Produk kategori ini belum ditemukan atau tidak sesuai dengan filter harga.</p>
                        <a href="{{ route('shop.index') }}">Lihat Semua Produk</a>
                    </div>
                @endforelse
            </div>

            @if (method_exists($produks, 'links'))
                <div class="category-pagination">{{ $produks->appends(request()->query())->links() }}</div>
            @endif
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('categoryPriceFilter');
    if (!form) return;

    const minRange = document.getElementById('categoryMinRange');
    const maxRange = document.getElementById('categoryMaxRange');
    const minInput = document.getElementById('categoryMinInput');
    const maxInput = document.getElementById('categoryMaxInput');
    const minLabel = document.getElementById('categoryMinLabel');
    const maxLabel = document.getElementById('categoryMaxLabel');
    const track = document.getElementById('categoryRangeTrack');
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
        minRange.value = Math.max(0, Math.min(maxValue, Number(this.value || 0)));
        update('min', false);
    });

    maxInput.addEventListener('input', function () {
        maxRange.value = Math.max(0, Math.min(maxValue, Number(this.value || maxValue)));
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