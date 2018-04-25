<?php

use App\Http\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;


class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            "email"    => "admin@example.com",
            "password" => bcrypt("admin"),
            "username" => "admin",
            "role"     => "admin",
            "active"   => true,
        ]);
    }
}
