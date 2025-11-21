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
        // 1. Vai trò mặc định cho người dùng mới (để khớp với role_id = 1 trong RegisteredUserController)
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'User',
            'description' => 'Standard user/customer role.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Các vai trò khác (ví dụ)
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