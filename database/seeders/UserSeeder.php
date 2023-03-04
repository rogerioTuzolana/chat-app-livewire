<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => "Rogério Tuzolana",
            'email'=> "tuzolanarogerio@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt("12345678"),
            'remember_token' => Str::random(10),
            'type' => "user",
        ]);
        User::create([
            'name' => "Ana Maria",
            'email'=> "ana@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt("12345678"),
            'remember_token' => Str::random(10),
            'type' => "user",
        ]);
        User::create([
            'name' => "Sérgio Gomes",
            'email'=> "sergio@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt("12345678"),
            'remember_token' => Str::random(10),
            'type' => "user",
        ]);
    }
}
