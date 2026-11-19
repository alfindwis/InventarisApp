<?php

use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Aktifkan baris berikut HANYA jika laravel/ui sudah terpasang (atau ganti dengan route auth milikmu)
// Auth::routes();

// Dashboard untuk semua role yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Admin: kelola user, kategori, barang, persetujuan peminjaman & laporan
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);

    Route::get('admin/requests', [BorrowController::class, 'indexAdmin'])->name('admin.requests');
    Route::post('admin/requests/{id}/approve', [BorrowController::class, 'approve'])->name('admin.approve');
    Route::post('admin/requests/{id}/reject', [BorrowController::class, 'reject'])->name('admin.reject');

    Route::get('reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('reports/borrow-history', [ReportController::class, 'borrowHistory'])->name('reports.history');
});

// Petugas: serah-terima barang & proses pengembalian
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('petugas/handovers', [BorrowController::class, 'handoverForm'])->name('petugas.handoverForm');
    Route::post('petugas/handovers/{id}', [BorrowController::class, 'handover'])->name('petugas.handover');

    Route::get('petugas/returns', [ReturnController::class, 'returnForm'])->name('petugas.returnForm');
    Route::post('petugas/returns/{id}', [ReturnController::class, 'processReturn'])->name('petugas.processReturn');
});

// Peminjam: ajukan peminjaman & lihat riwayat pribadi
Route::middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('borrow', [BorrowController::class, 'create'])->name('borrow.create');
    Route::post('borrow', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('my-requests', [BorrowController::class, 'indexUser'])->name('borrow.myrequests');
});