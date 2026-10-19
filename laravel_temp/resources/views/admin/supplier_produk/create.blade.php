@extends('admin.layouts.app')

@section('title', 'Tambah Supplier Produk')
@section('breadcrumb', 'Tambah Supplier Produk')

@push('styles')
<style>
.sp-form-page { color:#182230; }
.sp-form-heading { margin-bottom:24px; }
.sp-form-heading h2 { margin:0 0 7px;font-size:27px;font-weight:800; }
.sp-form-heading p { margin:0;color:#788397;font-size:14px; }
.sp-form-card { padding:28px;background:#fff;border:1px solid #e8edf4;border-radius:17px;box-shadow:0 3px 12px #10182808; }
.sp-form-card-header { display:flex;align-items:center;gap:14px;padding-bottom:22px;margin-bottom:25px;border-bottom:1px solid #edf0f5; }
.sp-form-icon { width:48px;height:48px;display:grid;place-items:center;flex-shrink:0;border-radius:13px;background:#edf3ff;color:#246bfd;font-size:20px; }
.sp-form-card-header h3 { margin:0 0 5px;font-size:18px;font-weight:800; }
.sp-form-card-header p { margin:0;color:#788397;font-size:13px; }
.sp-form-grid { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:22px; }
.sp-form-group { min-width:0; }
.sp-form-group.full { grid-column:1/-1; }
.sp-form-label { display:block;margin-bottom:9px;color:#344054;font-size:13px;font-weight:700; }
.sp-form-control { display:block;width:100%;min-height:46px;padding:11px 14px;border:1px solid #d8e0eb;border-radius:9px;outline:none;background:#fff;color:#182230;font-family:inherit;font-size:13px; }
.sp-form-control:focus { border-color:#246bfd;box-shadow:0 0 0 3px #246bfd18; }
.sp-form-hint { display:block;margin-top:7px;color:#98a2b3;font-size:12px; }
.sp-form-error { display:block;margin-top:7px;color:#d92d20;font-size:12px; }
.sp-form-alert { margin-bottom:20px;padding:14px 17px;border:1px solid #fecdca;border-radius:10px;background:#fef3f2;color:#b42318;font-size:13px; }
.sp-form-footer { display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;margin-top:28px;padding-top:22px;border-top:1px solid #edf0f5; }
.sp-form-note { color:#788397;font-size:12px; }
.sp-form-actions { display:flex;gap:10px;flex-wrap:wrap; }
.sp-form-btn { min-height:43px;display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:0 17px;border:1px solid transparent;border-radius:9px;font-family:inherit;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer; }
.sp-form-primary { color:#fff;background:#246bfd; }
.sp-form-primary:hover { color:#fff;background:#1558df; }
.sp-form-secondary { color:#536176;background:#fff;border-color:#d8e0eb; }
.sp-form-secondary:hover { background:#f5f7fb; }
@media(max-width:650px) {
    .sp-form-card { padding:19px; }
    .sp-form-heading h2 { font-size:23px; }
    .sp-form-grid { grid-template-columns:1fr;gap:19px; }
    .sp-form-group.full { grid-column:auto; }
    .sp-form-actions { width:100%; }
    .sp-form-actions .sp-form-btn { flex:1; }
}
</style>
@endpush

@section('content')
<div class="sp-form-page">
    <div class="sp-form-heading">
        <h2>Tambah Supplier Produk</h2>
        <p>Hubungkan supplier dengan produk yang disediakannya.</p>
    </div>

    @if($errors->any())
        <div class="sp-form-alert">
            <strong><i class="fa-solid fa-circle-exclamation"></i> Data belum dapat disimpan.</strong>
            <ul style="margin:8px 0 0;padding-left:22px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="sp-form-card">
        <div class="sp-form-card-header">
            <div class="sp-form-icon"><i class="fa-solid fa-link"></i></div>
            <div>
                <h3>Informasi Supplier Produk</h3>
                <p>Pilih supplier dan produk, lalu lengkapi harga serta waktu penyediaan.</p>
            </div>
        </div>

        <form action="{{ route('admin.supplier-produk.store') }}" method="POST">
            @csrf

            <div class="sp-form-grid">
                <div class="sp-form-group">
                    <label for="id_supplier" class="sp-form-label">Supplier <span style="color:#d92d20">*</span></label>
                    <select id="id_supplier" name="id_supplier" class="sp-form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($supplier as $item)
                            <option value="{{ $item->id_supplier }}" @selected(old('id_supplier') == $item->id_supplier)>
                                {{ $item->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_supplier') <span class="sp-form-error">{{ $message }}</span> @enderror
                    @if($supplier->isEmpty())
                        <span class="sp-form-error">Belum ada supplier. Tambahkan supplier terlebih dahulu.</span>
                    @endif
                </div>

                <div class="sp-form-group">
                    <label for="id_produk" class="sp-form-label">Produk <span style="color:#d92d20">*</span></label>
                    <select id="id_produk" name="id_produk" class="sp-form-control" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produk as $item)
                            <option value="{{ $item->id_produk }}" @selected(old('id_produk') == $item->id_produk)>
                                {{ $item->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_produk') <span class="sp-form-error">{{ $message }}</span> @enderror
                    @if($produk->isEmpty())
                        <span class="sp-form-error">Belum ada produk. Tambahkan produk terlebih dahulu.</span>
                    @endif
                </div>

                <div class="sp-form-group">
                    <label for="harga_beli" class="sp-form-label">Harga Beli (Rp) <span style="color:#d92d20">*</span></label>
                    <input type="number" id="harga_beli" name="harga_beli"
                           class="sp-form-control" min="0" step="0.01"
                           value="{{ old('harga_beli') }}" placeholder="Contoh: 2500000" required>
                    <span class="sp-form-hint">Harga beli produk dari supplier.</span>
                    @error('harga_beli') <span class="sp-form-error">{{ $message }}</span> @enderror
                </div>

                <div class="sp-form-group">
                    <label for="waktu_penyediaan" class="sp-form-label">Waktu Penyediaan (Hari) <span style="color:#d92d20">*</span></label>
                    <input type="number" id="waktu_penyediaan" name="waktu_penyediaan"
                           class="sp-form-control" min="0" step="1"
                           value="{{ old('waktu_penyediaan') }}" placeholder="Contoh: 3" required>
                    <span class="sp-form-hint">Perkiraan waktu supplier menyediakan produk dalam hari.</span>
                    @error('waktu_penyediaan') <span class="sp-form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="sp-form-footer">
                <div class="sp-form-note"><span style="color:#d92d20">*</span> Wajib diisi.</div>
                <div class="sp-form-actions">
                    <a href="{{ route('admin.supplier-produk.index') }}" class="sp-form-btn sp-form-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="sp-form-btn sp-form-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
