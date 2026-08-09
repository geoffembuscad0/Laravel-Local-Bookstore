<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customer\HomePage;

// Landing page: catalog (public)
Route::get('/', HomePage::class)->name('home');

// Auth routes (login/register/etc.)
require __DIR__.'/auth.php';

// Authenticated (default) user routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Default user dashboard
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // User profile
    Route::view('profile', 'profile')->name('profile');
});

// Admin routes - guarded by Spatie role:admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('dashboard', 'livewire.admin.dashboard')->name('dashboard');
});
