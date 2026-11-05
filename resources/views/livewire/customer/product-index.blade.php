<div class="min-h-screen bg-gray-50 text-gray-900">
    <header class="border-b bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
            <a href="{{ route('home') }}" class="text-xl font-bold text-orange-700">
                Local Bookstore
            </a>

            <div class="flex items-center gap-5 text-sm">
                <a href="{{ route('home') }}" class="hover:text-orange-700">Shop</a>
                <a href="{{ route('cart.index') }}" class="hover:text-orange-700">
                    Cart ({{ $cartCount }})
                </a>
                <a href="{{ route('orders.index') }}" class="hover:text-orange-700">
                    My orders
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-10">
        <a href="{{ route('home') }}"
           class="text-sm text-orange-700 hover:underline">
            ← Back to catalog
        </a>

        @if (session('success'))
            <div class="mt-5 rounded-lg bg-emerald-50 p-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 grid gap-10 rounded-xl border bg-white p-6 shadow-sm md:grid-cols-[320px_1fr] md:p-10">
            <div class="flex justify-center">
                @if ($book->cover_image)
                    <img
                        src="{{ Storage::disk(config('books.cover_disk'))->url($book->cover_image) }}"
                        alt="{{ $book->title }}"
                        class="max-h-[440px] w-full max-w-[300px] rounded-lg object-contain"
                    >
                @else
                    <div class="flex min-h-[360px] w-full max-w-[300px] items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                        No book cover available
                    </div>
                @endif
            </div>

            <div>
                <div class="mb-3 flex flex-wrap gap-2">
                    @foreach ($book->categories as $category)
                        <a href="{{ route('category.view', $category->slug) }}"
                           class="rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-700">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <h1 class="text-3xl font-bold tracking-tight">
                    {{ $book->title }}
                </h1>

                <p class="mt-2 text-gray-600">
                    by {{ $book->primaryAuthor?->name ?? 'Unknown author' }}
                </p>

                <div class="mt-5">
                    @if ($book->discount_price)
                        <span class="text-3xl font-bold text-orange-700">
                            ₱{{ number_format((float) $book->discount_price, 2) }}
                        </span>
                        <span class="ml-2 text-lg text-gray-400 line-through">
                            ₱{{ number_format((float) $book->price, 2) }}
                        </span>
                    @else
                        <span class="text-3xl font-bold text-orange-700">
                            ₱{{ number_format((float) $book->price, 2) }}
                        </span>
                    @endif
                </div>

                <div class="mt-5">
                    @if ($book->stock > 0)
                        <span class="text-sm font-medium text-emerald-700">
                            In stock — {{ $book->stock }} available
                        </span>
                    @else
                        <span class="text-sm font-medium text-red-600">
                            Currently out of stock
                        </span>
                    @endif
                </div>

                @if ($book->description)
                    <div class="mt-8 border-t pt-6">
                        <h2 class="text-lg font-semibold">About this book</h2>
                        <p class="mt-3 whitespace-pre-line leading-7 text-gray-600">
                            {{ $book->description }}
                        </p>
                    </div>
                @endif

                <div class="mt-8 grid gap-3 border-t pt-6 text-sm sm:grid-cols-2">
                    @if ($book->isbn)
                        <p><span class="font-medium">ISBN:</span> {{ $book->isbn }}</p>
                    @endif

                    @if ($book->publisher)
                        <p><span class="font-medium">Publisher:</span> {{ $book->publisher->name }}</p>
                    @endif

                    @if ($book->pages)
                        <p><span class="font-medium">Pages:</span> {{ $book->pages }}</p>
                    @endif

                    @if ($book->language)
                        <p><span class="font-medium">Language:</span> {{ $book->language }}</p>
                    @endif

                    @if ($book->publication_date)
                        <p>
                            <span class="font-medium">Publication date:</span>
                            {{ $book->publication_date->format('F Y') }}
                        </p>
                    @endif
                </div>

                <div class="mt-8 border-t pt-6">
                    @if ($book->stock > 0)
                        @if (auth()->check() && auth()->user()->hasRole('User'))
                            <form wire:submit="addToCart" class="flex flex-wrap items-end gap-4">
                                <div>
                                    <label for="quantity" class="mb-2 block text-sm font-medium">
                                        Quantity
                                    </label>

                                    <input
                                        id="quantity"
                                        type="number"
                                        min="1"
                                        max="{{ $book->stock }}"
                                        wire:model="quantity"
                                        class="w-24 rounded-lg border-gray-300"
                                    >

                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    class="rounded-lg bg-orange-700 px-6 py-3 font-semibold text-white hover:bg-orange-800 disabled:opacity-60"
                                >
                                    Add to cart
                                </button>
                            </form>
                        @elseif (auth()->guest())
                            <a href="{{ route('login') }}"
                               class="inline-block rounded-lg bg-orange-700 px-6 py-3 font-semibold text-white hover:bg-orange-800">
                                Sign in to add to cart
                            </a>
                        @endif
                    @else
                        <button disabled
                                class="cursor-not-allowed rounded-lg bg-gray-300 px-6 py-3 font-semibold text-gray-600">
                            Out of stock
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>