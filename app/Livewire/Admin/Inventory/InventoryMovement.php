<?php
namespace App\Livewire\Admin\Inventory;

use App\Enums\StockMovementType;
use App\Models\StockMovement;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryMovement extends Component
{
    use WithPagination;

    public string $search = '';
    public string $typeFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTypeFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $movements = StockMovement::query()
            ->with(['book', 'user', 'purchaseOrderItem.purchaseOrder'])
            ->when(trim($this->search) !== '', function ($query) {
                $term = '%' . trim($this->search) . '%';

                $query->where(function ($query) use ($term) {
                    $query->where('reference', 'like', $term)
                        ->orWhere('notes', 'like', $term)
                        ->orWhereHas('book', function ($bookQuery) use ($term) {
                            $bookQuery->where('title', 'like', $term);
                        });
                });
            })
            ->when($this->typeFilter !== '', function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->latest()
            ->paginate(15);

        $movementTypes = StockMovementType::cases();

        return view(
            'livewire.admin.inventory.inventory-movement',
            compact('movements', 'movementTypes')
        )->layout('layouts.admin');
    }
}