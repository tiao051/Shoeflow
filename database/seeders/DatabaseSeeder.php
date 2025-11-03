<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Shoe;
use App\Models\Promotion;
use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@shoeler.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Create Sample Users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '081234567891',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '081234567892',
        ]);

        // Create Categories
        $categories = [
            [
                'name' => 'Men',
                'slug' => 'men',
                'description' => 'Shoes for men',
                'is_active' => true,
            ],
            [
                'name' => 'Women',
                'slug' => 'women',
                'description' => 'Shoes for women',
                'is_active' => true,
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Athletic and sports shoes',
                'is_active' => true,
            ],
            [
                'name' => 'Casual',
                'slug' => 'casual',
                'description' => 'Casual everyday shoes',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Shoes
        $shoes = [
            [
                'category_id' => 1,
                'name' => 'Nike Air Max 90',
                'slug' => 'nike-air-max-90',
                'description' => 'Classic Nike Air Max with superior cushioning',
                'brand' => 'Nike',
                'material' => 'Leather/Mesh',
                'price' => 1299000,
                'discount_price' => 999000,
                'sizes' => ['40', '41', '42', '43', '44'],
                'stock' => 50,
                'color' => 'Black/White',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.5,
            ],
            [
                'category_id' => 1,
                'name' => 'Adidas Ultraboost 22',
                'slug' => 'adidas-ultraboost-22',
                'description' => 'Premium running shoes with boost technology',
                'brand' => 'Adidas',
                'material' => 'Primeknit',
                'price' => 2499000,
                'sizes' => ['40', '41', '42', '43'],
                'stock' => 30,
                'color' => 'Core Black',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.8,
            ],
            [
                'category_id' => 2,
                'name' => 'Puma Cali Sport',
                'slug' => 'puma-cali-sport',
                'description' => 'Stylish women sneakers with classic design',
                'brand' => 'Puma',
                'material' => 'Leather',
                'price' => 899000,
                'discount_price' => 699000,
                'sizes' => ['36', '37', '38', '39', '40'],
                'stock' => 40,
                'color' => 'White/Pink',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.3,
            ],
            [
                'category_id' => 3,
                'name' => 'New Balance 574',
                'slug' => 'new-balance-574',
                'description' => 'Comfortable running shoes for daily training',
                'brand' => 'New Balance',
                'material' => 'Suede/Mesh',
                'price' => 1099000,
                'sizes' => ['40', '41', '42', '43', '44'],
                'stock' => 45,
                'color' => 'Grey/Navy',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.6,
            ],
            [
                'category_id' => 4,
                'name' => 'Converse Chuck Taylor All Star',
                'slug' => 'converse-chuck-taylor-all-star',
                'description' => 'Iconic canvas sneakers for everyday wear',
                'brand' => 'Converse',
                'material' => 'Canvas',
                'price' => 599000,
                'sizes' => ['38', '39', '40', '41', '42', '43'],
                'stock' => 60,
                'color' => 'Black',
                'is_featured' => false,
                'is_active' => true,
                'rating' => 4.4,
            ],
            [
                'category_id' => 4,
                'name' => 'Vans Old Skool',
                'slug' => 'vans-old-skool',
                'description' => 'Classic skate shoes with durable construction',
                'brand' => 'Vans',
                'material' => 'Canvas/Suede',
                'price' => 799000,
                'discount_price' => 649000,
                'sizes' => ['39', '40', '41', '42', '43'],
                'stock' => 55,
                'color' => 'Black/White',
                'is_featured' => true,
                'is_active' => true,
                'rating' => 4.7,
            ],
        ];

        foreach ($shoes as $shoe) {
            Shoe::create($shoe);
        }

        // Create Sample Promotions
        Promotion::create([
            'code' => 'WELCOME10',
            'name' => 'Welcome Discount',
            'description' => '10% off for new customers',
            'type' => 'percentage',
            'value' => 10,
            'min_purchase' => 500000,
            'max_discount' => 100000,
            'usage_limit' => 100,
            'start_date' => now(),
            'end_date' => now()->addMonths(1),
            'is_active' => true,
        ]);

        Promotion::create([
            'code' => 'FLASH50',
            'name' => 'Flash Sale',
            'description' => 'Rp 50,000 discount for purchases above Rp 1,000,000',
            'type' => 'fixed',
            'value' => 50000,
            'min_purchase' => 1000000,
            'usage_limit' => 50,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'is_active' => true,
        ]);

        // Create Sample Banners
        Banner::create([
            'title' => 'New Collection 2024',
            'description' => 'Discover our latest shoe collection',
            'image' => 'banners/default-1.jpg',
            'link' => '/shoes',
            'order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Flash Sale Up to 50% Off',
            'description' => 'Limited time offer on selected items',
            'image' => 'banners/default-2.jpg',
            'link' => '/shoes',
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
