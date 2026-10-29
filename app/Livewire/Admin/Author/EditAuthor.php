<?php

namespace App\Livewire\Admin\Author;

use App\Models\Author;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditAuthor extends Component
{
    public Author $author;

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

    public function mount(Author $author): void
    {
        $this->authorize('update', $author);

        $this->author = $author;
        $this->name = $author->name;
        $this->bio = $author->bio ?? '';
        $this->birth_date = $author->birth_date?->format('Y-m-d');
        $this->website = $author->website ?? '';
        $this->email = $author->email ?? '';
        $this->country = $author->country ?? '';
    }

    public function update(): void
    {
        $this->authorize('update', $this->author);
        $validated = $this->validate();

        $baseSlug = Str::slug($validated['name']) ?: 'author';
        $slug = $baseSlug;
        $suffix = 2;

        while (
            Author::withTrashed()
                ->where('slug', $slug)
                ->where('id', '!=', $this->author->id)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $suffix++;
        }

        $this->author->update([
            'name' => trim($validated['name']),
            'slug' => $slug,
            'bio' => $validated['bio'] ?: null,
            'birth_date' => $validated['birth_date'] ?: null,
            'website' => $validated['website'] ?: null,
            'email' => $validated['email'] ?: null,
            'country' => $validated['country'] ?: null,
        ]);

        session()->flash('success', 'Author updated successfully.');
        $this->redirect(route('admin.authors.view', $this->author));
    }

    public function render()
    {
        $this->authorize('update', $this->author);

        return view('livewire.admin.author.edit-author')
            ->layout('layouts.admin');
    }
}