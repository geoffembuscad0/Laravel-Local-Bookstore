# Laravel Bookstore — MVP

A full-stack online bookstore MVP built with Laravel: customer storefront
with cart/checkout, admin catalog management, and inventory tracking with
purchase-order receiving. Cash on Delivery, scoped to Metro Manila.

> **Status:** MVP. Payment gateway intentionally deferred (COD-only) to
> avoid third-party fees; delivery restricted to Metro Manila by design.

## Demo
![Admin verview](docs/image-admin-book-mgt.png)
![Catalog overview](docs/image-catalog-cart.png)
![Index overview](docs/image-index.png)
![Product overview](docs/image-product-view.png)

## What it does
**Customer**
- Browse/search/filter catalog by category
- Cart → checkout → COD order
- Order history, order details, pending-order cancellation
- Delivery address validated against Metro Manila

**Admin**
- Dashboard
- Books, authors, categories, publishers, suppliers
- Inventory monitoring & adjustments
- Stock movement history
- Purchase orders + partial receiving

## Architecture notes
- **Service classes** for [name them — e.g. InventoryService, OrderService]
  to keep controllers thin and business rules testable
- **Role-based access** — admin vs. customer routes/middleware
- **Stock movement ledger** — every inventory change is recorded, so
  current stock is derived from movements rather than a single counter
- **Partial PO receiving** — a purchase order can be received across
  multiple deliveries, with stock updated per receipt
- **Cover image upload** for book management

## Stack
Laravel · MySQL · Blade · Tailwind · Vite · Alpine.js *(adjust to reality)*

## Getting started
```bash
git clone https://github.com/geoffembuscad0/laravel-bookstore-mvp.git
cd laravel-bookstore-mvp
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
# configure DB in .env, then:
php artisan migrate --seed
php artisan serve