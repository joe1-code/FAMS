<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->disableForeignKeys('units');
        // $this->delete('units');

        \DB::table('units')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Parents',
                    'unit_group_id' => 1,
                    'short_code' => 'PRNTS',
                    'parent_id' => 0,
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                1 =>
                array (
                    'id' => 2,
                    'name' => 'leaders',
                    'unit_group_id' => 2,
                    'short_code' => 'LDRS',
                    'parent_id' => 0,
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                2 =>
                array (
                    'id' => 3,
                    'name' => 'Children',
                    'unit_group_id' => 3,
                    'short_code' => 'CLDRN',
                    'parent_id' => 0,
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                3 =>
                array (
                    'id' => 4,
                    'name' => 'Members',
                    'unit_group_id' => 4,
                    'short_code' => 'MMBRS',
                    'parent_id' => 0,
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            ));
            // $this->enableForeignKeys('units');

    }
}
