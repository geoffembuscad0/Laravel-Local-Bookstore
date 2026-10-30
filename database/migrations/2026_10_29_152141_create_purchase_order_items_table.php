<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders')
                ->cascadeOnDelete();

            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete();

            $table->unsignedInteger('quantity_ordered');
            $table->unsignedInteger('quantity_received')->default(0);

            $table->decimal('unit_cost', 12, 2);
            $table->decimal('line_total', 12, 2);

            $table->timestamps();

            $table->unique(
                ['purchase_order_id', 'book_id'],
                'purchase_order_items_order_book_unique'
            );

            $table->index('book_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};