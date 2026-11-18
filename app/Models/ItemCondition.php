<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_detail_id',
        'checked_by',
        'condition_before',
        'condition_after',
        'notes',
    ];

    // Relasi: Terkait dengan detail barang yang dipinjam
    public function borrowDetail()
    {
        return $this->belongsTo(BorrowDetail::class);
    }

    // Relasi: Petugas yang melakukan pengecekan fisik barang
    public function checkedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}