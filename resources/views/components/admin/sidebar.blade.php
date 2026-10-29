@php
    $catalogMenuActive = request()->routeIs(
        'admin.books.*',
        'admin.authors.*',
        'admin.category.*',
        'admin.publisher.*'
    );
@endphp
<aside class="w-64 bg-slate-900 text-white shadow-lg hidden md:fixed md:left-0 md:top-0 md:h-screen md:overflow-y-auto md:flex md:flex-col">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-slate-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center font-bold text-lg">
                        B
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Bookstore</h1>
                        <p class="text-xs text-slate-400">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition-colors {{ request()->routeIs('admin.dashboard')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    @if(request()->routeIs('admin.dashboard'))
                        aria-current="page"
                    @endif
                >
                    {{-- Keep your existing SVG icon here --}}
                    <span>Dashboard</span>
                </a>

                <!-- Books Management -->
                <div class="space-y-1">
                    <button type="button"
                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition-colors focus:outline-none {{ $catalogMenuActive
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        onclick="toggleSubmenu('books-menu')"
                        aria-expanded="{{ $catalogMenuActive ? 'true' : 'false' }}"
                        aria-controls="books-menu">
                        {{-- Keep your existing SVG icon here --}}
                        <span>Books</span>
                        <svg class="w-4 h-4 ml-auto transition-transform {{ $catalogMenuActive ? 'rotate-180' : '' }}" id="books-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" ></path>
                        </svg>
                    </button>
                    <div id="books-menu" class="hidden space-y-1 pl-2">
                        <a href="{{ route('admin.books.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm transition-colors
                                {{ request()->routeIs('admin.books.index')
                                    ? 'bg-blue-600 text-white font-medium'
                                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            @if(request()->routeIs('admin.books.index'))
                                aria-current="page"
                            @endif
                        >
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>All Books</span>
                        </a>
                        <a href="{{ route('admin.books.create') }}"
                            class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm transition-colors
                                {{ request()->routeIs('admin.books.create')
                                    ? 'bg-blue-600 text-white font-medium'
                                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            @if(request()->routeIs('admin.books.create'))
                                aria-current="page"
                            @endif
                        >
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>Add Book</span>
                        </a>
                        <a href="{{ route('admin.authors.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm transition-colors
                                {{ request()->routeIs('admin.authors.index')
                                    ? 'bg-blue-600 text-white font-medium'
                                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            @if(request()->routeIs('admin.books.create'))
                                aria-current="page"
                            @endif
                        >
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>Authors</span>
                        </a>
                        <a href="{{ route('admin.publisher.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm transition-colors
                                {{ request()->routeIs('admin.publisher.index')
                                    ? 'bg-blue-600 text-white font-medium'
                                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            @if(request()->routeIs('admin.publisher.create'))
                                aria-current="page"
                            @endif
                        >
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>Publishers</span>
                        </a>
                        <a href="{{ route('admin.category.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm transition-colors
                                {{ request()->routeIs('admin.category.index')
                                    ? 'bg-blue-600 text-white font-medium'
                                    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            @if(request()->routeIs('admin.category.create'))
                                aria-current="page"
                            @endif
                        >
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>Categories</span>
                        </a>
                    </div>
                </div>

                <!-- Orders Management -->
                <div class="space-y-1">
                    <button class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 font-medium transition-colors hover:bg-slate-800 hover:text-white focus:outline-none" onclick="toggleSubmenu('orders-menu')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Orders</span>
                        <svg class="w-4 h-4 ml-auto transition-transform" id="orders-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>
                    <div id="orders-menu" class="hidden space-y-1 pl-2">
                        <a href="#" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-slate-400 text-sm transition-colors hover:bg-slate-800 hover:text-white">
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>All Orders</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-slate-400 text-sm transition-colors hover:bg-slate-800 hover:text-white">
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>Pending</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-slate-400 text-sm transition-colors hover:bg-slate-800 hover:text-white">
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>Completed</span>
                        </a>
                    </div>
                </div>

                <!-- Users Management -->
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 font-medium transition-colors hover:bg-slate-800 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M12 4.354l-3-3 3 3m0 0l3 3-3-3m12 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Users</span>
                </a>

                <!-- Reports -->
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 font-medium transition-colors hover:bg-slate-800 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Reports</span>
                </a>

                <!-- Settings -->
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 font-medium transition-colors hover:bg-slate-800 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-700 space-y-3">
                <div class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-slate-800">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        A
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" href="#" class="w-full flex items-center justify-center space-x-2 px-4 py-2 rounded-lg text-slate-300 text-sm transition-colors hover:bg-slate-800 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>