<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'PesanKustom.id' }}</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="overflow-x-hidden text-ink antialiased">
    @php
        $isSellerArea = request()->routeIs('seller.*');
        $authUser = auth()->user();
        $mySeller = $authUser?->seller;
        $demoSeller = \App\Models\Seller::query()->oldest('id')->first();
        $currentSeller = request()->route('seller') instanceof \App\Models\Seller
            ? request()->route('seller')
            : ($mySeller ?: $demoSeller);
    @endphp
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-40 border-b border-line bg-white/70 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-lg font-extrabold tracking-tight text-ink">
                    <span class="grid size-9 -rotate-6 place-items-center rounded-[14px] bg-brand text-xl font-extrabold text-white shadow-[0_10px_22px_-8px_rgba(7,168,107,0.7)]">P</span>
                    <span>PesanKustom<span class="text-brand">.id</span></span>
                </a>
                <nav class="hidden items-center gap-1 text-sm font-bold text-muted md:flex">
                    @if ($isSellerArea)
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('seller.page-builder') }}">Halaman</a>
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('seller.products.index') }}">Produk</a>
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('seller.form-builder') }}">Form</a>
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('seller.payment') }}">QRIS</a>
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('seller.subscription') }}">Paket</a>
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('seller.orders.index') }}">Order</a>
                    @else
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ $demoSeller ? route('public.store', $demoSeller) : route('register') }}">Contoh Toko</a>
                        <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('orders.lookup') }}">Cek Status</a>
                        @auth
                            <a class="rounded-full px-3 py-2 hover:bg-brand-soft hover:text-brand-deep" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        @endauth
                    @endif
                </nav>
                <div class="flex shrink-0 items-center gap-2">
                    @auth
                        @if ($isSellerArea && $currentSeller)
                            <a href="{{ route('public.store', $currentSeller) }}" class="rounded-2xl bg-brand px-4 py-2.5 text-sm font-extrabold text-white shadow-[0_10px_20px_-9px_rgba(7,168,107,0.8)] hover:bg-brand-deep">
                                <span class="hidden sm:inline">Toko Publik</span>
                                <span class="sm:hidden">Toko</span>
                            </a>
                        @elseif (! $isSellerArea)
                            <a href="{{ route('seller.dashboard') }}" class="rounded-2xl bg-brand px-4 py-2.5 text-sm font-extrabold text-white shadow-[0_10px_20px_-9px_rgba(7,168,107,0.8)] hover:bg-brand-deep">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-2xl border-[1.5px] border-line bg-white px-3 py-2.5 text-sm font-bold text-muted hover:border-brand hover:text-brand-deep">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-2xl px-3 py-2.5 text-sm font-bold text-ink hover:bg-brand-soft">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-2xl bg-brand px-4 py-2.5 text-sm font-extrabold text-white shadow-[0_10px_20px_-9px_rgba(7,168,107,0.8)] hover:bg-brand-deep">
                            <span class="hidden sm:inline">Mulai Gratis</span>
                            <span class="sm:hidden">Mulai</span>
                        </a>
                    @endauth
                </div>
            </div>
            <div class="border-t border-line/70 md:hidden">
                <nav class="mx-auto flex max-w-6xl gap-2 overflow-x-auto px-4 py-2 text-xs font-bold text-muted">
                    @if ($isSellerArea)
                        <a class="shrink-0 rounded-full bg-brand-soft px-3 py-2 text-brand-deep" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        <a class="shrink-0 rounded-full bg-white px-3 py-2" href="{{ route('seller.products.index') }}">Produk</a>
                        <a class="shrink-0 rounded-full bg-white px-3 py-2" href="{{ route('seller.form-builder') }}">Form</a>
                        <a class="shrink-0 rounded-full bg-white px-3 py-2" href="{{ route('seller.payment') }}">QRIS</a>
                        <a class="shrink-0 rounded-full bg-white px-3 py-2" href="{{ route('seller.subscription') }}">Paket</a>
                        <a class="shrink-0 rounded-full bg-white px-3 py-2" href="{{ route('seller.orders.index') }}">Order</a>
                    @else
                        <a class="shrink-0 rounded-full bg-brand-soft px-3 py-2 text-brand-deep" href="{{ $demoSeller ? route('public.store', $demoSeller) : route('register') }}">Contoh Toko</a>
                        <a class="shrink-0 rounded-full bg-white px-3 py-2" href="{{ route('orders.lookup') }}">Cek Status</a>
                        @auth
                            <a class="shrink-0 rounded-full bg-white px-3 py-2" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <main class="flex-1">
            @if (session('status'))
                <div class="mx-auto mt-4 max-w-6xl px-4">
                    <div class="flex items-center gap-2 rounded-2xl border border-brand/20 bg-brand-soft px-4 py-3 text-sm font-bold text-brand-deep">
                        <span class="grid size-5 place-items-center rounded-full bg-brand text-xs text-white">✓</span>
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-auto mt-4 max-w-6xl px-4">
                    <div class="rounded-2xl border border-coral/30 bg-coral-soft px-4 py-3 text-sm text-coral-ink">
                        <strong class="font-extrabold">Ada input yang perlu dicek:</strong>
                        <ul class="mt-2 list-disc space-y-1 pl-5 font-semibold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="mt-12 border-t border-line bg-white/60">
            <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-6 text-sm font-semibold text-muted md:flex-row md:items-center md:justify-between">
                <p><strong class="font-extrabold text-brand-deep">PesanKustom.id</strong> — halaman pesanan custom untuk kreator & UMKM.</p>
                <div class="flex flex-wrap gap-4 font-bold">
                    <a href="{{ route('register') }}" class="hover:text-brand-deep">Mulai Gratis</a>
                    @if ($demoSeller)
                        <a href="{{ route('public.store', $demoSeller) }}" class="hover:text-brand-deep">Contoh Toko</a>
                    @endif
                    <a href="{{ route('orders.lookup') }}" class="hover:text-brand-deep">Cek Status</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
