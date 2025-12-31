<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Project;
use App\Http\Controllers\ProjectController;

// dashboard pages
Route::get('/', function () {
    return view('pages.dashboard.ecommerce', ['title' => 'E-commerce Dashboard']);
})->name('dashboard');

// calender pages
Route::get('/calendar', function () {
    return view('pages.calender', ['title' => 'Calendar']);
})->name('calendar');

// projects pages
Route::get('/projects', function () {
   $projects = Project::with('user')->latest()->get();
    return view('pages.projects.project', ['title' => 'Projects', 'projects' => $projects]);
})->name('project');

// create a task (or subtask) for a project
Route::post('projects/{project}/tasks', [ProjectController::class, 'addTask'])->name('projects.tasks.store');
// task edit page
Route::get('projects/{project}/tasks/{task}/edit', [ProjectController::class, 'editTask'])->name('projects.tasks.edit');
// task update
Route::patch('projects/{project}/tasks/{task}', [ProjectController::class, 'updateTask'])->name('projects.tasks.update');
// subtask edit page
Route::get('projects/{project}/tasks/{task}/subtasks/{subtask}/edit', [ProjectController::class, 'editSubtask'])->name('projects.tasks.subtasks.edit');
// subtask update
Route::patch('projects/{project}/tasks/{task}/subtasks/{subtask}', [ProjectController::class, 'updateSubtask'])->name('projects.tasks.subtasks.update');

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

Route::get('/signup', function () {
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






















