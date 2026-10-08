<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Validate;

class EditCategory extends Component
{
    public Category $category;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string')]
    public string $description = '';

    #[Validate('nullable|exists:categories,id')]
    public ?int $parent_id = null;

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description ?? '';
        $this->parent_id = $category->parent_id;
    }

    public function update()
    {
        $this->validate();

        $this->category->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description ?: null,
            'parent_id' => $this->parent_id,
        ]);

        session()->flash('success', 'Category updated successfully');
    }

    public function render()
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $this->category->id)
            ->get();

        return view('livewire.admin.category.edit-category', compact('parentCategories'));
    }
}
