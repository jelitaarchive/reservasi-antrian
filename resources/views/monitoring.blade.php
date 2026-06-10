<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Antrian - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#F5F5F5] font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-10 pl-2">ANTRE.in</div>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 p-3">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span class="text-sm">Beranda</span>
                    </a>
                    <div class="relative flex items-center bg-gray-300 rounded-xl">
                        <div class="absolute left-[-24px] w-1.5 h-6 bg-black rounded-r-md"></div>
                        <a href="{{ route('monitoring.antrian') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-black">analytics</span>
                            <span class="text-sm">Monitoring Antrian</span>
                        </a>
                    </div>
                    <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 p-3">
                        <span class="material-icons-outlined text-xl">add_box</span>
                        <span class="text-sm">Tambah Antrian</span>
                    </a>
                    <a href="{{ route('riwayat.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span class="text-sm">Riwayat Antrian</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span class="font-medium text-sm">Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-10 flex justify-center">
            <div class="w-full max-w-4xl">
                
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-700">Monitoring Antrian</h2>
                    </div>
                    <div class="flex-1 max-w-sm px-6">
                        <div class="relative">
                            <input type="text" placeholder="Cari" class="w-full pl-4 pr-10 py-2 bg-transparent border border-gray-400 rounded-full text-sm focus:outline-none focus:ring-1 focus:ring-gray-600">
                            <span class="material-icons-outlined absolute right-3 top-2 text-gray-400">search</span>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 hover:opacity-80 transition group">
                        <div class="text-right">
                            <h4 class="font-bold text-gray-800 text-xs leading-tight">{{ Auth::user()->name ?? 'Halo, Mahasiswa' }}</h4>
                            <p class="text-[10px] text-gray-400">{{ Auth::user()->nim ?? 'ST020230300' }}</p>
                        </div>
                        <div class="w-8 h-8 bg-gray-100 rounded-full border border-gray-300 flex items-center justify-center overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <span class="material-icons-outlined text-xl text-gray-400">account_circle</span>
                            @endif
                        </div>
                    </a>
                </div>

                <div class="bg-gray-800 rounded-[32px] p-8 text-white shadow-lg mb-6">
                    <div class="flex justify-between items-start mb-12">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Jenis Pelayanan</p>
                            <h3 class="text-lg font-bold">Pembayaran UKT</h3>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Waktu Pelayanan</p>
                            <p class="text-sm font-medium">08.00 - 12.00 WIB</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Nomor Antrian Anda</p>
                        <h1 class="text-7xl font-black tracking-tighter">A-09</h1>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-10">
                    <div class="bg-white border border-gray-200 rounded-[32px] p-8 text-center shadow-sm">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Sisa Antrian</p>
                        <h2 class="text-4xl font-bold text-gray-800">3</h2>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-[32px] p-8 text-center shadow-sm">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Nomor Antrian yang Sedang Dilayani</p>
                        <h2 class="text-4xl font-bold text-gray-800">A-05</h2>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-[32px] p-8 shadow-sm">
                    <h3 class="text-base font-bold text-gray-800 mb-6">Daftar Antrian</h3>
                    <div class="space-y-6">
                        @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center space-x-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="material-icons-outlined text-gray-400">account_circle</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm">User {{ $i + 1 }}</p>
                                <p class="text-[10px] text-gray-400">Jenis Pelayanan</p>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>