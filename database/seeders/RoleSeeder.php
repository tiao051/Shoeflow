<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('roles')->insert([
            ['name' => 'admin', 'description' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'staff', 'description' => 'Staff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'customer', 'description' => 'Customer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
