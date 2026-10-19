
@extends('admin.layouts.app')

@section('title', 'Edit Supplier')
@section('breadcrumb', 'Edit Supplier')

@push('styles')
<style>
    .supplier-edit-page { color: #182230; }

    .supplier-edit-heading { margin-bottom: 24px; }

    .supplier-edit-heading h2 {
        margin: 0 0 7px;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .supplier-edit-heading p {
        margin: 0;
        color: #788397;
        font-size: 14px;
    }

    .supplier-edit-card {
        padding: 28px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 17px;
        box-shadow: 0 3px 12px rgba(16, 24, 40, .025);
    }

    .supplier-edit-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 22px;
        margin-bottom: 25px;
        border-bottom: 1px solid #edf0f5;
    }

    .supplier-edit-icon {
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

    .supplier-edit-card-header h3 {
        margin: 0 0 5px;
        font-size: 18px;
        font-weight: 800;
    }

    .supplier-edit-card-header p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .supplier-edit-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .supplier-edit-group { min-width: 0; }
    .supplier-edit-group.full { grid-column: 1 / -1; }

    .supplier-edit-label {
        display: block;
        margin-bottom: 9px;
        color: #344054;
        font-size: 13px;
        font-weight: 700;
    }

    .supplier-edit-control {
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

    .supplier-edit-control:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px rgba(36, 107, 253, .10);
    }

    .supplier-edit-control::placeholder { color: #a0a9b8; }

    textarea.supplier-edit-control {
        min-height: 115px;
        resize: vertical;
        line-height: 1.6;
    }

    .supplier-edit-error {
        display: block;
        margin-top: 7px;
        color: #d92d20;
        font-size: 12px;
    }

    .supplier-edit-alert {
        margin-bottom: 20px;
        padding: 14px 17px;
        border: 1px solid #fecdca;
        border-radius: 10px;
        background: #fef3f2;
        color: #b42318;
        font-size: 13px;
    }

    .supplier-edit-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #edf0f5;
    }

    .supplier-edit-note {
        color: #788397;
        font-size: 12px;
    }

    .supplier-edit-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .supplier-edit-btn {
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

    .supplier-edit-btn-primary {
        color: #fff;
        background: #246bfd;
    }

    .supplier-edit-btn-primary:hover {
        color: #fff;
        background: #1558df;
    }

    .supplier-edit-btn-secondary {
        color: #536176;
        background: #fff;
        border-color: #d8e0eb;
    }

    .supplier-edit-btn-secondary:hover { background: #f5f7fb; }

    @media(max-width: 650px) {
        .supplier-edit-card { padding: 19px; }
        .supplier-edit-heading h2 { font-size: 23px; }
        .supplier-edit-grid { grid-template-columns: 1fr; gap: 19px; }
        .supplier-edit-group.full { grid-column: auto; }
        .supplier-edit-actions { width: 100%; }
        .supplier-edit-actions .supplier-edit-btn { flex: 1; }
    }
</style>
@endpush

@section('content')
<div class="supplier-edit-page">

    <div class="supplier-edit-heading">
        <h2>Edit Supplier</h2>
        <p>Perbarui informasi pemasok yang terdaftar di ELECTROMART.</p>
    </div>

    @if($errors->any())
        <div class="supplier-edit-alert">
            <strong><i class="fa-solid fa-circle-exclamation"></i>
                Data belum dapat disimpan.</strong>
            <ul style="margin:8px 0 0;padding-left:22px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="supplier-edit-card">

        <div class="supplier-edit-card-header">
            <div class="supplier-edit-icon">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h3>Informasi Supplier</h3>
                <p>
                    Mengedit data:
                    <strong>{{ $supplier->nama_supplier }}</strong>
                </p>
            </div>
        </div>

        <form action="{{ route('admin.supplier.update', $supplier->id_supplier) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="supplier-edit-grid">

                <div class="supplier-edit-group full">
                    <label for="nama_supplier" class="supplier-edit-label">
                        Nama Supplier <span style="color:#d92d20">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_supplier"
                        name="nama_supplier"
                        class="supplier-edit-control"
                        value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                        maxlength="100"
                        required>
                    @error('nama_supplier')
                        <span class="supplier-edit-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="supplier-edit-group full">
                    <label for="alamat_supplier" class="supplier-edit-label">
                        Alamat Supplier
                    </label>
                    <textarea
                        id="alamat_supplier"
                        name="alamat_supplier"
                        class="supplier-edit-control"
                        placeholder="Masukkan alamat lengkap supplier">{{ old('alamat_supplier', $supplier->alamat_supplier) }}</textarea>
                    @error('alamat_supplier')
                        <span class="supplier-edit-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="supplier-edit-group">
                    <label for="no_telp" class="supplier-edit-label">
                        Nomor Telepon
                    </label>
                    <input
                        type="text"
                        id="no_telp"
                        name="no_telp"
                        class="supplier-edit-control"
                        value="{{ old('no_telp', $supplier->no_telp) }}"
                        maxlength="20"
                        placeholder="Contoh: 081234567890">
                    @error('no_telp')
                        <span class="supplier-edit-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="supplier-edit-group">
                    <label for="email" class="supplier-edit-label">
                        Email Supplier
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="supplier-edit-control"
                        value="{{ old('email', $supplier->email) }}"
                        maxlength="100"
                        placeholder="supplier@perusahaan.com">
                    @error('email')
                        <span class="supplier-edit-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="supplier-edit-footer">
                <div class="supplier-edit-note">
                    ID Supplier:
                    <strong>#{{ $supplier->id_supplier }}</strong>
                </div>

                <div class="supplier-edit-actions">
                    <a href="{{ route('admin.supplier.index') }}"
                       class="supplier-edit-btn supplier-edit-btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="supplier-edit-btn supplier-edit-btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
