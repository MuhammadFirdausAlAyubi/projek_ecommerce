@extends('admin.layouts.app')

@section('title', 'Tambah Brand')
@section('breadcrumb', 'Brand / Tambah')

@section('content')
<div style="max-width:800px;background:#fff;padding:24px;border-radius:14px;border:1px solid #e5e7eb;">
    <h2 style="margin-top:0;">Tambah Brand</h2>
    <p style="color:#64748b;">Masukkan informasi merek produk.</p>

    <form action="{{ route('admin.brand.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:20px;">
            <label for="nama_brand" style="display:block;margin-bottom:8px;">
                Nama Brand <span style="color:red;">*</span>
            </label>

            <input id="nama_brand"
                   type="text"
                   name="nama_brand"
                   value="{{ old('nama_brand') }}"
                   maxlength="100"
                   required
                   placeholder="Contoh: ASUS"
                   style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;">

            @error('nama_brand')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label for="deskripsi" style="display:block;margin-bottom:8px;">
                Deskripsi
            </label>

            <textarea id="deskripsi"
                      name="deskripsi"
                      rows="4"
                      placeholder="Deskripsi brand (opsional)"
                      style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;">{{ old('deskripsi') }}</textarea>

            @error('deskripsi')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit"
                style="background:#2563eb;color:white;padding:11px 18px;border:0;border-radius:8px;cursor:pointer;">
            Simpan Brand
        </button>

        <a href="{{ route('admin.brand.index') }}"
           style="margin-left:8px;color:#64748b;text-decoration:none;">
            Batal
        </a>
    </form>
</div>
@endsection
