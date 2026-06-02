<x-layouts.app title="Cek Status Pesanan">
    <section class="mx-auto max-w-xl px-4 py-10">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Cek Status</p>
            <h1 class="mt-2 text-3xl font-black text-slate-950">Masukkan kode pesanan</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Kode pesanan didapat setelah pelanggan mengirim brief custom, contohnya BID-ABC123.
            </p>

            <form method="POST" action="{{ route('orders.lookup.submit') }}" class="mt-6">
                @csrf
                <label class="block">
                    <span class="text-sm font-bold text-slate-700">Kode pesanan</span>
                    <input name="order_code" value="{{ old('order_code') }}" required placeholder="BID-ABC123" class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm uppercase focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                </label>
                <button class="mt-5 w-full rounded-full bg-emerald-600 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">
                    Lihat Status
                </button>
            </form>
        </div>
    </section>
</x-layouts.app>
