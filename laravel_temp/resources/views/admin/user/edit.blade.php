@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('breadcrumb', 'Edit User')

@section('content')
<style>
    .user-form-card { max-width:850px; padding:24px; background:#fff; border:1px solid #e8edf4; border-radius:14px; color:#263247; }
    .user-form-title { margin:0 0 6px; font-size:22px; font-weight:750; }
    .user-form-desc { margin:0 0 24px; color:#8490a1; font-size:13px; }
    .user-form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:20px; }
    .user-form-group { display:flex; flex-direction:column; gap:8px; }
    .user-form-label { font-size:13px; font-weight:650; }
    .user-form-control { width:100%; box-sizing:border-box; padding:12px 13px; border:1px solid #dbe2ec; border-radius:8px; font-size:13px; color:#263247; background:#fff; }
    .user-form-control:focus { outline:none; border-color:#60a5fa; box-shadow:0 0 0 3px #dbeafe; }
    .user-form-error { color:#dc2626; font-size:12px; }
    .user-form-hint { color:#8490a1; font-size:12px; }
    .user-form-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:25px; padding-top:20px; border-top:1px solid #edf1f6; }
    .user-form-btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 16px; border:0; border-radius:8px; text-decoration:none; font-size:13px; font-weight:650; cursor:pointer; }
    .user-form-save { background:#2563eb; color:#fff; }
    .user-form-back { background:#eef2f7; color:#475569; }
    @media(max-width:600px) { .user-form-grid { grid-template-columns:1fr; } .user-form-card { padding:16px; } }
</style>

<div class="user-form-card">
    <h2 class="user-form-title">Edit User</h2>
    <p class="user-form-desc">Perbarui informasi akun #{{ $user->id_user }}.</p>

    @if($errors->any())
        <div style="padding:12px 15px;margin-bottom:20px;background:#fef2f2;color:#b91c1c;border-radius:8px;font-size:13px;">
            <strong>Periksa kembali data berikut:</strong>
            <ul style="margin:8px 0 0;padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.user.update', $user->id_user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="user-form-grid">
            <div class="user-form-group">
                <label class="user-form-label" for="nama">Nama lengkap *</label>
                <input class="user-form-control" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required maxlength="255">
                @error('nama') <span class="user-form-error">{{ $message }}</span> @enderror
            </div>

            <div class="user-form-group">
                <label class="user-form-label" for="email">Email *</label>
                <input class="user-form-control" id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255">
                @error('email') <span class="user-form-error">{{ $message }}</span> @enderror
            </div>

            <div class="user-form-group">
                <label class="user-form-label" for="no_telp">Nomor telepon</label>
                <input class="user-form-control" id="no_telp" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" maxlength="20">
                @error('no_telp') <span class="user-form-error">{{ $message }}</span> @enderror
            </div>

            <div class="user-form-group">
                <label class="user-form-label" for="role">Role *</label>
                <select
                    class="user-form-control"
                    id="role"
                    name="role"
                    required
                    {{ (string) $user->id_user === (string) auth()->id() ? 'disabled' : '' }}
                >
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pelanggan" {{ old('role', $user->role) === 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                </select>

                @if((string) $user->id_user === (string) auth()->id())
                    <span class="user-form-hint">Role akun yang sedang digunakan tidak bisa diubah.</span>
                    <input type="hidden" name="role" value="{{ $user->role }}">
                @endif

                @error('role') <span class="user-form-error">{{ $message }}</span> @enderror
            </div>

            <div class="user-form-group">
                <label class="user-form-label" for="password">Password baru</label>
                <input class="user-form-control" id="password" type="password" name="password" minlength="8" autocomplete="new-password">
                <span class="user-form-hint">Kosongkan jika tidak ingin mengganti password.</span>
                @error('password') <span class="user-form-error">{{ $message }}</span> @enderror
            </div>

            <div class="user-form-group">
                <label class="user-form-label" for="password_confirmation">Konfirmasi password baru</label>
                <input class="user-form-control" id="password_confirmation" type="password" name="password_confirmation" minlength="8" autocomplete="new-password">
            </div>
        </div>

        <div class="user-form-actions">
            <a href="{{ route('admin.user.index') }}" class="user-form-btn user-form-back">Batal</a>
            <button type="submit" class="user-form-btn user-form-save">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
