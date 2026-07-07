<x-layouts.app :title="'Form Pesanan | '.$seller->brand_name">
    @php($inp = 'mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15')
    @php($lbl = 'text-sm font-bold text-ink')
    @php($hint = 'mt-1 block text-xs font-semibold text-faint')

    <section class="mx-auto max-w-6xl px-4 pt-8">
        <div class="overflow-hidden rounded-[26px] bg-ink p-6 text-white md:p-8" style="background-image:radial-gradient(circle at 92% 0%,rgba(7,168,107,.32),transparent 48%)">
            <div class="grid gap-6 lg:grid-cols-[1fr_340px] lg:items-end">
                <div class="min-w-0">
                    <p class="text-xs font-extrabold uppercase tracking-wide text-[#2BD08A]">Form Brief Custom</p>
                    <h1 class="mt-2 break-words text-2xl font-extrabold leading-tight tracking-tight sm:text-3xl md:text-4xl">Pesanan untuk {{ $seller->brand_name }}</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-white/70">Isi detail pesanan sekali saja. Ringkasan tersimpan, bisa dibayar lewat QRIS, lalu dikirim ke WhatsApp penjual.</p>
                </div>
                <div class="min-w-0 rounded-2xl bg-white/10 p-4 text-sm leading-6 text-white/85 backdrop-blur">
                    <p class="font-extrabold text-white">💡 Tips agar tidak bingung</p>
                    <p class="mt-1 break-words">Produk acuan = contoh dari katalog. Tipe pesanan custom = detail hasil akhir yang kamu mau, mis. "figur karakter 12 cm dari foto".</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[320px_1fr]">
        <aside class="lg:sticky lg:top-24 lg:self-start">
            <div class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                <p class="text-sm font-extrabold text-ink">Alur brief</p>
                <div class="mt-4 space-y-4">
                    @foreach ([
                        ['Data pelanggan', 'Nama dan WhatsApp untuk follow up.', 'bg-brand-soft text-brand-deep'],
                        ['Detail custom', 'Produk acuan, tipe, ukuran, bahan, deadline.', 'bg-sky-soft text-sky-ink'],
                        ['Referensi', 'Upload gambar atau file pendukung jika ada.', 'bg-lilac-soft text-lilac-ink'],
                    ] as [$title, $copy, $accent])
                        <div class="flex gap-3">
                            <span class="grid size-8 shrink-0 place-items-center rounded-xl text-sm font-extrabold {{ $accent }}">{{ $loop->iteration }}</span>
                            <div>
                                <p class="text-sm font-extrabold text-ink">{{ $title }}</p>
                                <p class="mt-1 text-xs leading-5 text-muted">{{ $copy }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 rounded-2xl border border-sunny/40 bg-sunny-soft p-4 text-sm leading-6 text-sunny-ink">
                    Harga di form adalah estimasi awal. Harga final tetap bisa disepakati setelah penjual mengecek brief.
                </div>
            </div>
        </aside>

        <form method="POST" action="{{ route('public.order.store', $seller) }}" enctype="multipart/form-data" class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)] md:p-6">
            @csrf

            <div class="flex items-center gap-3 border-b border-line pb-5">
                <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-brand-soft text-base font-extrabold text-brand-deep">1</span>
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Langkah 1</p>
                    <h2 class="text-xl font-extrabold text-ink">Data pelanggan</h2>
                </div>
            </div>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="{{ $lbl }}">Nama pelanggan</span>
                    <input name="customer_name" value="{{ old('customer_name') }}" required class="{{ $inp }}">
                </label>
                <label class="block">
                    <span class="{{ $lbl }}">Nomor WhatsApp</span>
                    <input name="customer_whatsapp" value="{{ old('customer_whatsapp') }}" required placeholder="08xxxxxxxxxx" class="{{ $inp }}">
                </label>
            </div>

            <div class="mt-8 flex items-center gap-3 border-b border-line pb-5">
                <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-sky-soft text-base font-extrabold text-sky-ink">2</span>
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Langkah 2</p>
                    <h2 class="text-xl font-extrabold text-ink">Detail pesanan custom</h2>
                </div>
            </div>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="{{ $lbl }}">Pilih produk acuan dari katalog</span>
                    <select name="product_id" class="{{ $inp }}">
                        <option value="">Tidak ada acuan, pesanan benar-benar custom</option>
                        @foreach ($seller->products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }} - Rp{{ number_format($product->starting_price, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                    <span class="{{ $hint }}">Opsional. Membantu penjual memberi estimasi awal.</span>
                </label>
                <label class="block">
                    <span class="{{ $lbl }}">Tipe pesanan custom yang ingin dibuat</span>
                    <input name="product_type" value="{{ old('product_type') }}" required placeholder="Contoh: mini figure karakter 12 cm dari foto" class="{{ $inp }}">
                    <span class="{{ $hint }}">Wajib. Jelaskan bentuk akhir yang ingin dibuat, bukan hanya nama produk.</span>
                </label>
            </div>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                @if ($fields['material'] ?? false)
                    <label class="block"><span class="{{ $lbl }}">Bahan</span><input name="material" value="{{ old('material') }}" placeholder="PLA, resin, kain, kertas, dll." class="{{ $inp }}"></label>
                @endif
                @if ($fields['size'] ?? false)
                    <label class="block"><span class="{{ $lbl }}">Ukuran</span><input name="size" value="{{ old('size') }}" placeholder="Contoh: 10 cm, A4, M" class="{{ $inp }}"></label>
                @endif
                @if ($fields['color'] ?? false)
                    <label class="block"><span class="{{ $lbl }}">Warna</span><input name="color" value="{{ old('color') }}" placeholder="Contoh: hitam doff" class="{{ $inp }}"></label>
                @endif
                @if ($fields['quantity'] ?? false)
                    <label class="block"><span class="{{ $lbl }}">Jumlah</span><input type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}" class="{{ $inp }}"></label>
                @endif
                @if ($fields['deadline'] ?? false)
                    <label class="block"><span class="{{ $lbl }}">Deadline</span><input type="date" name="deadline" value="{{ old('deadline') }}" min="{{ now()->toDateString() }}" class="{{ $inp }}"></label>
                @endif
                @if ($fields['budget'] ?? false)
                    <label class="block"><span class="{{ $lbl }}">Budget awal</span><input name="budget" value="{{ old('budget') }}" placeholder="Contoh: Rp200.000 - Rp300.000" class="{{ $inp }}"></label>
                @endif
            </div>

            <div class="mt-8 flex items-center gap-3 border-b border-line pb-5">
                <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-lilac-soft text-base font-extrabold text-lilac-ink">3</span>
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Langkah 3</p>
                    <h2 class="text-xl font-extrabold text-ink">Referensi dan catatan</h2>
                </div>
            </div>
            @if ($fields['reference'] ?? false)
                <label class="mt-5 block">
                    <span class="{{ $lbl }}">Upload referensi</span>
                    <input type="file" name="reference" accept=".jpg,.jpeg,.png,.webp,.pdf" class="mt-2 w-full rounded-xl border border-dashed border-line bg-cream px-4 py-4 text-sm text-muted">
                </label>
            @endif
            @if ($fields['notes'] ?? false)
                <label class="mt-5 block">
                    <span class="{{ $lbl }}">Detail tambahan</span>
                    <textarea name="notes" rows="5" placeholder="Tuliskan bentuk, gaya, contoh, penggunaan, atau catatan penting lainnya." class="{{ $inp }}">{{ old('notes') }}</textarea>
                </label>
            @endif

            <button class="mt-6 w-full rounded-2xl bg-brand px-5 py-4 text-sm font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">
                Kirim Brief Pesanan →
            </button>
        </form>
    </section>
</x-layouts.app>
