<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateCategory extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string')]
    public string $description = '';

    #[Validate('nullable|exists:categories,id')]
    public ?int $parent_id = null;

    public function save()
    {
        $this->validate();

        $category = Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description ?: null,
            'parent_id' => $this->parent_id,
        ]);

        session()->flash('success', 'Category created successfully');
        $this->redirect(route('admin.categories.view', $category));
    }

    public function render()
    {
        $parentCategories = Category::whereNull('parent_id')->get();

        return view('livewire.admin.category.create-category', compact('parentCategories'));
    }
}
