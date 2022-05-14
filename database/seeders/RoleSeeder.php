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
            "CHEF DE SERVICE",
            "AFILIER"
        ];

        foreach ($roles as $role){
            Role::create([
                "name" => $role,
                "description" => $role
            ]);
        }
    }
}
