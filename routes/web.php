<?php

use App\Http\Controllers\KaryawanAuthController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login-choice');
})->name('login');

Route::redirect('/', '/login');

Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');

Route::prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/login', [KaryawanAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [KaryawanAuthController::class, 'login'])->name('authenticate');
    Route::post('/logout', [KaryawanAuthController::class, 'logout'])->name('logout');
    Route::get('/', [KaryawanAuthController::class, 'dashboard'])->name('dashboard');
});
