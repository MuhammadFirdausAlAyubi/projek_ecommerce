<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | ELECTROMART Admin</title>

    {{-- Master layout ini menggunakan AdminLTE 3 seperti class sidebar yang kamu kirim. --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f5f7fb; }
        .main-sidebar { background: #101828; }
        .brand-link { border-bottom: 1px solid #293447 !important; padding: 18px 16px; }
        .brand-text { font-weight: 800 !important; letter-spacing: -.4px; }
        .brand-text span { color: #7da7ff; }
        .sidebar .nav-link { margin: 3px 10px; border-radius: 7px; color: #cbd5e1; }
        .sidebar .nav-link.active { background: #155eef !important; color: #fff !important; box-shadow: none; }
        .sidebar .nav-link:hover:not(.active) { background: #1d2939; color: #fff; }
        .nav-sidebar .nav-header { color: #98a2b3; font-size: 10px; letter-spacing: 1px; padding: 18px 20px 7px; }
        .main-header { border-bottom: 1px solid #e6eaf0; }
        .content-wrapper { background: #f5f7fb; }
        .content-header h1 { font-size: 24px; font-weight: 800; color: #172033; }
        .content { padding-bottom: 28px; }
        .card { border: 1px solid #e6eaf0; border-radius: 12px; box-shadow: 0 4px 18px #17203308; }
        .card-header { background: #fff; border-bottom: 1px solid #eef1f5; border-radius: 12px 12px 0 0 !important; }
        .main-footer { font-size: 12px; color: #667085; background: #fff; border-top: 1px solid #e6eaf0; }
        @stack('styles')
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Buka/tutup menu"><i class="fas fa-bars"></i></a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-flex align-items-center mr-3 small text-muted">Panel Administrasi ELECTROMART</li>
            <li class="nav-item"><a href="{{ url('/') }}" class="nav-link" title="Lihat toko"><i class="fas fa-external-link-alt"></i></a></li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-2">
        <a href="{{ url('/admin') }}" class="brand-link">
            <span class="brand-text font-weight-light">ELECTRO<span>MART</span></span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <div class="image"><span class="d-flex align-items-center justify-content-center rounded-circle bg-primary" style="width:34px;height:34px"><i class="fas fa-user text-white"></i></span></div>
                <div class="info"><span class="d-block text-white">{{ auth()->user()->name ?? 'Administrator' }}</span><small class="text-muted">Admin Toko</small></div>
            </div>
            @include('layouts.sidebar')
        </div>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h1 class="m-0">@yield('page_heading', 'Dashboard')</h1>
                    <ol class="breadcrumb float-sm-right mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                        <li class="breadcrumb-item active">@yield('page_heading', 'Dashboard')</li>
                    </ol>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>&copy; {{ date('Y') }} ELECTROMART.</strong> Panel administrasi toko elektronik.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>
