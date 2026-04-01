@extends('layouts.app')

@section('content')
    <div class="max-w-3xl bg-[#0b1220] border border-slate-700 rounded-xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6 text-white">Edit User</h2>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-500/20 text-red-400 border border-red-500/30 px-4 py-3">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium text-slate-300">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Password Baru</label>
                <input type="password" name="password"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                <p class="text-sm text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti password.</p>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Role</label>
                <select name="role_id" class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-slate-300">Organisasi</label>
                <select name="organization_id"
                    class="w-full border border-slate-700 bg-[#111827] text-white rounded px-3 py-2">
                    <option value="">-- Pilih Organisasi --</option>
                    @foreach($organizations as $organization)
                        <option value="{{ $organization->id }}" {{ old('organization_id', $user->organization_id) == $organization->id ? 'selected' : '' }}>
                            {{ $organization->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2 text-slate-300">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                    class="accent-cyan-500">
                <label>User Aktif</label>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit"
                    class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded">
                    Update
                </button>

                <a href="{{ route('users.index') }}" class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded">
                    Kembali
                </a>
            </div>

        </form>

    </div>
@endsection