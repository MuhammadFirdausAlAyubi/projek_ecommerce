@extends('admin.layouts.app')

@section('title', 'Tambah Pembelian')
@section('breadcrumb', 'Tambah Pembelian')

@section('content')
<style>
    .pc-page{color:#263247}
    .pc-heading{margin-bottom:22px}
    .pc-heading h2{margin:0;font-size:24px;font-weight:750}
    .pc-heading p{margin:6px 0 0;color:#7b8798;font-size:13px}
    .pc-card{background:#fff;border:1px solid #e8edf4;border-radius:14px;padding:22px;margin-bottom:18px}
    .pc-section{font-size:15px;font-weight:750;margin:0 0 18px}
    .pc-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
    .pc-field label{display:block;font-size:13px;font-weight:650;margin-bottom:8px}
    .pc-field input,.pc-field select{width:100%;min-height:43px;padding:10px 12px;border:1px solid #dbe2ec;border-radius:8px;font-size:13px;background:#fff;color:#263247}
    .pc-help{font-size:11px;color:#8490a1;margin-top:6px}
    .pc-table-wrap{overflow-x:auto}
    .pc-table{width:100%;border-collapse:collapse;min-width:700px}
    .pc-table th{padding:12px;text-align:left;background:#f8fafc;color:#64748b;font-size:11px;text-transform:uppercase}
    .pc-table td{padding:10px;border-bottom:1px solid #edf1f6}
    .pc-table input,.pc-table select{width:100%;min-width:110px;padding:9px;border:1px solid #dbe2ec;border-radius:7px;font-size:12px}
    .pc-subtotal{font-size:12px;font-weight:700;white-space:nowrap}
    .pc-total{display:flex;justify-content:flex-end;align-items:center;gap:20px;margin-top:20px;padding:18px;background:#f8fafc;border-radius:10px}
    .pc-total span{font-size:13px;color:#64748b}
    .pc-total strong{font-size:22px;color:#2563eb}
    .pc-btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 15px;border:0;border-radius:8px;text-decoration:none;font-size:13px;font-weight:650;cursor:pointer}
    .pc-primary{background:#2563eb;color:#fff}
    .pc-secondary{background:#eef2f7;color:#475569}
    .pc-danger{background:#fee2e2;color:#b91c1c;padding:8px 10px}
    .pc-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap}
    .pc-alert{padding:13px 16px;border-radius:9px;margin-bottom:16px;font-size:13px;background:#fff1f2;color:#be123c}
    @media(max-width:650px){.pc-grid{grid-template-columns:1fr}.pc-card{padding:15px}.pc-heading h2{font-size:21px}}
</style>

<div class="pc-page">
    <div class="pc-heading">
        <h2>Tambah Pembelian</h2>
        <p>Buat pesanan barang baru kepada supplier.</p>
    </div>

    @if($errors->any())
        <div class="pc-alert">
            <strong>Periksa kembali data kamu:</strong>
            <ul style="margin:8px 0 0;padding-left:20px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pembelian.store') }}" method="POST" id="formPembelian">
        @csrf

        <div class="pc-card">
            <h3 class="pc-section">Informasi Pembelian</h3>

            <div class="pc-grid">
                <div class="pc-field">
                    <label for="id_supplier">Supplier <span style="color:#dc2626">*</span></label>
                    <select name="id_supplier" id="id_supplier" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($supplier as $s)
                            <option value="{{ $s->id_supplier }}" {{ old('id_supplier') == $s->id_supplier ? 'selected' : '' }}>
                                {{ $s->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pc-field">
                    <label for="tanggal_pembelian">Tanggal Pembelian <span style="color:#dc2626">*</span></label>
                    <input
                        type="datetime-local"
                        name="tanggal_pembelian"
                        id="tanggal_pembelian"
                        value="{{ old('tanggal_pembelian', now()->format('Y-m-d\TH:i')) }}"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="pc-card">
            <h3 class="pc-section">Daftar Produk</h3>

            <div class="pc-table-wrap">
                <table class="pc-table">
                    <thead>
                        <tr>
                            <th style="width:34%">Produk</th>
                            <th style="width:17%">Jumlah</th>
                            <th style="width:22%">Harga Beli (Rp)</th>
                            <th style="width:19%">Subtotal</th>
                            <th style="width:8%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="daftarProduk"></tbody>
                </table>
            </div>

            <div style="margin-top:16px">
                <button type="button" class="pc-btn pc-secondary" id="tambahProduk">
                    <i class="fa-solid fa-plus"></i> Tambah Produk
                </button>
            </div>

            <div class="pc-total">
                <span>Total Pembelian</span>
                <strong id="totalTampil">Rp 0</strong>
            </div>
        </div>

        <div class="pc-actions">
            <a href="{{ route('admin.pembelian.index') }}" class="pc-btn pc-secondary">Batal</a>
            <button type="submit" class="pc-btn pc-primary">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Pembelian
            </button>
        </div>
    </form>
</div>

<template id="templateProduk">
    <tr class="baris-produk">
        <td>
            <select name="id_produk[]" class="pilih-produk" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($produk as $p)
                    <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="jumlah[]" class="jumlah-produk" min="1" step="1" value="1" required>
        </td>
        <td>
            <input type="number" name="harga_beli[]" class="harga-produk" min="0" step="0.01" placeholder="0" required>
        </td>
        <td><span class="pc-subtotal">Rp 0</span></td>
        <td>
            <button type="button" class="pc-btn pc-danger hapus-produk" title="Hapus produk">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const daftar = document.getElementById('daftarProduk');
    const template = document.getElementById('templateProduk');
    const totalTampil = document.getElementById('totalTampil');
    const form = document.getElementById('formPembelian');

    function rupiah(nilai) {
        return 'Rp ' + Number(nilai || 0).toLocaleString('id-ID', {
            maximumFractionDigits: 2
        });
    }

    function hitungTotal() {
        let total = 0;

        daftar.querySelectorAll('.baris-produk').forEach(function (baris) {
            const jumlah = Number(baris.querySelector('.jumlah-produk').value) || 0;
            const harga = Number(baris.querySelector('.harga-produk').value) || 0;
            const subtotal = jumlah * harga;

            baris.querySelector('.pc-subtotal').textContent = rupiah(subtotal);
            total += subtotal;
        });

        totalTampil.textContent = rupiah(total);
    }

    function tambahBaris() {
        const clone = template.content.cloneNode(true);
        daftar.appendChild(clone);
        hitungTotal();
    }

    document.getElementById('tambahProduk').addEventListener('click', tambahBaris);

    daftar.addEventListener('input', function (event) {
        if (event.target.matches('.jumlah-produk, .harga-produk')) {
            hitungTotal();
        }
    });

    daftar.addEventListener('click', function (event) {
        const tombol = event.target.closest('.hapus-produk');

        if (tombol) {
            const baris = tombol.closest('.baris-produk');

            if (daftar.querySelectorAll('.baris-produk').length > 1) {
                baris.remove();
                hitungTotal();
            } else {
                alert('Minimal harus ada satu produk.');
            }
        }
    });

    form.addEventListener('submit', function (event) {
        const baris = daftar.querySelectorAll('.baris-produk');

        if (!baris.length) {
            event.preventDefault();
            alert('Tambahkan minimal satu produk.');
            return;
        }

        const produkDipilih = Array.from(daftar.querySelectorAll('.pilih-produk'))
            .map(function (select) { return select.value; });

        if (produkDipilih.some(function (id) { return !id; })) {
            event.preventDefault();
            alert('Pilih produk pada semua baris.');
            return;
        }

        if (new Set(produkDipilih).size !== produkDipilih.length) {
            event.preventDefault();
            alert('Produk yang sama tidak boleh dipilih dua kali. Gabungkan jumlahnya dalam satu baris.');
        }
    });

    tambahBaris();
});
</script>
@endsection
