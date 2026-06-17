<x-layouts.app title="Lupa Password - Buatin.id">
    <section class="mx-auto max-w-md px-4 py-10">
        <div class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200">
            <h1 class="text-3xl font-black tracking-tight">Lupa password</h1>
            <p class="mt-2 text-slate-600">Masukkan email akunmu. Kami akan mengirim link untuk mengatur ulang password.</p>

            <form method="POST" action="{{ route('password.email') }}" class="mt-7 space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-bold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
                </div>
                <button class="w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">Kirim link reset</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                <a href="{{ route('login') }}" class="font-bold text-emerald-700 hover:underline">Kembali ke halaman masuk</a>
            </p>
        </div>
    </section>
</x-layouts.app>
