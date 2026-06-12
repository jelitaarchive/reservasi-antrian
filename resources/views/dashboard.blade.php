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
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <a href="{{ route('pembayaran') }}" class="block bg-white border border-gray-200 rounded-[28px] p-6 shadow-sm flex items-start gap-5 hover:shadow-md hover:border-gray-300 transition group">
                            <div class="bg-white p-6 border rounded-3xl overflow-hidden shadow-sm">
                                <img src="{{ asset('images/pembayaran.png') }}" class="w-24 h-24 rounded-2xl">
                            </div>
                            <div class="flex flex-col justify-between h-full py-1">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition">Pembayaran</h3>
                                    <p class="text-xs text-gray-400 mt-1 max-w-sm">Layanan ini dikhususkan untuk memproses segala bentuk pembayaran akademik, termasuk pembayaran UKT, biaya SKS, atau biaya administrasi lainnya. Pastikan Anda menyiapkan bukti tagihan dan dokumen pendukung agar proses verifikasi di loket berjalan lebih cepat.</p>
                                </div>
                                <div class="mt-4">
                                    <span class="text-[11px] font-bold text-gray-400 group-hover:text-blue-600 transition underline underline-offset-4">Lihat Selengkapnya</span>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('administrasi') }}" class="block bg-white border border-gray-200 rounded-[28px] p-6 shadow-sm flex items-start gap-5 hover:shadow-md hover:border-gray-300 transition group">
                            <div class="bg-white p-6 border rounded-3xl overflow-hidden shadow-sm">
                                <img src="{{ asset('images/administrasi.png') }}" class="w-24 h-24 rounded-2xl">
                            </div>
                            <div class="flex flex-col justify-between h-full py-1">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 leading-tight group-hover:text-blue-600 transition">Administrasi</h3>
                                    <p class="text-xs text-gray-400 mt-1 max-w-sm">Layanan ini menangani kebutuhan administrasi kemahasiswaan, seperti pengurusan kartu mahasiswa, surat keterangan aktif kuliah, legalisir dokumen, serta konsultasi data akademik. Silakan pilih layanan ini untuk pengurusan dokumen resmi kampus.</p>
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
                        
                        <div class="bg-gray-200 border border-gray-300 rounded-[28px] p-8 text-center shadow-sm flex flex-col items-center justify-center min-h-[180px] relative overflow-hidden">
                            <div class="mb-3 text-gray-600">
                                <span class="material-icons-outlined text-4xl">calendar_today</span>
                            </div>

                            <div class="relative z-10">
                                <h3 id="realtime-day" class="text-3xl font-bold text-gray-800 tracking-tight">Menghitung...</h3>
                                <p id="realtime-date" class="text-sm font-semibold text-gray-500 tracking-wide mt-2">...</p>
                            </div>

                            <img src="{{ asset('images/kalender.png') }}" class="absolute -bottom-2 -right-2 w-24 opacity-20 pointer-events-none">
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

    <script>
        function updateCalendar() {
            const now = new Date();
            
            // Array nama hari dan bulan dalam bahasa Indonesia
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            
            const dayName = days[now.getDay()];
            const dateNum = now.getDate();
            const monthName = months[now.getMonth()];
            const yearNum = now.getFullYear();
            
            // Render ke elemen HTML
            document.getElementById('realtime-day').textContent = dayName;
            document.getElementById('realtime-date').textContent = `${dateNum} ${monthName} ${yearNum}`;
        }

        // Jalankan saat halaman di-load
        document.addEventListener('DOMContentLoaded', updateCalendar);
    </script>
</body>
</html>