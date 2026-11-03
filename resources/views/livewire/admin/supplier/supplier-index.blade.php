<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Suppliers</h1>
        <p class="mt-1 text-sm text-gray-600">Find supplier contacts for purchasing and inventory operations.</p>
    </div>

    <div class="mb-4">
        <label for="supplier-search" class="sr-only">Search suppliers</label>
        <input id="supplier-search"
               type="search"
               wire:model.live.debounce.300ms="search"
               placeholder="Search name, code, contact, email, phone, city, or country..."
               class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full">
            <thead class="border-b bg-gray-100">
                <tr>
                    <th scope="col" class="cursor-pointer px-6 py-3 text-left text-sm font-semibold" wire:click="sortBy('name')">
                        Supplier
                        @if ($sortBy === 'name')
                            <span aria-hidden="true">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th scope="col" class="cursor-pointer px-6 py-3 text-left text-sm font-semibold" wire:click="sortBy('code')">
                        Code
                        @if ($sortBy === 'code')
                            <span aria-hidden="true">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold">Contact</th>
                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold">Email / phone</th>
                    <th scope="col" class="cursor-pointer px-6 py-3 text-left text-sm font-semibold" wire:click="sortBy('country')">
                        Location
                        @if ($sortBy === 'country')
                            <span aria-hidden="true">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                    <th scope="col" class="cursor-pointer px-6 py-3 text-left text-sm font-semibold" wire:click="sortBy('is_active')">
                        Status
                        @if ($sortBy === 'is_active')
                            <span aria-hidden="true">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr wire:key="supplier-{{ $supplier->id }}" class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $supplier->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $supplier->code }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $supplier->contact_person ?: '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div>{{ $supplier->email ?: '—' }}</div>
                            <div>{{ $supplier->phone ?: '—' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ collect([$supplier->city, $supplier->country])->filter()->implode(', ') ?: '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($supplier->is_active)
                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-800">Active</span>
                            @else
                                <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            {{ trim($search) !== '' ? 'No suppliers match your search.' : 'No suppliers have been registered yet.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $suppliers->links() }}
    </div>
</div>
