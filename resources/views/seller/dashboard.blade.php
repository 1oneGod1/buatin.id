<x-layouts.app title="Dashboard Seller - PesanKustom.id">
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
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Seller Dashboard</p>
                <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-ink">Halo, {{ explode(' ', $seller->brand_name)[0] }} 👋</h1>
                <p class="mt-2 text-muted">Pantau performa toko & pesanan custom hari ini. Paket aktif: <strong class="font-extrabold text-brand-deep">{{ $seller->planLabel() }}</strong>.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('public.store', $seller) }}" class="rounded-2xl border-[1.5px] border-line bg-white px-4 py-2.5 text-sm font-bold text-ink hover:border-brand">Lihat halaman publik</a>
                <a href="{{ route('seller.products.index') }}" class="rounded-2xl bg-brand-soft px-4 py-2.5 text-sm font-extrabold text-brand-deep hover:bg-brand-soft/70">Tambah produk</a>
                <a href="{{ route('seller.page-builder') }}" class="rounded-2xl bg-brand px-4 py-2.5 text-sm font-extrabold text-white shadow-[0_10px_20px_-9px_rgba(7,168,107,0.8)] hover:bg-brand-deep">Edit halaman</a>
            </div>
        </div>

        <div class="mt-8 rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
            <div class="flex flex-col justify-between gap-3 md:flex-row md:items-center">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Setup toko</p>
                    <h2 class="mt-1 text-2xl font-extrabold text-ink">{{ $completedSetup }}/{{ count($setupItems) }} langkah siap</h2>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-line md:w-72">
                    <div class="h-full rounded-full bg-brand" style="width: {{ ($completedSetup / count($setupItems)) * 100 }}%"></div>
                </div>
            </div>
            <div class="mt-5 grid gap-3 md:grid-cols-5">
                @foreach ($setupItems as [$label, $done, $url])
                    <a href="{{ $url }}" class="rounded-2xl border p-4 text-sm font-extrabold {{ $done ? 'border-brand/30 bg-brand-soft text-brand-deep' : 'border-line bg-cream text-muted' }}">
                        <span class="mb-2 grid size-7 place-items-center rounded-xl text-xs {{ $done ? 'bg-brand text-white' : 'border border-line bg-white text-faint' }}">{{ $done ? '✓' : $loop->iteration }}</span>
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ([
                ['Kunjungan', $stats['visits'], 'Halaman dibuka', '👁️', 'bg-sky-soft', 'text-ink'],
                ['Produk', $stats['products'], 'Tampil di katalog', '📦', 'bg-brand-soft', 'text-ink'],
                ['Order baru', $stats['new_orders'], 'Perlu diproses', '🔔', 'bg-sunny-soft', 'text-brand'],
                ['Belum bayar', $stats['pending_payment'], 'Follow up pembeli', '💳', 'bg-coral-soft', 'text-coral-ink'],
                ['Selesai', $stats['completed'], 'Semua waktu', '✅', 'bg-lilac-soft', 'text-ink'],
            ] as [$label, $value, $hint, $icon, $iconbg, $numcolor])
                <div class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                    <div class="flex items-center gap-2.5">
                        <span class="grid size-9 place-items-center rounded-xl text-base {{ $iconbg }}">{{ $icon }}</span>
                        <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">{{ $label }}</p>
                    </div>
                    <p class="mt-3 text-4xl font-extrabold tracking-tight {{ $numcolor }}">{{ $value }}</p>
                    <p class="mt-1 text-sm font-semibold text-faint">{{ $hint }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-[340px_1fr]">
            <div class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                <h2 class="text-lg font-extrabold text-ink">Aksi cepat</h2>
                <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-2">
                    <a href="{{ route('seller.page-builder') }}" class="rounded-2xl bg-brand-soft p-4 text-center text-sm font-extrabold text-brand-deep">Edit<br>Halaman</a>
                    <a href="{{ route('seller.products.index') }}" class="rounded-2xl bg-sunny-soft p-4 text-center text-sm font-extrabold text-sunny-ink">Tambah<br>Produk</a>
                    <a href="{{ route('seller.form-builder') }}" class="rounded-2xl bg-sky-soft p-4 text-center text-sm font-extrabold text-sky-ink">Atur<br>Form</a>
                    <a href="{{ route('seller.payment') }}" class="rounded-2xl bg-coral-soft p-4 text-center text-sm font-extrabold text-coral-ink">Atur<br>QRIS</a>
                    <a href="{{ route('seller.subscription') }}" class="rounded-2xl bg-lilac-soft p-4 text-center text-sm font-extrabold text-lilac-ink">Paket<br>Premium</a>
                </div>
                <div class="mt-5 rounded-2xl border border-sunny/40 bg-sunny-soft p-4 text-sm leading-6 text-sunny-ink">
                    <p class="font-extrabold">Alur penjual yang disarankan</p>
                    <p class="mt-1">Isi profil toko → tambah produk katalog → atur field brief → bagikan link publik.</p>
                </div>
                <div class="mt-5 rounded-2xl bg-cream p-4">
                    <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Link publik</p>
                    <p class="mt-2 break-all font-mono text-sm font-bold text-brand-deep">{{ $seller->public_url }}</p>
                </div>
            </div>

            <div class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-extrabold text-ink">Pesanan terbaru</h2>
                    <a href="{{ route('seller.orders.index') }}" class="text-sm font-extrabold text-brand-deep hover:underline">Lihat semua</a>
                </div>
                <div class="mt-3 divide-y divide-line">
                    @forelse ($orders as $order)
                        @php($pc = match($order->payment_status) { 'paid' => 'bg-brand-soft text-brand-deep', 'proof_uploaded' => 'bg-sunny-soft text-sunny-ink', default => 'bg-coral-soft text-coral-ink' })
                        <a href="{{ route('seller.orders.show', $order) }}" class="flex items-center justify-between gap-4 py-4 hover:opacity-80">
                            <div>
                                <p class="font-extrabold text-ink">{{ $order->customer_name }}</p>
                                <p class="text-sm text-muted">{{ $order->product_type }} · <span class="font-mono">{{ $order->order_code }}</span></p>
                            </div>
                            <span class="shrink-0 rounded-full px-3 py-1 text-xs font-extrabold {{ $pc }}">{{ $order->payment_status_label }}</span>
                        </a>
                    @empty
                        <div class="rounded-2xl bg-cream p-6 text-center text-muted">
                            Belum ada pesanan. Coba buka halaman publik dan buat order demo.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
