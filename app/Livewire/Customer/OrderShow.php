<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use App\Services\CustomerOrderService;
use Livewire\Component;

class OrderShow extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        abort_unless($order->user_id === auth()->id(), 404);
        $this->order = $order->load('items');
    }

    public function cancel(CustomerOrderService $orderService): void
    {
        $orderService->cancel($this->order, auth()->user());
        $this->order->refresh()->load('items');
        session()->flash('success', 'Your order has been cancelled.');
    }

    public function render()
    {
        return view('livewire.customer.order-show', [
            'statusLabels' => Order::STATUS_LABELS,
            'progressStatuses' => ['pending', 'processing', 'out_for_delivery', 'delivered'],
        ])->layout('layouts.storefront');
    }
}
