<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-[#F3F4F6] font-sans antialiased flex min-h-screen">

    <aside class="w-72 bg-white border-r border-gray-200 flex flex-col p-8">
        <div class="text-3xl font-black mb-12">
            ANTRE<span class="text-black">.in</span>
        </div>

        <nav class="flex-1 space-y-4">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-4 p-3 text-gray-500 hover:bg-gray-100 rounded-2xl transition">
                <i class="fa-solid fa-house text-xl"></i>
                <span class="text-lg font-medium">Beranda</span>
            </a>
            <a href="#" class="flex items-center space-x-4 p-3 text-gray-500 hover:bg-gray-100 rounded-2xl transition">
                <i class="fa-solid fa-desktop text-xl"></i>
                <span class="text-lg font-medium">Monitoring Antrian</span>
            </a>
            <a href="#" class="flex items-center space-x-4 p-3 text-gray-500 hover:bg-gray-100 rounded-2xl transition">
                <i class="fa-solid fa-square-plus text-xl"></i>
                <span class="text-lg font-medium">Tambah Antrian</span>
            </a>
            <a href="#" class="flex items-center space-x-4 p-3 text-gray-500 hover:bg-gray-100 rounded-2xl transition">
                <i class="fa-solid fa-table-list text-xl"></i>
                <span class="text-lg font-medium">Riwayat Antrian</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-4 p-3 bg-gray-200 text-black rounded-2xl transition">
                <i class="fa-solid fa-user text-xl"></i>
                <span class="text-lg font-bold">Akun Saya</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-12 relative overflow-y-auto">
        
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800">Profil</h1>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-black transition text-lg border border-gray-300 px-6 py-2 rounded-full">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <a href="{{ route('dashboard') }}" class="inline-block mb-8 text-2xl text-gray-600 hover:text-black transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="flex space-x-4 mb-10">
            <button class="bg-[#9CA3AF] text-white px-10 py-3 rounded-full text-lg font-medium">Edit Profil</button>
            <button class="bg-white border border-gray-300 text-gray-500 px-10 py-3 rounded-full text-lg font-medium hover:bg-gray-50 transition">Preferensi</button>
            <button class="bg-white border border-gray-300 text-gray-500 px-10 py-3 rounded-full text-lg font-medium hover:bg-gray-50 transition">Tentang</button>
        </div>

        <div class="bg-white rounded-[40px] p-12 shadow-sm max-w-5xl">
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div class="flex items-start space-x-12">
                    <div class="relative">
                        <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden border-4 border-gray-100 shadow-inner">
                            <i class="fa-solid fa-user text-6xl text-gray-400"></i>
                        </div>
                        <button type="button" class="absolute bottom-0 right-0 bg-gray-600 text-white w-10 h-10 rounded-full border-4 border-white flex items-center justify-center hover:bg-black transition">
                            <i class="fa-solid fa-camera text-sm"></i>
                        </button>
                    </div>

                    <div class="flex-1 space-y-6">
                        <div>
                            <label class="block text-gray-600 text-lg font-medium mb-1 pl-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-6 py-4 rounded-full border border-gray-300 bg-[#F9FAFB] focus:ring-2 focus:ring-gray-400 outline-none text-lg">
                        </div>

                        <div>
                            <label class="block text-gray-600 text-lg font-medium mb-1 pl-2">NIM</label>
                            <input type="text" name="nim" value="{{ old('nim', $user->nim) }}" class="w-full px-6 py-4 rounded-full border border-gray-300 bg-[#F9FAFB] focus:ring-2 focus:ring-gray-400 outline-none text-lg">
                        </div>

                        <div>
                            <label class="block text-gray-600 text-lg font-medium mb-1 pl-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-6 py-4 rounded-full border border-gray-300 bg-[#F9FAFB] focus:ring-2 focus:ring-gray-400 outline-none text-lg">
                        </div>

                        <div>
                            <label class="block text-gray-600 text-lg font-medium mb-1 pl-2">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="w-full px-6 py-4 rounded-full border border-gray-300 bg-[#F9FAFB] focus:ring-2 focus:ring-gray-400 outline-none text-lg">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-12">
                    <button type="submit" class="bg-[#D1D5DB] text-gray-800 text-xl font-bold px-20 py-4 rounded-full hover:bg-gray-400 transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>