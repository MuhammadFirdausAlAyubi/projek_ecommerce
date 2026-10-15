
<?php

use App\Models\Produk;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\UserController;

// HALAMAN UTAMA
Route::get('/', function () {
    $produks = Produk::with(['kategori', 'brand', 'stok'])
        ->orderByDesc('created_at')
        ->limit(8)
        ->get();

    return view('home.dashboard', [
        'produks' => $produks,
    ]);
})->name('home');

// KATALOG SEMUA PRODUK
Route::get('/shop', function () {
    $produks = Produk::with(['kategori', 'brand', 'stok'])
        ->orderBy('nama_produk')
        ->paginate(12)
        ->withQueryString();

    return view('shop.produk', [
        'produks' => $produks,
    ]);
})->name('shop.index');

// HALAMAN KATEGORI
Route::get('/shop/{category}', function ($category) {
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

    $produks = Produk::with(['kategori', 'brand', 'stok'])
        ->whereHas('kategori', function ($query) use ($namaKategori) {
            $query->whereRaw(
                'LOWER(TRIM(nama_kategori)) = ?',
                [strtolower($namaKategori)]
            );
        })
        ->orderBy('nama_produk')
        ->paginate(12)
        ->withQueryString();

    return view('shop.category', [
        'category' => $namaKategori,
        'slug' => $category,
        'produks' => $produks,
    ]);
})->name('shop.category');

// LOGIN DAN REGISTRASI
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

// AKUN, EDIT PROFIL, GANTI PASSWORD, LOGOUT, DAN KERANJANG
Route::middleware('auth')->group(function () {
    Route::get('/akun', [UserController::class, 'profile'])
        ->name('account.profile');

    Route::get('/akun/edit', [UserController::class, 'editProfile'])
        ->name('account.edit');

    Route::put('/akun/edit', [UserController::class, 'updateProfile'])
        ->name('account.update');

    Route::get('/akun/ganti-password', [UserController::class, 'showChangePassword'])
        ->name('password.edit');

    Route::put('/akun/ganti-password', [UserController::class, 'changePassword'])
        ->name('password.update');

    Route::post('/logout', [UserController::class, 'logout'])
        ->name('logout');

    // KERANJANG: URL /cart
    Route::get('/cart', [KeranjangController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add/{id}', [KeranjangController::class, 'tambah'])
        ->name('cart.add');

    Route::patch('/cart/{id}', [KeranjangController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{id}', [KeranjangController::class, 'hapus'])
        ->name('cart.remove');

    // KERANJANG: URL /keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])
        ->name('keranjang.index');

    Route::post('/keranjang/tambah/{id_produk}', [KeranjangController::class, 'tambah'])
        ->name('keranjang.tambah');

    Route::patch('/keranjang/update/{id_detail_keranjang}', [KeranjangController::class, 'update'])
        ->name('keranjang.update');

    Route::delete('/keranjang/hapus/{id_detail_keranjang}', [KeranjangController::class, 'hapus'])
        ->name('keranjang.hapus');
});
