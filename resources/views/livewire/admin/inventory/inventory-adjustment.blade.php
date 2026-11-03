<div class="container mx-auto max-w-3xl px-4 py-8">

    <div class="mb-6">
        <h1 class="text-3xl font-bold">Inventory Adjustment</h1>
        <p class="text-sm text-gray-600">
            Record manual increases or decreases in book stock.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-100 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-lg bg-white p-6 shadow">

        <form wire:submit="save" class="space-y-5">

            <div>
                <label class="mb-1 block font-medium">Book</label>

                <select wire:model="bookId"
                        class="w-full rounded border border-gray-300 px-4 py-2">
                    <option value="">Select a book</option>

                    @foreach ($books as $book)
                        <option value="{{ $book->id }}">
                            {{ $book->title }} — Stock: {{ $book->stock }}
                        </option>
                    @endforeach
                </select>

                @error('bookId')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block font-medium">Adjustment Type</label>

                <select wire:model="adjustmentType"
                        class="w-full rounded border border-gray-300 px-4 py-2">
                    <option value="increase">Increase Stock</option>
                    <option value="decrease">Decrease Stock</option>
                </select>

                @error('adjustmentType')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block font-medium">Quantity</label>

                <input type="number"
                       min="1"
                       wire:model="quantity"
                       class="w-full rounded border border-gray-300 px-4 py-2">

                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block font-medium">Reason</label>

                <textarea wire:model="reason"
                          rows="4"
                          class="w-full rounded border border-gray-300 px-4 py-2"
                          placeholder="Explain why this adjustment is necessary..."></textarea>

                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.inventory.index') }}"
                   class="rounded border px-4 py-2 hover:bg-gray-100">
                    Cancel
                </a>

                <button type="submit"
                        wire:loading.attr="disabled"
                        class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    <span wire:loading.remove>Save Adjustment</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>

        </form>
    </div>
</div>