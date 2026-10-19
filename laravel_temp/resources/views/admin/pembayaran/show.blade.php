
@extends('admin.layouts.app')

@section('title', 'Detail Pembayaran')
@section('breadcrumb', 'Detail Pembayaran')

@push('styles')
<style>
    .payment-detail {
        color: #182230;
    }

    .pd-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .pd-heading h2 {
        margin: 0 0 6px;
        font-size: 25px;
        font-weight: 800;
        color: #101828;
    }

    .pd-heading p {
        margin: 0;
        color: #788397;
        font-size: 13px;
    }

    .pd-panel {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 3px 12px #10182805;
        margin-bottom: 20px;
    }

    .pd-header {
        padding: 19px 22px;
        border-bottom: 1px solid #e8edf4;
        font-size: 15px;
        font-weight: 800;
        color: #101828;
    }

    .pd-header i {
        color: #246bfd;
        margin-right: 9px;
    }

    .pd-body {
        padding: 22px;
    }

    .pd-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .pd-info {
        width: 100%;
        border-collapse: collapse;
    }

    .pd-info th,
    .pd-info td {
        padding: 12px 0;
        border-bottom: 1px solid #edf0f5;
        font-size: 13px;
        text-align: left;
        vertical-align: top;
        overflow-wrap: anywhere;
    }

    .pd-info tr:last-child th,
    .pd-info tr:last-child td {
        border-bottom: 0;
    }

    .pd-info th {
        width: 42%;
        color: #788397;
        font-weight: 600;
        padding-right: 12px;
    }

    .pd-info td {
        color: #182230;
        font-weight: 600;
    }

    .pd-amount {
        font-size: 25px;
        font-weight: 800;
        color: #246bfd;
        overflow-wrap: anywhere;
    }

    .pd-status {
        display: inline-flex;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    .pd-status-menunggu {
        color: #b77912;
        background: #fff5d9;
    }

    .pd-status-berhasil {
        color: #13865c;
        background: #e8f8f0;
    }

    .pd-status-gagal {
        color: #d04444;
        background: #fff0f0;
    }

    .pd-status-dikembalikan {
        color: #7655d9;
        background: #f2edff;
    }

    .pd-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 0 16px;
        border-radius: 9px;
        font: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: background .2s, color .2s;
    }

    .pd-btn-primary {
        background: #246bfd;
        color: #fff;
    }

    .pd-btn-primary:hover {
        background: #1558e8;
        color: #fff;
    }

    .pd-btn-light {
        background: #fff;
        color: #526075;
        border-color: #e1e7f0;
    }

    .pd-btn-light:hover {
        background: #f5f7fb;
        color: #182230;
    }

    .pd-select {
        width: 100%;
        height: 43px;
        padding: 0 12px;
        border: 1px solid #e1e7f0;
        border-radius: 9px;
        font: inherit;
        font-size: 13px;
        background: #fff;
        color: #182230;
    }

    .pd-select:focus {
        outline: none;
        border-color: #246bfd;
        box-shadow: 0 0 0 3px #246bfd16;
    }

    .pd-label {
        display: block;
        margin-bottom: 9px;
        font-size: 12px;
        font-weight: 700;
        color: #526075;
    }

    .pd-form {
        display: flex;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pd-field {
        flex: 1 1 240px;
    }

    .pd-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 15px 18px;
        margin-bottom: 20px;
        border-radius: 10px;
        font-size: 13px;
        line-height: 1.6;
    }

    .pd-alert i {
        margin-top: 2px;
        font-size: 16px;
    }

    .pd-alert-content {
        flex: 1;
        min-width: 0;
    }

    .pd-success {
        color: #13865c;
        background: #e8f8f0;
        border: 1px solid #a7e5c8;
    }

    .pd-danger {
        color: #c03939;
        background: #fff0f0;
        border: 1px solid #fecaca;
    }

    .pd-note {
        color: #788397;
        font-size: 12px;
        line-height: 1.7;
        margin: 15px 0 0;
    }

    @media (max-width: 760px) {
        .pd-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .pd-heading h2 {
            font-size: 21px;
        }

        .pd-body,
        .pd-header {
            padding: 17px;
        }

        .pd-form .pd-btn {
            width: 100%;
        }

        .pd-field {
            flex-basis: 100%;
        }

        .pd-amount {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')
<div class="payment-detail">

    {{-- HEADER HALAMAN --}}
    <div class="pd-heading">
        <div>
            <h2>
                Pembayaran #{{ $pembayaran->id_pembayaran }}
            </h2>

            <p>
                Informasi metode, nominal, dan status pembayaran.
            </p>
        </div>

        <a
            href="{{ route('admin.pembayaran.index') }}"
            class="pd-btn pd-btn-light"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if (session('success'))
        <div class="pd-alert pd-success" role="alert">
            <i class="fa-solid fa-circle-check"></i>

            <div class="pd-alert-content">
                <strong>Berhasil!</strong>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if ($errors->any())
        <div class="pd-alert pd-danger" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i>

            <div class="pd-alert-content">
                <strong>Gagal!</strong>

                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- INFORMASI PEMBAYARAN DAN PELANGGAN --}}
    <div class="pd-grid">

        {{-- INFORMASI PEMBAYARAN --}}
        <section class="pd-panel">
            <div class="pd-header">
                <i class="fa-solid fa-credit-card"></i>
                Informasi Pembayaran
            </div>

            <div class="pd-body">
                <table class="pd-info">
                    <tr>
                        <th>ID Pembayaran</th>
                        <td>#{{ $pembayaran->id_pembayaran }}</td>
                    </tr>

                    <tr>
                        <th>ID Pesanan</th>
                        <td>
                            #{{ $pembayaran->pesanan->id_pesanan ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Metode</th>
                        <td>
                            {{ strtoupper($pembayaran->metode_pembayaran) }}
                        </td>
                    </tr>

                    <tr>
                        <th>Bank</th>
                        <td>
                            {{ $pembayaran->bank->nama_bank ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Tanggal</th>
                        <td>
                            @if ($pembayaran->tanggal_pembayaran)
                                {{ $pembayaran->tanggal_pembayaran->format('d M Y, H:i') }}
                            @else
                                Belum tercatat
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="pd-status pd-status-{{ $pembayaran->status_pembayaran }}">
                                {{ ucfirst($pembayaran->status_pembayaran) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </section>

        {{-- INFORMASI PELANGGAN --}}
        <section class="pd-panel">
            <div class="pd-header">
                <i class="fa-solid fa-user"></i>
                Informasi Pelanggan
            </div>

            <div class="pd-body">
                <table class="pd-info">
                    <tr>
                        <th>Nama</th>
                        <td>
                            {{ $pembayaran->pesanan->user->nama ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>
                            {{ $pembayaran->pesanan->user->email ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Total Pesanan</th>
                        <td>
                            Rp {{ number_format((float) ($pembayaran->pesanan->total_harga ?? 0), 0, ',', '.') }}
                        </td>
                    </tr>
                </table>

                <div style="margin-top:22px">
                    <div style="font-size:12px;color:#788397;margin-bottom:6px">
                        Nominal Pembayaran
                    </div>

                    <div class="pd-amount">
                        Rp {{ number_format((float) $pembayaran->nominal, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- KELOLA STATUS PEMBAYARAN --}}
    <section class="pd-panel">
        <div class="pd-header">
            <i class="fa-solid fa-arrows-rotate"></i>
            Kelola Status Pembayaran
        </div>

        <div class="pd-body">
            <form
                action="{{ route('admin.pembayaran.updateStatus', $pembayaran->id_pembayaran) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="pd-form">
                    <div class="pd-field">
                        <label
                            class="pd-label"
                            for="status_pembayaran"
                        >
                            Status Pembayaran
                        </label>

                        <select
                            class="pd-select"
                            name="status_pembayaran"
                            id="status_pembayaran"
                            required
                        >
                            @foreach (['menunggu', 'berhasil', 'gagal', 'dikembalikan'] as $status)
                                <option
                                    value="{{ $status }}"
                                    @selected(old('status_pembayaran', $pembayaran->status_pembayaran) === $status)
                                >
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="pd-btn pd-btn-primary"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Status
                    </button>
                </div>

                <p class="pd-note">
                    Ubah status hanya setelah memeriksa transaksi.
                    Fitur ini memperbarui status pembayaran dan, jika
                    pembayaran berhasil, dapat mengubah status pesanan
                    dari menunggu pembayaran menjadi dibayar.
                    Pengembalian dana belum dilakukan secara otomatis.
                </p>
            </form>
        </div>
    </section>

</div>
@endsection
