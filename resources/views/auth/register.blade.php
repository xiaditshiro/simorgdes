<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#071633] flex items-center justify-center px-4">

    <div class="w-full max-w-6xl bg-white rounded-[36px] overflow-hidden shadow-2xl">
        <div class="grid grid-cols-1 md:grid-cols-2 min-h-[650px]">

            {{-- Kiri --}}
            <div
                class="hidden md:flex flex-col items-center justify-center bg-gradient-to-b from-cyan-400 to-cyan-500 rounded-r-[120px] px-10 text-white">
                <h2 class="text-5xl font-bold text-center leading-tight">Welcome Back</h2>
                <p class="mt-4 text-lg text-cyan-50">Already have an Account</p>

                <a href="{{ route('login') }}"
                    class="mt-8 inline-block rounded-full border-2 border-white px-10 py-3 text-lg font-semibold text-white transition hover:bg-white hover:text-cyan-500">
                    Login
                </a>
            </div>

            {{-- Kanan --}}
            <div class="flex items-center justify-center px-8 py-12 md:px-14">
                <div class="w-full max-w-md">
                    <h1 class="mb-8 text-center text-5xl font-bold text-slate-800">Register</h1>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                autocomplete="name" placeholder="Full Name"
                                class="w-full rounded-lg bg-gray-100 py-3 px-4 text-gray-800 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            @error('name')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="username" placeholder="Email"
                                class="w-full rounded-lg bg-gray-100 py-3 px-4 text-gray-800 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            @error('email')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="Password"
                                class="w-full rounded-lg bg-gray-100 py-3 px-4 text-gray-800 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            @error('password')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password" placeholder="Confirm Password"
                                class="w-full rounded-lg bg-gray-100 py-3 px-4 text-gray-800 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full rounded-full bg-gradient-to-r from-slate-900 to-cyan-400 py-3 text-lg font-semibold text-white shadow-md transition hover:opacity-90">
                            Register
                        </button>

                        <div class="pt-2 text-center md:hidden">
                            <p class="text-sm text-gray-600">Already have an account?</p>
                            <a href="{{ route('login') }}"
                                class="mt-2 inline-block rounded-full border border-cyan-500 px-6 py-2 font-semibold text-cyan-500 hover:bg-cyan-500 hover:text-white">
                                Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>