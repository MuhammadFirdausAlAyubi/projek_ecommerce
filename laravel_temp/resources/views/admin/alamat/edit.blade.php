@extends('admin.layouts.app')

@section('title', 'Edit Alamat')
@section('breadcrumb', 'Edit Alamat')

@section('content')
<style>
.alamat-form-card{max-width:900px;background:#fff;border:1px solid #e8edf4;border-radius:14px;padding:24px;color:#263247}.alamat-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.alamat-group{display:flex;flex-direction:column;gap:7px}.alamat-full{grid-column:1/-1}.alamat-label{font-size:13px;font-weight:650}.alamat-control{width:100%;box-sizing:border-box;padding:12px;border:1px solid #dbe2ec;border-radius:8px;background:#fff;font-size:13px;color:#263247}.alamat-error{color:#dc2626;font-size:12px}.alamat-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:18px;border-top:1px solid #edf1f6}.alamat-btn{display:inline-flex;gap:7px;align-items:center;padding:11px 15px;border-radius:8px;border:0;text-decoration:none;font-size:13px;cursor:pointer}.alamat-save{background:#2563eb;color:white}.alamat-back{background:#eef2f7;color:#475569}@media(max-width:600px){.alamat-grid{grid-template-columns:1fr}.alamat-full{grid-column:auto}.alamat-form-card{padding:16px}}
</style>

<div class="alamat-form-card">
    <h2 style="margin-top:0">Edit Alamat #{{ $alamat->id_alamat }}</h2>
    <p style="color:#8490a1;font-size:13px;margin-bottom:24px">Perbarui data penerima dan alamat pengiriman.</p>

    @if($errors->any())
        <div style="padding:12px;background:#fef2f2;color:#b91c1c;border-radius:8px;margin-bottom:18px">
            <ul style="margin:0;padding-left:20px">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.alamat.update', $alamat->id_alamat) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="alamat-grid">
            <div class="alamat-group alamat-full">
                <label class="alamat-label" for="id_user">Pemilik alamat *</label>
                <select class="alamat-control" id="id_user" name="id_user" required>
                    <option value="">Pilih pelanggan</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id_user }}" {{ (string)old('id_user', $alamat->id_user) === (string)$user->id_user ? 'selected' : '' }}>
                            {{ $user->nama }} — {{ $user->email }} ({{ $user->role }})
                        </option>
                    @endforeach
                </select>
                @error('id_user')<span class="alamat-error">{{ $message }}</span>@enderror
            </div>

            <div class="alamat-group">
                <label class="alamat-label" for="nama_penerima">Nama penerima *</label>
                <input class="alamat-control" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima', $alamat->nama_penerima) }}" maxlength="100" required>
                @error('nama_penerima')<span class="alamat-error">{{ $message }}</span>@enderror
            </div>

            <div class="alamat-group">
                <label class="alamat-label" for="no_telp_penerima">Telepon penerima *</label>
                <input class="alamat-control" id="no_telp_penerima" name="no_telp_penerima" value="{{ old('no_telp_penerima', $alamat->no_telp_penerima) }}" maxlength="20" required>
                @error('no_telp_penerima')<span class="alamat-error">{{ $message }}</span>@enderror
            </div>

            <div class="alamat-group">
                <label class="alamat-label" for="provinsi">Provinsi *</label>
                <input class="alamat-control" id="provinsi" name="provinsi" value="{{ old('provinsi', $alamat->provinsi) }}" maxlength="100" required>
                @error('provinsi')<span class="alamat-error">{{ $message }}</span>@enderror
            </div>

            <div class="alamat-group">
                <label class="alamat-label" for="kota">Kota/Kabupaten *</label>
                <input class="alamat-control" id="kota" name="kota" value="{{ old('kota', $alamat->kota) }}" maxlength="100" required>
                @error('kota')<span class="alamat-error">{{ $message }}</span>@enderror
            </div>

            <div class="alamat-group">
                <label class="alamat-label" for="kecamatan">Kecamatan *</label>
                <input class="alamat-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $alamat->kecamatan) }}" maxlength="100" required>
                @error('kecamatan')<span class="alamat-error">{{ $message }}</span>@enderror
            </div>

            <div class="alamat-group">
                <label class="alamat-label" for="kode_pos">Kode pos *</label>
                <input class="alamat-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $alamat->kode_pos) }}" maxlength="10" required>
                @error('kode_pos')<span class="alamat-error">{{ $message }}</span>@enderror
            </div>

            <div class="alamat-group alamat-full">
                <label class="alamat-label" for="alamat_lengkap">Alamat lengkap *</label>
                <textarea class="alamat-control" id="alamat_lengkap" name="alamat_lengkap" rows="4" required>{{ old('alamat_lengkap', $alamat->alamat_lengkap) }}</textarea>
                @error('alamat_lengkap')<span class="alamat-error">{{ $message }}</span>@enderror
            </div>

            <div class="alamat-group alamat-full">
                <label style="display:flex;gap:9px;align-items:center;font-size:13px">
                    <input type="checkbox" name="is_utama" value="1" {{ old('is_utama', $alamat->is_utama) ? 'checked' : '' }}>
                    Jadikan alamat utama untuk pelanggan ini
                </label>
                <small style="color:#8490a1">Jika dicentang, alamat utama pelanggan yang sama sebelumnya akan dinonaktifkan.</small>
            </div>
        </div>

        <div class="alamat-actions">
            <a href="{{ route('admin.alamat.index') }}" class="alamat-btn alamat-back">Batal</a>
            <button type="submit" class="alamat-btn alamat-save"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
