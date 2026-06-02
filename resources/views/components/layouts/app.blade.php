<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Buatin.id' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    @php
        $isSellerArea = request()->routeIs('seller.*');
        $demoSeller = \App\Models\Seller::query()->first();
        $currentSeller = request()->route('seller') instanceof \App\Models\Seller ? request()->route('seller') : $demoSeller;
    @endphp
    <div class="min-h-screen">
        <header class="sticky top-0 z-40 border-b border-emerald-100 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-black text-emerald-800">
                    <span class="grid size-9 place-items-center rounded-2xl bg-emerald-100 text-emerald-700">B</span>
                    Buatin.id
                </a>
                <nav class="hidden items-center gap-2 text-sm font-semibold text-slate-600 md:flex">
                    @if ($isSellerArea)
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.dashboard') }}">Dashboard</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.page-builder') }}">Halaman</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.products.index') }}">Produk</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.form-builder') }}">Form</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.payment') }}">QRIS</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.orders.index') }}">Order</a>
                    @else
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ $demoSeller ? route('public.store', $demoSeller) : route('seller.start') }}">Contoh Toko</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('orders.lookup') }}">Cek Status</a>
                        <a class="rounded-full px-3 py-2 hover:bg-slate-100" href="{{ route('seller.dashboard') }}">Untuk Penjual</a>
                    @endif
                </nav>
                <a href="{{ $isSellerArea && $currentSeller ? route('public.store', $currentSeller) : route('seller.start') }}" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                    {{ $isSellerArea ? 'Toko Publik' : 'Mulai Gratis' }}
                </a>
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
    </div>
</body>
</html>
