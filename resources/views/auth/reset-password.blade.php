<x-layouts.app title="Atur Ulang Password - PesanKustom.id">
    <section class="mx-auto max-w-md px-4 py-10">
        <div class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200">
            <h1 class="text-3xl font-black tracking-tight">Atur ulang password</h1>
            <p class="mt-2 text-slate-600">Buat password baru untuk akunmu.</p>

            <form method="POST" action="{{ route('password.update') }}" class="mt-7 space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label class="text-sm font-bold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $email) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Password baru</label>
                    <input type="password" name="password" required autofocus class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700">Ulangi password baru</label>
                    <input type="password" name="password_confirmation" required class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <button class="w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">Simpan password baru</button>
            </form>
        </div>
    </section>
</x-layouts.app>
