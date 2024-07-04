<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organization_statuses')->insert([
            ['name' => 'Демо-доступ'],
            ['name' => 'Активный'],
            ['name' => 'Заблокирован']
        ]);
    }
}
