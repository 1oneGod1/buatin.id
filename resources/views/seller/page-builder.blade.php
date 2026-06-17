<x-layouts.app title="Page Builder - PesanKustom.id">
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_420px]">
        <form method="POST" action="{{ route('seller.page-builder.update') }}" enctype="multipart/form-data" class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            @csrf
            <p class="text-sm font-bold text-emerald-700">Page Builder</p>
            <h1 class="mt-1 text-3xl font-black">Atur halaman publik</h1>
            <p class="mt-2 text-slate-600">Link publik: <a class="font-bold text-emerald-700" href="{{ route('public.store', $seller) }}">{{ $seller->public_url }}</a></p>

            <div class="mt-6 grid gap-5">
                <div>
                    <label class="text-sm font-bold text-slate-700">Nama brand</label>
                    <input name="brand_name" value="{{ old('brand_name', $seller->brand_name) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Kategori</label>
                    <input name="category" value="{{ old('category', $seller->category) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">WhatsApp</label>
                    <input name="whatsapp" value="{{ old('whatsapp', $seller->whatsapp) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Lokasi</label>
                    <input name="location" value="{{ old('location', $seller->location) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-emerald-500">{{ old('description', $seller->description) }}</textarea>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-bold text-slate-700">Logo</label>
                        <input type="file" name="logo" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700">Banner</label>
                        <input type="file" name="banner" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm">
                    </div>
                </div>
            </div>
            <button class="mt-6 w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">Simpan & Publikasikan</button>
        </form>

        <aside class="rounded-[2rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-slate-500">Pratinjau langsung</p>
            <div class="mt-4 overflow-hidden rounded-[1.5rem] border border-slate-200">
                <div class="bg-gradient-to-br from-emerald-950 via-slate-900 to-emerald-500 p-6 text-white">
                    <div class="grid size-14 place-items-center rounded-2xl bg-white/15 text-xl font-black">{{ strtoupper(substr($seller->brand_name, 0, 1)) }}</div>
                    <h2 class="mt-8 text-2xl font-black">{{ $seller->brand_name }}</h2>
                    <p class="text-sm text-emerald-50">{{ $seller->category }} · {{ $seller->location }}</p>
                </div>
                <div class="space-y-4 p-5">
                    <p class="text-sm text-slate-600">{{ $seller->description }}</p>
                    <div class="grid gap-3">
                        @foreach ($seller->products->take(2) as $product)
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="font-black">{{ $product->name }}</p>
                                <p class="text-sm text-emerald-700">Mulai Rp{{ number_format($product->starting_price, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('public.order.create', $seller) }}" class="block rounded-2xl bg-emerald-700 px-5 py-3 text-center font-black text-white">Buat Pesanan Custom</a>
                </div>
            </div>
        </aside>
    </section>
</x-layouts.app>
