<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - ANTRE.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#efefef]">

<div class="min-h-screen">

    <nav class="flex justify-between items-center px-20 py-8">

        <h1 class="text-5xl font-bold">
            ANTRE.in
        </h1>

        <div class="flex items-center gap-12">

            <a href="/" class="text-xl hover:text-blue-500">
                Beranda
            </a>

            <a href="#" class="text-xl hover:text-blue-500">
                Reservasi
            </a>

            <a href="#" class="text-xl hover:text-blue-500">
                Atur Jadwal
            </a>

            <a href="{{ route('login') }}"
               class="bg-gray-700 text-white px-10 py-4 rounded-full text-xl font-semibold">
                Masuk
            </a>

        </div>

    </nav>

    <div class="flex justify-between items-center px-20 mt-10">

        <div class="bg-gray-300 rounded-[40px] p-10 w-[500px] shadow-lg">

            <h2 class="text-5xl font-bold mb-6">
                DAFTAR
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form id="registerForm"
                  method="POST"
                  action="{{ route('register') }}">

                @csrf

                <div class="mb-4">
                    <label class="block text-lg mb-1">
                        Daftar Sebagai
                    </label>

                    <select
                        id="roleSelect"
                        name="role"
                        class="w-full rounded-full border border-gray-500 px-5 py-3 bg-white appearance-none"
                        required
                    >
                        <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label id="identityLabel" class="block text-lg mb-1">
                        NIM
                    </label>

                    <input
                        id="identityInput"
                        type="text"
                        name="nim"
                        value="{{ old('nim') }}"
                        class="w-full rounded-full border border-gray-500 px-5 py-3"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-lg mb-1">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-full border border-gray-500 px-5 py-3"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-lg mb-1">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full rounded-full border border-gray-500 px-5 py-3"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-lg mb-1">
                        Nomor WhatsApp
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        class="w-full rounded-full border border-gray-500 px-5 py-3"
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-lg mb-1">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-full border border-gray-500 px-5 py-3"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-lg mb-1">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full rounded-full border border-gray-500 px-5 py-3"
                        required
                    >
                </div>

                <div class="text-center mt-4">

                    Sudah memiliki akun?

                    <a href="{{ route('login') }}"
                       class="text-blue-600 hover:underline">
                        Masuk
                    </a>

                </div>

            </form>

        </div>

        <div class="flex-1 flex justify-center items-center">

            <button
                type="submit"
                form="registerForm"
                class="border border-gray-500 rounded-full px-36 py-5 text-2xl hover:bg-white transition">

                Daftar

            </button>

        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('roleSelect');
        const identityLabel = document.getElementById('identityLabel');
        const identityInput = document.getElementById('identityInput');

        function updateIdentityField() {
            if (roleSelect.value === 'admin') {
                identityLabel.textContent = 'NIK';
                identityInput.name = 'nim'; // Tetap gunakan 'nim' agar kamu tidak perlu mengubah backend RegisterController lama, atau ubah ke 'nik' jika di backend sudah dipisah.
                identityInput.placeholder = 'Masukkan NIK Anda';
            } else {
                identityLabel.textContent = 'NIM';
                identityInput.name = 'nim';
                identityInput.placeholder = 'Masukkan NIM Anda';
            }
        }

        // Jalankan saat pertama kali halaman dimuat (untuk handle old value jika reload/gagal validasi)
        updateIdentityField();

        // Jalankan setiap kali dropdown berubah
        roleSelect.addEventListener('change', updateIdentityField);
    });
</script>

</body>
</html>