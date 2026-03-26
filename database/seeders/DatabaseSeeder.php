<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Kasir Shift 1',
            'email' => 'kasir@pos.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir'
        ]);

        // 2. Buat Kategori Menu Dasar
        $categories = ['Makanan Utama', 'Minuman', 'Snack & Cemilan', 'Dessert'];
        
        foreach ($categories as $index => $cat) {
            Category::create([
                'name' => $cat,
                'is_active' => true,
                'sort_order' => $index + 1
            ]);
        }
    }
}