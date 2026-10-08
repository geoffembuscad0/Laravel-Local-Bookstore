<?php

namespace App\Livewire\Admin\Book;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Validate;

class EditBook extends Component
{
    public Book $book;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string|max:20')]
    public string $isbn = '';

    #[Validate('nullable|string')]
    public string $description = '';

    #[Validate('required|numeric|min:0|decimal:0,2')]
    public float $price = 0;

    #[Validate('nullable|numeric|min:0|decimal:0,2|lt:price')]
    public ?float $discount_price = null;

    #[Validate('required|integer|min:0')]
    public int $stock = 0;

    #[Validate('nullable|integer|min:1')]
    public ?int $pages = null;

    #[Validate('nullable|string|max:50')]
    public string $language = '';

    #[Validate('nullable|date')]
    public ?string $publication_date = null;

    #[Validate('nullable|string|max:255')]
    public string $sku = '';

    #[Validate('nullable|exists:publishers,id')]
    public ?int $publisher_id = null;

    #[Validate('nullable|exists:authors,id')]
    public ?int $primary_author_id = null;

    public function mount(Book $book)
    {
        $this->authorize('update', $book);
        $this->book = $book;
        $this->title = $book->title;
        $this->isbn = $book->isbn ?? '';
        $this->description = $book->description ?? '';
        $this->price = $book->price;
        $this->discount_price = $book->discount_price;
        $this->stock = $book->stock;
        $this->pages = $book->pages;
        $this->language = $book->language ?? '';
        $this->publication_date = $book->publication_date?->format('Y-m-d');
        $this->sku = $book->sku ?? '';
        $this->publisher_id = $book->publisher_id;
        $this->primary_author_id = $book->primary_author_id;
    }

    public function update()
    {
        $this->authorize('update', $this->book);
        $this->validate();

        $this->book->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'isbn' => $this->isbn ?: null,
            'description' => $this->description ?: null,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'stock' => $this->stock,
            'pages' => $this->pages,
            'language' => $this->language ?: null,
            'publication_date' => $this->publication_date,
            'sku' => $this->sku ?: null,
            'publisher_id' => $this->publisher_id,
            'primary_author_id' => $this->primary_author_id,
        ]);

        session()->flash('success', 'Book updated successfully');
    }

    public function render()
    {
        $this->authorize('update', $this->book);
        return view('livewire.admin.book.edit-book', [
            'publishers' => Publisher::all(),
            'authors' => Author::all(),
        ]);
    }
}