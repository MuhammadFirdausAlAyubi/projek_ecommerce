@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@push('styles')
<style>
    .page-heading {
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:18px;
        margin-bottom:27px;
    }

    .eyebrow {
        color:#246bfd;
        font-size:11px;
        font-weight:800;
        letter-spacing:1.5px;
        margin-bottom:9px;
    }

    h1 {
        font-size:clamp(25px,3vw,32px);
        line-height:1.2;
        letter-spacing:-1px;
        margin:0;
        font-weight:800;
    }

    .subtitle {
        color:#788397;
        margin:9px 0 0;
        line-height:1.6;
    }

    .date-label {
        background:white;
        border:1px solid #e8edf4;
        padding:11px 14px;
        border-radius:10px;
        color:#596579;
        white-space:nowrap;
    }

    .section-caption {
        font-size:12px;
        font-weight:800;
        letter-spacing:.7px;
        color:#7a8699;
        margin-bottom:14px;
    }

    .stats-grid {
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:17px;
        margin-bottom:22px;
    }

    .stat-card {
        background:white;
        border:1px solid #e8edf4;
        border-radius:16px;
        padding:21px;
        min-width:0;
        box-shadow:0 3px 10px #172b4d05;
    }

    .stat-top {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        margin-bottom:21px;
    }

    .stat-label { color:#667085; font-weight:600; }

    .stat-icon {
        width:43px;
        height:43px;
        border-radius:13px;
        display:grid;
        place-items:center;
        font-size:17px;
    }

    .icon-blue { color:#246bfd; background:#edf4ff; }
    .icon-green { color:#15966a; background:#e9f8f1; }
    .icon-purple { color:#7952d6; background:#f1edff; }
    .icon-orange { color:#d97706; background:#fff4df; }

    .stat-number {
        font-size:clamp(27px,2.3vw,34px);
        font-weight:800;
        letter-spacing:-1px;
        overflow-wrap:anywhere;
    }

    .stat-note { margin-top:8px; color:#8792a4; font-size:12px; }

    .panel {
        background:white;
        border:1px solid #e8edf4;
        border-radius:16px;
        overflow:hidden;
        margin-bottom:22px;
    }

    .stock-panel {
        display:flex;
        align-items:center;
        gap:15px;
        padding:20px 22px;
    }

    .stock-icon {
        width:48px;
        height:48px;
        display:grid;
        place-items:center;
        border-radius:14px;
        background:#fff4df;
        color:#c77712;
        font-size:18px;
        flex-shrink:0;
    }

    .stock-title { color:#7b8799; font-size:12px; font-weight:600; }
    .stock-number { margin-top:5px; font-size:24px; font-weight:800; }

    .panel-header {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:15px;
        padding:21px 23px;
        border-bottom:1px solid #e8edf4;
    }

    .panel-heading { display:flex; align-items:center; gap:12px; }

    .heading-icon {
        width:40px;
        height:40px;
        display:grid;
        place-items:center;
        border-radius:12px;
        background:#edf4ff;
        color:#246bfd;
        flex-shrink:0;
    }

    .panel-title { font-size:16px; font-weight:800; margin:0; }
    .panel-subtitle { font-size:12px; color:#788397; margin-top:5px; }

    .pill {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:6px 10px;
        border-radius:7px;
        font-size:11px;
        font-weight:700;
        background:#f0f2f6;
        color:#596579;
    }

    .pill-active { color:#13784e; background:#e8f8ef; }
    .pill-inactive { color:#b42332; background:#fff0f0; }

    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; white-space:nowrap; }
    thead { background:#fafbfd; }

    th {
        text-align:left;
        color:#8792a4;
        font-size:11px;
        letter-spacing:.6px;
        text-transform:uppercase;
        font-weight:800;
        padding:15px 23px;
        border-bottom:1px solid #e8edf4;
    }

    td {
        padding:17px 23px;
        border-bottom:1px solid #f0f2f6;
        color:#475467;
        font-size:13px;
    }

    tbody tr:last-child td { border-bottom:0; }
    tbody tr:hover { background:#fafcff; }
    .product-id { font-weight:700; color:#7b8799; }
    .product-name { font-weight:700; color:#202c40; }
    .product-sub { display:block; color:#98a2b3; font-size:11px; margin-top:4px; }

    .empty-state { text-align:center; padding:42px 20px; white-space:normal; }
    .empty-icon {
        width:54px;
        height:54px;
        display:grid;
        place-items:center;
        margin:0 auto 14px;
        background:#f0f4fa;
        color:#8a97aa;
        border-radius:16px;
        font-size:21px;
    }

    .footer { text-align:center; padding:18px; color:#98a2b3; font-size:12px; }
    .footer strong { color:#667085; }

    @media(max-width:1200px) {
        .stats-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
    }

    @media(max-width:768px) {
        .page-heading { flex-direction:column; }
        .date-label { display:none; }
        .stat-card { padding:15px; }
        .panel-header { padding:17px; }
        th,td { padding:14px 16px; }
    }

    @media(max-width:380px) {
        .stats-grid { grid-template-columns:1fr; }
    }
</style>
@endpush

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">ELECTROMART ADMIN PANEL</div>
            <h1>Dashboard Overview</h1>
            <p class="subtitle">
                Halo, {{ auth()->user()->nama ?? 'Administrator' }}.
                Pantau pengelolaan toko elektronik kamu dari sini.
            </p>
        </div>

        <div class="date-label">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    <div class="section-caption">Ringkasan toko</div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Produk</span>
                <span class="stat-icon icon-blue"><i class="fa-solid fa-box"></i></span>
            </div>
            <div class="stat-number">{{ number_format($totalProduk,0,',','.') }}</div>
            <div class="stat-note">Produk terdaftar di katalog</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Kategori</span>
                <span class="stat-icon icon-green"><i class="fa-solid fa-layer-group"></i></span>
            </div>
            <div class="stat-number">{{ number_format($totalKategori,0,',','.') }}</div>
            <div class="stat-note">Kategori produk elektronik</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Brand</span>
                <span class="stat-icon icon-purple"><i class="fa-solid fa-tags"></i></span>
            </div>
            <div class="stat-number">{{ number_format($totalBrand,0,',','.') }}</div>
            <div class="stat-note">Merek yang tersedia</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Pelanggan</span>
                <span class="stat-icon icon-orange"><i class="fa-solid fa-users"></i></span>
            </div>
            <div class="stat-number">{{ number_format($totalPelanggan,0,',','.') }}</div>
            <div class="stat-note">Akun dengan role pelanggan</div>
        </div>
    </div>

    <section class="panel">
        <div class="stock-panel">
            <div class="stock-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div>
                <div class="stock-title">Produk dengan stok menipis</div>
                <div class="stock-number">
                    {{ number_format($totalStokMenipis,0,',','.') }}
                    <span style="font-size:13px;font-weight:500;color:#8792a4">baris stok</span>
                </div>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-heading">
                <div class="heading-icon"><i class="fa-solid fa-box-open"></i></div>
                <div>
                    <h2 class="panel-title">Produk Terbaru</h2>
                    <div class="panel-subtitle">Lima produk terakhir yang tercatat di katalog.</div>
                </div>
            </div>
            <span class="pill">{{ $produkTerbaru->count() }} produk</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Brand</th>
                        <th>Harga Jual</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkTerbaru as $produk)
                        @php
                            $status = strtolower((string) $produk->status_produk);
                        @endphp
                        <tr>
                            <td><span class="product-id">#{{ $produk->id_produk }}</span></td>
                            <td>
                                <span class="product-name">{{ $produk->nama_produk }}</span>
                                <span class="product-sub">ELECTROMART product catalog</span>
                            </td>
                            <td>{{ $produk->nama_kategori ?? '-' }}</td>
                            <td>{{ $produk->nama_brand ?? '-' }}</td>
                            <td style="font-weight:700;color:#202c40">
                                Rp {{ number_format($produk->harga_jual,0,',','.') }}
                            </td>
                            <td>
                                <span class="pill {{ in_array($status,['aktif','active','tersedia']) ? 'pill-active' : (in_array($status,['nonaktif','inactive']) ? 'pill-inactive' : '') }}">
                                    {{ $produk->status_produk ?? 'Belum diatur' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fa-solid fa-box-open"></i></div>
                                    <strong>Belum ada produk</strong>
                                    <p>Produk yang ditambahkan akan tampil di sini.</p>
                                    <a href="{{ route('admin.produk.create') }}" style="color:#246bfd;font-weight:700">
                                        Tambah produk pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <footer class="footer">
        © {{ date('Y') }} <strong>ELECTROMART</strong> · Admin Panel
    </footer>
@endsection
