<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('documents')->insert(array (
            0 =>
           array (
               'id' => 1,
               'name' => 'Monthly_payments',
               'document_group_id' => 1,
               'description' => 'documents to show monthly payments',
               'isActive' => true,
               'created_at' => '2024-08-19 11:48:21',
               'updated_at' => NULL,
           ),
           
       ));
    }
}
