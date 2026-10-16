<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        /*
        |--------------------------------------------------------------------------
        | Books
        |--------------------------------------------------------------------------
        |
        | Each book is associated with an existing author and publisher
        | using their unique slugs.
        |
        | Prices and stock quantities are sample bookstore inventory data.
        |
        */

        $books = [
            [
                'title' => 'Meditations',
                'slug' => 'meditations',
                'isbn' => null,
                'description' => 'A collection of personal reflections by Roman emperor Marcus Aurelius on Stoic philosophy, self-discipline, duty, and living according to reason.',
                'price' => 450.00,
                'discount_price' => null,
                'stock' => 15,
                'pages' => 256,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-MEDITATIONS',
                'author_slug' => 'marcus-aurelius',
                'publisher_slug' => 'penguin-random-house',
            ],
            [
                'title' => 'Nicomachean Ethics',
                'slug' => 'nicomachean-ethics',
                'isbn' => null,
                'description' => 'Aristotle explores the nature of happiness, virtue, practical wisdom, friendship, and the good life in one of the foundational works of Western moral philosophy.',
                'price' => 550.00,
                'discount_price' => null,
                'stock' => 10,
                'pages' => 384,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-NICOMACHEAN-ETHICS',
                'author_slug' => 'aristotle',
                'publisher_slug' => 'oxford-university-press',
            ],
            [
                'title' => 'Beyond Good and Evil',
                'slug' => 'beyond-good-and-evil',
                'isbn' => null,
                'description' => 'Friedrich Nietzsche challenges conventional morality and examines truth, philosophy, power, and the assumptions underlying traditional systems of thought.',
                'price' => 420.00,
                'discount_price' => null,
                'stock' => 12,
                'pages' => 240,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-BEYOND-GOOD-EVIL',
                'author_slug' => 'friedrich-nietzsche',
                'publisher_slug' => 'penguin-random-house',
            ],
            [
                'title' => "Man's Search for Meaning",
                'slug' => 'mans-search-for-meaning',
                'isbn' => null,
                'description' => 'Viktor Frankl reflects on his experiences in Nazi concentration camps and introduces logotherapy, exploring how the search for meaning can sustain human beings through suffering.',
                'price' => 399.00,
                'discount_price' => null,
                'stock' => 20,
                'pages' => 184,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-MANS-SEARCH-MEANING',
                'author_slug' => 'viktor-e-frankl',
                'publisher_slug' => 'simon-and-schuster',
            ],
            [
                'title' => 'The 48 Laws of Power',
                'slug' => 'the-48-laws-of-power',
                'isbn' => null,
                'description' => 'Robert Greene examines historical examples of power, strategy, influence, and human behavior, presenting lessons drawn from political and social relationships.',
                'price' => 650.00,
                'discount_price' => 599.00,
                'stock' => 18,
                'pages' => 480,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-48-LAWS-POWER',
                'author_slug' => 'robert-greene',
                'publisher_slug' => 'penguin-random-house',
            ],
            [
                'title' => 'Atomic Habits',
                'slug' => 'atomic-habits',
                'isbn' => null,
                'description' => 'James Clear explains how small behavioral changes, environmental design, and consistent systems can help people build good habits and break bad ones.',
                'price' => 599.00,
                'discount_price' => 549.00,
                'stock' => 25,
                'pages' => 320,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-ATOMIC-HABITS',
                'author_slug' => 'james-clear',
                'publisher_slug' => 'penguin-random-house',
            ],
            [
                'title' => 'Deep Work',
                'slug' => 'deep-work',
                'isbn' => null,
                'description' => 'Cal Newport argues that sustained, distraction-free concentration is valuable for producing meaningful work and developing difficult skills in an increasingly distracted world.',
                'price' => 520.00,
                'discount_price' => null,
                'stock' => 14,
                'pages' => 304,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-DEEP-WORK',
                'author_slug' => 'cal-newport',
                'publisher_slug' => 'grand-central-publishing',
            ],
            [
                'title' => 'The Obstacle Is the Way',
                'slug' => 'the-obstacle-is-the-way',
                'isbn' => null,
                'description' => 'Ryan Holiday draws on Stoic philosophy and historical examples to explore how perception, action, and persistence can help people respond constructively to adversity.',
                'price' => 450.00,
                'discount_price' => null,
                'stock' => 16,
                'pages' => 224,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-OBSTACLE-IS-WAY',
                'author_slug' => 'ryan-holiday',
                'publisher_slug' => 'penguin-random-house',
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'slug' => 'sapiens-brief-history-of-humankind',
                'isbn' => null,
                'description' => 'Yuval Noah Harari surveys the history of humanity, examining the cognitive, agricultural, and scientific revolutions and their influence on human societies.',
                'price' => 699.00,
                'discount_price' => 649.00,
                'stock' => 12,
                'pages' => 464,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-SAPIENS',
                'author_slug' => 'yuval-noah-harari',
                'publisher_slug' => 'harpercollins-publishers',
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'slug' => 'thinking-fast-and-slow',
                'isbn' => null,
                'description' => 'Daniel Kahneman explores two modes of thinking and explains how cognitive biases, intuition, and judgment influence the decisions people make.',
                'price' => 620.00,
                'discount_price' => null,
                'stock' => 11,
                'pages' => 512,
                'language' => 'English',
                'publication_date' => null,
                'cover_image' => null,
                'sku' => 'BOOK-THINKING-FAST-SLOW',
                'author_slug' => 'daniel-kahneman',
                'publisher_slug' => 'farrar-straus-and-giroux',
            ],
        ];

        DB::transaction(function () use ($books) {
            foreach ($books as $bookData) {
                /*
                 * Find the author using the slug from AuthorsAndPublishersSeeder.
                 */
                $author = Author::where(
                    'slug',
                    $bookData['author_slug']
                )->firstOrFail();

                /*
                 * Find the publisher using its slug.
                 */
                $publisher = Publisher::where(
                    'slug',
                    $bookData['publisher_slug']
                )->firstOrFail();

                /*
                 * Remove the temporary relationship identifiers.
                 */
                unset(
                    $bookData['author_slug'],
                    $bookData['publisher_slug']
                );

                /*
                 * Assign the foreign keys.
                 */
                $bookData['primary_author_id'] = $author->id;
                $bookData['publisher_id'] = $publisher->id;

                /*
                 * Create or update the book using its unique slug.
                 */
                $book = Book::withTrashed()->updateOrCreate(
                    ['slug' => $bookData['slug']],
                    $bookData
                );

                /*
                 * Restore the book if it was previously soft-deleted.
                 */
                if ($book->trashed()) {
                    $book->restore();
                }
            }
        });
    }
}
