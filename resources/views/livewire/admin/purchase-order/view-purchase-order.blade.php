<div class="container mx-auto px-4 py-8">

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

        $canReceive = in_array($status->value, ['ordered', 'partially_received'], true);
        $canCancel = in_array($status->value, ['draft', 'ordered'], true);
    @endphp

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <div class="mb-2 flex flex-wrap items-center gap-3">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $purchaseOrder->po_number }}
                </h1>

                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                    {{ ucwords(str_replace('_', ' ', $status->value)) }}
                </span>
            </div>

            <p class="text-sm text-gray-600">
                Purchase order details and supplier delivery records.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.purchase-orders.index') }}"
               class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Back to Purchase Orders
            </a>

            @if ($status->value === 'draft')
                <a href="{{ route('admin.purchase-orders.edit', $purchaseOrder) }}"
                   class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700">
                    Edit Draft
                </a>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-lg border border-green-300 bg-green-100 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Order Information --}}
    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

        <div class="rounded-lg bg-white p-6 shadow lg:col-span-2">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Order Information</h2>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <p class="text-sm text-gray-500">Supplier</p>
                    <p class="mt-1 font-medium text-gray-900">
                        {{ $purchaseOrder->supplier->name }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $purchaseOrder->supplier->code }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Created By</p>
                    <p class="mt-1 font-medium text-gray-900">
                        {{ $purchaseOrder->creator->name }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Order Date</p>
                    <p class="mt-1 font-medium text-gray-900">
                        {{ $purchaseOrder->order_date->format('M d, Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Expected Delivery</p>
                    <p class="mt-1 font-medium text-gray-900">
                        {{ $purchaseOrder->expected_delivery_date?->format('M d, Y') ?? 'Not specified' }}
                    </p>
                </div>

            </div>

            @if ($purchaseOrder->notes)
                <div class="mt-5 border-t border-gray-100 pt-4">
                    <p class="text-sm text-gray-500">Notes</p>
                    <p class="mt-1 whitespace-pre-line text-sm text-gray-700">
                        {{ $purchaseOrder->notes }}
                    </p>
                </div>
            @endif
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Order Summary</h2>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">
                        {{ number_format((float) $purchaseOrder->subtotal, 2) }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-medium">
                        {{ number_format((float) $purchaseOrder->shipping_cost, 2) }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-medium">
                        {{ number_format((float) $purchaseOrder->tax_amount, 2) }}
                    </span>
                </div>

                <div class="border-t border-gray-200 pt-3">
                    <div class="flex justify-between text-base">
                        <span class="font-semibold text-gray-900">Total</span>
                        <span class="font-bold text-gray-900">
                            {{ number_format((float) $purchaseOrder->total_amount, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            @if ($status->value === 'draft')
                <button type="button"
                        wire:click="placeOrder"
                        wire:confirm="Are you sure you want to place this purchase order?"
                        wire:loading.attr="disabled"
                        class="mt-6 w-full rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50">
                    Place Purchase Order
                </button>
            @endif

            @if ($canCancel)
                <button type="button"
                        wire:click="cancelOrder"
                        wire:confirm="Are you sure you want to cancel this purchase order?"
                        wire:loading.attr="disabled"
                        class="mt-3 w-full rounded-lg border border-red-300 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 disabled:opacity-50">
                    Cancel Purchase Order
                </button>
            @endif

            @if ($status->value === 'draft')
                <p class="mt-3 text-xs text-gray-500">
                    Placing this order will not increase inventory. Stock changes only when items are received.
                </p>
            @endif
        </div>
    </div>

    {{-- Ordered Items --}}
    <div class="mb-6 rounded-lg bg-white p-6 shadow">

        <div class="mb-5">
            <h2 class="text-lg font-semibold text-gray-900">Ordered Books</h2>
            <p class="text-sm text-gray-500">
                Review ordered, received, and remaining quantities.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Book</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Unit Cost</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Ordered</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Received</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Remaining</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Line Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($purchaseOrder->items as $item)
                        <tr wire:key="po-item-{{ $item->id }}" class="border-b">
                            <td class="px-4 py-4">
                                <p class="font-medium text-gray-900">
                                    {{ $item->book->title }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $item->book->sku ?? 'No SKU' }}
                                </p>
                            </td>

                            <td class="px-4 py-4 text-right text-sm text-gray-700">
                                {{ number_format((float) $item->unit_cost, 2) }}
                            </td>

                            <td class="px-4 py-4 text-right text-sm text-gray-700">
                                {{ $item->quantity_ordered }}
                            </td>

                            <td class="px-4 py-4 text-right text-sm font-medium text-green-700">
                                {{ $item->quantity_received }}
                            </td>

                            <td class="px-4 py-4 text-right text-sm font-medium {{ $item->remaining_quantity > 0 ? 'text-amber-700' : 'text-green-700' }}">
                                {{ $item->remaining_quantity }}
                            </td>

                            <td class="px-4 py-4 text-right text-sm font-medium text-gray-900">
                                {{ number_format((float) $item->line_total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Receive Items --}}
    @if ($canReceive)
        <div class="mb-6 rounded-lg bg-white p-6 shadow">

            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-900">Receive Stock</h2>
                <p class="text-sm text-gray-500">
                    Record the quantities delivered by the supplier. You can receive the remaining quantities in multiple batches.
                </p>
            </div>

            <div class="space-y-5">
                @foreach ($purchaseOrder->items as $item)
                    <div wire:key="receive-item-{{ $item->id }}"
                         class="rounded-lg border border-gray-200 p-4">

                        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">
                                    {{ $item->book->title }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Ordered: {{ $item->quantity_ordered }}
                                    · Received: {{ $item->quantity_received }}
                                    · Remaining: {{ $item->remaining_quantity }}
                                </p>
                            </div>

                            @if ($item->remaining_quantity <= 0)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                                    Fully Received
                                </span>
                            @endif
                        </div>

                        @if ($item->remaining_quantity > 0)
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Quantity Received
                                    </label>

                                    <input type="number"
                                           min="1"
                                           max="{{ $item->remaining_quantity }}"
                                           wire:model="receivingQuantities.{{ $item->id }}"
                                           class="w-full rounded-lg border border-gray-300 px-3 py-2">

                                    @error("receivingQuantities.{$item->id}")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-1 block text-sm font-medium text-gray-700">
                                        Receiving Notes
                                    </label>

                                    <input type="text"
                                           wire:model="receivingNotes.{{ $item->id }}"
                                           placeholder="Optional delivery notes..."
                                           class="w-full rounded-lg border border-gray-300 px-3 py-2">

                                    @error("receivingNotes.{$item->id}")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <div class="mt-4 flex justify-end">
                                <button type="button"
                                        wire:click="receiveItem({{ $item->id }})"
                                        wire:loading.attr="disabled"
                                        class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 disabled:opacity-50">
                                    <span wire:loading.remove wire:target="receiveItem({{ $item->id }})">
                                        Record Received Stock
                                    </span>
                                    <span wire:loading wire:target="receiveItem({{ $item->id }})">
                                        Recording...
                                    </span>
                                </button>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Receiving History --}}
    <div class="rounded-lg bg-white p-6 shadow">

        <div class="mb-5">
            <h2 class="text-lg font-semibold text-gray-900">Receiving History</h2>
            <p class="text-sm text-gray-500">
                Stock movements recorded against this purchase order.
            </p>
        </div>

        @php
            $receivingMovements = $purchaseOrder->items
                ->flatMap(fn ($item) => $item->stockMovements)
                ->sortByDesc('created_at');
        @endphp

        @if ($receivingMovements->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Book</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold">Quantity</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Recorded By</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Notes</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($receivingMovements as $movement)
                            <tr wire:key="receiving-movement-{{ $movement->id }}"
                                class="border-b">

                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $movement->created_at->format('M d, Y h:i A') }}
                                </td>

                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $movement->book->title }}
                                </td>

                                <td class="px-4 py-3 text-right text-sm font-semibold text-green-700">
                                    +{{ $movement->quantity }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $movement->user->name }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $movement->notes ?: '—' }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-lg border border-dashed border-gray-300 p-8 text-center text-sm text-gray-500">
                No stock has been received for this purchase order yet.
            </div>
        @endif

    </div>

</div>