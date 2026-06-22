<x-layouts.app title="Kelola Produk Custom - PesanKustom.id">
    @php($inp = 'mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15')
    @php($inpSm = 'mt-1 w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15')
    @php($hint = 'mt-1 block text-xs font-semibold text-faint')
    @php($lblSm = 'text-[11px] font-extrabold uppercase tracking-wide text-faint')

    <section class="mx-auto max-w-6xl px-4 py-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Katalog Produk</p>
                <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-ink">Kelola produk custom</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">Tambahkan contoh produk/jasa yang sering dipesan: mini figure, prototype casing, keychain nama, hampers custom, atau desain merchandise.</p>
            </div>
            <a href="{{ route('public.store', $seller) }}" class="rounded-2xl border-[1.5px] border-line bg-white px-5 py-3 text-center text-sm font-extrabold text-ink hover:border-brand">Lihat Katalog Publik</a>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                @csrf
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Tambah Produk Baru</p>
                <h2 class="mt-1 text-2xl font-extrabold text-ink">Produk custom yang bisa dipesan</h2>
                <p class="mt-2 text-sm leading-6 text-muted">Produk jadi pilihan acuan di form order. Pembeli tetap bisa menulis detail custom sesuai kebutuhan.</p>

                @if ($seller->productLimit())
                    <div class="mt-4 rounded-2xl border border-sunny/40 bg-sunny-soft p-4 text-sm font-semibold leading-6 text-sunny-ink">
                        Paket {{ $seller->planLabel() }} mendukung maksimal {{ $seller->productLimit() }} produk. Saat ini ada {{ $seller->products->count() }} produk.
                    </div>
                @endif

                <div class="mt-5 grid gap-4">
                    <label class="block">
                        <span class="text-sm font-bold text-ink">Nama produk di katalog</span>
                        <input name="name" value="{{ old('name') }}" required placeholder="Contoh: Mini figure custom 12 cm" class="{{ $inp }}">
                        <span class="{{ $hint }}">Muncul di halaman toko dan pilihan form pesanan.</span>
                    </label>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-bold text-ink">Tipe/Jenis produk</span>
                            <input name="category" value="{{ old('category') }}" placeholder="Figurine, Prototype, Merchandise" class="{{ $inp }}">
                            <span class="{{ $hint }}">Untuk mengelompokkan produk.</span>
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-ink">Harga mulai dari</span>
                            <input type="number" min="0" name="starting_price" value="{{ old('starting_price', 0) }}" required class="{{ $inp }}">
                            <span class="{{ $hint }}">Harga awal untuk estimasi.</span>
                        </label>
                    </div>
                    <label class="block">
                        <span class="text-sm font-bold text-ink">Deskripsi singkat</span>
                        <textarea name="description" rows="4" placeholder="Contoh: Cocok untuk hadiah, bisa dibuat dari foto referensi pelanggan." class="{{ $inp }}">{{ old('description') }}</textarea>
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-ink">Foto produk / contoh hasil</span>
                        <input type="file" name="image" class="mt-2 w-full rounded-xl border border-dashed border-line bg-cream px-4 py-4 text-sm text-muted">
                    </label>
                    <label class="flex items-start gap-3 rounded-2xl bg-cream p-4">
                        <input type="checkbox" name="is_featured" value="1" checked class="mt-1 size-4 accent-brand">
                        <span>
                            <span class="block text-sm font-extrabold text-ink">Tampilkan di katalog publik</span>
                            <span class="mt-1 block text-xs font-semibold leading-5 text-faint">Jika aktif, produk muncul di toko & bisa dipilih pembeli saat brief.</span>
                        </span>
                    </label>
                </div>

                @if ($seller->canAddProduct())
                    <button class="mt-6 w-full rounded-2xl bg-brand px-5 py-3.5 text-sm font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Tambah Produk Custom</button>
                @else
                    <a href="{{ route('seller.subscription') }}" class="mt-6 block rounded-2xl bg-ink px-5 py-3.5 text-center text-sm font-extrabold text-white hover:opacity-90">Upgrade untuk tambah produk</a>
                @endif
            </form>

            <div class="space-y-4">
                <div class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                    <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-end">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-faint">Daftar Produk</p>
                            <h2 class="mt-1 text-2xl font-extrabold text-ink">{{ $seller->products->count() }} produk custom</h2>
                        </div>
                        <a href="{{ route('public.order.create', $seller) }}" class="text-sm font-extrabold text-brand-deep hover:underline">Cek Form Pesanan</a>
                    </div>
                    <div class="mt-4 rounded-2xl border border-sunny/40 bg-sunny-soft p-4 text-sm font-semibold leading-6 text-sunny-ink">
                        Tips: buat nama produk yang mudah dibayangkan pembeli, lalu isi tipe untuk kategori besar. Mis. nama "Mini figure custom 12 cm", tipe "Figurine".
                    </div>
                </div>

                @forelse ($seller->products as $product)
                    <article class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                        <div class="grid gap-4 md:grid-cols-[120px_1fr]">
                            <div class="grid aspect-square place-items-center overflow-hidden rounded-2xl" style="background-color:#eaf6f0;background-image:repeating-linear-gradient(45deg,rgba(7,168,107,.10) 0 9px,transparent 9px 18px)">
                                @if ($product->image_path)
                                    <img src="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="grid size-10 place-items-center rounded-xl bg-white text-brand shadow-sm ring-1 ring-line">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                                    </span>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data" class="grid gap-3">
                                @csrf
                                @method('PUT')
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <label class="block"><span class="{{ $lblSm }}">Nama produk</span><input name="name" value="{{ $product->name }}" required class="{{ $inpSm }}"></label>
                                    <label class="block"><span class="{{ $lblSm }}">Tipe/Jenis</span><input name="category" value="{{ $product->category }}" placeholder="Figurine, Prototype" class="{{ $inpSm }}"></label>
                                </div>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <label class="block"><span class="{{ $lblSm }}">Harga mulai dari</span><input type="number" min="0" name="starting_price" value="{{ $product->starting_price }}" required class="{{ $inpSm }}"></label>
                                    <label class="block"><span class="{{ $lblSm }}">Ganti foto</span><input type="file" name="image" class="{{ $inpSm }}"></label>
                                </div>
                                <label class="block"><span class="{{ $lblSm }}">Deskripsi</span><textarea name="description" rows="3" class="{{ $inpSm }}">{{ $product->description }}</textarea></label>
                                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                                    <label class="flex items-center gap-2 text-sm font-bold text-ink">
                                        <input type="checkbox" name="is_featured" value="1" @checked($product->is_featured) class="size-4 accent-brand">
                                        Tampilkan di katalog publik
                                    </label>
                                    <button class="rounded-2xl bg-ink px-5 py-2.5 text-sm font-extrabold text-white hover:opacity-90">Simpan Produk</button>
                                </div>
                            </form>
                        </div>

                        <form method="POST" action="{{ route('seller.products.destroy', $product) }}" class="mt-4 border-t border-line pt-4">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus produk custom ini dari katalog?')" class="text-sm font-extrabold text-coral-ink hover:underline">Hapus produk dari katalog</button>
                        </form>
                    </article>
                @empty
                    <div class="rounded-[22px] border border-dashed border-line bg-white p-8 text-center">
                        <p class="text-lg font-extrabold text-ink">Belum ada produk custom</p>
                        <p class="mt-2 text-sm leading-6 text-muted">Tambahkan minimal satu produk agar pembeli punya acuan saat mengisi brief pesanan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
