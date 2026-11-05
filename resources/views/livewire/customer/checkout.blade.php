<div class="min-h-screen bg-slate-50 text-slate-800">
    <header class="border-b bg-white">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <a href="{{ route('home') }}" class="text-xl font-bold text-orange-700">Local Bookstore</a>
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="hover:text-orange-700">Shop</a>
                <a href="{{ route('cart.index') }}" class="hover:text-orange-700">Cart ({{ $cartCount }})</a>
                <a href="{{ route('orders.index') }}" class="font-medium text-orange-700">My orders</a>
            </div>
        </nav>
    </header>
    <main class="mx-auto max-w-6xl px-4 py-8">
        <div class="mb-6"><a href="{{ route('cart.index') }}" class="text-sm text-orange-700">← Back to cart</a><h1 class="mt-3 text-3xl font-bold">Delivery details</h1><p class="mt-1 text-slate-600">We currently deliver within Metro Manila only. Payment is cash on delivery.</p></div>
        @if ($errors->has('cart')) <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-700">{{ $errors->first('cart') }}</div> @endif
        <form wire:submit="placeOrder" class="grid gap-8 lg:grid-cols-[1fr_360px]">
            <section class="space-y-5 rounded-xl border bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold">Recipient and delivery address</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="text-sm font-medium">Recipient name<input wire:model="customer_name" autocomplete="name" class="mt-1 w-full rounded-lg border px-3 py-2" />@error('customer_name')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm font-medium">Philippine mobile number<input wire:model="customer_phone" type="tel" autocomplete="tel" placeholder="09XXXXXXXXX or +639XXXXXXXXX" class="mt-1 w-full rounded-lg border px-3 py-2" />@error('customer_phone')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm font-medium sm:col-span-2">House/building number, street, and subdivision<input wire:model="shipping_address" autocomplete="street-address" placeholder="e.g. 12 Sample Street, Barangay Sample" class="mt-1 w-full rounded-lg border px-3 py-2" />@error('shipping_address')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm font-medium">Barangay<input wire:model="shipping_barangay" class="mt-1 w-full rounded-lg border px-3 py-2" />@error('shipping_barangay')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm font-medium">Metro Manila city / municipality<select wire:model="shipping_city" class="mt-1 w-full rounded-lg border px-3 py-2"><option value="">Choose your city</option>@foreach ($metroManilaCities as $city)<option value="{{ $city }}">{{ $city }}</option>@endforeach</select>@error('shipping_city')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm font-medium">4-digit postal code<input wire:model="shipping_postal_code" inputmode="numeric" maxlength="4" placeholder="e.g. 1000" class="mt-1 w-full rounded-lg border px-3 py-2" />@error('shipping_postal_code')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm font-medium">Landmark (optional)<input wire:model="delivery_landmark" placeholder="Nearby store, gate, or landmark" class="mt-1 w-full rounded-lg border px-3 py-2" />@error('delivery_landmark')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                    <label class="text-sm font-medium sm:col-span-2">Delivery instructions (optional)<textarea wire:model="customer_notes" rows="3" placeholder="Helpful directions or preferred delivery time" class="mt-1 w-full rounded-lg border px-3 py-2"></textarea>@error('customer_notes')<span class="text-xs text-red-600">{{ $message }}</span>@enderror</label>
                </div>
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900"><strong>Cash on Delivery</strong><p class="mt-1">Pay the order total in cash when your books arrive. No online payment is collected at checkout.</p></div>
            </section>
            <aside class="h-fit rounded-xl border bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold">Order summary</h2>
                <ul class="my-4 space-y-3 text-sm">@foreach ($cart->items as $item)<li class="flex justify-between gap-3"><span>{{ $item->book?->title }} × {{ $item->quantity }}</span><span>₱{{ number_format((float) ($item->book?->discount_price ?? $item->book?->price ?? 0) * $item->quantity, 2) }}</span></li>@endforeach</ul>
                <div class="space-y-2 border-t pt-4 text-sm"><div class="flex justify-between"><span>Subtotal</span><span>₱{{ number_format($subtotal, 2) }}</span></div><div class="flex justify-between"><span>Local delivery</span><span>Free</span></div><div class="flex justify-between border-t pt-3 text-base font-bold"><span>Total due on delivery</span><span>₱{{ number_format($subtotal, 2) }}</span></div></div>
                <button type="submit" wire:loading.attr="disabled" class="mt-6 w-full rounded-lg bg-orange-700 px-4 py-3 font-semibold text-white hover:bg-orange-800 disabled:opacity-60">Place COD order</button>
            </aside>
        </form>
    </main>
</div>
