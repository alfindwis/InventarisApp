<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::create([
            'category_id' => 1, // Pastikan kategori ID 1 ada
            'item_code' => 'ITM-ELK-001',
            'item_name' => 'Proyektor Epson EB-S400',
            'stock_total' => 5,
            'stock_available' => 5,
            'stock_borrowed' => 0,
            'stock_damaged' => 0,
            'stock_lost' => 0,
            'minimum_stock' => 1,
        ]);
    }
}