<?php

namespace App\Livewire\Admin\Publisher;

use App\Models\Publisher;
use Livewire\Component;
use Livewire\WithPagination;

class PublisherIndex extends Component
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

    public function deletePublisher(Publisher  $publisher): void
    {
        $this->authorize('delete', $publisher);

        $publisher->delete();

        session()->flash('success', 'Publisher deleted successfully.');
    }

    public function render()
    {
        $this->authorize('viewAny', Publisher::class);

        $publishers = Publisher::query()
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

        return view('livewire.admin.publisher.publisher-index', compact('publishers'))
            ->layout('layouts.admin');
    }
}