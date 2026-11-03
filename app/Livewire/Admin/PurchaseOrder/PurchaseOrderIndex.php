<?php
namespace App\Livewire\Admin\PurchaseOrder;

use App\Enums\PurchaseOrderStatus;
use App\Models\PurchaseOrder;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseOrderIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $purchaseOrders = PurchaseOrder::query()
            ->with(['supplier', 'creator'])
            ->withCount('items')
            ->when(trim($this->search) !== '', function ($query) {
                $term = '%' . trim($this->search) . '%';

                $query->where(function ($query) use ($term) {
                    $query->where('po_number', 'like', $term)
                        ->orWhereHas('supplier', function ($supplierQuery) use ($term) {
                            $supplierQuery->where('name', 'like', $term)
                                ->orWhere('code', 'like', $term);
                        });
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        $statuses = PurchaseOrderStatus::cases();

        return view(
            'livewire.admin.purchase-order.purchase-order-index',
            compact('purchaseOrders', 'statuses')
        )->layout('layouts.admin');
    }
}