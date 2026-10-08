<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class ViewCategory extends Component
{
    public Category $category;

    public function mount(Category $category)
    {
        $this->authorize('view', $category);
        $this->category = $category;
    }

    public function render()
    {
        $this->authorize('view', $this->category);
        return view('livewire.admin.category.view-category');
    }
}
