<x-layouts.app title="Cek Status Pesanan">
    <section class="mx-auto max-w-xl px-4 py-10">
        <div class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)] md:p-7">
            <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Cek Status</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-ink">Masukkan kode pesanan</h1>
            <p class="mt-3 text-sm leading-6 text-muted">Kode pesanan didapat setelah pelanggan mengirim brief custom, contohnya <span class="font-mono font-bold text-brand">BID-ABC123</span>.</p>

            <form method="POST" action="{{ route('orders.lookup.submit') }}" class="mt-6">
                @csrf
                <label class="block">
                    <span class="text-sm font-bold text-ink">Kode pesanan</span>
                    <input name="order_code" value="{{ old('order_code') }}" required placeholder="BID-ABC123" class="mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-sm uppercase text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15">
                </label>
                <button class="mt-5 w-full rounded-2xl bg-brand px-5 py-3.5 text-sm font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">
                    Lihat Status
                </button>
            </form>
        </div>
    </section>
</x-layouts.app>
