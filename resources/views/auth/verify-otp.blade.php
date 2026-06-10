<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRE.in - Verifikasi OTP</title>
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
        <div class="bg-[#C2C9D1] w-[500px] rounded-[55px] p-16 shadow-lg">
            <h1 class="text-4xl font-black text-black mb-1">VERIFIKASI</h1>
            <p class="text-sm text-gray-600 mb-10 pl-1 font-bold uppercase tracking-widest">KODE OTP</p>
            
            <form method="POST" action="{{ route('password.verify_otp') }}" class="space-y-8 text-center">
                @csrf
                <div>
                    <p class="text-[11px] text-gray-500 mb-3 text-left pl-1">KODE DIKIRIM KE WHATSAPP</p>
                    <input type="text" name="otp" maxlength="6" placeholder="- - - - - -"
                           class="w-full bg-white border-none rounded-2xl py-5 text-center text-3xl font-black tracking-[0.5em] focus:ring-2 focus:ring-gray-400" required autofocus />
                    @error('otp')
                        <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[#4E4E4E] text-white text-xl font-bold py-4 rounded-3xl hover:bg-black transition shadow-md">
                    Verifikasi Kode
                </button>
            </form>
        </div>
    </main>
</body>
</html>