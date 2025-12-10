<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks
        Schema::disableForeignKeyConstraints();
        // Clear the table before seeding
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        // --- Top Sales Products ---
        $products = [
            [
                'name' => 'Strawberry Bliss Pancakes',
                'category' => 'Snacks',
                'brand' => 'SweetHeaven',
                'price' => 7.99,
                'regular_price' => 9.99,
                'discount_type' => 'percent',
                'discount_value' => 12.5,
                'tax_rate' => 0.06,
                'rating' => 4.0,
                'is_top_sale' => true,
                'stock_quantity' => 120,
                'weight' => 0.25,
                'length' => 12.0,
                'width' => 12.0,
                'height' => 4.0,
                'image' => 'images/products/strawberry_bliss_pancakes.png',
                'description' => 'Fluffy pancakes topped with fresh strawberries, whipped cream, and a drizzle of syrup.',
            ],
            [
                'name' => 'Mega Cheese Burger',
                'category' => 'Food',
                'brand' => 'BurgerTown',
                'price' => 12.99,
                'regular_price' => 14.99,
                'discount_type' => 'fixed',
                'discount_value' => 0.50,
                'tax_rate' => 0.06,
                'rating' => 4.5,
                'is_top_sale' => true,
                'stock_quantity' => 85,
                'weight' => 0.45,
                'length' => 15.0,
                'width' => 15.0,
                'height' => 8.0,
                'image' => 'images/products/mega_cheese_burger.png',
                'description' => 'Juicy beef patty stacked with double cheese, lettuce, tomato, and house special sauce.',
            ],
            [
                'name' => 'Fresh Orange Juice',
                'category' => 'Drinks',
                'brand' => 'NatureSip',
                'price' => 3.99,
                'regular_price' => 4.50,
                'discount_type' => 'percent',
                'discount_value' => 10,
                'tax_rate' => 0.06,
                'rating' => 4.2,
                'is_top_sale' => true,
                'stock_quantity' => 200,
                'weight' => 0.35,
                'length' => 6.0,
                'width' => 6.0,
                'height' => 16.0,
                'image' => 'images/products/fresh_orange_juice.png',
                'description' => 'Refreshing and freshly squeezed orange juice, rich in vitamin C.',
            ],
            [
                'name' => 'Crispy French Fries',
                'category' => 'Snacks',
                'brand' => 'FryMaster',
                'price' => 4.49,
                'regular_price' => 5.00,
                'discount_type' => 'fixed',
                'discount_value' => 0.30,
                'tax_rate' => 0.06,
                'rating' => 3.9,
                'is_top_sale' => true,
                'stock_quantity' => 150,
                'weight' => 0.30,
                'length' => 10.0,
                'width' => 10.0,
                'height' => 5.0,
                'image' => 'images/products/crispy_french_fries.png',
                'description' => 'Golden, crispy fries served with a side of tangy ketchup.',
            ],

            // --- New Listing Products ---
            [
                'name' => 'Green Veggie Salad',
                'category' => 'Healthy',
                'brand' => 'FreshFarm',
                'price' => 9.99,
                'regular_price' => 11.00,
                'discount_type' => 'percent',
                'discount_value' => 5,
                'tax_rate' => 0.06,
                'rating' => 4.8,
                'is_top_sale' => false,
                'stock_quantity' => 70,
                'weight' => 0.35,
                'length' => 14.0,
                'width' => 14.0,
                'height' => 6.0,
                'image' => 'images/products/green_veggie_salad.png',
                'description' => 'A refreshing mix of lettuce, cucumbers, cherry tomatoes, and avocado with light dressing.',
            ],
            [
                'name' => 'Chicken Caesar Wrap',
                'category' => 'Food',
                'brand' => 'UrbanEats',
                'price' => 11.50,
                'regular_price' => 12.50,
                'discount_type' => 'fixed',
                'discount_value' => 0.40,
                'tax_rate' => 0.06,
                'rating' => 4.6,
                'is_top_sale' => false,
                'stock_quantity' => 60,
                'weight' => 0.40,
                'length' => 18.0,
                'width' => 8.0,
                'height' => 6.0,
                'image' => 'images/products/chicken_caesar_wrap.png',
                'description' => 'Grilled chicken, romaine lettuce, parmesan cheese, and Caesar dressing wrapped in a tortilla.',
            ],
            [
                'name' => 'Spicy Tuna Roll',
                'category' => 'Snacks',
                'brand' => 'SushiWave',
                'price' => 8.99,
                'regular_price' => 10.00,
                'discount_type' => 'fixed',
                'discount_value' => 0.50,
                'tax_rate' => 0.06,
                'rating' => 4.5,
                'is_top_sale' => false,
                'stock_quantity' => 50,
                'weight' => 0.30,
                'length' => 12.0,
                'width' => 12.0,
                'height' => 5.0,
                'image' => 'images/products/spicy_tuna_roll.png',
                'description' => 'Delicious sushi roll with spicy tuna filling, rice, and seaweed.',
            ],
            [
                'name' => 'Beef Burrito',
                'category' => 'Food',
                'brand' => 'MexiFiesta',
                'price' => 13.99,
                'regular_price' => 15.00,
                'discount_type' => 'percent',
                'discount_value' => 4,
                'tax_rate' => 0.06,
                'rating' => 4.7,
                'is_top_sale' => false,
                'stock_quantity' => 90,
                'weight' => 0.60,
                'length' => 20.0,
                'width' => 8.0,
                'height' => 7.0,
                'image' => 'images/products/beef_burrito.png',
                'description' => 'A hearty burrito stuffed with seasoned beef, beans, rice, and salsa.',
            ],
            [
                'name' => 'Avocado Toast',
                'category' => 'Healthy',
                'brand' => 'MorningBite',
                'price' => 8.49,
                'regular_price' => 9.50,
                'discount_type' => 'percent',
                'discount_value' => 7,
                'tax_rate' => 0.06,
                'rating' => 4.4,
                'is_top_sale' => false,
                'stock_quantity' => 110,
                'weight' => 0.20,
                'length' => 10.0,
                'width' => 10.0,
                'height' => 3.0,
                'image' => 'images/products/avocado_toast.png',
                'description' => 'Crispy toasted bread topped with creamy mashed avocado and a sprinkle of chili flakes.',
            ],
            [
                'name' => 'Mango Smoothie',
                'category' => 'Drinks',
                'brand' => 'FruitFusion',
                'price' => 5.99,
                'regular_price' => 6.50,
                'discount_type' => 'fixed',
                'discount_value' => 0.20,
                'tax_rate' => 0.06,
                'rating' => 4.9,
                'is_top_sale' => false,
                'stock_quantity' => 180,
                'weight' => 0.40,
                'length' => 7.0,
                'width' => 7.0,
                'height' => 16.0,
                'image' => 'images/products/mango_smoothie.png',
                'description' => 'Sweet and creamy mango smoothie blended with fresh mangoes and yogurt.',
            ],
        ];

        // Create detailed seeded products
        foreach ($products as $data) {
            // Handle Image Seeding
            $imagePath = null;
            if (isset($data['image'])) {
                $sourcePath = public_path($data['image']);
                if (file_exists($sourcePath)) {
                    $filename = basename($data['image']);
                    $destinationPath = 'products/' . $filename;

                    // Ensure directory exists
                    if (!Storage::disk('public')->exists('products')) {
                        Storage::disk('public')->makeDirectory('products');
                    }

                    // Copy file to storage
                    Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));

                    // Update image path for DB
                    $imagePath = $destinationPath;
                }
            }

            Product::create(array_merge($data, [
                'slug' => Str::slug($data['name']),
                'sku' => strtoupper(Str::random(8)),
                'discounted_price' => $this->calculateDiscountedPrice($data),
                'is_featured' => rand(0, 1),
                'vendor_id' => rand(1, 3),
                'image' => $imagePath, // Use the new storage path
            ]));
        }

        // Generate additional random products
        Product::factory(8)->create();
    }

    /**
     * Calculate discounted price dynamically.
     */
    private function calculateDiscountedPrice(array $product): float
    {
        if ($product['discount_type'] === 'percent') {
            return $product['regular_price'] - ($product['regular_price'] * ($product['discount_value'] / 100));
        }

        if ($product['discount_type'] === 'fixed') {
            return $product['regular_price'] - $product['discount_value'];
        }

        return $product['price'];
    }
}
