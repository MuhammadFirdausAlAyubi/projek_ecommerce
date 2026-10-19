@extends('admin.layouts.app')

@section('title', 'Tambah Ekspedisi')
@section('breadcrumb', 'Tambah Ekspedisi')

@push('styles')
<style>
.ef-page{color:#182230;max-width:900px}
.ef-heading{margin-bottom:25px}
.ef-heading h2{margin:0 0 7px;font-size:25px;font-weight:800;color:#101828}
.ef-heading p{margin:0;color:#788397;font-size:13px}
.ef-panel{background:#fff;border:1px solid #e8edf4;border-radius:15px;overflow:hidden;box-shadow:0 3px 12px #10182805}
.ef-header{padding:21px 24px;border-bottom:1px solid #e8edf4;font-size:16px;font-weight:800;color:#101828}
.ef-header i{color:#246bfd;margin-right:9px}
.ef-body{padding:25px}
.ef-field{margin-bottom:22px}
.ef-label{display:block;margin-bottom:9px;font-size:13px;font-weight:700;color:#344054}
.ef-control{width:100%;height:45px;padding:0 13px;border:1px solid #e1e7f0;border-radius:9px;background:#fff;color:#182230;font:inherit;font-size:13px;outline:none}
.ef-control:focus{border-color:#246bfd;box-shadow:0 0 0 3px #246bfd15}
.ef-help{margin-top:7px;color:#788397;font-size:12px;line-height:1.6}
.ef-error{margin-top:7px;color:#d04444;font-size:12px}
.ef-alert{padding:13px 16px;margin:20px 24px 0;border-radius:10px;color:#c03939;background:#fff0f0;font-size:13px}
.ef-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;padding-top:20px;border-top:1px solid #edf0f5}
.ef-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:0 16px;border-radius:9px;border:1px solid transparent;font:inherit;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer}
.ef-primary{background:#246bfd;color:#fff}
.ef-primary:hover{background:#1558e8;color:#fff}
.ef-light{background:#fff;color:#526075;border-color:#e1e7f0}
.ef-light:hover{background:#f5f7fb;color:#182230}
@media(max-width:600px){.ef-heading h2{font-size:21px}.ef-body{padding:18px}.ef-header{padding:18px}.ef-actions{flex-direction:column-reverse}.ef-actions .ef-btn{width:100%}}
</style>
@endpush

@section('content')
<div class="ef-page">
    <div class="ef-heading">
        <h2>Tambah Ekspedisi</h2>
        <p>Tambahkan jasa kurir untuk mendukung proses pengiriman pesanan.</p>
    </div>

    <section class="ef-panel">
        <div class="ef-header"><i class="fa-solid fa-truck-fast"></i> Formulir Ekspedisi</div>

        @if($errors->any())
            <div class="ef-alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="ef-body">
            <form action="{{ route('admin.ekspedisi.store') }}" method="POST">
                @csrf

                <div class="ef-field">
                    <label for="nama_ekspedisi" class="ef-label">Nama Ekspedisi <span style="color:#d04444">*</span></label>
                    <input type="text" id="nama_ekspedisi" name="nama_ekspedisi"
                           class="ef-control" maxlength="50" required
                           value="{{ old('nama_ekspedisi') }}"
                           placeholder="Contoh: JNE, J&T Express">
                    <div class="ef-help">Nama ekspedisi wajib diisi dan tidak boleh sama dengan data yang sudah ada.</div>
                    @error('nama_ekspedisi')
                        <div class="ef-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ef-field">
                    <label for="status_ekspedisi" class="ef-label">Status Ekspedisi <span style="color:#d04444">*</span></label>
                    <select id="status_ekspedisi" name="status_ekspedisi" class="ef-control" required>
                        <option value="aktif" @selected(old('status_ekspedisi', 'aktif') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status_ekspedisi') === 'nonaktif')>Nonaktif</option>
                    </select>
                    <div class="ef-help">Ekspedisi aktif dapat dipilih untuk penggunaan operasional sesuai alur aplikasi.</div>
                    @error('status_ekspedisi')
                        <div class="ef-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ef-actions">
                    <a href="{{ route('admin.ekspedisi.index') }}" class="ef-btn ef-light">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="ef-btn ef-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Ekspedisi
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
