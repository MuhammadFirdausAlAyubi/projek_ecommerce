@extends('layouts.customer')

@section('content')
<div class="container py-5" style="max-width:500px">
    <h2 class="mb-2">Masuk ke ELECTROMART</h2>
    <p class="text-secondary">Masuk untuk mengakses akun kamu.</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-control"
                value="{{ old('email') }}"
                autocomplete="email"
                required
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-control"
                autocomplete="current-password"
                required
            >
        </div>

        <button class="btn btn-primary w-100" type="submit">
            Masuk
        </button>
    </form>

    <p class="mt-3 text-center">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sekarang</a>
    </p>
</div>
@endsection
