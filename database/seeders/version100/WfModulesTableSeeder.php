<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WfModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('wf_modules')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Monthly Payments Workflow',
                    'wf_module_group_id' => 1,
                    'isActive' => 1,
                    'type' => 1,
                    'description' => 'This is a workflow special for monthly payments',
                    'created_at' => '2024-05-03 11:48:21',
                    'updated_at' => NULL,
                ),
                
                
            ));
            // $this->enableForeignKeys('units');

    }
}

