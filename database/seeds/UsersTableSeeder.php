<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        
        User::create([
            'name' => 'Admin Example',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Rizky',
            'email' => 'rizky@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
