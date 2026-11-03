<?php

namespace App\Livewire\Customer;

use App\Models\Book;
use App\Models\Category;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class HomePage extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function addToCart(int $bookId, CartService $cartService)
    {
        abort_unless(Auth::check() && Auth::user()->hasRole('User'), 403);
        $cartService->add(Auth::id(), $bookId);
        session()->flash('success', 'Book added to your cart.');
        return $this->redirect(route('cart.index'));
    }

    public function render()
    {
        $products = Book::query()
            ->whereHas('product', fn ($query) => $query->where('is_active', true))
            ->with(['primaryAuthor', 'categories'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('isbn', 'like', '%' . $this->search . '%')
                        ->orWhereHas('primaryAuthor', fn ($author) => $author->where('name', 'like', '%' . $this->search . '%'));
                });
            })
            ->orderBy('title')->paginate(12);

        $categories = Category::query()->withCount(['books' => fn ($query) => $query->whereHas('product', fn ($product) => $product->where('is_active', true))])->orderBy('name')->get();
        $cartCount = auth()->check() ? auth()->user()->cart?->items()->sum('quantity') ?? 0 : 0;

        return view('livewire.customer.home-page', compact('products', 'categories', 'cartCount'))
            ->layout('layouts.storefront');
    }
}
