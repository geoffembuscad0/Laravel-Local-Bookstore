<div class="min-h-screen bg-slate-50 text-slate-800">
    <header class="border-b bg-white"><nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4"><a href="{{ route('home') }}" class="text-xl font-bold text-indigo-700">Local Bookstore</a><div class="flex gap-4 text-sm"><a href="{{ route('home') }}">Shop</a><a href="{{ route('cart.index') }}">Cart</a><a href="{{ route('orders.index') }}" class="font-semibold text-indigo-700">My orders</a></div></nav></header>
    <main class="mx-auto max-w-4xl px-4 py-8">
        <a href="{{ route('orders.index') }}" class="text-sm text-indigo-700">← My orders</a>
        @if (session('success'))<div class="mt-4 rounded-lg bg-emerald-50 p-4 text-emerald-800">{{ session('success') }}</div>@endif
        @error('order')<div class="mt-4 rounded-lg bg-red-50 p-4 text-red-700">{{ $message }}</div>@enderror
        <section class="mt-5 rounded-xl border bg-white p-6 shadow-sm">
            <div class="flex flex-wrap justify-between gap-3"><div><p class="text-sm text-slate-500">Order number</p><h1 class="text-2xl font-bold">{{ $order->order_number }}</h1><p class="mt-1 text-sm text-slate-500">Placed {{ $order->placed_at?->format('M j, Y g:i A') }}</p></div><span class="h-fit rounded-full bg-indigo-50 px-3 py-1 text-sm font-semibold text-indigo-800">{{ $order->status_label }}</span></div>
            @if ($order->status !== 'cancelled')
                <div class="mt-8 grid grid-cols-4 gap-2 text-center text-xs sm:text-sm">
                    @php($currentStep = array_search($order->status, $progressStatuses, true))
                    @foreach ($progressStatuses as $index => $step)
                        <div><div class="mx-auto mb-2 flex h-8 w-8 items-center justify-center rounded-full {{ $currentStep !== false && $index <= $currentStep ? 'bg-indigo-700 text-white' : 'bg-slate-200 text-slate-500' }}">{{ $index + 1 }}</div><span class="{{ $currentStep !== false && $index === $currentStep ? 'font-semibold text-indigo-800' : 'text-slate-500' }}">{{ $statusLabels[$step] }}</span></div>
                    @endforeach
                </div>
            @else
                <div class="mt-6 rounded-lg bg-red-50 p-4 text-sm text-red-800">This order was cancelled. No payment is due.</div>
            @endif
        </section>
        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <section class="rounded-xl border bg-white p-6 shadow-sm"><h2 class="font-semibold">Delivery address</h2><p class="mt-3 text-sm leading-6">{{ $order->customer_name }}<br>{{ $order->customer_phone }}<br>{{ $order->shipping_address }}<br>Barangay {{ $order->shipping_barangay }}, {{ $order->shipping_city }} {{ $order->shipping_postal_code }}<br>{{ $order->shipping_country }}</p>@if($order->delivery_landmark)<p class="mt-2 text-sm text-slate-600">Landmark: {{ $order->delivery_landmark }}</p>@endif</section>
            <section class="rounded-xl border bg-white p-6 shadow-sm"><h2 class="font-semibold">Payment</h2><p class="mt-3 text-sm">Cash on Delivery</p><p class="text-sm text-slate-500">{{ $order->payment_status === 'unpaid' ? 'Payment is due in cash when the order is delivered.' : ucfirst($order->payment_status) }}</p><p class="mt-3 text-xl font-bold">₱{{ number_format((float) $order->total_amount, 2) }}</p></section>
        </div>
        <section class="mt-6 rounded-xl border bg-white p-6 shadow-sm"><h2 class="font-semibold">Books in this order</h2><div class="mt-4 divide-y">@foreach ($order->items as $item)<div class="flex justify-between gap-4 py-3 text-sm"><span>{{ $item->book_title }} × {{ $item->quantity }}</span><span>₱{{ number_format((float) $item->line_total, 2) }}</span></div>@endforeach</div></section>
        @if ($order->customer_notes)<section class="mt-6 rounded-xl border bg-white p-6 shadow-sm"><h2 class="font-semibold">Delivery instructions</h2><p class="mt-2 text-sm text-slate-600">{{ $order->customer_notes }}</p></section>@endif
        @if ($order->status === 'pending')<button wire:click="cancel" wire:confirm="Cancel this order? The reserved books will be returned to stock." class="mt-6 rounded-lg border border-red-300 px-4 py-2 font-medium text-red-700 hover:bg-red-50">Cancel pending order</button><p class="mt-2 text-xs text-slate-500">You can cancel while the order is pending. Once preparation starts, please contact the bookstore for help.</p>@endif
    </main>
</div>
