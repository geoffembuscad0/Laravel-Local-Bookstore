<div class="min-h-screen bg-gray-50 text-gray-900">
    <header class="border-b bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
            <a href="{{ route('home') }}" class="text-xl font-bold text-orange-700">
                Local Bookstore
            </a>

            <div class="flex items-center gap-5 text-sm">
                <a href="{{ route('home') }}" class="hover:text-orange-700">Continue shopping</a>
                <a href="{{ route('cart.index') }}" class="font-semibold text-orange-700">
                    Cart ({{ $cartCount }})
                </a>
                <a href="{{ route('orders.index') }}" class="hover:text-orange-700">
                    My orders
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Shopping Cart</h1>
            <p class="mt-2 text-gray-600">
                Review your books before proceeding to checkout.
            </p>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-lg bg-emerald-50 p-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('cart'))
            <div class="mb-5 rounded-lg bg-red-50 p-4 text-red-700">
                {{ $errors->first('cart') }}
            </div>
        @endif

        @if ($cart->items->isEmpty())
            <div class="rounded-xl border bg-white px-6 py-16 text-center shadow-sm">
                <h2 class="text-xl font-semibold">Your cart is empty</h2>
                <p class="mt-2 text-gray-500">
                    You haven't added any books to your cart yet.
                </p>

                <a href="{{ route('home') }}"
                   class="mt-6 inline-block rounded-lg bg-orange-700 px-6 py-3 font-semibold text-white hover:bg-orange-800">
                    Browse books
                </a>
            </div>
        @else
            <div class="grid gap-8 lg:grid-cols-[1fr_340px]">
                <section class="space-y-4">
                    @foreach ($cart->items as $item)
                        @php
                            $book = $item->book;
                            $isAvailable = $book
                                && $book->product?->is_active
                                && $book->stock >= $item->quantity;
                            $unitPrice = (float) ($book?->discount_price ?? $book?->price ?? 0);
                        @endphp

                        <article wire:key="cart-item-{{ $item->id }}"
                                 class="flex flex-col gap-5 rounded-xl border bg-white p-5 shadow-sm sm:flex-row">

                            <div class="flex h-36 w-28 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-gray-100">
                                @if ($book?->cover_image)
                                    <img
                                        src="{{ Storage::disk(config('books.cover_disk'))->url($book->cover_image) }}"
                                        alt="{{ $book->title }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <span class="px-2 text-center text-xs text-gray-400">
                                        No cover
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-1 flex-col justify-between gap-4">
                                <div>
                                    <h2 class="font-semibold">
                                        {{ $book?->title ?? 'Book no longer available' }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $book?->primaryAuthor?->name ?? 'Unknown author' }}
                                    </p>

                                    @if ($isAvailable)
                                        <p class="mt-2 text-sm text-emerald-700">
                                            In stock
                                        </p>
                                    @else
                                        <p class="mt-2 text-sm font-medium text-red-600">
                                            This book is unavailable or has insufficient stock.
                                            Please remove it from your cart.
                                        </p>
                                    @endif
                                </div>

                                <div class="flex flex-wrap items-end justify-between gap-4">
                                    <div>
                                        <p class="text-lg font-bold text-orange-700">
                                            ₱{{ number_format($unitPrice, 2) }}
                                        </p>

                                        <div class="mt-2">
                                            <label for="quantity-{{ $item->id }}"
                                                   class="text-xs font-medium text-gray-500">
                                                Quantity
                                            </label>

                                            <div class="mt-1 flex items-center gap-2">
                                                <button
                                                    type="button"
                                                    wire:click="updateQuantity({{ $item->id }}, {{ max(0, $item->quantity - 1) }})"
                                                    class="rounded border px-3 py-1 hover:bg-gray-100"
                                                    aria-label="Decrease quantity"
                                                >
                                                    −
                                                </button>

                                                <span id="quantity-{{ $item->id }}"
                                                      class="min-w-8 text-center">
                                                    {{ $item->quantity }}
                                                </span>

                                                <button
                                                    type="button"
                                                    wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                    @disabled(! $isAvailable || $item->quantity >= $book->stock)
                                                    class="rounded border px-3 py-1 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-40"
                                                    aria-label="Increase quantity"
                                                >
                                                    +
                                                </button>
                                            </div>

                                            @error('quantity.' . $item->id)
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Item total</p>
                                        <p class="font-semibold">
                                            ₱{{ number_format($unitPrice * $item->quantity, 2) }}
                                        </p>

                                        <button
                                            type="button"
                                            wire:click="remove({{ $item->id }})"
                                            wire:confirm="Remove this book from your cart?"
                                            class="mt-2 text-sm text-red-600 hover:underline"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </section>

                <aside class="h-fit rounded-xl border bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold">Order Summary</h2>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Items</span>
                            <span>{{ $cartCount }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">
                                ₱{{ number_format($subtotal, 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Delivery</span>
                            <span>Free</span>
                        </div>

                        <div class="flex justify-between border-t pt-4 text-base font-bold">
                            <span>Total</span>
                            <span>₱{{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>

                    @if ($hasUnavailableItems)
                        <div class="mt-5 rounded-lg bg-amber-50 p-3 text-sm text-amber-800">
                            Remove unavailable books or adjust their quantities before checkout.
                        </div>
                    @else
                        <a href="{{ route('checkout') }}"
                           class="mt-6 block rounded-lg bg-orange-700 px-4 py-3 text-center font-semibold text-white hover:bg-orange-800">
                            Proceed to checkout
                        </a>
                    @endif

                    <p class="mt-4 text-center text-xs text-gray-500">
                        Payment method: Cash on Delivery
                    </p>

                    <a href="{{ route('home') }}"
                       class="mt-4 block text-center text-sm text-orange-700 hover:underline">
                        Continue shopping
                    </a>
                </aside>
            </div>
        @endif
    </main>
</div>