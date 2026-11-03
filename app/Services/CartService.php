<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function add(int $userId, int $bookId, int $quantity = 1): CartItem
    {
        return DB::transaction(function () use ($userId, $bookId, $quantity) {
            $book = Book::query()->whereHas('product', fn ($query) => $query->where('is_active', true))
                ->lockForUpdate()->findOrFail($bookId);

            if ($quantity < 1 || $book->stock < 1) {
                throw ValidationException::withMessages(['cart' => 'This book is currently out of stock.']);
            }

            $cart = Cart::firstOrCreate(['user_id' => $userId]);
            $item = $cart->items()->firstOrNew(['book_id' => $book->id]);
            $newQuantity = (int) $item->quantity + $quantity;

            if ($newQuantity > $book->stock) {
                throw ValidationException::withMessages(['cart' => "Only {$book->stock} copies of this book are available."]);
            }

            $item->quantity = $newQuantity;
            $item->save();

            return $item;
        }, 3);
    }
}
