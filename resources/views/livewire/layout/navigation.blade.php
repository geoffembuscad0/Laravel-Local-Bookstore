<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ 
    sideMenuOpen: false,
    toggleSideMenu() {
        this.sideMenuOpen = !this.sideMenuOpen;
    },
    closeSideMenu() {
        this.sideMenuOpen = false;
    }
}" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    
    <!-- Desktop Navigation (≥ 720px) -->
    <div class="hidden lg:block max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @can('view-books')
                        <x-nav-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')" wire:navigate>
                            {{ __('Books') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()?->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Mobile Header (< 720px) -->
    <div class="lg:hidden px-4 py-3 flex justify-between items-center h-16">
        <!-- Logo for Mobile -->
        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}" wire:navigate>
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>

        <!-- Mobile Menu Toggle Button -->
        <button 
            @click="toggleSideMenu()"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
        >
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': sideMenuOpen, 'inline-flex': ! sideMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! sideMenuOpen, 'inline-flex': sideMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Ionic-Style Side Menu Overlay (< 720px) -->
    <div 
        @click="closeSideMenu()"
        :class="{'opacity-100 pointer-events-auto': sideMenuOpen, 'opacity-0 pointer-events-none': ! sideMenuOpen}"
        class="fixed inset-0 bg-black/50 transition-opacity duration-300 lg:hidden z-40"
    ></div>

    <!-- Ionic-Style Side Menu Panel (< 720px) -->
    <div 
        :class="{'translate-x-0': sideMenuOpen, '-translate-x-full': ! sideMenuOpen}"
        class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 shadow-lg transition-transform duration-300 ease-in-out z-50 lg:hidden overflow-y-auto"
    >
        <!-- Side Menu Header -->
        <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="font-semibold text-gray-800 dark:text-gray-200">Menu</div>
                <button 
                    @click="closeSideMenu()"
                    class="inline-flex items-center justify-center p-1 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Side Menu Navigation Links -->
        <div class="px-3 py-4 space-y-1">
            <a 
                href="{{ route('dashboard') }}" 
                wire:navigate
                @click="closeSideMenu()"
                :class="{'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white': {{ request()->routeIs('dashboard') ? 'true' : 'false' }}, 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700': {{ request()->routeIs('dashboard') ? 'false' : 'true' }}}"
                class="block px-4 py-2 rounded-lg text-base font-medium transition"
            >
                {{ __('Dashboard') }}
            </a>

            @can('view-books')
                <a 
                    href="{{ route('admin.books.index') }}" 
                    wire:navigate
                    @click="closeSideMenu()"
                    :class="{'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white': {{ request()->routeIs('admin.books.*') ? 'true' : 'false' }}, 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700': {{ request()->routeIs('admin.books.*') ? 'false' : 'true' }}}"
                    class="block px-4 py-2 rounded-lg text-base font-medium transition"
                >
                    {{ __('Books') }}
                </a>
            @endcan
        </div>

        <!-- Side Menu Footer with User Info -->
        <div class="absolute bottom-0 left-0 right-0 px-3 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <div class="px-4 mb-4">
                <div class="font-medium text-sm text-gray-800 dark:text-gray-200" x-data="{{ json_encode(['name' => auth()->user()?->name]) }}" x-text="name"></div>
                <div class="font-medium text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()?->email }}</div>
            </div>

            <div class="space-y-1">
                <a 
                    href="{{ route('profile') }}" 
                    wire:navigate
                    @click="closeSideMenu()"
                    class="block px-4 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                >
                    {{ __('Profile') }}
                </a>

                <button 
                    wire:click="logout"
                    @click="closeSideMenu()"
                    class="w-full text-start px-4 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                >
                    {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </div>
</nav>
