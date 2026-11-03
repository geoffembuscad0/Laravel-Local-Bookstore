<div class="container mx-auto px-4 py-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold">Stock Movement History</h1>
        <p class="text-sm text-gray-600">
            Review all recorded inventory changes.
        </p>
    </div>

    <div class="mb-4 flex flex-col gap-3 md:flex-row">

        <input type="search"
               wire:model.live.debounce.300ms="search"
               placeholder="Search book or reference..."
               class="w-full rounded border border-gray-300 px-4 py-2">

        <select wire:model.live="typeFilter"
                class="rounded border border-gray-300 px-4 py-2">
            <option value="">All Movement Types</option>

            @foreach ($movementTypes as $type)
                <option value="{{ $type->value }}">
                    {{ ucwords(str_replace('_', ' ', $type->value)) }}
                </option>
            @endforeach
        </select>

        <a href="{{ route('admin.inventory.index') }}"
           class="rounded border px-4 py-2 text-center hover:bg-gray-100">
            Back to Inventory
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full">
            <thead class="border-b bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Book</th>
                    <th class="px-6 py-3 text-left">Movement</th>
                    <th class="px-6 py-3 text-left">Quantity</th>
                    <th class="px-6 py-3 text-left">Before</th>
                    <th class="px-6 py-3 text-left">After</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($movements as $movement)
                    <tr wire:key="movement-{{ $movement->id }}"
                        class="border-b hover:bg-gray-50">

                        <td class="px-6 py-4 text-sm">
                            {{ $movement->created_at->format('M d, Y h:i A') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $movement->book->title }}
                        </td>

                        <td class="px-6 py-4 text-sm">
                            {{ ucwords(str_replace('_', ' ', $movement->type->value)) }}
                        </td>

                        <td class="px-6 py-4 font-semibold">
                            {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $movement->quantity_before }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $movement->quantity_after }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $movement->user->name }}
                        </td>

                        <td class="px-6 py-4">
                            <a href="{{ route('admin.inventory.movements.view', $movement) }}"
                               class="text-blue-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            No stock movements found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $movements->links() }}
    </div>
</div>