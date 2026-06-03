<x-layouts.app title="Paket Premium - Buatin.id">
    <section class="mx-auto max-w-6xl px-4 py-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-emerald-700">Subscription</p>
                <h1 class="mt-2 text-3xl font-black text-slate-950">Pilih paket Buatin.id</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                    Untuk MVP, halaman ini dipakai sebagai simulasi model bisnis freemium. Penjual bisa memakai paket Free, lalu upgrade untuk fitur operasional yang lebih lengkap.
                </p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800">
                Paket aktif: {{ $seller->planLabel() }}
            </div>
        </div>

        <div class="mt-8 grid gap-5 lg:grid-cols-3">
            @foreach ($plans as $key => $plan)
                @php($isActive = ($seller->plan ?? 'free') === $key)
                <article class="flex flex-col rounded-[2rem] border bg-white p-6 shadow-sm {{ $isActive ? 'border-emerald-300 ring-2 ring-emerald-100' : 'border-slate-200' }}">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-black uppercase tracking-[0.14em] text-emerald-700">{{ $plan['name'] }}</p>
                            <h2 class="mt-3 text-3xl font-black text-slate-950">{{ $plan['price'] }}</h2>
                            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $plan['period'] }}</p>
                        </div>
                        @if ($isActive)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-black text-emerald-800">Aktif</span>
                        @endif
                    </div>

                    <p class="mt-5 min-h-12 text-sm leading-6 text-slate-600">{{ $plan['description'] }}</p>

                    <ul class="mt-5 flex-1 space-y-3 text-sm text-slate-700">
                        @foreach ($plan['features'] as $feature)
                            <li class="flex gap-2">
                                <span class="mt-0.5 grid size-5 place-items-center rounded-full bg-emerald-100 text-xs font-black text-emerald-700">✓</span>
                                <span>{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <form method="POST" action="{{ route('seller.subscription.update') }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $key }}">
                        <button class="w-full rounded-2xl px-5 py-4 text-sm font-black {{ $isActive ? 'bg-slate-100 text-slate-500' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}" @disabled($isActive)>
                            {{ $isActive ? 'Sedang digunakan' : 'Pilih paket ini' }}
                        </button>
                    </form>
                </article>
            @endforeach
        </div>

        <div class="mt-8 rounded-[2rem] border border-amber-200 bg-amber-50 p-5 text-sm leading-6 text-amber-900">
            <p class="font-black">Catatan MVP</p>
            <p class="mt-1">
                Integrasi pembayaran subscription dapat dikembangkan setelah validasi. Untuk sekarang, pembayaran pelanggan tetap memakai QRIS penjual, sedangkan halaman ini menunjukkan rencana monetisasi Buatin.id.
            </p>
        </div>
    </section>
</x-layouts.app>
