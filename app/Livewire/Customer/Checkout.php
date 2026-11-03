<?php

namespace App\Livewire\Customer;

use App\Models\Cart;
use App\Services\CustomerOrderService;
use Livewire\Component;

class Checkout extends Component
{
    public string $customer_name = '';
    public string $customer_phone = '';
    public string $shipping_address = '';
    public string $shipping_city = '';
    public string $shipping_postal_code = '';
    public string $shipping_country = '';
    public string $customer_notes = '';

    public function mount(): void
    {
        $user = auth()->user();
        $this->customer_name = $user->name;
        $this->customer_phone = $user->phone ?? '';
        $this->shipping_address = $user->address ?? '';
        $this->shipping_city = $user->city ?? '';
        $this->shipping_postal_code = $user->postal_code ?? '';
        $this->shipping_country = $user->country ?? '';
    }

    public function placeOrder(CustomerOrderService $orderService)
    {
        $validated = $this->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'shipping_address' => ['required', 'string', 'max:2000'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_postal_code' => ['required', 'string', 'max:30'],
            'shipping_country' => ['required', 'string', 'max:255'],
            'customer_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $order = $orderService->checkout(auth()->user(), $validated);
        return $this->redirectRoute('orders.show', $order);
    }

    public function render()
    {
        $cart = Cart::query()->where('user_id', auth()->id())->with('items.book')->first();
        abort_if(! $cart || $cart->items->isEmpty(),  redirect()->route('cart.index'));
        $subtotal = $cart->items->sum(fn ($item) => (float) ($item->book?->discount_price ?? $item->book?->price ?? 0) * $item->quantity);
        return view('livewire.customer.checkout', compact('cart', 'subtotal'))->layout('layouts.storefront');
    }
}
