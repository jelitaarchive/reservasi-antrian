<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 font-sans text-gray-800">
        
        <!-- SIDEBAR KIRI -->
        <aside class="w-64 bg-white border-r border-gray-200 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <!-- Logo / Nama Aplikasi -->
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-10">
                    ANTRE.in
                </div>
                
                <!-- Menu Navigasi -->
                <nav class="space-y-4">
                    <a href="#" class="flex items-center space-x-3 text-gray-900 font-semibold bg-gray-100 p-3 rounded-xl">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span>Beranda</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span>Monitoring Antrian</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">add_box</span>
                        <span>Tambah Antrian</span>
                    </a>
                    <a href="{{ route('antrean.riwayat') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span>Riwayat Antrian</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span>Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- KONTEN UTAMA (KOTAK PUTIH MELENGKUNG DI FIGMA) -->
        <main class="flex-1 p-6 md:p-10 flex justify-center items-start">
            <div class="w-full max-w-6xl bg-white rounded-3xl shadow-sm border border-gray-100 p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- KOLOM KIRI & TENGAH (Menu Utama & Info Layanan) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- KARTU MENU 1: PEMBAYARAN (Bisa diklik di seluruh kotak) -->
                    <a href="{{ route('pembayaran') }}" class="block border border-gray-200 rounded-2xl p-6 flex items-start space-x-6 hover:shadow-lg hover:border-gray-400 transition bg-white cursor-pointer group">
                        <div class="w-24 h-24 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-gray-100 transition">
                            <!-- Placeholder Gambar Ilustrasi -->
                            <span class="text-gray-300 text-sm group-hover:text-gray-400">[ Ilustrasi ]</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Pembayaran</h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc neque eros, maximus et maximus quis, malesuada eu velit.</p>
                            <span class="text-sm font-semibold text-gray-700 underline group-hover:text-black">Lihat Selengkapnya</span>
                        </div>
                    </a>

                    <!-- KARTU MENU 2: ADMINISTRASI (Bisa diklik di seluruh kotak) -->
                    <a href="{{ route('administrasi') }}" class="block border border-gray-200 rounded-2xl p-6 flex items-start space-x-6 hover:shadow-lg hover:border-gray-400 transition bg-white cursor-pointer group">
                        <div class="w-24 h-24 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-gray-100 transition">
                            <!-- Placeholder Gambar Ilustrasi -->
                            <span class="text-gray-300 text-sm group-hover:text-gray-400">[ Ilustrasi ]</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Administrasi</h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc neque eros, maximus et maximus quis, malesuada eu velit.</p>
                            <span class="text-sm font-semibold text-gray-700 underline group-hover:text-black">Lihat Selengkapnya</span>
                        </div>
                    </a>

                    <!-- KOTAK INFO LAYANAN -->
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Info Layanan</h3>
                        <div class="space-y-4 text-sm text-gray-700">
                            <div>
                                <h4 class="font-bold text-gray-900">Senin - Jumat</h4>
                                <div class="flex justify-between border-b border-gray-100 py-1">
                                    <span>Shift 1</span><span>08.00 - 12.00 WIB</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span>Shift 2</span><span>13.30 - 16.00 WIB</span>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Sabtu</h4>
                                <div class="flex justify-between border-b border-gray-100 py-1">
                                    <span>Shift 1</span><span>08.00 - 12.00 WIB</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span>Shift 2</span><span>13.30 - 15.00 WIB</span>
                                </div>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="font-bold text-gray-900">Minggu & Hari Libur Nasional</span>
                                <span class="text-red-500 font-semibold">Tutup</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN (Profil, Hari, & Daftar Antrean) -->
                <div class="space-y-6">
                    <!-- HEADER PROFIL (Mengambil nama user yang login otomatis) -->
                    <div class="flex items-center justify-between">
                        <div class="text-right">
                            <h4 class="font-bold text-gray-900">Halo, {{ Auth::user()->name }}</h4>
                            <p class="text-xs text-gray-400">STI202303000</p>
                        </div>
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600">
                            <span class="material-icons-outlined">account_circle</span>
                        </div>
                    </div>

                    <!-- KARTU HARI & TANGGAL -->
                    <div class="bg-gray-200 rounded-2xl p-6 relative overflow-hidden flex flex-col justify-between h-36 shadow-inner">
                        <div>
                            <span class="material-icons-outlined text-gray-600 text-xl">calendar_today</span>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">Senin</h2>
                            <p class="text-sm text-gray-600 font-medium">27 Apr 2026</p>
                        </div>
                        <!-- Placeholder mini-ilustrasi orang santai di figma -->
                        <div class="absolute bottom-0 right-2 opacity-20 text-xs">[ Ilustrasi ]</div>
                    </div>

                    <!-- DAFTAR ANTREAN -->
                    <div class="border border-gray-200 rounded-2xl p-6">
                        <h4 class="font-bold text-gray-900 mb-4 text-base">Daftar Antrian</h4>
                        <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                            <!-- Looping dummy daftar antrean sesuai figma -->
                            @for ($i = 0; $i < 5; $i++)
                            <div class="flex items-center space-x-3 py-1 border-b border-gray-50 last:border-none">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                                    <span class="material-icons-outlined text-lg">person</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">User</p>
                                    <p class="text-xs text-gray-400">Jenis Pelayanan</p>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="mt-4 text-center">
                            <a href="#" class="text-xs font-semibold text-gray-500 underline hover:text-black">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Google Material Icons untuk memunculkan ikon sidebar & list -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</x-app-layout>