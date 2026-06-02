<x-layouts.app :title="'Status '.$order->order_code">
    <section class="mx-auto max-w-4xl px-4 py-8">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Status Pesanan</p>
            <div class="mt-2 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                <div>
                    <h1 class="text-3xl font-black text-slate-950">{{ $order->order_code }}</h1>
                    <p class="mt-2 text-sm text-slate-600">{{ $order->seller->brand_name }} - {{ $order->product_type }}</p>
                </div>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noreferrer" class="rounded-full bg-emerald-600 px-5 py-3 text-center text-sm font-black text-white hover:bg-emerald-700">
                    Tanya Penjual
                </a>
            </div>

            @php
                $steps = ['waiting_payment' => 'Menunggu bayar', 'received' => 'Diterima', 'processing' => 'Diproses', 'ready' => 'Siap', 'completed' => 'Selesai'];
                $activeIndex = array_search($order->status, array_keys($steps), true);
                $activeIndex = $activeIndex === false ? 0 : $activeIndex;
            @endphp

            <div class="mt-8 grid gap-3 md:grid-cols-5">
                @foreach ($steps as $key => $label)
                    @php $isDone = $loop->index <= $activeIndex; @endphp
                    <div class="rounded-2xl border p-4 {{ $isDone ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-slate-50' }}">
                        <div class="grid size-8 place-items-center rounded-full {{ $isDone ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                            {{ $loop->iteration }}
                        </div>
                        <p class="mt-3 text-sm font-black {{ $isDone ? 'text-emerald-900' : 'text-slate-600' }}">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase text-slate-500">Status produksi</p>
                    <p class="mt-1 font-black text-slate-950">{{ $order->status_label }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase text-slate-500">Status pembayaran</p>
                    <p class="mt-1 font-black text-slate-950">{{ $order->payment_status_label }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase text-slate-500">Estimasi awal</p>
                    <p class="mt-1 font-black text-emerald-700">Rp{{ number_format($order->estimated_price, 0, ',', '.') }}</p>
                </div>
            </div>

            @if ($order->payment_proof_path)
                <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-900">
                    Bukti pembayaran sudah diunggah dan menunggu konfirmasi penjual.
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
