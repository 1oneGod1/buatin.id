<x-layouts.app title="Daftar Pesanan - PesanKustom.id">
    <section class="mx-auto max-w-6xl px-4 py-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Order Management</p>
                <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-ink">Daftar pesanan</h1>
                <p class="mt-2 text-muted">Semua brief pelanggan yang masuk lewat halaman publik {{ $seller->brand_name }}.</p>
            </div>
            <a href="{{ route('public.store', $seller) }}" class="rounded-2xl bg-brand px-4 py-2.5 text-sm font-extrabold text-white shadow-[0_10px_20px_-9px_rgba(7,168,107,0.8)] hover:bg-brand-deep">Buka toko publik</a>
        </div>

        <div class="mt-8 overflow-hidden rounded-[22px] border border-line bg-white shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
            <div class="hidden grid-cols-[1.2fr_2fr_1.3fr_1fr] gap-4 border-b border-line bg-cream px-5 py-3 text-[11px] font-extrabold uppercase tracking-wide text-faint sm:grid">
                <span>Order</span><span>Pelanggan</span><span>Status</span><span class="text-right">Total</span>
            </div>
            @forelse ($orders as $order)
                @php($sc = match($order->status) {
                    'completed' => 'bg-brand text-white',
                    'ready' => 'bg-brand-soft text-brand-deep',
                    'processing' => 'bg-lilac-soft text-lilac-ink',
                    'waiting_payment' => 'bg-sunny-soft text-sunny-ink',
                    'cancelled' => 'bg-cream text-faint',
                    default => 'bg-sky-soft text-sky-ink',
                })
                <a href="{{ route('seller.orders.show', $order) }}" class="grid grid-cols-2 gap-3 border-b border-line px-5 py-4 text-sm last:border-0 hover:bg-brand-soft/30 sm:grid-cols-[1.2fr_2fr_1.3fr_1fr] sm:items-center">
                    <span class="font-mono font-extrabold text-brand-deep">{{ $order->order_code }}</span>
                    <span class="order-3 col-span-2 sm:order-none sm:col-span-1">
                        <strong class="font-extrabold text-ink">{{ $order->customer_name }}</strong>
                        <span class="block text-muted">{{ $order->product_type }}</span>
                    </span>
                    <span><span class="inline-block rounded-full px-3 py-1 text-xs font-extrabold {{ $sc }}">{{ $order->status_label }}</span></span>
                    <span class="text-right font-extrabold text-ink">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</span>
                </a>
            @empty
                <div class="p-8 text-center text-muted">Belum ada pesanan.</div>
            @endforelse
        </div>

        <div class="mt-6">{{ $orders->links() }}</div>
    </section>
</x-layouts.app>
