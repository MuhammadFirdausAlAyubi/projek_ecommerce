@extends('admin.layouts.app')

@section('title', 'Proses Pembelian')
@section('breadcrumb', 'Proses Pembelian')

@section('content')
<style>
    .pe-page{color:#263247}
    .pe-heading{margin-bottom:22px}
    .pe-heading h2{margin:0;font-size:24px;font-weight:750}
    .pe-heading p{margin:6px 0 0;color:#7b8798;font-size:13px}
    .pe-card{background:#fff;border:1px solid #e8edf4;border-radius:14px;padding:22px;margin-bottom:18px}
    .pe-info{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
    .pe-label{font-size:12px;color:#8490a1;margin-bottom:7px}
    .pe-value{font-size:14px;font-weight:700;overflow-wrap:anywhere}
    .pe-status{display:inline-block;padding:6px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#fff7ed;color:#c2410c}
    .pe-field{margin-top:22px}
    .pe-field label{display:block;font-size:13px;font-weight:650;margin-bottom:8px}
    .pe-field select{width:100%;max-width:420px;min-height:44px;padding:10px 12px;border:1px solid #dbe2ec;border-radius:8px;background:#fff;font-size:13px}
    .pe-help{font-size:12px;color:#64748b;margin-top:9px;line-height:1.6}
    .pe-alert{padding:13px 15px;background:#eff6ff;color:#1d4ed8;border-radius:9px;font-size:13px;line-height:1.6;margin-bottom:18px}
    .pe-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-top:24px}
    .pe-btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 15px;border:0;border-radius:8px;text-decoration:none;font-size:13px;font-weight:650;cursor:pointer}
    .pe-primary{background:#2563eb;color:#fff}
    .pe-secondary{background:#eef2f7;color:#475569}
    @media(max-width:600px){.pe-info{grid-template-columns:1fr}.pe-card{padding:16px}.pe-heading h2{font-size:21px}}
</style>

<div class="pe-page">
    <div class="pe-heading">
        <h2>Proses Pembelian</h2>
        <p>Perbarui status penerimaan barang dari supplier.</p>
    </div>

    @if($errors->any())
        <div class="pe-alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="pe-card">
        <h3 style="font-size:15px;font-weight:750;margin:0 0 20px">Informasi Pembelian</h3>

        <div class="pe-info">
            <div>
                <div class="pe-label">Nomor Pembelian</div>
                <div class="pe-value">#PB-{{ $pembelian->id_pembelian }}</div>
            </div>

            <div>
                <div class="pe-label">Supplier</div>
                <div class="pe-value">{{ $pembelian->supplier->nama_supplier ?? 'Supplier tidak ditemukan' }}</div>
            </div>

            <div>
                <div class="pe-label">Tanggal Pembelian</div>
                <div class="pe-value">{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d M Y, H:i') }}</div>
            </div>

            <div>
                <div class="pe-label">Total Pembelian</div>
                <div class="pe-value" style="color:#2563eb;font-size:18px">
                    Rp {{ number_format((float)$pembelian->total_pembelian, 0, ',', '.') }}
                </div>
            </div>

            <div>
                <div class="pe-label">Status Saat Ini</div>
                <div><span class="pe-status">Dipesan</span></div>
            </div>
        </div>
    </div>

    <div class="pe-alert">
        <strong>Perhatian:</strong> jika status diubah menjadi <strong>Diterima</strong>,
        jumlah stok semua produk dalam pembelian ini akan bertambah. Pastikan barang
        benar-benar sudah diterima. Status akhir tidak dapat diproses ulang.
    </div>

    <div class="pe-card">
        <h3 style="font-size:15px;font-weight:750;margin:0 0 8px">Perbarui Status</h3>
        <p style="font-size:13px;color:#8490a1;margin:0">Pilih tindakan untuk pembelian ini.</p>

        <form action="{{ route('admin.pembelian.update', $pembelian->id_pembelian) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="pe-field">
                <label for="status_pembelian">Status Pembelian</label>
                <select name="status_pembelian" id="status_pembelian" required>
                    <option value="dipesan" {{ old('status_pembelian', $pembelian->status_pembelian) === 'dipesan' ? 'selected' : '' }}>
                        Dipesan
                    </option>
                    <option value="diterima" {{ old('status_pembelian') === 'diterima' ? 'selected' : '' }}>
                        Diterima — tambahkan stok
                    </option>
                    <option value="dibatalkan" {{ old('status_pembelian') === 'dibatalkan' ? 'selected' : '' }}>
                        Dibatalkan
                    </option>
                </select>

                <div class="pe-help">
                    Status Diterima akan menambahkan jumlah barang ke stok.
                    Status Dibatalkan tidak mengubah stok.
                </div>
            </div>

            <div class="pe-actions">
                <a href="{{ route('admin.pembelian.index') }}" class="pe-btn pe-secondary">Kembali</a>
                <button type="submit" class="pe-btn pe-primary"
                    onclick="return confirm('Yakin ingin memperbarui status pembelian ini?')">
                    <i class="fa-solid fa-check"></i> Simpan Status
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
