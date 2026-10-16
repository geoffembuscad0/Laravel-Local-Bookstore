<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Publisher;

class AuthorsAndPublishersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Authors
        |--------------------------------------------------------------------------
        */

        $authors = [
            [
                'name' => 'Marcus Aurelius',
                'slug' => 'marcus-aurelius',
                'bio' => 'Roman emperor and Stoic philosopher. His personal writings, published as Meditations, explore self-discipline, duty, reason, and the nature of human life.',
                'birth_date' => null,
                'website' => null,
                'email' => null,
                'country' => 'Roman Empire',
            ],
            [
                'name' => 'Aristotle',
                'slug' => 'aristotle',
                'bio' => 'Ancient Greek philosopher whose writings influenced ethics, politics, logic, metaphysics, and the study of nature. His Nicomachean Ethics remains a foundational work in moral philosophy.',
                'birth_date' => null,
                'website' => null,
                'email' => null,
                'country' => 'Ancient Greece',
            ],
            [
                'name' => 'Friedrich Nietzsche',
                'slug' => 'friedrich-nietzsche',
                'bio' => 'German philosopher known for his critiques of morality, religion, and traditional values. His influential works include Beyond Good and Evil, Thus Spoke Zarathustra, and On the Genealogy of Morality.',
                'birth_date' => '1844-10-15',
                'website' => null,
                'email' => null,
                'country' => 'Germany',
            ],
            [
                'name' => 'Viktor E. Frankl',
                'slug' => 'viktor-e-frankl',
                'bio' => 'Austrian neurologist, psychiatrist, and Holocaust survivor who founded logotherapy, an approach to psychotherapy centered on the human search for meaning. His best-known book is Mans Search for Meaning.',
                'birth_date' => '1905-03-26',
                'website' => null,
                'email' => null,
                'country' => 'Austria',
            ],
            [
                'name' => 'Robert Greene',
                'slug' => 'robert-greene',
                'bio' => 'American author known for books examining power, strategy, human behavior, and mastery. His works include The 48 Laws of Power, The Art of Seduction, and Mastery.',
                'birth_date' => null,
                'website' => 'https://powerseductionandwar.com/',
                'email' => null,
                'country' => 'United States',
            ],
            [
                'name' => 'James Clear',
                'slug' => 'james-clear',
                'bio' => 'American author and writer focused on habits, behavior change, and continuous improvement. He is best known for Atomic Habits, which explores practical systems for building good habits and breaking bad ones.',
                'birth_date' => null,
                'website' => 'https://jamesclear.com/',
                'email' => null,
                'country' => 'United States',
            ],
            [
                'name' => 'Cal Newport',
                'slug' => 'cal-newport',
                'bio' => 'American computer science professor and nonfiction author whose work explores productivity, attention, digital technology, and meaningful work. His books include Deep Work, Digital Minimalism, and Slow Productivity.',
                'birth_date' => null,
                'website' => 'https://calnewport.com/',
                'email' => null,
                'country' => 'United States',
            ],
            [
                'name' => 'Ryan Holiday',
                'slug' => 'ryan-holiday',
                'bio' => 'American author and media strategist known for popularizing practical applications of Stoic philosophy. His books include The Obstacle Is the Way, Ego Is the Enemy, and Stillness Is the Key.',
                'birth_date' => null,
                'website' => 'https://ryanholiday.net/',
                'email' => null,
                'country' => 'United States',
            ],
            [
                'name' => 'Yuval Noah Harari',
                'slug' => 'yuval-noah-harari',
                'bio' => 'Israeli historian and author whose books examine human history, civilization, technology, and the future of humanity. His internationally recognized works include Sapiens, Homo Deus, and 21 Lessons for the 21st Century.',
                'birth_date' => '1976-02-24',
                'website' => 'https://www.ynharari.com/',
                'email' => null,
                'country' => 'Israel',
            ],
            [
                'name' => 'Daniel Kahneman',
                'slug' => 'daniel-kahneman',
                'bio' => 'Israeli-American psychologist and Nobel Memorial Prize in Economic Sciences laureate whose research transformed the understanding of judgment, decision-making, and behavioral economics. He co-authored Thinking, Fast and Slow.',
                'birth_date' => '1934-03-05',
                'website' => null,
                'email' => null,
                'country' => 'Israel',
            ],
        ];

        foreach ($authors as $authorData) {
            $author = Author::withTrashed()->updateOrCreate(
                ['slug' => $authorData['slug']],
                $authorData
            );

            // Restore the author if the existing record was soft-deleted.
            if ($author->trashed()) {
                $author->restore();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Publishers
        |--------------------------------------------------------------------------
        */

        $publishers = [
            [
                'name' => 'Penguin Random House',
                'slug' => 'penguin-random-house',
                'description' => 'A major international book publishing group with an extensive catalog of nonfiction, literature, biographies, history, philosophy, and personal development titles.',
                'website' => 'https://www.penguinrandomhouse.com/',
                'email' => null,
                'country' => 'United States',
                'founded_year' => 2013,
            ],
            [
                'name' => 'HarperCollins Publishers',
                'slug' => 'harpercollins-publishers',
                'description' => 'An international publishing company offering books across nonfiction, history, psychology, business, biography, religion, and general literature.',
                'website' => 'https://www.harpercollins.com/',
                'email' => null,
                'country' => 'United States',
                'founded_year' => 1989,
            ],
            [
                'name' => 'Simon & Schuster',
                'slug' => 'simon-and-schuster',
                'description' => 'A major book publisher with a broad catalog of nonfiction, memoirs, history, philosophy, psychology, politics, and popular science.',
                'website' => 'https://www.simonandschuster.com/',
                'email' => null,
                'country' => 'United States',
                'founded_year' => 1924,
            ],
            [
                'name' => 'Macmillan Publishers',
                'slug' => 'macmillan-publishers',
                'description' => 'An international publishing company with titles in academic publishing, popular nonfiction, science, history, biography, and general interest.',
                'website' => 'https://us.macmillan.com/',
                'email' => null,
                'country' => 'United Kingdom',
                'founded_year' => 1843,
            ],
            [
                'name' => 'Hachette Book Group',
                'slug' => 'hachette-book-group',
                'description' => 'A major United States book publisher offering nonfiction across history, politics, business, psychology, biography, and personal development.',
                'website' => 'https://www.hachettebookgroup.com/',
                'email' => null,
                'country' => 'United States',
                'founded_year' => 2006,
            ],
            [
                'name' => 'Oxford University Press',
                'slug' => 'oxford-university-press',
                'description' => 'The publishing department of the University of Oxford, known for scholarly books, academic references, philosophy, history, religion, and educational publications.',
                'website' => 'https://global.oup.com/',
                'email' => null,
                'country' => 'United Kingdom',
                'founded_year' => 1586,
            ],
            [
                'name' => 'W. W. Norton & Company',
                'slug' => 'ww-norton-and-company',
                'description' => 'An independent American publisher known for nonfiction, psychology, history, science, philosophy, literary criticism, and educational books.',
                'website' => 'https://wwnorton.com/',
                'email' => null,
                'country' => 'United States',
                'founded_year' => 1923,
            ],
            [
                'name' => 'Yale University Press',
                'slug' => 'yale-university-press',
                'description' => 'An academic publisher producing scholarly and general-interest books in history, philosophy, politics, art, religion, and the social sciences.',
                'website' => 'https://yalebooks.yale.edu/',
                'email' => null,
                'country' => 'United States',
                'founded_year' => 1908,
            ],

            [
                'name' => 'Grand Central Publishing',
                'slug' => 'grand-central-publishing',
                'description' => 'A book publishing imprint known for publishing nonfiction, popular psychology, business, history, and general-interest titles.',
                'website' => 'https://www.hachettebookgroup.com/',
                'email' => null,
                'country' => 'United States',
                'founded_year' => null,
            ],
            [
                'name' => 'Farrar, Straus and Giroux',
                'slug' => 'farrar-straus-and-giroux',
                'description' => 'A publishing imprint known for literary fiction, nonfiction, history, biography, and other works of intellectual and cultural interest.',
                'website' => 'https://us.macmillan.com/',
                'email' => null,
                'country' => 'United States',
                'founded_year' => null,
            ]
        ];

        foreach ($publishers as $publisherData) {
            $publisher = Publisher::withTrashed()->updateOrCreate(
                ['slug' => $publisherData['slug']],
                $publisherData
            );

            // Restore the publisher if the existing record was soft-deleted.
            if ($publisher->trashed()) {
                $publisher->restore();
            }
        }
    }
}
