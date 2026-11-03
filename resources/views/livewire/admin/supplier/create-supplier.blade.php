<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Register Supplier</h1>
        <p class="mt-1 text-sm text-gray-600">Add a supplier for purchase orders and stock replenishment.</p>
    </div>

    <form wire:submit="save" class="rounded-lg bg-white p-6 shadow">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Supplier name *</label>
                <input id="name" type="text" wire:model="name" maxlength="255" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="code" class="mb-2 block text-sm font-medium text-gray-700">Supplier code *</label>
                <input id="code" type="text" wire:model="code" maxlength="255" required class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('code') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="contact_person" class="mb-2 block text-sm font-medium text-gray-700">Contact person</label>
                <input id="contact_person" type="text" wire:model="contact_person" maxlength="255" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('contact_person') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" wire:model="email" maxlength="255" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">Phone</label>
                <input id="phone" type="text" wire:model="phone" maxlength="255" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="website" class="mb-2 block text-sm font-medium text-gray-700">Website</label>
                <input id="website" type="url" wire:model="website" maxlength="255" placeholder="https://example.com" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('website') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="city" class="mb-2 block text-sm font-medium text-gray-700">City</label>
                <input id="city" type="text" wire:model="city" maxlength="255" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('city') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="postal_code" class="mb-2 block text-sm font-medium text-gray-700">Postal code</label>
                <input id="postal_code" type="text" wire:model="postal_code" maxlength="255" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('postal_code') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="country" class="mb-2 block text-sm font-medium text-gray-700">Country</label>
                <input id="country" type="text" wire:model="country" maxlength="255" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('country') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="payment_terms" class="mb-2 block text-sm font-medium text-gray-700">Payment terms</label>
                <input id="payment_terms" type="text" wire:model="payment_terms" maxlength="255" placeholder="e.g. Net 30" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('payment_terms') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
                <label for="address" class="mb-2 block text-sm font-medium text-gray-700">Address</label>
                <textarea id="address" wire:model="address" rows="3" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('address') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
                <label for="notes" class="mb-2 block text-sm font-medium text-gray-700">Notes</label>
                <textarea id="notes" wire:model="notes" rows="4" class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @error('notes') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-700 md:col-span-2">
                <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                Supplier is active and available for new purchase orders
            </label>
        </div>

        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('admin.suppliers.index') }}" class="rounded bg-gray-500 px-6 py-2 font-bold text-white hover:bg-gray-700">Cancel</a>
            <button type="submit" wire:loading.attr="disabled" class="rounded bg-green-600 px-6 py-2 font-bold text-white hover:bg-green-700 disabled:opacity-50">
                <span wire:loading.remove>Register Supplier</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </form>
</div>
