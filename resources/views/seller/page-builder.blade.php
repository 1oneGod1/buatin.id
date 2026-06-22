<x-layouts.app title="Page Builder - PesanKustom.id">
    @php($inp = 'mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15')
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_400px]">
        <form method="POST" action="{{ route('seller.page-builder.update') }}" enctype="multipart/form-data" class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
            @csrf
            <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Page Builder</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-ink">Atur halaman publik</h1>
            <p class="mt-2 text-muted">Link publik: <a class="font-mono font-bold text-brand-deep" href="{{ route('public.store', $seller) }}">{{ $seller->public_url }}</a></p>

            <div class="mt-6 grid gap-5">
                <div><label class="text-sm font-bold text-ink">Nama brand</label><input name="brand_name" value="{{ old('brand_name', $seller->brand_name) }}" class="{{ $inp }}"></div>
                <div><label class="text-sm font-bold text-ink">Kategori</label><input name="category" value="{{ old('category', $seller->category) }}" class="{{ $inp }}"></div>
                <div><label class="text-sm font-bold text-ink">WhatsApp</label><input name="whatsapp" value="{{ old('whatsapp', $seller->whatsapp) }}" class="{{ $inp }}"></div>
                <div><label class="text-sm font-bold text-ink">Lokasi</label><input name="location" value="{{ old('location', $seller->location) }}" class="{{ $inp }}"></div>
                <div><label class="text-sm font-bold text-ink">Deskripsi</label><textarea name="description" rows="4" class="{{ $inp }}">{{ old('description', $seller->description) }}</textarea></div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div><label class="text-sm font-bold text-ink">Logo</label><input type="file" name="logo" class="mt-2 w-full rounded-xl border border-dashed border-line bg-cream px-4 py-3 text-sm text-muted"></div>
                    <div><label class="text-sm font-bold text-ink">Banner</label><input type="file" name="banner" class="mt-2 w-full rounded-xl border border-dashed border-line bg-cream px-4 py-3 text-sm text-muted"></div>
                </div>
            </div>
            <button class="mt-6 w-full rounded-2xl bg-brand px-6 py-4 font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Simpan &amp; Publikasikan</button>
        </form>

        <aside class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)] lg:sticky lg:top-24 lg:self-start">
            <p class="text-xs font-extrabold uppercase tracking-wide text-faint">Pratinjau langsung</p>
            <div class="mt-4 overflow-hidden rounded-[18px] border border-line">
                <div class="relative overflow-hidden bg-gradient-to-br from-brand-deep via-brand to-[#2bd08a] p-6 text-white">
                    <span class="pointer-events-none absolute -right-3 -top-6 text-[100px] font-extrabold leading-none text-white/15">{{ strtoupper(substr($seller->brand_name, 0, 1)) }}</span>
                    <h2 class="relative mt-8 text-2xl font-extrabold">{{ $seller->brand_name }}</h2>
                    <p class="relative text-sm text-white/85">{{ $seller->category }} · {{ $seller->location }}</p>
                </div>
                <div class="space-y-4 p-5">
                    <p class="text-sm text-muted">{{ $seller->description }}</p>
                    <div class="grid gap-3">
                        @foreach ($seller->products->take(2) as $product)
                            <div class="rounded-2xl bg-cream p-4">
                                <p class="font-extrabold text-ink">{{ $product->name }}</p>
                                <p class="text-sm font-bold text-brand-deep">Mulai Rp{{ number_format($product->starting_price, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('public.order.create', $seller) }}" class="block rounded-2xl bg-brand-deep px-5 py-3 text-center font-extrabold text-white">Buat Pesanan Custom</a>
                </div>
            </div>
        </aside>
    </section>
</x-layouts.app>
