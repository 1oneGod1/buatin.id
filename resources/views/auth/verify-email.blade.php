<x-layouts.app title="Verifikasi Email - PesanKustom.id">
    <section class="mx-auto max-w-md px-4 py-10">
        <div class="rounded-[2rem] bg-white p-7 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold text-emerald-700">Langkah terakhir</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight">Verifikasi email kamu</h1>
            <p class="mt-2 text-slate-600">Kami sudah mengirim link verifikasi ke <strong>{{ auth()->user()?->email }}</strong>. Buka link tersebut, lalu kembali ke sini dan klik <strong>Saya sudah verifikasi</strong>.</p>

            <div id="fb-message" class="hidden"></div>

            <div class="mt-7 flex flex-col gap-3">
                <button id="fb-verify-continue" type="button" class="w-full rounded-2xl bg-emerald-600 px-6 py-4 font-black text-white hover:bg-emerald-700">Saya sudah verifikasi &rarr; Lanjut</button>
                <button id="fb-verify-resend" type="button" class="w-full rounded-2xl border border-slate-200 px-6 py-3 font-bold text-slate-600 hover:bg-slate-50">Kirim ulang email verifikasi</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full rounded-2xl border border-slate-200 px-6 py-3 font-bold text-slate-500 hover:bg-slate-50">Keluar</button>
                </form>
            </div>
        </div>
    </section>

    @include('auth.partials.firebase')
</x-layouts.app>
