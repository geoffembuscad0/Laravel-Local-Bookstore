<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Create New Category</h1>

    <form wire:submit="save" class="bg-white rounded-lg shadow p-6">
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

        <!-- Form Actions -->
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded">
                Cancel
            </a>
            <button 
                type="submit" 
                class="px-6 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded"
            >
                Create Category
            </button>
        </div>
    </form>
</div>
