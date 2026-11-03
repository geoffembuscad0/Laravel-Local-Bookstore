<div class="container mx-auto px-4 py-8">

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Purchase Orders</h1>
            <p class="mt-1 text-sm text-gray-600">
                Manage supplier orders and track incoming book deliveries.
            </p>
        </div>

        <a href="{{ route('admin.purchase-orders.create') }}"
           class="rounded-lg bg-blue-600 px-4 py-2 text-center text-white hover:bg-blue-700">
            Create Purchase Order
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-green-300 bg-green-100 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex flex-col gap-3 md:flex-row">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Search PO number or supplier..."
            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >

        <select
            wire:model.live="statusFilter"
            class="rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            <option value="">All Statuses</option>

            @foreach ($statuses as $status)
                <option value="{{ $status->value }}">
                    {{ ucwords(str_replace('_', ' ', $status->value)) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full">
            <thead class="border-b bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">PO Number</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Supplier</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Order Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Expected Delivery</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Items</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Total</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($purchaseOrders as $purchaseOrder)
                    @php
                        $status = $purchaseOrder->status;
                        $statusClasses = match ($status->value) {
                            'draft' => 'bg-gray-100 text-gray-700',
                            'ordered' => 'bg-blue-100 text-blue-800',
                            'partially_received' => 'bg-yellow-100 text-yellow-800',
                            'received' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <tr wire:key="purchase-order-{{ $purchaseOrder->id }}"
                        class="border-b hover:bg-gray-50">

                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900">
                                {{ $purchaseOrder->po_number }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $purchaseOrder->supplier->name }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $purchaseOrder->order_date->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $purchaseOrder->expected_delivery_date?->format('M d, Y') ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $purchaseOrder->items_count }}
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ number_format((float) $purchaseOrder->total_amount, 2) }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                                {{ ucwords(str_replace('_', ' ', $status->value)) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <a href="{{ route('admin.purchase-orders.view', $purchaseOrder) }}"
                               class="font-medium text-blue-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                            @if (trim($search) !== '' || $statusFilter !== '')
                                No purchase orders match your filters.
                            @else
                                No purchase orders have been created yet.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $purchaseOrders->links() }}
    </div>

</div>