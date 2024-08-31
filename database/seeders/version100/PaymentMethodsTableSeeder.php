<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('payment_methods')->insert(array (
            0 =>
           array (
               'id' => 1,
               'name' => 'CRDB Account',
               'created_at' => '2024-08-30 11:48:21',
               'updated_at' => NULL,
           ),
            1 =>
           array (
               'id' => 2,
               'name' => 'UTT AMIS Account',
               'created_at' => '2024-08-19 11:48:21',
               'updated_at' => NULL,
           ),
           
       ));
    }
}
