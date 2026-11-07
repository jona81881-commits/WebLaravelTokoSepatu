<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Sepatu Kets', 'Sepatu Lari', 'Formal', 'Kasual', 'Bot'] as $nama) {
            Category::create(['category' => $nama]);
        }
    }
}
