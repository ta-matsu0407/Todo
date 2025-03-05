<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $chunkSize = 100; // 1回の挿入を100件ずつにする
        $totalRecords = 3000;


        for ($i = 0; $i < $totalRecords / $chunkSize; $i++) {
            User::factory()->count($chunkSize)->create();
        }

        Todo::factory(50)->create();
        $this->call([
            // UserSeeder::class,
            AdminSeeder::class,
            // TodoSeeder::class,
        ]);
    }
}
