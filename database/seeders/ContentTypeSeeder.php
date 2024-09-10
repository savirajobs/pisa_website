<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContentType;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contenttypes = [
			[
                'type_id' => 'CT',
				'type_desc' => 'Content',
        	],
			[
				'type_id' => 'CP',
				'type_desc' => 'ChildProgram',
        	],
            [
				'type_id' => 'FC',
				'type_desc' => 'Facility',
        	],
            [
				'type_id' => 'LW',
				'type_desc' => 'Law/Legal',
        	],
		];
		foreach ($contenttypes as $data) {
			ContentType::create($data);
		}
    }
}
