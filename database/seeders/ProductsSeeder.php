<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Munkarovid - XS', 'description' => 'Kék munkarovid extra kicsi méret', 'category_id' => 1, 'location_id' => 1, 'quantity' => 50, 'size' => 'XS'],
            ['name' => 'Munkarovid - S', 'description' => 'Kék munkarovid kicsi méret', 'category_id' => 1, 'location_id' => 1, 'quantity' => 75, 'size' => 'S'],
            ['name' => 'Munkarovid - M', 'description' => 'Kék munkarovid közepes méret', 'category_id' => 1, 'location_id' => 2, 'quantity' => 100, 'size' => 'M'],
            ['name' => 'Munkarovid - L', 'description' => 'Kék munkarovid nagy méret', 'category_id' => 1, 'location_id' => 2, 'quantity' => 80, 'size' => 'L'],
            ['name' => 'Munkarovid - XL', 'description' => 'Kék munkarovid extra nagy méret', 'category_id' => 1, 'location_id' => 3, 'quantity' => 60, 'size' => 'XL'],
            ['name' => 'Munkarovid - XXL', 'description' => 'Kék munkarovid extra extra nagy méret', 'category_id' => 1, 'location_id' => 3, 'quantity' => 40, 'size' => 'XXL'],
            ['name' => 'Munkanadrág - S', 'description' => 'Szürke munkanadrág kicsi méret', 'category_id' => 3, 'location_id' => 4, 'quantity' => 45, 'size' => 'S'],
            ['name' => 'Munkanadrág - M', 'description' => 'Szürke munkanadrág közepes méret', 'category_id' => 3, 'location_id' => 4, 'quantity' => 55, 'size' => 'M'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
