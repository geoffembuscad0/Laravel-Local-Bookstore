<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = auth()->user()->orders()->withCount('items')->latest()->paginate(10);
        return view('livewire.customer.order-index', compact('orders'))->layout('layouts.storefront');
    }
}
