@extends('admin.layouts.app')

@section('title', 'User')
@section('breadcrumb', 'User')

@push('styles')
<style>
    .user-page {
        color: #182230;
    }

    /* Heading */
    .user-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .user-heading h2 {
        margin: 0;
        font-size: 29px;
        font-weight: 700;
        letter-spacing: -.7px;
        color: #182230;
    }

    .user-heading p {
        margin: 8px 0 0;
        color: #788397;
        font-size: 14px;
    }

    /* Statistics */
    .user-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .user-stat {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 22px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
    }

    .user-stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #edf4ff;
        color: #246bfd;
        font-size: 20px;
    }

    .user-stat-label {
        margin-bottom: 5px;
        color: #788397;
        font-size: 12px;
    }

    .user-stat-value {
        color: #182230;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.2;
    }

    /* Cards */
    .user-card {
        margin-bottom: 20px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
    }

    .user-card-header {
        padding: 20px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .user-card-heading {
        margin: 0;
        color: #202c40;
        font-size: 16px;
        font-weight: 800;
    }

    .user-card-description {
        margin: 5px 0 0;
        color: #788397;
        font-size: 11px;
    }

    /* Buttons */
    .user-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 15px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .user-btn-primary {
        background: #246bfd;
        color: #fff;
    }

    .user-btn-primary:hover {
        background: #1558df;
        color: #fff;
    }

    .user-btn-secondary {
        background: #f0f4fa;
        color: #344054;
    }

    .user-btn-secondary:hover {
        background: #e5ebf4;
        color: #182230;
    }

    /* Filters */
    .user-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 23px;
        border-bottom: 1px solid #e8edf4;
    }

    .user-input {
        min-height: 42px;
        padding: 10px 13px;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        background: #fff;
        color: #182230;
        font-family: inherit;
        font-size: 13px;
        outline: none;
    }

    .user-input:focus {
        border-color: #246bfd;
        box-shadow: 0 0 0 3px rgba(36, 107, 253, .1);
    }

    .user-search {
        flex: 1;
        min-width: 200px;
    }

    /* Table */
    .user-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .user-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .user-table th {
        padding: 14px 18px;
        background: #fafbfd;
        color: #788397;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .5px;
        border-bottom: 1px solid #e8edf4;
        white-space: nowrap;
    }

    .user-table td {
        padding: 16px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #536176;
        vertical-align: middle;
    }

    .user-table tbody tr:last-child td {
        border-bottom: none;
    }

    .user-table tbody tr:hover {
        background: #fafcff;
    }

    /* User profile */
    .user-profile {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 180px;
    }

    .user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #edf4ff;
        color: #246bfd;
        font-size: 15px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .user-name {
        color: #202c40;
        font-size: 13px;
        font-weight: 700;
    }

    .user-id {
        margin-top: 4px;
        color: #8792a4;
        font-size: 11px;
    }

    .user-email {
        overflow-wrap: anywhere;
    }

    /* Role badges */
    .user-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .user-role-admin {
        background: #f1eaff;
        color: #6d28d9;
    }

    .user-role-customer {
        background: #e8f8ef;
        color: #067647;
    }

    /* Alerts */
    .user-alert {
        padding: 13px 16px;
        margin-bottom: 18px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
    }

    .user-alert-success {
        background: #ecfdf3;
        color: #067647;
        border-color: #abefc6;
    }

    .user-alert-error {
        background: #fef3f2;
        color: #b42318;
        border-color: #fecdca;
    }

    /* Action icons: same as Kategori */
    .user-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    .user-actions form {
        margin: 0;
    }

    .user-action {
        width: 34px;
        height: 34px;
        padding: 0;
        display: grid;
        place-items: center;
        border: 0;
        border-radius: 8px;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .user-btn-edit {
        background: #edf4ff;
        color: #246bfd;
    }

    .user-btn-edit:hover {
        background: #246bfd;
        color: #fff;
    }

    .user-btn-delete {
        background: #fff0f0;
        color: #b42332;
    }

    .user-btn-delete:hover {
        background: #b42332;
        color: #fff;
    }

    /* Empty state */
    .user-empty {
        padding: 42px 20px !important;
        text-align: center;
    }

    .user-empty-icon {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        margin: 0 auto 12px;
        border-radius: 12px;
        background: #edf4ff;
        color: #246bfd;
        font-size: 22px;
    }

    .user-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: 14px;
        font-weight: 800;
    }

    .user-empty p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    /* Pagination */
    .user-pagination {
        padding: 18px 23px;
        border-top: 1px solid #e8edf4;
    }

    .user-pagination nav svg {
        width: 16px;
        height: 16px;
    }

    .user-pagination nav a,
    .user-pagination nav span {
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .user-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .user-heading {
            align-items: flex-start;
        }

        .user-heading h2 {
            font-size: 25px;
        }

        .user-stats {
            grid-template-columns: 1fr;
        }

        .user-card-header,
        .user-filters {
            padding: 16px;
        }

        .user-search {
            flex-basis: 100%;
            min-width: 0;
        }

        .user-filters > .user-btn {
            flex: 1;
        }

        .user-table th,
        .user-table td {
            padding: 14px;
        }

        .user-pagination {
            padding: 16px;
        }
    }
</style>
@endpush

@section('content')
<div class="user-page">

    {{-- HEADING --}}
    <div class="user-heading">
        <div>
            <h2>Manajemen User</h2>
            <p>Kelola akun admin dan pelanggan ELECTROMART.</p>
        </div>

        <a href="{{ route('admin.user.create') }}"
           class="user-btn user-btn-primary">
            <i class="fa-solid fa-user-plus"></i>
            Tambah User
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="user-alert user-alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="user-alert user-alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="user-alert user-alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="user-stats">

        <div class="user-stat">
            <div class="user-stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div>
                <div class="user-stat-label">Total User</div>
                <div class="user-stat-value">
                    {{ number_format($totalUsers, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="user-stat">
            <div class="user-stat-icon"
                 style="background:#f1eaff;color:#6d28d9">
                <i class="fa-solid fa-user-shield"></i>
            </div>

            <div>
                <div class="user-stat-label">Total Admin</div>
                <div class="user-stat-value">
                    {{ number_format($totalAdmin, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="user-stat">
            <div class="user-stat-icon"
                 style="background:#e8f8ef;color:#067647">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <div>
                <div class="user-stat-label">Total Pelanggan</div>
                <div class="user-stat-value">
                    {{ number_format($totalPelanggan, 0, ',', '.') }}
                </div>
            </div>
        </div>

    </div>

    {{-- FILTER USER --}}
    <div class="user-card">

        <div class="user-card-header">
            <h3 class="user-card-heading">Daftar User</h3>
            <p class="user-card-description">
                Cari user berdasarkan nama, email, telepon, atau role.
            </p>
        </div>

        <form action="{{ route('admin.user.index') }}"
              method="GET"
              class="user-filters">

            <input
                type="text"
                name="search"
                class="user-input user-search"
                placeholder="Cari nama, email, atau nomor telepon..."
                value="{{ request('search') }}"
            >

            <select name="role" class="user-input">
                <option value="">Semua Role</option>

                <option value="admin"
                    {{ request('role') === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option value="pelanggan"
                    {{ request('role') === 'pelanggan' ? 'selected' : '' }}>
                    Pelanggan
                </option>
            </select>

            <button type="submit" class="user-btn user-btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Cari
            </button>

            <a href="{{ route('admin.user.index') }}"
               class="user-btn user-btn-secondary">
                <i class="fa-solid fa-rotate-left"></i>
                Reset
            </a>
        </form>
    </div>

    {{-- TABEL USER --}}
    <div class="user-card">

        <div class="user-card-header">
            <h3 class="user-card-heading">Data Pengguna</h3>
            <p class="user-card-description">
                Informasi akun administrator dan pelanggan yang terdaftar.
            </p>
        </div>

        <div class="user-table-wrap">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Role</th>
                        <th>Tanggal Bergabung</th>
                        <th style="text-align:right">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="user-profile">
                                    <div class="user-avatar">
                                        {{ \Illuminate\Support\Str::substr($user->nama ?? '?', 0, 1) }}
                                    </div>

                                    <div>
                                        <div class="user-name">
                                            {{ $user->nama }}
                                        </div>

                                        <div class="user-id">
                                            ID: {{ $user->id_user }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="user-email">
                                {{ $user->email }}
                            </td>

                            <td>
                                {{ $user->no_telp ?: '-' }}
                            </td>

                            <td>
                                @if($user->role === 'admin')
                                    <span class="user-role user-role-admin">
                                        <i class="fa-solid fa-shield-halved"></i>
                                        Admin
                                    </span>
                                @else
                                    <span class="user-role user-role-customer">
                                        <i class="fa-solid fa-user"></i>
                                        Pelanggan
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $user->created_at
                                    ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i')
                                    : '-' }}
                            </td>

                            <td>
                                <div class="user-actions">

                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.user.edit', $user->id_user) }}"
                                        class="user-action user-btn-edit"
                                        title="Edit user"
                                        aria-label="Edit user"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    {{-- HAPUS: TIDAK MENAMPILKAN TOMBOL UNTUK AKUN SENDIRI --}}
                                    @if((string) $user->id_user !== (string) auth()->id())
                                        <form
                                            action="{{ route('admin.user.destroy', $user->id_user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus akun {{ addslashes($user->nama) }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="user-action user-btn-delete"
                                                title="Hapus user"
                                                aria-label="Hapus user"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="user-empty">
                                <div class="user-empty-icon">
                                    <i class="fa-solid fa-users"></i>
                                </div>

                                <strong>User tidak ditemukan</strong>

                                <p>
                                    Coba ubah kata pencarian atau filter role.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($users->hasPages())
            <div class="user-pagination">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
