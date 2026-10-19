@extends('admin.layouts.app')

@section('title', 'Edit Bank')
@section('breadcrumb', 'Edit Bank')

@push('styles')
<style>
.be-page{max-width:900px;color:#182230}
.be-heading{margin-bottom:25px}
.be-heading h2{margin:0 0 7px;font-size:25px;font-weight:800;color:#101828}
.be-heading p{margin:0;color:#788397;font-size:13px}
.be-panel{background:#fff;border:1px solid #e8edf4;border-radius:15px;overflow:hidden;box-shadow:0 3px 12px #10182805}
.be-header{padding:21px 24px;border-bottom:1px solid #e8edf4;font-size:16px;font-weight:800;color:#101828}
.be-header i{color:#246bfd;margin-right:9px}
.be-body{padding:25px}
.be-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.be-field{margin-bottom:22px}
.be-label{display:block;margin-bottom:9px;font-size:13px;font-weight:700;color:#344054}
.be-control{width:100%;height:45px;padding:0 13px;border:1px solid #e1e7f0;border-radius:9px;background:#fff;color:#182230;font:inherit;font-size:13px;outline:none}
.be-control:focus{border-color:#246bfd;box-shadow:0 0 0 3px #246bfd15}
.be-help{margin-top:7px;color:#788397;font-size:12px;line-height:1.6}
.be-error{margin-top:7px;color:#d04444;font-size:12px}
.be-alert{padding:13px 16px;margin:20px 24px 0;border-radius:10px;color:#c03939;background:#fff0f0;font-size:13px}
.be-actions{display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;padding-top:20px;border-top:1px solid #edf0f5}
.be-action-right{display:flex;gap:10px;flex-wrap:wrap}
.be-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:42px;padding:0 16px;border-radius:9px;border:1px solid transparent;font:inherit;font-size:13px;font-weight:700;text-decoration:none;cursor:pointer}
.be-primary{background:#246bfd;color:#fff}
.be-primary:hover{background:#1558e8;color:#fff}
.be-light{background:#fff;color:#526075;border-color:#e1e7f0}
.be-light:hover{background:#f5f7fb;color:#182230}
@media(max-width:600px){.be-heading h2{font-size:21px}.be-body{padding:18px}.be-header{padding:18px}.be-grid{grid-template-columns:1fr;gap:0}.be-actions,.be-action-right{flex-direction:column}.be-actions .be-btn,.be-action-right .be-btn{width:100%}}
</style>
@endpush

@section('content')
<div class="be-page">
    <div class="be-heading">
        <h2>Edit Bank</h2>
        <p>Perbarui informasi rekening bank yang terdaftar di ELECTROMART.</p>
    </div>

    <section class="be-panel">
        <div class="be-header"><i class="fa-solid fa-pen-to-square"></i> Formulir Edit Bank</div>

        @if($errors->any())
            <div class="be-alert">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <div class="be-body">
            <form action="{{ route('admin.bank.update', $bank->id_bank) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="be-grid">
                    <div class="be-field">
                        <label for="nama_bank" class="be-label">Nama Bank <span style="color:#d04444">*</span></label>
                        <input type="text" id="nama_bank" name="nama_bank" class="be-control"
                               maxlength="100" required
                               value="{{ old('nama_bank', $bank->nama_bank) }}">
                        @error('nama_bank')<div class="be-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="be-field">
                        <label for="no_rekening" class="be-label">Nomor Rekening <span style="color:#d04444">*</span></label>
                        <input type="text" id="no_rekening" name="no_rekening" class="be-control"
                               maxlength="50" required
                               value="{{ old('no_rekening', $bank->no_rekening) }}">
                        @error('no_rekening')<div class="be-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="be-grid">
                    <div class="be-field">
                        <label for="atas_nama" class="be-label">Atas Nama <span style="color:#d04444">*</span></label>
                        <input type="text" id="atas_nama" name="atas_nama" class="be-control"
                               maxlength="100" required
                               value="{{ old('atas_nama', $bank->atas_nama) }}">
                        @error('atas_nama')<div class="be-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="be-field">
                        <label for="status_bank" class="be-label">Status Bank <span style="color:#d04444">*</span></label>
                        <select id="status_bank" name="status_bank" class="be-control" required>
                            <option value="aktif" @selected(old('status_bank', $bank->status_bank) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status_bank', $bank->status_bank) === 'nonaktif')>Nonaktif</option>
                        </select>
                        <div class="be-help">Menonaktifkan bank tidak menghapus riwayat pembayaran.</div>
                        @error('status_bank')<div class="be-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="be-actions">
                    <a href="{{ route('admin.bank.index') }}" class="be-btn be-light">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <div class="be-action-right">
                        <button type="submit" class="be-btn be-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
