<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\InventarisController;

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects/{project}/gantt', [ProjectController::class, 'gantt'])->name('projects.gantt');


// dashboard pages
Route::get('/', function () {
    return view('pages.dashboard.ecommerce', ['title' => 'E-commerce Dashboard']);
})->name('dashboard');

// calender pages
Route::get('/calendar', function () {
    return view('pages.calender', ['title' => 'Calendar']);
})->name('calendar');

// profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

// form pages
Route::get('/form-elements', function () {
    return view('pages.form.form-elements', ['title' => 'Form Elements']);
})->name('form-elements');

// tables pages
Route::get('/basic-tables', function () {
    return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
})->name('basic-tables');

// pages

Route::get('/blank', function () {
    return view('pages.blank', ['title' => 'Blank']);
})->name('blank');

// error pages
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

// chart pages
Route::get('/line-chart', function () {
    return view('pages.chart.line-chart', ['title' => 'Line Chart']);
})->name('line-chart');

Route::get('/bar-chart', function () {
    return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
})->name('bar-chart');


// authentication pages
Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Sign In']);
})->name('signin');

// Route::get('/signup', function () {
//     return view('pages.auth.signup', ['title' => 'Sign Up']);
// })->name('signup');


// ui elements pages
Route::get('/alerts', function () {
    return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
})->name('alerts');

Route::get('/avatars', function () {
    return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
})->name('avatars');

Route::get('/badge', function () {
    return view('pages.ui-elements.badges', ['title' => 'Badges']);
})->name('badges');

Route::get('/buttons', function () {
    return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
})->name('buttons');

Route::get('/image', function () {
    return view('pages.ui-elements.images', ['title' => 'Images']);
})->name('images');

Route::get('/videos', function () {
    return view('pages.ui-elements.videos', ['title' => 'Videos']);
})->name('videos');



// baru
Route::get('/test', [TestController::class, 'test'])->name('test');

Route::resource('menus', MenuController::class);
Route::resource('menu-items', MenuItemController::class);
Route::post('/menu-items/reorder', [MenuItemController::class, 'reorder'])
    ->name('menu-items.reorder');

Route::get('/signup', [RegisterController::class, 'show'])->name('register');
Route::post('/signup', [RegisterController::class, 'store'])->name('register.store');
Route::get('/two-step-verification', [OtpController::class, 'form'])->name('otp.form');
Route::post('/two-step-verification', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');



// --- USER MANAGEMENT PAGES (CRUD) ---

// 1. Index (Menampilkan daftar semua user)
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// 2. Create (Menampilkan form tambah user baru)
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// 3. Store (Menyimpan data user baru dari form)
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// 4. Show (Menampilkan detail satu user)
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// 5. Edit (Menampilkan form edit user)
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// 6. Update (Memperbarui data user yang sudah ada)
// Metode: PUT/PATCH digunakan untuk pembaruan data
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// 7. Destroy (Menghapus user)
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// --- ROUTE KEUANGAN ---
Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
Route::get('/keuangan/{id}', [KeuanganController::class, 'show'])->name('keuangan.show'); // Detail
Route::put('/keuangan/{id}', [KeuanganController::class, 'update'])->name('keuangan.update');
Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');

// Tambahkan pembungkus Route::middleware(['auth'])
// Route::middleware(['auth'])->group(function () {
    
//     // --- ROUTE SURAT (Sekarang sudah diproteksi) ---
//     Route::get('/surat', [SuratController::class, 'index'])->name('surat.index');
//     Route::post('/surat', [SuratController::class, 'store'])->name('surat.store');
//     Route::get('/surat/{id}', [SuratController::class, 'show'])->name('surat.show');
//     Route::put('/surat/{id}', [SuratController::class, 'update'])->name('surat.update');
//     Route::delete('/surat/{id}', [SuratController::class, 'destroy'])->name('surat.destroy');
// });

// --- ROUTE SURAT ---
Route::get('/surat', [SuratController::class, 'index'])->name('surat.index');
Route::post('/surat', [SuratController::class, 'store'])->name('surat.store');
Route::get('/surat/{id}', [SuratController::class, 'show'])->name('surat.show');
Route::put('/surat/{id}', [SuratController::class, 'update'])->name('surat.update');
Route::delete('/surat/{id}', [SuratController::class, 'destroy'])->name('surat.destroy');

// --- ROUTE INVENTARIS ---
// 1. Barang
Route::get('/inventaris/barang', [InventarisController::class, 'indexBarang'])->name('inventaris.barang.index');
Route::post('/inventaris/barang', [InventarisController::class, 'storeBarang'])->name('inventaris.barang.store');
Route::put('/inventaris/barang/{id}', [InventarisController::class, 'updateBarang'])->name('inventaris.barang.update');
Route::delete('/inventaris/barang/{id}', [InventarisController::class, 'destroyBarang'])->name('inventaris.barang.destroy');

// 2. Mutasi
Route::post('/inventaris/mutasi', [InventarisController::class, 'storeMutasi'])->name('inventaris.mutasi.store');












