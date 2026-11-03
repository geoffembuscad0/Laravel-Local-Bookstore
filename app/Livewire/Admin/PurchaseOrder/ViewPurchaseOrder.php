<?php
namespace App\Livewire\Admin\PurchaseOrder;

use App\Enums\PurchaseOrderStatus;
use App\Models\PurchaseOrder;
use App\Services\InventoryService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewPurchaseOrder extends Component
{
    public PurchaseOrder $purchaseOrder;

    public array $receivingQuantities = [];
    public array $receivingNotes = [];

    public function mount(PurchaseOrder $purchaseOrder): void
    {
        $this->purchaseOrder = $purchaseOrder;

        $this->loadPurchaseOrder();
    }

    private function loadPurchaseOrder(): void
    {
        $this->purchaseOrder->load([
            'supplier',
            'creator',
            'items.book',
            'items.stockMovements.user',
        ]);

        foreach ($this->purchaseOrder->items as $item) {
            $this->receivingQuantities[$item->id] ??= 1;
            $this->receivingNotes[$item->id] ??= '';
        }
    }

    public function placeOrder(): void
    {
        DB::transaction(function () {
            $purchaseOrder = PurchaseOrder::query()
                ->lockForUpdate()
                ->withCount('items')
                ->findOrFail($this->purchaseOrder->id);

            if ($purchaseOrder->status !== PurchaseOrderStatus::DRAFT) {
                abort(403, 'Only draft purchase orders can be placed.');
            }

            if ($purchaseOrder->items_count < 1) {
                abort(422, 'A purchase order must contain at least one item.');
            }

            $purchaseOrder->update([
                'status' => PurchaseOrderStatus::ORDERED,
            ]);
        });

        session()->flash('success', 'Purchase order placed successfully.');

        $this->loadPurchaseOrder();
    }

    public function cancelOrder(): void
    {
        DB::transaction(function () {
            $purchaseOrder = PurchaseOrder::query()
                ->lockForUpdate()
                ->findOrFail($this->purchaseOrder->id);

            if (! in_array($purchaseOrder->status, [
                PurchaseOrderStatus::DRAFT,
                PurchaseOrderStatus::ORDERED,
            ], true)) {
                abort(403, 'This purchase order can no longer be cancelled.');
            }

            $hasReceivedItems = $purchaseOrder->items()
                ->where('quantity_received', '>', 0)
                ->exists();

            if ($hasReceivedItems) {
                abort(403, 'A purchase order with received items cannot be cancelled.');
            }

            $purchaseOrder->update([
                'status' => PurchaseOrderStatus::CANCELLED,
            ]);
        });

        session()->flash('success', 'Purchase order cancelled.');

        $this->loadPurchaseOrder();
    }

    public function receiveItem(
        int $itemId,
        InventoryService $inventoryService
    ): void {
        $item = $this->purchaseOrder->items()
            ->findOrFail($itemId);

        $validated = $this->validate([
            "receivingQuantities.{$itemId}" => [
                'required',
                'integer',
                'min:1',
                'max:' . $item->remaining_quantity,
            ],
            "receivingNotes.{$itemId}" => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $inventoryService->receivePurchaseOrderItem(
            item: $item,
            quantity: (int) $validated['receivingQuantities'][$itemId],
            userId: auth()->id(),
            notes: $validated['receivingNotes'][$itemId] ?: null,
        );

        $this->receivingQuantities[$itemId] = 1;
        $this->receivingNotes[$itemId] = '';

        session()->flash('success', 'Received stock successfully.');

        $this->loadPurchaseOrder();
    }

    public function render()
    {
        return view(
            'livewire.admin.purchase-order.view-purchase-order'
        )->layout('layouts.admin');
    }
}