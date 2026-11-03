<?php

use App\Livewire\Admin\Author\AuthorIndex;
use App\Livewire\Admin\Author\CreateAuthor;
use App\Livewire\Admin\Author\EditAuthor;
use App\Livewire\Admin\Author\ViewAuthor;
use App\Livewire\Admin\Book\BookIndex;
use App\Livewire\Admin\Book\CreateBook;
use App\Livewire\Admin\Book\EditBook;
use App\Livewire\Admin\Book\ViewBook;
use App\Livewire\Admin\Category\CategoryIndex;
use App\Livewire\Admin\Category\CreateCategory;
use App\Livewire\Admin\Category\EditCategory;
use App\Livewire\Admin\Category\ViewCategory;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Publisher\CreatePublisher;
use App\Livewire\Admin\Publisher\EditPublisher;
use App\Livewire\Admin\Publisher\PublisherIndex;
use App\Livewire\Admin\Publisher\ViewPublisher;
use App\Livewire\Admin\Supplier\CreateSupplier;
use App\Livewire\Admin\Supplier\EditSupplier;
use App\Livewire\Admin\Supplier\SupplierIndex;
use App\Livewire\Admin\Supplier\SupplierView;
use App\Livewire\Customer\CartIndex;
use App\Livewire\Customer\Checkout;
use App\Livewire\Customer\CollectionBestSeller;
use App\Livewire\Customer\CreateCollection;
use App\Livewire\Customer\CustomerCategories;
use App\Livewire\Customer\HomePage;
use App\Livewire\Customer\OrderIndex;
use App\Livewire\Customer\OrderShow;
use App\Livewire\Customer\ProductIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Inventory\InventoryIndex;
use App\Livewire\Admin\Inventory\InventoryAdjustment;
use App\Livewire\Admin\Inventory\InventoryMovement;
use App\Livewire\Admin\Inventory\StockMovementView;
use App\Livewire\Admin\PurchaseOrder\CreatePurchaseOrder;
use App\Livewire\Admin\PurchaseOrder\EditPurchaseOrder;
use App\Livewire\Admin\PurchaseOrder\PurchaseOrderIndex;
use App\Livewire\Admin\PurchaseOrder\ViewPurchaseOrder;

Route::get('/', HomePage::class)->name('home');

require __DIR__.'/auth.php';

Route::get('collection', CartIndex::class)->name('collections.index');
Route::get('collection/bestsellers', CollectionBestSeller::class)->name('collections.bestsellers');
Route::redirect('/categories', '/')->name('categories');
Route::get('categories/{category:slug}', CustomerCategories::class)->name('category.view');
Route::get('products/{book:slug}', ProductIndex::class)->name('product.show');

Route::middleware(['auth', 'verified', 'role:User'])->group(function () {
    Route::get('cart', CartIndex::class)->name('cart.index');
    Route::get('checkout', Checkout::class)->name('checkout');
    Route::get('orders', OrderIndex::class)->name('orders.index');
    Route::get('orders/{order}', OrderShow::class)->name('orders.show');
    Route::get('collection/add', CreateCollection::class)->name('collections.new');
    Route::view('profile', 'profile')->name('profile');
});

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
    Route::get('suppliers', SupplierIndex::class)->name('suppliers.index');
    Route::get('suppliers/create', CreateSupplier::class)->name('suppliers.create');
    Route::get('suppliers/{supplier}/edit', EditSupplier::class)->name('suppliers.edit');
    Route::get('suppliers/{supplier}', SupplierView::class)->name('suppliers.view');
    Route::get('inventory', InventoryIndex::class)->name('inventory.index');
    Route::get('inventory/adjustment', InventoryAdjustment::class)->name('inventory.adjustment');
    Route::get('inventory/movements', InventoryMovement::class)->name('inventory.movements');
    Route::get('inventory/movements/{stockMovement}', StockMovementView::class)->name('inventory.movements.view');
    Route::get('purchase-orders', PurchaseOrderIndex::class)->name('purchase-orders.index');
    Route::get('purchase-orders/create', CreatePurchaseOrder::class)->name('purchase-orders.create');
    Route::get('purchase-orders/{purchaseOrder}/edit', EditPurchaseOrder::class)->name('purchase-orders.edit');
    Route::get('purchase-orders/{purchaseOrder}', ViewPurchaseOrder::class)->name('purchase-orders.view');
});
