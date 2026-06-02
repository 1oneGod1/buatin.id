<x-layouts.app title="Pengaturan Pembayaran - Buatin.id">
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_380px]">
        <form method="POST" action="{{ route('seller.payment.update') }}" enctype="multipart/form-data" class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
            @csrf
            <p class="text-sm font-bold text-emerald-700">Payment Settings</p>
            <h1 class="mt-1 text-3xl font-black">Metode QRIS</h1>
            <p class="mt-2 text-slate-600">Kelola cara pelanggan membayar DP atau tagihan awal melalui QRIS.</p>

            <label class="mt-6 flex items-center justify-between rounded-2xl bg-emerald-50 p-4">
                <span>
                    <span class="block font-black text-emerald-900">Aktifkan pembayaran QRIS</span>
                    <span class="text-sm text-emerald-700">Terima pembayaran dari e-wallet dan m-banking.</span>
                </span>
                <input type="checkbox" name="qris_enabled" value="1" @checked($seller->qris_enabled) class="size-5 accent-emerald-600">
            </label>

            <div class="mt-5">
                <label class="text-sm font-bold text-slate-700">Upload QRIS standar</label>
                <input type="file" name="qris" class="mt-2 w-full rounded-2xl border border-dashed border-emerald-300 bg-emerald-50/40 px-4 py-6 text-sm">
            </div>
            <div class="mt-5">
                <label class="text-sm font-bold text-slate-700">Nama bank/e-wallet terkait</label>
                <input name="payment_account" value="{{ old('payment_account', $seller->payment_account) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-emerald-500" placeholder="Contoh: BCA, GoPay, ShopeePay">
            </div>
            <div class="mt-5">
                <label class="text-sm font-bold text-slate-700">Instruksi pembayaran</label>
                <textarea name="payment_instructions" rows="5" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-emerald-500">{{ old('payment_instructions', $seller->payment_instructions) }}</textarea>
            </div>
            <button class="mt-6 w-full rounded-2xl bg-emerald-700 px-6 py-4 font-black text-white hover:bg-emerald-800">Simpan Pembayaran</button>
        </form>

        <aside class="rounded-[2rem] bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-slate-500">Preview pembayaran</p>
            <div class="mt-4 rounded-[1.5rem] border border-emerald-100 p-5 text-center">
                @if ($seller->qris_path)
                    <img src="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($seller->qris_path) }}" alt="QRIS" class="mx-auto aspect-square w-56 rounded-2xl object-cover">
                @else
                    <div class="mx-auto grid aspect-square w-56 place-items-center rounded-2xl border border-dashed border-emerald-300 bg-emerald-50 text-sm font-bold text-emerald-700">QRIS belum diupload</div>
                @endif
                <p class="mt-4 font-black">{{ $seller->payment_account ?: 'QRIS Seller' }}</p>
                <p class="mt-2 text-sm text-slate-500">{{ $seller->payment_instructions ?: 'Instruksi pembayaran akan tampil di sini.' }}</p>
            </div>
        </aside>
    </section>
</x-layouts.app>
