<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fehérnemű', 'description' => 'Munkaruha fehérnemű és alapruházat'],
            ['name' => 'Felső ruhák', 'description' => 'Munkaruha felső ruhák'],
            ['name' => 'Alsó ruhák', 'description' => 'Munkaruha alsó ruhák'],
            ['name' => 'Cipők', 'description' => 'Munkaruha cipők és lábbelik'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
