<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookCategories = [
            'meditations' => [
                'philosophy',
                'stoicism',
                'personal-development',
            ],

            'nicomachean-ethics' => [
                'philosophy',
            ],

            'beyond-good-and-evil' => [
                'philosophy',
            ],

            'mans-search-for-meaning' => [
                'psychology',
                'philosophy',
                'personal-development',
            ],

            'the-48-laws-of-power' => [
                'psychology',
                'strategy',
                'business',
            ],

            'atomic-habits' => [
                'self-help',
                'personal-development',
                'psychology',
            ],

            'deep-work' => [
                'productivity',
                'personal-development',
                'business',
            ],

            'the-obstacle-is-the-way' => [
                'philosophy',
                'stoicism',
                'personal-development',
            ],

            'sapiens-brief-history-of-humankind' => [
                'history',
                'anthropology',
                'science',
            ],

            'thinking-fast-and-slow' => [
                'psychology',
                'science',
                'decision-making',
            ],
        ];

        DB::transaction(function () use ($bookCategories) {
            foreach ($bookCategories as $bookSlug => $categorySlugs) {
                $book = Book::where('slug', $bookSlug)->firstOrFail();

                $categoryIds = Category::whereIn('slug', $categorySlugs)
                    ->get()
                    ->keyBy('slug');

                // Ensure every requested category exists.
                $missingCategories = array_diff(
                    $categorySlugs,
                    $categoryIds->keys()->all()
                );

                if (! empty($missingCategories)) {
                    throw new \RuntimeException(
                        "Missing categories for book '{$bookSlug}': "
                        . implode(', ', $missingCategories)
                    );
                }

                // Attach categories without removing existing assignments.
                $book->categories()->syncWithoutDetaching(
                    $categoryIds->pluck('id')->all()
                );
            }
        });
    }
}
