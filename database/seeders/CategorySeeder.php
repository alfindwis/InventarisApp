<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'category_name' => 'Elektronik & IT',
            'description' => 'Perangkat komputer, proyektor, dan aksesoris.',
        ]);

        Category::create([
            'category_name' => 'Alat Praktikum / Lab',
            'description' => 'Peralatan jaringan dan mikrokontroler.',
        ]);
    }
}