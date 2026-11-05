<div class="min-h-screen bg-gray-50 text-gray-900">

    {{-- Storefront Header --}}
    <header class="border-b bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">

            <a href="{{ route('home') }}"
               class="text-xl font-bold text-indigo-700">
                Local Bookstore
            </a>

            <nav class="flex items-center gap-5 text-sm">
                <a href="{{ route('home') }}" class="hover:text-indigo-700">
                    Home
                </a>

                <a href="{{ route('collections.index') }}"
                   class="font-semibold text-indigo-700">
                    Catalog
                </a>

                @auth
                    <a href="{{ route('orders.index') }}" class="hover:text-indigo-700">
                        My Orders
                    </a>
                @endauth

                <a href="{{ route('cart.index') }}" class="hover:text-indigo-700">
                    Cart ({{ $cartCount }})
                </a>

                @guest
                    <a href="{{ route('login') }}" class="hover:text-indigo-700">
                        Sign In
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:text-indigo-700">
                            Logout
                        </button>
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-10">

        {{-- Page Heading --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight">
                Book Catalog
            </h1>

            <p class="mt-2 text-gray-600">
                Explore our collection and discover your next favorite book.
            </p>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search and Sorting --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row">

            <div class="flex-1">
                <input
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by title, ISBN, or author..."
                    class="w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            <div class="sm:w-56">
                <select
                    wire:model.live="sortBy"
                    class="w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="newest">Newest first</option>
                    <option value="title">Title: A–Z</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                </select>
            </div>

        </div>

        {{-- Results --}}
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-lg font-semibold">
                Available Books
            </h2>

            <span class="text-sm text-gray-500">
                {{ $products->total() }} books found
            </span>
        </div>

        {{-- Book Grid --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

            @forelse ($products as $product)

                <article
                    wire:key="catalog-book-{{ $product->id }}"
                    class="flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm"
                >

                    {{-- Cover --}}
                    <a href="{{ route('product.show', $product->slug) }}"
                       class="block aspect-[3/4] overflow-hidden bg-gray-100">

                        @if ($product->cover_image)
                            <img
                                src="{{ Storage::disk(config('books.cover_disk'))->url($book->cover_image) }}"
                                alt="{{ $product->title }}"
                                class="h-full w-full object-cover transition duration-300 hover:scale-105"
                            >
                        @else
                            <div class="flex h-full items-center justify-center text-sm text-gray-400">
                                No cover available
                            </div>
                        @endif

                    </a>

                    {{-- Book Information --}}
                    <div class="flex flex-1 flex-col p-4">

                        <h3 class="text-sm font-semibold">
                            <a href="{{ route('product.show', $product->slug) }}"
                               class="hover:text-indigo-700">
                                {{ Str::limit($product->title, 60) }}
                            </a>
                        </h3>

                        <p class="mt-1 flex-1 text-xs text-gray-500">
                            {{ $product->primaryAuthor?->name ?? 'Unknown author' }}
                        </p>

                        {{-- Price --}}
                        <div class="mt-4">

                            @if ($product->discount_price)
                                <span class="text-lg font-bold text-indigo-700">
                                    ₱{{ number_format((float) $product->discount_price, 2) }}
                                </span>

                                <span class="ml-1 text-sm text-gray-400 line-through">
                                    ₱{{ number_format((float) $product->price, 2) }}
                                </span>
                            @else
                                <span class="text-lg font-bold text-indigo-700">
                                    ₱{{ number_format((float) $product->price, 2) }}
                                </span>
                            @endif

                        </div>

                        {{-- Stock and Cart Action --}}
                        <div class="mt-4">

                            @if ($product->stock > 0)

                                @if (auth()->check() && auth()->user()->hasRole('User'))

                                    <button
                                        wire:click="addToCart({{ $product->id }})"
                                        wire:loading.attr="disabled"
                                        class="w-full rounded-lg bg-indigo-700 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-800 disabled:opacity-60"
                                    >
                                        Add to Cart
                                    </button>

                                @elseif (auth()->guest())

                                    <a href="{{ route('login') }}"
                                       class="block rounded-lg border border-indigo-700 px-3 py-2 text-center text-sm font-medium text-indigo-700 hover:bg-indigo-50">
                                        Sign In to Purchase
                                    </a>

                                @endif

                            @else

                                <button
                                    disabled
                                    class="w-full cursor-not-allowed rounded-lg bg-gray-200 px-3 py-2 text-sm font-medium text-gray-500"
                                >
                                    Out of Stock
                                </button>

                            @endif

                        </div>
                    </div>
                </article>

            @empty

                <div class="col-span-full rounded-lg border bg-white py-16 text-center">
                    <h3 class="text-lg font-semibold">
                        No books found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Try another search term.
                    </p>

                    <button
                        wire:click="$set('search', '')"
                        class="mt-4 text-sm font-medium text-indigo-700 hover:underline"
                    >
                        Clear Search
                    </button>
                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->links() }}
        </div>

    </main>
</div>