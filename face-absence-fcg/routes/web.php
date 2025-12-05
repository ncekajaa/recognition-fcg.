<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\DataController;

// Halaman Absensi
Route::get('/', [AbsenController::class, 'index'])->name('absen.index');
Route::post('/check-username', [AbsenController::class, 'checkUsername'])->name('absen.checkUsername');
Route::post('/submit-absen', [AbsenController::class, 'submitAbsen'])->name('absen.submit');

// Dashboard & CRUD
Route::get('/dashboard', [DataController::class, 'dashboard'])->name('dashboard');
Route::post('/user/store', [DataController::class, 'store'])->name('user.store');
Route::delete('/user/{id}', [DataController::class, 'destroy'])->name('user.destroy');
Route::delete('/absen/{id}', [DataController::class, 'destroyAbsen'])->name('absen.destroy');