<x-layouts.app title="Dashboard Seller - Buatin.id">
    <section class="mx-auto max-w-6xl px-4 py-8">
        @php
            $setupItems = [
                ['Profil toko', filled($seller->brand_name) && filled($seller->whatsapp), route('seller.page-builder')],
                ['Produk katalog', $seller->products->count() > 0, route('seller.products.index')],
                ['Form brief', filled($seller->form_fields), route('seller.form-builder')],
                ['QRIS pembayaran', $seller->qris_enabled && filled($seller->qris_path), route('seller.payment')],
                ['Link publik', true, route('public.store', $seller)],
            ];
            $completedSetup = collect($setupItems)->where(1, true)->count();
        @endphp
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-sm font-bold text-emerald-700">Seller Dashboard</p>
                <h1 class="mt-1 text-3xl font-black">Halo, {{ explode(' ', $seller->brand_name)[0] }}</h1>
                <p class="mt-2 text-slate-600">Pantau performa toko dan pesanan custom hari ini. Paket aktif: <strong class="text-emerald-700">{{ $seller->planLabel() }}</strong>.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('public.store', $seller) }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700">Lihat halaman publik</a>
                <a href="{{ route('seller.products.index') }}" class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-800">Tambah produk custom</a>
                <a href="{{ route('seller.page-builder') }}" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-bold text-white">Edit halaman</a>
            </div>
        </div>

        <div class="mt-8 rounded-[1.5rem] border border-emerald-100 bg-white p-5 shadow-sm">
            <div class="flex flex-col justify-between gap-3 md:flex-row md:items-center">
                <div>
                    <p class="text-sm font-black uppercase tracking-wide text-emerald-700">Setup toko</p>
                    <h2 class="mt-1 text-2xl font-black text-slate-950">{{ $completedSetup }}/{{ count($setupItems) }} langkah siap</h2>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-slate-100 md:w-72">
                    <div class="h-full rounded-full bg-emerald-600" style="width: {{ ($completedSetup / count($setupItems)) * 100 }}%"></div>
                </div>
            </div>
            <div class="mt-5 grid gap-3 md:grid-cols-5">
                @foreach ($setupItems as [$label, $done, $url])
                    <a href="{{ $url }}" class="rounded-2xl border p-4 text-sm font-bold {{ $done ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : 'border-slate-200 bg-slate-50 text-slate-600' }}">
                        <span class="mb-2 grid size-7 place-items-center rounded-full {{ $done ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">{{ $done ? 'OK' : $loop->iteration }}</span>
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ([['Kunjungan', $stats['visits'], 'Halaman publik dibuka'], ['Produk', $stats['products'], 'Tampil di katalog'], ['Order baru', $stats['new_orders'], 'Perlu diproses'], ['Belum bayar', $stats['pending_payment'], 'Follow up pembeli'], ['Selesai', $stats['completed'], 'Bulan ini']] as [$label, $value, $hint])
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
                <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-2">
                    <a href="{{ route('seller.page-builder') }}" class="rounded-2xl bg-emerald-50 p-4 text-center text-sm font-bold text-emerald-800">Edit<br>Halaman</a>
                    <a href="{{ route('seller.products.index') }}" class="rounded-2xl bg-lime-50 p-4 text-center text-sm font-bold text-lime-800">Tambah<br>Produk</a>
                    <a href="{{ route('seller.form-builder') }}" class="rounded-2xl bg-blue-50 p-4 text-center text-sm font-bold text-blue-800">Atur<br>Form</a>
                    <a href="{{ route('seller.payment') }}" class="rounded-2xl bg-amber-50 p-4 text-center text-sm font-bold text-amber-800">Atur<br>QRIS</a>
                    <a href="{{ route('seller.subscription') }}" class="rounded-2xl bg-violet-50 p-4 text-center text-sm font-bold text-violet-800">Paket<br>Premium</a>
                </div>
                <div class="mt-5 rounded-2xl bg-amber-50 p-4 text-sm leading-6 text-amber-900">
                    <p class="font-black">Alur penjual yang disarankan</p>
                    <p class="mt-1">Isi profil toko, tambah produk custom sebagai katalog, atur field brief, lalu bagikan link publik.</p>
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
                                <p class="text-sm text-slate-500">{{ $order->product_type }} - {{ $order->order_code }}</p>
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
