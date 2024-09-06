<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$users = [
			[
				'name' 			=> 'Admin',
				'email' 		=> 'admin@mail.com',
				'password' 		=> bcrypt('admin'),
				'email_verified_at' => Carbon::now(),
				'role' 			=> 'super-admin'
			],
			[
				'name' 		=> 'User',
				'email' 	=> 'user@mail.com',
				'password' 	=> bcrypt('user'),
				'email_verified_at' => Carbon::now(),
				'role' 		=> 'admin'
			]
		];
		foreach ($users as $data) {
			User::create($data);
		}
	}
}
