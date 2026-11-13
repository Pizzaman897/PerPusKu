<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookDetailController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserHistoryController;
use App\Http\Controllers\UserStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])
    ->name('home');

Route::get('/landing', [LandingController::class, 'index'])
    ->name('landing');

// Register
Route::get('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/register', [AuthController::class, 'store'])
    ->name('register.store');

// Login
Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login.authenticate');

// ============================================================
// USER
// ============================================================

Route::prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard + Etalase Buku
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        // Detail Buku
        Route::get('/buku/{id}', [BookDetailController::class, 'show'])
            ->name('book.show');

        // Proses Pinjam Buku
        Route::post('/buku/{id}/pinjam', [BookDetailController::class, 'pinjam'])
            ->name('book.pinjam');

        // Status Peminjaman
        Route::get('/status', [UserStatusController::class, 'index'])
            ->name('status');

        // Proses Kembalikan Buku
        Route::post('/buku/{id}/kembalikan', [UserStatusController::class, 'kembalikan'])
            ->name('book.kembalikan');

        // History Peminjaman
        Route::get('/history', [UserHistoryController::class, 'index'])
            ->name('history');

        // Logout
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });

// ============================================================
// ADMIN
// ============================================================

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ----------------------------------------------------
        // Kelola Buku
        // ----------------------------------------------------

        Route::resource('buku', BookController::class);

        // ----------------------------------------------------
        // Kelola User
        // ----------------------------------------------------

        Route::resource('users', UserController::class);

        // ----------------------------------------------------
        // Kelola Admin
        // ----------------------------------------------------

        Route::name('kelola-admin.')->prefix('kelola-admin')->group(function () {
            Route::get('/', [AdminManagementController::class, 'index'])->name('index');
            Route::get('/create', [AdminManagementController::class, 'create'])->name('create');
            Route::post('/', [AdminManagementController::class, 'store'])->name('store');
            Route::get('/{admin}', [AdminManagementController::class, 'show'])->name('show');
            Route::get('/{admin}/edit', [AdminManagementController::class, 'edit'])->name('edit');
            Route::put('/{admin}', [AdminManagementController::class, 'update'])->name('update');
            Route::delete('/{admin}', [AdminManagementController::class, 'destroy'])->name('destroy');
        });

        // ----------------------------------------------------
        // Kelola Status Peminjaman
        // ----------------------------------------------------

        Route::get('/status', [BorrowingController::class, 'index'])
            ->name('status.index');

        Route::put('/status/{id}', [BorrowingController::class, 'update'])
            ->name('status.update');

        // ----------------------------------------------------
        // Logout
        // ----------------------------------------------------

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });
