<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Create New Book</h1>

    <form wire:submit="save" class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input 
                    type="text" 
                    id="title" 
                    wire:model="title" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- ISBN -->
            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">ISBN</label>
                <input 
                    type="text" 
                    id="isbn" 
                    wire:model="isbn" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('isbn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                <input 
                    type="number" 
                    id="price" 
                    wire:model="price" 
                    step="0.01" 
                    min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Discount Price -->
            <div>
                <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-2">Discount Price</label>
                <input 
                    type="number" 
                    id="discount_price" 
                    wire:model="discount_price" 
                    step="0.01" 
                    min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('discount_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                <input 
                    type="number" 
                    id="stock" 
                    wire:model="stock" 
                    min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- SKU -->
            <div>
                <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                <input 
                    type="text" 
                    id="sku" 
                    wire:model="sku" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Pages -->
            <div>
                <label for="pages" class="block text-sm font-medium text-gray-700 mb-2">Pages</label>
                <input 
                    type="number" 
                    id="pages" 
                    wire:model="pages" 
                    min="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('pages') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Language -->
            <div>
                <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                <input 
                    type="text" 
                    id="language" 
                    wire:model="language" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('language') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Publication Date -->
            <div>
                <label for="publication_date" class="block text-sm font-medium text-gray-700 mb-2">Publication Date</label>
                <input 
                    type="date" 
                    id="publication_date" 
                    wire:model="publication_date" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('publication_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Publisher -->
            <div>
                <label for="publisher_id" class="block text-sm font-medium text-gray-700 mb-2">Publisher</label>
                <select 
                    id="publisher_id" 
                    wire:model="publisher_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">Select a Publisher</option>
                    @foreach ($publishers as $publisher)
                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                    @endforeach
                </select>
                @error('publisher_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Primary Author -->
            <div>
                <label for="primary_author_id" class="block text-sm font-medium text-gray-700 mb-2">Primary Author</label>
                <select 
                    id="primary_author_id" 
                    wire:model="primary_author_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">Select an Author</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                    @endforeach
                </select>
                @error('primary_author_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea 
                    id="description" 
                    wire:model="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Book
            </button>
            <a href="{{ route('admin.books.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>