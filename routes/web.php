<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookDetailController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentHistoryController;
use App\Http\Controllers\StudentStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])
    ->name('home');

Route::get('/landing', [LandingController::class, 'index'])
    ->name('landing');

// Login
Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login.authenticate');

// ============================================================
// STUDENT / MURID
// ============================================================

Route::prefix('murid')
    ->name('student.')
    ->group(function () {

        // Dashboard + Etalase Buku
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard');

        // Detail Buku
        Route::get('/buku/{id}', [BookDetailController::class, 'show'])
            ->name('book.show');

        // Proses Pinjam Buku
        Route::post('/buku/{id}/pinjam', [BookDetailController::class, 'pinjam'])
            ->name('book.pinjam');

        // Status Peminjaman
        Route::get('/status', [StudentStatusController::class, 'index'])
            ->name('status');

        // Proses Kembalikan Buku
        Route::post('/buku/{id}/kembalikan', [StudentStatusController::class, 'kembalikan'])
            ->name('book.kembalikan');

        // History Peminjaman
        Route::get('/history', [StudentHistoryController::class, 'index'])
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
        // Kelola Murid
        // ----------------------------------------------------

        Route::resource('murid', StudentController::class);

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
