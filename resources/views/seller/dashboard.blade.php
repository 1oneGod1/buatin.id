<x-layouts.app title="Dashboard Seller - Buatin.id">
    <section class="mx-auto max-w-6xl px-4 py-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-sm font-bold text-emerald-700">Seller Dashboard</p>
                <h1 class="mt-1 text-3xl font-black">Halo, {{ explode(' ', $seller->brand_name)[0] }}</h1>
                <p class="mt-2 text-slate-600">Pantau performa toko dan pesanan custom hari ini.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('public.store', $seller) }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700">Lihat halaman publik</a>
                <a href="{{ route('seller.page-builder') }}" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-bold text-white">Edit halaman</a>
            </div>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([['Kunjungan', $stats['visits'], '+12% dari kemarin'], ['Order baru', $stats['new_orders'], 'Perlu diproses'], ['Belum bayar', $stats['pending_payment'], 'Follow up pembeli'], ['Selesai', $stats['completed'], 'Bulan ini']] as [$label, $value, $hint])
                <div class="rounded-[1.5rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <p class="text-xs font-black uppercase tracking-wide text-slate-500">{{ $label }}</p>
                    <p class="mt-3 text-4xl font-black {{ $label === 'Order baru' ? 'text-emerald-600' : ($label === 'Belum bayar' ? 'text-red-600' : 'text-slate-950') }}">{{ $value }}</p>
                    <p class="mt-1 text-sm font-semibold text-slate-500">{{ $hint }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[340px_1fr]">
            <div class="rounded-[1.5rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <h2 class="text-lg font-black">Aksi cepat</h2>
                <div class="mt-4 grid grid-cols-3 gap-3">
                    <a href="{{ route('seller.page-builder') }}" class="rounded-2xl bg-emerald-50 p-4 text-center text-sm font-bold text-emerald-800">Edit<br>Halaman</a>
                    <a href="{{ route('seller.form-builder') }}" class="rounded-2xl bg-blue-50 p-4 text-center text-sm font-bold text-blue-800">Atur<br>Form</a>
                    <a href="{{ route('seller.payment') }}" class="rounded-2xl bg-amber-50 p-4 text-center text-sm font-bold text-amber-800">Atur<br>QRIS</a>
                </div>
                <div class="mt-6 rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs font-black uppercase text-slate-500">Link publik</p>
                    <p class="mt-2 break-all text-sm font-bold text-emerald-700">{{ $seller->public_url }}</p>
                </div>
            </div>

            <div class="rounded-[1.5rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-black">Pesanan terbaru</h2>
                    <a href="{{ route('seller.orders.index') }}" class="text-sm font-bold text-emerald-700">Lihat semua</a>
                </div>
                <div class="mt-4 divide-y divide-slate-100">
                    @forelse ($orders as $order)
                        <a href="{{ route('seller.orders.show', $order) }}" class="flex items-center justify-between gap-4 py-4">
                            <div>
                                <p class="font-black">{{ $order->customer_name }}</p>
                                <p class="text-sm text-slate-500">{{ $order->product_type }} · {{ $order->order_code }}</p>
                            </div>
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-black text-amber-800">{{ $order->payment_status_label }}</span>
                        </a>
                    @empty
                        <div class="rounded-2xl bg-slate-50 p-6 text-center text-slate-500">
                            Belum ada pesanan. Coba buka halaman publik dan buat order demo.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
