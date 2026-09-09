<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Halaman Login
Route::name('admin.')->prefix('admin')->group(function() {

Route::get('/login',[AdminController::class, 'login'])->name('login');

});