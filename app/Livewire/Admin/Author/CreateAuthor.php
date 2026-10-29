<?php

namespace App\Livewire\Admin\Author;

use App\Models\Author;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateAuthor extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string')]
    public string $bio = '';

    #[Validate('nullable|date|before_or_equal:today')]
    public ?string $birth_date = null;

    #[Validate('nullable|url|max:255')]
    public string $website = '';

    #[Validate('nullable|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:255')]
    public string $country = '';

    public function save(): void
    {
        $this->authorize('create', Author::class);
        $validated = $this->validate();

        $baseSlug = Str::slug($this->name) ?: 'author';
        $slug = $baseSlug;
        $suffix = 2;

        while (Author::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $suffix++;
        }

        $author = Author::create([
            'name' => trim($validated['name']),
            'slug' => $slug,
            'bio' => $validated['bio'] ?: null,
            'birth_date' => $validated['birth_date'] ?: null,
            'website' => $validated['website'] ?: null,
            'email' => $validated['email'] ?: null,
            'country' => $validated['country'] ?: null,
        ]);

        session()->flash('success', 'Author created successfully.');

        $this->redirect(route('admin.authors.view', $author));
    }

    public function render()
    {
        $this->authorize('create', Author::class);

        return view('livewire.admin.author.create-author')
            ->layout('layouts.admin');
    }
}