@extends('layouts.customer')

@section('title', $produk->nama_produk . ' | ELECTROMART')

@push('styles')
<style>
.dt-page{max-width:1400px;margin:0 auto;padding:18px 28px 48px;color:#172033}
.dt-page *{box-sizing:border-box}

/* BREADCRUMB */
.dt-breadcrumb{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-bottom:16px;color:#667085;font-size:12px}
.dt-breadcrumb a{color:#155eef;text-decoration:none}
.dt-breadcrumb a:hover{text-decoration:underline}
.dt-breadcrumb i{font-size:8px;color:#98a2b3}
.dt-breadcrumb .dt-current{max-width:320px;overflow:hidden;color:#344054;text-overflow:ellipsis;white-space:nowrap}

/* LAYOUT 3 KOLOM */
.dt-layout{display:grid;grid-template-columns:minmax(0,440px) minmax(0,1fr) 330px;grid-template-areas:"gallery info buy";gap:28px;align-items:start}
.dt-gallery{grid-area:gallery;position:sticky;top:184px;min-width:0}
.dt-info{grid-area:info;min-width:0}
.dt-buy{grid-area:buy;position:sticky;top:184px;min-width:0}

/* GALERI */
.dt-main-image{position:relative;display:flex;align-items:center;justify-content:center;width:100%;aspect-ratio:1/1;padding:30px;overflow:hidden;border:1px solid #e6eaf0;border-radius:20px;background:radial-gradient(circle at 50% 40%,#fff 0,#f2f6fd 100%)}
.dt-main-image img{display:block;width:100%;height:100%;object-fit:contain;transition:transform .35s ease}
.dt-main-image:hover img{transform:scale(1.05)}
.dt-no-image{color:#98a2b3;font-size:13px;text-align:center}
.dt-chip-brand{position:absolute;top:14px;left:14px;padding:6px 12px;border-radius:999px;background:#155eef;color:#fff;font-size:11px;font-weight:700;letter-spacing:.3px}
.dt-thumbs{display:flex;flex-wrap:wrap;gap:10px;margin-top:12px}
.dt-thumb{width:72px;height:72px;padding:6px;overflow:hidden;border:1px solid #e0e5ed;border-radius:12px;background:#fff;cursor:pointer;transition:border-color .2s,box-shadow .2s}
.dt-thumb img{display:block;width:100%;height:100%;object-fit:contain}
.dt-thumb:hover,.dt-thumb.active{border-color:#155eef;box-shadow:0 0 0 3px rgba(21,94,239,.12)}

/* INFO PRODUK */
.dt-category{margin-bottom:8px;color:#155eef;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
.dt-title{margin:0 0 12px;color:#172033;font-size:clamp(23px,2.2vw,30px);font-weight:800;line-height:1.3;letter-spacing:-.5px;overflow-wrap:anywhere}
.dt-meta{display:flex;flex-wrap:wrap;align-items:center;gap:10px 16px;margin-bottom:14px;color:#667085;font-size:13px}
.dt-rating{display:inline-flex;align-items:center;gap:7px}
.dt-rating .dt-stars{color:#f5a623;font-size:13px;letter-spacing:1px}
.dt-rating strong{color:#344054}
.dt-stock{display:inline-flex;align-items:center;gap:6px;padding:5px 11px;border:1px solid #abefc6;border-radius:999px;background:#ecfdf3;color:#067647;font-size:12px;font-weight:700}
.dt-stock.empty{border-color:#fecdca;background:#fef3f2;color:#b42318}
.dt-price-box{margin:0 0 18px;padding:16px 20px;border:1px solid #d9e5ff;border-radius:16px;background:linear-gradient(120deg,#eaf1ff,#f7faff)}
.dt-price-label{display:block;margin-bottom:3px;color:#667085;font-size:11px;font-weight:600}
.dt-price{color:#155eef;font-size:clamp(28px,3vw,36px);font-weight:850;line-height:1.2;letter-spacing:-.8px;overflow-wrap:anywhere}

/* VARIAN */
.dt-variants{margin:0 0 18px}
.dt-variants h2{margin:0 0 4px;color:#172033;font-size:15px;font-weight:800}
.dt-variant-help{margin:0 0 11px;color:#667085;font-size:12px}
.dt-variant-list{display:flex;flex-wrap:wrap;gap:10px}
.dt-variant{display:flex;align-items:center;gap:10px;min-height:50px;padding:9px 14px;border:1px solid #d8dee9;border-radius:12px;background:#fff;color:#344054;text-align:left;cursor:pointer;transition:all .2s}
.dt-variant:hover{border-color:#9db9f7}
.dt-variant.active{border-color:#155eef;background:#f4f7ff;box-shadow:0 0 0 3px rgba(21,94,239,.12)}
.dt-swatch{width:22px;height:22px;flex:0 0 22px;border:1px solid #d0d5dd;border-radius:50%;background:var(--swatch-color,#e5e7eb)}
.dt-variant-label{display:flex;flex-direction:column;gap:2px}
.dt-variant-label strong{font-size:13px;font-weight:700}
.dt-variant-label small{color:#667085;font-size:11px}

/* TAB */
.dt-tabs{border:1px solid #e6eaf0;border-radius:16px;background:#fff;overflow:hidden}
.dt-tab-nav{display:flex;gap:4px;padding:0 16px;overflow-x:auto;border-bottom:1px solid #e6eaf0;background:#fbfcfe;scrollbar-width:none}
.dt-tab-nav::-webkit-scrollbar{display:none}
.dt-tab-btn{flex:0 0 auto;padding:15px 14px 13px;border:0;border-bottom:3px solid transparent;background:none;color:#667085;font-size:13px;font-weight:700;cursor:pointer;transition:color .2s,border-color .2s}
.dt-tab-btn:hover{color:#155eef}
.dt-tab-btn.active{border-bottom-color:#155eef;color:#155eef}
.dt-tab-panel{display:none;padding:20px}
.dt-tab-panel.active{display:block}
.dt-text{margin:0;color:#475467;font-size:14px;line-height:1.85;overflow-wrap:anywhere}

/* SPESIFIKASI */
.dt-spec{overflow:hidden;border:1px solid #edf0f4;border-radius:12px}
.dt-spec-row{display:grid;grid-template-columns:200px minmax(0,1fr);gap:14px;padding:11px 16px;font-size:13px;line-height:1.6}
.dt-spec-row:nth-child(odd){background:#f8faff}
.dt-spec-row dt{margin:0;color:#667085;font-weight:600}
.dt-spec-row dd{margin:0;color:#172033;font-weight:500;overflow-wrap:anywhere}
.dt-spec-row.full{display:block;color:#172033;font-weight:700}

/* ULASAN */
.dt-review-summary{display:flex;align-items:center;gap:18px;margin-bottom:16px;padding:16px 18px;border-radius:14px;background:#f8faff}
.dt-review-score{color:#172033;font-size:38px;font-weight:850;line-height:1}
.dt-review-summary .dt-stars{display:block;margin-bottom:4px;color:#f5a623;font-size:14px;letter-spacing:2px}
.dt-review-summary span{color:#667085;font-size:12px}
.dt-review{display:grid;grid-template-columns:42px minmax(0,1fr);gap:12px;padding:16px 0;border-top:1px solid #edf0f4}
.dt-review:first-of-type{border-top:0}
.dt-avatar{display:grid;place-items:center;width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#155eef,#06b6d4);color:#fff;font-size:15px;font-weight:800}
.dt-review-head{display:flex;flex-wrap:wrap;align-items:center;gap:6px 12px;margin-bottom:4px}
.dt-review-head strong{color:#172033;font-size:13px}
.dt-review-head .dt-stars{color:#f5a623;font-size:12px;letter-spacing:1px}
.dt-review-head time{color:#98a2b3;font-size:11px}
.dt-review p{margin:0;color:#475467;font-size:13px;line-height:1.75;overflow-wrap:anywhere}
.dt-empty{padding:20px;border-radius:12px;background:#f7f9fc;color:#667085;font-size:13px;text-align:center}

/* KARTU BELI */
.dt-buy-card{padding:20px;border:1px solid #dfe6f3;border-radius:18px;background:#fff;box-shadow:0 10px 30px rgba(23,32,51,.07)}
.dt-buy-title{margin:0 0 14px;color:#172033;font-size:15px;font-weight:800}
.dt-qty-row{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:14px}
.dt-qty-row label{color:#344054;font-size:13px;font-weight:600}
.dt-qty{display:flex;align-items:center;overflow:hidden;border:1px solid #d0d5dd;border-radius:10px}
.dt-qty button{display:grid;place-items:center;width:36px;height:38px;border:0;background:#f5f7fb;color:#344054;font-size:16px;cursor:pointer}
.dt-qty button:hover{background:#e8eefc;color:#155eef}
.dt-qty input{width:52px;height:38px;border:0;border-right:1px solid #e4e7ec;border-left:1px solid #e4e7ec;outline:none;color:#172033;font-size:14px;font-weight:700;text-align:center;-moz-appearance:textfield}
.dt-qty input::-webkit-outer-spin-button,.dt-qty input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
.dt-subtotal{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:16px;padding:12px 0;border-top:1px dashed #d0d5dd;border-bottom:1px dashed #d0d5dd}
.dt-subtotal span{color:#667085;font-size:12px}
.dt-subtotal strong{color:#155eef;font-size:18px;font-weight:850;overflow-wrap:anywhere;text-align:right}
.dt-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;min-height:48px;padding:0 18px;border-radius:12px;font-size:14px;font-weight:800;text-decoration:none;cursor:pointer;transition:background .2s,color .2s,transform .2s,box-shadow .2s}
.dt-btn + .dt-btn{margin-top:10px}
.dt-btn-outline{border:2px solid #155eef;background:#fff;color:#155eef}
.dt-btn-outline:hover{background:#f0f5ff}
.dt-btn-solid{border:2px solid #155eef;background:#155eef;color:#fff}
.dt-btn-solid:hover{border-color:#104bc5;background:#104bc5;box-shadow:0 8px 20px rgba(21,94,239,.28);transform:translateY(-1px)}
.dt-btn:disabled{border-color:#d0d5dd;background:#e4e7ec;color:#98a2b3;box-shadow:none;transform:none;cursor:not-allowed}
.dt-share{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;margin-top:14px;padding:10px;border:0;border-radius:10px;background:none;color:#475467;font-size:13px;font-weight:600;cursor:pointer}
.dt-share:hover{background:#f5f7fb;color:#155eef}
.dt-perks{display:grid;gap:12px;margin:16px 0 0;padding:16px 0 0;border-top:1px solid #edf0f4;list-style:none}
.dt-perks li{display:flex;align-items:center;gap:11px;color:#475467;font-size:12px;line-height:1.5}
.dt-perks i{display:grid;place-items:center;width:32px;height:32px;flex:0 0 32px;border-radius:10px;background:#eef4ff;color:#155eef;font-size:13px}

/* RESPONSIVE */
@media(max-width:1180px){
    .dt-layout{grid-template-columns:minmax(0,400px) minmax(0,1fr);grid-template-areas:"gallery info" "gallery buy";gap:22px}
    .dt-buy{position:static}
}
@media(max-width:820px){
    .dt-page{padding:14px 16px 36px}
    .dt-layout{grid-template-columns:minmax(0,1fr);grid-template-areas:"gallery" "info" "buy";gap:18px}
    .dt-gallery{position:static}
    .dt-main-image{aspect-ratio:4/3;padding:22px}
    .dt-spec-row{grid-template-columns:130px minmax(0,1fr)}
}
@media(max-width:480px){
    .dt-page{padding:12px 12px 30px}
    .dt-main-image{aspect-ratio:1/1;padding:18px;border-radius:16px}
    .dt-thumb{width:62px;height:62px}
    .dt-tab-panel{padding:16px 14px}
    .dt-spec-row{display:block;padding:10px 14px}
    .dt-spec-row dt{margin-bottom:2px;font-size:11px}
    .dt-breadcrumb .dt-current{max-width:160px}
}
</style>
@endpush

@section('content')
@php
    $daftarGambar = collect();

    if ($produk->gambar) {
        $daftarGambar->push($produk->gambar);
    }

    if ($produk->relationLoaded('fotoProduk')) {
        foreach ($produk->fotoProduk as $foto) {
            if ($foto->gambar && !$daftarGambar->contains($foto->gambar)) {
                $daftarGambar->push($foto->gambar);
            }
        }
    }

    $daftarGambar = $daftarGambar->take(4)->values();

    $varianAktif = $produk->varianProduk
        ->where('status_varian', true)
        ->values();

    $memilikiVarian = $varianAktif->isNotEmpty();
    $stokProduk = (int) ($produk->stok->jumlah_stok ?? 0);

    $urlGambarProduk = function ($gambar) {
        if (!$gambar) return null;

        return preg_match('/^https?:\/\//i', $gambar)
            ? $gambar
            : asset('storage/' . ltrim($gambar, '/'));
    };

    $gambarUtama = $daftarGambar->isNotEmpty()
        ? $urlGambarProduk($daftarGambar->first())
        : null;

    $stokAwal = $memilikiVarian
        ? (int) ($varianAktif->first()->jumlah_stok ?? 0)
        : $stokProduk;

    $hargaAwal = $memilikiVarian && $varianAktif->first()->harga !== null
        ? (float) $varianAktif->first()->harga
        : (float) $produk->harga_jual;

    $daftarUlasan = ($produk->ulasanProduk ?? collect())->sortByDesc('created_at')->values();
    $jumlahUlasan = $daftarUlasan->count();
    $rataRating = $jumlahUlasan > 0 ? $daftarUlasan->avg('rating') : 0;

    $namaBrand = $produk->brand->nama_brand ?? null;
    $namaKategori = $produk->kategori->nama_kategori ?? null;
    $slugKategori = $namaKategori ? \Illuminate\Support\Str::slug($namaKategori) : null;

    // Spesifikasi: baris "Judul: isi" jadi tabel, baris lain jadi sub-judul
    $barisSpesifikasi = collect(preg_split('/\r\n|\r|\n/', (string) $produk->spesifikasi))
        ->map(fn ($baris) => trim($baris))
        ->filter()
        ->values();
@endphp

<div class="dt-page">

    {{-- BREADCRUMB --}}
    <nav class="dt-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        @if ($slugKategori)
            <a href="{{ route('shop.category', ['category' => $slugKategori]) }}">{{ $namaKategori }}</a>
        @else
            <a href="{{ route('shop.index') }}">Semua Produk</a>
        @endif
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        <span class="dt-current">{{ $produk->nama_produk }}</span>
    </nav>

    <div class="dt-layout">

        {{-- KOLOM 1: GALERI --}}
        <div class="dt-gallery">
            <div class="dt-main-image">
                @if ($namaBrand)
                    <span class="dt-chip-brand">{{ $namaBrand }}</span>
                @endif

                @if ($gambarUtama)
                    <img id="detail-image-preview" src="{{ $gambarUtama }}" alt="{{ $produk->nama_produk }}">
                    <div class="dt-no-image" id="detail-image-error" style="display:none">Gambar tidak tersedia</div>
                @else
                    <div class="dt-no-image" id="detail-image-error">Gambar produk belum tersedia</div>
                    <img id="detail-image-preview" src="" alt="{{ $produk->nama_produk }}" style="display:none">
                @endif
            </div>

            @if ($daftarGambar->count() > 1)
                <div class="dt-thumbs">
                    @foreach ($daftarGambar as $index => $gambar)
                        <button type="button"
                            class="dt-thumb {{ $index === 0 ? 'active' : '' }}"
                            onclick="pilihGambarProduk(this)"
                            data-image="{{ $urlGambarProduk($gambar) }}"
                            aria-label="Lihat foto {{ $index + 1 }}">
                            <img src="{{ $urlGambarProduk($gambar) }}" alt="Foto {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- KOLOM 2: INFORMASI --}}
        <div class="dt-info">
            @if ($namaKategori)
                <div class="dt-category">{{ $namaKategori }}</div>
            @endif

            <h1 class="dt-title">{{ $produk->nama_produk }}</h1>

            <div class="dt-meta">
                <div class="dt-rating">
                    @if ($jumlahUlasan > 0)
                        <span class="dt-stars">
                            @for ($star = 1; $star <= 5; $star++)
                                <i class="{{ $star <= round($rataRating) ? 'fa-solid' : 'fa-regular' }} fa-star" aria-hidden="true"></i>
                            @endfor
                        </span>
                        <strong>{{ number_format($rataRating, 1, ',', '.') }}</strong>
                        <span>({{ $jumlahUlasan }} ulasan)</span>
                    @else
                        <span>Belum ada ulasan</span>
                    @endif
                </div>

                <span id="detail-stock" class="dt-stock {{ $stokAwal > 0 ? '' : 'empty' }}">
                    <i class="fa-solid {{ $stokAwal > 0 ? 'fa-circle-check' : 'fa-circle-xmark' }}" aria-hidden="true"></i>
                    <span id="detail-stock-text">{{ $stokAwal > 0 ? 'Stok tersedia: ' . $stokAwal : 'Stok habis' }}</span>
                </span>
            </div>

            <div class="dt-price-box">
                <span class="dt-price-label">Harga</span>
                <div class="dt-price" id="detail-price">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</div>
            </div>

            @if ($memilikiVarian)
                <div class="dt-variants">
                    <h2>Pilih varian</h2>
                    <p class="dt-variant-help">Pilih warna atau tipe yang ingin dibeli.</p>

                    <div class="dt-variant-list" id="variant-list">
                        @foreach ($varianAktif as $index => $varian)
                            @php
                                $labelVarian = collect([$varian->warna, $varian->kapasitas])
                                    ->filter()->implode(' · ');

                                if (!$labelVarian) {
                                    $labelVarian = $varian->nama_varian;
                                }

                                $warnaSwatch = [
                                    'icy blue'=>'#cbdcf4','blue'=>'#8db7ee',
                                    'navy'=>'#30323b','black'=>'#252525',
                                    'phantom black'=>'#252525','mint'=>'#c8e0cf',
                                    'green'=>'#9ac5a6','silver'=>'#e5e7eb',
                                    'silver shadow'=>'#d8d8d8','white'=>'#ffffff',
                                    'cream'=>'#f0eee7','gray'=>'#9ca3af',
                                    'grey'=>'#9ca3af','pink'=>'#f2b8c6',
                                    'purple'=>'#c4b5fd','red'=>'#ef4444',
                                ];

                                $swatchKey = strtolower(trim($varian->warna ?? ''));
                                $swatchColor = $warnaSwatch[$swatchKey] ?? '#e5e7eb';

                                $hargaVarian = $varian->harga !== null
                                    ? (float) $varian->harga
                                    : (float) $produk->harga_jual;

                                $gambarVarian = $urlGambarProduk($varian->gambar);
                            @endphp

                            <button type="button"
                                class="dt-variant {{ $index === 0 ? 'active' : '' }}"
                                data-id="{{ $varian->id_varian }}"
                                data-price="{{ $hargaVarian }}"
                                data-stock="{{ (int) $varian->jumlah_stok }}"
                                data-image="{{ $gambarVarian ?? '' }}"
                                aria-pressed="{{ $index === 0 ? 'true' : 'false' }}">
                                @if ($varian->warna)
                                    <span class="dt-swatch" style="--swatch-color: {{ $swatchColor }}"></span>
                                @endif

                                <span class="dt-variant-label">
                                    <strong>{{ $labelVarian }}</strong>
                                    <small>{{ (int) $varian->jumlah_stok > 0 ? 'Stok: ' . (int) $varian->jumlah_stok : 'Stok habis' }}</small>
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- TAB: DESKRIPSI, SPESIFIKASI, ULASAN --}}
            <div class="dt-tabs">
                <div class="dt-tab-nav" role="tablist">
                    <button type="button" class="dt-tab-btn active" data-tab="tab-deskripsi" role="tab">Deskripsi</button>
                    <button type="button" class="dt-tab-btn" data-tab="tab-spesifikasi" role="tab">Spesifikasi</button>
                    <button type="button" class="dt-tab-btn" data-tab="tab-ulasan" role="tab">Ulasan ({{ $jumlahUlasan }})</button>
                </div>

                <div class="dt-tab-panel active" id="tab-deskripsi" role="tabpanel">
                    <p class="dt-text">
                        @if ($produk->deskripsi)
                            {!! nl2br(e($produk->deskripsi)) !!}
                        @else
                            Belum ada deskripsi untuk produk ini.
                        @endif
                    </p>
                </div>

                <div class="dt-tab-panel" id="tab-spesifikasi" role="tabpanel">
                    @if ($barisSpesifikasi->isNotEmpty())
                        <dl class="dt-spec">
                            @foreach ($barisSpesifikasi as $baris)
                                @if (str_contains($baris, ':'))
                                    @php [$kunci, $nilai] = array_map('trim', explode(':', $baris, 2)); @endphp
                                    <div class="dt-spec-row">
                                        <dt>{{ $kunci }}</dt>
                                        <dd>{{ $nilai }}</dd>
                                    </div>
                                @else
                                    <div class="dt-spec-row full">{{ $baris }}</div>
                                @endif
                            @endforeach
                        </dl>
                    @else
                        <p class="dt-text">Spesifikasi produk belum tersedia.</p>
                    @endif
                </div>

                <div class="dt-tab-panel" id="tab-ulasan" role="tabpanel">
                    @if ($jumlahUlasan > 0)
                        <div class="dt-review-summary">
                            <div class="dt-review-score">{{ number_format($rataRating, 1, ',', '.') }}</div>
                            <div>
                                <span class="dt-stars">
                                    @for ($star = 1; $star <= 5; $star++)
                                        <i class="{{ $star <= round($rataRating) ? 'fa-solid' : 'fa-regular' }} fa-star" aria-hidden="true"></i>
                                    @endfor
                                </span>
                                <span>dari {{ $jumlahUlasan }} ulasan pembeli</span>
                            </div>
                        </div>

                        @foreach ($daftarUlasan as $ulasan)
                            @php
                                $namaPembeli = $ulasan->user->nama
                                    ?? $ulasan->user->name
                                    ?? 'Pembeli ELECTROMART';
                                $ratingUlasan = max(0, min(5, (int) $ulasan->rating));
                            @endphp

                            <article class="dt-review">
                                <span class="dt-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($namaPembeli, 0, 1)) }}</span>
                                <div>
                                    <div class="dt-review-head">
                                        <strong>{{ $namaPembeli }}</strong>
                                        <span class="dt-stars" aria-label="Rating {{ $ratingUlasan }} dari 5">
                                            @for ($star = 1; $star <= 5; $star++)
                                                <i class="{{ $star <= $ratingUlasan ? 'fa-solid' : 'fa-regular' }} fa-star" aria-hidden="true"></i>
                                            @endfor
                                        </span>
                                        @if ($ulasan->created_at)
                                            <time>{{ $ulasan->created_at->format('d M Y') }}</time>
                                        @endif
                                    </div>

                                    @if (filled($ulasan->komentar))
                                        <p>{{ $ulasan->komentar }}</p>
                                    @else
                                        <p style="color:#98a2b3">Pembeli memberikan rating tanpa komentar.</p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    @else
                        <div class="dt-empty">
                            Belum ada ulasan untuk produk ini. Jadilah pembeli pertama yang memberikan ulasan setelah pesanan selesai.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM 3: KARTU PEMBELIAN --}}
        <aside class="dt-buy">
            <div class="dt-buy-card">
                <h2 class="dt-buy-title">Atur pesanan</h2>

                @if ($memilikiVarian || $stokProduk > 0)
                    <form action="{{ route('keranjang.tambah', ['id_produk' => $produk->id_produk]) }}"
                        method="POST" id="form-tambah-keranjang">
                        @csrf

                        @if ($memilikiVarian)
                            <input type="hidden" name="id_varian" id="id-varian"
                                value="{{ $varianAktif->first()->id_varian }}">
                        @endif

                        <div class="dt-qty-row">
                            <label for="jumlah">Jumlah</label>
                            <div class="dt-qty">
                                <button type="button" id="qty-minus" aria-label="Kurangi jumlah">&minus;</button>
                                <input type="number" id="jumlah" name="jumlah" value="1"
                                    min="1" max="{{ max(1, $stokAwal) }}" required>
                                <button type="button" id="qty-plus" aria-label="Tambah jumlah">+</button>
                            </div>
                        </div>

                        <div class="dt-subtotal">
                            <span>Subtotal</span>
                            <strong id="detail-subtotal">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</strong>
                        </div>

                        <button type="submit" class="dt-btn dt-btn-outline"
                            id="tombol-tambah-keranjang" {{ $stokAwal < 1 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-cart-plus" aria-hidden="true"></i>
                            <span>{{ $stokAwal > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}</span>
                        </button>

                        <button type="submit" name="beli_langsung" value="1" class="dt-btn dt-btn-solid"
                            id="tombol-beli-langsung" {{ $stokAwal < 1 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                            <span>Beli Sekarang</span>
                        </button>
                    </form>
                @else
                    <button type="button" class="dt-btn dt-btn-solid" disabled>Stok Habis</button>
                @endif

                <button type="button" class="dt-share" id="tombol-bagikan">
                    <i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
                    <span>Bagikan produk</span>
                </button>

                <ul class="dt-perks">
                    <li><i class="fa-solid fa-box-open" aria-hidden="true"></i>5 hari rusak, ganti baru</li>
                    <li><i class="fa-solid fa-shield-halved" aria-hidden="true"></i>Proteksi produk elektronik</li>
                    <li><i class="fa-solid fa-stopwatch" aria-hidden="true"></i>Pengiriman cepat</li>
                </ul>
            </div>
        </aside>

    </div>
</div>

<script>
function pilihGambarProduk(tombol) {
    const gambarUtama = document.getElementById('detail-image-preview');
    const gambarError = document.getElementById('detail-image-error');

    if (!gambarUtama) return;

    gambarUtama.src = tombol.dataset.image;
    gambarUtama.style.display = 'block';

    if (gambarError) gambarError.style.display = 'none';

    document.querySelectorAll('.dt-thumb').forEach(function (item) {
        item.classList.remove('active');
    });

    tombol.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function () {
    const gambarUtama = document.getElementById('detail-image-preview');
    const gambarError = document.getElementById('detail-image-error');
    const pilihanVarian = document.querySelectorAll('.dt-variant');
    const inputVarian = document.getElementById('id-varian');
    const hargaElement = document.getElementById('detail-price');
    const subtotalElement = document.getElementById('detail-subtotal');
    const stokElement = document.getElementById('detail-stock');
    const stokTeks = document.getElementById('detail-stock-text');
    const inputJumlah = document.getElementById('jumlah');
    const tombolTambah = document.getElementById('tombol-tambah-keranjang');
    const tombolBeli = document.getElementById('tombol-beli-langsung');
    const tombolMin = document.getElementById('qty-minus');
    const tombolPlus = document.getElementById('qty-plus');

    let hargaAktif = {{ (float) $hargaAwal }};

    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(Number(angka || 0));
    }

    function ubahJumlah(nilai) {
        if (!inputJumlah) return;

        const maksimum = Number(inputJumlah.max || 1);
        let jumlah = Number(nilai || 1);

        if (jumlah < 1) jumlah = 1;
        if (jumlah > maksimum) jumlah = maksimum;

        inputJumlah.value = jumlah;

        if (subtotalElement) {
            subtotalElement.textContent = formatRupiah(hargaAktif * jumlah);
        }
    }

    // Gambar utama
    if (gambarUtama && gambarError) {
        gambarUtama.addEventListener('error', function () {
            gambarUtama.style.display = 'none';
            gambarError.style.display = 'block';
        });

        gambarUtama.addEventListener('load', function () {
            gambarUtama.style.display = 'block';
            gambarError.style.display = 'none';
        });
    }

    // Pilih varian
    function pilihVarian(tombol) {
        pilihanVarian.forEach(function (item) {
            item.classList.remove('active');
            item.setAttribute('aria-pressed', 'false');
        });

        tombol.classList.add('active');
        tombol.setAttribute('aria-pressed', 'true');

        hargaAktif = Number(tombol.dataset.price || 0);

        if (inputVarian) inputVarian.value = tombol.dataset.id;
        if (hargaElement) hargaElement.textContent = formatRupiah(hargaAktif);

        const stok = Number(tombol.dataset.stock || 0);

        if (stokElement && stokTeks) {
            stokTeks.textContent = stok > 0 ? 'Stok tersedia: ' + stok : 'Stok habis';
            stokElement.classList.toggle('empty', stok < 1);

            const ikon = stokElement.querySelector('i');
            if (ikon) {
                ikon.className = 'fa-solid ' + (stok > 0 ? 'fa-circle-check' : 'fa-circle-xmark');
            }
        }

        if (inputJumlah) {
            inputJumlah.max = Math.max(1, stok);
            ubahJumlah(1);
        }

        if (tombolTambah) {
            tombolTambah.disabled = stok < 1;
            const teks = tombolTambah.querySelector('span');
            if (teks) teks.textContent = stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis';
        }

        if (tombolBeli) tombolBeli.disabled = stok < 1;

        const gambarVarian = tombol.dataset.image;

        if (gambarVarian && gambarUtama) {
            gambarUtama.src = gambarVarian;
            gambarUtama.style.display = 'block';

            if (gambarError) gambarError.style.display = 'none';

            document.querySelectorAll('.dt-thumb').forEach(function (item) {
                item.classList.remove('active');
            });
        }
    }

    pilihanVarian.forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            pilihVarian(tombol);
        });
    });

    // Jumlah
    if (inputJumlah) {
        inputJumlah.addEventListener('change', function () {
            ubahJumlah(inputJumlah.value);
        });

        inputJumlah.addEventListener('input', function () {
            ubahJumlah(inputJumlah.value);
        });
    }

    if (tombolMin) {
        tombolMin.addEventListener('click', function () {
            ubahJumlah(Number(inputJumlah.value || 1) - 1);
        });
    }

    if (tombolPlus) {
        tombolPlus.addEventListener('click', function () {
            ubahJumlah(Number(inputJumlah.value || 1) + 1);
        });
    }

    // Tab
    const tombolTab = document.querySelectorAll('.dt-tab-btn');
    const panelTab = document.querySelectorAll('.dt-tab-panel');

    tombolTab.forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            tombolTab.forEach(function (item) { item.classList.remove('active'); });
            panelTab.forEach(function (panel) { panel.classList.remove('active'); });

            tombol.classList.add('active');

            const panel = document.getElementById(tombol.dataset.tab);
            if (panel) panel.classList.add('active');
        });
    });

    // Bagikan
    const tombolBagikan = document.getElementById('tombol-bagikan');

    if (tombolBagikan) {
        tombolBagikan.addEventListener('click', function () {
            const data = { title: document.title, url: window.location.href };
            const teks = tombolBagikan.querySelector('span');

            if (navigator.share) {
                navigator.share(data).catch(function () {});
                return;
            }

            if (navigator.clipboard) {
                navigator.clipboard.writeText(data.url).then(function () {
                    if (teks) {
                        teks.textContent = 'Link disalin';
                        setTimeout(function () { teks.textContent = 'Bagikan produk'; }, 2000);
                    }
                });
            }
        });
    }

    ubahJumlah(1);
});
</script>
@endsection