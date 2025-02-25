<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(25000)->create();

        // $chunkSize = 10000; // 1回の挿入を1000件ずつにする
        // $totalRecords = 300000;

        $chunkSize = 100;
        $totalRecords = 3000;


        for ($i = 0; $i < $totalRecords / $chunkSize; $i++) {
            User::factory()->count($chunkSize)->create();
        }
        Todo::factory(50)->create();
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // UserSeeder::class,
            AdminSeeder::class,
            // TodoSeeder::class,
        ]);
    }
}
