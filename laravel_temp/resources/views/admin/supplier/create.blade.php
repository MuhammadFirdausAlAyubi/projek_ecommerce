@extends('admin.layouts.app')

@section('title', 'Tambah Supplier')
@section('breadcrumb', 'Tambah Supplier')

@push('styles')
<style>
    .supplier-form-page { color: #182230; }

    .supplier-form-heading { margin-bottom: 24px; }

    .supplier-form-heading h2 {
        margin: 0 0 7px;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .supplier-form-heading p {
        margin: 0;
        color: #788397;
        font-size: 14px;
    }

    .supplier-form-card {
        max-width: 100%;
        padding: 28px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 17px;
        box-shadow: 0 3px 12px rgba(16, 24, 40, .025);
    }

    .supplier-form-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 22px;
        margin-bottom: 25px;
        border-bottom: 1px solid #edf0f5;
    }

    .supplier-form-icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        color: #246bfd;
        background: #edf3ff;
        border-radius: 13px;
        font-size: 20px;
    }

    .supplier-form-card-header h3 {
        margin: 0 0 5px;
        font-size: 18px;
        font-weight: 800;
    }

    .supplier-form-card-header p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .supplier-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .supplier-form-group {
        min-width: 0;
    }

    .supplier-form-group.full {
        grid-column: 1 / -1;
    }

    .supplier-form-label {
        display: block;
        margin-bottom: 9px;
        color: #344054;
        font-size: 13px;
        font-weight: 700;
    }

    .supplier-required { color: #d92d20; }

    .supplier-form-control {
        display: block;
        width: 100%;
        min-height: 46px;
        padding: 11px 14px;
        border: 1px solid #d8e0eb;
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: #182230;
        font-family: inherit;
        font-size: 13px;
        transition: border-color .2s, box-shadow .2s;
    }

    .supplier-form-control:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px rgba(36, 107, 253, .10);
    }

    .supplier-form-control::placeholder { color: #a0a9b8; }

    textarea.supplier-form-control {
        min-height: 115px;
        resize: vertical;
        line-height: 1.6;
    }

    .supplier-form-hint {
        display: block;
        margin-top: 7px;
        color: #98a2b3;
        font-size: 12px;
    }

    .supplier-form-error {
        display: block;
        margin-top: 7px;
        color: #d92d20;
        font-size: 12px;
    }

    .supplier-form-alert {
        margin-bottom: 20px;
        padding: 14px 17px;
        border: 1px solid #fecdca;
        border-radius: 10px;
        background: #fef3f2;
        color: #b42318;
        font-size: 13px;
    }

    .supplier-form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #edf0f5;
    }

    .supplier-form-note {
        color: #788397;
        font-size: 12px;
    }

    .supplier-form-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .supplier-form-btn {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 0 17px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .supplier-form-btn-primary {
        color: #fff;
        background: #246bfd;
    }

    .supplier-form-btn-primary:hover {
        color: #fff;
        background: #1558df;
    }

    .supplier-form-btn-secondary {
        color: #536176;
        background: #fff;
        border-color: #d8e0eb;
    }

    .supplier-form-btn-secondary:hover {
        background: #f5f7fb;
    }

    @media(max-width: 650px) {
        .supplier-form-card { padding: 19px; }
        .supplier-form-heading h2 { font-size: 23px; }
        .supplier-form-grid { grid-template-columns: 1fr; gap: 19px; }
        .supplier-form-group.full { grid-column: auto; }
        .supplier-form-footer { align-items: flex-start; }
        .supplier-form-actions { width: 100%; }
        .supplier-form-actions .supplier-form-btn { flex: 1; }
    }
</style>
@endpush

@section('content')
<div class="supplier-form-page">

    <div class="supplier-form-heading">
        <h2>Tambah Supplier</h2>
        <p>Tambahkan informasi pemasok baru ke sistem ELECTROMART.</p>
    </div>

    @if($errors->any())
        <div class="supplier-form-alert">
            <strong><i class="fa-solid fa-circle-exclamation"></i>
                Data belum dapat disimpan.</strong>
            <ul style="margin:8px 0 0;padding-left:22px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="supplier-form-card">

        <div class="supplier-form-card-header">
            <div class="supplier-form-icon">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
                <h3>Informasi Supplier</h3>
                <p>Lengkapi informasi kontak pemasok di bawah ini.</p>
            </div>
        </div>

        <form action="{{ route('admin.supplier.store') }}" method="POST">
            @csrf

            <div class="supplier-form-grid">

                <div class="supplier-form-group full">
                    <label for="nama_supplier" class="supplier-form-label">
                        Nama Supplier <span class="supplier-required">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_supplier"
                        name="nama_supplier"
                        class="supplier-form-control"
                        placeholder="Contoh: PT Sumber Elektronik Indonesia"
                        value="{{ old('nama_supplier') }}"
                        maxlength="100"
                        required
                        autofocus>
                    @error('nama_supplier')
                        <span class="supplier-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="supplier-form-group full">
                    <label for="alamat_supplier" class="supplier-form-label">
                        Alamat Supplier
                    </label>
                    <textarea
                        id="alamat_supplier"
                        name="alamat_supplier"
                        class="supplier-form-control"
                        placeholder="Masukkan alamat lengkap supplier">{{ old('alamat_supplier') }}</textarea>
                    @error('alamat_supplier')
                        <span class="supplier-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="supplier-form-group">
                    <label for="no_telp" class="supplier-form-label">
                        Nomor Telepon
                    </label>
                    <input
                        type="text"
                        id="no_telp"
                        name="no_telp"
                        class="supplier-form-control"
                        placeholder="Contoh: 081234567890"
                        value="{{ old('no_telp') }}"
                        maxlength="20">
                    @error('no_telp')
                        <span class="supplier-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="supplier-form-group">
                    <label for="email" class="supplier-form-label">
                        Email Supplier
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="supplier-form-control"
                        placeholder="supplier@perusahaan.com"
                        value="{{ old('email') }}"
                        maxlength="100">
                    @error('email')
                        <span class="supplier-form-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="supplier-form-footer">
                <div class="supplier-form-note">
                    <span class="supplier-required">*</span>
                    Wajib diisi.
                </div>

                <div class="supplier-form-actions">
                    <a href="{{ route('admin.supplier.index') }}"
                       class="supplier-form-btn supplier-form-btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="supplier-form-btn supplier-form-btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Supplier
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
