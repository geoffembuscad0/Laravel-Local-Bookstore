<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Publishers Management</h1>
        <a href="{{ route('admin.publisher.create') }}"
           class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700">
            Add New Publisher
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-400 bg-green-100 p-4 text-green-700" role="status">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <input type="search"
               wire:model.live.debounce.300ms="search"
               placeholder="Search by name, email, country, or biography..."
               aria-label="Search publishers"
               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full">
            <thead class="border-b bg-gray-100">
                <tr>
                    <th scope="col" class="cursor-pointer px-6 py-3 text-left text-sm font-semibold" wire:click="sortBy('name')">
                        Name
                        @if ($sortBy === 'name')
                            <span aria-hidden="true">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th scope="col" class="cursor-pointer px-6 py-3 text-left text-sm font-semibold" wire:click="sortBy('website')">
                        Website
                        @if ($sortBy === 'website')
                            <span aria-hidden="true">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th scope="col" class="cursor-pointer px-6 py-3 text-left text-sm font-semibold" wire:click="sortBy('country')">
                        Country
                        @if ($sortBy === 'country')
                            <span aria-hidden="true">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th scope="col" class="cursor-pointer px-6 py-3 text-left text-sm font-semibold" wire:click="sortBy('created_at')">
                        Created
                        @if ($sortBy === 'created_at')
                            <span aria-hidden="true">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($publishers as $publisher)
                    <tr wire:key="publisher-{{ $publisher->id }}" class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium">{{ $publisher->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $publisher->website ?: '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $publisher->country ?: '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $publisher->created_at?->format('M d, Y') ?? '—' }}</td>
                        <td class="space-x-2 px-6 py-4 text-sm">
                            <a href="{{ route('admin.publisher.view', $publisher) }}" class="text-blue-600 hover:underline">View</a>
                            <a href="{{ route('admin.publisher.edit', $publisher) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <button type="button"
                                    wire:click="deletePublisher({{ $publisher->id }})"
                                    wire:confirm="Are you sure you want to delete this publisher? The publisher will be soft-deleted."
                                    class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">No Publishers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $publishers->links() }}
    </div>
</div>