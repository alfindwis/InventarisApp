<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ==========================================
// 1. ROUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return "Halaman Dashboard Admin";
    })->name('dashboard');

    // Tambahan route manajemen user/setting khusus admin di sini...
});

// ==========================================
// 2. ROUTE KHUSUS PETUGAS
// ==========================================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return "Halaman Dashboard Petugas (Validasi Peminjaman & Stok)";
    })->name('dashboard');

    // Tambahan route kelola barang & verifikasi peminjaman di sini...
});

// ==========================================
// 3. ROUTE KHUSUS PEMINJAM (MAHASISWA)
// ==========================================
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/dashboard', function () {
        return "Halaman Dashboard Peminjam (Katalog & Riwayat)";
    })->name('dashboard');

    // Tambahan route ajukan peminjaman barang di sini...
});

// ==========================================
// 4. ROUTE MULTI-ROLE (Bisa diakses Admin & Petugas)
// ==========================================
Route::middleware(['auth', 'role:admin,petugas'])->prefix('shared')->name('shared.')->group(function () {
    Route::get('/laporan', function () {
        return "Halaman Laporan Peminjaman (Admin & Petugas)";
    })->name('laporan');
});