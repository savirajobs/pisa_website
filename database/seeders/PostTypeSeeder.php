<?php

namespace Database\Seeders;

use App\Models\PostType;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post_types = [
			[
                'type_id' => 'NW',
				'type_desc' => 'News',
        	],
			[
                'type_id' => 'IF',
				'type_desc' => 'Information',
        	],
			[
				'type_id' => 'CP',
				'type_desc' => 'Child Program',
        	],
			[
				'type_id' => 'FC',
				'type_desc' => 'Facility',
        	],
            [
				'type_id' => 'LW',
				'type_desc' => 'Law/Legal',
        	],
			[
				'type_id' => 'MD',
				'type_desc' => 'Gallery',
        	],
		];
		foreach ($post_types as $data) {
			PostType::create($data);
		}
    }
}
