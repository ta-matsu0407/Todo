<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('todos')->insert([
            [
                'user_id' => 1,
                'title' => 'title1が入る',
                'memo' => 'やることリストが入る。やることリストが入る。やることリストが入る。',
                'due_date' => '2024/01/01',
            ],
            [
                'user_id' => 2,
                'title' => 'title2が入る',
                'memo' => 'やることリストが入る。やることリストが入る。やることリストが入る。',
                'due_date' => '2024/02/02',
            ],
        ]);
    }
}
