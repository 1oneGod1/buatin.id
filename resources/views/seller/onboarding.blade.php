<x-layouts.app title="Setup Brand - PesanKustom.id">
    @php($inp = 'mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15')
    <section class="mx-auto grid max-w-6xl gap-8 px-4 py-8 lg:grid-cols-[1fr_360px]">
        <div class="rounded-[26px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)] md:p-7">
            @if ($isCreatingNew ?? true)
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Langkah 2 dari 2</p>
                <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-ink">Lengkapi profil toko</h1>
                <p class="mt-2 text-muted">Data ini dipakai untuk membuat halaman publik pertama tokomu.</p>
                <div class="mt-6 h-2 overflow-hidden rounded-full bg-line">
                    <div class="h-full w-full rounded-full bg-brand"></div>
                </div>
            @else
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Profil toko</p>
                <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-ink">Edit profil toko</h1>
                <p class="mt-2 text-muted">Perbarui identitas usaha yang tampil di halaman publikmu.</p>
            @endif

            <form method="POST" action="{{ route('seller.start.store') }}" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-bold text-ink">Nama brand</label>
                    <input name="brand_name" value="{{ old('brand_name', $seller->brand_name ?? '') }}" placeholder="Contoh: Disyan 3D Studio" class="{{ $inp }}">
                </div>
                <div>
                    <label class="text-sm font-bold text-ink">Kategori usaha</label>
                    <input name="category" value="{{ old('category', $seller->category ?? '') }}" placeholder="Contoh: Jasa desain & cetak 3D" class="{{ $inp }}">
                </div>
                <div>
                    <label class="text-sm font-bold text-ink">Nomor WhatsApp</label>
                    <input name="whatsapp" value="{{ old('whatsapp', $seller->whatsapp ?? '') }}" placeholder="Contoh: 082260638053" class="{{ $inp }}">
                </div>
                <div>
                    <label class="text-sm font-bold text-ink">Lokasi</label>
                    <input name="location" value="{{ old('location', $seller->location ?? '') }}" placeholder="Contoh: Surabaya, Indonesia" class="{{ $inp }}">
                </div>
                <div>
                    <label class="text-sm font-bold text-ink">Deskripsi singkat</label>
                    <textarea name="description" rows="4" placeholder="Contoh: Melayani desain produk, mini figure, dan prototype casing custom berbasis 3D printing." class="{{ $inp }}">{{ old('description', $seller->description ?? '') }}</textarea>
                </div>
                <button class="w-full rounded-2xl bg-brand px-6 py-4 font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">
                    {{ ($isCreatingNew ?? true) ? 'Lanjut buat halaman' : 'Simpan perubahan' }}
                </button>
            </form>
        </div>

        <aside class="rounded-[26px] bg-ink p-6 text-white shadow-xl" style="background-image:radial-gradient(circle at 90% 0%,rgba(7,168,107,.3),transparent 50%)">
            <div class="grid size-14 -rotate-6 place-items-center rounded-2xl bg-brand text-2xl font-extrabold text-white shadow-[0_10px_22px_-8px_rgba(7,168,107,0.7)]">P</div>
            <h2 class="mt-6 text-2xl font-extrabold">Profil yang rapi bikin pelanggan lebih percaya.</h2>
            <p class="mt-3 text-white/70">Setelah profil tersimpan, kamu bisa membuat link publik, form brief, QRIS, dan menerima order custom.</p>
            <div class="mt-8 space-y-3 text-sm">
                <div class="rounded-2xl bg-white/10 p-4">Satu link untuk katalog, brief, dan pembayaran</div>
                <div class="rounded-2xl bg-white/10 p-4">Cocok untuk 3D print, hampers, sablon, stiker, dan kue custom</div>
            </div>
        </aside>
    </section>
</x-layouts.app>
