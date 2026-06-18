@php($firebaseWeb = config('firebase.web'))
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
    import {
        getAuth, setPersistence, browserLocalPersistence, onAuthStateChanged, reload,
        createUserWithEmailAndPassword, signInWithEmailAndPassword,
        sendEmailVerification, sendPasswordResetEmail, updateProfile,
    } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-auth.js";

    const app = initializeApp(@json($firebaseWeb));
    const auth = getAuth(app);
    auth.languageCode = "id";
    await setPersistence(auth, browserLocalPersistence);

    let resolveReady;
    const authReady = new Promise((r) => (resolveReady = r));
    onAuthStateChanged(auth, (user) => resolveReady(user));

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? "";
    const callbackUrl = @json(route('auth.firebase.callback'));
    const dashboardUrl = @json(route('seller.dashboard'));

    const box = document.getElementById("fb-message");
    function show(text, ok = false) {
        if (!box) return;
        box.textContent = text;
        box.className = "mt-4 rounded-2xl border px-4 py-3 text-sm font-semibold " +
            (ok ? "border-emerald-200 bg-emerald-50 text-emerald-800" : "border-red-200 bg-red-50 text-red-800");
        box.classList.remove("hidden");
    }
    function busy(btn, on, label) {
        if (!btn) return;
        btn.disabled = on;
        btn.dataset.label ??= btn.textContent;
        btn.textContent = on ? (label || "Memproses...") : btn.dataset.label;
    }
    function msgFor(code) {
        return ({
            "auth/email-already-in-use": "Email sudah terdaftar. Silakan masuk.",
            "auth/invalid-email": "Format email tidak valid.",
            "auth/weak-password": "Password minimal 6 karakter.",
            "auth/missing-password": "Password wajib diisi.",
            "auth/invalid-credential": "Email atau password salah.",
            "auth/wrong-password": "Email atau password salah.",
            "auth/user-not-found": "Email atau password salah.",
            "auth/user-disabled": "Akun ini dinonaktifkan.",
            "auth/too-many-requests": "Terlalu banyak percobaan. Coba lagi nanti.",
            "auth/network-request-failed": "Jaringan bermasalah. Coba lagi.",
            "auth/operation-not-allowed": "Metode email/password belum diaktifkan di Firebase.",
        })[code] || "Terjadi kesalahan. Coba lagi.";
    }

    async function exchange(idToken) {
        const res = await fetch(callbackUrl, {
            method: "POST",
            headers: { "Content-Type": "application/json", "Accept": "application/json", "X-CSRF-TOKEN": csrf },
            body: JSON.stringify({ id_token: idToken }),
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) throw new Error(data.message || "Gagal membuat sesi.");
        window.location.href = data.redirect || dashboardUrl;
    }

    // --- Register ---
    const registerForm = document.getElementById("fb-register-form");
    registerForm?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const btn = registerForm.querySelector("button[type=submit]");
        const f = registerForm.elements;
        if (f.password.value !== f.password_confirmation.value) return show("Konfirmasi password tidak sama.");
        busy(btn, true, "Membuat akun...");
        try {
            const cred = await createUserWithEmailAndPassword(auth, f.email.value, f.password.value);
            if (f.name.value) await updateProfile(cred.user, { displayName: f.name.value });
            await sendEmailVerification(cred.user);
            await exchange(await cred.user.getIdToken());
        } catch (err) {
            show(msgFor(err.code)); busy(btn, false);
        }
    });

    // --- Login ---
    const loginForm = document.getElementById("fb-login-form");
    loginForm?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const btn = loginForm.querySelector("button[type=submit]");
        const f = loginForm.elements;
        busy(btn, true, "Masuk...");
        try {
            const cred = await signInWithEmailAndPassword(auth, f.email.value, f.password.value);
            await exchange(await cred.user.getIdToken());
        } catch (err) {
            show(msgFor(err.code)); busy(btn, false);
        }
    });

    // --- Forgot password ---
    const forgotForm = document.getElementById("fb-forgot-form");
    forgotForm?.addEventListener("submit", async (e) => {
        e.preventDefault();
        const btn = forgotForm.querySelector("button[type=submit]");
        busy(btn, true, "Mengirim...");
        try {
            await sendPasswordResetEmail(auth, forgotForm.elements.email.value);
            show("Link reset password sudah dikirim. Cek email (termasuk folder spam).", true);
            busy(btn, false);
        } catch (err) {
            show(msgFor(err.code)); busy(btn, false);
        }
    });

    // --- Verify email notice ---
    const continueBtn = document.getElementById("fb-verify-continue");
    continueBtn?.addEventListener("click", async () => {
        busy(continueBtn, true, "Memeriksa...");
        const user = await authReady;
        if (!user) { show("Sesi habis. Silakan masuk lagi."); return busy(continueBtn, false); }
        try {
            await reload(user);
            if (!user.emailVerified) { show("Email belum terverifikasi. Buka link di email lalu coba lagi."); return busy(continueBtn, false); }
            await exchange(await user.getIdToken(true));
        } catch (err) {
            show(msgFor(err.code)); busy(continueBtn, false);
        }
    });
    const resendBtn = document.getElementById("fb-verify-resend");
    resendBtn?.addEventListener("click", async () => {
        busy(resendBtn, true, "Mengirim...");
        const user = await authReady;
        if (!user) { show("Sesi habis. Silakan masuk lagi."); return busy(resendBtn, false); }
        try {
            await sendEmailVerification(user);
            show("Email verifikasi dikirim ulang.", true);
        } catch (err) { show(msgFor(err.code)); }
        busy(resendBtn, false);
    });
</script>
