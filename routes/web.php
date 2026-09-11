<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\BookDetailController;
use App\Http\Controllers\StudentStatusController;
use App\Http\Controllers\StudentHistoryController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BorrowingController;

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

        // Status Peminjaman
        Route::get('/status', [StudentStatusController::class, 'index'])
            ->name('status');

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

        Route::resource('admin', AdminController::class);


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