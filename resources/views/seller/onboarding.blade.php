<x-layouts.app title="Setup Brand - Buatin.id">
    <section class="mx-auto grid max-w-6xl gap-8 px-4 py-8 lg:grid-cols-[1fr_380px]">
        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            @if ($isCreatingNew ?? true)
                <p class="text-sm font-bold text-emerald-700">Langkah 2 dari 2</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight">Lengkapi profil toko</h1>
                <p class="mt-2 text-slate-600">Data ini dipakai untuk membuat halaman publik pertama tokomu.</p>

                <div class="mt-6 h-2 overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full w-full rounded-full bg-emerald-600"></div>
                </div>
            @else
                <p class="text-sm font-bold text-emerald-700">Profil toko</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight">Edit profil toko</h1>
                <p class="mt-2 text-slate-600">Perbarui identitas usaha yang tampil di halaman publikmu.</p>
            @endif

            <form method="POST" action="{{ route('seller.start.store') }}" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-bold text-slate-700">Nama brand</label>
                    <input name="brand_name" value="{{ old('brand_name', $seller->brand_name ?? '') }}" placeholder="Contoh: Disyan 3D Studio" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Kategori usaha</label>
                    <input name="category" value="{{ old('category', $seller->category ?? '') }}" placeholder="Contoh: Jasa desain & cetak 3D" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Nomor WhatsApp</label>
                    <input name="whatsapp" value="{{ old('whatsapp', $seller->whatsapp ?? '') }}" placeholder="Contoh: 082260638053" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Lokasi</label>
                    <input name="location" value="{{ old('location', $seller->location ?? '') }}" placeholder="Contoh: Surabaya, Indonesia" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Deskripsi singkat</label>
                    <textarea name="description" rows="4" placeholder="Contoh: Melayani desain produk, mini figure, dan prototype casing custom berbasis 3D printing." class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">{{ old('description', $seller->description ?? '') }}</textarea>
                </div>
                <button class="w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">
                    {{ ($isCreatingNew ?? true) ? 'Lanjut buat halaman' : 'Simpan perubahan' }}
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
