<?php

namespace App\Livewire\Customer;

use App\Models\Cart;
use App\Services\CustomerOrderService;
use Livewire\Component;

class Checkout extends Component
{
    private const METRO_MANILA_CITIES = [
        'Caloocan', 'Las Piñas', 'Makati', 'Malabon', 'Mandaluyong', 'Manila',
        'Marikina', 'Muntinlupa', 'Navotas', 'Parañaque', 'Pasay', 'Pasig',
        'Quezon City', 'San Juan', 'Taguig', 'Valenzuela', 'Pateros',
    ];

    public string $customer_name = '';
    public string $customer_phone = '';
    public string $shipping_address = '';
    public string $shipping_barangay = '';
    public string $shipping_city = '';
    public string $shipping_postal_code = '';
    public string $shipping_country = 'Philippines';
    public string $delivery_landmark = '';
    public string $customer_notes = '';

    public function mount(): void
    {
        $user = auth()->user();
        $this->customer_name = $user->name;
        $this->customer_phone = $user->phone ?? '';
        $this->shipping_address = $user->address ?? '';
        $this->shipping_city = in_array($user->city, self::METRO_MANILA_CITIES, true) ? $user->city : '';
        $this->shipping_postal_code = $user->postal_code ?? '';
    }

    public function placeOrder(CustomerOrderService $orderService)
    {
        $validated = $this->validate([
            'customer_name' => ['required', 'string', 'min:2', 'max:255'],
            'customer_phone' => ['required', 'string', 'regex:/^(?:\\+63|0)9\\d{9}$/'],
            'shipping_address' => ['required', 'string', 'min:8', 'max:500'],
            'shipping_barangay' => ['required', 'string', 'max:150'],
            'shipping_city' => ['required', 'string', 'in:' . implode(',', self::METRO_MANILA_CITIES)],
            'shipping_postal_code' => ['required', 'regex:/^\\d{4}$/'],
            'shipping_country' => ['required', 'in:Philippines'],
            'delivery_landmark' => ['nullable', 'string', 'max:255'],
            'customer_notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'customer_phone.regex' => 'Enter a Philippine mobile number, such as 09XXXXXXXXX or +639XXXXXXXXX.',
            'shipping_city.in' => 'We currently deliver only within Metro Manila. Please select a listed city or municipality.',
            'shipping_postal_code.regex' => 'Enter the four-digit postal code for your Metro Manila address.',
            'shipping_country.in' => 'Delivery is currently available only in the Philippines, within Metro Manila.',
        ]);

        $order = $orderService->checkout(auth()->user(), $validated);

        return $this->redirectRoute('orders.show', $order);
    }

    public function render()
    {
        $cart = Cart::query()->where('user_id', auth()->id())->with('items.book')->first();
        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $subtotal = $cart->items->sum(fn ($item) => (float) ($item->book?->discount_price ?? $item->book?->price ?? 0) * $item->quantity);

        return view('livewire.customer.checkout', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'metroManilaCities' => self::METRO_MANILA_CITIES,
        ])->layout('layouts.storefront');
    }
}
