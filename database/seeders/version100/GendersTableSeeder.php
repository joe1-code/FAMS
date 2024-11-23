<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('genders')->insert(array (
            0 =>
           array (
               'id' => 1,
               'name' => 'Male',
               'created_at' => '2024-11-19 11:48:21',
               'updated_at' => NULL,
           ),
            1 =>
           array (
               'id' => 2,
               'name' => 'Female',
               'created_at' => '2024-11-19 11:48:21',
               'updated_at' => NULL,
           ),
           
       ));
    }
}
