<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/kabupaten.json'));
        $kabupatens = json_decode($json, true);

        $payload = [];
        foreach ($kabupatens as $kabupaten) {
            $payload[] = [
                'id' => $kabupaten['id'],
                'provinsi_id' => $kabupaten['provinsi_id'],
                'name' => $kabupaten['name']
            ];
        }
        DB::table('kabupaten')->insert($payload);
    }
}
