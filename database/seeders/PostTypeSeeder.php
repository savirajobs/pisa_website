<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PostType;
use App\Models\Tag;

class PostTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$posttypes = [
			[
				'type_id' => 'NW',
				'type_desc' => 'News'
			],
			[
				'type_id' => 'IF',
				'type_desc' => 'Information'
			],
			[
				'type_id' => 'CP',
				'type_desc' => 'Child Program'
			],
			[
				'type_id' => 'FC',
				'type_desc' => 'Facility'
			],
			[
				'type_id' => 'LW',
				'type_desc' => 'Law/Legal'
			],
			[
				'type_id' => 'MD',
				'type_desc' => 'Gallery'
			],
			[
				'type_id' => 'PROFILE',
				'type_desc' => 'Profile'
			],
			[
				'type_id' => 'SECRETARY',
				'type_desc' => 'Secretary'
			]
		];
		foreach ($posttypes as $data) {
			PostType::create($data);
		}
	}
}
