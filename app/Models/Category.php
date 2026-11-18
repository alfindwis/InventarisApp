<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'description',
    ];

    // Relasi: Satu kategori memiliki banyak barang (items)
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}