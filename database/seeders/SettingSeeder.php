<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Post;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $profile = [
        //     [
        //         'pots_id' => 'PF0001',
        //         'post_title' => 'Profile',
        //         'slug' => 'profile',
        //         'post_type' => 'PROFILE',
        //         'is_publish' => '1',
        //         'category_id' => 99,
        //         'created_by' => 1,
        //         'created_at' => now()
        //     ],
        //     [
        //         'pots_id' => 'PF0002',
        //         'post_title' => 'Sekretariat',
        //         'slug' => 'secretary',
        //         'post_type' => 'SECRETARY',
        //         'is_publish' => 1,
        //         'category_id' => 99,
        //         'created_by' => 1,
        //         'created_at' => now()
        //     ]
        // ];
        // foreach ($profile as $data) {
        //     Post::create($data);
        // }

        // Menambah data ke tabel 'posts'
        DB::table('posts')->insert([
            [
                'post_id' => 'PF0001',
                'post_title' => 'Profile',
                'slug' => 'profile',
                'post_type' => 'PROFILE',
                'is_publish' => '1',
                'category_id' => 99,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'post_id' => 'PF0002',
                'post_title' => 'Sekretariat',
                'slug' => 'secretary',
                'post_type' => 'SECRETARY',
                'is_publish' => 1,
                'category_id' => 99,
                'created_by' => 1,
                'created_at' => now()
            ]
        ]);

        // Menambah data ke tabel 'NumberRange'
        DB::table('numberrange')->insert([
            [
                'type' => 'NW',
                'from' => 10000,
                'to' => 19999,
                'current' => 0
            ],
            [
                'type' => 'IF',
                'from' => 10000,
                'to' => 19999,
                'current' => 0
            ],
            [
                'type' => 'CP',
                'from' => 10000,
                'to' => 19999,
                'current' => 0
            ],
            [
                'type' => 'FC',
                'from' => 10000,
                'to' => 19999,
                'current' => 0
            ],
            [
                'type' => 'LW',
                'from' => 10000,
                'to' => 19999,
                'current' => 0
            ],
            [
                'type' => 'MD',
                'from' => 10000,
                'to' => 19999,
                'current' => 0
            ],
            [
                'type' => 'RP',
                'from' => 10000,
                'to' => 19999,
                'current' => 0
            ]
        ]);
    }
}
