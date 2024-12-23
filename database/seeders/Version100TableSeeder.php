<?php

namespace Database\Seeders;

use Database\Seeders\version100\DesignationsTableSeeder;
use Database\Seeders\version100\DistrictsTableSeeder;
use Database\Seeders\version100\DocumentGroupsTableSeeder;
use Database\Seeders\version100\DocumentsTableSeeder;
use Database\Seeders\version100\GendersTableSeeder;
use Database\Seeders\version100\PaymentMethodsTableSeeder;
use Database\Seeders\version100\PaymentTypesTableSeeder;
use Database\Seeders\version100\RegionsTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Version100\UnitGroupsTableSeeder;
use Database\Seeders\version100\UnitsTableSeeder;
use Database\Seeders\version100\WfDefinitionsTableSeeder;
use Database\Seeders\version100\WfModuleGroupsTableSeeder;
use Database\Seeders\version100\WfModulesTableSeeder;
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
        $this->call(RegionsTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(DocumentGroupsTableSeeder::class);
        $this->call(DocumentsTableSeeder::class);
        $this->call(PaymentTypesTableSeeder::class);
        $this->call(WfModuleGroupsTableSeeder::class);
        $this->call(WfModulesTableSeeder::class);
        $this->call(WfDefinitionsTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(GendersTableSeeder::class);

        DB::commit();
    }
}
