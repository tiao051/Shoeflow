<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                // This category will likely have ID = 1, matching your product seed data
                'name' => 'Converse Sneakers',
                'slug' => Str::slug('Converse Sneakers'),
                'description' => 'The complete collection of classic Chuck Taylor, Chuck 70, and modern Converse footwear.',
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chuck 70', 
                'slug' => Str::slug('Chuck 70'),
                'description' => 'The premium line of Converse, featuring heavier canvas and enhanced cushioning.',
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Run Star',
                'slug' => Str::slug('Run Star'),
                'description' => 'Modern, platform-style Converse shoes offering a bold, elevated look.',
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Classic Chuck',
                'slug' => Str::slug('Classic Chuck'),
                'description' => 'The original, iconic Chuck Taylor All Star designs.',
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}