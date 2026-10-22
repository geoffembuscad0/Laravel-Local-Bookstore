<?php
namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Book;
use App\Models\Category;

class CustomerCategories extends Component
{
    use WithPagination;
    public ?Category $category = null;

    public function mount(?Category $category = null): void {
        $this->category = $category;
    }

    public function render() {
        $products = Book::with('categories')
            ->when($this->category, function ($query) {
                $query->whereHas('categories', function ($categoryQuery) {
                    $categoryQuery->where(
                        'categories.id',
                        $this->category->id
                    );
                });
            })
            ->orderBy('title')
            ->paginate(12);

        return view('livewire.customer.customer-categories', [
            'products' => $products,
            'category' => $this->category,
        ]);
    }
}