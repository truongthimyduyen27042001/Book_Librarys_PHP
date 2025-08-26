<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Chạy các seeder riêng biệt
        $this->call([
            UserSeeder::class,
            // BookSeeder::class, // Nếu tạo BookSeeder riêng
        ]);

        // Hoặc tạo trực tiếp
        // User::factory(10)->create();
        // Book::factory(5)->create();
    }
}
