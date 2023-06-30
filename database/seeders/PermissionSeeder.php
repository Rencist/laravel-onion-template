<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/permission.json'));
        $permissions = json_decode($json, true);

        $payload = [];
        foreach ($permissions as $permission) {
            $payload[] = [
                'id' => $permission['id'],
                'name' => $permission['name']
            ];
        }
        DB::table('permissions')->insert($payload);
    }
}
