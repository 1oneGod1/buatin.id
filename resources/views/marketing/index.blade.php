<x-layouts.app
    title="PesanKustom.id — Toko custom dalam satu link"
    description="Buat halaman pesanan custom untuk kreator & UMKM: katalog, form brief, QRIS, dan status order dalam satu link. Gratis untuk mulai."
>
    {{-- HERO --}}
    <section class="mx-auto grid max-w-6xl gap-10 px-4 py-10 md:grid-cols-[1fr_420px] md:items-center md:py-14">
        <div>
            <div class="mb-5 flex flex-wrap gap-2 text-xs font-extrabold">
                <span class="rounded-full bg-brand-soft px-3 py-1.5 text-brand-deep">Katalog</span>
                <span class="rounded-full bg-sunny-soft px-3 py-1.5 text-sunny-ink">Form brief</span>
                <span class="rounded-full bg-sky-soft px-3 py-1.5 text-sky-ink">QRIS</span>
            </div>
            <h1 class="max-w-3xl text-4xl font-extrabold leading-[1.05] tracking-tight text-ink md:text-6xl">
                Buat halaman order custom dalam <span class="text-brand">10 menit</span>
            </h1>
            <p class="mt-5 max-w-2xl text-lg font-medium leading-8 text-muted">
                Untuk kreator dan UMKM yang menerima pesanan custom dari chat, katalog, dan form brief — dalam satu link.
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('register') }}" class="rounded-2xl bg-brand px-6 py-4 text-center font-extrabold text-white shadow-[0_16px_30px_-12px_rgba(7,168,107,0.75)] hover:bg-brand-deep">
                    Mulai Gratis →
                </a>
                @if ($seller)
                    <a href="{{ route('public.store', $seller) }}" class="rounded-2xl border-[1.5px] border-line bg-white px-6 py-4 text-center font-extrabold text-ink hover:border-brand">
                        Lihat Contoh Toko
                    </a>
                @endif
            </div>
            <div class="mt-10 flex max-w-xl items-stretch gap-3 text-center">
                @foreach ([['10rb+', 'Transaksi'], ['500+', 'UMKM kreatif'], ['4.9★', 'Rating puas']] as [$n, $l])
                    <div class="flex-1 rounded-2xl border border-line bg-white p-4 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                        <div class="text-2xl font-extrabold text-brand">{{ $n }}</div>
                        <div class="mt-1 text-xs font-bold text-faint">{{ $l }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-[28px] border border-line bg-white p-3 shadow-[0_34px_60px_-30px_rgba(22,33,28,0.45)]">
            <div class="rounded-[22px] bg-cream p-3">
                <div class="mb-3 flex items-center justify-between text-xs">
                    <span class="font-mono font-bold text-muted">pesankustom.id/disyanz3d</span>
                    <span class="rounded-full bg-ink px-2.5 py-1 text-[10px] font-extrabold text-white">● LIVE</span>
                </div>
                <div class="overflow-hidden rounded-[18px] bg-white shadow-sm">
                    <div class="relative h-40 overflow-hidden bg-gradient-to-br from-brand-deep via-brand to-[#2bd08a] p-5 text-white">
                        <span class="pointer-events-none absolute -right-4 -top-8 text-[120px] font-extrabold leading-none text-white/15">D</span>
                        <div class="relative mt-12 text-xl font-extrabold">Disyan 3D Studio</div>
                        <div class="relative text-xs text-white/85">Mini figure &amp; custom part</div>
                    </div>
                    <div class="space-y-3 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-extrabold text-ink">Custom Figurine</h3>
                                <p class="text-xs text-muted">Upload file, pilih material, kirim brief.</p>
                            </div>
                            <span class="shrink-0 rounded-lg bg-sunny-soft px-2.5 py-1 text-xs font-extrabold text-sunny-ink">Rp150rb+</span>
                        </div>
                        <div class="rounded-xl border border-dashed border-brand/40 p-4 text-center text-xs font-bold text-brand-deep" style="background-color:#eaf6f0">
                            ⤓ Upload File Desain (.stl)
                        </div>
                        <a href="{{ $seller ? route('public.order.create', $seller) : route('register') }}" class="block rounded-xl bg-brand-deep px-5 py-3 text-center text-sm font-extrabold text-white">Lanjut ke Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PROBLEM --}}
    <section class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-wide text-coral-ink">Problem yang diselesaikan</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-ink">Brief custom tidak perlu tercecer di chat.</h2>
                <p class="mt-4 text-base leading-7 text-muted">
                    PesanKustom.id mengubah chat berantakan jadi satu alur order yang rapi: katalog, form brief, upload referensi, estimasi awal, QRIS, dan status pesanan.
                </p>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ([
                    ['Chat bolak-balik', 'Pelanggan mengisi brief lengkap sejak awal.', 'bg-coral'],
                    ['Salah paham detail', 'Produk acuan & tipe pesanan dipisah jelas.', 'bg-sky'],
                    ['Pembayaran manual', 'QRIS & upload bukti ada di ringkasan.', 'bg-sunny'],
                    ['Status tidak jelas', 'Pembeli cek progres dari kode order.', 'bg-brand'],
                ] as [$title, $copy, $dot])
                    <div class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                        <span class="inline-block size-2.5 rounded-full {{ $dot }}"></span>
                        <p class="mt-3 font-extrabold text-ink">{{ $title }}</p>
                        <p class="mt-1 text-sm leading-6 text-muted">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="mx-auto max-w-6xl px-4 py-10">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Alur utama</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-ink">Dari link toko sampai order diproses.</h2>
            </div>
            <a href="{{ route('register') }}" class="shrink-0 rounded-2xl bg-brand px-5 py-3 text-sm font-extrabold text-white shadow-[0_12px_22px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Coba buat toko</a>
        </div>
        <div class="mt-7 grid gap-4 md:grid-cols-4">
            @foreach ([
                ['Buat toko', 'Isi profil brand, WhatsApp, deskripsi.', 'bg-brand-soft text-brand-deep'],
                ['Tambah produk', 'Produk acuan, tipe, harga awal, foto.', 'bg-sunny-soft text-sunny-ink'],
                ['Terima brief', 'Pelanggan isi form custom & referensi.', 'bg-lilac-soft text-lilac-ink'],
                ['Kelola order', 'Pantau pembayaran, WhatsApp, status.', 'bg-sky-soft text-sky-ink'],
            ] as [$title, $copy, $accent])
                <div class="rounded-[22px] border border-line bg-white p-5 shadow-[0_2px_6px_rgba(22,33,28,0.05)]">
                    <div class="grid size-10 place-items-center rounded-2xl text-base font-extrabold {{ $accent }}">{{ $loop->iteration }}</div>
                    <p class="mt-4 text-lg font-extrabold text-ink">{{ $title }}</p>
                    <p class="mt-1 text-sm leading-6 text-muted">{{ $copy }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- FREEMIUM --}}
    <section class="mx-auto max-w-6xl px-4 pb-14">
        <div class="grid gap-8 overflow-hidden rounded-[28px] bg-ink p-8 text-white lg:grid-cols-[1fr_1fr] lg:items-center md:p-10" style="background-image:radial-gradient(circle at 92% 0%,rgba(7,168,107,.3),transparent 45%)">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-wide text-[#2BD08A]">Freemium MVP</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight">Mulai gratis, upgrade saat order mulai ramai.</h2>
                <p class="mt-4 text-sm leading-7 text-white/70">
                    Model bisnis bertahap: coba fitur inti gratis, lalu pakai paket berbayar untuk branding, katalog lebih banyak, dan operasional order lebih lengkap.
                </p>
            </div>
            <div class="grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['Free', 'Rp0', 'Validasi usaha', false],
                    ['Starter', 'Rp29rb', 'Order aktif', false],
                    ['★ Pro', 'Rp79rb', 'Brand profesional', true],
                ] as [$name, $price, $tag, $pro])
                    <div class="rounded-2xl border p-5 {{ $pro ? 'border-transparent bg-brand' : 'border-white/10 bg-white/5' }}">
                        <p class="text-sm font-extrabold {{ $pro ? 'text-white' : 'text-[#2BD08A]' }}">{{ $name }}</p>
                        <p class="mt-3 text-3xl font-extrabold">{{ $price }}</p>
                        <p class="mt-2 text-sm {{ $pro ? 'text-white/85' : 'text-white/60' }}">{{ $tag }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
