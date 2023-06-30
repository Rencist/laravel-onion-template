<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/province.json'));
        $provinces = json_decode($json, true);

        $payload = [];
        foreach ($provinces as $province) {
            $payload[] = [
                'id' => $province['id'],
                'name' => $province['name']
            ];
        }
        DB::table('provinces')->insert($payload);
    }
}
