<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the data to be inserted
        $products = [
            [
                'name' => 'Chuck 70 High Top - Classic Black',
                'slug' => 'chuck-70-high-top-classic-black',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 1890000.00,
                'sale_price' => null,
                'description' => 'The classic Chuck 70 version, made from premium canvas fabric, thicker rubber sole, and enhanced cushioning for superior comfort.',
                'image' => 'images/chuck_70_hightop1.jpg',
                'is_new' => 1,
                'is_active' => 1,
                'stock' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Run Star Motion CX - White/Black/Gum',
                'slug' => 'run-star-motion-cx-white-black-gum',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 2550000.00,
                'sale_price' => null,
                'description' => 'Bold, unique style with an oversized wavy platform sole and responsive CX foam cushioning for maximum comfort.',
                'image' => 'images/one_start1.jpg',
                'is_new' => 1,
                'is_active' => 1,
                'stock' => 35,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chuck Taylor All Star Lift - Pink Foam',
                'slug' => 'chuck-taylor-all-star-lift-pink-foam',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 1790000.00,
                'sale_price' => null,
                'description' => 'Platform shoe designed to increase height and style. Canvas upper with a unique stacked double sole.',
                'image' => 'images/all_star1.jpg',
                'is_new' => 1,
                'is_active' => 1,
                'stock' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chuck 70 Hi Vintage - Ivory',
                'slug' => 'chuck-70-hi-vintage-ivory',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 1990000.00,
                'sale_price' => null,
                'description' => 'A Chuck 70 version inspired by vintage style, featuring an off-white rubber sole and thick canvas for a retro look.',
                'image' => 'images/chuck_taylor1.jpg',
                'is_new' => 1,
                'is_active' => 1,
                'stock' => 25,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'One Star Mocha Pro Suede - Obsidian',
                'slug' => 'one-star-mocha-pro-suede-obsidian',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 2200000.00,
                'sale_price' => 1800000.00,
                'description' => 'Design built for skateboarding, with durable suede and specialized cushioning for impact protection.',
                'image' => 'images/y2k_mocha.jpg',
                'is_new' => 0,
                'is_active' => 1,
                'stock' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'All Star BB Shift - Volt Orange',
                'slug' => 'all-star-bb-shift-volt-orange',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 2100000.00,
                'sale_price' => null,
                'description' => 'High-performance basketball shoe, engineered for speed and quick direction changes on the court.',
                'image' => 'images/all_star2.jpg',
                'is_new' => 0,
                'is_active' => 1,
                'stock' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chuck Taylor All Star Classic Low Top - White',
                'slug' => 'chuck-taylor-all-star-classic-low-top-white',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 1450000.00,
                'sale_price' => null,
                'description' => 'The world’s most iconic sneaker model, recognized for its unmistakable silhouette and cultural authenticity.',
                'image' => 'images/all_star_white_low.jpg',
                'is_new' => 0,
                'is_active' => 1,
                'stock' => 100,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chuck 70 High Top - Seasonal Red',
                'slug' => 'chuck-70-high-top-seasonal-red',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 1890000.00,
                'sale_price' => null,
                'description' => 'A seasonal color update for the Chuck 70 High Top featuring vibrant red canvas.',
                'image' => 'images/red1.jpg',
                'is_new' => 0, 
                'is_active' => 1,
                'stock' => 20,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Converse High-top Sneakers Navy Blue',
                'slug' => 'converse-high-top-sneakers-navy-blue',
                'brand' => 'Converse',
                'category_id' => 1,
                'price' => 1890000.00,
                'sale_price' => null,
                'description' => 'The classic high-top Converse sneaker in modern navy blue, perfect for any street style.',
                'image' => 'images/high_top1.jpg',
                'is_new' => 1,
                'is_active' => 1,
                'stock' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Converse Older Kids Star Player 76 Foundational Canvas (GS)',
                'slug' => 'converse-older-kids-star-player-76-foundational-canvas-gs',
                'brand' => 'Converse',
                'category_id' => 2, 
                'price' => 1550000.00,
                'sale_price' => null,
                'description' => 'The Star Player 76 low-top version for older kids, designed with durable and comfortable canvas.',
                'image' => 'images/low.jpg',
                'is_new' => 1,
                'is_active' => 1,
                'stock' => 35,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insert the data into the 'products' table
        DB::table('products')->insert($products);
    }
}