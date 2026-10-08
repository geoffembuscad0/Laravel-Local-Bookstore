@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="min-h-screen bg-gray-50 text-gray-900">
  @unless(request()->routeIs('dashboard'))
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
          <img src="{{ asset('images/logo.svg') }}" alt="Bookstore" class="w-10 h-10">
          <span class="font-bold text-xl tracking-tight">Local Bookstore</span>
        </a>

        <form class="flex-1 mx-6" wire:submit.prevent>
          <label for="search" class="sr-only">Search books</label>
          <div class="relative">
            <input id="search" type="search" wire:model.debounce.300ms="search"
                   placeholder="Search books, authors, ISBN..."
                   class="w-full border border-gray-200 rounded-full py-2 pl-4 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="button" class="absolute right-1 top-1/2 -translate-y-1/2 bg-indigo-600 text-white rounded-full p-2 hover:bg-indigo-700"
                    aria-label="Search">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18A7.5 7.5 0 1010.5 3a7.5 7.5 0 000 15z"/>
              </svg>
            </button>
          </div>
        </form>

        <div class="flex items-center gap-4">
          <a href="{{ route('cart.index') }}" class="relative inline-flex items-center gap-2 text-sm">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h13"/>
            </svg>
            <span class="hidden sm:inline">Cart</span>
            <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full">
              {{ $cartCount ?? 0 }}
            </span>
          </a>

          @guest
            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:underline">Sign in</a>
          @else
            <div x-data="{ open: false }" class="relative">
              <button type="button" @click="open = !open" class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" aria-label="User menu">
                <i class="fas fa-user text-sm"></i>
              </button>

              <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50 py-1 border border-gray-200" style="display: none;">
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                  <i class="fas fa-user text-gray-500"></i>
                  {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                    <i class="fas fa-sign-out-alt text-gray-500"></i>
                    {{ __('Logout') }}
                  </button>
                </form>
              </div>
            </div>
          @endguest
        </div>
      </div>
    </header>
  @endunless
  <section class="bg-gradient-to-r from-indigo-600 to-indigo-500 text-white">
    <div class="container mx-auto px-4 py-20 flex flex-col lg:flex-row items-center gap-12">
      <div class="lg:w-1/2">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight">
          Discover your next favorite book
        </h1>
        <p class="mt-4 text-indigo-100 max-w-xl">
          Hand-picked titles from local authors and bestsellers. Fast shipping and secure checkout.
        </p>
        <div class="mt-8 flex gap-3">
          <a href="#catalog" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-lg shadow hover:bg-gray-100 font-semibold">
            Browse catalog
          </a>
          <a href="{{ route('collections.new') }}" class="inline-flex items-center px-6 py-3 border border-white/30 text-white rounded-lg hover:bg-white/10">
            New arrivals
          </a>
        </div>
      </div>

      <div class="lg:w-1/2 w-full">
        <!-- Placeholder for hero image -->
        <div class="bg-white/10 rounded-lg p-6 flex items-center justify-center h-64">
          <img src="{{ asset('images/hero-books.png') }}" alt="Books" class="object-contain h-56">
        </div>
      </div>
    </div>
  </section>
  <main class="container mx-auto px-4 py-10">
    <section class="mb-8">
      <h2 class="text-lg font-semibold mb-4">Shop by category</h2>
      <div class="flex gap-4 overflow-x-auto pb-2">
        @foreach($categories ?? [] as $category)
          <a href="{{ route('category.show', $category->slug) }}"
             class="flex-shrink-0 bg-white border border-gray-200 rounded-lg px-4 py-3 hover:shadow transition">
            <div class="text-sm font-medium">{{ $category->name }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $category->books_count ?? '' }} titles</div>
          </a>
        @endforeach

        @if(empty($categories) || count($categories) === 0)
          @foreach(['Fiction','Non-Fiction','Children','Sci-Fi','Romance'] as $name)
            <a class="flex-shrink-0 bg-white border border-gray-200 rounded-lg px-4 py-3">
              <div class="text-sm font-medium">{{ $name }}</div>
            </a>
          @endforeach
        @endif
      </div>
    </section>

    <section id="catalog" class="mb-12">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold">Featured books</h2>
        <div class="text-sm text-gray-500">Showing curated picks</div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products ?? [] as $product)
          <article class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden flex flex-col">
            <a href="{{ route('product.show', $product->slug) }}" class="block aspect-[3/4] bg-gray-100 overflow-hidden">
              <img src="{{ $product->cover_url ?? asset('images/book-placeholder.png') }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
            </a>

            <div class="p-4 flex-1 flex flex-col">
              <h3 class="text-sm font-medium">
                <a href="{{ route('product.show', $product->slug) }}" class="hover:underline">
                  {{ Str::limit($product->title, 60) }}
                </a>
              </h3>
              <p class="text-xs text-gray-500 mt-1 flex-1">{{ Str::limit($product->author ?? 'Unknown author', 60) }}</p>

              <div class="mt-4 flex items-center justify-between">
                <div>
                  <span class="text-lg font-semibold">${{ number_format($product->price, 2) }}</span>
                  @if($product->old_price)
                    <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($product->old_price, 2) }}</span>
                  @endif
                </div>

                <div class="flex items-center gap-2">
                  <button wire:click="addToCart({{ $product->id }})"
                          class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h13"/>
                    </svg>
                    Add
                  </button>
                </div>
              </div>
            </div>
          </article>
        @empty
          @for($i=0;$i<8;$i++)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm h-64 flex items-center justify-center text-gray-400">
              No products yet
            </div>
          @endfor
        @endforelse
      </div>

      <div class="mt-8 flex justify-center">
        {{ $products->links ?? '' }}
      </div>
    </section>
  </main>
</div>
