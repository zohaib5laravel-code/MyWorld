<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Oceans',
                'image' => 'categories/oceans.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mountains',
                'image' => 'categories/mountains.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Forests',
                'image' => 'categories/forests.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Category::insert($categories);
    }
}
