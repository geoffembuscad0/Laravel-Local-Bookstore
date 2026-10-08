<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Category: {{ $category->name }}</h1>

    <form wire:submit="update" class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input 
                    type="text" 
                    id="name" 
                    wire:model="name" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter category name"
                >
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Parent Category -->
            <div>
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Parent Category</label>
                <select 
                    id="parent_id" 
                    wire:model="parent_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">-- Select Parent Category --</option>
                    @foreach ($parentCategories as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
                @error('parent_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Description -->
        <div class="mt-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea 
                id="description" 
                wire:model="description"
                rows="5"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter category description (optional)"
            ></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Category Details -->
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Category Information</h3>
            <dl class="space-y-2 text-sm">
                <div>
                    <dt class="font-medium text-gray-700">Slug</dt>
                    <dd class="text-gray-600">{{ $category->slug }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-700">Created At</dt>
                    <dd class="text-gray-600">{{ $category->created_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-700">Last Updated</dt>
                    <dd class="text-gray-600">{{ $category->updated_at->format('M d, Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded">
                Cancel
            </a>
            <button 
                type="submit" 
                class="px-6 py-2 bg-yellow-500 hover:bg-yellow-700 text-white font-bold rounded"
            >
                Update Category
            </button>
        </div>
    </form>
</div>
