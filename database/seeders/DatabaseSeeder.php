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
        User::factory(30)->create();
        Todo::factory(50)->create();

        $this->call([
            AdminSeeder::class,
        ]);
    }
}
