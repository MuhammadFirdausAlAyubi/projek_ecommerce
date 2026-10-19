
@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('breadcrumb', 'Edit Kategori')

@push('styles')
<style>
    .page-heading { margin-bottom:24px; }
    h1 { font-size:28px; margin:0; }
    .subtitle { color:#788397; margin-top:8px; }

    .form-card {
        background:white;
        border:1px solid #e8edf4;
        border-radius:15px;
        overflow:hidden;
        max-width:900px;
    }

    .card-heading {
        padding:20px 23px;
        border-bottom:1px solid #e8edf4;
    }

    .card-heading h2 { margin:0; font-size:16px; }
    .card-heading p { margin:6px 0 0; color:#788397; font-size:12px; }
    .form-body { padding:23px; }

    .field { margin-bottom:20px; }
    .field:last-child { margin-bottom:0; }

    .field label {
        display:block;
        font-weight:700;
        margin-bottom:9px;
        color:#344054;
    }

    .required { color:#dc3545; }

    .field input,.field textarea {
        width:100%;
        padding:12px 13px;
        border:1px solid #dfe5ee;
        border-radius:9px;
        font:inherit;
        outline:none;
        background:white;
        color:#182230;
    }

    .field textarea { min-height:130px; resize:vertical; }

    .field input:focus,.field textarea:focus {
        border-color:#246bfd;
        box-shadow:0 0 0 3px #246bfd16;
    }

    .form-actions {
        display:flex;
        justify-content:flex-end;
        gap:10px;
        flex-wrap:wrap;
        margin-top:22px;
    }

    .btn {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        padding:12px 16px;
        border:0;
        border-radius:9px;
        font-weight:700;
        cursor:pointer;
        font-size:13px;
    }

    .btn-primary { background:#246bfd; color:white; }
    .btn-primary:hover { background:#1557df; }
    .btn-light { background:#f0f4fa; color:#344054; }

    @media(max-width:600px) {
        .form-body { padding:17px; }
    }
</style>
@endpush

@section('content')
    <div class="page-heading">
        <h1>Edit Kategori</h1>
        <p class="subtitle">
            Perbarui informasi kategori {{ $kategori->nama_kategori }}.
        </p>
    </div>

    <section class="form-card">
        <div class="card-heading">
            <h2><i class="fa-solid fa-pen-to-square" style="color:#246bfd"></i> Informasi Kategori</h2>
            <p>Kolom bertanda <span class="required">*</span> wajib diisi.</p>
        </div>

        <div class="form-body">
            <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="nama_kategori">
                        Nama kategori <span class="required">*</span>
                    </label>

                    <input id="nama_kategori"
                           type="text"
                           name="nama_kategori"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                           maxlength="100"
                           required>
                </div>

                <div class="field">
                    <label for="deskripsi">Deskripsi kategori</label>

                    <textarea id="deskripsi"
                              name="deskripsi"
                              placeholder="Deskripsi kategori...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-light">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
