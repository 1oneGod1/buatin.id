<x-layouts.app :title="'Status '.$order->order_code">
    <section class="mx-auto max-w-4xl px-4 py-8">
        <div class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)] md:p-8">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Status Pesanan</p>
                    <h1 class="mt-2 font-mono text-3xl font-extrabold text-ink">{{ $order->order_code }}</h1>
                    <p class="mt-2 text-sm text-muted">{{ $order->seller->brand_name }} · {{ $order->product_type }}</p>
                </div>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noreferrer" class="flex items-center justify-center gap-2 rounded-2xl bg-wa px-5 py-3 text-center text-sm font-extrabold text-white shadow-[0_12px_22px_-12px_rgba(37,211,102,0.8)] hover:opacity-90">
                    💬 Tanya Penjual
                </a>
            </div>

            @if ($order->status === 'cancelled')
                <div class="mt-8 flex items-center gap-3 rounded-2xl border border-coral/30 bg-coral-soft p-5 text-coral-ink">
                    <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-coral text-base font-extrabold text-white">✕</span>
                    <div>
                        <p class="font-extrabold">Pesanan dibatalkan</p>
                        <p class="mt-0.5 text-sm font-semibold">Hubungi penjual lewat WhatsApp jika ingin mendiskusikan pesanan ini kembali.</p>
                    </div>
                </div>
            @else
                @php
                    $steps = ['waiting_payment' => 'Menunggu bayar', 'received' => 'Diterima', 'processing' => 'Diproses', 'ready' => 'Siap', 'completed' => 'Selesai'];
                    $activeIndex = array_search($order->status, array_keys($steps), true);
                    $activeIndex = $activeIndex === false ? 0 : $activeIndex;
                @endphp

                <div class="mt-8 grid gap-3 md:grid-cols-5">
                    @foreach ($steps as $key => $label)
                        @php $isDone = $loop->index <= $activeIndex; @endphp
                        <div class="rounded-2xl border p-4 {{ $isDone ? 'border-brand/30 bg-brand-soft' : 'border-line bg-cream' }}">
                            <div class="grid size-8 place-items-center rounded-xl text-sm font-extrabold {{ $isDone ? 'bg-brand text-white' : 'border border-line bg-white text-faint' }}">
                                {{ $isDone ? '✓' : $loop->iteration }}
                            </div>
                            <p class="mt-3 text-sm font-extrabold {{ $isDone ? 'text-brand-deep' : 'text-muted' }}">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl bg-cream p-4">
                    <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Status produksi</p>
                    <p class="mt-1 font-extrabold text-ink">{{ $order->status_label }}</p>
                </div>
                <div class="rounded-2xl bg-cream p-4">
                    <p class="text-[11px] font-extrabold uppercase tracking-wide text-faint">Status pembayaran</p>
                    <p class="mt-1 font-extrabold text-ink">{{ $order->payment_status_label }}</p>
                </div>
                <div class="rounded-2xl bg-sunny-soft p-4">
                    <p class="text-[11px] font-extrabold uppercase tracking-wide text-sunny-ink">Estimasi awal</p>
                    <p class="mt-1 font-extrabold text-sunny-ink">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</p>
                </div>
            </div>

            @if ($order->payment_proof_path)
                <div class="mt-6 flex items-center gap-2 rounded-2xl border border-brand/20 bg-brand-soft p-4 text-sm font-bold text-brand-deep">
                    <span class="grid size-5 place-items-center rounded-full bg-brand text-xs text-white">✓</span>
                    Bukti pembayaran sudah diunggah dan menunggu konfirmasi penjual.
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
