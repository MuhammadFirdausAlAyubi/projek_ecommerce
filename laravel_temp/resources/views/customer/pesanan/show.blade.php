@extends('layouts.customer')

@section('content')
<div class="detail-page">
    <a href="{{ route('pesanan-saya.index') }}" class="back-link">
        &larr; Kembali ke Pesanan Saya
    </a>

    <div class="page-heading">
        <div>
            <h1>Detail Pesanan</h1>
            <p>Informasi lengkap transaksi ELECTROMART kamu.</p>
        </div>

        <span class="status-badge">
            {{ ucwords(str_replace('_', ' ', $pesanan->status_pesanan ?? 'menunggu')) }}
        </span>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert-error">
            <strong>Periksa kembali data ulasan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="detail-card">
        <div class="card-heading">
            <div>
                <span class="muted-label">NOMOR PESANAN</span>
                <h2>#{{ $pesanan->id_pesanan }}</h2>
            </div>

            <div class="tanggal">
                <span class="muted-label">TANGGAL PESANAN</span>
                <strong>
                    {{ $pesanan->tanggal_pesanan
                        ? \Illuminate\Support\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y, H:i')
                        : '-' }}
                </strong>
            </div>
        </div>

        <div class="card-body">
            <h3 class="section-title">Produk yang Dibeli</h3>

            @forelse ($pesanan->detailPesanan as $detail)
                <div class="product-row">
                    <div class="product-info">
                        <div class="product-image">
                            @if ($detail->produk && $detail->produk->gambar)
                                <img
                                    src="{{ asset('storage/' . $detail->produk->gambar) }}"
                                    alt="{{ $detail->produk->nama_produk }}"
                                >
                            @else
                                <span>📦</span>
                            @endif
                        </div>

                        <div>
                            <h4>{{ $detail->produk->nama_produk ?? 'Produk tidak tersedia' }}</h4>
                            <p>
                                {{ $detail->jumlah }} barang ×
                                Rp{{ number_format((float) $detail->harga_satuan, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <strong class="product-subtotal">
                        Rp{{ number_format((float) $detail->subtotal, 0, ',', '.') }}
                    </strong>
                </div>

                @if ($pesanan->status_pesanan === 'selesai' && $detail->produk && auth()->check())
                    @php
                        $daftarUlasanProduk = $detail->produk->ulasanProduk ?? collect();

                        $ulasanSaya = $daftarUlasanProduk->firstWhere(
                            'id_user',
                            auth()->user()->id_user
                        );
                    @endphp

                    <div class="review-box">
                        @if ($ulasanSaya)
                            <h4>Ulasan Kamu</h4>

                            <div class="review-stars">
                                {{ str_repeat('★', (int) $ulasanSaya->rating) }}{{ str_repeat('☆', 5 - (int) $ulasanSaya->rating) }}
                            </div>

                            <p class="review-rating-text">
                                Rating: {{ $ulasanSaya->rating }}/5
                            </p>

                            <p class="review-comment">
                                {{ $ulasanSaya->komentar ?: 'Kamu memberikan rating tanpa komentar.' }}
                            </p>

                            <p class="review-note">
                                Ulasan sudah dikirim dan tidak dapat diubah.
                            </p>
                        @else
                            <h4>Beri Ulasan Produk</h4>

                            <p class="review-description">
                                Bagikan pengalaman kamu setelah menerima produk.
                            </p>

                            <form
                                action="{{ route('ulasan.store', ['id' => $detail->produk->id_produk]) }}"
                                method="POST"
                            >
                                @csrf

                                <label for="rating-{{ $detail->produk->id_produk }}">
                                    Rating bintang
                                </label>

                                <select
                                    id="rating-{{ $detail->produk->id_produk }}"
                                    name="rating"
                                    required
                                >
                                    <option value="">Pilih rating</option>

                                    @for ($bintang = 5; $bintang >= 1; $bintang--)
                                        <option
                                            value="{{ $bintang }}"
                                            @selected((int) old('rating') === $bintang)
                                        >
                                            {{ $bintang }} bintang
                                        </option>
                                    @endfor
                                </select>

                                <label for="komentar-{{ $detail->produk->id_produk }}">
                                    Komentar (opsional)
                                </label>

                                <textarea
                                    id="komentar-{{ $detail->produk->id_produk }}"
                                    name="komentar"
                                    rows="3"
                                    maxlength="2000"
                                    placeholder="Bagaimana pengalamanmu menggunakan produk ini?"
                                >{{ old('komentar') }}</textarea>

                                @error('rating')
                                    <p class="review-error">{{ $message }}</p>
                                @enderror

                                @error('komentar')
                                    <p class="review-error">{{ $message }}</p>
                                @enderror

                                <button type="submit" class="review-submit">
                                    Kirim Ulasan
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            @empty
                <p>Rincian produk untuk pesanan ini belum tersedia.</p>
            @endforelse
        </div>
    </section>

    <div class="detail-grid">
        <section class="detail-card">
            <div class="card-body">
                <h3 class="section-title">Alamat Pengiriman</h3>

                @if ($pesanan->alamat)
                    <div class="address-information">
                        @foreach ([
                            'nama_penerima' => 'Nama Penerima',
                            'no_telp' => 'Nomor Telepon',
                            'alamat_lengkap' => 'Alamat',
                            'kelurahan' => 'Kelurahan',
                            'kecamatan' => 'Kecamatan',
                            'kota' => 'Kota/Kabupaten',
                            'provinsi' => 'Provinsi',
                            'kode_pos' => 'Kode Pos',
                        ] as $field => $label)
                            @if (filled(data_get($pesanan->alamat, $field)))
                                <div class="info-row">
                                    <span>{{ $label }}</span>
                                    <strong>{{ data_get($pesanan->alamat, $field) }}</strong>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="muted-text">Informasi alamat tidak tersedia.</p>
                @endif

                <h3 class="section-title section-spacing">Informasi Pengiriman</h3>

                @if ($pesanan->pengiriman)
                    <div class="info-row">
                        <span>Ekspedisi</span>
                        <strong>
                            {{ $pesanan->pengiriman->ekspedisi->nama_ekspedisi ?? 'Belum ditentukan' }}
                        </strong>
                    </div>

                    <div class="info-row">
                        <span>Status Pengiriman</span>
                        <strong>
                            {{ ucwords(str_replace('_', ' ', $pesanan->pengiriman->status_pengiriman ?? 'menunggu')) }}
                        </strong>
                    </div>

                    <div class="info-row">
                        <span>Nomor Resi</span>
                        <strong>{{ $pesanan->pengiriman->no_resi ?: 'Belum tersedia' }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Tanggal Pengiriman</span>
                        <strong>
                            {{ $pesanan->pengiriman->tanggal_pengiriman
                                ? \Illuminate\Support\Carbon::parse($pesanan->pengiriman->tanggal_pengiriman)->format('d M Y, H:i')
                                : 'Belum dikirim' }}
                        </strong>
                    </div>
                @else
                    <p class="muted-text">Informasi pengiriman belum tersedia.</p>
                @endif
            </div>
        </section>

        <section class="detail-card">
            <div class="card-body">
                <h3 class="section-title">Informasi Pembayaran</h3>

                @if ($pesanan->pembayaran)
                    <div class="info-row">
                        <span>Metode Pembayaran</span>
                        <strong>
                            {{ strtoupper($pesanan->pembayaran->metode_pembayaran ?? '-') }}
                        </strong>
                    </div>

                    <div class="info-row">
                        <span>Status Pembayaran</span>
                        <strong>
                            {{ ucwords(str_replace('_', ' ', $pesanan->pembayaran->status_pembayaran ?? 'menunggu')) }}
                        </strong>
                    </div>

                    <div class="info-row">
                        <span>Tanggal Pembayaran</span>
                        <strong>
                            {{ $pesanan->pembayaran->tanggal_pembayaran
                                ? \Illuminate\Support\Carbon::parse($pesanan->pembayaran->tanggal_pembayaran)->format('d M Y, H:i')
                                : 'Belum dibayar' }}
                        </strong>
                    </div>
                @else
                    <p class="muted-text">Informasi pembayaran belum tersedia.</p>
                @endif

                <h3 class="section-title section-spacing">Rincian Total</h3>

                <div class="info-row">
                    <span>Subtotal Produk</span>
                    <strong>
                        Rp{{ number_format((float) $pesanan->detailPesanan->sum('subtotal'), 0, ',', '.') }}
                    </strong>
                </div>

                <div class="info-row">
                    <span>Ongkos Kirim</span>
                    <strong>
                        Rp{{ number_format((float) $pesanan->ongkir, 0, ',', '.') }}
                    </strong>
                </div>

                <div class="total-row">
                    <span>Total Pembayaran</span>
                    <strong>
                        Rp{{ number_format((float) $pesanan->total_harga, 0, ',', '.') }}
                    </strong>
                </div>
            </div>
        </section>
    </div>

    <div class="bottom-action">
        <a href="{{ route('shop.index') }}" class="btn-shop">Belanja Lagi</a>
    </div>
</div>

<style>
    .detail-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 30px 20px 48px;
        color: #202124;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 22px;
        color: #1d4ed8;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
    }

    .page-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        margin-bottom: 24px;
    }

    .page-heading h1 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 800;
    }

    .page-heading p {
        margin: 0;
        color: #777;
        font-size: 14px;
    }

    .status-badge {
        padding: 9px 13px;
        border-radius: 8px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .detail-card {
        overflow: hidden;
        margin-bottom: 20px;
        border: 1px solid #e9e9e9;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .035);
    }

    .card-heading {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 22px 24px;
        background: #f8fbff;
        border-bottom: 1px solid #eee;
    }

    .muted-label {
        display: block;
        margin-bottom: 7px;
        color: #858585;
        font-size: 10px;
        letter-spacing: .7px;
    }

    .card-heading h2 {
        margin: 0;
        font-size: 22px;
    }

    .tanggal {
        text-align: right;
    }

    .tanggal strong {
        font-size: 13px;
    }

    .card-body {
        padding: 24px;
    }

    .section-title {
        margin: 0 0 18px;
        font-size: 16px;
        font-weight: 800;
    }

    .section-spacing {
        margin-top: 28px;
    }

    .product-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 16px 0;
        border-bottom: 1px solid #eee;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
    }

    .product-image {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 78px;
        height: 78px;
        overflow: hidden;
        border: 1px solid #eee;
        border-radius: 10px;
        background: #fafafa;
        font-size: 28px;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .product-info h4 {
        margin: 0 0 8px;
        font-size: 14px;
    }

    .product-info p {
        margin: 0;
        color: #777;
        font-size: 12px;
    }

    .product-subtotal {
        font-size: 14px;
        white-space: nowrap;
    }

    .review-box {
        margin: 16px 0 22px;
        padding: 18px;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        background: #f8fbff;
    }

    .review-box h4 {
        margin: 0 0 12px;
        color: #1d4ed8;
        font-size: 16px;
    }

    .review-description,
    .review-comment {
        color: #475467;
        font-size: 14px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .review-box label {
        display: block;
        margin: 12px 0 6px;
        font-size: 13px;
        font-weight: 700;
    }

    .review-box select,
    .review-box textarea {
        display: block;
        width: 100%;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        font: inherit;
        box-sizing: border-box;
    }

    .review-submit {
        margin-top: 12px;
        padding: 10px 16px;
        border: 0;
        border-radius: 8px;
        background: #2563eb;
        color: #fff;
        font-weight: 700;
        cursor: pointer;
    }

    .review-submit:hover {
        background: #1d4ed8;
    }

    .review-stars {
        color: #f59e0b;
        font-size: 22px;
        letter-spacing: 2px;
    }

    .review-rating-text {
        margin: 6px 0;
        color: #475467;
        font-size: 13px;
    }

    .review-note {
        margin-bottom: 0;
        color: #15803d;
        font-size: 13px;
    }

    .review-error {
        color: #b91c1c;
        font-size: 13px;
    }

    .alert-success,
    .alert-error {
        margin-bottom: 18px;
        padding: 13px 16px;
        border-radius: 9px;
        font-size: 14px;
    }

    .alert-success {
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #166534;
    }

    .alert-error {
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #991b1b;
    }

    .alert-error ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }

    .detail-grid .detail-card {
        height: 100%;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }

    .info-row span {
        color: #777;
    }

    .info-row strong {
        text-align: right;
        overflow-wrap: anywhere;
    }

    .muted-text {
        color: #777;
        font-size: 14px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #ddd;
        font-size: 14px;
    }

    .total-row strong {
        color: #2563eb;
        font-size: 21px;
        font-weight: 800;
        text-align: right;
    }

    .bottom-action {
        display: flex;
        justify-content: flex-end;
        margin-top: 8px;
    }

    .btn-shop {
        display: inline-flex;
        justify-content: center;
        padding: 12px 22px;
        border-radius: 9px;
        background: #2563eb;
        color: #fff;
        font-weight: 700;
        text-decoration: none;
    }

    .btn-shop:hover {
        background: #1d4ed8;
        color: #fff;
    }

    @media (max-width: 760px) {
        .detail-page {
            padding: 22px 12px 35px;
        }

        .page-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .page-heading h1 {
            font-size: 24px;
        }

        .card-heading {
            flex-direction: column;
            padding: 18px;
        }

        .tanggal {
            text-align: left;
        }

        .card-body {
            padding: 18px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .product-image {
            width: 65px;
            height: 65px;
        }

        .product-subtotal {
            font-size: 12px;
        }

        .bottom-action .btn-shop {
            width: 100%;
        }
    }
</style>
@endsection