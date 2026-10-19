
@extends('layouts.customer')

@section('content')
<div class="pesanan-page">
    <div class="pesanan-header">
        <div>
            <h1>Pesanan Saya</h1>
            <p>Pantau status dan riwayat belanja kamu di ELECTROMART.</p>
        </div>
        <a href="{{ route('shop.index') }}" class="btn-belanja">
            + Belanja Lagi
        </a>
    </div>

    <div class="pesanan-card">
        <div class="pesanan-tabs">
            <a href="{{ route('pesanan-saya.index') }}" class="active">
                Semua Pesanan
            </a>
        </div>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($pesanan->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h2>Belum Ada Pesanan</h2>
                <p>Pesanan yang kamu buat akan muncul di halaman ini.</p>
                <a href="{{ route('shop.index') }}" class="btn-belanja">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="daftar-pesanan">
                @foreach ($pesanan as $item)
                    <article class="pesanan-item">
                        <div class="pesanan-item-header">
                            <div class="nomor-pesanan">
                                <span class="label-kecil">NO. PESANAN</span>
                                <strong>#{{ $item->id_pesanan }}</strong>
                            </div>

                            <div class="tanggal-pesanan">
                                {{ $item->tanggal_pesanan
                                    ? $item->tanggal_pesanan->format('d M Y, H:i')
                                    : '-' }}
                            </div>

                            <span class="status-badge">
                                {{ ucwords(str_replace(
                                    '_',
                                    ' ',
                                    $item->status_pesanan ?? 'menunggu'
                                )) }}
                            </span>
                        </div>

                        <div class="produk-pesanan">
                            @foreach ($item->detailPesanan as $detail)
                                <div class="produk-item">
                                    <div class="produk-info">
                                        <div class="produk-gambar">
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
                                            <h3>
                                                {{ $detail->produk->nama_produk
                                                    ?? 'Produk tidak tersedia' }}
                                            </h3>
                                            <p>{{ $detail->jumlah }} barang</p>
                                            <span class="harga-produk">
                                                Rp{{ number_format(
                                                    (float) $detail->harga_satuan,
                                                    0, ',', '.'
                                                ) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="subtotal-produk">
                                        <span>Subtotal</span>
                                        <strong>
                                            Rp{{ number_format(
                                                (float) $detail->subtotal,
                                                0, ',', '.'
                                            ) }}
                                        </strong>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pesanan-footer">
                            <div class="total-pesanan">
                                <span>Total Pesanan</span>
                                <strong>
                                    Rp{{ number_format(
                                        (float) $item->total_harga,
                                        0, ',', '.'
                                    ) }}
                                </strong>
                            </div>

                            <a
                                href="{{ route('pesanan-saya.show', $item->id_pesanan) }}"
                                class="btn-detail"
                            >
                                Lihat Detail →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $pesanan->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .pesanan-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 32px 20px 48px;
        color: #202124;
    }

    .pesanan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 26px;
    }

    .pesanan-header h1 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 800;
    }

    .pesanan-header p {
        margin: 0;
        color: #747474;
        font-size: 14px;
    }

    .btn-belanja,
    .btn-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 18px;
        border-radius: 9px;
        background: #2563eb;
        color: white;
        font-weight: 700;
        text-decoration: none;
        transition: .2s;
    }

    .btn-belanja:hover,
    .btn-detail:hover {
        background: #1d4ed8;
        color: white;
    }

    .pesanan-card {
        overflow: hidden;
        background: white;
        border: 1px solid #e9e9e9;
        border-radius: 16px;
        box-shadow: 0 5px 22px rgba(0, 0, 0, .035);
    }

    .pesanan-tabs {
        display: flex;
        border-bottom: 1px solid #eee;
        padding: 0 24px;
    }

    .pesanan-tabs a {
        padding: 18px 4px;
        color: #555;
        text-decoration: none;
    }

    .pesanan-tabs a.active {
        color: #2563eb;
        border-bottom: 3px solid #2563eb;
        font-weight: 800;
    }

    .daftar-pesanan {
        padding: 20px;
    }

    .pesanan-item {
        overflow: hidden;
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .pesanan-item:last-child {
        margin-bottom: 0;
    }

    .pesanan-item-header {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        padding: 16px 20px;
        background: #fafafa;
        border-bottom: 1px solid #eee;
    }

    .nomor-pesanan {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .label-kecil {
        color: #858585;
        font-size: 10px;
        letter-spacing: .7px;
    }

    .tanggal-pesanan {
        color: #777;
        font-size: 13px;
    }

    .status-badge {
        margin-left: auto;
        padding: 7px 11px;
        border-radius: 7px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 800;
    }

    .produk-pesanan {
        padding: 6px 20px;
    }

    .produk-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 16px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .produk-item:last-child {
        border-bottom: 0;
    }

    .produk-info {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
    }

    .produk-gambar {
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

    .produk-gambar img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .produk-info h3 {
        margin: 0 0 7px;
        font-size: 14px;
        font-weight: 700;
    }

    .produk-info p,
    .harga-produk {
        margin: 0 0 5px;
        color: #777;
        font-size: 12px;
    }

    .subtotal-produk {
        display: flex;
        flex-direction: column;
        gap: 5px;
        text-align: right;
        font-size: 12px;
    }

    .subtotal-produk span {
        color: #888;
    }

    .subtotal-produk strong {
        color: #333;
        font-size: 14px;
    }

    .pesanan-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 18px 20px;
        border-top: 1px solid #eee;
        background: #f8fbff;
    }

    .total-pesanan {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .total-pesanan span {
        color: #777;
        font-size: 12px;
    }

    .total-pesanan strong {
        color: #2563eb;
        font-size: 21px;
        font-weight: 800;
    }

    .btn-detail {
        background: white;
        color: #1d4ed8;
        border: 1px solid #2563eb;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .empty-state {
        padding: 65px 20px;
        text-align: center;
    }

    .empty-icon {
        margin-bottom: 16px;
        font-size: 55px;
    }

    .empty-state h2 {
        margin-bottom: 10px;
        font-size: 22px;
    }

    .empty-state p {
        margin-bottom: 24px;
        color: #777;
        font-size: 14px;
    }

    .alert-success {
        margin: 20px;
        padding: 13px 16px;
        border-radius: 9px;
        background: #ecfdf5;
        color: #047857;
    }

    .pagination-wrapper {
        padding: 0 20px 22px;
    }

    @media (max-width: 640px) {
        .pesanan-page {
            padding: 22px 12px 35px;
        }

        .pesanan-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .pesanan-header h1 {
            font-size: 24px;
        }

        .daftar-pesanan {
            padding: 12px;
        }

        .pesanan-item-header {
            gap: 10px;
            padding: 13px;
        }

        .status-badge {
            margin-left: 0;
        }

        .produk-pesanan {
            padding: 5px 13px;
        }

        .produk-item {
            align-items: flex-start;
            flex-direction: column;
        }

        .produk-gambar {
            width: 65px;
            height: 65px;
        }

        .subtotal-produk {
            align-items: flex-start;
            margin-left: 80px;
            text-align: left;
        }

        .pesanan-footer {
            align-items: flex-start;
            flex-direction: column;
            padding: 16px 13px;
        }

        .btn-detail {
            width: 100%;
        }
    }
</style>
@endsection
