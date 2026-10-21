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
        @include('components.admin.sidebar')

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
                <p>&copy; {{ date('Y')}} Laravel Local Bookstore. All rights reserved.</p>
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
