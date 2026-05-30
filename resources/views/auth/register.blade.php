<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-[320px] bg-white rounded-[30px] p-8 shadow-lg relative overflow-hidden">

        <div class="absolute top-[-60px] left-[-60px] w-40 h-40 bg-gray-300 rounded-full blur-2xl opacity-50"></div>
        <div class="absolute bottom-[-60px] right-[-60px] w-40 h-40 bg-gray-300 rounded-full blur-2xl opacity-50"></div>

        <h1 class="text-2xl font-bold mb-10">ANTRE.in</h1>

        <div class="flex justify-end mb-8">
            <a href="{{ route('login') }}"
               class="bg-gray-600 text-white px-6 py-2 rounded-full">
                Masuk
            </a>
        </div>

        <div class="bg-gray-200 rounded-[30px] p-6">

            <h2 class="text-2xl font-bold mb-6">DAFTAR</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="text-sm">Nama</label>

                    <input type="text"
                           name="name"
                           class="w-full rounded-full border-gray-300"
                           required>
                </div>

                <div class="mb-3">
                    <label class="text-sm">NIM</label>

                    <input type="text"
                        name="nim"
                        class="w-full rounded-full border-gray-300"
                        required>
                </div>

                <div class="mb-3">
                    <label class="text-sm">Email</label>

                    <input type="email"
                           name="email"
                           class="w-full rounded-full border-gray-300"
                           required>
                </div>

                <div class="mb-3">
                    <label class="text-sm">Nomor Telepon</label>

                    <input type="text"
                        name="phone"
                        class="w-full rounded-full border-gray-300">
                </div>

                <div class="mb-3">
                    <label class="text-sm">Password</label>

                    <input type="password"
                           name="password"
                           class="w-full rounded-full border-gray-300"
                           required>
                </div>

                <div class="mb-6">
                    <label class="text-sm">Konfirmasi Password</label>

                    <input type="password"
                           name="password_confirmation"
                           class="w-full rounded-full border-gray-300"
                           required>
                </div>

                <button type="submit"
                        class="w-full border rounded-full py-2 bg-white hover:bg-gray-100">
                    Daftar
                </button>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>