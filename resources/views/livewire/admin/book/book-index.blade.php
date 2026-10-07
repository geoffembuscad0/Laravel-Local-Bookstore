<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold">Books Management</h1>
        <a href="{{ route('admin.books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Book
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Search by title, ISBN, or SKU..." 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold cursor-pointer" wire:click="sortBy('title')">
                        Title
                        @if ($sortBy === 'title')
                            <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold cursor-pointer" wire:click="sortBy('price')">
                        Price
                        @if ($sortBy === 'price')
                            <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold cursor-pointer" wire:click="sortBy('stock')">
                        Stock
                        @if ($sortBy === 'stock')
                            <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">ISBN</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">{{ $book->title }}</td>
                        <td class="px-6 py-4 text-sm">${{ number_format($book->price, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $book->isbn ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.books.view', $book) }}" class="text-blue-500 hover:underline">View</a>
                            <a href="{{ route('admin.books.edit', $book) }}" class="text-yellow-500 hover:underline">Edit</a>
                            <button wire:click="deleteBook({{ $book->id }})" wire:confirm="Are you sure?" class="text-red-500 hover:underline">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No books found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>