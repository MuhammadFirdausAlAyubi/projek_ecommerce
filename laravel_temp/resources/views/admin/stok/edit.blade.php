@extends('admin.layouts.app')

@section('title', 'Edit Stok')
@section('breadcrumb', 'Stok / Edit')

@section('content')
<div style="max-width:750px;background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:24px;">
    <h2 style="margin-top:0;">Perbarui Stok Produk</h2>

    <p style="color:#64748b;">
        Produk: <strong>{{ $stok->nama_produk }}</strong>
    </p>

    <form action="{{ route('admin.stok.update', $stok->id_stok) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:20px;">
            <label for="jumlah_stok"
                   style="display:block;margin-bottom:8px;">
                Jumlah Stok Saat Ini
            </label>

            <input id="jumlah_stok"
                   type="number"
                   name="jumlah_stok"
                   min="0"
                   required
                   value="{{ old('jumlah_stok', $stok->jumlah_stok) }}"
                   style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;">

            @error('jumlah_stok')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom:24px;">
            <label for="stok_minimum"
                   style="display:block;margin-bottom:8px;">
                Batas Minimum Stok
            </label>

            <input id="stok_minimum"
                   type="number"
                   name="stok_minimum"
                   min="0"
                   required
                   value="{{ old('stok_minimum', $stok->stok_minimum) }}"
                   style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;">

            @error('stok_minimum')
                <small style="color:red;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit"
                style="background:#2563eb;color:#fff;padding:11px 18px;border:0;border-radius:8px;cursor:pointer;">
            Simpan Perubahan
        </button>

        <a href="{{ route('admin.stok.index') }}"
           style="margin-left:8px;color:#64748b;text-decoration:none;">
            Kembali
        </a>
    </form>
</div>
@endsection
