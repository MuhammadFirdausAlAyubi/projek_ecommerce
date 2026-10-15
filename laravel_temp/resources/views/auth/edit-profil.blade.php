
@extends('layouts.customer')

@section('content')
<div class="container py-5" style="max-width:600px">

    <h2 class="mb-2">Edit Profil</h2>
    <p class="text-secondary mb-4">
        Ubah informasi akun kamu di bawah ini.
    </p>

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

            <form method="POST" action="{{ route('account.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama lengkap</label>
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

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
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

                <div class="mb-4">
                    <label for="no_telp" class="form-label">
                        Nomor telepon
                    </label>
                    <input
                        type="text"
                        id="no_telp"
                        name="no_telp"
                        class="form-control"
                        value="{{ old('no_telp', $user->no_telp) }}"
                        maxlength="20"
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    Simpan Perubahan
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
