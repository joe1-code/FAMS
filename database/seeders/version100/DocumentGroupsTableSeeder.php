<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('document_groups')->insert(array (
                 0 =>
                array (
                    'id' => 1,
                    'name' => 'payments',
                    'created_at' => '2024-08-19 11:48:21',
                    'updated_at' => NULL,
                ),
                
            ));
        
    }
}
