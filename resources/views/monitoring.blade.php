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
                            <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Kategori Pelayanan</p>
                            <h3 class="text-lg font-bold">
                                {{ $antrianUser ? $antrianUser->kategori_layanan : 'Belum Ada Antrian' }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Waktu Pelayanan</p>
                            <p class="text-sm font-medium">
                                {{ $antrianUser ? $antrianUser->waktu_layanan : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Nomor Antrian Anda</p>
                        <h1 class="text-7xl font-black tracking-tighter">
                            {{ $antrianUser ? $antrianUser->nomor_antrian : '-' }}
                        </h1>
                        @if($antrianUser)
                            <div class="mt-4">
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                    Status: {{ $antrianUser->status }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-10">
                    <div class="bg-white border border-gray-200 rounded-[32px] p-8 text-center shadow-sm">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Sisa Antrian</p>
                        <h2 class="text-4xl font-bold text-gray-800">
                            {{ $antrianUser ? $sisaAntrian : '0' }} <span class="text-xs font-normal text-gray-400">orang</span>
                        </h2>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-[32px] p-8 text-center shadow-sm">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Nomor Antrian yang Sedang Dilayani</p>
                        <h2 class="text-4xl font-bold text-blue-600">
                            {{ $nomorDilayaniText }}
                        </h2>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-[32px] p-8 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-base font-bold text-gray-800">Daftar Antrian Hari Ini</h3>
                        <span class="px-2.5 py-0.5 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full">
                            {{ $daftarAntrian->count() }} Aktif
                        </span>
                    </div>

                    <div class="space-y-6 max-h-80 overflow-y-auto pr-1">
                        @forelse($daftarAntrian as $item)
                            <div class="flex items-center space-x-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0 p-2 rounded-2xl transition {{ $antrianUser && $item->id === $antrianUser->id ? 'bg-blue-50/50 border border-blue-200' : '' }}">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <span class="material-icons-outlined text-gray-400">account_circle</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-sm text-gray-800">
                                        {{-- Samarkan nama jika itu milik mahasiswa lain --}}
                                        {{ $antrianUser && $item->id === $antrianUser->id ? $item->nama : 'Mahasiswa (' . substr($item->nim, -4) . ')' }}
                                        <span class="text-gray-900 font-black pl-1">[{{ $item->nomor_antrian }}]</span>
                                    </p>
                                    <p class="text-[10px] text-gray-400">{{ $item->jenis_layanan }} • {{ $item->kategori_layanan }}</p>
                                </div>
                                <div>
                                    @if($item->status === 'melayani')
                                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200 font-semibold uppercase animate-pulse">
                                            Sedang Dilayani
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-50 text-blue-600 border border-blue-100 font-semibold uppercase">
                                            Menunggu
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div>
                                <p class="text-sm text-gray-400 text-center py-4">Belum ada daftar antrian lain hari ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>