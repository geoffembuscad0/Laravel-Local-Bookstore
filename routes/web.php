<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customer\HomePage;
use App\Livewire\Customer\CartIndex;
use App\Livewire\Customer\CreateCollection;
use App\Livewire\Customer\CollectionBestSeller;
use App\Livewire\Customer\CustomerCategories;

// Landing page: catalog (public)
Route::get('/', HomePage::class)->name('home');

// Auth routes (login/register/etc.)
require __DIR__.'/auth.php';

// Authenticated (default) user routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Default user dashboard
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('cart', CartIndex::class)->name('cart.index');
    Route::get('collection/add', CreateCollection::class)->name('collections.new');
    Route::get('collection', CartIndex::class)->name('collections.index');
    Route::get('collection/bestsellers', CollectionBestSeller::class)->name('collections.bestsellers');
    Route::get('categories', CustomerCategories::class)->name('categories');

    // User profile
    Route::view('profile', 'profile')->name('profile');
});

// Admin routes - guarded by Spatie role:admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('dashboard', 'livewire.admin.dashboard')->name('dashboard');
});
