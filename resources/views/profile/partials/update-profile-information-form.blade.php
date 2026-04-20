<section>
    <header>
        <h2 class="text-xl font-semibold text-white">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-slate-400">
            Perbarui nama dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-slate-400">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-rose-400 text-sm" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-slate-400">Email Address</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if($user->organizationMember)
            <div class="pt-2">
                <h3 class="text-lg font-semibold text-white mb-4 border-t border-slate-700/50 pt-6">Data Keanggotaan Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nik" class="block mb-2 text-sm font-medium text-slate-400">NIK (Nomor Induk Kependudukan)</label>
                        <input id="nik" name="nik" type="text" class="block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" value="{{ old('nik', $user->organizationMember->nik) }}" />
                        <x-input-error class="mt-2 text-rose-400 text-sm" :messages="$errors->get('nik')" />
                    </div>
                    <div>
                        <label for="gender" class="block mb-2 text-sm font-medium text-slate-400">Jenis Kelamin</label>
                        <select id="gender" name="gender" class="block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender', $user->organizationMember->gender) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('gender', $user->organizationMember->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <x-input-error class="mt-2 text-rose-400 text-sm" :messages="$errors->get('gender')" />
                    </div>
                    <div>
                        <label for="birth_place" class="block mb-2 text-sm font-medium text-slate-400">Tempat Lahir</label>
                        <input id="birth_place" name="birth_place" type="text" class="block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" value="{{ old('birth_place', $user->organizationMember->birth_place) }}" />
                        <x-input-error class="mt-2 text-rose-400 text-sm" :messages="$errors->get('birth_place')" />
                    </div>
                    <div>
                        <label for="birth_date" class="block mb-2 text-sm font-medium text-slate-400">Tanggal Lahir</label>
                        <input id="birth_date" name="birth_date" type="date" class="block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" value="{{ old('birth_date', $user->organizationMember->birth_date?->format('Y-m-d')) }}" />
                        <x-input-error class="mt-2 text-rose-400 text-sm" :messages="$errors->get('birth_date')" />
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-slate-400">Nomor Telepon</label>
                        <input id="phone" name="phone" type="text" class="block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition" value="{{ old('phone', $user->organizationMember->phone) }}" />
                        <x-input-error class="mt-2 text-rose-400 text-sm" :messages="$errors->get('phone')" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block mb-2 text-sm font-medium text-slate-400">Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="3" class="block w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition">{{ old('address', $user->organizationMember->address) }}</textarea>
                        <x-input-error class="mt-2 text-rose-400 text-sm" :messages="$errors->get('address')" />
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4 pt-4">
            <button class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-3 text-sm font-bold text-white shadow-[0_0_20px_rgba(59,130,246,0.3)] hover:scale-[1.02] active:scale-[0.98] transition-all">Simpan Profil</button>

            @if (session('status') === 'profile-updated')
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
