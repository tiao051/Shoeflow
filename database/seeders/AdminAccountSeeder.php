<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@shoesdelrey.com',
            'password' => Hash::make('password'), 
            'role_id' => 2, 
            'phone' => '0909090909',
            'is_verified' => true,
        ]);
    }
}