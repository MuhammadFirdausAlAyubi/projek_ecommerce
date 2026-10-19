@extends('admin.layouts.app')

@section('title', 'Detail Alamat')
@section('breadcrumb', 'Detail Alamat')

@section('content')
<style>
.alamat-detail{max-width:900px;background:#fff;border:1px solid #e8edf4;border-radius:14px;padding:24px;color:#263247}.alamat-detail-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:22px}.alamat-detail-label{font-size:12px;color:#8490a1;margin-bottom:7px}.alamat-detail-value{font-size:14px;font-weight:600;overflow-wrap:anywhere}.alamat-detail-full{grid-column:1/-1}.alamat-detail-actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:25px;padding-top:20px;border-top:1px solid #edf1f6}.alamat-btn{display:inline-flex;align-items:center;gap:7px;padding:11px 15px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:650}.alamat-back{background:#eef2f7;color:#475569}.alamat-edit{background:#2563eb;color:#fff}.alamat-badge{display:inline-block;padding:6px 10px;border-radius:20px;background:#dcfce7;color:#15803d;font-size:12px}
@media(max-width:600px){.alamat-detail-grid{grid-template-columns:1fr}.alamat-detail-full{grid-column:auto}.alamat-detail{padding:16px}}
</style>

<div class="alamat-detail">
    <h2 style="margin-top:0">Detail Alamat #{{ $alamat->id_alamat }}</h2>
    <p style="color:#8490a1;font-size:13px;margin-bottom:25px">Informasi alamat pengiriman pelanggan.</p>

    <div class="alamat-detail-grid">
        <div>
            <div class="alamat-detail-label">Nama pelanggan</div>
            <div class="alamat-detail-value">{{ $alamat->user?->nama ?? 'User tidak ditemukan' }}</div>
        </div>
        <div>
            <div class="alamat-detail-label">Email pelanggan</div>
            <div class="alamat-detail-value">{{ $alamat->user?->email ?? '-' }}</div>
        </div>
        <div>
            <div class="alamat-detail-label">Nama penerima</div>
            <div class="alamat-detail-value">{{ $alamat->nama_penerima }}</div>
        </div>
        <div>
            <div class="alamat-detail-label">Nomor telepon penerima</div>
            <div class="alamat-detail-value">{{ $alamat->no_telp_penerima }}</div>
        </div>
        <div>
            <div class="alamat-detail-label">Provinsi</div>
            <div class="alamat-detail-value">{{ $alamat->provinsi }}</div>
        </div>
        <div>
            <div class="alamat-detail-label">Kota/Kabupaten</div>
            <div class="alamat-detail-value">{{ $alamat->kota }}</div>
        </div>
        <div>
            <div class="alamat-detail-label">Kecamatan</div>
            <div class="alamat-detail-value">{{ $alamat->kecamatan }}</div>
        </div>
        <div>
            <div class="alamat-detail-label">Kode pos</div>
            <div class="alamat-detail-value">{{ $alamat->kode_pos }}</div>
        </div>
        <div class="alamat-detail-full">
            <div class="alamat-detail-label">Alamat lengkap</div>
            <div class="alamat-detail-value" style="font-weight:400;white-space:pre-line">{{ $alamat->alamat_lengkap }}</div>
        </div>
        <div>
            <div class="alamat-detail-label">Status alamat</div>
            <div class="alamat-detail-value">
                @if($alamat->is_utama)
                    <span class="alamat-badge">Alamat Utama</span>
                @else
                    Bukan alamat utama
                @endif
            </div>
        </div>
    </div>

    <div class="alamat-detail-actions">
        <a href="{{ route('admin.alamat.index') }}" class="alamat-btn alamat-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('admin.alamat.edit', $alamat->id_alamat) }}" class="alamat-btn alamat-edit">
            <i class="fa-solid fa-pen"></i> Edit Alamat
        </a>
    </div>
</div>
@endsection
