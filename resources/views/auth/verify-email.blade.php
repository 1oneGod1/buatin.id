<x-layouts.app title="Verifikasi Email - PesanKustom.id">
    <section class="mx-auto max-w-md px-4 py-12">
        <div class="rounded-[26px] border border-line bg-white p-7 shadow-[0_18px_40px_-24px_rgba(22,33,28,0.4)]">
            <p class="text-xs font-extrabold uppercase tracking-wide text-brand">Langkah terakhir</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-ink">Verifikasi email kamu</h1>
            <p class="mt-2 text-muted">Kami sudah mengirim link verifikasi ke <strong class="text-ink">{{ auth()->user()?->email }}</strong>. Buka link tersebut, lalu kembali ke sini dan klik <strong>Saya sudah verifikasi</strong>.</p>

            <div id="fb-message" class="hidden"></div>

            <div class="mt-7 flex flex-col gap-3">
                <button id="fb-verify-continue" type="button" class="w-full rounded-2xl bg-brand px-6 py-4 font-extrabold text-white shadow-[0_14px_26px_-10px_rgba(7,168,107,0.7)] hover:bg-brand-deep">Saya sudah verifikasi &rarr; Lanjut</button>
                <button id="fb-verify-resend" type="button" class="w-full rounded-2xl border-[1.5px] border-line px-6 py-3 font-bold text-muted hover:border-brand hover:text-brand-deep">Kirim ulang email verifikasi</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full rounded-2xl border-[1.5px] border-line px-6 py-3 font-bold text-faint hover:bg-cream">Keluar</button>
                </form>
            </div>
        </div>
    </section>

    @include('auth.partials.firebase')
</x-layouts.app>
