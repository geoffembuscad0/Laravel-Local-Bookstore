<?php
namespace App\Livewire\Customer;

use App\Models\Book;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CollectionIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortBy = 'newest';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function addToCart(int $bookId, CartService $cartService): void
    {
        abort_unless(
            Auth::check() && Auth::user()->hasRole('User'),
            403
        );

        $cartService->add(Auth::id(), $bookId);

        session()->flash('success', 'Book added to your cart.');
    }

    public function render()
    {
        $products = Book::query()
            ->whereHas('product', function ($query) {
                $query->where('is_active', true);
            })
            ->with(['primaryAuthor', 'categories'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('isbn', 'like', '%' . $this->search . '%')
                        ->orWhereHas('primaryAuthor', function ($author) {
                            $author->where(
                                'name',
                                'like',
                                '%' . $this->search . '%'
                            );
                        });
                });
            })
            ->when($this->sortBy === 'newest', fn ($query) => $query->latest())
            ->when($this->sortBy === 'title', fn ($query) => $query->orderBy('title'))
            ->when($this->sortBy === 'price_low', fn ($query) => $query->orderByRaw('COALESCE(discount_price, price) ASC'))
            ->when($this->sortBy === 'price_high', fn ($query) => $query->orderByRaw('COALESCE(discount_price, price) DESC'))
            ->paginate(12);

        $cartCount = Auth::check()
            ? Auth::user()->cart?->items()->sum('quantity') ?? 0
            : 0;

        return view('livewire.customer.collection-index', compact(
            'products',
            'cartCount'
        ))->layout('layouts.storefront');
    }
}