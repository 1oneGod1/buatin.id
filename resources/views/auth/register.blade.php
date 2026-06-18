<x-layouts.app title="Daftar Akun - PesanKustom.id">
    <section class="mx-auto max-w-md px-4 py-10">
        <div class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-emerald-700">Langkah 1 dari 2</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight">Buat akun penjual</h1>
            <p class="mt-2 text-slate-600">Akun ini menjaga toko kamu tetap milikmu sendiri dan bisa diakses dari perangkat mana pun.</p>

            <div id="fb-message" class="hidden"></div>

            <form id="fb-register-form" class="mt-7 space-y-5">
                <div>
                    <label class="text-sm font-bold text-slate-700">Nama lengkap</label>
                    <input name="name" required autofocus class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Email</label>
                    <input type="email" name="email" required class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Password</label>
                    <input type="password" name="password" required minlength="6" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                    <span class="mt-1 block text-xs font-semibold text-slate-500">Minimal 6 karakter.</span>
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Ulangi password</label>
                    <input type="password" name="password_confirmation" required class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">Daftar &amp; lanjut</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:underline">Masuk di sini</a>
            </p>
        </div>
    </section>

    @include('auth.partials.firebase')
</x-layouts.app>
