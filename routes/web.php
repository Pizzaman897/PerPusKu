<?php

use App\Http\Controllers\KelolaAdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\BookDetailController;
use App\Http\Controllers\StudentStatusController;
use App\Http\Controllers\StudentHistoryController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\KelolaMuridController;
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
        // Kelola Murid (route utama — dipakai oleh view Kelola-Murid)
        // ----------------------------------------------------

        Route::name('kelola-murid.')->prefix('kelola-murid')->group(function () {
            Route::get('/', [KelolaMuridController::class, 'index'])->name('index');
            Route::get('/create', [KelolaMuridController::class, 'create'])->name('create');
            Route::post('/', [KelolaMuridController::class, 'store'])->name('store');
            Route::get('/{kelola_murid}', [KelolaMuridController::class, 'show'])->name('show');
            Route::get('/{kelola_murid}/edit', [KelolaMuridController::class, 'edit'])->name('edit');
            Route::put('/{kelola_murid}', [KelolaMuridController::class, 'update'])->name('update');
            Route::delete('/{kelola_murid}', [KelolaMuridController::class, 'destroy'])->name('destroy');
        });

        // Alias route lama "murid" -> tetap arahkan ke KelolaMuridController
        // supaya link lama di halaman lain (Dasbor, Kelola-Admin, Buku, dll)
        // yang masih pakai route('admin.murid.xxx') tetap berfungsi.
        Route::name('murid.')->prefix('murid')->group(function () {
            Route::get('/', [KelolaMuridController::class, 'index'])->name('index');
            Route::get('/create', [KelolaMuridController::class, 'create'])->name('create');
            Route::post('/', [KelolaMuridController::class, 'store'])->name('store');
            Route::get('/{kelola_murid}', [KelolaMuridController::class, 'show'])->name('show');
            Route::get('/{kelola_murid}/edit', [KelolaMuridController::class, 'edit'])->name('edit');
            Route::put('/{kelola_murid}', [KelolaMuridController::class, 'update'])->name('update');
            Route::delete('/{kelola_murid}', [KelolaMuridController::class, 'destroy'])->name('destroy');
        });


        // ----------------------------------------------------
        // Kelola Admin
        // ----------------------------------------------------

        Route::name('kelola-admin.')->prefix('kelola-admin')->group(function () {
            Route::get('/', [KelolaAdminController::class, 'index'])->name('index');
            Route::get('/create', [KelolaAdminController::class, 'create'])->name('create');
            Route::post('/', [KelolaAdminController::class, 'store'])->name('store');
            Route::get('/{kelola_admin}', [KelolaAdminController::class, 'show'])->name('show');
            Route::get('/{kelola_admin}/edit', [KelolaAdminController::class, 'edit'])->name('edit');
            Route::put('/{kelola_admin}', [KelolaAdminController::class, 'update'])->name('update');
            Route::delete('/{kelola_admin}', [KelolaAdminController::class, 'destroy'])->name('destroy');
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