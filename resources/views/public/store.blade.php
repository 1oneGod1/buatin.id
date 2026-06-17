<x-layouts.app :title="$seller->brand_name.' | PesanKustom.id'">
    <section class="bg-white">
        <div class="mx-auto max-w-6xl px-4 py-8 lg:py-12">
            <div class="grid gap-8 lg:grid-cols-[1fr_440px] lg:items-center">
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2 text-sm font-bold">
                        <span class="rounded-lg bg-emerald-50 px-3 py-2 text-emerald-800">{{ $seller->category }}</span>
                        <span class="rounded-lg bg-sky-50 px-3 py-2 text-sky-800">{{ $seller->location ?: 'Indonesia' }}</span>
                    </div>
                    <h1 class="mt-5 max-w-3xl break-words text-4xl font-black leading-tight text-slate-950 md:text-5xl">
                        {{ $seller->brand_name }}
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-8 text-slate-600 md:text-lg">
                        {{ $seller->description }}
                    </p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('public.order.create', $seller) }}" class="rounded-lg bg-slate-950 px-5 py-3 text-center text-sm font-black text-white shadow-sm hover:bg-slate-800">
                            Buat Brief Pesanan
                        </a>
                        <a href="{{ route('orders.lookup') }}" class="rounded-lg border border-slate-300 bg-white px-5 py-3 text-center text-sm font-black text-slate-800 hover:border-slate-400">
                            Cek Status Order
                        </a>
                    </div>
                    <div class="mt-7 grid max-w-2xl gap-3 sm:grid-cols-3">
                        @foreach ([
                            ['Produk acuan', $seller->products->count().' pilihan'],
                            ['Kontak penjual', $seller->whatsapp],
                            ['Pembayaran', $seller->qris_enabled ? 'QRIS tersedia' : 'Konfirmasi WA'],
                        ] as [$label, $value])
                            <div class="border-l-4 border-emerald-500 bg-slate-50 px-4 py-3">
                                <p class="text-xs font-black uppercase text-slate-500">{{ $label }}</p>
                                <p class="mt-1 text-sm font-black text-slate-950">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <aside class="min-w-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-950 shadow-xl shadow-slate-900/10">
                    <div class="relative h-64 bg-slate-900">
                        @if ($seller->banner_path)
                            <img src="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($seller->banner_path) }}" alt="Banner {{ $seller->brand_name }}" class="h-full w-full object-cover">
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                        @else
                            <div class="relative grid h-full place-items-center overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-800 to-slate-950 px-8 pb-24 text-center text-white">
                                <span class="pointer-events-none absolute -right-5 -top-10 select-none text-[11rem] font-black leading-none text-white/10">{{ strtoupper(mb_substr($seller->brand_name, 0, 1)) }}</span>
                                <div class="relative">
                                    <p class="text-sm font-black uppercase tracking-wide text-emerald-200">Portfolio Preview</p>
                                    <p class="mt-3 text-3xl font-black drop-shadow">{{ $seller->brand_name }}</p>
                                    <p class="mt-3 text-sm leading-6 text-emerald-50/80">Contoh produk, brief, pembayaran, dan status dalam satu halaman.</p>
                                </div>
                            </div>
                        @endif
                        <div class="absolute bottom-4 left-4 right-4 rounded-lg bg-white/95 p-4 shadow-lg backdrop-blur">
                            <p class="text-xs font-black uppercase text-slate-500">Order custom dimulai dari</p>
                            <p class="mt-1 text-lg font-black text-slate-950">{{ $seller->products->first()?->name ?: 'Brief produk custom' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 divide-x divide-slate-800 bg-slate-950 text-white">
                        @foreach ($seller->products->take(3) as $product)
                            <div class="p-4">
                                <p class="text-xs font-black text-emerald-300">{{ $product->category }}</p>
                                <p class="mt-1 line-clamp-2 text-sm font-bold text-white">{{ $product->name }}</p>
                            </div>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-slate-50">
        <div class="mx-auto grid max-w-6xl gap-4 px-4 py-7 md:grid-cols-4">
            @foreach ([
                ['Pilih acuan', 'Ambil contoh produk dari katalog.'],
                ['Isi tipe custom', 'Jelaskan jenis pesanan yang mau dibuat.'],
                ['Kirim brief', 'Sertakan ukuran, bahan, warna, dan referensi.'],
                ['Pantau status', 'Cek pembayaran dan progres order.'],
            ] as [$title, $copy])
                <div class="flex gap-3">
                    <div class="grid size-9 shrink-0 place-items-center rounded-lg bg-white text-sm font-black text-emerald-700 ring-1 ring-slate-200">{{ $loop->iteration }}</div>
                    <div>
                        <p class="font-black text-slate-950">{{ $title }}</p>
                        <p class="mt-1 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-10">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-black uppercase text-emerald-700">Katalog & Portfolio</p>
                <h2 class="mt-2 text-3xl font-black text-slate-950">Pilih produk acuan, lalu custom sesuai kebutuhan.</h2>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Produk di bawah hanya titik awal. Detail akhir tetap bisa kamu tulis di form brief.</p>
            </div>
            <a href="{{ route('public.order.create', $seller) }}" class="rounded-lg bg-emerald-600 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">Mulai Brief Custom</a>
        </div>

        <div class="mt-7 grid gap-5 md:grid-cols-3">
            @forelse ($seller->products as $product)
                <article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                        @if ($product->image_path)
                            <img src="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="grid h-full place-items-center bg-gradient-to-br from-emerald-50 via-white to-amber-50">
                                <span class="grid size-16 place-items-center rounded-2xl bg-white text-emerald-600 shadow-sm ring-1 ring-slate-200 transition duration-300 group-hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                    </svg>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-black uppercase text-emerald-700">{{ $product->category }}</p>
                                <h3 class="mt-1 text-lg font-black text-slate-950">{{ $product->name }}</h3>
                            </div>
                            <p class="shrink-0 rounded-lg bg-amber-50 px-3 py-2 text-sm font-black text-amber-800">Rp{{ number_format($product->starting_price, 0, ',', '.') }}+</p>
                        </div>
                        <p class="mt-3 min-h-12 text-sm leading-6 text-slate-600">{{ $product->description }}</p>
                        <a href="{{ route('public.order.create', $seller) }}" class="mt-5 inline-flex w-full justify-center rounded-lg border border-slate-300 px-4 py-3 text-sm font-black text-slate-800 hover:border-emerald-400 hover:text-emerald-700">
                            Pesan tipe ini
                        </a>
                    </div>
                </article>
            @empty
                <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600 md:col-span-3">
                    Portfolio belum diisi oleh penjual.
                </div>
            @endforelse
        </div>
    </section>

    <section class="bg-slate-950 text-white">
        <div class="mx-auto grid max-w-6xl gap-6 px-4 py-10 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <p class="text-sm font-black uppercase text-emerald-300">Siap mulai?</p>
                <h2 class="mt-2 text-3xl font-black">Kirim brief lengkap agar estimasi lebih cepat dihitung.</h2>
                <p class="mt-3 text-sm leading-6 text-slate-300">Cocok untuk pesanan 3D print, merchandise, hampers, sablon, stiker, kue custom, dan jasa kreatif lain.</p>
            </div>
            <a href="{{ route('public.order.create', $seller) }}" class="rounded-lg bg-white px-6 py-4 text-center text-sm font-black text-slate-950 hover:bg-emerald-50">
                Isi Form Pesanan
            </a>
        </div>
    </section>
</x-layouts.app>
