<?php

namespace App\Livewire\Admin\Book;

use App\Models\Book;
use Livewire\Component;

class ViewBook extends Component
{
    public Book $book;

    public function mount(Book $book)
    {
        $this->authorize('view', $book);
        $this->book = $book;
    }

    public function render()
    {
        $this->authorize('view', $this->book);
        return view('livewire.admin.book.view-book');
    }
}