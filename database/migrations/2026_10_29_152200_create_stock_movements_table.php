<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete();

            $table->foreignId('purchase_order_item_id')
                ->nullable()
                ->constrained('purchase_order_items')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('type');

            // Positive values increase stock; negative values decrease it.
            $table->integer('quantity');

            $table->unsignedInteger('quantity_before');
            $table->unsignedInteger('quantity_after');

            $table->string('reference')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['book_id', 'created_at']);
            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};