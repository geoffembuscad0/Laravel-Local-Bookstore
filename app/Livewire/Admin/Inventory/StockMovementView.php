<?php

namespace App\Livewire\Admin\Inventory;

use App\Models\StockMovement;
use Livewire\Component;

class StockMovementView extends Component
{
    public StockMovement $stockMovement;

    public function mount(StockMovement $stockMovement): void
    {
        $this->stockMovement = $stockMovement->load([
            'book.publisher',
            'book.primaryAuthor',
            'user',
            'purchaseOrderItem.purchaseOrder.supplier',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.inventory.stock-movement-view')
            ->layout('layouts.admin');
    }
}