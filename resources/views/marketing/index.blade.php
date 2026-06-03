<x-layouts.app title="Buatin.id - Custom Order Manager">
    <section class="mx-auto grid max-w-6xl gap-10 px-4 py-10 md:grid-cols-[1fr_420px] md:items-center md:py-16">
        <div>
            <div class="mb-5 flex flex-wrap gap-2">
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">Katalog</span>
                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">Form brief</span>
                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">QRIS</span>
            </div>
            <h1 class="max-w-3xl text-4xl font-black leading-tight tracking-tight text-slate-950 md:text-6xl">
                Buat halaman order custom dalam <span class="text-emerald-700">10 menit</span>
            </h1>
            <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
                Untuk kreator dan UMKM yang menerima pesanan custom dari chat, katalog, dan form brief dalam satu link.
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('seller.start', ['new' => 1]) }}" class="rounded-2xl bg-emerald-600 px-6 py-4 text-center font-bold text-white shadow-lg shadow-emerald-900/10 hover:bg-emerald-700">
                    Mulai Gratis
                </a>
                @if ($seller)
                    <a href="{{ route('public.store', $seller) }}" class="rounded-2xl border border-slate-200 bg-white px-6 py-4 text-center font-bold text-slate-800 hover:border-emerald-300">
                        Lihat Contoh Toko
                    </a>
                @endif
            </div>
            <div class="mt-10 grid max-w-xl grid-cols-3 gap-4 text-center">
                <div class="rounded-3xl bg-white p-4 shadow-sm">
                    <div class="text-2xl font-black text-emerald-700">10rb+</div>
                    <div class="text-xs font-semibold text-slate-500">Transaksi berhasil</div>
                </div>
                <div class="rounded-3xl bg-white p-4 shadow-sm">
                    <div class="text-2xl font-black text-emerald-700">500+</div>
                    <div class="text-xs font-semibold text-slate-500">UMKM kreatif</div>
                </div>
                <div class="rounded-3xl bg-white p-4 shadow-sm">
                    <div class="text-2xl font-black text-emerald-700">4.9/5</div>
                    <div class="text-xs font-semibold text-slate-500">Rating puas</div>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] border border-emerald-100 bg-white p-4 shadow-2xl shadow-emerald-900/10">
            <div class="rounded-[1.5rem] bg-slate-50 p-4">
                <div class="mb-4 flex items-center justify-between text-sm">
                    <span class="font-bold text-slate-700">buatin.id/disyanz3d</span>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">LIVE</span>
                </div>
                <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
                    <div class="h-48 bg-gradient-to-br from-emerald-950 via-slate-900 to-emerald-500 p-5 text-white">
                        <div class="grid size-14 place-items-center rounded-2xl bg-white/15 text-xl font-black">D</div>
                        <h2 class="mt-8 text-2xl font-black">Omah 3D Print</h2>
                        <p class="text-sm text-emerald-50">Mini figure & custom part</p>
                    </div>
                    <div class="space-y-4 p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-black">Custom Figurine - Level 1</h3>
                                <p class="text-sm text-slate-500">Upload file, pilih material, dan kirim brief.</p>
                            </div>
                            <div class="text-right font-black text-emerald-700">Rp 150rb+</div>
                        </div>
                        <div class="rounded-2xl border border-dashed border-emerald-300 bg-emerald-50/50 p-6 text-center text-sm font-semibold text-emerald-700">
                            Upload File Desain (.stl)
                        </div>
                        <a href="{{ $seller ? route('public.order.create', $seller) : route('seller.start') }}" class="block rounded-2xl bg-emerald-700 px-5 py-4 text-center font-black text-white">
                            Lanjut ke Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.16em] text-emerald-700">Problem yang diselesaikan</p>
                <h2 class="mt-3 text-3xl font-black text-slate-950">Brief custom tidak perlu tercecer di chat.</h2>
                <p class="mt-4 text-base leading-7 text-slate-600">
                    Buatin.id membantu penjual mengubah chat yang berantakan menjadi satu alur order yang rapi: katalog, form brief, upload referensi, estimasi awal, QRIS, dan status pesanan.
                </p>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ([
                    ['Chat bolak-balik', 'Pelanggan mengisi brief lengkap sejak awal.'],
                    ['Salah paham detail', 'Produk acuan dan tipe pesanan dipisahkan dengan jelas.'],
                    ['Pembayaran manual', 'QRIS dan upload bukti ada di ringkasan pesanan.'],
                    ['Status tidak jelas', 'Pembeli bisa cek progres dari kode order.'],
                ] as [$title, $copy])
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="font-black text-slate-950">{{ $title }}</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-12">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.16em] text-emerald-700">Alur utama</p>
                <h2 class="mt-3 text-3xl font-black text-slate-950">Dari link toko sampai order diproses.</h2>
            </div>
            <a href="{{ route('seller.start', ['new' => 1]) }}" class="rounded-full bg-emerald-600 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">Coba buat toko</a>
        </div>
        <div class="mt-7 grid gap-4 md:grid-cols-4">
            @foreach ([
                ['1', 'Buat toko', 'Isi profil brand, WhatsApp, dan deskripsi usaha.'],
                ['2', 'Tambah produk', 'Masukkan produk acuan, tipe, harga awal, dan foto.'],
                ['3', 'Terima brief', 'Pelanggan mengisi form custom dan upload referensi.'],
                ['4', 'Kelola order', 'Pantau pembayaran, WhatsApp, dan status produksi.'],
            ] as [$num, $title, $copy])
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="grid size-10 place-items-center rounded-2xl bg-emerald-100 font-black text-emerald-700">{{ $num }}</div>
                    <p class="mt-5 text-lg font-black text-slate-950">{{ $title }}</p>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-slate-950 text-white">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 lg:grid-cols-[1fr_1fr]">
            <div>
                <p class="text-sm font-black uppercase tracking-[0.16em] text-emerald-300">Freemium MVP</p>
                <h2 class="mt-3 text-3xl font-black">Mulai gratis, upgrade saat order mulai ramai.</h2>
                <p class="mt-4 text-sm leading-7 text-slate-300">
                    Model bisnis Buatin.id dibuat bertahap. Pelaku usaha bisa mencoba fitur inti gratis, lalu memakai paket berbayar untuk branding, katalog lebih banyak, dan operasional order yang lebih lengkap.
                </p>
            </div>
            <div class="grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['Free', 'Rp0', 'Validasi usaha'],
                    ['Starter', 'Rp29rb', 'Order aktif'],
                    ['Pro', 'Rp79rb', 'Brand profesional'],
                ] as [$name, $price, $tag])
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-sm font-black text-emerald-300">{{ $name }}</p>
                        <p class="mt-3 text-3xl font-black">{{ $price }}</p>
                        <p class="mt-2 text-sm text-slate-300">{{ $tag }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
