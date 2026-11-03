<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseOrdersSeeder extends Seeder
{
    /**
     * Seed draft and ordered purchase orders for testing supplier order history.
     * This seeder deliberately does not receive items or change book stock.
     */
    public function run(): void
    {
        $user = User::query()->orderBy('id')->first();
        $books = Book::query()->orderBy('id')->limit(4)->get();

        if (! $user || $books->isEmpty()) {
            $this->command?->warn('Purchase orders were not seeded: seed at least one user and one book first.');

            return;
        }

        $orders = [
            [
                'po_number' => 'TEST-PO-2026-001',
                'supplier_code' => 'SUP-001',
                'status' => 'ordered',
                'order_date' => now()->subDays(12)->toDateString(),
                'expected_delivery_date' => now()->addDays(3)->toDateString(),
                'shipping_cost' => 12.50,
                'tax_amount' => 0,
                'notes' => 'Sample ordered purchase order. Items have not been received.',
                'book_indexes' => [0, 1],
                'quantities' => [8, 5],
                'unit_costs' => [180.00, 225.00],
            ],
            [
                'po_number' => 'TEST-PO-2026-002',
                'supplier_code' => 'SUP-002',
                'status' => 'draft',
                'order_date' => now()->subDays(2)->toDateString(),
                'expected_delivery_date' => now()->addDays(14)->toDateString(),
                'shipping_cost' => 0,
                'tax_amount' => 0,
                'notes' => 'Sample draft for testing the purchasing workflow.',
                'book_indexes' => [2],
                'quantities' => [6],
                'unit_costs' => [195.00],
            ],
            [
                'po_number' => 'TEST-PO-2026-003',
                'supplier_code' => 'SUP-003',
                'status' => 'cancelled',
                'order_date' => now()->subDays(30)->toDateString(),
                'expected_delivery_date' => null,
                'shipping_cost' => 0,
                'tax_amount' => 0,
                'notes' => 'Historical cancelled order for an inactive supplier.',
                'book_indexes' => [3],
                'quantities' => [3],
                'unit_costs' => [160.00],
            ],
        ];

        foreach ($orders as $orderData) {
            $supplier = Supplier::query()
                ->where('code', $orderData['supplier_code'])
                ->first();

            if (! $supplier) {
                $this->command?->warn("Purchase order {$orderData['po_number']} skipped: supplier {$orderData['supplier_code']} was not found.");

                continue;
            }

            $items = [];
            foreach ($orderData['book_indexes'] as $index => $bookIndex) {
                $book = $books->get($bookIndex);

                if (! $book) {
                    continue;
                }

                $quantity = $orderData['quantities'][$index];
                $unitCost = $orderData['unit_costs'][$index];

                $items[] = [
                    'book' => $book,
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'line_total' => $quantity * $unitCost,
                ];
            }

            if ($items === []) {
                continue;
            }

            $subtotal = array_sum(array_column($items, 'line_total'));
            $purchaseOrder = PurchaseOrder::query()->updateOrCreate(
                ['po_number' => $orderData['po_number']],
                [
                    'supplier_id' => $supplier->id,
                    'created_by' => $user->id,
                    'status' => $orderData['status'],
                    'order_date' => $orderData['order_date'],
                    'expected_delivery_date' => $orderData['expected_delivery_date'],
                    'subtotal' => $subtotal,
                    'shipping_cost' => $orderData['shipping_cost'],
                    'tax_amount' => $orderData['tax_amount'],
                    'total_amount' => $subtotal + $orderData['shipping_cost'] + $orderData['tax_amount'],
                    'notes' => $orderData['notes'],
                ]
            );

            foreach ($items as $item) {
                $purchaseOrder->items()->updateOrCreate(
                    ['book_id' => $item['book']->id],
                    [
                        'quantity_ordered' => $item['quantity'],
                        'quantity_received' => 0,
                        'unit_cost' => $item['unit_cost'],
                        'line_total' => $item['line_total'],
                    ]
                );
            }
        }
    }
}
