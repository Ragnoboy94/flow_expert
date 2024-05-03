<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'регионального министерства или комитета здравоохранения'],
            ['name' => 'аптечной сети федерального или регионального уровня'],
            ['name' => 'частной клиники'],
            ['name' => 'государственного учреждения здравоохранения'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
