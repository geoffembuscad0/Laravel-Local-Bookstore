<?php

namespace App\Livewire\Customer;

use App\Models\Cart;
use Livewire\Component;
use App\Services\CartService;

class CartIndex extends Component
{
    public function addToCart(int $bookId, CartService $cartService): void
    {
        $cartService->add(auth()->id(), $bookId);
        session()->flash('success', 'Book added to your cart.');
    }

    public function remove(int $itemId): void
    {
        $this->cart()->items()->whereKey($itemId)->delete();
    }

    private function cart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }
    public function updateQuantity(int $itemId, int $quantity): void
    {
        $this->resetErrorBag('quantity.' . $itemId);

        $item = $this->cart()
            ->items()
            ->with('book.product')
            ->findOrFail($itemId);

        if ($quantity < 1) {
            $item->delete();
            return;
        }

        abort_unless($item->book && $item->book->product?->is_active, 404);

        if ($quantity > $item->book->stock) {
            $this->addError(
                'quantity.' . $itemId,
                'The requested quantity exceeds available stock.'
            );

            return;
        }

        $item->update(['quantity' => $quantity]);
    }

    public function render()
    {
        $cart = $this->cart()->load(
            'items.book.primaryAuthor',
            'items.book.product'
        );

        $cartCount = $cart->items->sum('quantity');

        $hasUnavailableItems = $cart->items->contains(function ($item) {
            return ! $item->book
                || ! $item->book->product?->is_active
                || $item->book->stock < $item->quantity;
        });

        $subtotal = $cart->items->sum(function ($item) {
            $book = $item->book;

            if (! $book || ! $book->product?->is_active) {
                return 0;
            }

            $unitPrice = (float) ($book->discount_price ?? $book->price);

            return $unitPrice * $item->quantity;
        });

        return view('livewire.customer.cart-index', compact(
            'cart',
            'cartCount',
            'subtotal',
            'hasUnavailableItems'
        ))->layout('layouts.storefront');
    }
}
