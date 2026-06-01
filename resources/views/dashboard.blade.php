<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#F5F5F5] font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-10 pl-2">
                    ANTRE.in
                </div>
                <nav class="space-y-2">
                    <div class="relative flex items-center">
                        <div class="absolute left-[-24px] w-1.5 h-6 bg-black rounded-r-md"></div>
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-black">home</span>
                            <span class="text-sm">Beranda</span>
                        </a>
                    </div>
                    
                    <a href="{{ route('monitoring.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span class="font-medium text-sm">Monitoring Antrian</span>
                    </a>
                    
                    <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">add_box</span>
                        <span class="font-medium text-sm">Tambah Antrian</span>
                    </a>
                    
                    <a href="{{ route('riwayat.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span class="font-medium text-sm">Riwayat Antrian</span>
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span class="font-medium text-sm">Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-10 flex justify-center">
            <div class="w-full max-w-5xl">
                
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-700 tracking-tight">Beranda</h2>
                    </div>

                    <div class="flex-1 max-w-xs mx-0 md:mx-4">
                        <div class="relative">
                            <input type="text" placeholder="Cari" class="w-full pl-4 pr-10 py-2 bg-white border border-gray-300 rounded-full text-xs focus:outline-none focus:ring-1 focus:ring-gray-400 transition shadow-sm">
                            <span class="material-icons-outlined absolute right-3 top-2.5 text-gray-400 text-sm">search</span>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 hover:opacity-80 transition group">
                        <div class="text-right">
                            <h4 class="font-bold text-gray-800 text-xs leading-tight">{{ Auth::user()->name ?? 'Halo, Mahasiswa' }}</h4>
                            <p class="text-[10px] text-gray-400">{{ Auth::user()->nim ?? 'ST020230300' }}</p>
                        </div>
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 border border-gray-300 group-hover:bg-gray-300 transition">
                            <span class="material-icons-outlined text-xl">account_circle</span>
                        </div>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <a href="{{ route('pembayaran') }}" class="block bg-white border border-gray-200 rounded-[28px] p-6 shadow-sm flex items-start gap-5 hover:shadow-md hover:border-gray-300 transition group">
                            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center flex-shrink-0 border border-gray-200 group-hover:bg-blue-50 transition">
                                <span class="material-icons-outlined text-4xl text-gray-400 group-hover:text-blue-600 transition">payments</span>
                            </div>
                            <div class="flex flex-col justify-between h-full py-1">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition">Pembayaran</h3>
                                    <p class="text-xs text-gray-400 mt-1 max-w-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                                <div class="mt-4">
                                    <span class="text-[11px] font-bold text-gray-400 group-hover:text-blue-600 transition underline underline-offset-4">Lihat Selengkapnya</span>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('administrasi') }}" class="block bg-white border border-gray-200 rounded-[28px] p-6 shadow-sm flex items-start gap-5 hover:shadow-md hover:border-gray-300 transition group">
                            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center flex-shrink-0 border border-gray-200 group-hover:bg-blue-50 transition">
                                <span class="material-icons-outlined text-4xl text-gray-400 group-hover:text-blue-600 transition">gavel</span>
                            </div>
                            <div class="flex flex-col justify-between h-full py-1">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition">Administrasi</h3>
                                    <p class="text-xs text-gray-400 mt-1 max-w-sm">Natoque penatibus et magnis dis parturient montes nascetur. Quis maximus vel velit.</p>
                                </div>
                                <div class="mt-4">
                                    <span class="text-[11px] font-bold text-gray-400 group-hover:text-blue-600 transition underline underline-offset-4">Lihat Selengkapnya</span>
                                </div>
                            </div>
                        </a>

                        <div class="bg-white border border-gray-200 rounded-[28px] p-6 shadow-sm">
                            <h3 class="text-base font-bold text-gray-800 mb-4 tracking-tight">Info Layanan</h3>
                            <div class="space-y-4 text-xs">
                                <div class="border-b border-gray-100 pb-3">
                                    <h4 class="font-bold text-gray-700 mb-1">Senin - Jumat</h4>
                                    <div class="flex justify-between text-gray-400">
                                        <span>Shift 1</span>
                                        <span class="font-semibold text-gray-600">08.00 - 12.00 WIB</span>
                                    </div>
                                    <div class="flex justify-between text-gray-400 mt-1">
                                        <span>Shift 2</span>
                                        <span class="font-semibold text-gray-600">13.30 - 16.00 WIB</span>
                                    </div>
                                </div>
                                <div class="border-b border-gray-100 pb-3">
                                    <h4 class="font-bold text-gray-700 mb-1">Sabtu</h4>
                                    <div class="flex justify-between text-gray-400">
                                        <span>Shift 1</span>
                                        <span class="font-semibold text-gray-600">08.00 - 12.00 WIB</span>
                                    </div>
                                    <div class="flex justify-between text-gray-400 mt-1">
                                        <span>Shift 2</span>
                                        <span class="font-semibold text-gray-600">13.30 - 15.00 WIB</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-700 mb-1">Minggu & Hari Libur Nasional</h4>
                                    <div class="flex justify-between text-gray-400">
                                        <span>Tutup</span>
                                        <span class="font-semibold text-gray-600">Tutup</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-gray-200 border border-gray-300 rounded-[28px] p-6 text-center shadow-sm flex flex-col items-center justify-center min-h-[140px]">
                            <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Senin</h3>
                            <p class="text-xs font-semibold text-gray-500 tracking-wide mt-1">27 Apr 2026</p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-[28px] p-6 shadow-sm">
                            <h3 class="text-sm font-bold text-gray-800 mb-4 tracking-tight">Daftar Antrian</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                                            <span class="material-icons-outlined text-sm">account_circle</span>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-700 leading-tight">User</p>
                                            <p class="text-[9px] text-gray-400">Jenis Pelayanan</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                                            <span class="material-icons-outlined text-sm">account_circle</span>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-700 leading-tight">User</p>
                                            <p class="text-[9px] text-gray-400">Jenis Pelayanan</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                                            <span class="material-icons-outlined text-sm">account_circle</span>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-700 leading-tight">User</p>
                                            <p class="text-[9px] text-gray-400">Jenis Pelayanan</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                                            <span class="material-icons-outlined text-sm">account_circle</span>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-700 leading-tight">User</p>
                                            <p class="text-[9px] text-gray-400">Jenis Pelayanan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 pt-2">
                                <a href="{{ route('monitoring.antrian') }}" class="w-full py-2 border border-gray-200 hover:bg-gray-50 text-gray-500 hover:text-gray-800 font-bold text-[10px] rounded-full transition flex items-center justify-center shadow-sm">
                                    Lihat Selengkapnya
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </main>
    </div>

</body>
</html>