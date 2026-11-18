<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_request_id',
        'item_id',
        'quantity',
    ];

    // Relasi: Detail milik satu header transaksi peminjaman
    public function borrowRequest()
    {
        return $this->belongsTo(BorrowRequest::class);
    }

    // Relasi: Menunjuk ke data barang yang dipinjam
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi: Catatan kondisi barang pada detail transaksi ini
    public function itemConditions()
    {
        return $this->hasMany(ItemCondition::class);
    }
}