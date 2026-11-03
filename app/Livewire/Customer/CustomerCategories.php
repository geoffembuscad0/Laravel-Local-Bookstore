<?php

namespace App\Livewire\Customer;

use App\Models\Book;
use App\Models\Category;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerCategories extends Component
{
    use WithPagination;

    public Category $category;
    public string $search = '';

    public function mount(Category $category): void
    {
        $this->category = $category;
    }

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
        $products = Book::query()->whereHas('product', fn ($query) => $query->where('is_active', true))
            ->whereHas('categories', fn ($query) => $query->where('categories.id', $this->category->id))
            ->with(['primaryAuthor', 'categories'])
            ->when($this->search, fn ($query) => $query->where('title', 'like', '%' . $this->search . '%'))
            ->orderBy('title')->paginate(12);
        $cartCount = auth()->check() ? auth()->user()->cart?->items()->sum('quantity') ?? 0 : 0;

        return view('livewire.customer.customer-categories', compact('products', 'cartCount'))
            ->layout('layouts.storefront');
    }
}
