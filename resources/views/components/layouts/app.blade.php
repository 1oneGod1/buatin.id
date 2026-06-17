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
<body class="overflow-x-hidden bg-slate-50 text-slate-900 antialiased">
    @php
        $isSellerArea = request()->routeIs('seller.*');
        $authUser = auth()->user();
        $mySeller = $authUser?->seller;
        $demoSeller = \App\Models\Seller::query()->oldest('id')->first();
        $currentSeller = request()->route('seller') instanceof \App\Models\Seller
            ? request()->route('seller')
            : ($mySeller ?: $demoSeller);
    @endphp
    <div class="min-h-screen">
        <header class="sticky top-0 z-40 border-b border-emerald-100 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-black text-emerald-800">
                    <span class="grid size-9 place-items-center rounded-2xl bg-emerald-100 text-emerald-700">P</span>
                    PesanKustom.id
                </a>
                <nav class="hidden items-center gap-2 text-sm font-semibold text-slate-600 md:flex">
                    @if ($isSellerArea)
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.page-builder') }}">Halaman</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.products.index') }}">Produk</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.form-builder') }}">Form</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.payment') }}">QRIS</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.subscription') }}">Paket</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.orders.index') }}">Order</a>
                    @else
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ $demoSeller ? route('public.store', $demoSeller) : route('register') }}">Contoh Toko</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('orders.lookup') }}">Cek Status</a>
                        @auth
                            <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        @endauth
                    @endif
                </nav>
                <div class="flex shrink-0 items-center gap-2">
                    @auth
                        @if ($isSellerArea && $currentSeller)
                            <a href="{{ route('public.store', $currentSeller) }}" class="rounded-full bg-emerald-600 px-3 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 sm:px-4">
                                <span class="hidden sm:inline">Toko Publik</span>
                                <span class="sm:hidden">Toko</span>
                            </a>
                        @elseif (! $isSellerArea)
                            <a href="{{ route('seller.dashboard') }}" class="rounded-full bg-emerald-600 px-3 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 sm:px-4">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-bold text-slate-600 hover:bg-slate-100">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full px-3 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100">Masuk</a>
                        <a href="{{ route('register') }}" class="rounded-full bg-emerald-600 px-3 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 sm:px-4">
                            <span class="hidden sm:inline">Mulai Gratis</span>
                            <span class="sm:hidden">Mulai</span>
                        </a>
                    @endauth
                </div>
            </div>
            <div class="border-t border-slate-100 md:hidden">
                <nav class="mx-auto flex max-w-6xl gap-2 overflow-x-auto px-4 py-2 text-xs font-bold text-slate-600">
                    @if ($isSellerArea)
                        <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ route('seller.products.index') }}">Produk</a>
                        <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ route('seller.form-builder') }}">Form</a>
                        <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ route('seller.payment') }}">QRIS</a>
                        <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ route('seller.subscription') }}">Paket</a>
                        <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ route('seller.orders.index') }}">Order</a>
                    @else
                        <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ $demoSeller ? route('public.store', $demoSeller) : route('register') }}">Contoh Toko</a>
                        <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ route('orders.lookup') }}">Cek Status</a>
                        @auth
                            <a class="shrink-0 rounded-full bg-slate-100 px-3 py-2" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <main>
            @if (session('status'))
                <div class="mx-auto mt-4 max-w-6xl px-4">
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-auto mt-4 max-w-6xl px-4">
                    <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <strong class="font-bold">Ada input yang perlu dicek:</strong>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="mt-12 border-t border-slate-200 bg-white">
            <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-6 text-sm text-slate-500 md:flex-row md:items-center md:justify-between">
                <p><strong class="text-emerald-700">PesanKustom.id</strong> - custom order page builder untuk UMKM kreatif.</p>
                <div class="flex flex-wrap gap-3 font-semibold">
                    <a href="{{ route('register') }}" class="hover:text-emerald-700">Mulai Gratis</a>
                    @if ($demoSeller)
                        <a href="{{ route('public.store', $demoSeller) }}" class="hover:text-emerald-700">Contoh Toko</a>
                    @endif
                    <a href="{{ route('orders.lookup') }}" class="hover:text-emerald-700">Cek Status</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
