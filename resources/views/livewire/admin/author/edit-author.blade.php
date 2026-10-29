<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Edit Author: {{ $author->name }}</h1>
        <p class="mt-1 text-sm text-gray-600">Update the author's profile information.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-400 bg-green-100 p-4 text-green-700" role="status">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="update" class="rounded-lg bg-white p-6 shadow">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Full Name *</label>
                <input id="name" type="text" wire:model="name" maxlength="255" required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" wire:model="email" maxlength="255"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="birth_date" class="mb-2 block text-sm font-medium text-gray-700">Birth Date</label>
                <input id="birth_date" type="date" wire:model="birth_date" max="{{ now()->toDateString() }}"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('birth_date') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="country" class="mb-2 block text-sm font-medium text-gray-700">Country</label>
                <input id="country" type="text" wire:model="country" maxlength="255"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('country') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label for="website" class="mb-2 block text-sm font-medium text-gray-700">Website</label>
                <input id="website" type="url" wire:model="website" maxlength="255"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="https://example.com">
                @error('website') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label for="bio" class="mb-2 block text-sm font-medium text-gray-700">Biography</label>
                <textarea id="bio" wire:model="bio" rows="6"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $bio }}</textarea>
                @error('bio') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6 rounded-lg bg-gray-50 p-4">
            <h2 class="mb-3 text-sm font-semibold text-gray-700">Author Information</h2>
            <dl class="grid grid-cols-1 gap-3 text-sm md:grid-cols-2">
                <div>
                    <dt class="font-medium text-gray-700">Slug</dt>
                    <dd class="break-all text-gray-600">{{ $author->slug }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-700">Created At</dt>
                    <dd class="text-gray-600">{{ $author->created_at?->format('M d, Y H:i') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-700">Last Updated</dt>
                    <dd class="text-gray-600">{{ $author->updated_at?->format('M d, Y H:i') ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('admin.authors.view', $author) }}"
               class="rounded bg-gray-500 px-6 py-2 font-bold text-white hover:bg-gray-700">Cancel</a>
            <button type="submit" wire:loading.attr="disabled"
                    class="rounded bg-yellow-500 px-6 py-2 font-bold text-white hover:bg-yellow-600 disabled:opacity-50">
                <span wire:loading.remove>Update Author</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </form>
</div>