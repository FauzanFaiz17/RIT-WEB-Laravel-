<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityUserController;
use App\Http\Controllers\DashboardController;


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

Route::get('/signupu', function () {
    return view('pages.auth.signup', ['title' => 'Sign Up']);
})->name('signup');


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















// 1. ROUTE TAMU (GUEST) - Belum Login
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 2. ROUTE USER - Wajib Login
Route::middleware('auth')->group(function () {
    
    // --- Logout ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- Dashboard ---
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
 Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    
    // --- Fitur Profile ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // --- Fitur Komunitas & Anggota ---

    // 1. Halaman List Divisi (Melihat anak-anak dari Komunitas)
    Route::get('/community/{name}', [CommunityUserController::class, 'indexDivisions'])
        ->name('community.divisions');

    // 2. Halaman List Anggota (Melihat anggota dalam Divisi)
    Route::get('/community/{name}/members', [CommunityUserController::class, 'indexMembers'])
        ->name('member.list');

    // 3. CRUD Anggota (Manual Route)
    
    // Form Tambah Anggota
    Route::get('/community-user/create', [CommunityUserController::class, 'create'])
        ->name('community_user.create');

    // Proses Simpan Data
    Route::post('/community-user/store', [CommunityUserController::class, 'store'])
        ->name('community_user.store');

    // Form Edit Anggota
    Route::get('/community-user/{id}/edit', [CommunityUserController::class, 'edit'])
        ->name('community_user.edit');

    // Proses Update Data
    Route::put('/community-user/{id}', [CommunityUserController::class, 'update'])
        ->name('community_user.update');

    // Proses Hapus Data
    Route::delete('/community-user/{id}', [CommunityUserController::class, 'destroy'])
        ->name('community_user.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Route lainnya...
    Route::put('/profile/photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.photo.update');
});
