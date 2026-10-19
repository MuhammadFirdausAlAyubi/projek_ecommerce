@extends('layouts.customer')
@section('content')
@php
    $alamatUtama = $alamat->firstWhere('is_utama', 1) ?? $alamat->first();
    $jumlahProduk = 0;
    foreach ($keranjang->detailKeranjang as $detail) {
        if ($detail->produk) {
            $jumlahProduk += (int) $detail->jumlah;
        }
    }
    $alamatTerpilih = old('id_alamat', $alamatUtama?->id_alamat);
    $ekspedisiTerpilih = old('id_ekspedisi', $ekspedisi->first()?->id_ekspedisi);
    $metodeTerpilih = old('metode_pembayaran', 'transfer');
    $bankTerpilih = old('id_bank');
@endphp
<style>
    .checkout-page {
        --co-orange: #2563eb;
        --co-bg: #f5f7fb;
        --co-border: #e5eaf2;
        --co-text: #182230;
        background: var(--co-bg);
        padding: 30px 18px 55px;
        color: var(--co-text);
        min-height: 70vh;
    }
    .checkout-page,
    .checkout-page * {
        box-sizing: border-box;
    }
    .co-container {
        max-width: 1180px;
        margin: auto;
    }
    .co-heading {
        margin-bottom: 23px;
    }
    .co-heading h1 {
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 6px;
    }
    .co-heading p {
        font-size: 14px;
        color: #777;
        margin: 0;
    }
    .co-card {
        background: #fff;
        border-radius: 9px;
        margin-bottom: 18px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .035);
    }
    .co-card-head {
        padding: 18px 22px;
        border-bottom: 1px solid var(--co-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .co-card-head h2 {
        font-size: 17px;
        font-weight: 750;
        margin: 0;
    }
    .co-section-title {
        color: var(--co-orange);
        display: flex;
        align-items: center;
        gap: 9px;
    }
    .co-section-title h2 {
        color: var(--co-orange);
    }
    .co-body {
        padding: 21px 22px;
    }
    .co-address-list {
        display: grid;
        gap: 12px;
    }
    .co-address-option,
    .co-shipping-option,
    .co-payment-option {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border: 1px solid #e6e6e6;
        border-radius: 7px;
        padding: 15px;
        cursor: pointer;
        transition: border-color .18s, background .18s;
    }
    .co-address-option:has(input:checked),
    .co-shipping-option:has(input:checked),
    .co-payment-option:has(input:checked) {
        border-color: var(--co-orange);
        background: #eff6ff;
    }
    .co-address-option input,
    .co-shipping-option input,
    .co-payment-option input {
        accent-color: var(--co-orange);
        width: 17px;
        height: 17px;
        margin-top: 3px;
        flex-shrink: 0;
    }
    .co-address-content {
        flex: 1;
        min-width: 0;
    }
    .co-address-name {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        align-items: center;
        margin-bottom: 7px;
        font-size: 14px;
    }
    .co-address-text {
        font-size: 13px;
        color: #555;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }
    .co-badge {
        display: inline-block;
        font-size: 10px;
        padding: 3px 7px;
        color: var(--co-orange);
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 3px;
        font-weight: 700;
    }
    .co-link {
        font-size: 13px;
        color: var(--co-orange);
        text-decoration: none;
        font-weight: 650;
        white-space: nowrap;
    }
    .co-link:hover {
        text-decoration: underline;
    }
    .co-outline-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 13px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #fff;
        color: #444;
        font-size: 13px;
        text-decoration: none;
        white-space: nowrap;
    }
    .co-outline-btn:hover {
        color: var(--co-orange);
        border-color: var(--co-orange);
    }
    .co-product-head,
    .co-product-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 135px 75px 125px;
        gap: 14px;
        align-items: center;
    }
    .co-product-head {
        padding: 15px 22px;
        color: #888;
        font-size: 12px;
        border-bottom: 1px solid var(--co-border);
    }
    .co-product-row {
        padding: 19px 22px;
        border-bottom: 1px solid #f2f2f2;
        font-size: 13px;
    }
    .co-product-info {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }
    .co-product-image {
        width: 72px;
        height: 72px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eee;
        border-radius: 6px;
        background: #fafafa;
        overflow: hidden;
    }
    .co-product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 5px;
    }
    .co-product-name {
        font-size: 14px;
        line-height: 1.6;
        font-weight: 650;
        overflow-wrap: anywhere;
    }
    .co-muted {
        color: #888;
        font-size: 12px;
        margin-top: 5px;
    }
    .co-subtotal {
        color: var(--co-orange);
        font-weight: 750;
        text-align: right;
    }
    .co-product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 17px 22px;
        gap: 10px;
        background: #f8fbff;
        font-size: 13px;
    }
    .co-product-footer strong {
        color: var(--co-orange);
        font-size: 16px;
    }
    .co-shipping-list,
    .co-payment-list {
        display: grid;
        gap: 11px;
    }
    .co-option-main {
        flex: 1;
        min-width: 0;
    }
    .co-option-name {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .co-option-description {
        font-size: 12px;
        line-height: 1.6;
        color: #888;
    }
    .co-option-price {
        color: var(--co-orange);
        font-weight: 750;
        font-size: 13px;
        white-space: nowrap;
        text-align: right;
    }
    .co-payment-logo {
        width: 39px;
        height: 35px;
        border: 1px solid #eee;
        background: white;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 19px;
        flex-shrink: 0;
    }
    .co-bank-select {
        width: 100%;
        max-width: 420px;
        margin-top: 12px;
        padding: 11px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #fff;
        font-size: 13px;
    }
    .co-bank-details {
        margin-top: 12px;
    }
    .co-summary-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 345px;
        gap: 20px;
        align-items: start;
    }
    .co-summary {
        position: sticky;
        top: 18px;
    }
    .co-summary-body {
        padding: 22px;
    }
    .co-summary-line {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 17px;
        font-size: 13px;
        color: #666;
    }
    .co-summary-line strong {
        color: #333;
        font-weight: 650;
        text-align: right;
    }
    .co-summary-total {
        border-top: 1px dashed #ddd;
        padding-top: 19px;
        margin-top: 4px;
        align-items: center;
    }
    .co-summary-total span {
        color: #333;
        font-size: 14px;
        font-weight: 750;
    }
    .co-summary-total strong {
        color: var(--co-orange);
        font-size: 23px;
        font-weight: 800;
    }
    .co-submit {
        width: 100%;
        padding: 14px;
        margin-top: 6px;
        border: 0;
        border-radius: 5px;
        background: var(--co-orange);
        color: white;
        font-size: 15px;
        font-weight: 750;
        cursor: pointer;
    }
    .co-submit:hover {
        background: #1d4ed8;
    }
    .co-submit:disabled {
        opacity: .55;
        cursor: not-allowed;
    }
    .co-alert {
        padding: 13px 16px;
        border: 1px solid #ffd2ca;
        background: #fff1ee;
        color: #bd3c25;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 13px;
    }
    .co-error {
        display: block;
        color: #d93025;
        font-size: 12px;
        margin-top: 6px;
    }
    .co-secure {
        margin-top: 14px;
        color: #999;
        font-size: 11px;
        line-height: 1.7;
    }
    @media (max-width: 850px) {
        .co-summary-layout {
            grid-template-columns: 1fr;
        }
        .co-summary {
            position: static;
        }
    }
    @media (max-width: 600px) {
        .checkout-page {
            padding: 20px 11px 35px;
        }
        .co-heading h1 {
            font-size: 23px;
        }
        .co-card-head,
        .co-body {
            padding: 16px;
        }
        .co-product-head {
            display: none;
        }
        .co-product-row {
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            padding: 16px;
        }
        .co-product-info {
            grid-column: 1 / -1;
        }
        .co-product-row > :nth-child(2)::before {
            content: 'Harga: ';
            color: #999;
        }
        .co-product-row > :nth-child(3) {
            text-align: right;
        }
        .co-product-row > :nth-child(3)::before {
            content: 'Jumlah: ';
            color: #999;
        }
        .co-product-row > :nth-child(4) {
            grid-column: 1 / -1;
        }
        .co-product-row > :nth-child(4)::before {
            content: 'Subtotal: ';
            color: #999;
            font-weight: 400;
        }
        .co-subtotal {
            text-align: right;
        }
        .co-product-footer {
            padding: 16px;
        }
        .co-option-price {
            font-size: 12px;
        }
        .co-address-option,
        .co-shipping-option,
        .co-payment-option {
            padding: 12px;
            gap: 9px;
        }
        .co-address-content .co-link {
            display: block;
            margin-top: 8px;
        }
    }
</style>
<div class="checkout-page">
    <div class="co-container">
        <div class="co-heading">
            <h1>Checkout</h1>
            <p>Pastikan alamat, pengiriman, dan pembayaran sudah benar.</p>
        </div>
        @if (session('success'))
            <div class="co-alert" style="background:#effaf2;color:#237a3b;border-color:#ccebd4;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="co-alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="co-alert">
                <strong>Pesanan belum dapat diproses.</strong>
                <ul style="margin:8px 0 0;padding-left:20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
            @csrf
            {{-- ALAMAT PENGIRIMAN --}}
            <section class="co-card">
                <div class="co-card-head">
                    <div class="co-section-title">
                        <span style="font-size:22px;">⌖</span>
                        <h2>Alamat Pengiriman</h2>
                    </div>
                    <a href="{{ route('alamat.index') }}" class="co-link">
                        Kelola alamat →
                    </a>
                </div>
                <div class="co-body">
                    <div class="co-address-list">
                        @foreach ($alamat as $item)
                            <label class="co-address-option">
                                <input
                                    type="radio"
                                    name="id_alamat"
                                    value="{{ $item->id_alamat }}"
                                    required
                                    @checked((string) $alamatTerpilih === (string) $item->id_alamat)
                                >
                                <div class="co-address-content">
                                    <div class="co-address-name">
                                        <strong>{{ $item->nama_penerima }}</strong>
                                        <span style="color:#777;">
                                            {{ $item->no_telp_penerima }}
                                        </span>
                                        @if ($item->is_utama)
                                            <span class="co-badge">UTAMA</span>
                                        @endif
                                    </div>
                                    <div class="co-address-text">
                                        {{ $item->alamat_lengkap }},
                                        {{ $item->kecamatan }},
                                        {{ $item->kota }},
                                        {{ $item->provinsi }}
                                        {{ $item->kode_pos }}
                                    </div>
                                    <a href="{{ route('alamat.index') }}" class="co-link">
                                        Ubah alamat
                                    </a>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('id_alamat')
                        <span class="co-error">{{ $message }}</span>
                    @enderror
                    <div style="margin-top:15px;">
                        <a href="{{ route('alamat.create') }}" class="co-outline-btn">
                            + Tambah alamat baru
                        </a>
                    </div>
                </div>
            </section>
            {{-- PRODUK --}}
            <section class="co-card">
                <div class="co-card-head">
                    <h2>Produk yang Dibeli</h2>
                    <span style="font-size:13px;color:#888;">
                        {{ $jumlahProduk }} barang
                    </span>
                </div>
                <div class="co-product-head">
                    <div>Produk</div>
                    <div>Harga Satuan</div>
                    <div>Jumlah</div>
                    <div style="text-align:right;">Subtotal</div>
                </div>
                @foreach ($keranjang->detailKeranjang as $item)
                    @if ($item->produk)
                        @php
                            $produk = $item->produk;
                            $harga = (float) $produk->harga_jual;
                            $subtotalProduk = $harga * (int) $item->jumlah;
                            $gambar = $produk->gambar ?? null;
                            if ($gambar && !preg_match('/^https?:\/\//i', $gambar)) {
                                $gambar = asset('storage/' . ltrim($gambar, '/'));
                            }
                        @endphp
                        <div class="co-product-row">
                            <div class="co-product-info">
                                <div class="co-product-image">
                                    @if ($gambar)
                                        <img
                                            src="{{ $gambar }}"
                                            alt="{{ $produk->nama_produk }}"
                                            onerror="this.style.display='none';this.nextElementSibling.style.display='block';"
                                        >
                                        <span style="display:none;font-size:25px;color:#bbb;">▧</span>
                                    @else
                                        <span style="font-size:25px;color:#bbb;">▧</span>
                                    @endif
                                </div>
                                <div style="min-width:0;">
                                    <div class="co-product-name">
                                        {{ $produk->nama_produk }}
                                    </div>
                                    <div class="co-muted">ELECTROMART</div>
                                </div>
                            </div>
                            <div>Rp{{ number_format($harga, 0, ',', '.') }}</div>
                            <div>{{ $item->jumlah }}</div>
                            <div class="co-subtotal">
                                Rp{{ number_format($subtotalProduk, 0, ',', '.') }}
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="co-product-footer">
                    <span style="color:#666;">Subtotal produk</span>
                    <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                </div>
            </section>
            {{-- PILIH EKSPEDISI --}}
            <section class="co-card">
                <div class="co-card-head">
                    <h2>🚚 Pilih Jasa Pengiriman</h2>
                    <span style="font-size:12px;color:#888;">Pilih satu layanan</span>
                </div>
                <div class="co-body">
                    @if ($ekspedisi->isNotEmpty())
                        <div class="co-shipping-list">
                            @foreach ($ekspedisi as $kurir)
                                <label class="co-shipping-option">
                                    <input
                                        type="radio"
                                        name="id_ekspedisi"
                                        value="{{ $kurir->id_ekspedisi }}"
                                        data-ongkir="{{ (float) $kurir->ongkir }}"
                                        required
                                        @checked((string) $ekspedisiTerpilih === (string) $kurir->id_ekspedisi)
                                    >
                                    <div class="co-option-main">
                                        <div class="co-option-name">
                                            {{ $kurir->nama_ekspedisi }}
                                        </div>
                                        <div class="co-option-description">
                                            Tarif sesuai pengaturan admin.
                                            Estimasi waktu belum terintegrasi.
                                        </div>
                                    </div>
                                    <div class="co-option-price">
                                        Rp{{ number_format((float) $kurir->ongkir, 0, ',', '.') }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="co-alert">
                            Belum ada ekspedisi aktif. Hubungi admin untuk mengaktifkan layanan pengiriman.
                        </div>
                    @endif
                    @error('id_ekspedisi')
                        <span class="co-error">{{ $message }}</span>
                    @enderror
                </div>
            </section>
            {{-- PILIH PEMBAYARAN --}}
            <section class="co-card">
                <div class="co-card-head">
                    <h2>💳 Metode Pembayaran</h2>
                </div>
                <div class="co-body">
                    <div class="co-payment-list">
                        <label class="co-payment-option">
                            <input
                                type="radio"
                                name="metode_pembayaran"
                                value="transfer"
                                required
                                @checked($metodeTerpilih === 'transfer')
                            >
                            <span class="co-payment-logo">🏦</span>
                            <div class="co-option-main">
                                <div class="co-option-name">Transfer Bank</div>
                                <div class="co-option-description">
                                    Transfer ke rekening yang tersedia.
                                </div>
                            </div>
                        </label>
                        <div
                            id="bankDetails"
                            class="co-bank-details"
                            style="{{ $metodeTerpilih === 'transfer' ? '' : 'display:none;' }}"
                        >
                            @if ($bank->isNotEmpty())
                                <label for="id_bank" style="font-size:13px;font-weight:650;">
                                    Pilih rekening bank
                                </label>
                                <select
                                    name="id_bank"
                                    id="id_bank"
                                    class="co-bank-select"
                                    @if ($metodeTerpilih === 'transfer') required @endif
                                >
                                    <option value="">-- Pilih bank --</option>
                                    @foreach ($bank as $rekening)
                                        <option
                                            value="{{ $rekening->id_bank }}"
                                            @selected((string) $bankTerpilih === (string) $rekening->id_bank)
                                        >
                                            {{ $rekening->nama_bank }}
                                            — {{ $rekening->no_rekening }}
                                            ({{ $rekening->atas_nama }})
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <div class="co-alert">
                                    Rekening bank belum tersedia. Admin perlu menambahkan rekening melalui menu Bank.
                                </div>
                                <select name="id_bank" id="id_bank" class="co-bank-select" disabled>
                                    <option value="">Belum ada rekening tersedia</option>
                                </select>
                            @endif
                            @error('id_bank')
                                <span class="co-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <label class="co-payment-option">
                            <input
                                type="radio"
                                name="metode_pembayaran"
                                value="cod"
                                required
                                @checked($metodeTerpilih === 'cod')
                            >
                            <span class="co-payment-logo">📦</span>
                            <div class="co-option-main">
                                <div class="co-option-name">COD (Bayar di Tempat)</div>
                                <div class="co-option-description">
                                    Pembayaran kepada kurir saat barang diterima.
                                    Pastikan layanan ini tersedia untuk tujuanmu.
                                </div>
                            </div>
                        </label>
                        <label class="co-payment-option">
                            <input
                                type="radio"
                                name="metode_pembayaran"
                                value="ewallet"
                                required
                                @checked($metodeTerpilih === 'ewallet')
                            >
                            <span class="co-payment-logo">📱</span>
                            <div class="co-option-main">
                                <div class="co-option-name">E-Wallet</div>
                                <div class="co-option-description">
                                    Metode dicatat sebagai e-wallet. Pembayaran otomatis belum terintegrasi.
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('metode_pembayaran')
                        <span class="co-error">{{ $message }}</span>
                    @enderror
                </div>
            </section>
            {{-- RINGKASAN PESANAN --}}
            <div class="co-summary-layout">
                <div>
                    <a href="{{ route('keranjang.index') }}" class="co-outline-btn">
                        ← Kembali ke Keranjang
                    </a>
                </div>
                <aside class="co-card co-summary">
                    <div class="co-card-head">
                        <h2>Rincian Pembayaran</h2>
                    </div>
                    <div class="co-summary-body">
                        <div class="co-summary-line">
                            <span>Total barang</span>
                            <strong>{{ $jumlahProduk }} barang</strong>
                        </div>
                        <div class="co-summary-line">
                            <span>Subtotal produk</span>
                            <strong id="subtotalText">
                                Rp{{ number_format($total, 0, ',', '.') }}
                            </strong>
                        </div>
                        <div class="co-summary-line">
                            <span>Ongkos kirim</span>
                            <strong id="ongkirText">Rp0</strong>
                        </div>
                        <div class="co-summary-line co-summary-total">
                            <span>Total pembayaran</span>
                            <strong id="totalText">
                                Rp{{ number_format($total, 0, ',', '.') }}
                            </strong>
                        </div>
                        <button
                            type="submit"
                            class="co-submit"
                            id="submitOrder"
                            @if ($ekspedisi->isEmpty()) disabled @endif
                        >
                            Buat Pesanan
                        </button>
                        <div class="co-secure">
                            🔒 Total akhir akan dihitung kembali oleh server.
                            Status pembayaran tidak otomatis menjadi berhasil.
                        </div>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const subtotal = {{ (float) $total }};
    const ongkirText = document.getElementById('ongkirText');
    const totalText = document.getElementById('totalText');
    const bankDetails = document.getElementById('bankDetails');
    const bankSelect = document.getElementById('id_bank');
    const submitOrder = document.getElementById('submitOrder');
    const formatRupiah = (number) => {
        return 'Rp' + new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(number);
    };
    function updateTotal() {
        const selectedShipping = document.querySelector(
            'input[name="id_ekspedisi"]:checked'
        );
        const ongkir = selectedShipping
            ? Number(selectedShipping.dataset.ongkir || 0)
            : 0;
        ongkirText.textContent = formatRupiah(ongkir);
        totalText.textContent = formatRupiah(subtotal + ongkir);
    }
    function updatePayment() {
        const selectedPayment = document.querySelector(
            'input[name="metode_pembayaran"]:checked'
        );
        const isTransfer = selectedPayment &&
            selectedPayment.value === 'transfer';
        if (bankDetails) {
            bankDetails.style.display = isTransfer ? 'block' : 'none';
        }
        if (bankSelect) {
            const bankOptionAvailable = Array.from(bankSelect.options)
                .some(option => option.value !== '');
            bankSelect.required = Boolean(isTransfer && bankOptionAvailable);
        }
    }
    document.querySelectorAll('input[name="id_ekspedisi"]').forEach(input => {
        input.addEventListener('change', updateTotal);
    });
    document.querySelectorAll('input[name="metode_pembayaran"]').forEach(input => {
        input.addEventListener('change', updatePayment);
    });
    document.getElementById('checkoutForm').addEventListener('submit', function (event) {
        const address = document.querySelector('input[name="id_alamat"]:checked');
        const shipping = document.querySelector('input[name="id_ekspedisi"]:checked');
        const payment = document.querySelector('input[name="metode_pembayaran"]:checked');
        if (!address || !shipping || !payment) {
            event.preventDefault();
            alert('Pilih alamat, ekspedisi, dan metode pembayaran terlebih dahulu.');
            return;
        }
        if (
            payment.value === 'transfer' &&
            (!bankSelect || !bankSelect.value || bankSelect.disabled)
        ) {
            event.preventDefault();
            alert('Pilih rekening bank yang tersedia terlebih dahulu.');
        }
    });
    updateTotal();
    updatePayment();
});
</script>
@endsection
