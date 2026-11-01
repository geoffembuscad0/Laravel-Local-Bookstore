<?php
namespace App\Enums;

enum StockMovementType: string
{
    case INITIAL_STOCK = 'initial_stock';
    case SALE = 'sale';
    case DAMAGE = 'damage';
    case LOSS = 'loss';
    case ADJUSTMENT = 'adjustment';
    case PURCHASE_RECEIVED = 'purchase_received';
}
