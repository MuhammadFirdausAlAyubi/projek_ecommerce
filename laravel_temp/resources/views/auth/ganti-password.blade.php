
@extends('layouts.customer')

@section('content')
<div class="container py-5" style="max-width:600px">

    <h2 class="mb-2">Ganti Password</h2>
    <p class="text-secondary mb-4">
        Masukkan password lama untuk mengatur password baru.
    </p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">
                        Password saat ini
                    </label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="form-control"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        Password baru
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                    <small class="text-secondary">
                        Minimal 8 karakter.
                    </small>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">
                        Konfirmasi password baru
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    Simpan Password Baru
                </button>

                <a href="{{ route('account.profile') }}"
                   class="btn btn-outline-secondary">
                    Batal
                </a>
            </form>

        </div>
    </div>

</div>
@endsection
