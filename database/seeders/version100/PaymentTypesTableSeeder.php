<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('payment_types')->insert(array (
            0 =>
           array (
               'id' => 1,
               'name' => 'Monthly_payments',
               'created_at' => '2024-08-19 11:48:21',
               'updated_at' => NULL,
           ),
            1 =>
           array (
               'id' => 2,
               'name' => 'Arrears_payments',
               'created_at' => '2024-08-19 11:48:21',
               'updated_at' => NULL,
           ),
            2 =>
           array (
               'id' => 3,
               'name' => 'Debt_payments',
               'created_at' => '2024-08-19 11:48:21',
               'updated_at' => NULL,
           ),
           
       ));
    }
}
