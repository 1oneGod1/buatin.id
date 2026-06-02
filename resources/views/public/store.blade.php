<x-layouts.app :title="$seller->brand_name.' | Buatin.id'">
    <section class="bg-white">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 py-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:py-12">
            <div>
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-800">
                    {{ $seller->category }}
                </div>
                <h1 class="max-w-2xl text-4xl font-black leading-tight text-slate-950 md:text-5xl">
                    {{ $seller->brand_name }}
                </h1>
                <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600 md:text-lg">
                    {{ $seller->description }}
                </p>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('public.order.create', $seller) }}" class="rounded-full bg-emerald-600 px-5 py-3 text-center text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                        Buat Pesanan Custom
                    </a>
                    <a href="{{ route('orders.lookup') }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">
                        Cek Status Pesanan
                    </a>
                </div>
                <div class="mt-6 grid max-w-xl grid-cols-2 gap-3 text-sm">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="font-bold text-slate-950">Lokasi</p>
                        <p class="mt-1 text-slate-600">{{ $seller->location ?: 'Indonesia' }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="font-bold text-slate-950">Kontak</p>
                        <p class="mt-1 text-slate-600">{{ $seller->whatsapp }}</p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-slate-950 shadow-xl">
                @if ($seller->banner_path)
                    <img src="{{ asset('storage/'.$seller->banner_path) }}" alt="Banner {{ $seller->brand_name }}" class="h-72 w-full object-cover">
                @else
                    <div class="grid h-72 place-items-center bg-[radial-gradient(circle_at_top_left,#34d399,transparent_35%),linear-gradient(135deg,#0f172a,#164e63)] px-8 text-center text-white">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-emerald-100">Portfolio Preview</p>
                            <p class="mt-3 text-3xl font-black">{{ $seller->brand_name }}</p>
                            <p class="mt-3 text-sm leading-6 text-slate-200">Tampilkan contoh produk, brief pelanggan, dan pembayaran dalam satu halaman.</p>
                        </div>
                    </div>
                @endif
                <div class="grid grid-cols-3 gap-px bg-slate-800">
                    @foreach ($seller->products->take(3) as $product)
                        <div class="bg-white p-4">
                            <p class="text-xs font-bold uppercase text-emerald-700">{{ $product->category }}</p>
                            <p class="mt-1 line-clamp-2 text-sm font-bold text-slate-950">{{ $product->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-10">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Katalog & Portfolio</p>
                <h2 class="mt-2 text-3xl font-black text-slate-950">Contoh produk yang bisa dipesan</h2>
            </div>
            <a href="{{ route('public.order.create', $seller) }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-800">Mulai dari brief custom</a>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @forelse ($seller->products as $product)
                <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="grid aspect-[4/3] place-items-center bg-slate-100">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="px-6 text-center">
                                <p class="text-sm font-bold uppercase tracking-[0.14em] text-slate-500">{{ $product->category }}</p>
                                <p class="mt-2 text-xl font-black text-slate-800">{{ $product->name }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-lg font-black text-slate-950">{{ $product->name }}</p>
                        <p class="mt-2 min-h-12 text-sm leading-6 text-slate-600">{{ $product->description }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-sm text-slate-500">Mulai dari</p>
                            <p class="text-base font-black text-emerald-700">Rp{{ number_format($product->starting_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600 md:col-span-3">
                    Portfolio belum diisi oleh penjual.
                </div>
            @endforelse
        </div>
    </section>

    <section class="bg-slate-100">
        <div class="mx-auto grid max-w-6xl gap-4 px-4 py-10 md:grid-cols-4">
            @foreach (['Isi brief custom', 'Lihat estimasi awal', 'Bayar via QRIS', 'Pantau status'] as $step)
                <div class="rounded-3xl border border-slate-200 bg-white p-5">
                    <p class="text-sm font-bold text-emerald-700">Langkah {{ $loop->iteration }}</p>
                    <p class="mt-2 text-lg font-black text-slate-950">{{ $step }}</p>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.app>
