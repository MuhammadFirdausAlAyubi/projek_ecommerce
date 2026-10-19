@extends('admin.layouts.app')

@section('title', 'Edit Ekspedisi')
@section('breadcrumb', 'Edit Ekspedisi')

@push('styles')
<style>
.ee-page{color:#182230;max-width:900px}
.ee-heading{margin-bottom:25px}
.ee-heading h2{margin:0 0 7px;font-size:25px;font-weight:800;color:#101828}
.ee-heading p{margin:0;color:#788397;font-size:13px}
.ee-panel{background:#fff;border:1px solid #e8edf4;border-radius:15px;overflow:hidden;box-shadow:0 3px 12px #10182805}
.ee-header{padding:21px 24px;border-bottom:1px solid #e8edf4;font-size:16px;font-weight:800;color:#101828}
.ee-header i{color:#246bfd;margin-right:9px}
.ee-body{padding:25px}
.ee-field{margin-bottom:22px}
.ee-label{display:block;margin-bottom:9px;font-size:13px;font-weight:700;color:#344054}
.ee-control{width:100%;height:45px;padding:0 13px;border:1px solid #e1e7f0;border-radius:9px;background:#fff;color:#182230;font:inherit;font-size:13px;outline:none}
.ee-control:focus{border-color:#246bfd;box-shadow:0 0 0 3px #246bfd15}
.ee-help{margin-top:7px;color:#788397;font-size:12px;line-height:1.6}
.ee-error{margin-top:7px;color:#d04444;font-size:12px}
.ee-alert{padding:13px 16px;margin:20px 24px 0;border-radius:10px;color:#c03939;background:#fff0f0;font-size:13px}
.ee-actions{display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;padding-top:20px;border-top:1px solid #edf0f5}
.ee-action-right{display:flex;gap:10px;flex-wrap:wrap}
.ee-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:0 16px;border-radius:9px;border:1px solid transparent;font:inherit;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer}
.ee-primary{background:#246bfd;color:#fff}
.ee-primary:hover{background:#1558e8;color:#fff}
.ee-light{background:#fff;color:#526075;border-color:#e1e7f0}
.ee-light:hover{background:#f5f7fb;color:#182230}
@media(max-width:600px){.ee-heading h2{font-size:21px}.ee-body{padding:18px}.ee-header{padding:18px}.ee-actions,.ee-action-right{flex-direction:column}.ee-actions .ee-btn,.ee-action-right .ee-btn{width:100%}}
</style>
@endpush

@section('content')
<div class="ee-page">
    <div class="ee-heading">
        <h2>Edit Ekspedisi</h2>
        <p>Perbarui informasi jasa kurir yang terdaftar di ELECTROMART.</p>
    </div>

    <section class="ee-panel">
        <div class="ee-header"><i class="fa-solid fa-pen-to-square"></i> Formulir Edit Ekspedisi</div>

        @if($errors->any())
            <div class="ee-alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="ee-body">
            <form action="{{ route('admin.ekspedisi.update', $ekspedisi->id_ekspedisi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="ee-field">
                    <label for="nama_ekspedisi" class="ee-label">Nama Ekspedisi <span style="color:#d04444">*</span></label>
                    <input type="text" id="nama_ekspedisi" name="nama_ekspedisi"
                           class="ee-control" maxlength="50" required
                           value="{{ old('nama_ekspedisi', $ekspedisi->nama_ekspedisi) }}"
                           placeholder="Masukkan nama ekspedisi">
                    <div class="ee-help">Nama ekspedisi harus unik dan maksimal 50 karakter.</div>
                    @error('nama_ekspedisi')
                        <div class="ee-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ee-field">
                    <label for="status_ekspedisi" class="ee-label">Status Ekspedisi <span style="color:#d04444">*</span></label>
                    <select id="status_ekspedisi" name="status_ekspedisi" class="ee-control" required>
                        <option value="aktif" @selected(old('status_ekspedisi', $ekspedisi->status_ekspedisi) === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status_ekspedisi', $ekspedisi->status_ekspedisi) === 'nonaktif')>Nonaktif</option>
                    </select>
                    <div class="ee-help">Jika jasa kurir tidak lagi digunakan, kamu dapat mengubah statusnya menjadi nonaktif tanpa menghapus riwayat pengiriman.</div>
                    @error('status_ekspedisi')
                        <div class="ee-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ee-actions">
                    <a href="{{ route('admin.ekspedisi.index') }}" class="ee-btn ee-light">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>

                    <div class="ee-action-right">
                        <button type="submit" class="ee-btn ee-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
