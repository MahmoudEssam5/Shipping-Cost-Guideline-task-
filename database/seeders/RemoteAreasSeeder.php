<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemoteAreasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['city' => 'Abu Dhabi', 'area' => 'Ghayathi'],
            ['city' => 'Abu Dhabi', 'area' => 'Bad Al Matawa'],
            ['city' => 'Abu Dhabi', 'area' => 'AL SILA'],
            ['city' => 'Dubai', 'area' => 'Hatta'],
            ['city' => 'Dubai', 'area' => 'Nazwa'],
            ['city' => 'Sharjah', 'area' => 'Lehbab'],
            ['city' => 'Sharjah', 'area' => 'Madam'],
            ['city' => 'Ajman', 'area' => 'Masfout'],
            ['city' => 'Ras Al Khaimah', 'area' => 'Wadi Al Shiji'],
            ['city' => 'Ras Al Khaimah', 'area' => 'Al showka'],
            ['city' => 'Al Ain', 'area' => 'Nahil'],
            ['city' => 'Al Ain', 'area' => 'Sawehan'],
            ['city' => 'Al Ain', 'area' => 'Al Wagan'],
        ];

        DB::table('remote_areas')->insert($data);
    }
}


