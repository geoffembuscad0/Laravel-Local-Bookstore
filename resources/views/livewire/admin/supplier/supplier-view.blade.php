<div class="container mx-auto px-4 py-8">
    @if (session('success'))
        <div class="mb-4 rounded border border-green-400 bg-green-100 p-4 text-green-700" role="status">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $supplier->name }}</h1>
            <p class="mt-1 text-sm text-gray-600">Supplier profile and purchase-order history</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="rounded bg-yellow-500 px-4 py-2 font-bold text-white hover:bg-yellow-600">Edit Supplier</a>
            <a href="{{ route('admin.suppliers.index') }}" class="rounded bg-gray-500 px-4 py-2 font-bold text-white hover:bg-gray-700">Back to Suppliers</a>
        </div>
    </div>

    <section class="rounded-lg bg-white p-6 shadow">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Supplier details</h2>
            @if ($supplier->is_active)
                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Active</span>
            @else
                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">Inactive</span>
            @endif
        </div>
        <dl class="grid grid-cols-1 gap-5 text-sm md:grid-cols-2 lg:grid-cols-3">
            <div><dt class="font-semibold text-gray-700">Supplier code</dt><dd class="mt-1 text-gray-600">{{ $supplier->code }}</dd></div>
            <div><dt class="font-semibold text-gray-700">Contact person</dt><dd class="mt-1 text-gray-600">{{ $supplier->contact_person ?: '—' }}</dd></div>
            <div>
                <dt class="font-semibold text-gray-700">Email</dt>
                <dd class="mt-1 text-gray-600">@if ($supplier->email)<a href="mailto:{{ $supplier->email }}" class="text-blue-600 hover:underline">{{ $supplier->email }}</a>@else—@endif</dd>
            </div>
            <div><dt class="font-semibold text-gray-700">Phone</dt><dd class="mt-1 text-gray-600">{{ $supplier->phone ?: '—' }}</dd></div>
            <div>
                <dt class="font-semibold text-gray-700">Website</dt>
                <dd class="mt-1 break-all text-gray-600">@if ($supplier->website)<a href="{{ $supplier->website }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">{{ $supplier->website }}</a>@else—@endif</dd>
            </div>
            <div><dt class="font-semibold text-gray-700">Payment terms</dt><dd class="mt-1 text-gray-600">{{ $supplier->payment_terms ?: '—' }}</dd></div>
            <div><dt class="font-semibold text-gray-700">Address</dt><dd class="mt-1 whitespace-pre-wrap text-gray-600">{{ $supplier->address ?: '—' }}</dd></div>
            <div><dt class="font-semibold text-gray-700">City</dt><dd class="mt-1 text-gray-600">{{ $supplier->city ?: '—' }}</dd></div>
            <div><dt class="font-semibold text-gray-700">Postal code</dt><dd class="mt-1 text-gray-600">{{ $supplier->postal_code ?: '—' }}</dd></div>
            <div><dt class="font-semibold text-gray-700">Country</dt><dd class="mt-1 text-gray-600">{{ $supplier->country ?: '—' }}</dd></div>
            <div><dt class="font-semibold text-gray-700">Registered</dt><dd class="mt-1 text-gray-600">{{ $supplier->created_at?->format('M d, Y H:i') ?? '—' }}</dd></div>
            <div><dt class="font-semibold text-gray-700">Last updated</dt><dd class="mt-1 text-gray-600">{{ $supplier->updated_at?->format('M d, Y H:i') ?? '—' }}</dd></div>
        </dl>
        @if ($supplier->notes)
            <div class="mt-6 border-t pt-4">
                <h3 class="font-semibold text-gray-700">Notes</h3>
                <p class="mt-2 whitespace-pre-wrap text-sm text-gray-600">{{ $supplier->notes }}</p>
            </div>
        @endif
    </section>

    <section class="mt-8 rounded-lg bg-white p-6 shadow">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900">Purchase orders</h2>
            <p class="mt-1 text-sm text-gray-600">Recent purchasing activity associated with this supplier.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b bg-gray-100">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">PO number</th>
                        <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                        <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Order date</th>
                        <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Expected delivery</th>
                        <th scope="col" class="px-4 py-3 text-right text-sm font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchaseOrders as $purchaseOrder)
                        <tr wire:key="supplier-purchase-order-{{ $purchaseOrder->id }}" class="border-b">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $purchaseOrder->po_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ str($purchaseOrder->getRawOriginal('status'))->replace('_', ' ')->title() }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $purchaseOrder->order_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $purchaseOrder->expected_delivery_date?->format('M d, Y') ?? '—' }}</td>
                            <td class="px-4 py-3 text-right text-sm text-gray-600">{{ number_format((float) $purchaseOrder->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No purchase orders have been placed with this supplier.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5">{{ $purchaseOrders->links() }}</div>
    </section>
</div>
