<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('education_levels')->insert(array (
            0 =>
           array (
               'id' => 1,
               'name' => 'Primary',
               'created_at' => '2025-01-08 12:26:21',
               'updated_at' => NULL,
           ),
            1 =>
           array (
               'id' => 2,
               'name' => 'Secondary',
               'created_at' => '2025-01-08 12:26:21',
               'updated_at' => NULL,
           ),
            2 =>
           array (
               'id' => 3,
               'name' => 'Diploma',
               'created_at' => '2025-01-08 12:26:21',
               'updated_at' => NULL,
           ),
            3 =>
           array (
               'id' => 4,
               'name' => "Bachelor's Degree",
               'created_at' => '2025-01-08 12:26:21',
               'updated_at' => NULL,
           ),
            4 =>
           array (
               'id' => 5,
               'name' => "Masters' Degree",
               'created_at' => '2025-01-08 12:26:21',
               'updated_at' => NULL,
           ),
            5 =>
           array (
               'id' => 6,
               'name' => "phD Degree",
               'created_at' => '2025-01-08 12:26:21',
               'updated_at' => NULL,
           ),
           
       ));
    }
}
