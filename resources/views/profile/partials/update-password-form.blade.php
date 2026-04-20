<section>
    <header>
        <h2 class="text-xl font-semibold text-white">
            Perbarui Kata Sandi
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block mb-2 text-sm font-medium text-slate-400">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <div>
            <label for="update_password_password" class="block mb-2 text-sm font-medium text-slate-400">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block mb-2 text-sm font-medium text-slate-400">Konfirmasi Kata Sandi</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-rose-400 text-sm" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-3 text-sm font-bold text-white shadow-[0_0_20px_rgba(59,130,246,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-all">Ubah Kata Sandi</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-lg"
                >Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
