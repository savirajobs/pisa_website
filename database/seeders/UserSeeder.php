<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin'),
            'role' => 'super-admin'
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => bcrypt('user'),
            'role' => 'admin'
        ]);
    }
}
