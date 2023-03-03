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
            "ADMINISTRATEUR",
            "EMPLOYEUR",
            "CHEF RECOUVREMENT",
            "RISQUE PROFESSIONELLE",
            "ADMINISTRATEUR WEB",
            "MEMBRE",
        ];

        foreach ($roles as $role){
            Role::create([
                "name" => $role,
                "description" => $role
            ]);
        }
    }
}
