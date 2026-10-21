@extends('layouts.customer')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .em-account {
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --navy: #0b1b3a;
        --ink: #14213d;
        --muted: #6b7a90;
        --line: #e6ebf3;
        --soft: #eef4ff;

        background: #f4f7fc;
        color: var(--ink);
        padding: 28px 0 56px;
        min-height: 70vh;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
    }
    .em-account *, .em-account *::before, .em-account *::after { box-sizing: border-box; }
    .em-wrap { width: min(960px, calc(100% - 32px)); margin: 0 auto; }

    /* HERO PROFIL */
    .em-hero {
        position: relative; overflow: hidden;
        display: flex; align-items: center; gap: 22px;
        padding: 30px 32px; margin-bottom: 22px; border-radius: 20px; color: #fff;
        background: linear-gradient(120deg, #0b1b3a 0%, #1e40af 55%, #2563eb 100%);
        box-shadow: 0 14px 34px rgba(37, 99, 235, .22);
    }
    .em-hero::before, .em-hero::after { content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.07); pointer-events: none; }
    .em-hero::before { width: 260px; height: 260px; right: -60px; top: -110px; }
    .em-hero::after  { width: 150px; height: 150px; right: 170px; bottom: -90px; background: rgba(56,189,248,.16); }

    .em-avatar {
        position: relative; z-index: 1; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        width: 76px; height: 76px; border-radius: 24px;
        background: #fff; color: var(--blue-dark); font-size: 32px; font-weight: 800;
        box-shadow: 0 8px 20px rgba(0,0,0,.2);
    }
    .em-hero-text { position: relative; z-index: 1; min-width: 0; }
    .em-hero h1 { margin: 0 0 6px; font-size: 26px; font-weight: 800; line-height: 1.3; overflow-wrap: anywhere; }
    .em-hero p { margin: 0; color: rgba(255,255,255,.78); font-size: 14px; overflow-wrap: anywhere; }

    /* ALERT */
    .em-alert { display: flex; align-items: flex-start; gap: 10px; padding: 13px 16px; margin-bottom: 16px; border: 1px solid transparent; border-radius: 12px; font-size: 13px; }
    .em-alert.success { border-color: #b7ebcb; background: #edfbf2; color: #137344; }
    .em-alert.error { border-color: #ffd0cb; background: #fff2f0; color: #b42318; }

    /* KARTU */
    .em-card { overflow: hidden; margin-bottom: 20px; border: 1px solid var(--line); border-radius: 18px; background: #fff; box-shadow: 0 6px 22px rgba(20,33,61,.05); }
    .em-card-head { display: flex; align-items: center; gap: 12px; padding: 18px 24px; border-bottom: 1px solid var(--line); }
    .em-card-head h2 { margin: 0; font-size: 16px; font-weight: 800; color: var(--navy); }
    .em-ico { display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; width: 38px; height: 38px; border-radius: 12px; background: var(--soft); color: var(--blue); font-size: 15px; }
    .em-ico.danger { background: #ffeceb; color: #d14343; }
    .em-card-body { padding: 22px 24px; }
    .em-card-body > p { margin: 0 0 16px; color: var(--muted); font-size: 14px; line-height: 1.7; }

    /* DATA PROFIL */
    .em-fields { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
    .em-field { padding: 14px 16px; border: 1px solid var(--line); border-radius: 14px; background: #f8faff; min-width: 0; }
    .em-field small { display: flex; align-items: center; gap: 7px; margin-bottom: 6px; color: #8a97ab; font-size: 12px; font-weight: 600; }
    .em-field strong { display: block; font-size: 14px; font-weight: 700; color: var(--navy); overflow-wrap: anywhere; }
    .em-field strong.empty { color: #9aa6b8; font-weight: 500; }

    /* TOMBOL */
    .em-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 9px;
        padding: 12px 20px; border-radius: 12px; border: 1.5px solid transparent;
        font: inherit; font-size: 13px; font-weight: 700; text-decoration: none; cursor: pointer; transition: .2s ease;
    }
    .em-btn.primary { background: linear-gradient(120deg, #1d4ed8, #2563eb); color: #fff; box-shadow: 0 8px 18px rgba(37,99,235,.25); }
    .em-btn.primary:hover { transform: translateY(-2px); color: #fff; }
    .em-btn.outline { background: #fff; border-color: var(--blue); color: var(--blue); }
    .em-btn.outline:hover { background: var(--blue); color: #fff; }
    .em-btn.danger { background: #fff; border-color: #f0b8b4; color: #c23a3a; }
    .em-btn.danger:hover { background: #d14343; border-color: #d14343; color: #fff; }

    .em-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .em-grid .em-card { margin-bottom: 0; display: flex; flex-direction: column; }
    .em-grid .em-card-body { flex: 1; display: flex; flex-direction: column; align-items: flex-start; }
    .em-grid .em-card-body > p { flex: 1; }
    .em-stack { margin-top: 20px; }

    .em-shortcuts { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-bottom: 20px; }
    .em-shortcut {
        display: flex; align-items: center; gap: 14px; padding: 16px 18px;
        border: 1px solid var(--line); border-radius: 16px; background: #fff;
        color: var(--navy); text-decoration: none; transition: .2s ease;
    }
    .em-shortcut:hover { border-color: #bcd0f7; box-shadow: 0 10px 24px rgba(37,99,235,.1); transform: translateY(-2px); color: var(--navy); }
    .em-shortcut b { display: block; font-size: 14px; font-weight: 800; }
    .em-shortcut span { color: var(--muted); font-size: 12px; }
    .em-shortcut .chev { margin-left: auto; color: #9aa6b8; font-size: 12px; }

    @media (max-width: 760px) {
        .em-account { padding: 18px 0 40px; }
        .em-hero { padding: 22px 20px; gap: 16px; }
        .em-avatar { width: 62px; height: 62px; border-radius: 20px; font-size: 26px; }
        .em-hero h1 { font-size: 21px; }
        .em-fields { grid-template-columns: 1fr; }
        .em-grid, .em-shortcuts { grid-template-columns: 1fr; }
        .em-card-head { padding: 16px 18px; }
        .em-card-body { padding: 18px; }
        .em-btn { width: 100%; }
    }
</style>

<div class="em-account">
    <div class="em-wrap">

        {{-- HERO PROFIL --}}
        <header class="em-hero">
            <div class="em-avatar">{{ mb_strtoupper(mb_substr($user->nama, 0, 1)) }}</div>

            <div class="em-hero-text">
                <h1>Halo, {{ $user->nama }}!</h1>
                <p>Kelola informasi akun ELECTROMART kamu di sini.</p>
            </div>
        </header>

        {{-- NOTIFIKASI --}}
        @if (session('success'))
            <div class="em-alert success"><i class="fa-solid fa-circle-check"></i> <div>{{ session('success') }}</div></div>
        @endif

        @if (session('error'))
            <div class="em-alert error"><i class="fa-solid fa-circle-exclamation"></i> <div>{{ session('error') }}</div></div>
        @endif

        @if ($errors->any())
            <div class="em-alert error"><i class="fa-solid fa-circle-exclamation"></i> <div>{{ $errors->first() }}</div></div>
        @endif

        {{-- PROFIL SAYA --}}
        <section class="em-card">
            <div class="em-card-head">
                <span class="em-ico"><i class="fa-solid fa-user"></i></span>
                <h2>Profil Saya</h2>
            </div>

            <div class="em-card-body">
                <div class="em-fields">
                    <div class="em-field">
                        <small><i class="fa-solid fa-id-card"></i> Nama lengkap</small>
                        <strong>{{ $user->nama }}</strong>
                    </div>

                    <div class="em-field">
                        <small><i class="fa-solid fa-envelope"></i> Email</small>
                        <strong>{{ $user->email }}</strong>
                    </div>

                    <div class="em-field">
                        <small><i class="fa-solid fa-phone"></i> Nomor telepon</small>
                        @if ($user->no_telp)
                            <strong>{{ $user->no_telp }}</strong>
                        @else
                            <strong class="empty">Belum diisi</strong>
                        @endif
                    </div>
                </div>

                <a href="{{ route('account.edit') }}" class="em-btn primary">
                    <i class="fa-solid fa-user-pen"></i> Edit Profil
                </a>
            </div>
        </section>

        {{-- PINTASAN --}}
        <div class="em-shortcuts">
            <a href="{{ route('pesanan-saya.index') }}" class="em-shortcut">
                <span class="em-ico"><i class="fa-solid fa-receipt"></i></span>
                <div>
                    <b>Pesanan Saya</b>
                    <span>Pantau status dan riwayat belanja</span>
                </div>
                <i class="fa-solid fa-chevron-right chev"></i>
            </a>

            <a href="{{ route('alamat.index') }}" class="em-shortcut">
                <span class="em-ico"><i class="fa-solid fa-location-dot"></i></span>
                <div>
                    <b>Alamat Pengiriman</b>
                    <span>Kelola alamat tujuan pesanan</span>
                </div>
                <i class="fa-solid fa-chevron-right chev"></i>
            </a>
        </div>

        <div class="em-grid">

            {{-- ALAMAT PENGIRIMAN --}}
            <section class="em-card">
                <div class="em-card-head">
                    <span class="em-ico"><i class="fa-solid fa-map-location-dot"></i></span>
                    <h2>Alamat Pengiriman</h2>
                </div>

                <div class="em-card-body">
                    <p>Kelola alamat tujuan pengiriman pesanan ELECTROMART kamu.</p>

                    <a href="{{ route('alamat.index') }}" class="em-btn primary">
                        <i class="fa-solid fa-map-location-dot"></i> Kelola Alamat
                    </a>
                </div>
            </section>

            {{-- KEAMANAN AKUN --}}
            <section class="em-card">
                <div class="em-card-head">
                    <span class="em-ico"><i class="fa-solid fa-shield-halved"></i></span>
                    <h2>Keamanan Akun</h2>
                </div>

                <div class="em-card-body">
                    <p>Ubah password secara berkala untuk menjaga keamanan akun.</p>

                    <a href="{{ route('password.edit') }}" class="em-btn outline">
                        <i class="fa-solid fa-key"></i> Ganti Password
                    </a>
                </div>
            </section>

        </div>

        {{-- LOGOUT --}}
        <section class="em-card em-stack">
            <div class="em-card-head">
                <span class="em-ico danger"><i class="fa-solid fa-right-from-bracket"></i></span>
                <h2>Logout</h2>
            </div>

            <div class="em-card-body">
                <p>Keluar dari akun ELECTROMART kamu.</p>

                <form method="POST"
                      action="{{ route('logout') }}"
                      onsubmit="return confirm('Yakin ingin logout?')">
                    @csrf

                    <button type="submit" class="em-btn danger">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </section>

    </div>
</div>

@endsection