<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create super admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'super_admin',
        ]);

        // Create admin
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create regular user
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'role' => 'user',
        ]);

        // Create user profiles
        $superAdmin->profile()->create([
            'full_name' => 'Super Admin User',
            'phone_number' => '+36201234567',
            'address' => '1234 Main St',
            'city' => 'Budapest',
        ]);

        $admin->profile()->create([
            'full_name' => 'Admin User',
            'phone_number' => '+36701234567',
            'address' => '1235 Main St',
            'city' => 'Budapest',
        ]);

        $user->profile()->create([
            'full_name' => 'John Doe Profile',
            'phone_number' => '+36301234567',
            'address' => '1236 Main St',
            'city' => 'Budapest',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Fehérnemű', 'description' => 'Munkaruha fehérnemű és alapruházat'],
            ['name' => 'Felső ruhák', 'description' => 'Munkaruha felső ruhák'],
            ['name' => 'Alsó ruhák', 'description' => 'Munkaruha alsó ruhák'],
            ['name' => 'Cipők', 'description' => 'Munkaruha cipők és lábbelik'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create locations
        $locations = [
            ['building' => 'A', 'row' => '1', 'shelf' => '1'],
            ['building' => 'A', 'row' => '1', 'shelf' => '2'],
            ['building' => 'A', 'row' => '2', 'shelf' => '1'],
            ['building' => 'B', 'row' => '1', 'shelf' => '1'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }

        // Create products
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
