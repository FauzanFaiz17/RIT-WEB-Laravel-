<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\InventarisController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityUserController;

use App\Http\Controllers\ActivityController;

use App\Models\Project;

// dashboard pages
// landing page
Route::get('/', function () {
    return view('pages.landing', ['title' => 'Landing Page']);
})->name('landing');






Route::middleware(['auth'])->group(function () {

    // Project
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/projects/destroy', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Task
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // untuk kanban
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
});
Route::resource('projects', ProjectController::class);
// profile pages
Route::get('/profile', function () {
    $projects = Project::with('user')->get();

    return view('pages.profile', [
        'title' => 'Profile',
        'projects' => $projects
    ]);
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
Route::post('/surat-store', [SuratController::class, 'store'])->name('surat.store');
Route::get('/surat/{id}', [SuratController::class, 'show'])->name('surat.show');
Route::put('/surat/{id}', [SuratController::class, 'update'])->name('surat.update');
Route::delete('/surat/{id}', [SuratController::class, 'destroy'])->name('surat.destroy');

// --- ROUTE INVENTARIS ---
// 1. Barang
Route::get('/inventaris', [InventarisController::class, 'indexBarang'])->name('inventaris.barang.index');
Route::post('/inventaris/barang', [InventarisController::class, 'storeBarang'])->name('inventaris.barang.store');
Route::put('/inventaris/barang/{id}', [InventarisController::class, 'updateBarang'])->name('inventaris.barang.update');
Route::delete('/inventaris/barang/{id}', [InventarisController::class, 'destroyBarang'])->name('inventaris.barang.destroy');

// 2. Mutasi
Route::post('/inventaris/mutasi', [InventarisController::class, 'storeMutasi'])->name('inventaris.mutasi.store');













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
    // Route::get('/', function () {
    //     return redirect()->route('dashboard');
    // });
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
    // Route lainnya
    Route::put('/profile/photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.photo.update');
});


Route::middleware(['auth'])->group(function () {
    // 1. Route Utama Sidebar (Mengarahkan user ke kalender unitnya sendiri secara otomatis)
    Route::get('/calendar', [ActivityController::class, 'indexGeneral'])->name('calendar.index');

    // 2. Route untuk Memilih Unit (Halaman all_units yang kita buat tadi)
    Route::get('/activities/all', [ActivityController::class, 'allActivities'])->name('activities.all');

    // 3. Route Kalender Berdasarkan ID Unit (Dinamis)
    Route::get('/unit/{unit_id}/activities', [ActivityController::class, 'index'])->name('activities.index');

    // 4. Proses Simpan, Update, dan Hapus
    Route::post('/unit/{unit_id}/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    
    Route::get('/kegiatan', [ActivityController::class, 'indexKegiatan'])->name('kegiatan.index');
    Route::get('/acara', [ActivityController::class, 'indexAcara'])->name('acara.index');

    Route::put('/activities/{id}/drag', [ActivityController::class, 'dragUpdate'])->name('activities.drag');

    
});

Route::get('/notifications/{notification}/read', function ($notificationId) {
    $notification = auth()->user()
        ->notifications()
        ->where('id', $notificationId)
        ->firstOrFail();

    $notification->markAsRead();

    return redirect($notification->data['url']);
})->name('notifications.read');
