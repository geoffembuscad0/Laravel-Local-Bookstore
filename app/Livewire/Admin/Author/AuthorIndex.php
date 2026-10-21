<?php

namespace App\Livewire\Admin\Author;

use App\Models\Author;
use Livewire\Component;
use Livewire\WithPagination;

class AuthorIndex extends Component
{
    use WithPagination;
    private const SORTABLE_COLUMNS = [
        'created_at',
        'name',
        'email'
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

    public function deleteAuthor(Author $author)
    {
        $this->authorize('delete', $author);
        $author->delete();
        session()->flash('success', 'Author deleted successfully');
    }

    public function render()
    {
        $this->authorize('viewAny', Author::class);
        $authors = Author::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.author.author-index', compact('authors'));
    }
}