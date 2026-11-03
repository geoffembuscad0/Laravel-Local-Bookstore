<?php
namespace App\Livewire\Admin\Inventory;

use App\Models\Book;
use App\Services\InventoryService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class InventoryAdjustment extends Component
{
    public string $bookId = '';
    public string $adjustmentType = 'increase';
    public int $quantity = 1;
    public string $reason = '';

    protected function rules(): array
    {
        return [
            'bookId' => ['required', 'exists:books,id'],
            'adjustmentType' => ['required', 'in:increase,decrease'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reason' => ['required', 'string', 'max:1000'],
        ];
    }

    public function save(InventoryService $inventoryService): void
    {
        $validated = $this->validate();

        $book = Book::findOrFail($validated['bookId']);

        $quantity = $validated['adjustmentType'] === 'increase'
            ? $validated['quantity']
            : -$validated['quantity'];

        $inventoryService->adjustStock(
            book: $book,
            quantity: $quantity,
            userId: auth()->id(),
            reason: $validated['reason'],
        );

        session()->flash('success', 'Inventory adjustment recorded successfully.');

        $this->reset([
            'bookId',
            'quantity',
            'reason',
        ]);

        $this->adjustmentType = 'increase';
        $this->quantity = 1;
    }

    public function render()
    {
        $books = Book::query()
            ->orderBy('title')
            ->get(['id', 'title', 'sku', 'stock']);

        return view('livewire.admin.inventory.inventory-adjustment', compact('books'))
            ->layout('layouts.admin');
    }
}