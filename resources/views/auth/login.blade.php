<x-layouts.app title="Masuk - Buatin.id">
    <section class="mx-auto max-w-md px-4 py-10">
        <div class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200">
            <h1 class="text-3xl font-black tracking-tight">Masuk ke akun</h1>
            <p class="mt-2 text-slate-600">Kelola toko, produk, dan pesanan custom kamu.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-7 space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-bold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Password</label>
                    <input type="password" name="password" required class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 font-semibold text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"> Ingat saya
                    </label>
                    <a href="{{ route('password.request') }}" class="font-bold text-emerald-700 hover:underline">Lupa password?</a>
                </div>
                <button class="w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">Masuk</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-emerald-700 hover:underline">Daftar gratis</a>
            </p>
            <p class="mt-3 text-center text-sm">
                <a href="{{ route('demo') }}" class="font-semibold text-slate-500 hover:text-emerald-700">Atau jelajahi sebagai akun demo &rarr;</a>
            </p>
        </div>
    </section>
</x-layouts.app>
