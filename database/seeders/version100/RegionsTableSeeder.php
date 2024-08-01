<?php

namespace Database\Seeders\version100;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('regions')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Dar es Salaam',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Mwanza',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Arusha',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Dodoma',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Geita ',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Iringa',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Kagera',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Katavi',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Kigoma',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Kilimanjaro',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Lindi',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Manyara',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Mara',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'Mbeya',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            14 =>
                array (
                    'id' => 15,
                    'name' => 'Morogoro',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            15 =>
                array (
                    'id' => 16,
                    'name' => 'Mtwara',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            16 =>
                array (
                    'id' => 18,
                    'name' => 'Njombe ',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            17 =>
                array (
                    'id' => 19,
                    'name' => 'Kaskazini Pemba ',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            18 =>
                array (
                    'id' => 20,
                    'name' => 'Kusini Pemba',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            19 =>
                array (
                    'id' => 21,
                    'name' => 'Pwani',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            20 =>
                array (
                    'id' => 22,
                    'name' => 'Rukwa',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            21 =>
                array (
                    'id' => 23,
                    'name' => 'Ruvuma',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            22 =>
                array (
                    'id' => 24,
                    'name' => 'Simiyu',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            23 =>
                array (
                    'id' => 25,
                    'name' => 'Singida',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            24 =>
                array (
                    'id' => 26,
                    'name' => 'Tabora',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            25 =>
                array (
                    'id' => 27,
                    'name' => 'Tanga',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            26 =>
                array (
                    'id' => 28,
                    'name' => 'Kaskazini Unguja',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            27 =>
                array (
                    'id' => 29,
                    'name' => 'Kusini Unguja',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            28 =>
                array (
                    'id' => 30,
                    'name' => 'Mjini Magharibi',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            29 =>
                array (
                    'id' => 31,
                    'name' => 'Zanzibar Urban West',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            30 =>
                array (
                    'id' => 32,
                    'name' => 'Shinyanga',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                ),
            31 =>
                array (
                    'id' => 33,
                    'name' => 'Songwe',
                    'country_id' => 1,
                    'created_at' => '2024-08-01 23:33:50',
                    'updated_at' => '2024-08-01 23:33:50',
                 ),
        ));


            // $this->enableForeignKeys('units');

    }
    }

