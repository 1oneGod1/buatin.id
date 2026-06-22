<x-layouts.app title="Paket Premium - PesanKustom.id">
    <section class="mx-auto max-w-6xl px-4 py-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Subscription</p>
                <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-ink">Pilih paket PesanKustom.id</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">Untuk MVP, halaman ini simulasi model bisnis freemium. Penjual bisa pakai paket Free, lalu upgrade untuk fitur operasional lebih lengkap.</p>
            </div>
            <div class="rounded-2xl border border-brand/20 bg-brand-soft px-4 py-3 text-sm font-extrabold text-brand-deep">
                Paket aktif: {{ $seller->planLabel() }}
            </div>
        </div>

        <div class="mt-8 grid gap-5 lg:grid-cols-3">
            @foreach ($plans as $key => $plan)
                @php($isActive = ($seller->plan ?? 'free') === $key)
                <article class="flex flex-col rounded-[22px] border-2 bg-white p-6 shadow-[0_2px_6px_rgba(22,33,28,0.05)] {{ $isActive ? 'border-brand' : 'border-line' }}">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-wide text-brand">{{ $plan['name'] }}</p>
                            <h2 class="mt-3 text-3xl font-extrabold text-ink">{{ $plan['price'] }}</h2>
                            <p class="mt-1 text-sm font-semibold text-faint">{{ $plan['period'] }}</p>
                        </div>
                        @if ($isActive)
                            <span class="rounded-full bg-brand px-3 py-1 text-xs font-extrabold text-white">Aktif</span>
                        @endif
                    </div>

                    <p class="mt-5 min-h-12 text-sm leading-6 text-muted">{{ $plan['description'] }}</p>

                    <ul class="mt-5 flex-1 space-y-3 text-sm text-ink">
                        @foreach ($plan['features'] as $feature)
                            <li class="flex gap-2">
                                <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-brand-soft text-xs font-extrabold text-brand-deep">✓</span>
                                <span>{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <form method="POST" action="{{ route('seller.subscription.update') }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $key }}">
                        <button class="w-full rounded-2xl px-5 py-4 text-sm font-extrabold {{ $isActive ? 'bg-cream text-faint' : 'bg-brand text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep' }}" @disabled($isActive)>
                            {{ $isActive ? 'Sedang digunakan' : 'Pilih paket ini' }}
                        </button>
                    </form>
                </article>
            @endforeach
        </div>

        <div class="mt-8 rounded-[22px] border border-sunny/40 bg-sunny-soft p-5 text-sm leading-6 text-sunny-ink">
            <p class="font-extrabold">Catatan MVP</p>
            <p class="mt-1">Integrasi pembayaran subscription dapat dikembangkan setelah validasi. Untuk sekarang, pembayaran pelanggan tetap memakai QRIS penjual; halaman ini menunjukkan rencana monetisasi PesanKustom.id.</p>
        </div>
    </section>
</x-layouts.app>
