<?php
namespace App\Services;

use App\Enums\PurchaseOrderStatus;
use App\Enums\StockMovementType;
use App\Models\Book;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    public function recordStockMovement(
        Book|int $book,
        int $quantity,
        int $userId,
        StockMovementType $type,
        ?string $notes = null,
        ?string $reference = null
    ): StockMovement {
        if ($type === StockMovementType::PURCHASE_RECEIVED) {
            throw ValidationException::withMessages([
                'type' => 'Purchase receipts must be processed through the purchase order receiving workflow.',
            ]);
        }

        // Business rule validations
        if ($quantity === 0) {
            throw ValidationException::withMessages([
                'quantity' => 'Stock movement quantity cannot be zero.',
            ]);
        }

        if ($type === StockMovementType::INITIAL_STOCK && $quantity < 0) {
            throw ValidationException::withMessages([
                'quantity' => 'Initial stock must be a positive quantity.',
            ]);
        }

        if (in_array($type, [StockMovementType::SALE, StockMovementType::DAMAGE, StockMovementType::LOSS], true) && $quantity > 0) {
            throw ValidationException::withMessages([
                'quantity' => 'This movement type must decrease stock.',
            ]);
        }

        if ($type === StockMovementType::ADJUSTMENT && blank($notes)) {
            throw ValidationException::withMessages([
                'notes' => 'A reason is required for stock adjustments.',
            ]);
        }

        return DB::transaction(function () use (
            $book,
            $quantity,
            $userId,
            $type,
            $notes,
            $reference
        ) {
            $book = Book::query()
                ->lockForUpdate()
                ->findOrFail($book instanceof Book ? $book->id : $book);

            $quantityBefore = (int) $book->stock;

            if ($type === StockMovementType::INITIAL_STOCK && $quantityBefore !== 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'Initial stock has already been recorded for this book.',
                ]);
            }

            $quantityAfter = $quantityBefore + $quantity;

            if ($quantityAfter < 0) {
                throw ValidationException::withMessages([
                    'quantity' => "Insufficient stock. The available quantity is {$quantityBefore}.",
                ]);
            }

            $book->update(['stock' => $quantityAfter]);

            return StockMovement::create([
                'book_id' => $book->id,
                'purchase_order_item_id' => null,
                'user_id' => $userId,
                'type' => $type->value,
                'quantity' => $quantity,
                'quantity_before' => $quantityBefore,
                'quantity_after' => $quantityAfter,
                'reference' => $reference,
                'notes' => $notes,
            ]);
        }, 3);
    }

    public function adjustStock(
        Book|int $book,
        int $quantity,
        int $userId,
        string $reason
    ): StockMovement {
        if (blank($reason)) {
            throw ValidationException::withMessages([
                'reason' => 'Please provide a reason for the stock adjustment.',
            ]);
        }

        return $this->recordStockMovement(
            book: $book,
            quantity: $quantity,
            userId: $userId,
            type: StockMovementType::ADJUSTMENT,
            notes: $reason,
        );
    }

    public function receivePurchaseOrderItem(
        PurchaseOrderItem|int $item,
        int $quantity,
        int $userId,
        ?string $notes = null
    ): StockMovement {
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => 'Received quantity must be greater than zero.',
            ]);
        }

        return DB::transaction(function () use ($item, $quantity, $userId, $notes) {
            $itemId = $item instanceof PurchaseOrderItem ? $item->id : $item;

            $itemReference = PurchaseOrderItem::findOrFail($itemId);

            $purchaseOrder = PurchaseOrder::query()
                ->lockForUpdate()
                ->findOrFail($itemReference->purchase_order_id);

            $item = PurchaseOrderItem::query()
                ->where('purchase_order_id', $purchaseOrder->id)
                ->lockForUpdate()
                ->findOrFail($itemId);

            if (!in_array($purchaseOrder->status, [
                PurchaseOrderStatus::ORDERED,
                PurchaseOrderStatus::PARTIALLY_RECEIVED,
            ], true)) {
                throw ValidationException::withMessages([
                    'purchase_order' => 'This purchase order cannot receive items in its current status.',
                ]);
            }

            $remainingQuantity = $item->quantity_ordered - $item->quantity_received;

            if ($remainingQuantity <= 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'This purchase order item has already been fully received.',
                ]);
            }

            if ($quantity > $remainingQuantity) {
                throw ValidationException::withMessages([
                    'quantity' => "Only {$remainingQuantity} remaining copies can be received.",
                ]);
            }

            $book = Book::query()
                ->lockForUpdate()
                ->findOrFail($item->book_id);

            $quantityBefore = (int) $book->stock;
            $quantityAfter = $quantityBefore + $quantity;

            $book->update(['stock' => $quantityAfter]);
            $item->increment('quantity_received', $quantity);

            $movement = StockMovement::create([
                'book_id' => $book->id,
                'purchase_order_item_id' => $item->id,
                'user_id' => $userId,
                'type' => StockMovementType::PURCHASE_RECEIVED->value,
                'quantity' => $quantity,
                'quantity_before' => $quantityBefore,
                'quantity_after' => $quantityAfter,
                'reference' => $purchaseOrder->po_number,
                'notes' => $notes,
            ]);

            // Determine updated PO status
            $hasOutstandingItems = $purchaseOrder->items()
                ->whereColumn('quantity_received', '<', 'quantity_ordered')
                ->exists();

            $purchaseOrder->update([
                'status' => !$hasOutstandingItems 
                    ? PurchaseOrderStatus::RECEIVED->value 
                    : PurchaseOrderStatus::PARTIALLY_RECEIVED->value
            ]);

            return $movement;
        }, 3);
    }
}