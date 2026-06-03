<x-layouts.app title="Kelola Produk Custom - Buatin.id">
    <section class="mx-auto max-w-6xl px-4 py-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Katalog Produk</p>
                <h1 class="mt-2 text-3xl font-black text-slate-950">Kelola produk custom</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                    Tambahkan contoh produk atau jasa yang sering dipesan, seperti mini figure, prototype casing, keychain nama, hampers custom, atau desain merchandise.
                </p>
            </div>
            <a href="{{ route('public.store', $seller) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 text-center text-sm font-black text-slate-700 hover:bg-slate-50">
                Lihat Katalog Publik
            </a>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data" class="rounded-[2rem] border border-emerald-100 bg-white p-6 shadow-sm">
                @csrf
                <p class="text-sm font-black text-emerald-700">Tambah Produk Baru</p>
                <h2 class="mt-1 text-2xl font-black text-slate-950">Produk custom yang bisa dipesan</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Gunakan produk sebagai pilihan acuan di form order. Pembeli tetap bisa menulis detail custom sesuai kebutuhan.
                </p>

                @if ($seller->productLimit())
                    <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm font-semibold leading-6 text-amber-900">
                        Paket {{ $seller->planLabel() }} mendukung maksimal {{ $seller->productLimit() }} produk. Saat ini ada {{ $seller->products->count() }} produk.
                    </div>
                @endif

                <div class="mt-5 grid gap-4">
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Nama produk di katalog</span>
                        <input name="name" value="{{ old('name') }}" required placeholder="Contoh: Mini figure custom 12 cm" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        <span class="mt-1 block text-xs font-semibold text-slate-500">Nama ini akan muncul di halaman toko dan pilihan form pesanan.</span>
                    </label>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">Tipe/Jenis produk custom</span>
                            <input name="category" value="{{ old('category') }}" placeholder="Contoh: Figurine, Prototype, Merchandise" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            <span class="mt-1 block text-xs font-semibold text-slate-500">Dipakai untuk mengelompokkan produk agar tidak tercampur.</span>
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-slate-700">Harga mulai dari</span>
                            <input type="number" min="0" name="starting_price" value="{{ old('starting_price', 0) }}" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            <span class="mt-1 block text-xs font-semibold text-slate-500">Harga awal untuk estimasi. Harga final tetap bisa dibicarakan lewat WhatsApp.</span>
                        </label>
                    </div>

                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Deskripsi singkat</span>
                        <textarea name="description" rows="4" placeholder="Contoh: Cocok untuk hadiah, bisa dibuat berdasarkan foto referensi pelanggan." class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('description') }}</textarea>
                    </label>

                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Foto produk atau contoh hasil</span>
                        <input type="file" name="image" class="mt-2 w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm">
                    </label>

                    <label class="flex items-start gap-3 rounded-2xl bg-slate-50 p-4">
                        <input type="checkbox" name="is_featured" value="1" checked class="mt-1 size-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span>
                            <span class="block text-sm font-bold text-slate-800">Tampilkan di katalog publik</span>
                            <span class="mt-1 block text-xs font-semibold leading-5 text-slate-500">Jika aktif, produk muncul di halaman toko dan bisa dipilih pembeli saat membuat brief.</span>
                        </span>
                    </label>
                </div>

                @if ($seller->canAddProduct())
                    <button class="mt-6 w-full rounded-full bg-emerald-600 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-emerald-700">
                        Tambah Produk Custom
                    </button>
                @else
                    <a href="{{ route('seller.subscription') }}" class="mt-6 block rounded-full bg-slate-950 px-5 py-3 text-center text-sm font-black text-white hover:bg-slate-800">
                        Upgrade untuk tambah produk
                    </a>
                @endif
            </form>

            <div class="space-y-4">
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-end">
                        <div>
                            <p class="text-sm font-black text-slate-500">Daftar Produk</p>
                            <h2 class="mt-1 text-2xl font-black text-slate-950">{{ $seller->products->count() }} produk custom</h2>
                        </div>
                        <a href="{{ route('public.order.create', $seller) }}" class="text-sm font-black text-emerald-700 hover:text-emerald-800">
                            Cek Form Pesanan
                        </a>
                    </div>
                    <div class="mt-4 rounded-2xl bg-amber-50 p-4 text-sm font-semibold leading-6 text-amber-900">
                        Tips: buat nama produk sebagai contoh yang mudah dibayangkan pembeli, lalu isi tipe untuk kategori besar. Misalnya nama produk "Mini figure custom 12 cm" dan tipe "Figurine".
                    </div>
                </div>

                @forelse ($seller->products as $product)
                    <article class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="grid gap-4 md:grid-cols-[120px_1fr]">
                            <div class="grid aspect-square place-items-center overflow-hidden rounded-2xl bg-slate-100">
                                @if ($product->image_path)
                                    <img src="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="px-3 text-center text-xs font-black uppercase tracking-wide text-slate-400">
                                        Produk
                                    </div>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data" class="grid gap-3">
                                @csrf
                                @method('PUT')

                                <div class="grid gap-3 sm:grid-cols-2">
                                    <label class="block">
                                        <span class="text-xs font-black uppercase text-slate-500">Nama produk</span>
                                        <input name="name" value="{{ $product->name }}" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                                    </label>
                                    <label class="block">
                                        <span class="text-xs font-black uppercase text-slate-500">Tipe/Jenis</span>
                                        <input name="category" value="{{ $product->category }}" placeholder="Figurine, Prototype, Merchandise" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                                    </label>
                                </div>

                                <div class="grid gap-3 sm:grid-cols-2">
                                    <label class="block">
                                        <span class="text-xs font-black uppercase text-slate-500">Harga mulai dari</span>
                                        <input type="number" min="0" name="starting_price" value="{{ $product->starting_price }}" required class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                                    </label>
                                    <label class="block">
                                        <span class="text-xs font-black uppercase text-slate-500">Ganti foto</span>
                                        <input type="file" name="image" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm">
                                    </label>
                                </div>

                                <label class="block">
                                    <span class="text-xs font-black uppercase text-slate-500">Deskripsi</span>
                                    <textarea name="description" rows="3" class="mt-1 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ $product->description }}</textarea>
                                </label>

                                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                                    <label class="flex items-center gap-2 text-sm font-bold text-slate-700">
                                        <input type="checkbox" name="is_featured" value="1" @checked($product->is_featured) class="size-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                        Tampilkan di katalog publik
                                    </label>
                                    <button class="rounded-full bg-slate-950 px-5 py-3 text-sm font-black text-white hover:bg-slate-800">
                                        Simpan Produk
                                    </button>
                                </div>
                            </form>
                        </div>

                        <form method="POST" action="{{ route('seller.products.destroy', $product) }}" class="mt-4 border-t border-slate-100 pt-4">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus produk custom ini dari katalog?')" class="text-sm font-black text-red-600 hover:text-red-700">
                                Hapus produk dari katalog
                            </button>
                        </form>
                    </article>
                @empty
                    <div class="rounded-[2rem] border border-dashed border-slate-300 bg-white p-8 text-center">
                        <p class="text-lg font-black text-slate-950">Belum ada produk custom</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Tambahkan minimal satu produk agar pembeli punya acuan saat mengisi brief pesanan.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
