<x-layouts.app :title="'Ringkasan '.$order->order_code">
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_0.9fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Ringkasan Pesanan</p>
            <h1 class="mt-2 text-3xl font-black text-slate-950">{{ $order->order_code }}</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Brief sudah tersimpan. Lanjutkan dengan pembayaran awal via QRIS, lalu kirim ringkasan ke WhatsApp penjual.
            </p>

            <dl class="mt-6 grid gap-3 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <dt class="text-xs font-bold uppercase text-slate-500">Produk</dt>
                    <dd class="mt-1 font-bold text-slate-950">{{ $order->product_type }}</dd>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <dt class="text-xs font-bold uppercase text-slate-500">Estimasi awal</dt>
                    <dd class="mt-1 font-black text-emerald-700">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</dd>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <dt class="text-xs font-bold uppercase text-slate-500">Jumlah</dt>
                    <dd class="mt-1 font-bold text-slate-950">{{ $order->quantity }} pcs</dd>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <dt class="text-xs font-bold uppercase text-slate-500">Deadline</dt>
                    <dd class="mt-1 font-bold text-slate-950">{{ $order->deadline?->format('d M Y') ?: '-' }}</dd>
                </div>
            </dl>

            <div class="mt-6 rounded-2xl border border-slate-200 p-4">
                <p class="text-sm font-bold text-slate-950">Catatan pesanan</p>
                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $order->notes ?: 'Tidak ada catatan tambahan.' }}</p>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noreferrer" class="rounded-full bg-emerald-600 px-5 py-3 text-center text-sm font-black text-white hover:bg-emerald-700">
                    Kirim ke WhatsApp Penjual
                </a>
                <a href="{{ route('orders.status', $order) }}" class="rounded-full border border-slate-300 px-5 py-3 text-center text-sm font-black text-slate-700 hover:bg-slate-50">
                    Pantau Status
                </a>
            </div>
        </div>

        <aside class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Pembayaran QRIS</p>
            <h2 class="mt-2 text-2xl font-black text-slate-950">{{ $order->seller->payment_account ?: $order->seller->brand_name }}</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $order->seller->payment_instructions }}</p>

            <div class="mt-5 grid aspect-square place-items-center rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-6">
                @if ($order->seller->qris_path)
                    <img src="{{ asset('storage/'.$order->seller->qris_path) }}" alt="QRIS {{ $order->seller->brand_name }}" class="max-h-full max-w-full rounded-2xl object-contain">
                @else
                    <div class="text-center">
                        <p class="text-3xl font-black text-slate-300">QRIS</p>
                        <p class="mt-2 text-sm text-slate-500">Penjual belum mengunggah QRIS.</p>
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('orders.payment-proof', $order) }}" enctype="multipart/form-data" class="mt-5">
                @csrf
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Upload bukti pembayaran</span>
                    <input type="file" name="payment_proof" required class="mt-2 w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-4 text-sm">
                </label>
                <button class="mt-4 w-full rounded-full bg-slate-950 px-5 py-3 text-sm font-black text-white hover:bg-slate-800">
                    Unggah Bukti
                </button>
            </form>
        </aside>
    </section>
</x-layouts.app>
