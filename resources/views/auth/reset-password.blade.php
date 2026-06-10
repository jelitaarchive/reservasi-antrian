<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRE.in - Password Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#E5E9EE] font-sans min-h-screen">

    <header class="flex justify-between items-center px-16 py-8">
        <div class="text-3xl font-bold tracking-tighter text-black">ANTRE.in</div>
        <nav class="flex items-center space-x-10 text-lg">
            <a href="#" class="font-medium text-gray-700 hover:text-black">Beranda</a>
            <a href="#" class="font-medium text-gray-700 hover:text-black">Reservasi</a>
            <a href="#" class="font-medium text-gray-700 hover:text-black">Atur Jadwal</a>
            <a href="{{ route('register') }}" class="bg-[#4E4E4E] text-white px-10 py-3 rounded-full font-bold hover:bg-black transition">Daftar</a>
        </nav>
    </header>

    <main class="flex items-center px-24 mt-10">
        <div class="bg-[#C2C9D1] w-[500px] rounded-[55px] p-14 shadow-lg">
            <h1 class="text-4xl font-black text-black mb-1">PASSWORD</h1>
            <p class="text-sm text-gray-600 mb-10 pl-1 font-bold uppercase tracking-widest">BARU</p>
            
            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[11px] text-gray-600 mb-2 pl-1 font-bold">PASSWORD BARU</label>
                    <input id="password" type="password" name="password" placeholder="Min. 8 Karakter" 
                           class="w-full bg-white border-none rounded-2xl px-6 py-4 text-lg focus:ring-2 focus:ring-gray-400" required />
                    @error('password')
                        <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-[11px] text-gray-600 mb-2 pl-1 font-bold">KONFIRMASI PASSWORD</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi Password" 
                           class="w-full bg-white border-none rounded-2xl px-6 py-4 text-lg focus:ring-2 focus:ring-gray-400" required />
                </div>

                <button type="submit" class="w-full bg-[#4E4E4E] text-white text-xl font-bold py-4 mt-4 rounded-3xl hover:bg-black transition shadow-md">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </main>
</body>
</html>