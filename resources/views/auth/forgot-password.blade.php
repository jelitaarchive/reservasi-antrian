<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRE.in - Lupa Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#E5E9EE] font-sans min-h-screen">

    <header class="flex justify-between items-center px-16 py-8">
        <div class="text-3xl font-bold tracking-tighter text-black">ANTRE.in</div>
        <nav class="flex items-center space-x-10">
            <a href="#" class="text-lg font-medium text-gray-700 hover:text-black">Beranda</a>
            <a href="#" class="text-lg font-medium text-gray-700 hover:text-black">Reservasi</a>
            <a href="#" class="text-lg font-medium text-gray-700 hover:text-black">Atur Jadwal</a>
            <a href="{{ route('register') }}" class="bg-[#4E4E4E] text-white px-10 py-3 rounded-full font-bold text-lg hover:bg-black transition">Daftar</a>
        </nav>
    </header>

    <main class="flex items-center px-24 mt-10">
        <div class="bg-[#C2C9D1] w-[500px] rounded-[55px] p-16 shadow-lg">
            <h1 class="text-5xl font-black text-black mb-2">LUPA</h1>
            <p class="text-sm text-gray-600 mb-10 pl-1">PASSWORD?</p>
            
            <form method="POST" action="{{ route('password.send_otp') }}" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-sm text-gray-600 mb-2 pl-1 italic font-bold">Nomor WhatsApp</label>
                    <input id="whatsapp_number" type="text" name="whatsapp_number" placeholder="08xxxxxxxxxx" 
                           class="w-full bg-white border-none rounded-2xl px-6 py-4 text-lg focus:ring-2 focus:ring-gray-400" required autofocus />
                    @error('whatsapp_number')
                        <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[#4E4E4E] text-white text-xl font-bold py-4 rounded-3xl hover:bg-black transition shadow-md">
                    Kirim Kode Via WhatsApp
                </button>
            </form>
        </div>
    </main>
</body>
</html>