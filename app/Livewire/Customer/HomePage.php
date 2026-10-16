<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use \App\Models\Category;

class HomePage extends Component
{
    public function render()
    {
        $categories = Category::withCount('books')->orderBy('name')->get();
        return view('livewire.customer.home-page', compact('categories'));
    }
}
