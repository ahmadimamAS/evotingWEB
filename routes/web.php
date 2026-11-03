<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;

Route::get('/import-siswa', [SiswaController::class, 'form']);
Route::post('/import-siswa', [SiswaController::class, 'import']);
Route::post('/admin/siswa/hapus-kelas', [SiswaController::class, 'hapusKelas']);
Route::post('/admin/siswa/hapus-nama', [SiswaController::class, 'hapusNama']);
Route::post('/admin/siswa/hapus-semua', [SiswaController::class, 'hapusSemua']);

// Public Routes - Landing Page
Route::get('/', [HomeController::class, 'index']);
Route::get('/profil', [HomeController::class, 'profil']);
Route::get('/informasi', [HomeController::class, 'informasi']);
Route::get('/kandidat', [HomeController::class, 'daftarKandidat']);

// Auth Routes
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login.form');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');
Route::get('/siswa/login', [AuthController::class, 'showSiswaLogin'])->name('siswa.login.form');
Route::post('/siswa/login', [AuthController::class, 'siswaLogin'])->name('siswa.login');

Route::get('/siswa/registrasi', [AuthController::class, 'showSiswaRegister'])->name('siswa.register.form');
Route::post('/siswa/registrasi', [AuthController::class, 'siswaRegister'])->name('siswa.register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Data Siswa CRUD
    Route::get('/siswa', [AdminController::class, 'siswaIndex'])->name('admin.siswa.index');
    Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('admin.siswa.store');
    Route::put('/siswa/{id}', [AdminController::class, 'siswaUpdate'])->name('admin.siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('admin.siswa.destroy');
    Route::post('/siswa/{id}/reset', [AdminController::class, 'siswaReset'])->name('admin.siswa.reset');
    
    // Data Kandidat CRUD
    Route::get('/kandidat', [AdminController::class, 'kandidatIndex'])->name('admin.kandidat.index');
    Route::post('/kandidat', [AdminController::class, 'kandidatStore'])->name('admin.kandidat.store');
    Route::put('/kandidat/{id}', [AdminController::class, 'kandidatUpdate'])->name('admin.kandidat.update');
    Route::delete('/kandidat/{id}', [AdminController::class, 'kandidatDestroy'])->name('admin.kandidat.destroy');
    
    // Pengaturan Voting
    Route::get('/pengaturan', [AdminController::class, 'pengaturan'])->name('admin.pengaturan');
    Route::post('/pengaturan', [AdminController::class, 'pengaturanUpdate'])->name('admin.pengaturan.update');
    
    // Hasil Voting
    Route::get('/hasil', [AdminController::class, 'hasil'])->name('admin.hasil');
    
    // Reset Voting
    Route::post('/reset-voting', [AdminController::class, 'resetVoting'])->name('admin.resetVoting');
});

// Siswa Routes (Protected)
Route::prefix('siswa')->middleware(['auth:siswa'])->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/voting', [SiswaController::class, 'voting'])->name('siswa.voting');
    Route::post('/voting', [SiswaController::class, 'votingStore'])->name('siswa.voting.store');
    Route::get('/status', [SiswaController::class, 'status'])->name('siswa.status');
});

