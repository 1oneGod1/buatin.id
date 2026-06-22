<x-layouts.app title="Masuk - PesanKustom.id">
    <section class="mx-auto max-w-md px-4 py-12">
        <div class="rounded-[26px] border border-line bg-white p-7 shadow-[0_18px_40px_-24px_rgba(22,33,28,0.4)]">
            <h1 class="text-3xl font-extrabold tracking-tight text-ink">Masuk ke akun</h1>
            <p class="mt-2 text-muted">Kelola toko, produk, dan pesanan custom kamu.</p>

            <div id="fb-message" class="hidden"></div>

            <form id="fb-login-form" class="mt-7 space-y-5">
                <div>
                    <label class="text-sm font-bold text-ink">Email</label>
                    <input type="email" name="email" required autofocus class="mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15">
                </div>
                <div>
                    <label class="text-sm font-bold text-ink">Password</label>
                    <input type="password" name="password" required class="mt-2 w-full rounded-xl border border-line bg-white px-4 py-3 text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15">
                </div>
                <div class="flex items-center justify-end text-sm">
                    <a href="{{ route('password.request') }}" class="font-extrabold text-brand-deep hover:underline">Lupa password?</a>
                </div>
                <button type="submit" class="w-full rounded-2xl bg-brand px-6 py-4 font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Masuk</button>
            </form>

            <p class="mt-6 text-center text-sm text-muted">Belum punya akun?
                <a href="{{ route('register') }}" class="font-extrabold text-brand-deep hover:underline">Daftar gratis</a>
            </p>
            <p class="mt-3 text-center text-sm">
                <a href="{{ route('demo') }}" class="font-bold text-faint hover:text-brand-deep">Atau jelajahi sebagai akun demo &rarr;</a>
            </p>
        </div>
    </section>

    @include('auth.partials.firebase')
</x-layouts.app>
