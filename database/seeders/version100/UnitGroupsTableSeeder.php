<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Support\Facades\DB;


class UnitGroupsTableSeeder extends Seeder
{
    // use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->disableForeignKeys('unit_groups');
        // $this->delete('unit_groups');
        // $check = DB::table('unit_groups')->is_empty();

        \DB::table('unit_groups')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Guiders',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                1 =>
                array (
                    'id' => 2,
                    'name' => 'Administrators',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                2 =>
                array (
                    'id' => 3,
                    'name' => 'Internal Unit',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
                3 =>
                array (
                    'id' => 4,
                    'name' => 'External Unit',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                    'deleted_at' => NULL,
                ),
            ));
            // $this->enableForeignKeys('unit_groups');

    }
}

