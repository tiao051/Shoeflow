<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Default role for new users (matches role_id = 1 in RegisteredUserController)
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'User',
            'description' => 'Standard user/customer role.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Other roles (example)
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'Admin',
            'description' => 'Full access administrator.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'Editor',
            'description' => 'Content editor.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}