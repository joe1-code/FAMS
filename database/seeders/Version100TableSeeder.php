<?php

namespace Database\Seeders;

use Database\Seeders\version100\DesignationsTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Version100\UnitGroupsTableSeeder;
use Database\Seeders\version100\UnitsTableSeeder;
use Illuminate\Support\Facades\DB;
// use Database\DisableForeignKeys;



class Version100TableSeeder extends Seeder
{
    // use DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(UnitGroupsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(DesignationsTableSeeder::class);

        DB::commit();
    }
}
