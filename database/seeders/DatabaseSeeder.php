<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Version100TableSeeder;
use Illuminate\Database\Eloquent\Model;
// use Database\DisableForeignKeys;

class DatabaseSeeder extends Seeder
{
    // use DisableForeignKeys;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(Version100TableSeeder::class);

    }
}
