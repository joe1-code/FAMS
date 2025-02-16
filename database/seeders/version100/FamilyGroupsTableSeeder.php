<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('family_groups')->insert(array (
            0 =>
           array (
               'id' => 1,
               'name' => 'Njaghah Family',
               'no_of_family_members' => 10,
               'created_at' => '2025-01-08 12:26:21',
               'updated_at' => NULL,
           ),
            
           
       ));
    }
}
