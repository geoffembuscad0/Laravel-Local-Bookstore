<!-- Top navigation -->
<header class="bg-white shadow-sm hidden lg:block">
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
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 hover:underline">Dashboard</a>
      @endguest
    </div>
  </div>
</header>

<!-- Sidebar Navigation for smaller devices (below 1024px) -->
<div class="lg:hidden" x-data="{ sidebarOpen: false }">
  <!-- Mobile Header with Menu Toggle -->
  <header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="flex items-center justify-between px-4 py-4">
      <a href="{{ route('home') }}" class="flex items-center gap-2">
        <img src="{{ asset('images/logo.svg') }}" alt="Bookstore" class="w-8 h-8">
        <span class="font-bold text-lg tracking-tight">Local Bookstore</span>
      </a>

      <!-- Hamburger Menu Button -->
      <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-gray-900">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </header>

  <!-- Sidebar Panel -->
  <div x-show="sidebarOpen" x-transition class="fixed inset-0 z-30">
    <!-- Backdrop -->
    <div @click="sidebarOpen = false" class="absolute inset-0 bg-black/50"></div>

    <!-- Sidebar Content -->
    <div class="absolute left-0 top-0 h-full w-64 bg-white shadow-lg flex flex-col">
      <!-- Close Button -->
      <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200">
        <span class="font-semibold">Menu</span>
        <button @click="sidebarOpen = false" class="text-gray-600 hover:text-gray-900">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <!-- Search -->
      <div class="px-4 py-4 border-b border-gray-200">
        <form wire:submit.prevent>
          <label for="mobile-search" class="sr-only">Search books</label>
          <input id="mobile-search" type="search" wire:model.debounce.300ms="search"
                 placeholder="Search books..." 
                 class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </form>
      </div>

      <!-- Menu Items -->
      <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-2">
        <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600">
          <span class="text-sm font-medium">Home</span>
        </a>
        <a href="{{ route('categories') }}" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600">
          <span class="text-sm font-medium">Categories</span>
        </a>
        <a href="{{ route('collections.new') }}" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600">
          <span class="text-sm font-medium">New Arrivals</span>
        </a>
        <a href="{{ route('collections.bestsellers') }}" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600">
          <span class="text-sm font-medium">Bestsellers</span>
        </a>
      </nav>

      <!-- Cart & Account Section -->
      <div class="border-t border-gray-200 px-2 py-4 space-y-2">
        <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 6h13"/>
          </svg>
          <span class="text-sm font-medium">Cart</span>
          <span class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full">
            {{ $cartCount ?? 0 }}
          </span>
        </a>

        @guest
          <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            <span class="text-sm font-medium">Sign in</span>
          </a>
        @else
          <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
          </a>
        @endguest
      </div>
    </div>
  </div>
</div>