<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subdistricts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/subdistrict.json'));
        $subdistricts = json_decode($json, true);

        $payload = [];
        foreach ($subdistricts as $subdistrict) {
            $payload[] = [
                'id' => $subdistrict['id'],
                'cities_id' => $subdistrict['city_id'],
                'name' => $subdistrict['name']
            ];
        }
        DB::table('subdistricts')->insert($payload);
    }
}
