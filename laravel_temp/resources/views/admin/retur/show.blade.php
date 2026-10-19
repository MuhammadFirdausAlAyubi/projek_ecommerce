@extends('admin.layouts.app')

@section('title', 'Detail Retur')
@section('breadcrumb', 'Detail Retur')

@push('styles')
<style>
.rd-page{color:#182230}
.rd-heading{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:15px;margin-bottom:25px}
.rd-heading h2{margin:0 0 6px;font-size:25px;font-weight:800;color:#101828}
.rd-heading p{margin:0;color:#788397;font-size:13px}
.rd-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;margin-bottom:20px}
.rd-panel{background:#fff;border:1px solid #e8edf4;border-radius:15px;overflow:hidden;box-shadow:0 3px 12px #10182805;margin-bottom:20px}
.rd-header{padding:19px 22px;border-bottom:1px solid #e8edf4;font-size:15px;font-weight:800;color:#101828}
.rd-header i{color:#246bfd;margin-right:9px}
.rd-body{padding:22px}
.rd-info{width:100%;border-collapse:collapse}
.rd-info th,.rd-info td{padding:12px 0;border-bottom:1px solid #edf0f5;font-size:13px;text-align:left;vertical-align:top;overflow-wrap:anywhere}
.rd-info tr:last-child th,.rd-info tr:last-child td{border-bottom:0}
.rd-info th{width:40%;color:#788397;font-weight:600;padding-right:12px}
.rd-info td{color:#182230;font-weight:600}
.rd-text{white-space:pre-line;line-height:1.8;color:#526075;font-size:13px;overflow-wrap:anywhere}
.rd-status{display:inline-flex;padding:7px 11px;border-radius:20px;font-size:11px;font-weight:800}
.rd-status-diajukan{color:#b77912;background:#fff5d9}
.rd-status-disetujui{color:#246bfd;background:#edf3ff}
.rd-status-ditolak{color:#d04444;background:#fff0f0}
.rd-status-selesai{color:#13865c;background:#e8f8f0}
.rd-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:0 16px;border-radius:9px;font:inherit;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer;border:1px solid transparent}
.rd-btn-primary{background:#246bfd;color:#fff}
.rd-btn-primary:hover{background:#1558e8;color:#fff}
.rd-btn-light{background:#fff;color:#526075;border-color:#e1e7f0}
.rd-btn-light:hover{background:#f5f7fb;color:#182230}
.rd-label{display:block;margin-bottom:9px;color:#526075;font-size:12px;font-weight:700}
.rd-input,.rd-select,.rd-textarea{width:100%;padding:11px 12px;border:1px solid #e1e7f0;border-radius:9px;background:#fff;color:#182230;font:inherit;font-size:13px}
.rd-select{height:43px;padding-top:0;padding-bottom:0}
.rd-textarea{min-height:120px;resize:vertical;line-height:1.6}
.rd-input:focus,.rd-select:focus,.rd-textarea:focus{outline:none;border-color:#246bfd;box-shadow:0 0 0 3px #246bfd15}
.rd-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.rd-field{margin-bottom:18px}
.rd-help{margin-top:7px;color:#788397;font-size:12px;line-height:1.6}
.rd-alert{padding:13px 16px;margin-bottom:20px;border-radius:10px;font-size:13px}
.rd-success{color:#13865c;background:#e8f8f0}
.rd-danger{color:#c03939;background:#fff0f0}
@media(max-width:760px){.rd-grid,.rd-form-grid{grid-template-columns:1fr;gap:15px}.rd-heading h2{font-size:21px}.rd-body,.rd-header{padding:17px}.rd-form-grid{gap:0}.rd-form-actions .rd-btn{width:100%}}
</style>
@endpush

@section('content')
<div class="rd-page">
    <div class="rd-heading">
        <div>
            <h2>Retur #{{ $retur->id_retur }}</h2>
            <p>Periksa pengajuan, informasi produk, dan keputusan retur pelanggan.</p>
        </div>
        <a href="{{ route('admin.retur.index') }}" class="rd-btn rd-btn-light">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="rd-alert rd-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="rd-alert rd-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="rd-grid">
        <section class="rd-panel">
            <div class="rd-header"><i class="fa-solid fa-rotate-left"></i> Informasi Retur</div>
            <div class="rd-body">
                <table class="rd-info">
                    <tr><th>ID Retur</th><td>#{{ $retur->id_retur }}</td></tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>{{ $retur->tanggal_retur ? $retur->tanggal_retur->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr><th>Jumlah Retur</th><td>{{ $retur->jumlah_retur }} unit</td></tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="rd-status rd-status-{{ $retur->status_retur }}">{{ ucfirst($retur->status_retur) }}</span></td>
                    </tr>
                </table>
            </div>
        </section>

        <section class="rd-panel">
            <div class="rd-header"><i class="fa-solid fa-user"></i> Informasi Pelanggan</div>
            <div class="rd-body">
                <table class="rd-info">
                    <tr><th>Nama</th><td>{{ $retur->detailPesanan->pesanan->user->nama ?? '-' }}</td></tr>
                    <tr><th>Email</th><td>{{ $retur->detailPesanan->pesanan->user->email ?? '-' }}</td></tr>
                    <tr><th>ID Pesanan</th><td>#{{ $retur->detailPesanan->id_pesanan ?? '-' }}</td></tr>
                    <tr><th>ID Produk</th><td>{{ $retur->detailPesanan->id_produk ?? '-' }}</td></tr>
                </table>
            </div>
        </section>
    </div>

    <section class="rd-panel">
        <div class="rd-header"><i class="fa-solid fa-box-open"></i> Informasi Produk dan Alasan Retur</div>
        <div class="rd-body">
            <table class="rd-info">
                <tr>
                    <th style="width:180px">Nama Produk</th>
                    <td>{{ $retur->detailPesanan->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                </tr>
                <tr>
                    <th>Jumlah pada Pesanan</th>
                    <td>{{ $retur->detailPesanan->jumlah ?? '-' }} unit</td>
                </tr>
                <tr>
                    <th>Jumlah yang Diretur</th>
                    <td>{{ $retur->jumlah_retur }} unit</td>
                </tr>
                <tr>
                    <th>Alasan Pelanggan</th>
                    <td><div class="rd-text">{{ $retur->alasan }}</div></td>
                </tr>
                <tr>
                    <th>Keputusan Admin</th>
                    <td><div class="rd-text">{{ $retur->keputusan_admin ?: 'Belum ada catatan keputusan.' }}</div></td>
                </tr>
            </table>
        </div>
    </section>

    <section class="rd-panel">
        <div class="rd-header"><i class="fa-solid fa-clipboard-check"></i> Tinjau dan Perbarui Retur</div>
        <div class="rd-body">
            <form action="{{ route('admin.retur.updateStatus', $retur->id_retur) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="rd-form-grid">
                    <div class="rd-field">
                        <label class="rd-label" for="status_retur">Keputusan Status</label>
                        <select name="status_retur" id="status_retur" class="rd-select" required>
                            @foreach(['diajukan','disetujui','ditolak','selesai'] as $status)
                                <option value="{{ $status }}"
                                    @selected(old('status_retur', $retur->status_retur) === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="rd-help">Pilih status sesuai hasil pemeriksaan retur.</div>
                    </div>

                    <div class="rd-field">
                        <label class="rd-label" for="keputusan_admin">Catatan Keputusan Admin</label>
                        <textarea name="keputusan_admin" id="keputusan_admin"
                                  class="rd-textarea" maxlength="5000"
                                  placeholder="Tuliskan hasil pemeriksaan atau alasan keputusan...">{{ old('keputusan_admin', $retur->keputusan_admin) }}</textarea>
                    </div>
                </div>

                <div class="rd-form-actions">
                    <button type="submit" class="rd-btn rd-btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Keputusan
                    </button>
                </div>

                <p class="rd-help">
                    Perubahan ini hanya menyimpan status dan catatan admin. Proses pengembalian dana
                    maupun perubahan stok belum dijalankan secara otomatis.
                </p>
            </form>
        </div>
    </section>
</div>
@endsection
