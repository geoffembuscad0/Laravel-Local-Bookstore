<?php

namespace App\Livewire\Customer;

use App\Models\Book;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductIndex extends Component
{
    public Book $book;
    public int $quantity = 1;

    public function mount(Book $book): void
    {
        abort_unless($book->product()->where('is_active', true)->exists(), 404);
        $this->book = $book->load(['primaryAuthor', 'publisher', 'categories']);
    }

    public function addToCart(CartService $cartService)
    {
        abort_unless(Auth::check() && Auth::user()->hasRole('User'), 403);
        $this->validate(['quantity' => ['required', 'integer', 'min:1', 'max:' . max(1, (int) $this->book->stock)]]);
        $cartService->add(Auth::id(), $this->book->id, $this->quantity);
        session()->flash('success', 'Book added to your cart.');
        return $this->redirect(route('cart.index'));
    }

    public function render()
    {
        $cartCount = auth()->check() ? auth()->user()->cart?->items()->sum('quantity') ?? 0 : 0;

        return view('livewire.customer.product-index', compact('cartCount'))
            ->layout('layouts.storefront');
    }
}
