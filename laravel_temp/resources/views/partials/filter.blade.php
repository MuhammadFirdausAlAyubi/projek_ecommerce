<form method="GET" action="{{ url()->current() }}" class="filter-card">
    <div class="filter-head">
        <span><i class="bi bi-sliders2"></i> Filter</span>
        <a href="{{ url()->current() }}" class="filter-reset">Reset</a>
    </div>

    {{-- RENTANG HARGA --}}
    <div class="filter-block">
        <h6>Rentang Harga</h6>

        <div class="price-inputs">
            <div>
                <label>Minimum</label>
                <div class="rp-wrap">
                    <span>Rp</span>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" min="0">
                </div>
            </div>
            <div>
                <label>Maksimum</label>
                <div class="rp-wrap">
                    <span>Rp</span>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="50000000" min="0">
                </div>
            </div>
        </div>

        <div class="price-chips">
            @foreach ($priceRanges as $key => $range)
                <a class="chip {{ $selectedRange === $key ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['price_range' => $key, 'min_price' => null, 'max_price' => null, 'page' => null]) }}">
                    {{ $range['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- BRAND (otomatis sesuai kategori yang dibuka) --}}
    <div class="filter-block">
        <h6>
            Brand
            <small>{{ $category ?? 'Semua Produk' }}</small>
        </h6>

        @forelse ($brandOptions as $b)
            <label class="brand-item">
                <input type="checkbox" name="brand[]" value="{{ $b->id_brand }}"
                       {{ in_array((string) $b->id_brand, array_map('strval', $selectedBrands)) ? 'checked' : '' }}>
                <span class="box"></span>
                <span class="name">{{ $b->nama_brand }}</span>
            </label>
        @empty
            <p class="text-muted small mb-0">Belum ada brand di kategori ini.</p>
        @endforelse
    </div>

    @if ($selectedRange)
        <input type="hidden" name="price_range" value="{{ $selectedRange }}">
    @endif

    <button type="submit" class="btn-apply">
        <i class="bi bi-funnel-fill"></i> Terapkan Filter
    </button>
</form>