<?php

use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Livewire\Customer\HomePage;
use App\Livewire\Customer\CartIndex;
use App\Livewire\Customer\ProductIndex;
use App\Livewire\Customer\CreateCollection;
use App\Livewire\Customer\CollectionBestSeller;
use App\Livewire\Customer\CustomerCategories;
use App\Livewire\Admin\Book\BookIndex;
use App\Livewire\Admin\Book\CreateBook;
use App\Livewire\Admin\Book\EditBook;
use App\Livewire\Admin\Book\ViewBook;
use App\Livewire\Admin\Author\AuthorIndex;
use App\Livewire\Admin\Author\CreateAuthor;
use App\Livewire\Admin\Author\EditAuthor;
use App\Livewire\Admin\Author\ViewAuthor;
use App\Livewire\Admin\Category\CategoryIndex;
use App\Livewire\Admin\Category\CreateCategory;
use App\Livewire\Admin\Category\EditCategory;
use App\Livewire\Admin\Category\ViewCategory;
use App\Livewire\Admin\Publisher\PublisherIndex;
use App\Livewire\Admin\Publisher\CreatePublisher;
use App\Livewire\Admin\Publisher\EditPublisher;
use App\Livewire\Admin\Publisher\ViewPublisher;

// Landing page: catalog (public)
Route::get('/', HomePage::class)->name('home');

// Auth routes (login/register/etc.)
require __DIR__.'/auth.php';

// Public routes (no authentication required)
Route::get('collection', CartIndex::class)->name('collections.index');
Route::get('collection/bestsellers', CollectionBestSeller::class)->name('collections.bestsellers');
Route::redirect('/categories', '/')->name('categories');
Route::get('categories/{category:slug}', CustomerCategories::class)->name('category.view');
Route::get('products/{book}', ProductIndex::class)->name('product.show');

// Authenticated customer routes
Route::middleware(['auth', 'verified', 'role:User'])->group(function () {
    Route::get('cart', CartIndex::class)->name('cart.index');
    Route::get('collection/add', CreateCollection::class)->name('collections.new');

    // User profile
    Route::view('profile', 'profile')->name('profile');
});

// Admin routes - guarded by Spatie roles
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin,Super Admin'])->group(function () {
        Route::get('dashboard', Dashboard::class)->name('dashboard');

        Route::get('books', BookIndex::class)->name('books.index');
        Route::get('books/create', CreateBook::class)->name('books.create');
        Route::get('books/{book}', ViewBook::class)->name('books.view');
        Route::get('books/{book}/edit', EditBook::class)->name('books.edit');

        Route::get('authors', AuthorIndex::class)->name('authors.index');
        Route::get('authors/create', CreateAuthor::class)->name('authors.create');
        Route::get('authors/{author}', ViewAuthor::class)->name('authors.view');
        Route::get('authors/{author}/edit', EditAuthor::class)->name('authors.edit');

        Route::get('category', CategoryIndex::class)->name('category.index');
        Route::get('category/create', CreateCategory::class)->name('category.create');
        Route::get('category/{category}', ViewCategory::class)->name('category.view');
        Route::get('category/{category}/edit', EditCategory::class)->name('category.edit');

        Route::get('publisher', PublisherIndex::class)->name('publisher.index');
        Route::get('publisher/create', CreatePublisher::class)->name('publisher.create');
        Route::get('publisher/{publisher}', ViewPublisher::class)->name('publisher.view');
        Route::get('publisher/{publisher}/edit', EditPublisher::class)->name('publisher.edit');
});