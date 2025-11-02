<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Англійські картки - Початковий рівень',
            'description' => 'Базові слова та фрази англійської мови',
            'price' => 299.00,
            'image' => 'images/english-basic.jpg',
            'language' => 'Англійська',
            'level' => 'Початковий',
            'card_count' => 500
        ]);

        Product::create([
            'name' => 'Німецькі картки - Середній рівень',
            'description' => 'Словниковий запас для середнього рівня німецької',
            'price' => 349.00,
            'image' => 'images/german-intermediate.jpg',
            'language' => 'Німецька',
            'level' => 'Середній',
            'card_count' => 750
        ]);

        Product::create([
            'name' => 'Французькі картки - Просунутий рівень',
            'description' => 'Складні фрази та ідіоми французької мови',
            'price' => 399.00,
            'image' => 'images/french-advanced.jpg',
            'language' => 'Французька',
            'level' => 'Просунутий',
            'card_count' => 1000
        ]);
    }
}
