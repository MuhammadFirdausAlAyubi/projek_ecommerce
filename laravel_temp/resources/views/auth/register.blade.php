@extends('layouts.customer')

@section('content')
<div class="container py-5" style="max-width:500px">
    <h2 class="mb-2">Buat Akun</h2>
    <p class="text-secondary">Daftar sebagai pelanggan ELECTROMART.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.process') }}">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama lengkap</label>
            <input
                id="nama"
                name="nama"
                type="text"
                class="form-control"
                value="{{ old('nama') }}"
                maxlength="100"
                autocomplete="name"
                required
            >
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-control"
                value="{{ old('email') }}"
                maxlength="100"
                autocomplete="email"
                required
            >
        </div>

        <div class="mb-3">
            <label for="no_telp" class="form-label">
                Nomor telepon (opsional)
            </label>
            <input
                id="no_telp"
                name="no_telp"
                type="text"
                class="form-control"
                value="{{ old('no_telp') }}"
                maxlength="20"
                autocomplete="tel"
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-control"
                minlength="8"
                autocomplete="new-password"
                required
            >
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">
                Konfirmasi password
            </label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control"
                minlength="8"
                autocomplete="new-password"
                required
            >
        </div>

        <button class="btn btn-primary w-100" type="submit">
            Daftar
        </button>
    </form>

    <p class="mt-3 text-center">
        Sudah punya akun?
        <a href="{{ route('login') }}">Masuk</a>
    </p>
</div>
@endsection
