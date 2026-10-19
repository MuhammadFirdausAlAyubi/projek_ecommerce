@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('breadcrumb', 'Tambah Produk')

@push('styles')
<style>
    .page-heading{margin-bottom:24px}
    .page-heading h1{font-size:28px;margin:0}
    .subtitle{color:#788397;margin-top:8px}
    .form-card{background:#fff;border:1px solid #e8edf4;border-radius:15px;overflow:hidden;margin-bottom:20px}
    .card-heading{padding:20px 23px;border-bottom:1px solid #e8edf4}
    .card-heading h2{margin:0;font-size:16px}
    .card-heading p{margin:6px 0 0;color:#788397;font-size:12px;line-height:1.6}
    .form-body{padding:23px}
    .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}
    .field{min-width:0}
    .field.full{grid-column:1/-1}
    .field label{display:block;font-weight:700;margin-bottom:9px;color:#344054}
    .required{color:#dc3545}
    .field input,.field select,.field textarea{display:block;width:100%;box-sizing:border-box;padding:12px 13px;border:1px solid #dfe5ee;border-radius:9px;outline:none;background:#fff;color:#182230;font:inherit}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:#246bfd;box-shadow:0 0 0 3px #246bfd16}
    .field textarea{min-height:110px;resize:vertical}
    .hint{color:#8792a4;font-size:12px;margin-top:7px;line-height:1.5}
    .error-message{display:block;color:#dc3545;font-size:12px;margin-top:7px}
    .photo-preview{display:flex;gap:12px;flex-wrap:wrap;margin-top:14px}
    .photo-preview-item{width:112px;padding:7px;border:1px solid #dfe5ee;border-radius:10px;background:#f8fafc}
    .photo-preview-item img{display:block;width:96px;height:96px;object-fit:contain}
    .photo-preview-item p{margin:7px 0 0;color:#667085;font-size:11px;overflow-wrap:anywhere}
    .variant-item{border:1px solid #dfe5ee;border-radius:12px;padding:18px;margin-bottom:16px;background:#fcfdff}
    .variant-heading{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:16px}
    .variant-heading h3{font-size:15px;margin:0;color:#344054}
    .form-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-top:22px}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 16px;border:0;border-radius:9px;font-weight:700;cursor:pointer;font-size:13px;text-decoration:none}
    .btn-primary{background:#246bfd;color:#fff}
    .btn-primary:hover{background:#1557df}
    .btn-light{background:#f0f4fa;color:#344054}
    .btn-danger{background:#fff1f2;color:#be123c}
    .btn:disabled{opacity:.6;cursor:not-allowed}
    .alert-error{background:#fff1f2;border:1px solid #fecdd3;color:#be123c;padding:16px;border-radius:10px;margin-bottom:20px}
    @media(max-width:650px){.form-grid{grid-template-columns:1fr}.field.full{grid-column:auto}.form-body{padding:17px}.page-heading h1{font-size:23px}.variant-heading{align-items:flex-start}}
</style>
@endpush

@section('content')
<div class="page-heading">
    <h1>Tambah Produk</h1>
    <p class="subtitle">Masukkan informasi produk baru ke katalog ELECTROMART.</p>
</div>

@if($errors->any())
    <div class="alert-error">
        <strong>Produk belum dapat disimpan.</strong>
        <ul style="margin:8px 0 0;padding-left:20px">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <section class="form-card">
        <div class="card-heading">
            <h2><i class="fa-solid fa-box-open" style="color:#246bfd"></i> Informasi Produk</h2>
            <p>Kolom bertanda <span class="required">*</span> wajib diisi.</p>
        </div>

        <div class="form-body">
            <div class="form-grid">
                <div class="field full">
                    <label for="nama_produk">Nama produk <span class="required">*</span></label>
                    <input id="nama_produk" name="nama_produk" type="text"
                           value="{{ old('nama_produk') }}" maxlength="255"
                           placeholder="Contoh: Samsung Galaxy S25" required>
                    @error('nama_produk')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="id_kategori">Kategori <span class="required">*</span></label>
                    <select id="id_kategori" name="id_kategori" required>
                        <option value="">Pilih kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}"
                                @selected((string)old('id_kategori') === (string)$kategori->id_kategori)>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="id_brand">Brand <span class="required">*</span></label>
                    <select id="id_brand" name="id_brand" required>
                        <option value="">Pilih brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id_brand }}"
                                @selected((string)old('id_brand') === (string)$brand->id_brand)>
                                {{ $brand->nama_brand }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_brand')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="harga_jual">Harga dasar produk (Rp) <span class="required">*</span></label>
                    <input id="harga_jual" type="number" name="harga_jual"
                           value="{{ old('harga_jual') }}" min="0" step="1"
                           placeholder="Contoh: 13999000" required>
                    <div class="hint">Untuk produk tanpa varian, harga ini digunakan sebagai harga jual.</div>
                    @error('harga_jual')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="field">
                    <label for="status_produk">Status produk <span class="required">*</span></label>
                    <select id="status_produk" name="status_produk" required>
                        <option value="">Pilih status</option>
                        <option value="aktif" @selected(old('status_produk', 'aktif') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status_produk') === 'nonaktif')>Nonaktif</option>
                    </select>
                    @error('status_produk')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="field full">
                    <label for="gambar">Foto utama produk (maksimal 4 foto)</label>
                    <input id="gambar" type="file" name="gambar[]" multiple
                           accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    <div class="hint">JPG, JPEG, PNG, atau WebP. Maksimal 2 MB per foto. Foto pertama menjadi foto utama.</div>
                    <div id="preview-foto" class="photo-preview"></div>
                    @error('gambar')<span class="error-message">{{ $message }}</span>@enderror
                    @error('gambar.*')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="field full">
                    <label for="deskripsi">Deskripsi produk</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Jelaskan informasi umum produk...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="field full">
                    <label for="spesifikasi">Spesifikasi produk</label>
                    <textarea id="spesifikasi" name="spesifikasi" placeholder="Contoh: prosesor, RAM, ukuran, konektivitas...">{{ old('spesifikasi') }}</textarea>
                    @error('spesifikasi')<span class="error-message">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </section>

    <section class="form-card">
        <div class="card-heading">
            <h2><i class="fa-solid fa-warehouse" style="color:#246bfd"></i> Informasi Stok Produk</h2>
            <p>Digunakan untuk produk yang tidak memakai varian.</p>
        </div>
        <div class="form-body">
            <div class="form-grid">
                <div class="field">
                    <label for="jumlah_stok">Jumlah stok <span class="required">*</span></label>
                    <input id="jumlah_stok" type="number" name="jumlah_stok"
                           value="{{ old('jumlah_stok', 0) }}" min="0" step="1" required>
                    @error('jumlah_stok')<span class="error-message">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label for="stok_minimum">Stok minimum <span class="required">*</span></label>
                    <input id="stok_minimum" type="number" name="stok_minimum"
                           value="{{ old('stok_minimum', 5) }}" min="0" step="1" required>
                    @error('stok_minimum')<span class="error-message">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </section>

    <section class="form-card">
        <div class="card-heading">
            <h2><i class="fa-solid fa-layer-group" style="color:#246bfd"></i> Varian Produk</h2>
            <p>Opsional. Tambahkan varian untuk warna, kapasitas, atau tipe berbeda. Setiap varian memiliki harga dan stok sendiri.</p>
        </div>
        <div class="form-body">
            <div id="daftar-varian">
                @foreach(old('varian', []) as $i => $varian)
                    <div class="variant-item">
                        <div class="variant-heading">
                            <h3>Varian <span class="nomor-varian">{{ $loop->iteration }}</span></h3>
                            <button type="button" class="btn btn-danger hapus-varian">Hapus baris</button>
                        </div>
                        <div class="form-grid">
                            <div class="field">
                                <label>Nama varian</label>
                                <input name="varian[{{ $i }}][nama_varian]" value="{{ $varian['nama_varian'] ?? '' }}" placeholder="Hitam 256GB">
                            </div>
                            <div class="field">
                                <label>Warna</label>
                                <input name="varian[{{ $i }}][warna]" value="{{ $varian['warna'] ?? '' }}" placeholder="Hitam">
                            </div>
                            <div class="field">
                                <label>Kapasitas / tipe</label>
                                <input name="varian[{{ $i }}][kapasitas]" value="{{ $varian['kapasitas'] ?? '' }}" placeholder="256GB">
                            </div>
                            <div class="field">
                                <label>Harga varian (Rp)</label>
                                <input type="number" min="0" step="1" name="varian[{{ $i }}][harga]" value="{{ $varian['harga'] ?? '' }}" placeholder="15000000">
                            </div>
                            <div class="field">
                                <label>Jumlah stok</label>
                                <input type="number" min="0" step="1" name="varian[{{ $i }}][jumlah_stok]" value="{{ $varian['jumlah_stok'] ?? '' }}" placeholder="10">
                            </div>
                            <div class="field">
                                <label>Gambar varian</label>
                                <input type="file" name="varian[{{ $i }}][gambar]" accept=".jpg,.jpeg,.png,.webp">
                                <div class="hint">Opsional, maksimal 2 MB.</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="tambah-varian" class="btn btn-light">
                <i class="fa-solid fa-plus"></i> Tambah Varian
            </button>
            <div class="hint">Contoh: Hitam 256GB dan Biru 512GB. Isi nama, harga, dan stok untuk setiap varian yang digunakan. Maksimal 30 varian.</div>
        </div>
    </section>

    <div class="form-actions" style="margin-bottom:30px">
        <a href="{{ route('admin.produk.index') }}" class="btn btn-light">
            <i class="fa-solid fa-arrow-left"></i> Batal
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Produk
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputFoto = document.getElementById('gambar');
    const preview = document.getElementById('preview-foto');
    let objectUrls = [];

    if (inputFoto && preview) {
        inputFoto.addEventListener('change', function () {
            objectUrls.forEach(url => URL.revokeObjectURL(url));
            objectUrls = [];
            preview.innerHTML = '';

            const files = Array.from(this.files || []);

            if (files.length > 4) {
                alert('Maksimal 4 foto produk.');
                this.value = '';
                return;
            }

            for (const file of files) {
                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                    alert('Gunakan format JPG, PNG, atau WebP.');
                    this.value = '';
                    preview.innerHTML = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran setiap foto maksimal 2 MB.');
                    this.value = '';
                    preview.innerHTML = '';
                    return;
                }

                const url = URL.createObjectURL(file);
                objectUrls.push(url);

                const wrapper = document.createElement('div');
                wrapper.className = 'photo-preview-item';

                const img = document.createElement('img');
                img.src = url;
                img.alt = file.name;

                const caption = document.createElement('p');
                caption.textContent = file.name;

                wrapper.append(img, caption);
                preview.appendChild(wrapper);
            }
        });
    }

    const daftar = document.getElementById('daftar-varian');
    const tombolTambah = document.getElementById('tambah-varian');
    if (!daftar || !tombolTambah) return;

    let nomor = {{ count(old('varian', [])) }};

    function perbaruiNomor() {
        daftar.querySelectorAll('.variant-item').forEach((item, index) => {
            const label = item.querySelector('.nomor-varian');
            if (label) label.textContent = index + 1;
        });
    }

    tombolTambah.addEventListener('click', function () {
        if (daftar.querySelectorAll('.variant-item').length >= 30) {
            alert('Maksimal 30 varian untuk satu produk.');
            return;
        }

        const i = nomor++;
        const item = document.createElement('div');
        item.className = 'variant-item';

        const heading = document.createElement('div');
        heading.className = 'variant-heading';

        const title = document.createElement('h3');
        title.textContent = 'Varian ';

        const number = document.createElement('span');
        number.className = 'nomor-varian';
        title.appendChild(number);

        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'btn btn-danger hapus-varian';
        remove.textContent = 'Hapus baris';

        heading.append(title, remove);

        const grid = document.createElement('div');
        grid.className = 'form-grid';

        const fields = [
            ['Nama varian', 'nama_varian', 'text', 'Hitam 256GB'],
            ['Warna', 'warna', 'text', 'Hitam'],
            ['Kapasitas / tipe', 'kapasitas', 'text', '256GB'],
            ['Harga varian (Rp)', 'harga', 'number', '15000000'],
            ['Jumlah stok', 'jumlah_stok', 'number', '10']
        ];

        fields.forEach(([labelText, key, type, placeholder]) => {
            const field = document.createElement('div');
            field.className = 'field';

            const label = document.createElement('label');
            label.textContent = labelText;

            const input = document.createElement('input');
            input.name = `varian[${i}][${key}]`;
            input.type = type;
            input.placeholder = placeholder;

            if (type === 'number') {
                input.min = '0';
                input.step = '1';
            }

            field.append(label, input);
            grid.appendChild(field);
        });

        const fieldGambar = document.createElement('div');
        fieldGambar.className = 'field';

        const labelGambar = document.createElement('label');
        labelGambar.textContent = 'Gambar varian';

        const inputGambar = document.createElement('input');
        inputGambar.type = 'file';
        inputGambar.name = `varian[${i}][gambar]`;
        inputGambar.accept = '.jpg,.jpeg,.png,.webp';

        const hint = document.createElement('div');
        hint.className = 'hint';
        hint.textContent = 'Opsional, maksimal 2 MB.';

        fieldGambar.append(labelGambar, inputGambar, hint);
        grid.appendChild(fieldGambar);

        item.append(heading, grid);
        daftar.appendChild(item);
        perbaruiNomor();
    });

    daftar.addEventListener('click', function (event) {
        const tombol = event.target.closest('.hapus-varian');
        if (!tombol) return;

        tombol.closest('.variant-item').remove();
        perbaruiNomor();
    });

    perbaruiNomor();
});
</script>
@endpush
