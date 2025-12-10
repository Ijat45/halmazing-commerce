<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('category_product')->truncate();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            ['name' => 'Food', 'icon' => 'fa-solid fa-utensils'],
            ['name' => 'Snacks', 'icon' => 'fa-solid fa-cookie-bite'],
            ['name' => 'Drinks', 'icon' => 'fa-solid fa-mug-hot'],
            ['name' => 'Healthy', 'icon' => 'fa-solid fa-heart-pulse'],
            ['name' => 'Groceries', 'icon' => 'fa-solid fa-basket-shopping'],
            ['name' => 'Fruits', 'icon' => 'fa-solid fa-apple-whole'],
            ['name' => 'Vegetables', 'icon' => 'fa-solid fa-carrot'],
            ['name' => 'Desserts', 'icon' => 'fa-solid fa-ice-cream'],
            ['name' => 'Hot Deals', 'icon' => 'fa-solid fa-fire'],
            ['name' => 'Favorites', 'icon' => 'fa-solid fa-thumbs-up'],
            ['name' => 'Delivery', 'icon' => 'fa-solid fa-truck-fast'],
            ['name' => 'Shops', 'icon' => 'fa-solid fa-store'],
            ['name' => 'Top Rated', 'icon' => 'fa-solid fa-star'],
            ['name' => 'Flash Sale', 'icon' => 'fa-solid fa-bolt-lightning'],
            ['name' => 'Gifts', 'icon' => 'fa-solid fa-gift'],
            ['name' => 'Offers', 'icon' => 'fa-solid fa-tags'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
