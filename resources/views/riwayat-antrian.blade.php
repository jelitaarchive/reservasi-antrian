<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Antrian - ANTRE.in</title>
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
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span class="font-medium text-sm">Beranda</span>
                    </a>
                    
                    <a href="{{ route('monitoring.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span class="font-medium text-sm">Monitoring Antrian</span>
                    </a>
                    
                    <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">add_box</span>
                        <span class="font-medium text-sm">Tambah Antrian</span>
                    </a>
                    
                    <div class="relative flex items-center">
                        <div class="absolute left-[-24px] w-1.5 h-6 bg-black rounded-r-md"></div>
                        <a href="{{ route('riwayat.antrian') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-black">history</span>
                            <span class="text-sm">Riwayat Antrian</span>
                        </a>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span class="font-medium text-sm">Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-8 md:p-12">
            <div class="w-full max-w-4xl mx-auto">
                
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-700 tracking-tight">Riwayat Antrian</h2>
                        <p class="text-xs text-gray-400 mt-1">Daftar seluruh antrean pelayanan Anda</p>
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

                <div class="space-y-4">
                    @forelse($histories as $history)
                        <div class="bg-white border border-gray-200 rounded-[24px] p-6 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:border-gray-300 transition-all">
                            <div class="flex items-start space-x-4">
                                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                                    <span class="material-icons-outlined text-2xl">assignment</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $history->layanan ?? 'Jenis Pelayanan' }}</h4>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1.5">
                                        <span class="material-icons-outlined text-xs">calendar_today</span>
                                        {{ $history->created_at ? $history->created_at->translatedFormat('d F Y') : '-' }}
                                        <span class="mx-1">•</span>
                                        <span class="material-icons-outlined text-xs">schedule</span>
                                        {{ $history->waktu_layanan ?? '-' }}
                                    </p>
                                    @if($history->kategori_layanan)
                                        <p class="text-[11px] text-gray-400 mt-2 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100 max-w-xl italic">
                                            "{{ $history->kategori_layanan }}"
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="text-right flex md:flex-col items-center md:items-end justify-between md:justify-center border-t md:border-t-0 pt-3 md:pt-0 border-gray-100">
                                <span class="text-xs font-bold text-gray-400 md:mb-1 block">Nomor Antrean</span>
                                <span class="text-2xl font-black text-blue-600 tracking-tight">{{ $history->nomor_antrian ?? 'A-00' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-gray-200 rounded-[32px] p-12 text-center shadow-sm">
                            <span class="material-icons-outlined text-gray-300 text-6xl mb-3">history_toggle_off</span>
                            <h4 class="font-bold text-gray-700 text-sm">Belum Ada Riwayat Antrian</h4>
                            <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">Anda belum pernah menambahkan atau memiliki riwayat pengajuan antrean pelayanan.</p>
                            <div class="mt-6">
                                <a href="{{ route('tambah.antrian') }}" class="inline-flex items-center space-x-1.5 py-2 px-5 bg-gray-950 text-white font-semibold text-xs rounded-full hover:bg-gray-800 transition shadow-sm">
                                    <span>Ambil Antrian Sekarang</span>
                                    <span class="material-icons-outlined text-xs">add</span>
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </main>
    </div>

</body>
</html>