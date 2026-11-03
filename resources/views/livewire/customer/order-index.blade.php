<div class="min-h-screen bg-slate-50 text-slate-800">
    <header class="border-b bg-white"><nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4"><a href="{{ route('home') }}" class="text-xl font-bold text-indigo-700">Local Bookstore</a><div class="flex gap-4 text-sm"><a href="{{ route('home') }}">Shop</a><a href="{{ route('cart.index') }}">Cart</a><a href="{{ route('orders.index') }}" class="font-semibold text-indigo-700">My orders</a></div></nav></header>
    <main class="mx-auto max-w-6xl px-4 py-8">
        <h1 class="text-3xl font-bold">My orders</h1><p class="mt-1 text-slate-600">Track your local delivery and COD payment status.</p>
        <div class="mt-6 space-y-4">
            @forelse ($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="block rounded-xl border bg-white p-5 shadow-sm hover:border-indigo-300">
                    <div class="flex flex-wrap items-start justify-between gap-3"><div><p class="font-semibold">{{ $order->order_number }}</p><p class="mt-1 text-sm text-slate-500">{{ $order->placed_at?->format('M j, Y g:i A') }} · {{ $order->items_count }} {{ \Illuminate\Support\Str::plural('book', $order->items_count) }}</p></div><span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-800">{{ $order->status_label }}</span></div>
                    <div class="mt-4 flex flex-wrap justify-between gap-2 border-t pt-4 text-sm"><span>Cash on Delivery · {{ ucfirst($order->payment_status) }}</span><strong>₱{{ number_format((float) $order->total_amount, 2) }}</strong></div>
                </a>
            @empty
                <div class="rounded-xl border bg-white p-8 text-center"><p class="font-semibold">No orders yet</p><p class="mt-1 text-sm text-slate-600">Browse the catalog and place your first order for Metro Manila delivery.</p><a href="{{ route('home') }}" class="mt-4 inline-block rounded-lg bg-indigo-700 px-4 py-2 text-white">Browse books</a></div>
            @endforelse
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    </main>
</div>
