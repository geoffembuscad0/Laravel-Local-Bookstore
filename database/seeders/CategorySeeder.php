<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Fiction',
            'Nonfiction',
            'Novel',
            'Romance',
            'Mystery',
            'Thriller',
            'Science Fiction',
            'Fantasy',
            'Horror',
            'Historical Fiction',
            'Literary Fiction',
            'Young Adult',
            'Children',
            'Biography',
            'Autobiography',
            'Memoir',
            'Self-Help',
            'Personal Development',
            'Business',
            'Finance',
            'History',
            'Philosophy',
            'Psychology',
            'Religion & Spirituality',
            'Science',
            'Technology',
            'Politics',
            'Travel',
            'Poetry',
            'Essays',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                [
                    'slug' => Str::slug($name),
                ],
                [
                    'name' => $name,
                    'description' => null,
                    'parent_id' => null,
                ]
            );
        }
    }
}
