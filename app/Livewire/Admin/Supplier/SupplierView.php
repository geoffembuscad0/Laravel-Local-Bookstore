<?php

namespace App\Livewire\Admin\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierView extends Component
{
    use WithPagination;

    public Supplier $supplier;

    public function mount(Supplier $supplier): void
    {
        $this->authorize('view', $supplier);
        $this->supplier = $supplier;
    }

    public function render()
    {
        $this->authorize('view', $this->supplier);

        $purchaseOrders = $this->supplier->purchaseOrders()
            ->orderByDesc('order_date')
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.admin.supplier.supplier-view', compact('purchaseOrders'))
            ->layout('layouts.admin');
    }
}
