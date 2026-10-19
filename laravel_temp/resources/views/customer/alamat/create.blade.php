@extends('layouts.customer')

@section('content')
<div class="container py-5" style="max-width: 750px">

    <div class="mb-4">
        <h2 class="mb-2">Tambah Alamat Pengiriman</h2>
        <p class="text-secondary">
            Lengkapi informasi penerima dan alamat untuk pesanan ELECTROMART.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data kamu:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('alamat.store') }}" method="POST">
                @csrf

                <h5 class="mb-3">Informasi Penerima</h5>

                <div class="mb-3">
                    <label for="nama_penerima" class="form-label">
                        Nama Penerima
                    </label>
                    <input
                        type="text"
                        id="nama_penerima"
                        name="nama_penerima"
                        class="form-control"
                        value="{{ old('nama_penerima') }}"
                        placeholder="Masukkan nama penerima"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="no_telp_penerima" class="form-label">
                        Nomor Telepon
                    </label>
                    <input
                        type="tel"
                        id="no_telp_penerima"
                        name="no_telp_penerima"
                        class="form-control"
                        value="{{ old('no_telp_penerima') }}"
                        placeholder="Contoh: 081234567890"
                        maxlength="20"
                        required
                    >
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Detail Alamat</h5>

                {{-- PROVINSI --}}
                <div class="mb-3">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <select
                        id="provinsi"
                        name="provinsi"
                        class="form-select"
                        required
                    >
                        <option value="">Pilih provinsi</option>

                        @foreach ($provinsi as $item)
                            <option
                                value="{{ $item->name }}"
                                data-code="{{ $item->code }}"
                                @selected(old('provinsi') == $item->name)
                            >
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- KABUPATEN / KOTA --}}
                <div class="mb-3">
                    <label for="kota" class="form-label">
                        Kabupaten/Kota
                    </label>
                    <select
                        id="kota"
                        name="kota"
                        class="form-select"
                        required
                        disabled
                    >
                        <option value="">Pilih kabupaten/kota</option>
                    </select>
                </div>

                <div class="row">
                    {{-- KECAMATAN --}}
                    <div class="col-md-6 mb-3">
                        <label for="kecamatan" class="form-label">
                            Kecamatan
                        </label>
                        <select
                            id="kecamatan"
                            name="kecamatan"
                            class="form-select"
                            required
                            disabled
                        >
                            <option value="">Pilih kecamatan</option>
                        </select>
                    </div>

                    {{-- KODE POS --}}
                    <div class="col-md-6 mb-3">
                        <label for="kode_pos" class="form-label">
                            Kode Pos
                        </label>
                        <input
                            type="text"
                            id="kode_pos"
                            name="kode_pos"
                            class="form-control"
                            value="{{ old('kode_pos') }}"
                            placeholder="Contoh: 15560"
                            maxlength="10"
                            required
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label for="alamat_lengkap" class="form-label">
                        Alamat Lengkap
                    </label>
                    <textarea
                        id="alamat_lengkap"
                        name="alamat_lengkap"
                        class="form-control"
                        rows="4"
                        maxlength="1000"
                        placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, dan patokan lokasi"
                        required
                    >{{ old('alamat_lengkap') }}</textarea>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Simpan Alamat
                    </button>

                    <a href="{{ route('alamat.index') }}"
                       class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const provinsiSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecamatanSelect = document.getElementById('kecamatan');

    const oldProvinsi = @json(old('provinsi'));
    const oldKota = @json(old('kota'));
    const oldKecamatan = @json(old('kecamatan'));

    function resetSelect(select, placeholder) {
        select.innerHTML = '';

        const option = document.createElement('option');
        option.value = '';
        option.textContent = placeholder;

        select.appendChild(option);
        select.disabled = true;
    }

    function addOptions(select, items, oldValue) {
        items.forEach(function (item) {
            const option = document.createElement('option');
            option.value = item.name;
            option.textContent = item.name;
            option.dataset.code = item.code;

            if (item.name === oldValue) {
                option.selected = true;
            }

            select.appendChild(option);
        });

        select.disabled = items.length === 0;
    }

    async function loadKota(kodeProvinsi, selectedKota = '') {
        resetSelect(kotaSelect, 'Memuat kabupaten/kota...');
        resetSelect(kecamatanSelect, 'Pilih kecamatan');

        try {
            const response = await fetch(
                `/wilayah/kota/${encodeURIComponent(kodeProvinsi)}`
            );

            if (!response.ok) {
                throw new Error('Gagal mengambil data kabupaten/kota.');
            }

            const data = await response.json();

            resetSelect(kotaSelect, 'Pilih kabupaten/kota');
            addOptions(kotaSelect, data, selectedKota);

            if (selectedKota) {
                const selectedOption = kotaSelect.options[kotaSelect.selectedIndex];

                if (selectedOption && selectedOption.value) {
                    await loadKecamatan(selectedOption.dataset.code, oldKecamatan);
                }
            }
        } catch (error) {
            resetSelect(kotaSelect, 'Gagal memuat kabupaten/kota');
            console.error(error);
        }
    }

    async function loadKecamatan(kodeKota, selectedKecamatan = '') {
        resetSelect(kecamatanSelect, 'Memuat kecamatan...');

        try {
            const response = await fetch(
                `/wilayah/kecamatan/${encodeURIComponent(kodeKota)}`
            );

            if (!response.ok) {
                throw new Error('Gagal mengambil data kecamatan.');
            }

            const data = await response.json();

            resetSelect(kecamatanSelect, 'Pilih kecamatan');
            addOptions(kecamatanSelect, data, selectedKecamatan);
        } catch (error) {
            resetSelect(kecamatanSelect, 'Gagal memuat kecamatan');
            console.error(error);
        }
    }

    provinsiSelect.addEventListener('change', function () {
        const option = provinsiSelect.options[provinsiSelect.selectedIndex];

        if (!option || !option.dataset.code) {
            resetSelect(kotaSelect, 'Pilih kabupaten/kota');
            resetSelect(kecamatanSelect, 'Pilih kecamatan');
            return;
        }

        loadKota(option.dataset.code);
    });

    kotaSelect.addEventListener('change', function () {
        const option = kotaSelect.options[kotaSelect.selectedIndex];

        if (!option || !option.dataset.code) {
            resetSelect(kecamatanSelect, 'Pilih kecamatan');
            return;
        }

        loadKecamatan(option.dataset.code);
    });

    // Memulihkan pilihan setelah validasi form gagal.
    if (oldProvinsi) {
        const option = Array.from(provinsiSelect.options).find(
            item => item.value === oldProvinsi
        );

        if (option && option.dataset.code) {
            loadKota(option.dataset.code, oldKota);
        }
    }
});
</script>
@endsection
