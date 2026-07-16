<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }} - Online Bookstore</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-slate-900 text-white shadow-lg hidden md:fixed md:left-0 md:top-0 md:h-screen md:overflow-y-auto md:flex md:flex-col">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-slate-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center font-bold text-lg">
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
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-blue-600 text-white font-medium transition-colors hover:bg-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-2m-9-2l4 2m9-11l-7-4-7 4"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Books Management -->
                <div class="space-y-1">
                    <button class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 font-medium transition-colors hover:bg-slate-800 hover:text-white focus:outline-none" onclick="toggleSubmenu('books-menu')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25S6.5 28 12 28s10-4.745 10-10.75C22 10.998 17.5 6.253 12 6.253z"></path>
                        </svg>
                        <span>Books</span>
                        <svg class="w-4 h-4 ml-auto transition-transform" id="books-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>
                    <div id="books-menu" class="hidden space-y-1 pl-2">
                        <a href="#" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-slate-400 text-sm transition-colors hover:bg-slate-800 hover:text-white">
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>All Books</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-slate-400 text-sm transition-colors hover:bg-slate-800 hover:text-white">
                            <span class="w-1 h-1 bg-blue-500 rounded-full"></span>
                            <span>Add Book</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-slate-400 text-sm transition-colors hover:bg-slate-800 hover:text-white">
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
                        <p class="text-sm font-medium">Admin User</p>
                        <p class="text-xs text-slate-400">admin@bookstore.com</p>
                    </div>
                </div>
                <a href="#" class="w-full flex items-center justify-center space-x-2 px-4 py-2 rounded-lg text-slate-300 text-sm transition-colors hover:bg-slate-800 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <!-- Top Navigation Bar -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 md:px-8 py-4 flex items-center justify-between">
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-600" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Search Bar -->
                    <div class="hidden md:block flex-1 max-w-xl">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Top Right Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Profile -->
                        <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
                            <div class="hidden sm:text-right">
                                <p class="text-sm font-medium text-gray-900">Admin User</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <img src="https://ui-avatars.com/api/?name=Admin+User&background=0D8ABC&color=fff" alt="Admin" class="w-10 h-10 rounded-full">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 px-4 md:px-8 py-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-4 md:px-8 py-6 text-center text-sm text-gray-600">
                <p>&copy; 2026 Laravel Local Bookstore. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
        }

        function toggleSubmenu(menuId) {
            const menu = document.getElementById(menuId);
            const chevron = document.getElementById(menuId.replace('-menu', '-chevron'));
            menu.classList.toggle('hidden');
            if (chevron) {
                chevron.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }
    </script>

    @livewireScripts
</body>
</html>
