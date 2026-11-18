<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'borrower_id',
        'approved_by',
        'handed_over_by',
        'status',
        'borrow_date',
        'due_date',
        'notes',
    ];

    // Relasi: Peminjam (User dengan role peminjam)
    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    // Relasi: Petugas/Admin yang menyetujui
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Relasi: Petugas yang menyerahkan barang
    public function handedOverBy()
    {
        return $this->belongsTo(User::class, 'handed_over_by');
    }

    // Relasi: Satu transaksi peminjaman memiliki banyak detail barang
    public function details()
    {
        return $this->hasMany(BorrowDetail::class);
    }
}