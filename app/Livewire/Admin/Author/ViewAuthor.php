<?php

namespace App\Livewire\Admin\Author;

use App\Models\Author;
use Livewire\Component;

class ViewAuthor extends Component
{
    public Author $author;

    public function mount(Author $author): void
    {
        $this->authorize('view', $author);

        $this->author = $author;
    }

    public function render()
    {
        $this->authorize('view', $this->author);

        return view('livewire.admin.author.view-author')
            ->layout('layouts.admin');
    }
}