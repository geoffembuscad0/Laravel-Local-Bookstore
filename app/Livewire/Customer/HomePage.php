<?php
namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Book;
use App\Models\Category;

class HomePage extends Component
{

    public function render() {
        $products = Book::orderBy('title')->get();
        $categories = Category::withCount('books')->orderBy('name')->get();

        return view('livewire.customer.home-page', [
            'products' => $products, 'categories' => $categories
        ]);
    }
}