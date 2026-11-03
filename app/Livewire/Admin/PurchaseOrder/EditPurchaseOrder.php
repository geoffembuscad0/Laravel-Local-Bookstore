<?php
namespace App\Livewire\Admin\PurchaseOrder;

use App\Enums\PurchaseOrderStatus;
use App\Models\Book;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditPurchaseOrder extends Component
{
    public PurchaseOrder $purchaseOrder;

    public string $supplier_id = '';
    public string $order_date = '';
    public string $expected_delivery_date = '';
    public string $shipping_cost = '0.00';
    public string $tax_amount = '0.00';
    public string $notes = '';

    public array $items = [];

    public function mount(PurchaseOrder $purchaseOrder): void
    {
        abort_unless(
            $purchaseOrder->status === PurchaseOrderStatus::DRAFT,
            403,
            'Only draft purchase orders can be edited.'
        );

        $this->purchaseOrder = $purchaseOrder->load('items');

        $this->supplier_id = (string) $purchaseOrder->supplier_id;
        $this->order_date = $purchaseOrder->order_date->format('Y-m-d');
        $this->expected_delivery_date = $purchaseOrder->expected_delivery_date?->format('Y-m-d') ?? '';
        $this->shipping_cost = (string) $purchaseOrder->shipping_cost;
        $this->tax_amount = (string) $purchaseOrder->tax_amount;
        $this->notes = $purchaseOrder->notes ?? '';

        $this->items = $purchaseOrder->items->map(fn ($item) => [
            'book_id' => (string) $item->book_id,
            'quantity_ordered' => $item->quantity_ordered,
            'unit_cost' => (string) $item->unit_cost,
        ])->toArray();
    }

    protected function rules(): array
    {
        return [
            'supplier_id' => [
                'required',
                Rule::exists('suppliers', 'id')
                    ->where('is_active', true)
                    ->whereNull('deleted_at'),
            ],

            'order_date' => ['required', 'date'],

            'expected_delivery_date' => [
                'nullable',
                'date',
                'after_or_equal:order_date',
            ],

            'shipping_cost' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:5000'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.book_id' => [
                'required',
                'distinct',
                Rule::exists('books', 'id')->whereNull('deleted_at'),
            ],
            'items.*.quantity_ordered' => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function addItem(): void
    {
        $this->items[] = [
            'book_id' => '',
            'quantity_ordered' => 1,
            'unit_cost' => '0.00',
        ];
    }

    public function removeItem(int $index): void
    {
        if (count($this->items) <= 1) {
            return;
        }

        unset($this->items[$index]);

        $this->items = array_values($this->items);
    }

    public function save(): void
    {
        $validated = $this->validate();

        $bookIds = collect($validated['items'])
            ->pluck('book_id')
            ->map(fn ($id) => (int) $id);

        $books = Book::query()
            ->whereIn('id', $bookIds)
            ->get();

        if ($books->count() !== $bookIds->count()) {
            $this->addError('items', 'One or more selected books are no longer available.');

            return;
        }

        $subtotal = 0;

        foreach ($validated['items'] as $item) {
            $subtotal += round(
                (int) $item['quantity_ordered'] * (float) $item['unit_cost'],
                2
            );
        }

        $shippingCost = (float) $validated['shipping_cost'];
        $taxAmount = (float) $validated['tax_amount'];

        $totalAmount = round($subtotal + $shippingCost + $taxAmount, 2);

        DB::transaction(function () use (
            $validated,
            $subtotal,
            $shippingCost,
            $taxAmount,
            $totalAmount
        ) {
            $purchaseOrder = PurchaseOrder::query()
                ->lockForUpdate()
                ->findOrFail($this->purchaseOrder->id);

            if ($purchaseOrder->status !== PurchaseOrderStatus::DRAFT) {
                abort(403, 'Only draft purchase orders can be edited.');
            }

            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?: null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?: null,
            ]);

            $purchaseOrder->items()->delete();

            foreach ($validated['items'] as $item) {
                $lineTotal = round(
                    (int) $item['quantity_ordered'] * (float) $item['unit_cost'],
                    2
                );

                $purchaseOrder->items()->create([
                    'book_id' => $item['book_id'],
                    'quantity_ordered' => $item['quantity_ordered'],
                    'quantity_received' => 0,
                    'unit_cost' => $item['unit_cost'],
                    'line_total' => $lineTotal,
                ]);
            }
        });

        session()->flash('success', 'Purchase order updated successfully.');

        $this->redirect(
            route('admin.purchase-orders.view', $this->purchaseOrder)
        );
    }

    public function render()
    {
        $suppliers = Supplier::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $books = Book::query()
            ->orderBy('title')
            ->get(['id', 'title', 'isbn', 'sku', 'stock']);

        return view(
            'livewire.admin.purchase-order.edit-purchase-order',
            compact('suppliers', 'books')
        )->layout('layouts.admin');
    }
}