<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat Pengguna Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'], 
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password123'), 
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Membuat Pengguna Biasa (User)
        User::firstOrCreate(
            ['email' => 'user@example.com'], 
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password123'), 
                'role' => 'user', 
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 3. Membuat 15 Pengguna Acak Tambahan
        User::factory()->count(15)->create();
    }
}