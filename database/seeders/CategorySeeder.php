<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('categories')->insert([
                ['name' => 'регионального министерства или комитета здравоохранения'],
                ['name' => 'аптечной сети федерального или регионального уровня'],
                ['name' => 'частной клиники'],
                ['name' => 'государственного учреждения здравоохранения'],
            ]);
    }
}
