<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customer\HomePage;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('home', HomePage::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::view('admin/dashboard', 'livewire.admin.dashboard')->name('admin.dashboard');
});

require __DIR__.'/auth.php';
