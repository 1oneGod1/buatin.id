<x-layouts.app title="Form Builder - Buatin.id">
    @php($fields = $seller->enabledFields())
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_420px]">
        <form method="POST" action="{{ route('seller.form-builder.update') }}" class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            @csrf
            <p class="text-sm font-bold text-emerald-700">Form Builder</p>
            <h1 class="mt-1 text-3xl font-black">Atur field brief custom</h1>
            <p class="mt-2 text-slate-600">Pilih informasi apa saja yang wajib diisi pelanggan sebelum pesanan dikirim.</p>

            <div class="mt-6 grid gap-3">
                @foreach ([
                    'material' => 'Material',
                    'size' => 'Ukuran',
                    'color' => 'Warna',
                    'quantity' => 'Jumlah',
                    'deadline' => 'Deadline',
                    'budget' => 'Budget',
                    'reference' => 'Upload referensi',
                    'notes' => 'Catatan tambahan',
                ] as $key => $label)
                    <label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <span class="font-bold text-slate-800">{{ $label }}</span>
                        <input type="checkbox" name="fields[{{ $key }}]" value="1" @checked($fields[$key] ?? false) class="size-5 accent-emerald-600">
                    </label>
                @endforeach
            </div>

            <button class="mt-6 w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">Simpan Konfigurasi</button>
        </form>

        <aside class="rounded-[2rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-slate-500">Live preview form</p>
            <div class="mt-4 rounded-[1.5rem] bg-slate-50 p-4">
                <h2 class="text-xl font-black">Brief Pesanan</h2>
                <p class="mt-1 text-sm text-slate-500">Mohon lengkapi detail pesanan Anda.</p>
                <div class="mt-5 space-y-3">
                    <div class="rounded-2xl bg-white p-3 text-sm font-semibold text-slate-600">Nama pelanggan</div>
                    <div class="rounded-2xl bg-white p-3 text-sm font-semibold text-slate-600">Jenis produk</div>
                    @foreach ($fields as $key => $enabled)
                        @if ($enabled)
                            <div class="rounded-2xl bg-white p-3 text-sm font-semibold text-slate-600">{{ Str::headline($key) }}</div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-5 rounded-2xl bg-emerald-600 px-4 py-3 text-center text-sm font-black text-white">Lihat Ringkasan</div>
            </div>
        </aside>
    </section>
</x-layouts.app>
