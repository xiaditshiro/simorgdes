<section class="space-y-6">
    <header>
        <h2 class="text-xl font-semibold text-rose-500">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            Setelah akun Anda dihapus, semua data dan informasi yang terkait di dalamnya akan dihapus secara permanen. Pastikan Anda telah menyimpan data penting sebelum menghapus akun.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-xl mt-4 bg-rose-500/10 border border-rose-500/20 px-8 py-3 text-sm font-bold text-rose-500 hover:bg-rose-500 hover:text-white hover:shadow-[0_0_20px_rgba(244,63,94,0.3)] transition-all ease-out"
    >Hapus Akun Permanen</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-white">
                Apakah Anda yakin ingin menghapus akun ini?
            </h2>

            <p class="mt-2 text-sm text-slate-400">
                Langkah ini tidak dapat dibatalkan. Setelah akun dihapus, seluruh sumber daya dan data di dalamnya akan musnah. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapusnya secara permanen.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Kata Sandi</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition"
                    placeholder="Masukkan Kata Sandi..."
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-rose-400 text-sm" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-semibold text-slate-300 hover:text-white hover:bg-slate-700 transition">
                    Batal
                </button>

                <button type="submit" class="rounded-xl bg-gradient-to-r from-rose-500 to-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-[0_0_20px_rgba(244,63,94,0.3)] hover:scale-[1.02] transition">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
