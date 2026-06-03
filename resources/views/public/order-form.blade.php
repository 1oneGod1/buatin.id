<x-layouts.app :title="'Form Pesanan | '.$seller->brand_name">
    <section class="bg-white">
        <div class="mx-auto max-w-6xl px-4 py-8">
            <div class="max-w-full overflow-hidden rounded-lg border border-slate-200 bg-slate-950 p-5 text-white md:p-8">
                <div class="grid gap-6 lg:grid-cols-[1fr_360px] lg:items-end">
                    <div class="min-w-0 max-w-xs sm:max-w-none">
                        <p class="text-sm font-black uppercase text-emerald-300">Form Brief Custom</p>
                        <h1 class="mt-2 break-words text-2xl font-black leading-tight sm:text-3xl md:text-4xl">Pesanan untuk {{ $seller->brand_name }}</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-300">
                            Isi detail pesanan sekali saja. Ringkasan akan tersimpan, bisa dibayar lewat QRIS jika aktif, lalu dikirim ke WhatsApp penjual.
                        </p>
                    </div>
                    <div class="min-w-0 max-w-xs rounded-lg bg-white/10 p-4 text-sm leading-6 text-slate-200 sm:max-w-none">
                        <p class="font-black text-white">Tips agar tidak bingung</p>
                        <p class="mt-1 break-words">Produk acuan adalah contoh dari katalog. Tipe pesanan custom adalah detail hasil akhir yang kamu mau, misalnya "figur karakter 12 cm dari foto".</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[330px_1fr]">
        <aside class="lg:sticky lg:top-28 lg:self-start">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-black text-slate-950">Alur brief</p>
                <div class="mt-4 space-y-4">
                    @foreach ([
                        ['Data pelanggan', 'Nama dan WhatsApp untuk follow up.'],
                        ['Detail custom', 'Produk acuan, tipe, ukuran, bahan, dan deadline.'],
                        ['Referensi', 'Upload gambar atau file pendukung jika ada.'],
                    ] as [$title, $copy])
                        <div class="flex gap-3">
                            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-emerald-50 text-sm font-black text-emerald-700">{{ $loop->iteration }}</span>
                            <div>
                                <p class="text-sm font-black text-slate-900">{{ $title }}</p>
                                <p class="mt-1 text-xs leading-5 text-slate-500">{{ $copy }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900">
                    Harga di form adalah estimasi awal. Harga final tetap bisa disepakati setelah penjual mengecek brief.
                </div>
            </div>
        </aside>

        <form method="POST" action="{{ route('public.order.store', $seller) }}" enctype="multipart/form-data" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm md:p-6">
            @csrf

            <div class="border-b border-slate-200 pb-5">
                <p class="text-sm font-black uppercase text-emerald-700">Langkah 1</p>
                <h2 class="mt-1 text-2xl font-black text-slate-950">Data pelanggan</h2>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Nama pelanggan</span>
                    <input name="customer_name" value="{{ old('customer_name') }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Nomor WhatsApp</span>
                    <input name="customer_whatsapp" value="{{ old('customer_whatsapp') }}" required placeholder="08xxxxxxxxxx" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                </label>
            </div>

            <div class="mt-8 border-b border-slate-200 pb-5">
                <p class="text-sm font-black uppercase text-emerald-700">Langkah 2</p>
                <h2 class="mt-1 text-2xl font-black text-slate-950">Detail pesanan custom</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Bagian ini membantu penjual memahami jenis produk dan kebutuhan teknis sejak awal.</p>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Pilih produk acuan dari katalog</span>
                    <select name="product_id" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        <option value="">Tidak ada acuan, pesanan benar-benar custom</option>
                        @foreach ($seller->products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                {{ $product->name }} - Rp{{ number_format($product->starting_price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    <span class="mt-1 block text-xs font-semibold text-slate-500">Opsional. Pilihan ini membantu penjual memberi estimasi awal.</span>
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Tipe pesanan custom yang ingin dibuat</span>
                    <input name="product_type" value="{{ old('product_type') }}" required placeholder="Contoh: mini figure karakter 12 cm dari foto" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    <span class="mt-1 block text-xs font-semibold text-slate-500">Wajib. Jelaskan bentuk akhir yang ingin dibuat, bukan hanya nama produk.</span>
                </label>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                @if ($fields['material'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Bahan</span>
                        <input name="material" value="{{ old('material') }}" placeholder="PLA, resin, kain, kertas, dll." class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['size'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Ukuran</span>
                        <input name="size" value="{{ old('size') }}" placeholder="Contoh: 10 cm, A4, M" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['color'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Warna</span>
                        <input name="color" value="{{ old('color') }}" placeholder="Contoh: hitam doff" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['quantity'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Jumlah</span>
                        <input type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['deadline'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Deadline</span>
                        <input type="date" name="deadline" value="{{ old('deadline') }}" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['budget'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Budget awal</span>
                        <input name="budget" value="{{ old('budget') }}" placeholder="Contoh: Rp200.000 - Rp300.000" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
            </div>

            <div class="mt-8 border-b border-slate-200 pb-5">
                <p class="text-sm font-black uppercase text-emerald-700">Langkah 3</p>
                <h2 class="mt-1 text-2xl font-black text-slate-950">Referensi dan catatan</h2>
            </div>

            @if ($fields['reference'] ?? false)
                <label class="mt-5 block">
                    <span class="text-sm font-bold text-slate-700">Upload referensi</span>
                    <input type="file" name="reference" class="mt-2 w-full rounded-lg border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm">
                </label>
            @endif

            @if ($fields['notes'] ?? false)
                <label class="mt-5 block">
                    <span class="text-sm font-bold text-slate-700">Detail tambahan</span>
                    <textarea name="notes" rows="5" placeholder="Tuliskan bentuk, gaya, contoh, penggunaan, atau catatan penting lainnya." class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('notes') }}</textarea>
                </label>
            @endif

            <button class="mt-6 w-full rounded-lg bg-emerald-600 px-5 py-4 text-sm font-black text-white shadow-sm hover:bg-emerald-700">
                Kirim Brief Pesanan
            </button>
        </form>
    </section>
</x-layouts.app>
