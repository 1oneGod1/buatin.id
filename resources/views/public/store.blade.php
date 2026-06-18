<x-layouts.app :title="$seller->brand_name.' | PesanKustom.id'">
    @php($storage = app(\App\Services\Firebase\FirebaseStorageService::class))

    {{-- HERO --}}
    <section class="mx-auto max-w-6xl px-4 py-8 lg:py-12">
        <div class="grid gap-8 lg:grid-cols-[1fr_400px] lg:items-center">
            <div class="min-w-0">
                <div class="flex flex-wrap gap-2 text-xs font-extrabold">
                    <span class="rounded-full bg-brand-soft px-3 py-1.5 text-brand-deep">{{ $seller->category }}</span>
                    <span class="rounded-full bg-sky-soft px-3 py-1.5 text-sky-ink">{{ $seller->location ?: 'Indonesia' }}</span>
                </div>
                <h1 class="mt-5 max-w-3xl break-words text-4xl font-extrabold leading-[1.05] tracking-tight text-ink md:text-5xl">
                    {{ $seller->brand_name }}
                </h1>
                <p class="mt-4 max-w-2xl text-base font-medium leading-7 text-muted md:text-lg">{{ $seller->description }}</p>
                <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('public.order.create', $seller) }}" class="rounded-2xl bg-ink px-6 py-3.5 text-center text-sm font-extrabold text-white shadow-[0_14px_26px_-12px_rgba(22,33,28,0.6)] hover:opacity-90">
                        Buat Brief Pesanan
                    </a>
                    <a href="{{ route('orders.lookup') }}" class="rounded-2xl border-[1.5px] border-line bg-white px-6 py-3.5 text-center text-sm font-extrabold text-ink hover:border-brand">
                        Cek Status Order
                    </a>
                </div>
                <div class="mt-7 grid max-w-2xl gap-3 sm:grid-cols-3">
                    @foreach ([
                        ['Produk acuan', $seller->products->count().' pilihan'],
                        ['Kontak penjual', $seller->whatsapp],
                        ['Pembayaran', $seller->qris_enabled ? 'QRIS tersedia ✓' : 'Konfirmasi WA'],
                    ] as [$label, $value])
                        <div class="rounded-2xl border border-line bg-white px-4 py-3 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                            <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">{{ $label }}</p>
                            <p class="mt-1 truncate text-sm font-extrabold text-ink">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <aside class="min-w-0">
                <div class="rounded-[28px] border border-line bg-white p-3 shadow-[0_34px_60px_-30px_rgba(22,33,28,0.45)]">
                    <div class="overflow-hidden rounded-[22px] bg-cream">
                        <div class="relative h-40 overflow-hidden bg-gradient-to-br from-brand-deep via-brand to-[#2bd08a] p-5 text-white">
                            <span class="pointer-events-none absolute -right-4 -top-8 select-none text-[120px] font-extrabold leading-none text-white/15">{{ strtoupper(mb_substr($seller->brand_name, 0, 1)) }}</span>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="rounded-full bg-white/20 px-2.5 py-1 text-[10px] font-extrabold backdrop-blur">{{ $seller->category }}</span>
                                <span class="rounded-full bg-white/20 px-2.5 py-1 text-[10px] font-extrabold backdrop-blur">{{ $seller->location ?: 'Indonesia' }}</span>
                            </div>
                            <div class="relative mt-7 text-xl font-extrabold">{{ $seller->brand_name }}</div>
                            <div class="relative line-clamp-1 text-xs text-white/85">{{ $seller->description }}</div>
                        </div>
                        @if ($seller->products->count())
                            <div class="grid grid-cols-3 divide-x divide-line">
                                @foreach ($seller->products->take(3) as $product)
                                    <div class="p-3">
                                        <p class="text-[10px] font-extrabold uppercase tracking-wide text-brand">{{ $product->category }}</p>
                                        <p class="mt-0.5 line-clamp-2 text-xs font-extrabold text-ink">{{ $product->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="border-t border-line p-3">
                            <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Order custom dimulai dari</p>
                            <p class="mt-0.5 text-base font-extrabold text-ink">{{ $seller->products->first()?->name ?: 'Brief produk custom' }}</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="mx-auto max-w-6xl px-4">
        <div class="grid gap-4 rounded-[26px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)] md:grid-cols-4 md:p-6">
            @foreach ([
                ['Pilih acuan', 'Ambil contoh produk dari katalog.', 'bg-brand-soft text-brand-deep'],
                ['Isi tipe custom', 'Jelaskan jenis pesanan yang mau dibuat.', 'bg-sunny-soft text-sunny-ink'],
                ['Kirim brief', 'Sertakan ukuran, bahan, warna, referensi.', 'bg-lilac-soft text-lilac-ink'],
                ['Pantau status', 'Cek pembayaran dan progres order.', 'bg-sky-soft text-sky-ink'],
            ] as [$title, $copy, $accent])
                <div class="flex gap-3">
                    <div class="grid size-9 shrink-0 place-items-center rounded-xl text-sm font-extrabold {{ $accent }}">{{ $loop->iteration }}</div>
                    <div>
                        <p class="font-extrabold text-ink">{{ $title }}</p>
                        <p class="mt-1 text-sm leading-6 text-muted">{{ $copy }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CATALOG --}}
    <section class="mx-auto max-w-6xl px-4 py-10">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Katalog &amp; Portfolio</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink">Pilih produk acuan, lalu custom sesuai kebutuhan.</h2>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">Produk di bawah hanya titik awal. Detail akhir tetap bisa kamu tulis di form brief.</p>
            </div>
            <a href="{{ route('public.order.create', $seller) }}" class="shrink-0 rounded-2xl bg-brand px-5 py-3 text-sm font-extrabold text-white shadow-[0_12px_22px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Mulai Brief Custom</a>
        </div>

        <div class="mt-7 grid gap-5 md:grid-cols-3">
            @forelse ($seller->products as $product)
                <article class="group overflow-hidden rounded-[22px] border border-line bg-white shadow-[0_2px_6px_rgba(22,33,28,0.05)] transition hover:-translate-y-1.5 hover:shadow-[0_26px_40px_-22px_rgba(22,33,28,0.45)]">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        @if ($product->image_path)
                            <img src="{{ $storage->url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="grid h-full place-items-center" style="background-color:#eaf6f0;background-image:repeating-linear-gradient(45deg,rgba(7,168,107,.10) 0 10px,transparent 10px 20px)">
                                <span class="grid size-14 place-items-center rounded-2xl bg-white text-brand shadow-sm ring-1 ring-line transition duration-300 group-hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                    </svg>
                                </span>
                            </div>
                        @endif
                        @if ($product->is_featured)
                            <span class="absolute left-3 top-3 rounded-full bg-coral px-2.5 py-1 text-[10px] font-extrabold text-white shadow-sm">★ Unggulan</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-[11px] font-extrabold uppercase tracking-wide text-brand">{{ $product->category }}</p>
                        <div class="mt-1 flex items-start justify-between gap-3">
                            <h3 class="text-lg font-extrabold leading-tight text-ink">{{ $product->name }}</h3>
                            <p class="shrink-0 rounded-xl bg-sunny-soft px-2.5 py-1.5 text-xs font-extrabold text-sunny-ink">Rp{{ number_format($product->starting_price, 0, ',', '.') }}+</p>
                        </div>
                        <p class="mt-2 min-h-10 text-sm leading-6 text-muted">{{ $product->description }}</p>
                        <a href="{{ route('public.order.create', $seller) }}" class="mt-4 block rounded-xl bg-ink px-4 py-3 text-center text-sm font-extrabold text-white hover:opacity-90">
                            Pesan tipe ini
                        </a>
                    </div>
                </article>
            @empty
                <div class="rounded-[22px] border border-dashed border-line bg-white p-8 text-center font-semibold text-muted md:col-span-3">
                    Portfolio belum diisi oleh penjual.
                </div>
            @endforelse
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-auto max-w-6xl px-4 pb-12">
        <div class="grid gap-6 overflow-hidden rounded-[28px] bg-ink p-8 text-white md:grid-cols-[1fr_auto] md:items-center" style="background-image:radial-gradient(circle at 90% 0%,rgba(7,168,107,.35),transparent 45%)">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Siap mulai?</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight">Kirim brief lengkap agar estimasi lebih cepat dihitung.</h2>
                <p class="mt-3 text-sm leading-6 text-white/70">Cocok untuk 3D print, merchandise, hampers, sablon, stiker, kue custom, dan jasa kreatif lain.</p>
            </div>
            <a href="{{ route('public.order.create', $seller) }}" class="rounded-2xl bg-white px-6 py-4 text-center text-sm font-extrabold text-ink hover:bg-brand-soft">
                Isi Form Pesanan
            </a>
        </div>
    </section>
</x-layouts.app>
