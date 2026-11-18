<?php

namespace Database\Seeders;

use App\Models\BorrowRequest;
use App\Models\BorrowDetail;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class BorrowRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user dengan role peminjam dan item pertama
        $peminjam = User::where('role', 'peminjam')->first();
        $petugas = User::where('role', 'petugas')->first();
        $item = Item::first();

        if ($peminjam && $item) {
            // 1. Buat Header Peminjaman
            $borrowRequest = BorrowRequest::create([
                'transaction_code' => 'TRX-' . date('Ymd') . '-001',
                'borrower_id' => $peminjam->id,
                'approved_by' => $petugas->id,
                'status' => 'APPROVED',
                'borrow_date' => now(),
                'due_date' => now()->addDays(3),
                'notes' => 'Peminjaman proyektor untuk kegiatan praktikum.',
            ]);

            // 2. Buat Detail Barang yang Dipinjam
            BorrowDetail::create([
                'borrow_request_id' => $borrowRequest->id,
                'item_id' => $item->id,
                'quantity' => 1,
            ]);

            // 3. Update stok barang yang dipinjam (opsional sesuai logika bisnis)
            $item->decrement('stock_available', 1);
            $item->increment('stock_borrowed', 1);
        }
    }
}