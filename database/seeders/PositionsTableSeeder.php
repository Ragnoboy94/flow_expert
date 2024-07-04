<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            ['name' => 'Главный врач'],
            ['name' => 'Заведующий отделением'],
            ['name' => 'Медицинский начальник службы'],
            ['name' => 'Сотрудник отдела закупок']
        ]);
    }
}
