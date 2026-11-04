# Laravel Local Bookstore

A Laravel 12 online bookstore project built from scratch. The application combines a bookstore catalog with an administrative area for managing books, suppliers, purchase orders, and inventory.

This project is being developed as a practical implementation of an online bookstore, with an emphasis on clean Laravel architecture and realistic bookstore management workflows.

> **Current development focus:** The admin-side catalog and basic supply-chain management features are implemented. The customer-facing shopping experience is still under development. Payment integ[...]

---

## Features

### Admin Management

| Module | Description |
|---|---|
| Dashboard | Admin landing page |
| Book Management | Create, view, edit, and manage book records |
| Author Management | Maintain book author information |
| Category Management | Organize books by category |
| Publisher Management | Maintain publisher information |
| Supplier Management | Register and manage book suppliers |
| Purchase Order Management | Create, place, and receive supplier purchase orders |
| Inventory Management | Monitor stock levels and record stock adjustments |
| Stock Movement History | Review inventory transactions and their details |

### Customer-facing Features

The customer-facing side is currently under development. Existing storefront routes and components are being expanded into a complete browsing and shopping experience.

Planned functionality includes:
- Browse the book catalog.
- View individual book details.
- Browse books by category.
- Explore book collections.
- Add books to a shopping cart.
- Continue through a checkout flow.

Payment gateway integration is outside the current project scope.

---

## Technology Stack

- **PHP:** 8.2+
- **Framework:** Laravel 12
- **Frontend:** Livewire 3, Livewire Volt
- **CSS Framework:** Tailwind CSS
- **Authorization:** Spatie Laravel Permission
- **Database:** MySQL
- **Testing:** Pest / PHPUnit

---

# Admin Guide

The admin area is intended for users with either the `Admin` or `Super Admin` role.

After logging in with an authorized account, navigate to:

```text
/admin/dashboard
```

The sidebar organizes the administrative features into separate management modules.

## 1. Book Management

Book Management is where administrators maintain the bookstore's catalog records.

Before creating books, it is helpful to establish the supporting catalog information first.

### Step 1.1 — Manage Authors

Navigate to:

```text
Admin Sidebar → Book Management → Authors
```

Register the authors whose books will be included in the bookstore.

Author records can be associated with books when creating or editing a book.

### Step 1.2 — Manage Categories

Navigate to:

```text
Admin Sidebar → Book Management → Categories
```

Create categories that will be used to organize the bookstore's catalog.

Examples:
- Fiction
- Non-Fiction
- Philosophy
- History
- Science
- Technology

Categories help organize books for the future customer-facing catalog.

### Step 1.3 — Manage Publishers

Navigate to:

```text
Admin Sidebar → Book Management → Publishers
```

Register the publishers associated with the books in the catalog.

### Step 1.4 — Add Books

Navigate to:

```text
Admin Sidebar → Book Management → Books
```

Select the option to create a new book.

Provide the necessary information, including:

- Book title
- ISBN
- Description
- Selling price
- Discount price (optional)
- Initial stock quantity
- Number of pages
- Language
- Publication date
- SKU
- Publisher
- Primary author

When a book is created, the application also creates its associated product record.

**Important: Initial Stock**

Initial stock is recorded through the inventory service. If an initial quantity greater than zero is provided during book creation, the application creates an `INITIAL_STOCK` movement.

The book's stock is not intended to be edited directly through the regular book editing form. Subsequent stock changes should be handled through Inventory Management or Purchase Order Receiving.

---

## 2. Supplier Management

Supplier Management maintains the bookstore's supplier records.

Navigate to:

```text
Admin Sidebar → Supply Chain → Suppliers
```

### Step 2.1 — Register a Supplier

Create a supplier record and provide its information:

- Supplier name
- Supplier code
- Email address
- Phone number
- Contact person
- Address
- City
- Postal code
- Country
- Website
- Payment terms
- Additional notes

Suppliers can be marked as active or inactive.

### Step 2.2 — Manage Supplier Records

From the supplier listing, administrators can search and review registered suppliers.

Supplier records are also associated with purchase orders, allowing administrators to review the purchasing history of a particular supplier.

**Note:** Only active suppliers are available when creating a new purchase order.

---

## 3. Inventory Management

Inventory Management provides an overview of the current stock quantities of books in the bookstore.

Navigate to:

```text
Admin Sidebar → Supply Chain → Inventory
```

### Step 3.1 — Monitor Stock Levels

The inventory listing displays the books and their current stock quantities.

Administrators can search for books using their title, ISBN, or SKU.

The inventory page provides stock filters:

| Filter | Description |
|---|---|
| All | Display all books |
| Out of Stock | Books with zero available stock |
| Low Stock | Books with 1–5 copies |
| Available | Books with more than 5 copies |

These filters help administrators identify books that may require replenishment.

### Step 3.2 — Adjust Inventory

Navigate to:

```text
Admin Sidebar → Supply Chain → Inventory → Adjustment
```

Use this feature when a manual stock correction is necessary.

Select a book, choose the adjustment type, enter the quantity, and provide a reason.

Available adjustment types:

- **Increase:** Add copies to the current stock.
- **Decrease:** Remove copies from the current stock.

For example:

If a book currently has 10 copies and an administrator records an increase of 5, the resulting stock becomes 15.

If an administrator records a decrease of 2, the resulting stock becomes 13.

Every adjustment is recorded as an inventory movement, including the quantity before and after the transaction.

**Important Inventory Rules**

- Stock cannot become negative.
- Zero-quantity movements are rejected.
- Every manual adjustment requires a reason.
- Stock changes are processed through the inventory service.
- Purchase receipts must be processed through the purchase order receiving workflow.

These rules help maintain consistent inventory records.

---

## 4. Purchase Order Management

Purchase Order Management handles the process of replenishing book inventory through registered suppliers.

Navigate to:

```text
Admin Sidebar → Supply Chain → Purchase Orders
```

The purchasing workflow follows this sequence:

```text
Create Purchase Order
        ↓
Save as Draft
        ↓
Review Purchase Order
        ↓
Place Order
        ↓
Receive Supplier Delivery
        ↓
Update Book Inventory
        ↓
Review Stock Movement History
```

### Step 4.1 — Create a Purchase Order

Select **Create Purchase Order**.

Provide the following information:

- Supplier
- Order date
- Expected delivery date
- Shipping cost
- Tax amount
- Notes

Next, add the books that will be included in the purchase order.

For every item, provide:

- Book
- Quantity ordered
- Unit cost

The application calculates the line totals, subtotal, and overall purchase order amount.

Once saved, the purchase order is assigned a unique purchase order number and starts with a `Draft` status.

**Important:** Creating a purchase order does not increase the stock quantity of the selected books. It only records the intended purchase.

### Step 4.2 — Review and Edit a Draft

Open the newly created purchase order to review its details.

While the purchase order is still in `Draft` status, administrators can edit its supplier, dates, costs, notes, and items.

Once the purchase order has been placed, it can no longer be edited.

### Step 4.3 — Place the Purchase Order

After reviewing the details, select **Place Order**.

The purchase order status changes from:

```text
Draft → Ordered
```

This indicates that the purchase order has been placed with the supplier.

Placing an order does not increase book inventory. Stock is updated only when the delivery is received and recorded.

### Step 4.4 — Receive Supplier Deliveries

When the supplier delivers the books, open the corresponding purchase order.

Each purchase order item displays its ordered quantity and received quantity.

Enter the quantity actually received for the selected item and provide optional receiving notes.

For example:

A purchase order contains 20 copies of a book.

The supplier delivers only 12 copies initially.

Record a receipt of 12 copies.

The application will:

1. Increase the book's current stock by 12.
2. Update the purchase order item's received quantity.
3. Create a `PURCHASE_RECEIVED` stock movement.
4. Update the purchase order status.

The remaining 8 copies can be received later.

### Step 4.5 — Understand Purchase Order Statuses

Purchase orders use the following statuses:

| Status | Description |
|---|---|
| Draft | Purchase order has been created but not placed |
| Ordered | Purchase order has been placed and is awaiting delivery |
| Partially Received | Some, but not all, ordered quantities have been received |
| Received | All purchase order items have been fully received |
| Cancelled | Purchase order has been cancelled |

A purchase order can be partially received across multiple deliveries.

The application prevents administrators from receiving more copies than the remaining ordered quantity.

Purchase orders with received items cannot be cancelled through the current workflow.

---

## 5. Stock Movement History

Every inventory transaction is recorded so administrators can review how book quantities have changed over time.

Navigate to:

```text
Admin Sidebar → Supply Chain → Inventory → Movements
```

The movement history records information such as:

- Book
- User who performed the transaction
- Movement type
- Quantity changed
- Quantity before the transaction
- Quantity after the transaction
- Reference
- Notes

### Supported Movement Types

| Movement Type | Description |
|---|---|
| `INITIAL_STOCK` | Initial stock recorded when a book is created |
| `ADJUSTMENT` | Manual increase or decrease in inventory |
| `PURCHASE_RECEIVED` | Stock received from a supplier purchase order |
| `SALE` | Stock reduction associated with a sale |
| `DAMAGE` | Stock reduction due to damaged books |
| `LOSS` | Stock reduction due to missing or lost books |

Some movement types are part of the broader inventory workflow and may be used by future customer-facing sales functionality.

Administrators can open an individual movement record to review its details.

**Why stock movement history matters**

Instead of simply changing a book's stock quantity, the application maintains a transaction history that explains how the current quantity was reached.

This provides a basic audit trail for inventory operations.

---

# Local Installation

Follow these instructions to run the project locally.

## Requirements

Make sure the following tools are installed:

- PHP 8.2 or later
- Composer
- Node.js and npm
- MySQL
- Git

## 1. Clone the Repository

```bash
git clone https://github.com/geoffembuscad0/Laravel-Local-Bookstore.git

cd Laravel-Local-Bookstore
```

## 2. Install Dependencies

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

## 3. Configure Environment Variables

Create your local environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

## 4. Configure the Database

Create a MySQL database for the project.

Update the database configuration in your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=l12_bookstore
DB_USERNAME=root
DB_PASSWORD=
```

Change these values according to your local MySQL configuration.

## 5. Configure an Admin Account

The project uses Spatie Laravel Permission for role-based access control.

The database seeder creates the following roles:

- `Super Admin`
- `Admin`
- `User`

To create a local Super Admin account through the seeder, configure these environment variables in `.env`:

```env
SEED_SUPER_ADMIN_EMAIL=superadmin@example.com
SEED_SUPER_ADMIN_NAME="Super Admin"
SEED_SUPER_ADMIN_PASSWORD=change-this-local-password
```

You can also configure a regular Admin account:

```env
SEED_ADMIN_EMAIL=admin@example.com
SEED_ADMIN_NAME="Default Admin"
SEED_ADMIN_PASSWORD=change-this-local-password
```

Use your own local passwords. Do not use sample credentials in a publicly accessible or production environment.

## 6. Run Migrations and Seeders

Run the database migrations and seed the database:

```bash
php artisan migrate --seed
```

The database seeder creates sample records for:

- Categories
- Authors
- Publishers
- Books
- Book categories
- Permissions and roles
- Sample users
- Suppliers
- Purchase orders

The sample supplier and purchase order records can be used to explore the supply-chain management features.

The sample purchase orders are not automatically received, so they do not increase book inventory.

## 7. Build Frontend Assets

For development:

```bash
npm run dev
```

For a production asset build:

```bash
npm run build
```

## 8. Start the Laravel Application

In a separate terminal, run:

```bash
php artisan serve
```

Open the application in your browser:

```text
http://127.0.0.1:8000
```

Log in using the local admin account configured during setup.

---

# Running Tests

Run the application's automated test suite:

```bash
php artisan test
```

---

# Project Structure

A simplified overview of the application's directory structure:

```text
app/
├── Enums/
├── Livewire/
│   ├── Admin/
│   │   ├── Author/
│   │   ├── Book/
│   │   ├── Category/
│   │   ├── Inventory/
│   │   ├── Publisher/
│   │   ├── PurchaseOrder/
│   │   └── Supplier/
│   └── Customer/
├── Models/
├── Policies/
└── Services/

database/
├── factories/
├── migrations/
└── seeders/

resources/
└── views/
    ├── components/
    ├── layouts/
    └── livewire/
        ├── admin/
        └── customer/

routes/
├── auth.php
├── console.php
└── web.php
```

## Important Business Logic

The project uses an `InventoryService` to centralize stock-related operations.

This service is responsible for:
- Recording initial stock.
- Processing manual stock adjustments.
- Receiving purchase order items.
- Preventing invalid stock changes.
- Recording stock movement history.
- Keeping purchase order receiving quantities and book inventory synchronized.

Database transactions and row locking are used in stock-changing workflows to help preserve inventory consistency.

---

# Development Roadmap

The project is being developed incrementally.

### Completed / Current Admin Scope

- [x] Book Management
- [x] Author Management
- [x] Category Management
- [x] Publisher Management
- [x] Supplier Management
- [x] Inventory Monitoring
- [x] Inventory Adjustments
- [x] Stock Movement History
- [x] Purchase Order Creation and Management
- [x] Partial Purchase Order Receiving

### Customer-facing Scope

- [x] Customer Book Catalog
- [x] Book Details and Browsing
- [x] Category-based Book Browsing
- [x] Shopping Cart
- [x] Customer Shopping Flow
- [x] Checkout Workflow — Cash on Delivery (COD)
- [x] Customer Order History and Details
- [x] Metro Manila delivery address validation
- [x] Customer order status display and pending-order cancellation

Customer checkout is limited to Metro Manila and accepts Cash on Delivery only. Orders are unpaid when placed; payment is due in cash upon delivery. There is no payment gateway integration.

Customer order states shown to customers are: Order received, Preparing your order, Out for delivery, Delivered, and Cancelled. Customers may cancel only while an order is pending.

---

## Project Notes

This is a personal development project intended to demonstrate practical Laravel application development.

The goal is to build a functional online bookstore with a manageable administrative workflow, rather than an enterprise-level inventory or supply-chain platform.

The implementation prioritizes maintainable code, clear separation of responsibilities, and realistic business rules appropriate for a small bookstore.
