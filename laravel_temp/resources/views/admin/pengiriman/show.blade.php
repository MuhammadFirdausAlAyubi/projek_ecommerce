@extends('admin.layouts.app')

@section('title', 'Detail Pengiriman')
@section('breadcrumb', 'Detail Pengiriman')

@push('styles')
<style>
.sd-page{color:#182230}
.sd-heading{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:15px;margin-bottom:25px}
.sd-heading h2{margin:0 0 6px;font-size:25px;font-weight:800;color:#101828}
.sd-heading p{margin:0;color:#788397;font-size:13px}
.sd-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;margin-bottom:20px}
.sd-panel{background:#fff;border:1px solid #e8edf4;border-radius:15px;overflow:hidden;box-shadow:0 3px 12px #10182805;margin-bottom:20px}
.sd-header{padding:19px 22px;border-bottom:1px solid #e8edf4;font-size:15px;font-weight:800;color:#101828}
.sd-header i{color:#246bfd;margin-right:9px}
.sd-body{padding:22px}
.sd-info{width:100%;border-collapse:collapse}
.sd-info th,.sd-info td{padding:12px 0;border-bottom:1px solid #edf0f5;font-size:13px;text-align:left;vertical-align:top;overflow-wrap:anywhere}
.sd-info tr:last-child th,.sd-info tr:last-child td{border-bottom:0}
.sd-info th{width:40%;color:#788397;font-weight:600;padding-right:12px}
.sd-info td{color:#182230;font-weight:600}
.sd-status{display:inline-flex;padding:7px 11px;border-radius:20px;font-size:11px;font-weight:800}
.sd-status-menunggu{color:#b77912;background:#fff5d9}
.sd-status-dikemas{color:#7655d9;background:#f2edff}
.sd-status-dikirim{color:#246bfd;background:#edf3ff}
.sd-status-diterima{color:#13865c;background:#e8f8f0}
.sd-status-gagal{color:#d04444;background:#fff0f0}
.sd-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:0 16px;border-radius:9px;font:inherit;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer;border:1px solid transparent}
.sd-btn-primary{background:#246bfd;color:#fff}
.sd-btn-primary:hover{background:#1558e8;color:#fff}
.sd-btn-light{background:#fff;color:#526075;border-color:#e1e7f0}
.sd-btn-light:hover{background:#f5f7fb;color:#182230}
.sd-label{display:block;margin-bottom:9px;color:#526075;font-size:12px;font-weight:700}
.sd-input,.sd-select{width:100%;height:43px;padding:0 12px;border:1px solid #e1e7f0;border-radius:9px;background:#fff;color:#182230;font:inherit;font-size:13px}
.sd-input:focus,.sd-select:focus{outline:none;border-color:#246bfd;box-shadow:0 0 0 3px #246bfd15}
.sd-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.sd-field{margin-bottom:18px}
.sd-help{margin-top:7px;color:#788397;font-size:12px;line-height:1.7}
.sd-alert{padding:13px 16px;margin-bottom:20px;border-radius:10px;font-size:13px}
.sd-success{color:#13865c;background:#e8f8f0}
.sd-danger{color:#c03939;background:#fff0f0}
.sd-product-table-wrap{overflow-x:auto}
.sd-product-table{width:100%;border-collapse:collapse;white-space:nowrap}
.sd-product-table th{padding:14px 20px;background:#f8faff;color:#788397;font-size:11px;text-align:left;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #e8edf4}
.sd-product-table td{padding:16px 20px;font-size:13px;border-bottom:1px solid #edf0f5}
.sd-product-table tbody tr:last-child td{border-bottom:0}
@media(max-width:760px){.sd-grid,.sd-form-grid{grid-template-columns:1fr;gap:15px}.sd-heading h2{font-size:21px}.sd-body,.sd-header{padding:17px}.sd-form-grid{gap:0}.sd-form-actions .sd-btn{width:100%}}
</style>
@endpush

@section('content')
<div class="sd-page">
    <div class="sd-heading">
        <div>
            <h2>Pengiriman #{{ $pengiriman->id_pengiriman }}</h2>
            <p>Informasi pesanan, ekspedisi, dan pembaruan status pengiriman.</p>
        </div>
        <a href="{{ route('admin.pengiriman.index') }}" class="sd-btn sd-btn-light">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="sd-alert sd-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="sd-alert sd-danger">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <div class="sd-grid">
        <section class="sd-panel">
            <div class="sd-header"><i class="fa-solid fa-truck-fast"></i> Informasi Pengiriman</div>
            <div class="sd-body">
                <table class="sd-info">
                    <tr><th>ID Pengiriman</th><td>#{{ $pengiriman->id_pengiriman }}</td></tr>
                    <tr><th>ID Pesanan</th><td>#{{ $pengiriman->pesanan->id_pesanan ?? '-' }}</td></tr>
                    <tr><th>Ekspedisi</th><td>{{ $pengiriman->ekspedisi->nama_ekspedisi ?? '-' }}</td></tr>
                    <tr><th>Nomor Resi</th><td>{{ $pengiriman->no_resi ?: 'Belum tersedia' }}</td></tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="sd-status sd-status-{{ $pengiriman->status_pengiriman }}">
                                {{ ucfirst($pengiriman->status_pengiriman) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengiriman</th>
                        <td>{{ $pengiriman->tanggal_pengiriman ? $pengiriman->tanggal_pengiriman->format('d M Y, H:i') : 'Belum tercatat' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Diterima</th>
                        <td>{{ $pengiriman->tanggal_diterima ? $pengiriman->tanggal_diterima->format('d M Y, H:i') : 'Belum diterima' }}</td>
                    </tr>
                </table>
            </div>
        </section>

        <section class="sd-panel">
            <div class="sd-header"><i class="fa-solid fa-user"></i> Informasi Pelanggan</div>
            <div class="sd-body">
                <table class="sd-info">
                    <tr><th>Nama</th><td>{{ $pengiriman->pesanan->user->nama ?? '-' }}</td></tr>
                    <tr><th>Email</th><td>{{ $pengiriman->pesanan->user->email ?? '-' }}</td></tr>
                    <tr><th>Total Pesanan</th><td>Rp {{ number_format((float)($pengiriman->pesanan->total_harga ?? 0), 0, ',', '.') }}</td></tr>
                    <tr>
                        <th>Alamat Tujuan</th>
                        <td style="white-space:pre-line;font-weight:500">{{ $pengiriman->pesanan->alamat_pengiriman_snapshot ?? 'Alamat tidak tersedia.' }}</td>
                    </tr>
                </table>
            </div>
        </section>
    </div>

    <section class="sd-panel">
        <div class="sd-header"><i class="fa-solid fa-box-open"></i> Produk dalam Pesanan</div>
        <div class="sd-product-table-wrap">
            <table class="sd-product-table">
                <thead>
                    <tr><th>Produk</th><th>Harga Satuan</th><th>Jumlah</th><th>Subtotal</th></tr>
                </thead>
                <tbody>
                    @forelse($pengiriman->pesanan?->detailPesanan ?? [] as $detail)
                        <tr>
                            <td>
                                <strong>{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</strong>
                                <div style="color:#788397;font-size:12px;margin-top:5px">ID Produk: {{ $detail->id_produk }}</div>
                            </td>
                            <td>Rp {{ number_format((float)$detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td><strong>Rp {{ number_format((float)$detail->subtotal, 0, ',', '.') }}</strong></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="padding:30px;text-align:center;color:#788397">Tidak ada detail produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="sd-panel">
        <div class="sd-header"><i class="fa-solid fa-clipboard-check"></i> Perbarui Pengiriman</div>
        <div class="sd-body">
            <form action="{{ route('admin.pengiriman.updateStatus', $pengiriman->id_pengiriman) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="sd-form-grid">
                    <div class="sd-field">
                        <label class="sd-label" for="status_pengiriman">Status Pengiriman</label>
                        <select name="status_pengiriman" id="status_pengiriman" class="sd-select" required>
                            @foreach(['menunggu','dikemas','dikirim','diterima','gagal'] as $status)
                                <option value="{{ $status }}" @selected(old('status_pengiriman', $pengiriman->status_pengiriman) === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sd-field">
                        <label class="sd-label" for="no_resi">Nomor Resi</label>
                        <input type="text" name="no_resi" id="no_resi" class="sd-input"
                               maxlength="100" value="{{ old('no_resi', $pengiriman->no_resi) }}"
                               placeholder="Masukkan nomor resi">
                    </div>
                </div>

                <div class="sd-form-actions">
                    <button type="submit" class="sd-btn sd-btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Pengiriman
                    </button>
                </div>

                <p class="sd-help">
                    Form ini menyimpan status dan nomor resi. Tanggal pengiriman dan tanggal diterima
                    belum diubah otomatis, dan belum ada integrasi pelacakan langsung dari ekspedisi.
                </p>
            </form>
        </div>
    </section>
</div>
@endsection
