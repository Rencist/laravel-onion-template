<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\VillageSeeder;
use Database\Seeders\SubdistrictSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProvinceSeeder::class,
            CitySeeder::class,
            SubdistrictSeeder::class,
            VillageSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RoleHasPermissionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
