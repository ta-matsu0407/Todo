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
        User::factory(1000)->create();
        Todo::factory(100)->create();

        $this->call([
            // UserSeeder::class,
            AdminSeeder::class,
            // TodoSeeder::class,
        ]);
    }
}
