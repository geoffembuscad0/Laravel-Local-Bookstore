<?php
namespace Database\Seeders;

use App\Models\Book;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        Book::query()->each(function (Book $book): void {
            Product::updateOrCreate(
                ['book_id' => $book->id],
                ['is_active' => true],
            );
        });
    }
}