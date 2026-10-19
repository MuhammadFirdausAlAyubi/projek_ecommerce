@extends('layouts.customer')

@section('content')
<div class="container py-5" style="max-width: 850px">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-2">Alamat Pengiriman</h2>
            <p class="text-secondary mb-0">
                Kelola alamat untuk pesanan ELECTROMART kamu.
            </p>
        </div>

        <a href="{{ route('alamat.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i>
            Tambah Alamat
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @forelse ($alamat as $item)
        <div class="card mb-3">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h5 class="mb-2">{{ $item->nama_penerima }}</h5>

                        @if ($item->is_utama)
                            <span class="badge bg-primary mb-2">
                                Alamat Utama
                            </span>
                        @endif

                        <p class="mb-2">
                            <i class="fa-solid fa-phone me-2 text-secondary"></i>
                            {{ $item->no_telp_penerima }}
                        </p>

                        <p class="mb-2">
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

                    <form
                        action="{{ route('alamat.destroy', $item->id_alamat) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus alamat ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fa-solid fa-trash me-1"></i>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fa-solid fa-map-location-dot fa-3x text-secondary mb-3"></i>

                <h5>Belum Ada Alamat</h5>

                <p class="text-secondary">
                    Tambahkan alamat pengiriman sebelum melanjutkan checkout.
                </p>

                <a href="{{ route('alamat.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-1"></i>
                    Tambah Alamat Sekarang
                </a>
            </div>
        </div>
    @endforelse

    <a href="{{ route('account.profile') }}"
       class="btn btn-outline-secondary mt-3">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Kembali ke Menu Akun
    </a>

</div>
@endsection
