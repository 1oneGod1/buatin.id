<x-layouts.app :title="'Ringkasan '.$order->order_code">
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_380px]">
        <div class="space-y-6">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                    <div>
                        <p class="text-sm font-black uppercase text-emerald-700">Ringkasan Pesanan</p>
                        <h1 class="mt-2 text-3xl font-black text-slate-950">{{ $order->order_code }}</h1>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Brief sudah tersimpan. Lanjutkan pembayaran jika diperlukan, lalu kirim ringkasan ke WhatsApp penjual.
                        </p>
                    </div>
                    <div class="rounded-lg bg-emerald-50 px-4 py-3 text-sm font-black text-emerald-800">
                        {{ $order->payment_status_label }}
                    </div>
                </div>

                <dl class="mt-6 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-lg bg-slate-50 p-4">
                        <dt class="text-xs font-black uppercase text-slate-500">Tipe pesanan</dt>
                        <dd class="mt-1 font-black text-slate-950">{{ $order->product_type }}</dd>
                    </div>
                    <div class="rounded-lg bg-amber-50 p-4">
                        <dt class="text-xs font-black uppercase text-amber-700">Estimasi awal</dt>
                        <dd class="mt-1 font-black text-amber-900">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</dd>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4">
                        <dt class="text-xs font-black uppercase text-slate-500">Jumlah</dt>
                        <dd class="mt-1 font-bold text-slate-950">{{ $order->quantity }} pcs</dd>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4">
                        <dt class="text-xs font-black uppercase text-slate-500">Deadline</dt>
                        <dd class="mt-1 font-bold text-slate-950">{{ $order->deadline?->format('d M Y') ?: '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-6 rounded-lg border border-slate-200 p-4">
                    <p class="text-sm font-black text-slate-950">Catatan pesanan</p>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $order->notes ?: 'Tidak ada catatan tambahan.' }}</p>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noreferrer" class="rounded-lg bg-emerald-600 px-5 py-3 text-center text-sm font-black text-white hover:bg-emerald-700">
                        Kirim ke WhatsApp Penjual
                    </a>
                    <a href="{{ route('orders.status', $order) }}" class="rounded-lg border border-slate-300 px-5 py-3 text-center text-sm font-black text-slate-700 hover:border-slate-400">
                        Pantau Status
                    </a>
                </div>
            </div>

            <div class="grid gap-3 rounded-lg border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-3">
                @foreach ([
                    ['1', 'Brief masuk', 'Data pesanan sudah tersimpan.'],
                    ['2', 'Bayar atau konfirmasi', 'Gunakan QRIS jika tersedia.'],
                    ['3', 'Chat penjual', 'Kirim ringkasan agar cepat diproses.'],
                ] as [$num, $title, $copy])
                    <div class="flex gap-3">
                        <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-slate-950 text-sm font-black text-white">{{ $num }}</span>
                        <div>
                            <p class="text-sm font-black text-slate-950">{{ $title }}</p>
                            <p class="mt-1 text-xs leading-5 text-slate-500">{{ $copy }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm lg:sticky lg:top-28 lg:self-start">
            <p class="text-sm font-black uppercase text-emerald-700">Pembayaran</p>
            <h2 class="mt-2 text-2xl font-black text-slate-950">{{ $order->seller->payment_account ?: $order->seller->brand_name }}</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                {{ $order->seller->payment_instructions ?: 'Diskusikan pembayaran dengan penjual melalui WhatsApp setelah ringkasan pesanan dikirim.' }}
            </p>

            <div class="mt-5 grid aspect-square place-items-center rounded-lg border border-dashed border-slate-300 bg-slate-50 p-6">
                @if ($order->seller->qris_enabled && $order->seller->qris_path)
                    <img src="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($order->seller->qris_path) }}" alt="QRIS {{ $order->seller->brand_name }}" class="max-h-full max-w-full rounded-lg object-contain">
                @else
                    <div class="text-center">
                        <p class="text-3xl font-black text-slate-300">QRIS</p>
                        <p class="mt-2 text-sm text-slate-500">QRIS belum aktif. Kirim ringkasan ke WhatsApp penjual untuk konfirmasi pembayaran.</p>
                    </div>
                @endif
            </div>

            @if ($order->seller->qris_enabled)
                <form method="POST" action="{{ route('orders.payment-proof', $order) }}" enctype="multipart/form-data" class="mt-5">
                    @csrf
                    <label class="block">
                        <span class="text-sm font-bold text-slate-700">Upload bukti pembayaran</span>
                        <input type="file" name="payment_proof" required class="mt-2 w-full rounded-lg border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm">
                    </label>
                    <button class="mt-4 w-full rounded-lg bg-slate-950 px-5 py-3 text-sm font-black text-white hover:bg-slate-800">
                        Unggah Bukti
                    </button>
                </form>
            @endif
        </aside>
    </section>
</x-layouts.app>
