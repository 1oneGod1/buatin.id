<x-layouts.app title="Detail Pesanan {{ $order->order_code }} - Buatin.id">
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_360px]">
        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div>
                    <p class="text-sm font-bold text-emerald-700">{{ $order->order_code }}</p>
                    <h1 class="mt-1 text-3xl font-black">{{ $order->product_type }}</h1>
                    <p class="mt-2 text-slate-600">{{ $order->customer_name }} · {{ $order->customer_whatsapp }}</p>
                </div>
                <span class="rounded-full bg-amber-100 px-4 py-2 text-sm font-black text-amber-800">{{ $order->payment_status_label }}</span>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                @foreach ([
                    'Material' => $order->material,
                    'Ukuran' => $order->size,
                    'Warna' => $order->color,
                    'Jumlah' => $order->quantity,
                    'Deadline' => $order->deadline?->format('d M Y'),
                    'Budget' => $order->budget,
                ] as $label => $value)
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-xs font-black uppercase text-slate-500">{{ $label }}</p>
                        <p class="mt-1 font-bold">{{ $value ?: '-' }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 rounded-2xl bg-slate-50 p-4">
                <p class="text-xs font-black uppercase text-slate-500">Catatan pelanggan</p>
                <p class="mt-2 text-slate-700">{{ $order->notes ?: 'Tidak ada catatan tambahan.' }}</p>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="text-xs font-black uppercase text-slate-500">Referensi desain</p>
                    @if ($order->reference_path)
                        <a href="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($order->reference_path) }}" target="_blank" class="mt-3 inline-flex rounded-xl bg-blue-50 px-4 py-2 text-sm font-bold text-blue-700">Buka file referensi</a>
                    @else
                        <p class="mt-3 text-sm text-slate-500">Belum ada file.</p>
                    @endif
                </div>
                <div class="rounded-2xl border border-slate-200 p-4">
                    <p class="text-xs font-black uppercase text-slate-500">Bukti pembayaran</p>
                    @if ($order->payment_proof_path)
                        <a href="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($order->payment_proof_path) }}" target="_blank" class="mt-3 inline-flex rounded-xl bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700">Buka bukti pembayaran</a>
                    @else
                        <p class="mt-3 text-sm text-red-500">Bukti belum diterima.</p>
                    @endif
                </div>
            </div>
        </div>

        <aside class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-xl font-black">Update status</h2>
            <p class="mt-2 text-sm text-slate-500">Total estimasi: <strong class="text-slate-900">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</strong></p>
            <form method="POST" action="{{ route('seller.orders.update', $order) }}" class="mt-5 space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="text-sm font-bold">Status pesanan</label>
                    <select name="status" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                        @foreach (['received' => 'Pesanan diterima', 'waiting_payment' => 'Menunggu pembayaran', 'processing' => 'Diproses', 'ready' => 'Siap diambil/dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                            <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-bold">Status pembayaran</label>
                    <select name="payment_status" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                        @foreach (['unpaid' => 'Belum bayar', 'proof_uploaded' => 'Bukti diunggah', 'paid' => 'Terkonfirmasi'] as $value => $label)
                            <option value="{{ $value }}" @selected($order->payment_status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="w-full rounded-2xl bg-emerald-600 px-5 py-4 font-black text-white">Simpan status</button>
            </form>
            <a href="{{ $whatsappUrl }}" target="_blank" class="mt-4 block rounded-2xl border border-emerald-200 px-5 py-4 text-center font-black text-emerald-700">Chat pelanggan</a>
            <a href="{{ route('orders.status', $order) }}" class="mt-3 block text-center text-sm font-bold text-slate-500">Lihat halaman status customer</a>
        </aside>
    </section>
</x-layouts.app>
