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
        'email',
        'country',
    ];

    public string $search = '';
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
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

    public function deleteAuthor(Author $author): void
    {
        $this->authorize('delete', $author);

        $author->delete();

        session()->flash('success', 'Author deleted successfully.');
    }

    public function render()
    {
        $this->authorize('viewAny', Author::class);

        $authors = Author::query()
            ->when(trim($this->search) !== '', function ($query) {
                $term = '%' . trim($this->search) . '%';

                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('country', 'like', $term)
                        ->orWhere('bio', 'like', $term);
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.author.author-index', compact('authors'))
            ->layout('layouts.admin');
    }
}