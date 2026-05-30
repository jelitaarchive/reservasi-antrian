<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ANTRE.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#efefef] min-h-screen overflow-hidden">

    <!-- Blur -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-gray-300 rounded-full blur-3xl opacity-60"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-gray-300 rounded-full blur-3xl opacity-60"></div>
    <div class="absolute bottom-0 right-0 w-72 h-72 bg-gray-300 rounded-full blur-3xl opacity-60"></div>

    <!-- Navbar -->
    <nav class="relative z-10 flex justify-between items-center px-16 py-8">

        <h1 class="text-4xl font-bold">
            ANTRE.in
        </h1>

        <div class="flex items-center gap-10">

            <a href="/" class="text-lg">
                Beranda
            </a>

            <a href="#" class="text-lg">
                Reservasi
            </a>

            <a href="#" class="text-lg">
                Atur Jadwal
            </a>

            <a href="{{ route('register') }}"
               class="bg-gray-600 text-white px-8 py-4 rounded-full text-xl font-semibold">

                Daftar

            </a>

        </div>

    </nav>

    <!-- Content -->
    <div class="relative z-10 flex justify-between items-center px-16 mt-8">

        <!-- Login Card -->
        <div class="bg-gray-300 w-[420px] rounded-[40px] p-10">

            <h2 class="text-5xl font-bold mb-12">
                LOGIN
            </h2>

            <form id="loginForm"
                  method="POST"
                  action="{{ route('login') }}">

                @csrf

                <div class="mb-5">
                    <label class="block mb-2">
                        NIM
                    </label>

                    <input
                        type="text"
                        name="nim"
                        class="w-full rounded-full border border-gray-500 px-5 py-3"
                        required
                    >
                </div>

                <div class="mb-8">

                    <div class="flex justify-between mb-2">

                        <label>
                            Password
                        </label>

                        <a href="{{ route('password.request') }}"
                           class="text-blue-600 text-sm">

                            Lupa Password?

                        </a>

                    </div>

                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-full border border-gray-500 px-5 py-3"
                        required
                    >

                </div>

                <div class="text-center">

                    Belum memiliki akun?

                    <a href="{{ route('register') }}"
                       class="text-blue-600">

                        Daftar

                    </a>

                </div>

            </form>

        </div>

        <!-- Tombol Login -->
        <div class="flex-1 flex justify-center items-center">

            <button
                type="submit"
                form="loginForm"
                class="border border-gray-500 rounded-full px-36 py-5 text-2xl">

                Masuk

            </button>

        </div>

    </div>

</body>
</html>