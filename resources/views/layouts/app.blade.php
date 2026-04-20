<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Organisasi Desa' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Scrollbar - Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: #1e293b;
            border-radius: 9999px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background-color: #334155;
        }
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: #1e293b transparent;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#070b14] text-white min-h-screen">
    @php
        $role = auth()->user()->role?->name;
    @endphp

    <div class="min-h-screen flex bg-[#070b14]">

        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition class="fixed inset-0 bg-black/50 z-40 lg:hidden"
            @click="sidebarOpen = false"></div>

        {{-- Sidebar --}}
        <aside
            class="fixed lg:static inset-y-0 left-0 z-50 w-72 bg-[#0b1220] border-r border-slate-800 shadow-2xl transform transition-transform duration-300 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            {{-- Header sidebar --}}
            <div class="h-[88px] flex items-center justify-between px-6 border-b border-slate-800">
                <div>
                    <h1 class="text-lg font-bold tracking-wide text-white">SIMORGDES</h1>
                    <p class="text-xs text-slate-400 mt-1">Sistem Manajemen Organisasi Desa</p>
                </div>

                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white text-xl">
                    ✕
                </button>
            </div>

            {{-- Isi sidebar --}}
            <div class="p-4 overflow-y-auto h-[calc(100vh-88px)] sidebar-scroll">
                <div class="mb-6 rounded-2xl border border-cyan-500/20 bg-[#0f172a] p-4">
                    <p class="text-sm text-slate-400">Login sebagai</p>
                    <h2 class="text-base font-semibold text-white mt-1">{{ auth()->user()->name }}</h2>
                    <p class="text-xs text-cyan-400 mt-1">{{ ucfirst(str_replace('_', ' ', $role)) }}</p>
                </div>

                {{-- SUPER ADMIN --}}
                @if($role === 'super_admin')
                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Utama</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('superadmin.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Dashboard
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Data Master</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('villages.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('villages.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Data Desa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('organizations.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('organizations.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Data Organisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('members.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('members.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Data Anggota
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Data User
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Operasional</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('activities.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('activities.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kegiatan Organisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cash.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('cash.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kas Anggota
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('finance.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('finance.index') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Manajemen Keuangan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('proposals.inbox') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('proposals.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Proposal
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Sistem</h3>
                    <ul class="space-y-1 text-sm">
                        <li>
                            <a href="{{ route('admin.settings.advance') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.settings.advance') ? 'bg-gradient-to-r from-rose-500 to-red-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Advance
                            </a>
                        </li>
                    </ul>
                @endif

                {{-- ADMIN DESA --}}
                @if($role === 'admin_desa')
                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Utama</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('desa.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('desa.dashboard') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Dashboard
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Data Master</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('organizations.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('organizations.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Data Organisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('members.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('members.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Data Anggota
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Operasional</h3>
                    <ul class="space-y-1 text-sm">
                        <li>
                            <a href="{{ route('activities.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('activities.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kegiatan Organisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('proposals.inbox') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('proposals.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Proposal
                            </a>
                        </li>
                    </ul>
                @endif

                {{-- KETUA --}}
                @if($role === 'ketua')
                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Utama</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('ketua.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('ketua.dashboard') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('members.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('members.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Data Anggota
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('activities.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('activities.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kegiatan Organisasi
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Keuangan</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('cash.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('cash.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kas Anggota
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('finance.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('finance.index') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Manajemen Keuangan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('finance.categories') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('finance.categories') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kategori Keuangan
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Surat Menyurat</h3>
                    <ul class="space-y-1 text-sm">
                        <li>
                            <a href="{{ route('proposals.inbox') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('proposals.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Proposal
                            </a>
                        </li>
                    </ul>
                @endif

                {{-- SEKRETARIS --}}
                @if($role === 'sekretaris')
                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Utama</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('sekretaris.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('sekretaris.dashboard') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('members.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('members.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Data Anggota
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('activities.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('activities.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kegiatan Organisasi
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Surat Menyurat</h3>
                    <ul class="space-y-1 text-sm">
                        <li>
                            <a href="{{ route('proposals.inbox') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('proposals.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Proposal
                            </a>
                        </li>
                    </ul>
                @endif

                {{-- BENDAHARA --}}
                @if($role === 'bendahara')
                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Utama</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('bendahara.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('bendahara.dashboard') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Dashboard
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Keuangan</h3>
                    <ul class="space-y-1 text-sm">
                        <li>
                            <a href="{{ route('cash.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('cash.*') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kas Anggota
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('finance.index') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('finance.index') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Manajemen Keuangan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('finance.categories') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('finance.categories') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kategori Keuangan
                            </a>
                        </li>
                    </ul>
                @endif

                {{-- ANGGOTA --}}
                @if($role === 'anggota')
                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Utama</h3>
                    <ul class="space-y-1 text-sm mb-5">
                        <li>
                            <a href="{{ route('anggota.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('anggota.dashboard') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Dashboard
                            </a>
                        </li>
                    </ul>

                    <h3 class="text-[10px] uppercase tracking-[0.2em] text-slate-500 mb-2 px-2 font-semibold">Menu Saya</h3>
                    <ul class="space-y-1 text-sm">
                        <li>
                            <a href="{{ route('cash.my') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('cash.my') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Kas Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attendance.my-qr') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('attendance.my-qr') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                QR Absensi Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('attendance.self-scanner') }}"
                                class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('attendance.self-scanner') ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                Scan Absensi Mandiri
                            </a>
                        </li>
                    </ul>
@endif
            </div>
        </aside>

        {{-- Area kanan --}}
        <div class="flex-1 flex flex-col min-h-screen min-w-0">

            {{-- Navbar atas --}}
            <nav class="h-[88px] bg-[#0b1220] border-b border-slate-800 flex items-center">
                <div class="w-full flex items-center justify-between px-4 md:px-6">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = true"
                            class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 transition">
                            ☰
                        </button>


                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden md:flex flex-col text-right">
                            <span class="text-sm font-medium text-white">{{ auth()->user()->name }}</span>
                            <span class="text-xs text-slate-400">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                        </div>

                        <a href="{{ route('profile.edit') }}" title="Pengaturan Akun"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-800 text-slate-300 hover:text-white hover:bg-slate-700 transition relative group ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="ml-1">
                            @csrf
                            <button type="submit"
                                class="rounded-xl bg-gradient-to-r from-rose-500 to-red-600 px-4 py-2 text-sm font-medium text-white shadow-[0_0_20px_rgba(239,68,68,0.25)] hover:scale-[1.02] transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            {{-- Content --}}
            <main class="flex-1 p-4 md:p-6 lg:p-8 bg-[#070b14]">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('modals')
    @stack('scripts')
</body>

</html>