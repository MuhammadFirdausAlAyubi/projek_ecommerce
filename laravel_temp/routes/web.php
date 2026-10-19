<?php

use App\Models\Produk;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SupplierProdukController;
use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AlamatController;
use App\Http\Controllers\Admin\KeranjangController as AdminKeranjangController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\ReturProdukController;
use App\Http\Controllers\Admin\PengirimanController;
use App\Http\Controllers\Admin\EkspedisiController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\UlasanProdukController;
use App\Http\Controllers\Admin\UlasanProdukController as AdminUlasanProdukController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AlamatPelangganController;
use App\Http\Controllers\PesananPelangganController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

// HALAMAN UTAMA
Route::get('/', function () {
    $produks = Produk::with([
        'kategori',
        'brand',
        'stok',
        'ulasanProduk',
    ])
        ->orderByDesc('created_at')
        ->limit(8)
        ->get();

    return view('home.dashboard', [
        'produks' => $produks,
    ]);
})->name('home');

// KATALOG SEMUA PRODUK + FILTER HARGA
Route::get('/shop', function (Request $request) {
  $priceRanges = [
    'under2_5m' => [0, 2499999],
    '2_5m_to_5m' => [2500000, 5000000],
    '5m_to_10m' => [5000001, 10000000],
    '10m_to_20m' => [10000001, 20000000],
    '20m_to_50m' => [20000001, 50000000],
];

    $selectedRange = $request->query('price_range');

    $minPrice = $request->filled('min_price') && is_numeric($request->min_price)
        ? max(0, (float) $request->min_price)
        : null;

    $maxPrice = $request->filled('max_price') && is_numeric($request->max_price)
        ? max(0, (float) $request->max_price)
        : null;

    if (isset($priceRanges[$selectedRange])) {
        [$minPrice, $maxPrice] = $priceRanges[$selectedRange];
    } else {
        $selectedRange = null;
    }

    $query = Produk::with([
        'kategori',
        'brand',
        'stok',
        'ulasanProduk',
    ]);

    if ($minPrice !== null) {
        $query->where('harga_jual', '>=', $minPrice);
    }

    if ($maxPrice !== null) {
        $query->where('harga_jual', '<=', $maxPrice);
    }

    $produk = $query->orderBy('nama_produk')
        ->paginate(12)
        ->withQueryString();

    return view('shop.produk', [
        'produk' => $produk,
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
        'selectedRange' => $selectedRange,
    ]);
})->name('shop.index');


// DETAIL PRODUK
Route::get('/produk/{id}', function ($id) {
    $produk = Produk::with([
        'kategori',
        'brand',
        'stok',
        'fotoProduk',
        'varianProduk',
        'ulasanProduk',
    ])->findOrFail($id);

    return view('shop.detail', compact('produk'));
})->name('produk.detail');


// HALAMAN KATEGORI + FILTER HARGA
Route::get('/shop/{category}', function (Request $request, $category) {
    $categories = [
        'smartphone' => 'Smartphone',
        'laptop' => 'Laptop',
        'komputer' => 'Komputer',
        'aksesori' => 'Aksesori',
        'gaming' => 'Gaming',
        'networking' => 'Networking',
    ];

    abort_unless(array_key_exists($category, $categories), 404);

    $namaKategori = $categories[$category];

    $priceRanges = [
        'under500' => [0, 499999],
        '500to1m' => [500000, 1000000],
        '1to3m' => [1000001, 3000000],
        'above3m' => [3000001, null],
    ];

    $selectedRange = $request->query('price_range');

    $minPrice = $request->filled('min_price') && is_numeric($request->min_price)
        ? max(0, (float) $request->min_price)
        : null;

    $maxPrice = $request->filled('max_price') && is_numeric($request->max_price)
        ? max(0, (float) $request->max_price)
        : null;

    if (isset($priceRanges[$selectedRange])) {
        [$minPrice, $maxPrice] = $priceRanges[$selectedRange];
    } else {
        $selectedRange = null;
    }

    $query = Produk::with([
        'kategori',
        'brand',
        'stok',
        'ulasanProduk',
    ])->whereHas('kategori', function ($query) use ($namaKategori) {
        $query->whereRaw(
            'LOWER(TRIM(nama_kategori)) = ?',
            [strtolower($namaKategori)]
        );
    });

    if ($minPrice !== null) {
        $query->where('harga_jual', '>=', $minPrice);
    }

    if ($maxPrice !== null) {
        $query->where('harga_jual', '<=', $maxPrice);
    }

    $produks = $query->orderBy('nama_produk')
        ->paginate(12)
        ->withQueryString();

    return view('shop.category', [
        'category' => $namaKategori,
        'slug' => $category,
        'produks' => $produks,
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
        'selectedRange' => $selectedRange,
    ]);
})->name('shop.category');


/*
|--------------------------------------------------------------------------
| HALAMAN INFORMASI FOOTER ELECTROMART
|--------------------------------------------------------------------------
*/

$footerPages = [

    // 1. TENTANG KAMI
    'about' => [
        'title' => 'Tentang Kami',
        'subtitle' => 'Mengenal ELECTROMART',
        'description' => 'Informasi mengenai ELECTROMART, layanan, dan komitmen kami.',
        'sections' => [
            [
                'heading' => '1. Tentang ELECTROMART',
                'points' => [
                    'ELECTROMART merupakan platform toko elektronik yang menyediakan informasi produk teknologi untuk kebutuhan sehari-hari.',
                    'Produk yang ditampilkan mencakup kategori smartphone, laptop, komputer, aksesori, gaming, dan networking.',
                    'Informasi produk membantu pengguna membandingkan pilihan sebelum melakukan pembelian.',
                    'Pengguna dianjurkan membaca deskripsi, spesifikasi, harga, dan informasi ketersediaan sebelum memesan.',
                ],
            ],
            [
                'heading' => '2. Visi dan Komitmen',
                'points' => [
                    'Membantu pengguna menemukan perangkat elektronik sesuai kebutuhan.',
                    'Menyediakan informasi produk yang mudah dipahami.',
                    'Mendukung pengalaman belanja yang praktis melalui situs ELECTROMART.',
                    'Memberikan akses kepada pengguna untuk menghubungi layanan pelanggan.',
                ],
            ],
            [
                'heading' => '3. Layanan ELECTROMART',
                'points' => [
                    'Pengguna dapat melihat katalog produk dan informasi spesifikasinya.',
                    'Pengguna yang memiliki akun dapat mengakses fitur akun dan keranjang sesuai ketentuan situs.',
                    'Informasi pesanan, pembayaran, dan pengiriman mengikuti fitur yang tersedia.',
                    'Pertanyaan mengenai produk atau transaksi dapat disampaikan melalui kontak layanan pelanggan.',
                ],
            ],
        ],
    ],

    // 2. KEBIJAKAN GARANSI
    'warranty' => [
        'title' => 'Kebijakan Garansi',
        'subtitle' => 'Ketentuan garansi produk elektronik',
        'description' => 'Informasi mengenai pemeriksaan dan pengajuan klaim garansi produk.',
        'sections' => [
            [
                'heading' => '1. Ketentuan Umum Garansi',
                'points' => [
                    'Garansi produk mengikuti ketentuan resmi produsen, distributor, atau penyedia garansi.',
                    'Masa garansi dapat berbeda untuk setiap produk.',
                    'Pengguna disarankan menyimpan bukti pembelian, kartu garansi, dan dokumen pendukung.',
                    'Tidak semua kerusakan otomatis termasuk dalam cakupan garansi.',
                ],
            ],
            [
                'heading' => '2. Persyaratan Klaim Garansi',
                'points' => [
                    'Siapkan bukti pembelian atau nomor pesanan.',
                    'Berikan informasi produk, seperti nama, merek, dan nomor seri jika tersedia.',
                    'Jelaskan kendala atau kerusakan yang dialami secara jelas.',
                    'Siapkan foto atau video kondisi produk jika diperlukan.',
                    'Siapkan dokumen dan kelengkapan produk sesuai persyaratan penyedia garansi.',
                ],
            ],
            [
                'heading' => '3. Prosedur Pengajuan Garansi',
                'points' => [
                    'Hubungi layanan pelanggan ELECTROMART untuk meminta informasi proses klaim.',
                    'Sampaikan nomor pesanan, identitas produk, dan penjelasan kerusakan.',
                    'Ikuti arahan mengenai pemeriksaan atau pengiriman produk.',
                    'Produk akan diperiksa berdasarkan ketentuan garansi yang berlaku.',
                    'Hasil pemeriksaan mengikuti keputusan pihak yang berwenang menangani garansi.',
                ],
            ],
            [
                'heading' => '4. Pengecualian Garansi',
                'points' => [
                    'Kerusakan akibat penggunaan yang tidak sesuai petunjuk dapat berada di luar cakupan garansi.',
                    'Kerusakan akibat benturan atau cairan dapat dikecualikan sesuai ketentuan penyedia garansi.',
                    'Perbaikan oleh pihak yang tidak berwenang dapat memengaruhi hak garansi.',
                    'Pengecualian harus merujuk pada ketentuan resmi garansi produk.',
                ],
            ],
        ],
    ],

    // 3. PENGEMBALIAN DAN PENGGANTIAN
    'returns' => [
        'title' => 'Pengembalian dan Penggantian',
        'subtitle' => 'Ketentuan pengajuan pengembalian produk',
        'description' => 'Panduan untuk mengajukan pemeriksaan pengembalian atau penggantian produk.',
        'sections' => [
            [
                'heading' => '1. Ketentuan Umum Pengembalian',
                'points' => [
                    'Pengajuan pengembalian atau penggantian harus disertai alasan yang jelas.',
                    'Pengguna perlu menyimpan bukti pembelian dan informasi pesanan.',
                    'Produk, kemasan, aksesori, dan kelengkapan lainnya sebaiknya tetap disimpan.',
                    'Pengajuan diperiksa berdasarkan kondisi produk dan ketentuan transaksi.',
                    'Pengajuan tidak otomatis disetujui sebelum pemeriksaan selesai.',
                ],
            ],
            [
                'heading' => '2. Kondisi yang Perlu Dilaporkan',
                'points' => [
                    'Produk diterima dalam kondisi rusak atau tidak berfungsi.',
                    'Produk yang diterima tidak sesuai dengan pesanan.',
                    'Kelengkapan produk tidak sesuai dengan informasi transaksi.',
                    'Terdapat masalah lain yang dapat dibuktikan melalui dokumentasi.',
                    'Dokumentasikan kondisi paket ketika diterima jika ditemukan masalah.',
                ],
            ],
            [
                'heading' => '3. Prosedur Pengajuan',
                'points' => [
                    'Hubungi layanan pelanggan dengan menyebutkan nomor pesanan.',
                    'Jelaskan nama produk dan alasan pengajuan.',
                    'Lampirkan foto atau video pendukung apabila diperlukan.',
                    'Tunggu instruksi mengenai pemeriksaan, pengemasan, dan pengiriman kembali.',
                    'Jangan mengirimkan produk sebelum memperoleh arahan prosedur pengembalian.',
                ],
            ],
            [
                'heading' => '4. Pemeriksaan dan Penyelesaian',
                'points' => [
                    'Informasi dan kondisi produk akan diperiksa berdasarkan ketentuan transaksi.',
                    'Pengguna dapat diminta memberikan bukti atau informasi tambahan.',
                    'Penyelesaian mengikuti hasil pemeriksaan dan kebijakan yang berlaku.',
                    'Pengembalian dana atau penggantian produk tidak otomatis disetujui.',
                ],
            ],
        ],
    ],

    // 4. KEBIJAKAN PRIVASI
    'privacy' => [
        'title' => 'Kebijakan Privasi',
        'subtitle' => 'Pengelolaan dan perlindungan informasi pengguna',
        'description' => 'Penjelasan mengenai informasi yang digunakan untuk mendukung layanan ELECTROMART.',
        'sections' => [
            [
                'heading' => '1. Informasi yang Dapat Dikumpulkan',
                'points' => [
                    'Informasi akun, seperti nama dan alamat email.',
                    'Informasi kontak, seperti nomor telepon.',
                    'Informasi alamat pengiriman untuk pemrosesan pesanan.',
                    'Informasi transaksi, termasuk detail pesanan, pembayaran, dan pengiriman.',
                    'Informasi komunikasi yang disampaikan kepada layanan pelanggan.',
                ],
            ],
            [
                'heading' => '2. Tujuan Penggunaan Informasi',
                'points' => [
                    'Membuat dan mengelola akun pengguna.',
                    'Memproses pesanan serta mendukung pembayaran dan pengiriman.',
                    'Menghubungi pengguna mengenai transaksi atau kendala layanan.',
                    'Menangani pertanyaan, keluhan, pengembalian, dan klaim garansi.',
                    'Menjaga keamanan layanan serta memenuhi kewajiban hukum.',
                ],
            ],
            [
                'heading' => '3. Penyimpanan dan Perlindungan Data',
                'points' => [
                    'Informasi pengguna perlu dikelola dengan langkah keamanan yang sesuai.',
                    'Akses informasi perlu dibatasi sesuai kebutuhan operasional.',
                    'Pengguna disarankan menjaga kerahasiaan kata sandi.',
                    'Pengguna perlu menghubungi pengelola apabila menduga akun digunakan tanpa izin.',
                ],
            ],
            [
                'heading' => '4. Pembagian dan Hak Pengguna',
                'points' => [
                    'Informasi dapat digunakan oleh pihak yang terlibat dalam pemrosesan transaksi jika diperlukan.',
                    'Penggunaan informasi harus mengikuti ketentuan hukum dan privasi yang berlaku.',
                    'Pengguna dapat menghubungi pengelola untuk menanyakan atau memperbarui informasi akun.',
                    'Permintaan perubahan atau penghapusan data dapat tunduk pada kewajiban penyimpanan berdasarkan hukum.',
                ],
            ],
        ],
    ],

    // 5. SYARAT DAN KETENTUAN
    'terms' => [
        'title' => 'Syarat dan Ketentuan',
        'subtitle' => 'Aturan penggunaan situs ELECTROMART',
        'description' => 'Ketentuan umum penggunaan situs dan fitur ELECTROMART.',
        'sections' => [
            [
                'heading' => '1. Penggunaan Situs',
                'points' => [
                    'Pengguna diharapkan memberikan informasi yang benar ketika membuat akun atau melakukan transaksi.',
                    'Pengguna bertanggung jawab menjaga keamanan akun dan kata sandi.',
                    'Situs tidak boleh digunakan untuk aktivitas yang melanggar hukum.',
                    'Pengguna tidak diperkenankan mengakses atau mengubah data pihak lain tanpa izin.',
                ],
            ],
            [
                'heading' => '2. Informasi Produk dan Harga',
                'points' => [
                    'Periksa nama, deskripsi, spesifikasi, dan harga produk sebelum memesan.',
                    'Ketersediaan produk dapat berubah mengikuti kondisi stok.',
                    'Ketidaksesuaian informasi dapat ditanyakan kepada layanan pelanggan.',
                    'Periksa detail transaksi sebelum pesanan dikonfirmasi.',
                ],
            ],
            [
                'heading' => '3. Pesanan dan Pembayaran',
                'points' => [
                    'Pesanan diproses sesuai informasi pengguna dan status transaksi.',
                    'Pengguna harus mengikuti instruksi pembayaran yang tersedia.',
                    'Bukti pembayaran sebaiknya disimpan.',
                    'Status pesanan dapat berubah sesuai proses verifikasi.',
                    'Kendala pembayaran dapat dilaporkan dengan menyertakan informasi transaksi.',
                ],
            ],
            [
                'heading' => '4. Tanggung Jawab Pengguna',
                'points' => [
                    'Pastikan data kontak dan alamat pengiriman sudah benar.',
                    'Baca kebijakan garansi, pengembalian, dan pengiriman yang relevan.',
                    'Penyalahgunaan fitur dapat ditangani sesuai ketentuan yang berlaku.',
                    'Ketentuan ini tetap memperhatikan hak konsumen dan peraturan perundang-undangan.',
                ],
            ],
        ],
    ],

    // 6. PANDUAN PENGIRIMAN
    'shipping' => [
        'title' => 'Panduan Pengiriman',
        'subtitle' => 'Ketentuan proses pengiriman pesanan',
        'description' => 'Informasi yang perlu diperhatikan sebelum dan setelah pesanan dikirim.',
        'sections' => [
            [
                'heading' => '1. Alamat Pengiriman',
                'points' => [
                    'Pastikan nama penerima ditulis dengan benar.',
                    'Masukkan nomor telepon penerima yang aktif.',
                    'Lengkapi alamat, kecamatan, kota atau kabupaten, provinsi, dan kode pos.',
                    'Tambahkan petunjuk lokasi jika diperlukan.',
                    'Periksa kembali alamat sebelum menyelesaikan pesanan.',
                ],
            ],
            [
                'heading' => '2. Ketentuan Pengiriman',
                'points' => [
                    'Pesanan diproses sesuai status transaksi dan kesiapan produk.',
                    'Pengiriman dilakukan ke alamat yang tercantum dalam pesanan.',
                    'Waktu pengiriman bergantung pada tujuan, ekspedisi, dan kondisi operasional.',
                    'Biaya pengiriman mengikuti informasi yang ditampilkan atau disepakati saat transaksi.',
                    'Keterlambatan dapat terjadi akibat cuaca, kendala operasional, hari libur, atau keadaan lainnya.',
                ],
            ],
            [
                'heading' => '3. Penerimaan Barang',
                'points' => [
                    'Pastikan penerima dapat dihubungi ketika pesanan diperkirakan tiba.',
                    'Periksa kondisi kemasan saat menerima paket.',
                    'Dokumentasikan kemasan jika terlihat rusak.',
                    'Periksa produk dan kelengkapannya setelah paket diterima.',
                    'Simpan bukti penerimaan apabila ditemukan masalah.',
                ],
            ],
            [
                'heading' => '4. Nomor Resi dan Pelacakan',
                'points' => [
                    'Nomor resi dapat digunakan untuk memeriksa perkembangan pengiriman apabila tersedia.',
                    'Pembaruan pelacakan bergantung pada informasi dari ekspedisi.',
                    'Jika status tidak berubah dalam waktu yang tidak wajar, hubungi layanan pelanggan.',
                    'Simpan informasi pesanan sampai barang diterima dan tidak ada kendala.',
                ],
            ],
            [
                'heading' => '5. Kendala Pengiriman',
                'points' => [
                    'Pastikan alamat dan nomor telepon yang dicantumkan sudah benar.',
                    'Jika kurir tidak berhasil menghubungi penerima, ikuti petunjuk ekspedisi.',
                    'Laporkan paket yang diduga hilang atau salah kirim dengan menyertakan informasi transaksi.',
                    'Penyelesaian mengikuti hasil penelusuran dan ketentuan ekspedisi.',
                ],
            ],
        ],
    ],

    // 7. PUSAT BANTUAN
    'help' => [
        'title' => 'Pusat Bantuan',
        'subtitle' => 'Panduan bantuan pelanggan ELECTROMART',
        'description' => 'Panduan awal untuk pertanyaan mengenai produk dan transaksi.',
        'sections' => [
            [
                'heading' => '1. Bantuan Mengenai Produk',
                'points' => [
                    'Buka halaman produk untuk membaca deskripsi dan spesifikasi.',
                    'Periksa merek, kategori, harga, dan informasi stok sebelum membeli.',
                    'Catat nama produk yang ingin ditanyakan.',
                    'Mintalah klarifikasi apabila ada spesifikasi yang belum jelas.',
                ],
            ],
            [
                'heading' => '2. Bantuan Akun',
                'points' => [
                    'Gunakan email dan kata sandi terdaftar untuk masuk.',
                    'Pastikan informasi profil dan kontak tetap benar.',
                    'Jangan membagikan kata sandi atau kode keamanan.',
                    'Hubungi layanan pelanggan jika mengalami masalah akses akun.',
                ],
            ],
            [
                'heading' => '3. Bantuan Pesanan dan Pembayaran',
                'points' => [
                    'Siapkan nomor pesanan ketika menanyakan status transaksi.',
                    'Simpan bukti pembayaran untuk membantu pemeriksaan.',
                    'Jelaskan kendala secara rinci.',
                    'Hindari mengirimkan informasi sensitif yang tidak diperlukan.',
                ],
            ],
            [
                'heading' => '4. Bantuan Pengiriman dan Pengembalian',
                'points' => [
                    'Siapkan nomor pesanan atau resi untuk pertanyaan pengiriman.',
                    'Sertakan dokumentasi kondisi barang apabila produk rusak atau tidak sesuai.',
                    'Ikuti instruksi layanan pelanggan sebelum mengirimkan produk.',
                    'Baca Panduan Pengiriman dan Pengembalian dan Penggantian untuk informasi tambahan.',
                ],
            ],
            [
                'heading' => '5. Menghubungi Layanan Pelanggan',
                'points' => [
                    'Hubungi WhatsApp atau telepon melalui nomor pada footer ELECTROMART.',
                    'Pertanyaan tertulis dapat dikirim ke alamat email layanan pelanggan.',
                    'Sertakan informasi yang relevan agar pertanyaan dapat ditangani dengan efektif.',
                    'Waktu respons bergantung pada jam operasional dan jenis kendala.',
                ],
            ],
        ],
    ],
];

// DAFTAR ROUTE HALAMAN FOOTER
foreach ($footerPages as $slug => $data) {
    Route::get('/' . $slug, function () use ($data) {
        return view('pages.footer-info', compact('data'));
    })->name('footer.' . $slug);
}


/*
|--------------------------------------------------------------------------
| LOGIN DAN REGISTRASI
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [UserController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [UserController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [UserController::class, 'register'])
        ->name('register.process');
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| KHUSUS USER / PELANGGAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'user'])->group(function () {
      // ULASAN PRODUK
    Route::post('/produk/{id}/ulasan', [
        UlasanProdukController::class,
        'store',
    ])->name('ulasan.store');

    // PROFIL
    Route::get('/akun', [UserController::class, 'profile'])
        ->name('account.profile');

    Route::get('/akun/edit', [UserController::class, 'editProfile'])
        ->name('account.edit');

    Route::put('/akun/edit', [UserController::class, 'updateProfile'])
        ->name('account.update');

    // GANTI PASSWORD
    Route::get('/akun/ganti-password', [
        UserController::class,
        'showChangePassword',
    ])->name('password.edit');

    Route::put('/akun/ganti-password', [
        UserController::class,
        'changePassword',
    ])->name('password.update');

    // KERANJANG / CART
    Route::get('/cart', [KeranjangController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add/{id}', [KeranjangController::class, 'tambah'])
        ->name('cart.add');

    Route::patch('/cart/{id}', [KeranjangController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{id}', [KeranjangController::class, 'hapus'])
        ->name('cart.remove');

       
    // ALAMAT PENGIRIMAN PELANGGAN

    // Dropdown kabupaten/kota berdasarkan provinsi
    Route::get('/wilayah/kota/{kode_provinsi}', [
        AlamatPelangganController::class,
        'getKota',
    ])->name('wilayah.kota');

    // Dropdown kecamatan berdasarkan kabupaten/kota
    Route::get('/wilayah/kecamatan/{kode_kota}', [
        AlamatPelangganController::class,
        'getKecamatan',
    ])->name('wilayah.kecamatan');

    // Daftar alamat pelanggan
    Route::get('/akun/alamat', [AlamatPelangganController::class, 'index'])
        ->name('alamat.index');

    // Form tambah alamat
    Route::get('/akun/alamat/tambah', [AlamatPelangganController::class, 'create'])
        ->name('alamat.create');

    // Simpan alamat
    Route::post('/akun/alamat', [AlamatPelangganController::class, 'store'])
        ->name('alamat.store');

    // Hapus alamat
    Route::delete('/akun/alamat/{id_alamat}', [AlamatPelangganController::class, 'destroy'])
        ->name('alamat.destroy');

    // CHECKOUT PELANGGAN
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
    
        // PESANAN SAYA - PELANGGAN
    Route::get('/pesanan-saya', [
        PesananPelangganController::class,
        'index',
    ])->name('pesanan-saya.index');

    Route::get('/pesanan-saya/{id}', [
        PesananPelangganController::class,
        'show',
    ])->name('pesanan-saya.show');
    // KERANJANG
    Route::get('/keranjang', [KeranjangController::class, 'index'])
        ->name('keranjang.index');

    Route::post('/keranjang/tambah/{id_produk}', [
        KeranjangController::class,
        'tambah',
    ])->name('keranjang.tambah');

    Route::patch('/keranjang/update/{id_detail_keranjang}', [
        KeranjangController::class,
        'update',
    ])->name('keranjang.update');

    Route::delete('/keranjang/hapus/{id_detail_keranjang}', [
        KeranjangController::class,
        'hapus',
    ])->name('keranjang.hapus');
});


/*
|--------------------------------------------------------------------------
| KHUSUS ADMIN ELECTROMART
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD PRODUK
        Route::resource('produk', ProdukController::class)
            ->except(['show']);

        // CRUD KATEGORI
        Route::resource('kategori', KategoriController::class)
            ->except(['show']);

        // CRUD BRAND
        Route::resource('brand', BrandController::class)
            ->except(['show']);

        // STOK
        Route::get('/stok', [StokController::class, 'index'])
            ->name('stok.index');

        Route::get('/stok/{id}/edit', [StokController::class, 'edit'])
            ->name('stok.edit');

        Route::put('/stok/{id}', [StokController::class, 'update'])
            ->name('stok.update');

        // CRUD SUPPLIER
        Route::resource('supplier', SupplierController::class)
            ->except(['show']);

        // CRUD SUPPLIER PRODUK
        Route::resource('supplier-produk', SupplierProdukController::class)
            ->except(['show']);

        // CRUD PEMBELIAN
        Route::resource('pembelian', PembelianController::class);

        // CRUD USER ADMIN
        Route::resource('user', AdminUserController::class)
            ->except(['show']);

        // CRUD ALAMAT
        Route::resource('alamat', AlamatController::class);

        // KERANJANG ADMIN
        Route::resource('keranjang', AdminKeranjangController::class)
            ->only(['index', 'show', 'destroy']);

        // PESANAN
        Route::get('/pesanan', [PesananController::class, 'index'])
            ->name('pesanan.index');

        Route::get('/pesanan/{id}', [PesananController::class, 'show'])
            ->name('pesanan.show');

        Route::put('/pesanan/{id}/status', [
            PesananController::class,
            'updateStatus',
        ])->name('pesanan.updateStatus');

        // PEMBAYARAN
        Route::get('/pembayaran', [PembayaranController::class, 'index'])
            ->name('pembayaran.index');

        Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])
            ->name('pembayaran.show');

        Route::put('/pembayaran/{id}/status', [
            PembayaranController::class,
            'updateStatus',
        ])->name('pembayaran.updateStatus');

        // RETUR PRODUK
        Route::get('/retur', [ReturProdukController::class, 'index'])
            ->name('retur.index');

        Route::get('/retur/{id}', [ReturProdukController::class, 'show'])
            ->name('retur.show');

        Route::put('/retur/{id}/status', [
            ReturProdukController::class,
            'updateStatus',
        ])->name('retur.updateStatus');

        // PENGIRIMAN
        Route::get('/pengiriman', [PengirimanController::class, 'index'])
            ->name('pengiriman.index');

        Route::get('/pengiriman/{id}', [PengirimanController::class, 'show'])
            ->name('pengiriman.show');

        Route::put('/pengiriman/{id}/status', [
            PengirimanController::class,
            'updateStatus',
        ])->name('pengiriman.updateStatus');

        // CRUD EKSPEDISI
        Route::resource('ekspedisi', EkspedisiController::class)
            ->except(['show']);

        // CRUD BANK
        Route::resource('bank', BankController::class)
            ->except(['show']);

        // ULASAN PRODUK ADMIN
        Route::get('/ulasan', [AdminUlasanProdukController::class, 'index'])
            ->name('ulasan.index');

        Route::delete('/ulasan/{id}', [AdminUlasanProdukController::class, 'destroy'])
            ->name('ulasan.destroy');
    });