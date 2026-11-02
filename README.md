# Laravel Local Bookstore

A Laravel-based online bookstore application with a customer storefront and an admin management area for books, catalog data, inventory, and purchasing workflows.

## Project overview

This project is designed as a practical bookstore management system with two primary user experiences:

- Customer-facing storefront for browsing books, categories, collections, and cart flow
- Admin-side management for catalog data, stock control, purchase orders, and inventory movements

The application uses Laravel with Livewire and Tailwind for the interface layer, and it includes role-based access control for customer and admin personas.

## Core functionality

### Customer storefront
- Public landing/catalog page
- Book detail pages
- Category browsing
- Best seller / collection pages
- Customer cart flow
- Authenticated customer route support

### Catalog management
- Books
- Authors
- Categories
- Publishers

### Inventory and purchasing workflow
The project includes a more advanced stock-management process than a basic catalog CRUD setup.

1. Initial stock is recorded when a book is created.
2. Stock is not edited directly in the regular book edit flow.
3. Inventory changes go through the inventory service layer.
4. Purchase orders can be created for stock replenishment.
5. Purchase order receiving updates stock and records movement history.
6. Inventory adjustments can create manual stock changes with notes.
7. Stock movement history is tracked for auditability.

## Key business rules

The system enforces a controlled stock flow through `InventoryService`:

- Initial stock is allowed once per book
- Negative stock is blocked
- Purchase receipts must be processed via the purchase-order receiving workflow
- Adjustment entries require a reason
- Zero-quantity movements are rejected
- Stock movement history is stored with before/after quantities

This keeps the business logic consistent and protects the integrity of inventory data.

## Tech stack

- Laravel 12
- PHP 8.2+
- Livewire 3
- Livewire Volt 1.7
- Tailwind CSS
- Spatie Laravel Permission
- MySQL / Laravel database layer
- PHPUnit for automated testing

## Project structure

```text
app/
├── Http/
├── Livewire/
│   ├── Admin/
│   │   ├── Book/
│   │   ├── Author/
│   │   ├── Category/
│   │   ├── Publisher/
│   │   ├── Inventory/
│   │   └── PurchaseOrder/
│   ├── Customer/
│   └── ...
├── Models/
├── Services/
├── Enums/
└── Providers/

resources/views/
├── livewire/
│   ├── admin/
│   ├── customer/
│   └── ...
└── layouts/

routes/
├── web.php
├── auth.php
└── console.php
```

## Route and role flow

The application is organized around Laravel routes and role guards:

- Public storefront routes: home, categories, product pages, collections
- Authenticated customer routes: cart and customer collection actions
- Admin routes: dashboard and catalog administration
- Role-based access is enforced using `role:User` and `role:Admin,Super Admin`

Example route groups include:

- `/` -> home catalog page
- `/products/{book}` -> book detail page
- `/cart` -> customer cart page
- `/admin/dashboard` -> admin dashboard
- `/admin/books` -> book administration
- `/admin/inventory` -> inventory monitoring
- `/admin/purchase-order` -> purchase orders

## Inventory workflow details

### 1. Book creation
Books can be created with catalog data and initial inventory stock recorded as part of the book setup flow.

### 2. Inventory adjustments
Administrative inventory changes can be recorded via stock-adjustment actions with reason notes and movement tracking.

### 3. Purchase order creation
Purchase orders are created for restocking. Each line item tracks quantity ordered against book inventory needs.

### 4. Purchase order receiving
When stock arrives:
- the order item receives quantities
- stock is increased in the book record
- purchase order status changes as needed
- a stock movement entry is recorded with the receiving event

### 5. Movement history
Each inventory transaction is logged with:
- book ID
- user ID
- movement type
- quantity
- quantity before/after
- reference
- notes

This supports reporting and administration review.

## Admin modules

The app includes dedicated admin modules for:

- Dashboard
- Books
- Authors
- Categories
- Publishers
- Inventory
- Purchase orders

The inventory and purchasing modules are the most advanced and represent the business workflow the project is currently emphasizing.

## Testing

The project includes automated tests around key stock and receiving flows.

Run tests with:

```bash
php artisan test
```

## Local setup

1. Clone the repository

```bash
git clone https://github.com/geoffembuscad0/Laravel-Local-Bookstore.git
cd Laravel-Local-Bookstore
```

2. Install PHP dependencies

```bash
composer install
```

3. Install frontend dependencies

```bash
npm install
```

4. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_local_bookstore
DB_USERNAME=root
DB_PASSWORD=
```

6. Run database migrations

```bash
php artisan migrate
```

7. Run the app

```bash
php artisan serve
```

and, in a separate terminal:

```bash
npm run dev
```

## Recommended development workflow

For this project, the typical application workflow is:

1. Create or manage catalog data (authors, publishers, categories, books)
2. Record initial stock when books are introduced
3. Monitor inventory levels
4. Generate purchase orders for replenishment
5. Receive supplier stock
6. Review stock movement history and adjustments
7. Validate the storefront behavior from the customer side

## Notes

This project is evolving around a bookstore domain that combines both storefront browsing and operational inventory management. The inventory and procurement logic is currently a central part of the application’s business rules and is more advanced than a standard demo storefront.

## License

This project is intended for learning and local development use. Check the repository license and project conventions before distributing or deploying it beyond local usage.
