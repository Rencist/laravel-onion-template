<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/city.json'));
        $cities = json_decode($json, true);

        $payload = [];
        foreach ($cities as $city) {
            
            $payload[] = [
                'id' => $city['id'],
                'provinces_id' => $city['province_id'],
                'name' => $city['name']
            ];
        }
        DB::table('cities')->insert($payload);
    }
}
