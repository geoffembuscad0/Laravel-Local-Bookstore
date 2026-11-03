<?php
namespace App\Livewire\Admin\PurchaseOrder;

use App\Models\Book;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreatePurchaseOrder extends Component
{
    public string $supplier_id = '';
    public string $order_date = '';
    public string $expected_delivery_date = '';
    public string $shipping_cost = '0.00';
    public string $tax_amount = '0.00';
    public string $notes = '';

    public array $items = [];

    public function mount(): void
    {
        $this->order_date = now()->toDateString();

        $this->items = [
            [
                'book_id' => '',
                'quantity_ordered' => 1,
                'unit_cost' => '0.00',
            ],
        ];
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
            'items.*.quantity_ordered' => [
                'required',
                'integer',
                'min:1',
            ],
            'items.*.unit_cost' => [
                'required',
                'numeric',
                'min:0',
            ],
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
            ->get()
            ->keyBy('id');

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

        $purchaseOrder = DB::transaction(function () use (
            $validated,
            $subtotal,
            $shippingCost,
            $taxAmount,
            $totalAmount
        ) {
            $purchaseOrder = PurchaseOrder::create([
                'po_number' => $this->generatePoNumber(),
                'supplier_id' => $validated['supplier_id'],
                'created_by' => auth()->id(),
                'status' => 'draft',
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?: null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?: null,
            ]);

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

            return $purchaseOrder;
        });

        session()->flash('success', 'Purchase order created successfully.');

        $this->redirect(
            route('admin.purchase-orders.view', $purchaseOrder)
        );
    }

    private function generatePoNumber(): string
    {
        do {
            $number = 'PO-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (PurchaseOrder::where('po_number', $number)->exists());

        return $number;
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
            'livewire.admin.purchase-order.create-purchase-order',
            compact('suppliers', 'books')
        )->layout('layouts.admin');
    }
}