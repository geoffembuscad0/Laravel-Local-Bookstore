<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomerOrderService
{
    public function checkout(User $user, array $shipping): Order
    {
        return DB::transaction(function () use ($user, $shipping) {
            $cart = Cart::query()->where('user_id', $user->id)->lockForUpdate()->firstOrFail();
            $items = $cart->items()->with('book.product')->get();

            if ($items->isEmpty()) {
                throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
            }

            $books = Book::query()->whereIn('id', $items->pluck('book_id'))
                ->whereHas('product', fn ($query) => $query->where('is_active', true))
                ->lockForUpdate()->get()->keyBy('id');

            $subtotalCents = 0;
            foreach ($items as $item) {
                $book = $books->get($item->book_id);
                if (! $book || $book->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => 'One or more cart items are no longer available in the requested quantity. Please review your cart.',
                    ]);
                }
                $subtotalCents += (int) round(((float) ($book->discount_price ?? $book->price)) * 100) * $item->quantity;
            }
            $subtotal = $subtotalCents / 100;

            $order = Order::create([
                'order_number' => $this->newOrderNumber(),
                'user_id' => $user->id,
                'status' => 'pending',
                'payment_method' => 'cash_on_delivery',
                'payment_status' => 'unpaid',
                'customer_name' => $shipping['customer_name'],
                'customer_email' => $user->email,
                'customer_phone' => $shipping['customer_phone'],
                'shipping_address' => $shipping['shipping_address'],
                'shipping_barangay' => $shipping['shipping_barangay'],
                'shipping_city' => $shipping['shipping_city'],
                'shipping_postal_code' => $shipping['shipping_postal_code'],
                'shipping_country' => 'Philippines',
                'delivery_landmark' => $shipping['delivery_landmark'] ?: null,
                'subtotal' => number_format($subtotal, 2, '.', ''),
                'shipping_cost' => '0.00',
                'total_amount' => number_format($subtotal, 2, '.', ''),
                'customer_notes' => $shipping['customer_notes'] ?: null,
                'placed_at' => now(),
            ]);

            foreach ($items as $item) {
                $book = $books->get($item->book_id);
                $unitPrice = (float) ($book->discount_price ?? $book->price);
                $lineTotal = round($unitPrice * $item->quantity, 2);

                $order->items()->create([
                    'book_id' => $book->id,
                    'book_title' => $book->title,
                    'book_isbn' => $book->isbn,
                    'quantity' => $item->quantity,
                    'unit_price' => number_format($unitPrice, 2, '.', ''),
                    'line_total' => number_format($lineTotal, 2, '.', ''),
                ]);

                $before = (int) $book->stock;
                $book->update(['stock' => $before - $item->quantity]);
                StockMovement::create([
                    'book_id' => $book->id,
                    'purchase_order_item_id' => null,
                    'user_id' => $user->id,
                    'type' => StockMovementType::SALE->value,
                    'quantity' => -$item->quantity,
                    'quantity_before' => $before,
                    'quantity_after' => $before - $item->quantity,
                    'reference' => $order->order_number,
                    'notes' => 'Customer order placed; payment due on delivery.',
                ]);
            }

            $cart->items()->delete();

            return $order;
        }, 3);
    }

    public function cancel(Order $order, User $user): void
    {
        DB::transaction(function () use ($order, $user) {
            $order = Order::query()->where('user_id', $user->id)->lockForUpdate()->findOrFail($order->id);
            if ($order->status !== 'pending') {
                throw ValidationException::withMessages(['order' => 'Only orders that are still pending can be cancelled. Please contact the bookstore if you need help with an order already being prepared.']);
            }

            foreach ($order->items as $item) {
                if (! $item->book_id) {
                    continue;
                }
                $book = Book::withTrashed()->lockForUpdate()->find($item->book_id);
                if (! $book) {
                    continue;
                }
                $before = (int) $book->stock;
                $book->update(['stock' => $before + $item->quantity]);
                StockMovement::create([
                    'book_id' => $book->id,
                    'purchase_order_item_id' => null,
                    'user_id' => $user->id,
                    'type' => StockMovementType::ADJUSTMENT->value,
                    'quantity' => $item->quantity,
                    'quantity_before' => $before,
                    'quantity_after' => $before + $item->quantity,
                    'reference' => $order->order_number,
                    'notes' => 'Stock returned after customer cancelled a pending COD order.',
                ]);
            }

            $order->update(['status' => 'cancelled']);
        }, 3);
    }

    private function newOrderNumber(): string
    {
        do {
            $number = 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
