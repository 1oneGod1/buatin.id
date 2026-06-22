<x-layouts.app title="Form Builder - PesanKustom.id">
    @php($fields = $seller->enabledFields())
    @php($fieldLabels = [
        'material' => 'Material', 'size' => 'Ukuran', 'color' => 'Warna', 'quantity' => 'Jumlah',
        'deadline' => 'Deadline', 'budget' => 'Budget', 'reference' => 'Upload referensi', 'notes' => 'Catatan tambahan',
    ])
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_400px]">
        <form method="POST" action="{{ route('seller.form-builder.update') }}" class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
            @csrf
            <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Form Builder</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-ink">Atur field brief custom</h1>
            <p class="mt-2 text-muted">Pilih detail tambahan yang dikumpulkan dari pelanggan. Field nama, WhatsApp, produk acuan, dan tipe pesanan custom tetap ada di form utama.</p>

            <div class="mt-6 grid gap-3">
                @foreach ($fieldLabels as $key => $label)
                    <label class="flex items-center justify-between rounded-2xl border border-line bg-cream px-4 py-3">
                        <span class="font-extrabold text-ink">{{ $label }}</span>
                        <input type="checkbox" name="fields[{{ $key }}]" value="1" @checked($fields[$key] ?? false) class="size-5 accent-brand">
                    </label>
                @endforeach
            </div>

            <button class="mt-6 w-full rounded-2xl bg-brand px-6 py-4 font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Simpan Konfigurasi</button>
        </form>

        <aside class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)] lg:sticky lg:top-24 lg:self-start">
            <p class="text-xs font-extrabold uppercase tracking-wide text-faint">Live preview form</p>
            <div class="mt-4 rounded-[18px] bg-cream p-4">
                <h2 class="text-xl font-extrabold text-ink">Brief Pesanan</h2>
                <p class="mt-1 text-sm text-muted">Mohon lengkapi detail pesanan Anda.</p>
                <div class="mt-5 space-y-2.5">
                    @foreach (['Nama pelanggan', 'WhatsApp pelanggan', 'Produk acuan dari katalog', 'Tipe pesanan custom'] as $base)
                        <div class="rounded-xl border border-line bg-white p-3 text-sm font-semibold text-muted">{{ $base }}</div>
                    @endforeach
                    @foreach ($fields as $key => $enabled)
                        @if ($enabled)
                            <div class="rounded-xl border border-brand/20 bg-brand-soft p-3 text-sm font-bold text-brand-deep">{{ $fieldLabels[$key] ?? $key }}</div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-5 rounded-xl bg-brand px-4 py-3 text-center text-sm font-extrabold text-white">Lihat Ringkasan</div>
            </div>
        </aside>
    </section>
</x-layouts.app>
