<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'item_code',
        'item_name',
        'stock_total',
        'stock_available',
        'stock_borrowed',
        'stock_damaged',
        'stock_lost',
        'minimum_stock',
    ];

    // Relasi: Barang milik satu kategori tertentu
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Barang bisa masuk ke banyak detail transaksi peminjaman
    public function borrowDetails()
    {
        return $this->hasMany(BorrowDetail::class);
    }
}