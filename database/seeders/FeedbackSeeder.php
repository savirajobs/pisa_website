<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FeedbackCategory;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feedback_categories = [
            [
                'category_id' => 1,
                'category_desc' => 'Consultation',
                'created_at' => now()
            ],
            [
                'category_id' => 2,
                'category_desc' => 'Complaint',
                'created_at' => now()
            ]
        ];
        foreach ($feedback_categories as $data) {
            FeedbackCategory::create($data);
        }
    }
}
