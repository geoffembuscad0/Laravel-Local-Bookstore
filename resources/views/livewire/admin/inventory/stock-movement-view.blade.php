<div class="container mx-auto max-w-4xl px-4 py-8">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Stock Movement Details</h1>
            <p class="text-sm text-gray-600">
                Movement #{{ $stockMovement->id }}
            </p>
        </div>

        <a href="{{ route('admin.inventory.movements') }}"
           class="rounded border px-4 py-2 hover:bg-gray-100">
            Back
        </a>
    </div>

    <div class="space-y-6 rounded-lg bg-white p-6 shadow">

        <div>
            <h2 class="mb-2 text-lg font-semibold">Book Information</h2>
            <p><strong>Title:</strong> {{ $stockMovement->book->title }}</p>
            <p><strong>SKU:</strong> {{ $stockMovement->book->sku ?? '—' }}</p>
            <p><strong>ISBN:</strong> {{ $stockMovement->book->isbn ?? '—' }}</p>
        </div>

        <hr>

        <div>
            <h2 class="mb-2 text-lg font-semibold">Movement Information</h2>

            <p>
                <strong>Type:</strong>
                {{ ucwords(str_replace('_', ' ', $stockMovement->type->value)) }}
            </p>

            <p><strong>Quantity:</strong> {{ $stockMovement->quantity }}</p>
            <p><strong>Quantity Before:</strong> {{ $stockMovement->quantity_before }}</p>
            <p><strong>Quantity After:</strong> {{ $stockMovement->quantity_after }}</p>
            <p><strong>Reference:</strong> {{ $stockMovement->reference ?? '—' }}</p>
            <p><strong>Recorded By:</strong> {{ $stockMovement->user->name }}</p>
            <p><strong>Date:</strong> {{ $stockMovement->created_at->format('M d, Y h:i A') }}</p>
        </div>

        @if ($stockMovement->purchaseOrderItem)
            <hr>

            <div>
                <h2 class="mb-2 text-lg font-semibold">Purchase Order Reference</h2>

                <p>
                    <strong>PO Number:</strong>
                    {{ $stockMovement->purchaseOrderItem->purchaseOrder->po_number }}
                </p>

                <p>
                    <strong>Supplier:</strong>
                    {{ $stockMovement->purchaseOrderItem->purchaseOrder->supplier->name }}
                </p>
            </div>
        @endif

        <hr>

        <div>
            <h2 class="mb-2 text-lg font-semibold">Notes</h2>
            <p class="whitespace-pre-line text-gray-700">
                {{ $stockMovement->notes ?: 'No additional notes.' }}
            </p>
        </div>

    </div>
</div>