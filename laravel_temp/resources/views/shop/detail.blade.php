@extends('layouts.customer')

@section('title', $produk->nama_produk . ' | ELECTROMART')

@push('styles')
<style>
.detail-page{max-width:1200px;margin:auto;padding:28px 20px 55px;color:#292929}
.detail-breadcrumb{font-size:13px;color:#777;margin-bottom:25px}
.detail-breadcrumb a{color:#555;text-decoration:none}
.detail-breadcrumb a:hover{color:#155eef}
.detail-layout{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:42px;align-items:start}
.detail-gallery,.detail-info{min-width:0}
.detail-main-image{height:430px;padding:24px;display:flex;align-items:center;justify-content:center;background:#f7f7f7;border:1px solid #eee;border-radius:12px;overflow:hidden}
.detail-main-image img{width:100%;height:100%;object-fit:contain}
.detail-no-image{color:#999;font-size:14px;text-align:center}
.detail-thumbnails{display:flex;flex-wrap:wrap;gap:12px;margin-top:14px}
.detail-thumbnail{width:76px;height:76px;padding:5px;border:1px solid #ddd;border-radius:8px;background:#fff;cursor:pointer;overflow:hidden}
.detail-thumbnail.active,.detail-thumbnail:hover{border:2px solid #155eef}
.detail-thumbnail img{width:100%;height:100%;object-fit:contain}
.detail-brand{font-size:13px;color:#777;margin-bottom:10px}
.detail-title{font-size:30px;line-height:1.35;margin:0 0 18px;overflow-wrap:anywhere}
.detail-price{font-size:30px;font-weight:700;color:#e53935;margin-bottom:20px;overflow-wrap:anywhere}
.detail-meta{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:22px}
.detail-meta span{font-size:13px;color:#555;background:#f5f6f8;padding:8px 12px;border-radius:6px}
.detail-stock{color:#16803d!important;background:#eaf8ef!important}
.detail-stock.empty{color:#b42318!important;background:#fff0ee!important}
.detail-divider{border:0;border-top:1px solid #eee;margin:22px 0}
.detail-section{margin-bottom:25px}
.detail-section h2,.detail-variants h2{font-size:18px;margin:0 0 12px;color:#222}
.detail-section p{color:#666;font-size:14px;line-height:1.8;margin:0;overflow-wrap:anywhere}
.detail-variants{margin:22px 0}
.variant-list{display:flex;flex-wrap:wrap;gap:10px}
.variant-option{display:flex;align-items:center;gap:9px;min-height:46px;padding:9px 13px;border:1px solid #d0d5dd;border-radius:9px;background:#fff;color:#344054;cursor:pointer;text-align:left}
.variant-option:hover,.variant-option.active{border:2px solid #155eef;background:#f5f8ff}
.variant-swatch{width:22px;height:22px;flex:0 0 22px;border:1px solid #ccc;border-radius:50%;background:var(--swatch-color,#e5e7eb)}
.variant-label{display:flex;flex-direction:column;gap:2px}
.variant-label strong{font-size:13px;font-weight:600}
.variant-label small,.variant-help{color:#667085;font-size:11px}
.variant-help{font-size:12px;margin:0 0 12px}
.detail-buy{margin-top:24px}
.detail-quantity{display:flex;align-items:center;gap:12px;margin-bottom:16px;font-size:14px}
.detail-quantity input{width:85px;padding:10px;border:1px solid #ddd;border-radius:6px;font-size:15px}
.detail-button{display:inline-block;width:100%;padding:14px 20px;border:0;border-radius:8px;background:#155eef;color:#fff;font-size:15px;font-weight:600;text-align:center;text-decoration:none;cursor:pointer}
.detail-button:hover{background:#104bc5}
.detail-button:disabled{background:#aaa;cursor:not-allowed}
.detail-back{display:inline-block;margin-top:22px;color:#155eef;font-size:14px;text-decoration:none}
.product-rating-summary{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin:-8px 0 18px;color:#667085;font-size:13px}
.rating-stars,.review-item-stars{color:#f59e0b;letter-spacing:1px}
.rating-stars{font-size:18px}
.product-rating-summary strong{color:#344054}
.product-reviews{margin-top:36px;padding:26px;border:1px solid #e5eaf2;border-radius:16px;background:#fff;box-shadow:0 5px 20px #00000009}
.product-reviews h2{margin:0 0 8px;font-size:22px;color:#202124}
.reviews-summary{margin:0 0 22px;color:#667085;font-size:14px}
.review-item{padding:18px 0;border-top:1px solid #edf0f4}
.review-item:first-of-type{border-top:0}
.review-item-heading{display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-bottom:8px}
.review-item-heading strong{color:#202124;font-size:14px}
.review-item p{margin:0;color:#475467;font-size:14px;line-height:1.7;overflow-wrap:anywhere}
.review-empty{padding:22px;border-radius:10px;background:#f8fbff;color:#667085;font-size:14px}
@media(max-width:800px){.detail-layout{grid-template-columns:1fr;gap:28px}.detail-main-image{height:350px}.detail-title{font-size:25px}.detail-price{font-size:26px}}
@media(max-width:480px){.detail-page{padding:20px 14px 40px}.detail-main-image{height:280px;padding:16px}.detail-title{font-size:22px}.detail-price{font-size:23px}}
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
@endphp

<div class="detail-page">
    <div class="detail-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> /
        <a href="{{ route('shop.index') }}">Semua Produk</a> /
        <span>{{ $produk->nama_produk }}</span>
    </div>

    <div class="detail-layout">
        <div class="detail-gallery">
            <div class="detail-main-image">
                @if ($gambarUtama)
                    <img id="detail-image-preview" src="{{ $gambarUtama }}" alt="{{ $produk->nama_produk }}">
                    <div class="detail-no-image" id="detail-image-error" style="display:none">Gambar tidak tersedia</div>
                @else
                    <div class="detail-no-image" id="detail-image-error">Gambar produk belum tersedia</div>
                    <img id="detail-image-preview" src="" alt="{{ $produk->nama_produk }}" style="display:none">
                @endif
            </div>

            @if ($daftarGambar->count() > 1)
                <div class="detail-thumbnails">
                    @foreach ($daftarGambar as $index => $gambar)
                        <button type="button"
                            class="detail-thumbnail {{ $index === 0 ? 'active' : '' }}"
                            onclick="pilihGambarProduk(this)"
                            data-image="{{ $urlGambarProduk($gambar) }}"
                            aria-label="Lihat foto {{ $index + 1 }}">
                            <img src="{{ $urlGambarProduk($gambar) }}" alt="Foto {{ $index + 1 }}">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="detail-info">
            <div class="detail-brand">
                {{ $produk->brand->nama_brand ?? 'ELECTROMART' }}
                @if ($produk->kategori)
                    · {{ $produk->kategori->nama_kategori }}
                @endif
            </div>

            <h1 class="detail-title">{{ $produk->nama_produk }}</h1>

            <div class="product-rating-summary">
                @if ($jumlahUlasan > 0)
                    <span class="rating-stars">{{ str_repeat('★', (int) round($rataRating)) }}{{ str_repeat('☆', 5 - (int) round($rataRating)) }}</span>
                    <strong>{{ number_format($rataRating, 1, ',', '.') }}/5</strong>
                    <span>({{ $jumlahUlasan }} ulasan)</span>
                @else
                    <span>Belum ada ulasan</span>
                @endif
            </div>

            <div class="detail-price" id="detail-price">
                Rp {{ number_format($hargaAwal, 0, ',', '.') }}
            </div>

            <div class="detail-meta">
                <span id="detail-stock" class="{{ $stokAwal > 0 ? 'detail-stock' : 'detail-stock empty' }}">
                    {{ $stokAwal > 0 ? 'Stok tersedia: ' . $stokAwal : 'Stok habis' }}
                </span>

                @if ($produk->status_produk)
                    <span>Status: {{ ucfirst($produk->status_produk) }}</span>
                @endif
            </div>

            @if ($memilikiVarian)
                <div class="detail-variants">
                    <h2>Pilih varian</h2>
                    <p class="variant-help">Pilih warna atau tipe yang ingin dibeli.</p>

                    <div class="variant-list" id="variant-list">
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
                                class="variant-option {{ $index === 0 ? 'active' : '' }}"
                                data-id="{{ $varian->id_varian }}"
                                data-price="{{ $hargaVarian }}"
                                data-stock="{{ (int) $varian->jumlah_stok }}"
                                data-image="{{ $gambarVarian ?? '' }}"
                                aria-pressed="{{ $index === 0 ? 'true' : 'false' }}">
                                @if ($varian->warna)
                                    <span class="variant-swatch" style="--swatch-color: {{ $swatchColor }}"></span>
                                @endif

                                <span class="variant-label">
                                    <strong>{{ $labelVarian }}</strong>
                                    <small>{{ (int) $varian->jumlah_stok > 0 ? 'Stok: ' . (int) $varian->jumlah_stok : 'Stok habis' }}</small>
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <hr class="detail-divider">

            <div class="detail-section">
                <h2>Deskripsi Produk</h2>
                <p>
                    @if ($produk->deskripsi)
                        {!! nl2br(e($produk->deskripsi)) !!}
                    @else
                        Belum ada deskripsi untuk produk ini.
                    @endif
                </p>
            </div>

            <hr class="detail-divider">

            <div class="detail-section">
                <h2>Spesifikasi Produk</h2>
                <p>
                    @if ($produk->spesifikasi)
                        {!! nl2br(e($produk->spesifikasi)) !!}
                    @else
                        Spesifikasi produk belum tersedia.
                    @endif
                </p>
            </div>

            <div class="detail-buy">
                @if ($memilikiVarian || $stokProduk > 0)
                    <form action="{{ route('keranjang.tambah', ['id_produk' => $produk->id_produk]) }}"
                        method="POST" id="form-tambah-keranjang">
                        @csrf

                        @if ($memilikiVarian)
                            <input type="hidden" name="id_varian" id="id-varian"
                                value="{{ $varianAktif->first()->id_varian }}">
                        @endif

                        <div class="detail-quantity">
                            <label for="jumlah">Jumlah:</label>
                            <input type="number" id="jumlah" name="jumlah" value="1"
                                min="1" max="{{ max(1, $stokAwal) }}" required>
                        </div>

                        <button type="submit" class="detail-button"
                            id="tombol-tambah-keranjang" {{ $stokAwal < 1 ? 'disabled' : '' }}>
                            {{ $stokAwal > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                        </button>
                    </form>
                @else
                    <button type="button" class="detail-button" disabled>Stok Habis</button>
                @endif
            </div>

            <a href="{{ url()->previous() }}" class="detail-back">&larr; Kembali ke halaman sebelumnya</a>
        </div>
    </div>

    <section class="product-reviews" id="ulasan-produk">
        <h2>Ulasan Pembeli</h2>

        @if ($jumlahUlasan > 0)
            <p class="reviews-summary">
                <span class="rating-stars">{{ str_repeat('★', (int) round($rataRating)) }}{{ str_repeat('☆', 5 - (int) round($rataRating)) }}</span>
                <strong>{{ number_format($rataRating, 1, ',', '.') }}/5</strong>
                dari {{ $jumlahUlasan }} ulasan
            </p>

            @foreach ($daftarUlasan as $ulasan)
                <article class="review-item">
                    <div class="review-item-heading">
                        <strong>{{ $ulasan->user->nama ?? 'Pembeli ELECTROMART' }}</strong>
                        <span class="review-item-stars" aria-label="Rating {{ $ulasan->rating }} dari 5">
                            {{ str_repeat('★', max(0, min(5, (int) $ulasan->rating))) }}{{ str_repeat('☆', 5 - max(0, min(5, (int) $ulasan->rating))) }}
                        </span>
                        <span>{{ $ulasan->created_at ? $ulasan->created_at->format('d M Y') : '' }}</span>
                    </div>

                    @if (filled($ulasan->komentar))
                        <p>{{ $ulasan->komentar }}</p>
                    @else
                        <p class="review-empty">Pembeli memberikan rating tanpa komentar.</p>
                    @endif
                </article>
            @endforeach
        @else
            <div class="review-empty">
                Belum ada ulasan untuk produk ini. Jadilah pembeli pertama yang memberikan ulasan setelah pesanan selesai.
            </div>
        @endif
    </section>
</div>

<script>
function pilihGambarProduk(tombol) {
    const gambarUtama = document.getElementById('detail-image-preview');
    const gambarError = document.getElementById('detail-image-error');

    if (!gambarUtama) return;

    gambarUtama.src = tombol.dataset.image;
    gambarUtama.style.display = 'block';

    if (gambarError) gambarError.style.display = 'none';

    document.querySelectorAll('.detail-thumbnail').forEach(function(item) {
        item.classList.remove('active');
    });

    tombol.classList.add('active');
}

document.addEventListener('DOMContentLoaded', function() {
    const gambarUtama = document.getElementById('detail-image-preview');
    const gambarError = document.getElementById('detail-image-error');
    const pilihanVarian = document.querySelectorAll('.variant-option');
    const inputVarian = document.getElementById('id-varian');
    const hargaElement = document.getElementById('detail-price');
    const stokElement = document.getElementById('detail-stock');
    const inputJumlah = document.getElementById('jumlah');
    const tombolTambah = document.getElementById('tombol-tambah-keranjang');

    if (gambarUtama && gambarError) {
        gambarUtama.addEventListener('error', function() {
            gambarUtama.style.display = 'none';
            gambarError.style.display = 'block';
        });

        gambarUtama.addEventListener('load', function() {
            gambarUtama.style.display = 'block';
            gambarError.style.display = 'none';
        });
    }

    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(Number(angka || 0));
    }

    function pilihVarian(tombol) {
        pilihanVarian.forEach(function(item) {
            item.classList.remove('active');
            item.setAttribute('aria-pressed', 'false');
        });

        tombol.classList.add('active');
        tombol.setAttribute('aria-pressed', 'true');

        if (inputVarian) inputVarian.value = tombol.dataset.id;
        if (hargaElement) hargaElement.textContent = formatRupiah(tombol.dataset.price);

        const stok = Number(tombol.dataset.stock || 0);

        if (stokElement) {
            stokElement.textContent = stok > 0 ? 'Stok tersedia: ' + stok : 'Stok habis';
            stokElement.classList.toggle('empty', stok < 1);
            stokElement.classList.toggle('detail-stock', stok > 0);
        }

        if (inputJumlah) {
            inputJumlah.value = 1;
            inputJumlah.max = Math.max(1, stok);
        }

        if (tombolTambah) {
            tombolTambah.disabled = stok < 1;
            tombolTambah.textContent = stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis';
        }

        const gambarVarian = tombol.dataset.image;

        if (gambarVarian && gambarUtama) {
            gambarUtama.src = gambarVarian;
            gambarUtama.style.display = 'block';

            if (gambarError) gambarError.style.display = 'none';

            document.querySelectorAll('.detail-thumbnail').forEach(function(item) {
                item.classList.remove('active');
            });
        }
    }

    pilihanVarian.forEach(function(tombol) {
        tombol.addEventListener('click', function() {
            pilihVarian(tombol);
        });
    });

    if (inputJumlah) {
        inputJumlah.addEventListener('change', function() {
            const maksimum = Number(inputJumlah.max || 1);
            let jumlah = Number(inputJumlah.value || 1);

            if (jumlah < 1) jumlah = 1;
            if (jumlah > maksimum) jumlah = maksimum;

            inputJumlah.value = jumlah;
        });
    }
});
</script>
@endsection