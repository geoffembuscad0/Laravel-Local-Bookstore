<?php

namespace App\Livewire\Admin\Book;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class BookIndex extends Component
{
    use WithPagination;
    private const SORTABLE_COLUMNS = [
        'created_at',
        'title',
        'price',
        'stock',
        'isbn',
        'sku',
    ];

    public string $search = '';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if (! in_array($column, self::SORTABLE_COLUMNS, true)) {
            return;
        }

        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteBook(Book $book)
    {
        $this->authorize('delete', $book);
        $book->delete();
        session()->flash('success', 'Book deleted successfully');
    }

    public function render()
    {
        $this->authorize('viewAny', Book::class);
        $books = Book::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                    ->orWhere('isbn', 'like', "%{$this->search}%")
                    ->orWhere('sku', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.book.book-index', compact('books'));
    }
}