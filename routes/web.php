<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BookAreaController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// HomePage
Route::get('/', [UserController::class, 'Index']);

// User Dashboard Routes
Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// User Group Middleware
Route::middleware('auth')->group(function () {
    Route::get('/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

// Admin Group Middleware
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});

// Admin Login Routes
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// Admin Group Middleware
Route::middleware(['auth', 'roles:admin'])->group(function () {
    // Teams Management Routes
    Route::controller(TeamController::class)->group(function () {
        Route::get('/all/team', 'AllTeam')->name('all.team');
    });

    // Book Area Management Routes
    Route::controller(BookAreaController::class)->group(function () {
        Route::get('/all/book_area', 'AllBookArea')->name('all.book.area');
        Route::get('/add/book_area', 'AddBookArea')->name('add.book.area');
        Route::post('/book_area/store', 'StoreBookArea')->name('book_area.store');
        Route::get('/edit/book_area/{id}', 'EditBookArea')->name('edit.book_area');
        Route::post('/book_area/update', 'UpdateBookArea')->name('book_area.update');
        Route::get('/delete/book_area/{id}', 'DeleteBookArea')->name('delete.book_area');
    });
});

// Instructor Group Middleware
Route::middleware(['auth', 'roles:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.dashboard');
});

require __DIR__ . '/auth.php';
