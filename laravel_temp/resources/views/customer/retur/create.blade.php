@extends('layouts.customer')

@section('content')
@include('partials.em-ui')

<div class="container py-5 retur-page" style="max-width: 850px">

    {{-- HEADER --}}
    <div class="em-hero mb-4">
        <h1 class="h2 mb-2">Pengajuan Retur Produk</h1>
        <p class="mb-0">
            Ajukan pengembalian produk dari pesanan ELECTROMART kamu.
        </p>
    </div>

    {{-- INFORMASI PESANAN --}}
    <div class="em-card mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3">
                <span class="em-icon-chip">
                    <i class="fa-solid fa-receipt"></i>
                </span>

                <div>
                    <div class="text-muted small">Nomor Pesanan</div>
                    <h2 class="h5 mb-1">
                        #{{ $pesanan->id_pesanan }}
                    </h2>
                    <div class="small text-muted">
                        Pilih produk yang ingin kamu ajukan untuk retur.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="em-alert em-alert-danger mb-4">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong>Periksa kembali data pengajuan kamu:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- FORM RETUR --}}
    <div class="em-card">
        <div class="card-body p-4">

            <form
                action="{{ route('pesanan-saya.retur.store', $pesanan->id_pesanan) }}"
                method="POST"
                class="em-form"
            >
                @csrf

                {{-- PILIH PRODUK --}}
                <div class="em-section-title mb-3">
                    <span class="em-icon-chip">
                        <i class="fa-solid fa-box-open"></i>
                    </span>
                    <h2>Produk yang Diretur</h2>
                </div>

                <div class="retur-product-list mb-4">
                    @forelse ($pesanan->detailPesanan as $detail)
                        @php
                            $jumlahSudahDiretur = $detail->returProduk
                                ->whereIn('status_retur', [
                                    'diajukan',
                                    'disetujui',
                                    'selesai',
                                ])
                                ->sum('jumlah_retur');

                            $sisaJumlah = max(
                                0,
                                (int) $detail->jumlah - (int) $jumlahSudahDiretur
                            );
                        @endphp

                        <label
                            class="retur-product-option {{ $sisaJumlah < 1 ? 'retur-disabled' : '' }}"
                            for="detail-{{ $detail->id_detail_pesanan }}"
                        >
                            <input
                                type="radio"
                                id="detail-{{ $detail->id_detail_pesanan }}"
                                name="id_detail_pesanan"
                                value="{{ $detail->id_detail_pesanan }}"
                                @checked(
                                    (string) old('id_detail_pesanan') ===
                                    (string) $detail->id_detail_pesanan
                                )
                                @disabled($sisaJumlah < 1)
                                required
                            >

                            <div class="retur-product-image">
                                @if ($detail->produk && $detail->produk->gambar)
                                    <img
                                        src="{{ asset('storage/' . $detail->produk->gambar) }}"
                                        alt="{{ $detail->produk->nama_produk }}"
                                    >
                                @else
                                    <i class="fa-solid fa-box"></i>
                                @endif
                            </div>

                            <div class="retur-product-info">
                                <strong>
                                    {{ $detail->produk->nama_produk ?? 'Produk tidak tersedia' }}
                                </strong>

                                <span>
                                    Jumlah dibeli:
                                    {{ $detail->jumlah }}
                                </span>

                                <span>
                                    Sisa yang dapat diretur:
                                    {{ $sisaJumlah }}
                                </span>

                                @if ($sisaJumlah < 1)
                                    <small class="retur-warning">
                                        Produk sudah tidak memiliki sisa jumlah retur.
                                    </small>
                                @endif
                            </div>

                            <span class="retur-radio-indicator">
                                <i class="fa-solid fa-check"></i>
                            </span>
                        </label>
                    @empty
                        <div class="text-muted py-3">
                            Tidak ada detail produk pada pesanan ini.
                        </div>
                    @endforelse
                </div>

                @error('id_detail_pesanan')
                    <div class="retur-field-error">{{ $message }}</div>
                @enderror

                <hr class="my-4">

                {{-- JUMLAH RETUR --}}
                <div class="em-section-title mb-3">
                    <span class="em-icon-chip">
                        <i class="fa-solid fa-calculator"></i>
                    </span>
                    <h2>Jumlah Retur</h2>
                </div>

                <div class="mb-4">
                    <label for="jumlah_retur" class="form-label">
                        Jumlah produk yang ingin diretur
                    </label>

                    <div class="em-ic">
                        <i class="fa-solid fa-hashtag"></i>
                        <input
                            type="number"
                            id="jumlah_retur"
                            name="jumlah_retur"
                            class="form-control"
                            value="{{ old('jumlah_retur', 1) }}"
                            min="1"
                            required
                        >
                    </div>

                    <small class="text-muted d-block mt-2">
                        Jumlah retur tidak boleh melebihi sisa produk yang tersedia.
                    </small>

                    @error('jumlah_retur')
                        <div class="retur-field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ALASAN RETUR --}}
                <div class="em-section-title mb-3">
                    <span class="em-icon-chip">
                        <i class="fa-solid fa-comment-dots"></i>
                    </span>
                    <h2>Alasan Pengajuan</h2>
                </div>

                <div class="mb-4">
                    <label for="alasan" class="form-label">
                        Jelaskan alasan retur
                    </label>

                    <textarea
                        id="alasan"
                        name="alasan"
                        class="form-control"
                        rows="5"
                        minlength="10"
                        maxlength="5000"
                        placeholder="Contoh: Produk yang diterima mengalami kerusakan..."
                        required
                    >{{ old('alasan') }}</textarea>

                    <small class="text-muted d-block mt-2">
                        Tuliskan alasan dengan jelas, minimal 10 karakter.
                    </small>

                    @error('alasan')
                        <div class="retur-field-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CATATAN --}}
                <div class="retur-info-note mb-4">
                    <i class="fa-solid fa-circle-info"></i>
                    <div>
                        <strong>Informasi Pengajuan</strong>
                        <p class="mb-0">
                            Setelah dikirim, pengajuan akan diperiksa oleh admin.
                            Pengajuan belum berarti retur disetujui.
                        </p>
                    </div>
                </div>

                {{-- TOMBOL --}}
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="em-btn-primary">
                        <i class="fa-solid fa-paper-plane"></i>
                        Kirim Pengajuan
                    </button>

                    <a
                        href="{{ route('pesanan-saya.show', $pesanan->id_pesanan) }}"
                        class="em-btn-ghost"
                    >
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    .retur-page {
        color: var(--em-text, #202124);
    }

    .retur-product-list {
        display: grid;
        gap: 12px;
    }

    .retur-product-option {
        position: relative;
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px;
        border: 1px solid var(--em-border, #e5e7eb);
        border-radius: 12px;
        background: var(--em-card-bg, #fff);
        cursor: pointer;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }

    .retur-product-option:hover {
        border-color: var(--em-primary, #2563eb);
    }

    .retur-product-option:has(input:checked) {
        border-color: var(--em-primary, #2563eb);
        background: var(--em-primary-soft, #eff6ff);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, .07);
    }

    .retur-product-option input[type="radio"] {
        width: 17px;
        height: 17px;
        flex-shrink: 0;
        accent-color: var(--em-primary, #2563eb);
    }

    .retur-product-image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 76px;
        height: 76px;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 10px;
        background: var(--em-surface, #f3f4f6);
        color: var(--em-muted, #6b7280);
        font-size: 25px;
    }

    .retur-product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .retur-product-info {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 5px;
        min-width: 0;
    }

    .retur-product-info strong {
        font-size: 14px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .retur-product-info span {
        color: var(--em-muted, #6b7280);
        font-size: 12px;
    }

    .retur-product-info .retur-warning {
        color: #b45309;
        font-size: 12px;
    }

    .retur-radio-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 27px;
        height: 27px;
        flex-shrink: 0;
        border-radius: 50%;
        background: var(--em-primary, #2563eb);
        color: #fff;
        font-size: 12px;
        opacity: 0;
        transform: scale(.8);
        transition: .2s;
    }

    .retur-product-option:has(input:checked) .retur-radio-indicator {
        opacity: 1;
        transform: scale(1);
    }

    .retur-product-option.retur-disabled {
        cursor: not-allowed;
        opacity: .65;
        background: var(--em-surface, #f9fafb);
    }

    .retur-info-note {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        border: 1px solid var(--em-border, #dbeafe);
        border-radius: 10px;
        background: var(--em-primary-soft, #eff6ff);
        color: var(--em-text, #1e40af);
    }

    .retur-info-note > i {
        margin-top: 3px;
        font-size: 17px;
    }

    .retur-info-note strong {
        display: block;
        margin-bottom: 5px;
        font-size: 13px;
    }

    .retur-info-note p {
        font-size: 13px;
        line-height: 1.7;
    }

    .retur-field-error {
        margin-top: 6px;
        color: #dc2626;
        font-size: 13px;
    }

    @media (max-width: 576px) {
        .retur-product-option {
            gap: 10px;
            padding: 12px;
        }

        .retur-product-image {
            width: 58px;
            height: 58px;
            font-size: 21px;
        }

        .retur-radio-indicator {
            width: 23px;
            height: 23px;
        }

        .retur-page .card-body {
            padding: 20px !important;
        }
    }
</style>
@endsection
