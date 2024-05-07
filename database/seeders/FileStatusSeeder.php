<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('file_statuses')->insert([
            ['name' => 'Pending'],
            ['name' => 'Processing'],
            ['name' => 'Done'],
            ['name' => 'Error'],
        ]);
    }
}
