@extends('admin.layouts.app')

@section('title', 'Tambah Bank')
@section('breadcrumb', 'Tambah Bank')

@push('styles')
<style>
.bf-page{max-width:900px;color:#182230}
.bf-heading{margin-bottom:25px}
.bf-heading h2{margin:0 0 7px;font-size:25px;font-weight:800;color:#101828}
.bf-heading p{margin:0;color:#788397;font-size:13px}
.bf-panel{background:#fff;border:1px solid #e8edf4;border-radius:15px;overflow:hidden;box-shadow:0 3px 12px #10182805}
.bf-header{padding:21px 24px;border-bottom:1px solid #e8edf4;font-size:16px;font-weight:800;color:#101828}
.bf-header i{color:#246bfd;margin-right:9px}
.bf-body{padding:25px}
.bf-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.bf-field{margin-bottom:22px}
.bf-label{display:block;margin-bottom:9px;font-size:13px;font-weight:700;color:#344054}
.bf-control{width:100%;height:45px;padding:0 13px;border:1px solid #e1e7f0;border-radius:9px;background:#fff;color:#182230;font:inherit;font-size:13px;outline:none}
.bf-control:focus{border-color:#246bfd;box-shadow:0 0 0 3px #246bfd15}
.bf-help{margin-top:7px;color:#788397;font-size:12px;line-height:1.6}
.bf-error{margin-top:7px;color:#d04444;font-size:12px}
.bf-alert{padding:13px 16px;margin:20px 24px 0;border-radius:10px;color:#c03939;background:#fff0f0;font-size:13px}
.bf-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;padding-top:20px;border-top:1px solid #edf0f5}
.bf-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:0 16px;border-radius:9px;border:1px solid transparent;font:inherit;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer}
.bf-primary{background:#246bfd;color:#fff}
.bf-primary:hover{background:#1558e8;color:#fff}
.bf-light{background:#fff;color:#526075;border-color:#e1e7f0}
.bf-light:hover{background:#f5f7fb;color:#182230}
@media(max-width:600px){.bf-heading h2{font-size:21px}.bf-body{padding:18px}.bf-header{padding:18px}.bf-grid{grid-template-columns:1fr;gap:0}.bf-actions{flex-direction:column-reverse}.bf-actions .bf-btn{width:100%}}
</style>
@endpush

@section('content')
<div class="bf-page">
    <div class="bf-heading">
        <h2>Tambah Bank</h2>
        <p>Masukkan informasi rekening bank yang akan dikelola di ELECTROMART.</p>
    </div>

    <section class="bf-panel">
        <div class="bf-header"><i class="fa-solid fa-building-columns"></i> Formulir Bank</div>

        @if($errors->any())
            <div class="bf-alert">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <div class="bf-body">
            <form action="{{ route('admin.bank.store') }}" method="POST">
                @csrf

                <div class="bf-grid">
                    <div class="bf-field">
                        <label for="nama_bank" class="bf-label">Nama Bank <span style="color:#d04444">*</span></label>
                        <input type="text" id="nama_bank" name="nama_bank" class="bf-control"
                               maxlength="100" required value="{{ old('nama_bank') }}"
                               placeholder="Contoh: BCA, BRI, Mandiri">
                        <div class="bf-help">Maksimal 100 karakter.</div>
                        @error('nama_bank')<div class="bf-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="bf-field">
                        <label for="no_rekening" class="bf-label">Nomor Rekening <span style="color:#d04444">*</span></label>
                        <input type="text" id="no_rekening" name="no_rekening" class="bf-control"
                               maxlength="50" required value="{{ old('no_rekening') }}"
                               placeholder="Masukkan nomor rekening">
                        <div class="bf-help">Masukkan nomor rekening sesuai data bank.</div>
                        @error('no_rekening')<div class="bf-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="bf-grid">
                    <div class="bf-field">
                        <label for="atas_nama" class="bf-label">Atas Nama <span style="color:#d04444">*</span></label>
                        <input type="text" id="atas_nama" name="atas_nama" class="bf-control"
                               maxlength="100" required value="{{ old('atas_nama') }}"
                               placeholder="Nama pemilik rekening">
                        @error('atas_nama')<div class="bf-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="bf-field">
                        <label for="status_bank" class="bf-label">Status Bank <span style="color:#d04444">*</span></label>
                        <select id="status_bank" name="status_bank" class="bf-control" required>
                            <option value="aktif" @selected(old('status_bank', 'aktif') === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status_bank') === 'nonaktif')>Nonaktif</option>
                        </select>
                        <div class="bf-help">Pilih nonaktif jika rekening tidak digunakan lagi.</div>
                        @error('status_bank')<div class="bf-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="bf-actions">
                    <a href="{{ route('admin.bank.index') }}" class="bf-btn bf-light">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="bf-btn bf-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Bank
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
