<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->delete();

        $categories = [
            [
                'name' => 'Chuck Taylor',
                'slug' => 'chuck-taylor',
                'description' => 'Classic high tops & low tops',
                'image' => 'images/cate1.jpg', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'One Star',
                'slug' => 'one-star',
                'description' => 'Retro basketball style',
                'image' => 'images/cate2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'All Star',
                'slug' => 'all-star',
                'description' => 'Heritage basketball sneakers',
                'image' => 'images/cate3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}