<x-layouts.app title="Daftar Pesanan - PesanKustom.id">
    <section class="mx-auto max-w-6xl px-4 py-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-sm font-bold text-emerald-700">Order Management</p>
                <h1 class="mt-1 text-3xl font-black">Daftar pesanan</h1>
                <p class="mt-2 text-slate-600">Semua brief pelanggan yang masuk melalui halaman publik {{ $seller->brand_name }}.</p>
            </div>
            <a href="{{ route('public.store', $seller) }}" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-bold text-white">Buka toko publik</a>
        </div>

        <div class="mt-8 overflow-hidden rounded-[1.5rem] bg-white shadow-sm ring-1 ring-slate-200">
            <div class="grid grid-cols-5 gap-4 border-b border-slate-100 bg-slate-50 px-5 py-3 text-xs font-black uppercase tracking-wide text-slate-500">
                <span>Order</span><span class="col-span-2">Pelanggan</span><span>Status</span><span class="text-right">Total</span>
            </div>
            @forelse ($orders as $order)
                <a href="{{ route('seller.orders.show', $order) }}" class="grid grid-cols-5 gap-4 px-5 py-4 text-sm hover:bg-emerald-50/40">
                    <span class="font-black text-emerald-700">{{ $order->order_code }}</span>
                    <span class="col-span-2">
                        <strong>{{ $order->customer_name }}</strong>
                        <span class="block text-slate-500">{{ $order->product_type }}</span>
                    </span>
                    <span class="font-bold text-slate-600">{{ $order->status_label }}</span>
                    <span class="text-right font-black">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</span>
                </a>
            @empty
                <div class="p-8 text-center text-slate-500">Belum ada pesanan.</div>
            @endforelse
        </div>

        <div class="mt-6">{{ $orders->links() }}</div>
    </section>
</x-layouts.app>
