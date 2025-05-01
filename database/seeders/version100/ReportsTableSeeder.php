<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('reports')->insert(array (
            0 =>
           array (
               'id' => 1,
               'name' => 'General Report With Paid Members',
               'shortcode' => 'GRPM',
               'created_at' => '2025-03-31 11:20:21',
               'updated_at' => NULL,
           ),
            1 =>
           array (
               'id' => 2,
               'name' => 'General Report With Non Paid Members',
               'shortcode' => 'GRNPM',
               'created_at' => '2025-03-31 11:20:21',
               'updated_at' => NULL,
           ),
           
       ));
    }
}
