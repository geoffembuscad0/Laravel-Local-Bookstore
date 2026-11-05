<?php

namespace App\Livewire\Admin\Book;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Str;
use App\Services\InventoryService;
use App\Enums\StockMovementType;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Throwable;

class CreateBook extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string|max:20|unique:books,isbn')]
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

    #[Validate('nullable|string|max:255|unique:books,sku')]
    public string $sku = '';

    #[Validate('nullable|exists:publishers,id')]
    public ?int $publisher_id = null;

    #[Validate('nullable|exists:authors,id')]
    public ?int $primary_author_id = null;

    #[Validate('nullable|image|max:2048')]
    public $cover_image = null;

    public function save()
    {
        $this->authorize('create', Book::class);

        $this->validate();

        // Upload the cover image when provided.
        $coverImagePath = $this->storeCoverImage();

        try {
            $book = DB::transaction(function () use ($coverImagePath) {

                $book = Book::create([
                    'title' => $this->title,
                    'slug' => Str::slug($this->title),
                    'isbn' => $this->isbn ?: null,
                    'description' => $this->description ?: null,
                    'price' => $this->price,
                    'discount_price' => $this->discount_price,
                    'stock' => 0,
                    'pages' => $this->pages,
                    'language' => $this->language ?: null,
                    'publication_date' => $this->publication_date,
                    'cover_image' => $coverImagePath,
                    'sku' => $this->sku ?: null,
                    'publisher_id' => $this->publisher_id,
                    'primary_author_id' => $this->primary_author_id,
                ]);

                // Automatically create the associated Product.
                $this->createProduct($book);

                if ($this->stock > 0) {
                    app(InventoryService::class)->recordStockMovement(
                        book: $book,
                        quantity: $this->stock,
                        userId: auth()->id(),
                        type: StockMovementType::INITIAL_STOCK,
                        notes: 'Initial stock upon book creation.',
                    );
                }

                return $book;
            });

        } catch (Throwable $exception) {

            // Remove the uploaded image if database operations fail.
            if ($coverImagePath) {
                Storage::disk(config('books.cover_disk'))
                    ->delete($coverImagePath);
            }

            throw $exception;
        }

        session()->flash('success', 'Book created successfully');

        redirect()->route('admin.books.view', $book);
    }
    private function createProduct(Book $book)
    {
        $book->product()->create([
            'is_active' => true,
        ]);
    }

    public function render()
    {
        $this->authorize('create', Book::class);
        return view('livewire.admin.book.create-book', [
            'publishers' => Publisher::all(),
            'authors' => Author::all(),
        ])->layout('layouts.admin');
    }
    private function generateCoverFilename()
    {
        $extension = $this->cover_image->getClientOriginalExtension();

        $filename = pathinfo(
            $this->cover_image->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        // Replace spaces and other non-alphanumeric characters with underscores.
        $filename = preg_replace('/[^A-Za-z0-9_-]+/', '_', $filename);

        // Remove underscores from the beginning and end.
        $filename = trim($filename, '_');

        return 'book_' . $this->book->id . '_' . $filename . '.' . strtolower($extension);
    }
    private function storeCoverImage()
    {
        if (!$this->cover_image) {
            return null;
        }

        $directory = public_path('images/books/covers');

        File::ensureDirectoryExists($directory);

        $filename = $this->generateCoverFilename();

        $this->cover_image->move($directory, $filename);

        return 'images/books/covers/' . $filename;
    }
}