@php
    $namaProduk = trim($produk->nama_produk, " \t\n\r\0\x0B\\/");
    $namaBrand = $produk->brand->nama_brand ?? null;

    $ulasan = $produk->ulasanProduk ?? collect();
    $jumlahUlasan = $ulasan->count();
    $rataRataRating = $jumlahUlasan > 0 ? $ulasan->avg('rating') : 0;

    $gambar = $produk->gambar;
    if ($gambar && !preg_match('/^https?:\/\//i', $gambar)) {
        $gambar = asset('storage/' . ltrim($gambar, '/'));
    }

    $jumlahStok = $produk->stok->jumlah_stok ?? 0;
    $kelasStok = $produk->stok ? ($jumlahStok > 0 ? 'tersedia' : 'habis') : '';
@endphp

<article class="pcard">
    <a class="pcard-link" href="{{ route('produk.detail', $produk->id_produk) }}" aria-label="Lihat detail {{ $namaProduk }}">
        <div class="pcard-image">
            @if ($gambar)
                <img src="{{ $gambar }}" alt="{{ $namaProduk }}" loading="lazy"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div class="pcard-placeholder" style="display:none">Gambar tidak tersedia</div>
            @else
                <div class="pcard-placeholder">Gambar belum tersedia</div>
            @endif
        </div>

        <div class="pcard-info">
            <span class="pcard-brand">{{ $namaBrand ?: 'ELECTROMART' }}</span>
            <h3 class="pcard-name">{{ $namaProduk }}</h3>

            <div class="pcard-rating">
                @if ($jumlahUlasan > 0)
                    <span style="color:#f59e0b;">★ {{ number_format($rataRataRating, 1) }}</span>
                    <span style="color:#667085;">({{ $jumlahUlasan }} ulasan)</span>
                @else
                    <span style="color:#98a2b3;">Belum ada ulasan</span>
                @endif
            </div>

            <div class="pcard-price">Rp {{ number_format((float) $produk->harga_jual, 0, ',', '.') }}</div>

            <span class="pcard-stock {{ $kelasStok }}">
                @if ($produk->stok)
                    Stok: {{ $jumlahStok }}
                @else
                    Stok belum tercatat
                @endif
            </span>
        </div>
    </a>
</article>
