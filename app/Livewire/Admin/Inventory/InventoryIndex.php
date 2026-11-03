<?php
namespace App\Livewire\Admin\Inventory;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $stockFilter = 'all';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStockFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $books = Book::query()
            ->with(['publisher', 'primaryAuthor'])
            ->when(trim($this->search) !== '', function ($query) {
                $term = '%' . trim($this->search) . '%';

                $query->where(function ($query) use ($term) {
                    $query->where('title', 'like', $term)
                        ->orWhere('isbn', 'like', $term)
                        ->orWhere('sku', 'like', $term);
                });
            })
            ->when($this->stockFilter === 'out', function ($query) {
                $query->where('stock', 0);
            })
            ->when($this->stockFilter === 'low', function ($query) {
                $query->whereBetween('stock', [1, 5]);
            })
            ->when($this->stockFilter === 'available', function ($query) {
                $query->where('stock', '>', 5);
            })
            ->orderBy('title')
            ->paginate(10);

        return view('livewire.admin.inventory.inventory-index', compact('books'))
            ->layout('layouts.admin');
    }
}