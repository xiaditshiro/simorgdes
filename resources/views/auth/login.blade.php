<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#071633] flex items-center justify-center px-4">

    <div class="w-full max-w-6xl bg-white rounded-[36px] overflow-hidden shadow-2xl">
        <div class="grid grid-cols-1 md:grid-cols-2 min-h-[650px]">

            {{-- Kiri --}}
            <div
                class="hidden md:flex flex-col items-center justify-center bg-gradient-to-b from-cyan-400 to-cyan-500 rounded-r-[120px] px-10 text-white">
                <h2 class="text-5xl font-bold text-center leading-tight">Hello, Welcome</h2>
                <p class="mt-4 text-lg text-cyan-50">Don't have an Account</p>

                <a href="{{ route('register') }}"
                    class="mt-8 inline-block rounded-full border-2 border-white px-10 py-3 text-lg font-semibold text-white transition hover:bg-white hover:text-cyan-500">
                    Register
                </a>
            </div>

            {{-- Kanan --}}
            <div class="flex items-center justify-center px-8 py-12 md:px-14">
                <div class="w-full max-w-md">
                    <h1 class="mb-8 text-center text-5xl font-bold text-slate-800">Login</h1>

                    @if (session('status'))
                        <div class="mb-4 text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <div class="relative">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="username" placeholder="Username"
                                    class="w-full rounded-lg bg-gray-100 py-3 pl-4 pr-12 text-gray-800 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5Z" />
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="relative">
                                <input id="password" type="password" name="password" required
                                    autocomplete="current-password" placeholder="Password"
                                    class="w-full rounded-lg bg-gray-100 py-3 pl-4 pr-12 text-gray-800 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M17 8h-1V6a4 4 0 1 0-8 0v2H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2Zm-6 0V6a2 2 0 1 1 4 0v2Z" />
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <label for="remember_me" class="inline-flex items-center text-gray-600">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-cyan-500 shadow-sm focus:ring-cyan-500">
                                <span class="ms-2">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="font-medium text-gray-600 hover:text-cyan-500">
                                    Forgot Password
                                </a>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full rounded-full bg-gradient-to-r from-slate-900 to-cyan-400 py-3 text-lg font-semibold text-white shadow-md transition hover:opacity-90">
                            Login
                        </button>

                        <div class="pt-4 text-center">
                            <p class="text-sm text-gray-500">or login with social platforms</p>

                            <div class="mt-4 flex items-center justify-center gap-4">
                                <button type="button"
                                    class="flex h-12 w-12 items-center justify-center border border-gray-300 text-xl font-bold text-gray-700 hover:bg-gray-100">G</button>
                                <button type="button"
                                    class="flex h-12 w-12 items-center justify-center border border-gray-300 text-xl font-bold text-gray-700 hover:bg-gray-100">f</button>
                                <button type="button"
                                    class="flex h-12 w-12 items-center justify-center border border-gray-300 text-xl font-bold text-gray-700 hover:bg-gray-100">⌘</button>
                                <button type="button"
                                    class="flex h-12 w-12 items-center justify-center border border-gray-300 text-xl font-bold text-gray-700 hover:bg-gray-100">in</button>
                            </div>
                        </div>

                        <div class="pt-2 text-center md:hidden">
                            <p class="text-sm text-gray-600">Don't have an Account?</p>
                            <a href="{{ route('register') }}"
                                class="mt-2 inline-block rounded-full border border-cyan-500 px-6 py-2 font-semibold text-cyan-500 hover:bg-cyan-500 hover:text-white">
                                Register
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>