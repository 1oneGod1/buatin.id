<x-layouts.app :title="'Ringkasan '.$order->order_code">
    @php($pc = match($order->payment_status) { 'paid' => 'bg-brand-soft text-brand-deep', 'proof_uploaded' => 'bg-sunny-soft text-sunny-ink', default => 'bg-coral-soft text-coral-ink' })

    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_380px]">
        <div class="space-y-6">
            <div class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Ringkasan Pesanan</p>
                        <h1 class="mt-2 font-mono text-3xl font-extrabold text-ink">{{ $order->order_code }}</h1>
                        <p class="mt-2 max-w-md text-sm leading-6 text-muted">Brief sudah tersimpan. Lanjutkan pembayaran jika perlu, lalu kirim ringkasan ke WhatsApp penjual.</p>
                    </div>
                    <span class="shrink-0 rounded-full px-4 py-2 text-sm font-extrabold {{ $pc }}">{{ $order->payment_status_label }}</span>
                </div>

                <dl class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl bg-cream p-4">
                        <dt class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Tipe pesanan</dt>
                        <dd class="mt-1 font-extrabold text-ink">{{ $order->product_type }}</dd>
                    </div>
                    <div class="rounded-2xl bg-sunny-soft p-4">
                        <dt class="text-[11px] font-extrabold uppercase tracking-wide text-sunny-ink">Estimasi awal</dt>
                        <dd class="mt-1 text-lg font-extrabold text-sunny-ink">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</dd>
                    </div>
                    <div class="rounded-2xl bg-cream p-4">
                        <dt class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Jumlah</dt>
                        <dd class="mt-1 font-bold text-ink">{{ $order->quantity }} pcs</dd>
                    </div>
                    <div class="rounded-2xl bg-cream p-4">
                        <dt class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Deadline</dt>
                        <dd class="mt-1 font-bold text-ink">{{ $order->deadline?->format('d M Y') ?: '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-6 rounded-2xl border border-line p-4">
                    <p class="text-sm font-extrabold text-ink">Catatan pesanan</p>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-muted">{{ $order->notes ?: 'Tidak ada catatan tambahan.' }}</p>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noreferrer" class="flex items-center justify-center gap-2 rounded-2xl bg-wa px-5 py-3.5 text-center text-sm font-extrabold text-white shadow-[0_12px_22px_-12px_rgba(37,211,102,0.8)] hover:opacity-90">
                        💬 Kirim ke WhatsApp Penjual
                    </a>
                    <a href="{{ route('orders.status', $order) }}" class="rounded-2xl border-[1.5px] border-line px-5 py-3.5 text-center text-sm font-extrabold text-ink hover:border-brand">
                        Pantau Status
                    </a>
                </div>
            </div>

            <div class="grid gap-3 rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)] md:grid-cols-3">
                @foreach ([
                    ['Brief masuk', 'Data pesanan sudah tersimpan.', 'bg-brand text-white'],
                    ['Bayar / konfirmasi', 'Gunakan QRIS jika tersedia.', 'bg-sky text-white'],
                    ['Chat penjual', 'Kirim ringkasan agar cepat diproses.', 'bg-lilac text-white'],
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
        </div>

        <aside class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)] lg:sticky lg:top-24 lg:self-start">
            <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Pembayaran</p>
            <h2 class="mt-2 text-2xl font-extrabold text-ink">{{ $order->seller->payment_account ?: $order->seller->brand_name }}</h2>
            <p class="mt-3 text-sm leading-6 text-muted">{{ $order->seller->payment_instructions ?: 'Diskusikan pembayaran dengan penjual lewat WhatsApp setelah ringkasan dikirim.' }}</p>

            <div class="mt-5 grid aspect-square place-items-center overflow-hidden rounded-2xl border border-line bg-cream p-4">
                @if ($order->seller->qris_enabled && $order->seller->qris_path)
                    <img src="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($order->seller->qris_path) }}" alt="QRIS {{ $order->seller->brand_name }}" class="max-h-full max-w-full rounded-xl object-contain">
                @else
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-faint">QRIS</p>
                        <p class="mt-2 text-sm text-muted">QRIS belum aktif. Kirim ringkasan ke WhatsApp penjual untuk konfirmasi pembayaran.</p>
                    </div>
                @endif
            </div>

            @if ($order->seller->qris_enabled)
                <form method="POST" action="{{ route('orders.payment-proof', $order) }}" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    <label class="block">
                        <span class="text-sm font-bold text-ink">Upload bukti pembayaran</span>
                        <input type="file" name="payment_proof" required class="mt-2 w-full rounded-xl border border-dashed border-line bg-cream px-4 py-4 text-sm text-muted">
                    </label>
                    <button class="mt-4 w-full rounded-2xl bg-ink px-5 py-3.5 text-sm font-extrabold text-white hover:opacity-90">Unggah Bukti</button>
                </form>
            @endif
        </aside>
    </section>
</x-layouts.app>
