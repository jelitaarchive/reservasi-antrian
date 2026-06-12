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

    <main class="flex items-center px-24 mt-5">
        <div class="bg-[#C2C9D1] w-[500px] rounded-[55px] p-16 shadow-lg">
            <h1 class="text-4xl font-black text-black mb-1">VERIFIKASI</h1>
            <p class="text-sm text-gray-600 mb-6 pl-1 font-bold uppercase tracking-widest">KODE OTP</p>
            
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl text-xs mb-6 font-semibold text-left">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify_otp') }}" class="space-y-6 text-center">
                @csrf
                
                <div>
                    <p class="text-[11px] text-gray-500 mb-2 text-left pl-1">KODE DIKIRIM KE WHATSAPP</p>
                    <input type="text" name="otp" maxlength="6" placeholder="- - - - - -" value="{{ old('otp') }}"
                           class="w-full bg-white border-none rounded-2xl py-4 text-center text-3xl font-black tracking-[0.5em] focus:ring-2 focus:ring-gray-400" required autofocus />
                    @error('otp')
                        <span class="text-red-600 text-xs mt-1.5 block text-left pl-1 font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <p class="text-[11px] text-gray-500 mb-2 text-left pl-1">PASSWORD BARU</p>
                    <input type="password" name="password" placeholder="Minimal 8 Karakter"
                           class="w-full bg-white border-none rounded-2xl py-3 px-5 text-left text-sm font-bold focus:ring-2 focus:ring-gray-400" required />
                    @error('password')
                        <span class="text-red-600 text-xs mt-1.5 block text-left pl-1 font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <p class="text-[11px] text-gray-500 mb-2 text-left pl-1">KONFIRMASI PASSWORD BARU</p>
                    <input type="password" name="password_confirmation" placeholder="Ulangi Password Baru"
                           class="w-full bg-white border-none rounded-2xl py-3 px-5 text-left text-sm font-bold focus:ring-2 focus:ring-gray-400" required />
                </div>

                <button type="submit" class="w-full bg-[#4E4E4E] text-white text-xl font-bold py-4 rounded-3xl hover:bg-black transition shadow-md mt-4">
                    Verifikasi Kode
                </button>
            </form>
        </div>
    </main>
</body>
</html>