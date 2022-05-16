<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Article::factory(30)->create();
        \App\Models\Institution::factory(80)->create();

        // \App\Models\User::create(
        //     [
        //     'name' => "Jean Lionel",
        //     'email' => "nijeanlionel@gmail.com",
        //     'email_verified_at' => now(),
        //     'password' => bcrypt("12345678"), // password
        //     'remember_token' => Str::random(10),
        //     'role_id' => 1,
        //     'telephone' => '+257 79 614 036',
        //     'mobile' => '+257 61 444 953'
        //     ]
        // );
        
        $this->call(
            [
                RoleSeeder::class
            ]
        );

    }
}
