<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/provinsi.json'));
        $provinsis = json_decode($json, true);

        $payload = [];
        foreach ($provinsis as $provinsi) {
            $payload[] = [
                'id' => $provinsi['id'],
                'name' => $provinsi['name']
            ];
        }
        DB::table('provinsi')->insert($payload);
    }
}
