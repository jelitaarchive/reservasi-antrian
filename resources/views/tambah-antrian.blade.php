<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Antrian - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#F5F5F5] font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-white border-r border-gray-200 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-10 pl-2">
                    ANTRE.in
                </div>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span class="font-medium text-sm">Beranda</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span class="font-medium text-sm">Monitoring Antrian</span>
                    </a>
                    
                    <div class="relative flex items-center">
                        <div class="absolute left-[-24px] w-1.5 h-6 bg-black rounded-r-md"></div>
                        <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-black">add_box</span>
                            <span class="text-sm">Tambah Antrian</span>
                        </a>
                    </div>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span class="font-medium text-sm">Riwayat Antrian</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span class="font-medium text-sm">Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-8 md:p-12 flex justify-center items-start">
            <div class="w-full max-w-3xl">
                
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-8">
                    <div class="flex flex-col">
                        <h2 class="text-3xl font-bold text-gray-700 tracking-tight leading-none">Tambah</h2>
                        <h2 class="text-3xl font-bold text-gray-700 tracking-tight mt-1 leading-none">Antrian</h2>
                    </div>

                    <div class="flex-1 max-w-xs mx-0 md:mx-4">
                        <div class="relative">
                            <input type="text" placeholder="Cari" class="w-full pl-4 pr-10 py-2 bg-white border border-gray-300 rounded-full text-xs focus:outline-none focus:ring-1 focus:ring-gray-400 transition shadow-sm">
                            <span class="material-icons-outlined absolute right-3 top-2.5 text-gray-400 text-sm">search</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 self-end md:self-auto">
                        <div class="text-right">
                            <h4 class="font-bold text-gray-800 text-xs leading-tight">Halo, {{ Auth::user()->name }}</h4>
                            <p class="text-[10px] text-gray-400">STI202303000</p>
                        </div>
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 border border-gray-300">
                            <span class="material-icons-outlined text-xl">account_circle</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 mb-10 w-full">
                    <div class="w-full h-3 bg-blue-500 rounded-full border border-blue-600 shadow-sm"></div>
                    <div class="w-full h-3 bg-[#D9D9D9] rounded-full"></div>
                    <div class="w-full h-3 bg-[#D9D9D9] rounded-full"></div>
                    <div class="w-full h-3 bg-[#D9D9D9] rounded-full"></div>
                </div>

                <div class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-10">
                    <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Biodata</h3>
                    <p class="text-gray-400 text-xs mt-0.5 mb-8">Lengkapi biodata dibawah ini!</p>

                    <form action="#" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1.5 pl-3">Nama Lengkap</label>
                            <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1.5 pl-3">NIM</label>
                            <input type="text" name="nim" placeholder="NIM" class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1.5 pl-3">Email</label>
                            <input type="email" name="email" placeholder="contoh@gmail.com" class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-500 mb-1.5 pl-3">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" placeholder="08xxxxxxxxxx" class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full py-2.5 border border-gray-300 rounded-full text-xs font-bold text-gray-600 hover:bg-gray-50 transition flex items-center justify-center space-x-1.5">
                                <span>Lanjutkan</span>
                                <span class="material-icons-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

</body>
</html>