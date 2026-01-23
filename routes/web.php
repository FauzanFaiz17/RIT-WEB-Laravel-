<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;

/*
|--------------------------------------------------------------------------
| 1. STATIC & UI TEMPLATE ROUTES
|--------------------------------------------------------------------------
| Rute-rute ini digunakan untuk menampilkan halaman statis dan elemen UI
| bawaan template.
*/

// Dashboard Template Page
Route::get('/', function () {
    return view('pages.dashboard.ecommerce', ['title' => 'E-commerce Dashboard']);
})->name('dashboard.template'); // Dibedakan namanya agar tidak konflik dengan dashboard utama

// Profile Template
Route::get('/profile-template', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile.template');

// Form & Tables
Route::get('/form-elements', function () {
    return view('pages.form.form-elements', ['title' => 'Form Elements']);
})->name('form-elements');

Route::get('/basic-tables', function () {
    return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
})->name('basic-tables');

// Utility Pages (Blank, Error, Charts)
Route::get('/blank', function () {
    return view('pages.blank', ['title' => 'Blank']);
})->name('blank');

Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

Route::get('/line-chart', function () {
    return view('pages.chart.line-chart', ['title' => 'Line Chart']);
})->name('line-chart');

Route::get('/bar-chart', function () {
    return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
})->name('bar-chart');

// Auth UI Pages (Static Views)
Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Sign In']);
})->name('signin');

Route::get('/signup', function () {
    return view('pages.auth.signup', ['title' => 'Sign Up']);
})->name('signup');

// UI Elements (Alerts, Buttons, etc.)
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


/*
|--------------------------------------------------------------------------
| 2. GUEST AUTHENTICATION ROUTES (BELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| 3. AUTHENTICATED USER ROUTES (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- Logout Action ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- Main Dashboard ---
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    // --- Profile Management ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.photo.update');

    // --- Community & Members Management ---
    
    // 1. Division List (Children of Community)
    Route::get('/community/{name}', [CommunityUserController::class, 'indexDivisions'])
        ->name('community.divisions');

    // 2. Member List (Within Division)
    Route::get('/community/{name}/members', [CommunityUserController::class, 'indexMembers'])
        ->name('member.list');

    // 3. Member CRUD Operations
    Route::get('/community-user/create', [CommunityUserController::class, 'create'])->name('community_user.create');
    Route::post('/community-user/store', [CommunityUserController::class, 'store'])->name('community_user.store');
    Route::get('/community-user/{id}/edit', [CommunityUserController::class, 'edit'])->name('community_user.edit');
    Route::put('/community-user/{id}', [CommunityUserController::class, 'update'])->name('community_user.update');
    Route::delete('/community-user/{id}', [CommunityUserController::class, 'destroy'])->name('community_user.destroy');

});


/*
|--------------------------------------------------------------------------
| 4. ACTIVITY & CALENDAR MANAGEMENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Main Calendar Route (Auto-redirect to user's unit)
    Route::get('/calendar', [ActivityController::class, 'indexGeneral'])->name('calendar.index');

    // Unit Selection Page
    Route::get('/activities/all', [ActivityController::class, 'allActivities'])->name('activities.all');

    // Dynamic Calendar (By Unit ID)
    Route::get('/unit/{unit_id}/activities', [ActivityController::class, 'index'])->name('activities.index');

    // Activity CRUD & Process
    Route::post('/unit/{unit_id}/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    
    // Categorized Activity Lists
    Route::get('/kegiatan', [ActivityController::class, 'indexKegiatan'])->name('kegiatan.index');
    Route::get('/acara', [ActivityController::class, 'indexAcara'])->name('acara.index');

    // Drag & Drop Calendar Update
    Route::put('/activities/{id}/drag', [ActivityController::class, 'dragUpdate'])->name('activities.drag');
});