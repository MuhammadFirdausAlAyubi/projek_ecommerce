@extends('layouts.customer')

@section('content')
@include('partials.em-ui')

<div class="container py-5" style="max-width:600px">

    <div class="em-hero mb-4">
        <h1 class="h2 mb-2">Edit Profil</h1>
        <p class="mb-0">
            Ubah informasi akun kamu di bawah ini.
        </p>
    </div>

    @if ($errors->any())
        <div class="em-alert em-alert-danger mb-4">
            <i class="fa-solid fa-circle-exclamation"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="em-card">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('account.update') }}" class="em-form">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama lengkap</label>
                    <div class="em-ic">
                        <i class="fa-regular fa-user"></i>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="form-control"
                            value="{{ old('nama', $user->nama) }}"
                            maxlength="100"
                            required
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="em-ic">
                        <i class="fa-regular fa-envelope"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            maxlength="100"
                            required
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label for="no_telp" class="form-label">
                        Nomor telepon
                    </label>
                    <div class="em-ic">
                        <i class="fa-solid fa-phone"></i>
                        <input
                            type="text"
                            id="no_telp"
                            name="no_telp"
                            class="form-control"
                            value="{{ old('no_telp', $user->no_telp) }}"
                            maxlength="20"
                        >
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="em-btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('account.profile') }}" class="em-btn-ghost">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection