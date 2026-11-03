<div class="container mx-auto px-4 py-8">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Inventory</h1>
            <p class="text-sm text-gray-600">Monitor current book stock levels.</p>
        </div>

        <a href="{{ route('admin.inventory.adjustment') }}"
           class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Adjust Stock
        </a>
    </div>

    <div class="mb-4 flex flex-col gap-3 md:flex-row">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Search books..."
            class="w-full rounded border border-gray-300 px-4 py-2"
        >

        <select wire:model.live="stockFilter"
                class="rounded border border-gray-300 px-4 py-2">
            <option value="all">All Stock</option>
            <option value="available">Available</option>
            <option value="low">Low Stock</option>
            <option value="out">Out of Stock</option>
        </select>

        <a href="{{ route('admin.inventory.movements') }}"
           class="rounded border border-gray-300 px-4 py-2 text-center hover:bg-gray-100">
            Stock Movements
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full">
            <thead class="border-b bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Book</th>
                    <th class="px-6 py-3 text-left">SKU</th>
                    <th class="px-6 py-3 text-left">Publisher</th>
                    <th class="px-6 py-3 text-left">Current Stock</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($books as $book)
                    <tr wire:key="inventory-book-{{ $book->id }}"
                        class="border-b hover:bg-gray-50">

                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $book->title }}</div>
                            <div class="text-xs text-gray-500">
                                {{ $book->isbn ?? 'No ISBN' }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            {{ $book->sku ?? '—' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $book->publisher?->name ?? '—' }}
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            {{ $book->stock }}
                        </td>

                        <td class="px-6 py-4">
                            @if ($book->stock === 0)
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs text-red-800">
                                    Out of Stock
                                </span>
                            @elseif ($book->stock <= 5)
                                <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs text-yellow-800">
                                    Low Stock
                                </span>
                            @else
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-800">
                                    Available
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No inventory records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>