<x-layouts.app title="Detail Pesanan {{ $order->order_code }} - PesanKustom.id">
    @php($pc = match($order->payment_status) { 'paid' => 'bg-brand-soft text-brand-deep', 'proof_uploaded' => 'bg-sunny-soft text-sunny-ink', default => 'bg-coral-soft text-coral-ink' })
    @php($sel = 'mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15')

    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_360px]">
        <div class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div>
                    <p class="font-mono text-xs font-extrabold uppercase tracking-wide text-brand">{{ $order->order_code }}</p>
                    <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-ink">{{ $order->product_type }}</h1>
                    <p class="mt-2 text-muted">{{ $order->customer_name }} · {{ $order->customer_whatsapp }}</p>
                </div>
                <span class="shrink-0 rounded-full px-4 py-2 text-sm font-extrabold {{ $pc }}">{{ $order->payment_status_label }}</span>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                @foreach ([
                    'Material' => $order->material, 'Ukuran' => $order->size, 'Warna' => $order->color,
                    'Jumlah' => $order->quantity, 'Deadline' => $order->deadline?->format('d M Y'), 'Budget' => $order->budget,
                ] as $label => $value)
                    <div class="rounded-2xl bg-cream p-4">
                        <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">{{ $label }}</p>
                        <p class="mt-1 font-bold text-ink">{{ $value ?: '-' }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 rounded-2xl bg-cream p-4">
                <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Catatan pelanggan</p>
                <p class="mt-2 whitespace-pre-line text-muted">{{ $order->notes ?: 'Tidak ada catatan tambahan.' }}</p>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-line p-4">
                    <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Referensi desain</p>
                    @if ($order->reference_path)
                        <a href="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($order->reference_path) }}" target="_blank" class="mt-3 inline-flex rounded-xl bg-sky-soft px-4 py-2 text-sm font-extrabold text-sky-ink">Buka file referensi</a>
                    @else
                        <p class="mt-3 text-sm text-faint">Belum ada file.</p>
                    @endif
                </div>
                <div class="rounded-2xl border border-line p-4">
                    <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Bukti pembayaran</p>
                    @if ($order->payment_proof_path)
                        <a href="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($order->payment_proof_path) }}" target="_blank" class="mt-3 inline-flex rounded-xl bg-brand-soft px-4 py-2 text-sm font-extrabold text-brand-deep">Buka bukti pembayaran</a>
                    @else
                        <p class="mt-3 text-sm text-coral-ink">Bukti belum diterima.</p>
                    @endif
                </div>
            </div>
        </div>

        <aside class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)] lg:sticky lg:top-24 lg:self-start">
            <h2 class="text-xl font-extrabold text-ink">Update status</h2>
            <p class="mt-2 text-sm text-muted">Total estimasi: <strong class="font-extrabold text-ink">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</strong></p>
            <form method="POST" action="{{ route('seller.orders.update', $order) }}" class="mt-5 space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="text-sm font-bold text-ink">Status pesanan</label>
                    <select name="status" class="{{ $sel }}">
                        @foreach (['received' => 'Pesanan diterima', 'waiting_payment' => 'Menunggu pembayaran', 'processing' => 'Diproses', 'ready' => 'Siap diambil/dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                            <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-bold text-ink">Status pembayaran</label>
                    <select name="payment_status" class="{{ $sel }}">
                        @foreach (['unpaid' => 'Belum bayar', 'proof_uploaded' => 'Bukti diunggah', 'paid' => 'Terkonfirmasi'] as $value => $label)
                            <option value="{{ $value }}" @selected($order->payment_status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="w-full rounded-2xl bg-brand px-5 py-4 font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Simpan status</button>
            </form>
            <a href="{{ $whatsappUrl }}" target="_blank" class="mt-4 flex items-center justify-center gap-2 rounded-2xl bg-wa px-5 py-3.5 text-center font-extrabold text-white hover:opacity-90">💬 Chat pelanggan</a>
            <a href="{{ route('orders.status', $order) }}" class="mt-3 block text-center text-sm font-bold text-faint hover:text-brand-deep">Lihat halaman status customer</a>
        </aside>
    </section>
</x-layouts.app>
