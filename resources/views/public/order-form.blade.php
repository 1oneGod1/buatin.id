<x-layouts.app :title="'Form Pesanan | '.$seller->brand_name">
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[0.9fr_1.1fr]">
        <aside class="lg:sticky lg:top-24 lg:self-start">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Pesanan Custom</p>
                <h1 class="mt-2 text-3xl font-black text-slate-950">{{ $seller->brand_name }}</h1>
                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Pilih produk acuan jika ada, lalu jelaskan tipe pesanan custom yang ingin dibuat. Detail brief akan dikirim ke penjual untuk dihitung dan ditindaklanjuti lewat WhatsApp.
                </p>
                <div class="mt-5 rounded-2xl bg-amber-50 p-4 text-sm leading-6 text-amber-900">
                    Contoh: pilih "Mini figure custom", lalu tulis tipe pesanan "figur karakter 12 cm dari foto referensi". Harga final tetap bisa disesuaikan setelah diskusi dengan penjual.
                </div>
            </div>
        </aside>

        <form method="POST" action="{{ route('public.order.store', $seller) }}" enctype="multipart/form-data" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Nama pelanggan</span>
                    <input name="customer_name" value="{{ old('customer_name') }}" required class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Nomor WhatsApp</span>
                    <input name="customer_whatsapp" value="{{ old('customer_whatsapp') }}" required placeholder="08xxxxxxxxxx" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                </label>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Pilih produk acuan dari katalog</span>
                    <select name="product_id" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
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
                    <input name="product_type" value="{{ old('product_type') }}" required placeholder="Contoh: mini figure karakter 12 cm dari foto" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    <span class="mt-1 block text-xs font-semibold text-slate-500">Wajib diisi agar penjual tahu hasil akhir yang kamu harapkan.</span>
                </label>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                @if ($fields['material'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Bahan</span>
                        <input name="material" value="{{ old('material') }}" placeholder="PLA, resin, kain, kertas, dll." class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['size'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Ukuran</span>
                        <input name="size" value="{{ old('size') }}" placeholder="Contoh: 10 cm, A4, M" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['color'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Warna</span>
                        <input name="color" value="{{ old('color') }}" placeholder="Contoh: hitam doff" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['quantity'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Jumlah</span>
                        <input type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['deadline'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Deadline</span>
                        <input type="date" name="deadline" value="{{ old('deadline') }}" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
                @if ($fields['budget'] ?? false)
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Budget awal</span>
                        <input name="budget" value="{{ old('budget') }}" placeholder="Contoh: Rp200.000 - Rp300.000" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </label>
                @endif
            </div>

            @if ($fields['reference'] ?? false)
                <label class="mt-5 block">
                    <span class="text-sm font-bold text-slate-700">Upload referensi</span>
                    <input type="file" name="reference" class="mt-2 w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm">
                </label>
            @endif

            @if ($fields['notes'] ?? false)
                <label class="mt-5 block">
                    <span class="text-sm font-bold text-slate-700">Detail tambahan</span>
                    <textarea name="notes" rows="5" placeholder="Tuliskan bentuk, gaya, contoh, penggunaan, atau catatan penting lainnya." class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('notes') }}</textarea>
                </label>
            @endif

            <button class="mt-6 w-full rounded-full bg-emerald-600 px-5 py-3 text-sm font-black text-white shadow-sm hover:bg-emerald-700">
                Kirim Brief Pesanan
            </button>
        </form>
    </section>
</x-layouts.app>
