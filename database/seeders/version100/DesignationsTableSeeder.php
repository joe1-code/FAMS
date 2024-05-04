<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('designations')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Father',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                1 =>
                array (
                    'id' => 2,
                    'name' => 'Mother',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                2 =>
                array (
                    'id' => 3,
                    'name' => 'Chairman',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                3 =>
                array (
                    'id' => 4,
                    'name' => 'General Secretary',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                4 =>
                array (
                    'id' => 5,
                    'name' => 'Accountant',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                5 =>
                array (
                    'id' => 6,
                    'name' => 'Internal Advisors',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                6 =>
                array (
                    'id' => 7,
                    'name' => 'External Advisors',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            ));
            // $this->enableForeignKeys('unit_groups');

    }
}
