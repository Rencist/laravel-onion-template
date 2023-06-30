<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/role.json'));
        $roles = json_decode($json, true);

        $payload = [];
        foreach ($roles as $role) {
            $payload[] = [
                'id' => $role['id'],
                'name' => $role['name']
            ];
        }
        DB::table('roles')->insert($payload);
    }
}
