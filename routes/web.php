<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('admin/dashboard', 'livewire.admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

require __DIR__.'/auth.php';
