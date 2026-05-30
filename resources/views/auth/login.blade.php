<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-[320px] bg-white rounded-[30px] p-8 shadow-lg relative overflow-hidden">

        <div class="absolute top-[-60px] left-[-60px] w-40 h-40 bg-gray-300 rounded-full blur-2xl opacity-50"></div>
        <div class="absolute bottom-[-60px] right-[-60px] w-40 h-40 bg-gray-300 rounded-full blur-2xl opacity-50"></div>

        <h1 class="text-2xl font-bold mb-10">ANTRE.in</h1>

        <div class="flex justify-end mb-8">
            <a href="{{ route('register') }}"
               class="bg-gray-600 text-white px-6 py-2 rounded-full">
                Daftar
            </a>
        </div>

        <div class="bg-gray-200 rounded-[30px] p-6">

            <h2 class="text-2xl font-bold mb-6">LOGIN</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="text-sm">NIM</label>

                    <input type="text"
                        name="nim"
                        class="w-full rounded-full border-gray-300"
                        required>
                </div>

                <div class="mb-6">

                <div class="flex justify-between items-center mb-1">

                    <label class="text-sm">Password</label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                        class="text-xs text-blue-500 hover:underline">
                            Lupa Password?
                        </a>
                    @endif

                </div>

                <input type="password"
                    name="password"
                    class="w-full rounded-full border-gray-300"
                    required>

                </div>

                <button type="submit"
                        class="w-full border rounded-full py-2 bg-white hover:bg-gray-100">
                    Masuk
                </button>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>