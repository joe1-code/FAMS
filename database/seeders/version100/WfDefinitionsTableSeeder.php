<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WfDefinitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('wf_definitions')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'wf_module_id' => 1,
                    'active' => 1,
                    'level' => 1.00,
                    'unit_id' => 4,
                    'designation_id' => 8,
                    'description' => 'member pays to initiate workflow',
                    'allow_rejection' => 0,
                    'is_approval' => 0,
                    'created_at' => '2024-07-22 11:48:21',
                    'updated_at' => NULL,
                ),
                1 =>
                array (
                    'id' => 2,
                    'wf_module_id' => 1,
                    'active' => 1,
                    'level' => 2.00,
                    'unit_id' => 2,
                    'designation_id' => 5,
                    'description' => 'Accountant Reviews Payment and Forwards to Chairperson',
                    'allow_rejection' => 0,
                    'is_approval' => 0,
                    'created_at' => '2024-07-22 11:48:21',
                    'updated_at' => NULL,
                ),
            
                2 =>
                array (
                    'id' => 3,
                    'wf_module_id' => 1,
                    'active' => 1,
                    'level' => 3.00,
                    'unit_id' => 2,
                    'designation_id' => 3,
                    'description' => 'Chairperson Reviews Payment and Forwards to Gurdian for Approval',
                    'allow_rejection' => 0,
                    'is_approval' => 0,
                    'created_at' => '2024-07-22 11:48:21',
                    'updated_at' => NULL,
                ),
            
                3 =>
                array (
                    'id' => 4,
                    'wf_module_id' => 1,
                    'active' => 1,
                    'level' => 4.00,
                    'unit_id' => 1,
                    'designation_id' => 1,
                    'description' => 'Chairperson Reviews Payment and Forwards to  Guardian for Approval',
                    'allow_rejection' => 0,
                    'is_approval' => 0,
                    'created_at' => '2024-07-22 11:48:21',
                    'updated_at' => NULL,
                ),
            
                
                
            ));
    }
}
