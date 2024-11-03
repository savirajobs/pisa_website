<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
			[
				'category_name' => 'Foto',
                'slug' => 'foto',
                'created_by' => 1,
                'created_at' => now()
			],
			[
                'category_name' => 'Video',
                'slug' => 'video',
                'created_by' => 1,
                'created_at' => now()
            ]
		];
		foreach ($categories as $data) {
			Category::create($data);
		}

    }
}
