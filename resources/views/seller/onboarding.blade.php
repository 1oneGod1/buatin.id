<x-layouts.app title="Setup Brand - Buatin.id">
    <section class="mx-auto grid max-w-6xl gap-8 px-4 py-8 lg:grid-cols-[1fr_380px]">
        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-emerald-700">Langkah 1 dari 3</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight">Lengkapi profil usaha</h1>
            <p class="mt-2 text-slate-600">Data ini akan dipakai untuk membuat halaman publik pertama kamu.</p>

            <div class="mt-6 h-2 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full w-1/3 rounded-full bg-emerald-600"></div>
            </div>

            <form method="POST" action="{{ route('seller.start.store') }}" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-bold text-slate-700">Nama brand</label>
                    <input name="brand_name" value="{{ old('brand_name', $seller->brand_name ?? 'Disyan 3D Studio') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Kategori usaha</label>
                    <input name="category" value="{{ old('category', $seller->category ?? 'Jasa desain & cetak 3D') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Nomor WhatsApp</label>
                    <input name="whatsapp" value="{{ old('whatsapp', $seller->whatsapp ?? '081234567890') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Lokasi</label>
                    <input name="location" value="{{ old('location', $seller->location ?? 'Surabaya, Indonesia') }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Deskripsi singkat</label>
                    <textarea name="description" rows="4" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">{{ old('description', $seller->description ?? 'Melayani desain produk, mini figure, dan prototype casing custom berbasis 3D printing.') }}</textarea>
                </div>
                <button class="w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">
                    Lanjut buat halaman
                </button>
            </form>
        </div>

        <aside class="rounded-[2rem] bg-emerald-950 p-6 text-white shadow-xl shadow-emerald-900/10">
            <div class="grid size-14 place-items-center rounded-2xl bg-emerald-400 text-2xl font-black text-emerald-950">B</div>
            <h2 class="mt-6 text-2xl font-black">Profil yang rapi bikin pelanggan lebih percaya.</h2>
            <p class="mt-3 text-emerald-50">Setelah profil tersimpan, kamu bisa membuat link publik, form brief, QRIS, dan menerima order custom.</p>
            <div class="mt-8 space-y-3 text-sm">
                <div class="rounded-2xl bg-white/10 p-4">Satu link untuk katalog, brief, dan pembayaran</div>
                <div class="rounded-2xl bg-white/10 p-4">Cocok untuk 3D print, hampers, sablon, stiker, dan kue custom</div>
            </div>
        </aside>
    </section>
</x-layouts.app>
