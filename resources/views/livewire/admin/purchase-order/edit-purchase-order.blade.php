<div class="container mx-auto max-w-6xl px-4 py-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Purchase Order</h1>
        <p class="mt-1 text-sm text-gray-600">
            Update the details of draft purchase order
            <span class="font-medium">{{ $purchaseOrder->po_number }}</span>.
        </p>
    </div>

    <div class="mb-5 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-800">
        Only draft purchase orders can be edited. Once an order is placed, its items and quantities can no longer be changed.
    </div>

    <form wire:submit="save" class="space-y-6">

        {{-- Order Information --}}
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-5 text-lg font-semibold text-gray-900">Order Information</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        PO Number
                    </label>

                    <input type="text"
                           value="{{ $purchaseOrder->po_number }}"
                           disabled
                           class="w-full rounded-lg border border-gray-200 bg-gray-100 px-4 py-2 text-gray-600">
                </div>

                <div>
                    <label for="supplier_id" class="mb-1 block text-sm font-medium text-gray-700">
                        Supplier *
                    </label>

                    <select id="supplier_id"
                            wire:model="supplier_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">
                        <option value="">Select a supplier</option>

                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
                                {{ $supplier->name }} ({{ $supplier->code }})
                            </option>
                        @endforeach
                    </select>

                    @error('supplier_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order_date" class="mb-1 block text-sm font-medium text-gray-700">
                        Order Date *
                    </label>

                    <input id="order_date"
                           type="date"
                           wire:model="order_date"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    @error('order_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="expected_delivery_date" class="mb-1 block text-sm font-medium text-gray-700">
                        Expected Delivery Date
                    </label>

                    <input id="expected_delivery_date"
                           type="date"
                           wire:model="expected_delivery_date"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    @error('expected_delivery_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Order Items --}}
        <div class="rounded-lg bg-white p-6 shadow">

            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                    <p class="text-sm text-gray-500">
                        Update the books, quantities, and unit costs.
                    </p>
                </div>

                <button type="button"
                        wire:click="addItem"
                        class="rounded-lg border border-blue-600 px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50">
                    + Add Book
                </button>
            </div>

            @error('items')
                <p class="mb-3 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="space-y-4">
                @foreach ($items as $index => $item)
                    <div wire:key="edit-po-item-{{ $index }}"
                         class="rounded-lg border border-gray-200 p-4">

                        <div class="mb-3 flex items-center justify-between">
                            <h3 class="font-medium text-gray-800">
                                Item {{ $index + 1 }}
                            </h3>

                            @if (count($items) > 1)
                                <button type="button"
                                        wire:click="removeItem({{ $index }})"
                                        class="text-sm text-red-600 hover:underline">
                                    Remove
                                </button>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Book *
                                </label>

                                <select wire:model="items.{{ $index }}.book_id"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2">
                                    <option value="">Select a book</option>

                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">
                                            {{ $book->title }}
                                            @if ($book->sku)
                                                — {{ $book->sku }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                                @error("items.{$index}.book_id")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Quantity *
                                </label>

                                <input type="number"
                                       min="1"
                                       wire:model="items.{{ $index }}.quantity_ordered"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2">

                                @error("items.{$index}.quantity_ordered")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Unit Cost *
                                </label>

                                <input type="number"
                                       min="0"
                                       step="0.01"
                                       wire:model="items.{{ $index }}.unit_cost"
                                       class="w-full rounded-lg border border-gray-300 px-3 py-2">

                                @error("items.{$index}.unit_cost")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Additional Costs --}}
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-5 text-lg font-semibold text-gray-900">Additional Costs</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <div>
                    <label for="shipping_cost" class="mb-1 block text-sm font-medium text-gray-700">
                        Shipping Cost
                    </label>

                    <input id="shipping_cost"
                           type="number"
                           min="0"
                           step="0.01"
                           wire:model="shipping_cost"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    @error('shipping_cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tax_amount" class="mb-1 block text-sm font-medium text-gray-700">
                        Tax Amount
                    </label>

                    <input id="tax_amount"
                           type="number"
                           min="0"
                           step="0.01"
                           wire:model="tax_amount"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2">

                    @error('tax_amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="notes" class="mb-1 block text-sm font-medium text-gray-700">
                        Notes
                    </label>

                    <textarea id="notes"
                              wire:model="notes"
                              rows="4"
                              class="w-full rounded-lg border border-gray-300 px-4 py-2"></textarea>

                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">
            <a href="{{ route('admin.purchase-orders.view', $purchaseOrder) }}"
               class="rounded-lg border border-gray-300 px-5 py-2 text-center text-gray-700 hover:bg-gray-100">
                Cancel
            </a>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50">
                <span wire:loading.remove>Save Changes</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>

    </form>
</div>