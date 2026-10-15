@extends('layouts.customer')

@section('content')
<div class="container py-5">

    {{-- Judul halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Keranjang Belanja</h2>
            <p class="text-muted mb-0">
                Periksa produk pilihanmu sebelum melanjutkan.
            </p>
        </div>

        <a href="{{ url('/shop') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i>
            Lanjut Belanja
        </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close"
                data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $items = $keranjang->detailKeranjang;
    @endphp

    @if ($items->isEmpty())

        {{-- Keranjang kosong --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-cart3"
                        style="font-size: 4rem; color: #adb5bd;"></i>
                </div>

                <h4 class="fw-bold">Keranjangmu masih kosong</h4>
                <p class="text-muted">
                    Yuk, temukan produk elektronik favoritmu!
                </p>

                <a href="{{ url('/shop') }}"
                    class="btn btn-primary px-4">
                    Mulai Belanja
                </a>
            </div>
        </div>

    @else

        <div class="row g-4">

            {{-- Daftar produk --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">
                            Produk Pilihan ({{ $items->count() }} jenis)
                        </h5>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($items as $item)
                                        @if ($item->produk)
                                            <tr>
                                                {{-- Informasi produk --}}
                                                <td class="ps-3">
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if ($item->produk->gambar)
                                                            <img
                                                                src="{{ asset('storage/' . $item->produk->gambar) }}"
                                                                alt="{{ $item->produk->nama_produk }}"
                                                                style="width: 65px; height: 65px; object-fit: contain;"
                                                                class="rounded border p-1"
                                                            >
                                                        @else
                                                            <div class="border rounded d-flex align-items-center justify-content-center"
                                                                style="width: 65px; height: 65px;">
                                                                <i class="bi bi-box-seam fs-3 text-secondary"></i>
                                                            </div>
                                                        @endif

                                                        <div>
                                                            <div class="fw-semibold">
                                                                {{ $item->produk->nama_produk }}
                                                            </div>
                                                            <small class="text-muted">
                                                                ID: {{ $item->id_produk }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- Harga satuan --}}
                                                <td>
                                                    Rp{{ number_format((float) $item->produk->harga_jual, 0, ',', '.') }}
                                                </td>

                                                {{-- Form update jumlah --}}
                                                <td>
                                                    <form
                                                        action="{{ route('keranjang.update', $item->id_detail_keranjang) }}"
                                                        method="POST"
                                                        class="d-flex align-items-center gap-1"
                                                    >
                                                        @csrf
                                                        @method('PATCH')

                                                        <input
                                                            type="number"
                                                            name="jumlah"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->jumlah }}"
                                                            min="1"
                                                            max="{{ $item->produk->stok->jumlah_stok ?? '' }}"
                                                            required
                                                            style="width: 75px;"
                                                        >

                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-primary"
                                                            title="Perbarui jumlah">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                </td>

                                                {{-- Subtotal --}}
                                                <td class="fw-semibold text-nowrap">
                                                    Rp{{ number_format((float) $item->produk->harga_jual * $item->jumlah, 0, ',', '.') }}
                                                </td>

                                                {{-- Hapus produk --}}
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('keranjang.hapus', $item->id_detail_keranjang) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Hapus produk">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ringkasan belanja --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0">Ringkasan Belanja</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Jumlah barang</span>
                            <span class="fw-semibold">
                                {{ $items->sum('jumlah') }} barang
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal produk</span>
                            <span class="fw-semibold">
                                Rp{{ number_format((float) $total, 0, ',', '.') }}
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary fs-5">
                                Rp{{ number_format((float) $total, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="button"
                            class="btn btn-primary w-100"
                            disabled>
                            Lanjut ke Checkout
                        </button>

                        <small class="text-muted d-block mt-2 text-center">
                            Fitur checkout akan dibuat setelah keranjang selesai.
                        </small>
                    </div>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
