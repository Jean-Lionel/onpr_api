<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            "ADMINISTEUR",
            "EMPLOYEUR",
            "CHEF DE SERVICE"
        ];

        foreach ($role as $roles){
            Role::create([
                "name" => $role
            ]);
        }
    }
}
