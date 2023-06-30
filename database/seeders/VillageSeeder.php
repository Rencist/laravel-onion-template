<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('villages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/village.json'));
        $vig_Villages = json_decode($json, true);
        foreach (array_chunk($vig_Villages, 1000) as $key => $villages) {
            $payload = [];
            foreach ($villages as $village) {
                $payload[] = [
                    'id' => $village['id'],
                    'subdistricts_id' => $village['subdistrict_id'],
                    'name' => $village['name']
                ];
            }
            DB::table('villages')->insert($payload);
        }
    }
}
