@extends('layouts.customer')

@section('content')
<div class="container py-5" style="max-width:850px">

    <h2 class="mb-2">Menu Akun</h2>
    <p class="text-secondary mb-4">
        Halo, {{ $user->nama }}! Kelola informasi akun ELECTROMART kamu.
    </p>

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

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- PROFIL SAYA --}}
    <div class="card mb-4">
        <div class="card-body p-4">
            <h5 class="mb-4">Profil Saya</h5>

            <div class="mb-3">
                <label class="form-label text-secondary">Nama lengkap</label>
                <p class="fw-semibold mb-0">{{ $user->nama }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary">Email</label>
                <p class="fw-semibold mb-0">{{ $user->email }}</p>
            </div>

            <div class="mb-4">
                <label class="form-label text-secondary">Nomor telepon</label>
                <p class="fw-semibold mb-0">
                    {{ $user->no_telp ?: 'Belum diisi' }}
                </p>
            </div>

            <a href="{{ route('account.edit') }}" class="btn btn-primary">
                <i class="fa-solid fa-user-pen me-1"></i>
                Edit Profil
            </a>
        </div>
    </div>

    {{-- ALAMAT PENGIRIMAN --}}
    <div class="card mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-start gap-3 mb-3">
                <div class="text-primary fs-3">
                    <i class="fa-solid fa-location-dot"></i>
                </div>

                <div>
                    <h5 class="mb-2">Alamat Pengiriman</h5>
                    <p class="text-secondary mb-0">
                        Kelola alamat tujuan pengiriman pesanan ELECTROMART kamu.
                    </p>
                </div>
            </div>

            <a href="{{ route('alamat.index') }}" class="btn btn-primary">
                <i class="fa-solid fa-map-location-dot me-1"></i>
                Kelola Alamat
            </a>
        </div>
    </div>

    {{-- KEAMANAN AKUN --}}
    <div class="card mb-4">
        <div class="card-body p-4">
            <h5 class="mb-2">Keamanan Akun</h5>
            <p class="text-secondary">
                Ubah password secara berkala untuk menjaga keamanan akun.
            </p>

            <a href="{{ route('password.edit') }}" class="btn btn-outline-primary">
                <i class="fa-solid fa-key me-1"></i>
                Ganti Password
            </a>
        </div>
    </div>

    {{-- LOGOUT --}}
    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-2">Logout</h5>
            <p class="text-secondary">
                Keluar dari akun ELECTROMART kamu.
            </p>

            <form method="POST"
                  action="{{ route('logout') }}"
                  onsubmit="return confirm('Yakin ingin logout?')">
                @csrf

                <button type="submit" class="btn btn-outline-danger">
                    <i class="fa-solid fa-right-from-bracket me-1"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
