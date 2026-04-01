@extends('layouts.app')

@section('content')

    <div class="bg-[#0b1220] border border-slate-700 rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-white">Data User</h2>

            <a href="{{ route('users.create') }}"
                class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded">
                + Tambah User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">

                <thead class="bg-[#111827] text-slate-300">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Role</th>
                        <th class="px-4 py-3 text-left">Organisasi</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-slate-200">

                    @foreach($users as $index => $user)

                        <tr class="border-t border-slate-700 hover:bg-slate-800/40">

                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->role?->name }}</td>
                            <td class="px-4 py-3">{{ $user->organization?->name }}</td>

                            <td class="px-4 py-3 flex gap-2">

                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Hapus user?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>
        </div>

    </div>

@endsection