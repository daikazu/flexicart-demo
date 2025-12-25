<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Classic T-Shirt',
                'slug' => 'classic-t-shirt',
                'description' => 'A comfortable and stylish cotton t-shirt perfect for everyday wear.',
                'price' => 29.99,
                'category' => 'Clothing',
                'taxable' => true,
                'variants' => ['colors' => ['Black', 'White', 'Navy', 'Gray'], 'sizes' => ['S', 'M', 'L', 'XL']],
            ],
            [
                'name' => 'Premium Hoodie',
                'slug' => 'premium-hoodie',
                'description' => 'Warm and cozy hoodie made from premium cotton blend.',
                'price' => 59.99,
                'category' => 'Clothing',
                'taxable' => true,
                'variants' => ['colors' => ['Black', 'Charcoal', 'Forest Green'], 'sizes' => ['S', 'M', 'L', 'XL', 'XXL']],
            ],
            [
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'description' => 'High-quality wireless headphones with noise cancellation.',
                'price' => 149.99,
                'category' => 'Electronics',
                'taxable' => true,
                'variants' => ['colors' => ['Black', 'White', 'Silver']],
            ],
            [
                'name' => 'Mechanical Keyboard',
                'slug' => 'mechanical-keyboard',
                'description' => 'Professional mechanical keyboard with RGB lighting.',
                'price' => 89.99,
                'category' => 'Electronics',
                'taxable' => true,
                'variants' => ['colors' => ['Black', 'White']],
            ],
            [
                'name' => 'Running Shoes',
                'slug' => 'running-shoes',
                'description' => 'Lightweight and comfortable running shoes for athletes.',
                'price' => 119.99,
                'category' => 'Sports',
                'taxable' => true,
                'variants' => ['colors' => ['Black/White', 'Blue/Orange', 'Red/Black'], 'sizes' => ['7', '8', '9', '10', '11', '12']],
            ],
            [
                'name' => 'Yoga Mat',
                'slug' => 'yoga-mat',
                'description' => 'Non-slip yoga mat for comfortable workouts.',
                'price' => 34.99,
                'category' => 'Sports',
                'taxable' => true,
                'variants' => ['colors' => ['Purple', 'Blue', 'Green', 'Black']],
            ],
            [
                'name' => 'Coffee Mug',
                'slug' => 'coffee-mug',
                'description' => 'Ceramic coffee mug with a modern design.',
                'price' => 14.99,
                'category' => 'Home',
                'taxable' => true,
                'variants' => ['colors' => ['White', 'Black', 'Blue']],
            ],
            [
                'name' => 'Desk Lamp',
                'slug' => 'desk-lamp',
                'description' => 'LED desk lamp with adjustable brightness.',
                'price' => 44.99,
                'category' => 'Home',
                'taxable' => true,
                'variants' => ['colors' => ['White', 'Black', 'Silver']],
            ],
            [
                'name' => 'Programming Book',
                'slug' => 'programming-book',
                'description' => 'Comprehensive guide to modern programming.',
                'price' => 49.99,
                'category' => 'Books',
                'taxable' => false,
            ],
            [
                'name' => 'Gift Card',
                'slug' => 'gift-card',
                'description' => 'Digital gift card - perfect for any occasion.',
                'price' => 50.00,
                'category' => 'Gift Cards',
                'taxable' => false,
            ],
            [
                'name' => 'Backpack',
                'slug' => 'backpack',
                'description' => 'Durable laptop backpack with multiple compartments.',
                'price' => 79.99,
                'category' => 'Accessories',
                'taxable' => true,
                'variants' => ['colors' => ['Black', 'Gray', 'Navy']],
            ],
            [
                'name' => 'Water Bottle',
                'slug' => 'water-bottle',
                'description' => 'Insulated stainless steel water bottle.',
                'price' => 24.99,
                'category' => 'Sports',
                'taxable' => true,
                'variants' => ['colors' => ['Black', 'White', 'Blue', 'Green', 'Red']],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
