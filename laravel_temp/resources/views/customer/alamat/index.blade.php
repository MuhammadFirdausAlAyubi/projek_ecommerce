@extends('layouts.customer')

@section('content')
@include('partials.em-ui')

<style>
    .em-address { position: relative; transition: box-shadow .2s ease, border-color .2s ease; }
    .em-address:hover { border-color: #c7d7f5; box-shadow: 0 18px 38px -22px rgba(37, 99, 235, .35); }
    .em-address.is-main { border-color: #bcd2ff; }
    .em-address.is-main::before {
        content: "";
        position: absolute;
        left: 0;
        top: 18px;
        bottom: 18px;
        width: 4px;
        background: linear-gradient(180deg, #2563eb, #60a5fa);
        border-radius: 0 6px 6px 0;
    }
    .em-meta { display: flex; align-items: center; gap: .5rem; color: var(--em-muted); font-size: .9rem; }
    .em-meta i { width: 16px; text-align: center; color: #94a3b8; }
</style>

<div class="container py-5" style="max-width: 850px">

    <div class="em-hero mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="h2 mb-2">Alamat Pengiriman</h1>
                <p class="mb-0">
                    Kelola alamat untuk pesanan ELECTROMART kamu.
                </p>
            </div>

            <a href="{{ route('alamat.create') }}" class="em-btn-glass">
                <i class="fa-solid fa-plus"></i>
                Tambah Alamat
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="em-alert em-alert-success mb-4">
            <i class="fa-solid fa-circle-check"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="em-alert em-alert-danger mb-4">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @forelse ($alamat as $item)
        <div class="em-card em-address {{ $item->is_utama ? 'is-main' : '' }} mb-3">
            <div class="p-4 d-flex justify-content-between align-items-start gap-3">

                <div class="d-flex align-items-start gap-3" style="min-width: 0">
                    <span class="em-icon-chip em-icon-lg">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>

                    <div style="min-width: 0">
                        <h5 class="fw-bold mb-2">{{ $item->nama_penerima }}</h5>

                        @if ($item->is_utama)
                            <span class="em-badge mb-2">
                                Alamat Utama
                            </span>
                        @endif

                        <p class="mb-2">
                            <i class="fa-solid fa-phone me-2 text-secondary"></i>
                            {{ $item->no_telp_penerima }}
                        </p>

                        <p class="mb-2" style="overflow-wrap: anywhere">
                            <i class="fa-solid fa-location-dot me-2 text-secondary"></i>
                            {{ $item->alamat_lengkap }}
                        </p>

                        <p class="text-secondary mb-0">
                            {{ $item->kecamatan }},
                            {{ $item->kota }},
                            {{ $item->provinsi }},
                            {{ $item->kode_pos }}
                        </p>
                    </div>
                </div>

                <form
                    action="{{ route('alamat.destroy', $item->id_alamat) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus alamat ini?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="em-btn-danger-soft">
                        <i class="fa-solid fa-trash"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="em-card em-empty">
            <div class="em-empty-icon">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>

            <h5>Belum Ada Alamat</h5>

            <p class="text-secondary">
                Tambahkan alamat pengiriman sebelum melanjutkan checkout.
            </p>

            <a href="{{ route('alamat.create') }}" class="em-btn-primary">
                <i class="fa-solid fa-plus"></i>
                Tambah Alamat Sekarang
            </a>
        </div>
    @endforelse

    <a href="{{ route('account.profile') }}" class="em-btn-ghost mt-3">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Menu Akun
    </a>

</div>
@endsection