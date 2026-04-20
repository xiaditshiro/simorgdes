@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Pengaturan Akun</h2>
                <p class="text-sm text-slate-400 mt-1.5">Perbarui profil, alamat email, dan kata sandi Anda.</p>
            </div>
            
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-800 border border-slate-700 px-5 py-2.5 text-sm font-semibold text-slate-300 hover:text-white hover:bg-slate-700 hover:border-slate-600 transition-all w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="space-y-6">
            
            {{-- Update Profile Information --}}
            <div class="bg-[#0b1220] border border-slate-700/60 rounded-3xl shadow-xl p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-[#0b1220] border border-slate-700/60 rounded-3xl shadow-xl p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-[#0b1220] border border-rose-900/30 rounded-3xl shadow-xl p-6 sm:p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-48 w-48 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>

    </div>

@endsection
