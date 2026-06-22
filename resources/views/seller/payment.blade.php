<x-layouts.app title="Pengaturan Pembayaran - PesanKustom.id">
    @php($inp = 'mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15')
    <section class="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[1fr_360px]">
        <form method="POST" action="{{ route('seller.payment.update') }}" enctype="multipart/form-data" class="rounded-[22px] border border-line bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
            @csrf
            <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Payment Settings</p>
            <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-ink">Metode QRIS</h1>
            <p class="mt-2 text-muted">Kelola cara pelanggan membayar DP atau tagihan awal lewat QRIS.</p>

            <label class="mt-6 flex items-center justify-between rounded-2xl border border-brand/20 bg-brand-soft p-4">
                <span>
                    <span class="block font-extrabold text-brand-deep">Aktifkan pembayaran QRIS</span>
                    <span class="text-sm text-brand-deep/80">Terima pembayaran dari e-wallet dan m-banking.</span>
                </span>
                <input type="checkbox" name="qris_enabled" value="1" @checked($seller->qris_enabled) class="size-5 accent-brand">
            </label>

            <div class="mt-5">
                <label class="text-sm font-bold text-ink">Upload QRIS standar</label>
                <input type="file" name="qris" class="mt-2 w-full rounded-xl border border-dashed border-brand/40 bg-brand-soft/40 px-4 py-6 text-sm text-brand-deep">
            </div>
            <div class="mt-5"><label class="text-sm font-bold text-ink">Nama bank/e-wallet terkait</label><input name="payment_account" value="{{ old('payment_account', $seller->payment_account) }}" class="{{ $inp }}" placeholder="Contoh: BCA, GoPay, ShopeePay"></div>
            <div class="mt-5"><label class="text-sm font-bold text-ink">Instruksi pembayaran</label><textarea name="payment_instructions" rows="5" class="{{ $inp }}">{{ old('payment_instructions', $seller->payment_instructions) }}</textarea></div>
            <button class="mt-6 w-full rounded-2xl bg-brand px-6 py-4 font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Simpan Pembayaran</button>
        </form>

        <aside class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)] lg:sticky lg:top-24 lg:self-start">
            <p class="text-xs font-extrabold uppercase tracking-wide text-faint">Preview pembayaran</p>
            <div class="mt-4 rounded-[18px] border border-line p-5 text-center">
                @if ($seller->qris_path)
                    <img src="{{ app(\App\Services\Firebase\FirebaseStorageService::class)->url($seller->qris_path) }}" alt="QRIS" class="mx-auto aspect-square w-56 rounded-2xl object-cover">
                @else
                    <div class="mx-auto grid aspect-square w-56 place-items-center rounded-2xl border border-dashed border-brand/40 bg-brand-soft text-sm font-extrabold text-brand-deep">QRIS belum diupload</div>
                @endif
                <p class="mt-4 font-extrabold text-ink">{{ $seller->payment_account ?: 'QRIS Seller' }}</p>
                <p class="mt-2 text-sm text-muted">{{ $seller->payment_instructions ?: 'Instruksi pembayaran akan tampil di sini.' }}</p>
            </div>
        </aside>
    </section>
</x-layouts.app>
