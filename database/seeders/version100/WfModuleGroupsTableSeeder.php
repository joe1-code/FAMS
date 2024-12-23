<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WfModuleGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('wf_module_groups')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Monthly Payments',
                    'table_name' => null,
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                ),
                
                
            ));
            // $this->enableForeignKeys('units');

    }
}

